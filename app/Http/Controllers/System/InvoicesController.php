<?php

namespace App\Http\Controllers\System;

use App\Models\GetDebt;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\GetDebtsRequest;
use App\Http\Requests\System\InvoicesRequest;
use App\Http\Requests\System\CustomersRequest;
use App\Http\Resources\System\GetDebtsResource;
use App\Http\Resources\System\InvoicesResource;
use App\Http\Resources\System\ProductsResource;
use App\Http\Resources\System\CustomersResource;
use App\Http\Resources\System\CategoriesResource;

class InvoicesController extends Controller
{

    public function BeforeCreate()
    {
        $products = Product::where('type_delete',1)
        ->where('ShowSelect',1)
        ->get();
        return inertia('System/Invoices/BeforeCreate' , ['products' => $products]);
    }

    public function BeforeStore()
    {
        $currency = Currency::find(1);
        $maxS_id = GetDebt::max('s_id');
        $nextS_id = $maxS_id + 1;
       $getDebt = GetDebt::create([
            'customer_id' => null,
            'user_id' => auth()->id(),
            'old_debt' => 0,
            'amount_of_debt' => 0,
            'discount' => 0,
            'new_debt' => 0,
            'name_of_recipient' => null,
            'name_of_office' => null,
            'notice_of_debt' => null,
            'type_amount' => 0,
            'delivery' => 0,
            'curr' => $currency ? $currency->iqd : null,
            'type_notice' => 0,
            'type_price' => 1,
            'amount_dollar' => 0,
            'amount_dinar' => 0,
            'type_invoice' => 1,
            'type_delete' => 1,
            's_id' =>$nextS_id,
        ]);
        return to_route('getdebts.invoices.index' , $getDebt->id);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request ,$id)
    {
        $getDebt = GetDebt::with('customer')->where('type_delete',1)->where('type_invoice', 1)->findOrFail($id);

        $getDebtIds = GetDebt::where('customer_id', $getDebt->customer_id)
        ->where('type_invoice', 1)
        ->whereNotIn('id', [$id])
        ->select('id')
        ->get();

        $secondLatestGetDebtForCustomer = GetDebt::where('customer_id', $getDebt->customer_id)
        ->orderBy('id', 'desc')
        ->skip(1)
        ->take(1)
        ->first();

        $lastCustomerId = Customer::orderBy('created_at', 'desc')->first(['id']);
        if (!$lastCustomerId) {
            return back();
        }

        $secondLatestCreatedAt = $secondLatestGetDebtForCustomer ? $secondLatestGetDebtForCustomer->created_at : null;

        $customers = Customer::where('type_delete',1)->get();

        $invoices = Invoice::with('product')
        ->search(['name|code' => $request->input('search')])
        ->orderBy('id', 'desc')
        ->where('get_debt_id', $id)
        ->paginateQuery();

        $invoices = $invoices->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $InvoicesResource = InvoicesResource::collection($invoices);

        $products = Product::where('type_delete',1)
        ->where('ShowSelect',1)
        ->get();

        $categories = Category::where('type_delete',1)->get();
        $totalBoxes = Invoice::where('get_debt_id', $id)->sum('box');
        $totalPriceAll = Invoice::where('get_debt_id', $id)->sum('price_all');

        $lastPrice = null;
        $lastGet_debt_id = null;

        $customer_id = $request->input('customer_id');
        $product_id = $request->input('product_id');
        if ($customer_id && $product_id) {
            $latestInvoice = Invoice::where('customer_id', $customer_id)
                                    ->where('product_id', $product_id)
                                    ->orderBy('id', 'desc')
                                    ->first();

            if ($latestInvoice) {
                $lastGet_debt_id = $latestInvoice->get_debt_id ?? 0;
                $lastPrice = $latestInvoice->price ?? 0;
            }
        }

        return inertia('System/Invoices/Index', [
            'getDebt' => $getDebt,
            'invoices' => $InvoicesResource,
            'customers' => $customers,
            'last_created_at' => $secondLatestCreatedAt,
            'last_customer_id' => $lastCustomerId,
            'products' => $products,
            'categories' => $categories,
            'totalBoxes' => $totalBoxes,
            'totalPriceAll' => $totalPriceAll,
            'getDebtIds' => $getDebtIds,
            'lastPrice' => $lastPrice,
            'lastGet_debt_id' => $lastGet_debt_id
        ]);
    }

    public function Getdebt($id)
    {
        $getDebt = GetDebt::findOrFail($id);

        $invoices = Invoice::where('get_debt_id', $id)->get();
        return inertia('System/Invoices/Partials/Getdebt', [
            'getDebt' => $getDebt,
            'invoices' => $invoices
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoicesRequest $request, GetDebt $getdebt)
    {
        $productId = $request->product_id;
        $product = null;
        if ($productId) {
            $product = Product::findOrFail($productId);
        } else {
            $product = Product::create([
                'category_id' => 1,
                'name_of_product' => $request->name,
                'code_of_product' => $request->code,
                'alert_of_out' => 15,
                'quantity_of_box' => $request->quantity_box,
                'quantity_of_store' => 0,
                'price_of_buy' => 0,
                'price_of_sell_tak' => $request->price,
                'price_of_sell_ko' => $request->price,
                'ShowSelect' => 1,
                'fix_number' => 0,
                'type_delete' =>1,
            ]);
            $productId = $product->id;
        }
        $quantity = $request->quantity ?? 0;
        $price = $request->price ?? 0;
        $box = $request->box ?? 0;
        $profit = ($price * $quantity) - ($product->price_of_buy * $quantity);
        Invoice::create([
            'get_debt_id' => $getdebt->id,
            'customer_id' => $getdebt->customer_id,
            'product_id' => $productId,
            'category_id' => $product->category_id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'code' => $request->code,
            'box' => $box,
            'quantity_box' => $request->quantity_box,
            'quantity' => $quantity,
            'profit' => $profit,
            'price' => $price,
            'price_all' => $request->price_all,
        ]);
        return back();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoicesRequest $request, GetDebt $getdebt, $id)
    {
        $invoice = $getdebt->invoices()->findOrFail($id);

        $invoice->update([
            'box' => $request->box,
            'code' => $request->code,
            'quantity_box' => $request->quantity_box,
            'quantity' => $request->quantity,
            'profit' => $request->profit,
            'price' => $request->price,
            'price_all' => $request->price_all,
            'get_debt_id' => $request->get_debt_id,
        ]);


        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GetDebt $getdebt,$id)
    {
        $getdebt->invoices()->findOrFail($id)->delete();

        return back();
    }

    public function getDebtUpdate(GetDebtsRequest $request, GetDebt $getDebt)
    {
        $originalCustomerId = $getDebt->getOriginal('customer_id');
        $orgiinalS_id = $getDebt->getOriginal('s_id');
        $getDebt->fill([
            'amount_of_debt' => $request->amount_of_debt ?? 0,
            'discount' => $request->discount ?? 0,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'type_price' => $request->type_price,
            'type_notice' => $request->type_notice,
            'customer_id' => $request->customer_id,
            'curr' => $request->curr ?? 0,
            'amount_dollar' => $request->amount_dollar ?? 0,
            'amount_dinar' => $request->amount_dinar ?? 0,
        ]);
        $isCustomerIdChanged = $getDebt->isDirty('customer_id');
        $getDebt->save();
        $newCustomerId = $getDebt->customer_id;
        if ($isCustomerIdChanged) {
            /// first step
            $greaterIdExists = GetDebt::where('customer_id', $newCustomerId)
            ->where('s_id', '>', $orgiinalS_id)
            ->exists();
                if ($greaterIdExists) {
                $maxS_id = GetDebt::max('s_id');
                $getDebt->s_id = $maxS_id + 1;
                $getDebt->save();
                }

                $price_all = GetDebt::where('get_debts.id', $getDebt->id)
                ->join('invoices', 'invoices.get_debt_id', '=', 'get_debts.id')
                ->sum('invoices.price_all');
                /// second step
                if($originalCustomerId) {
                    $oldCustomer = Customer::find($originalCustomerId);
                    $oldDebtCustomer = $oldCustomer ? $oldCustomer->debt_customer : 0;
                    $oldCustomer->debt_customer = $oldDebtCustomer - $price_all + ($getDebt->discount + $getDebt->amount_of_debt);
                    $oldCustomer->save();
                    $decrementAmount = $price_all;
                    $incrementAmount = $getDebt->discount + $getDebt->amount_of_debt;

                    // For old_debt
                    DB::table('get_debts')
                        ->where('customer_id', $originalCustomerId)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->decrement('old_debt', $decrementAmount);
                    DB::table('get_debts')
                        ->where('customer_id', $originalCustomerId)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->increment('old_debt', $incrementAmount);

                    // For new_debt
                    DB::table('get_debts')
                        ->where('customer_id', $originalCustomerId)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->decrement('new_debt', $decrementAmount);
                    DB::table('get_debts')
                        ->where('customer_id', $originalCustomerId)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->increment('new_debt', $incrementAmount);
                }
                if($newCustomerId) {
                    $newCustomer = Customer::find($newCustomerId);
                    $newDebtCustomer = $newCustomer ? $newCustomer->debt_customer : 0;
                    $newCustomer->debt_customer = $newDebtCustomer + $price_all - ($getDebt->discount + $getDebt->amount_of_debt);
                    $newCustomer->save();
                    $getDebt->new_debt = $newDebtCustomer + $price_all - ($getDebt->discount + $getDebt->amount_of_debt);
                    $getDebt->old_debt = $newDebtCustomer;
                    $getDebt->save();
                }
        }
        $customer = Customer::find($newCustomerId);
        if ($customer) {
            $getDebt->type_price = $customer->type_customer == 1 ? 1 : 0;
            $getDebt->save();
        }

        Invoice::whereHas('getDebt', function ($query) use ($getDebt) {
            $query->where('id', $getDebt->id);
        })->update(['customer_id' => $getDebt->customer_id]);


        return back();
    }

    public function FormCustomerStore(CustomersRequest $request)
    {
         Customer::create($request->validated());

        return back();
    }
    public function ListInvoice(Request $request)
    {
        $query = GetDebt::search([
            'customer.name_customer|s_id' => $request->input('search'),
        ]);
        if ($searchId = $request->input('ExSearch')) {
            $query->ExactSearch(['s_id' => $searchId]);
        }
        if ($searchKo = $request->input('CustSearchKo')) {
            $query->whereHas('customer', function ($query) use ($searchKo) {
                $query->where('name_customer', 'like', '%' . $searchKo . '%')
                      ->where('type_customer', 1);
            });
        }
        $NotDelivered = $request->input('NotDiv');
        if ($NotDelivered == 'equal') {
            $query->NumFilt('delivery', $NotDelivered);
        }
        $TypeNote = $request->input('Note');
        if ($TypeNote == 'greater') {
            $query->NumFilt('type_notice', $TypeNote);
        }

        if ($searchTak = $request->input('CustSearchTak')) {
            $query->whereHas('customer', function ($query) use ($searchTak) {
                $query->where('name_customer', 'like', '%' . $searchTak . '%')
                      ->where('type_customer', 0);
            });
        }
        $query->searchByDate($request->input('start_date'), $request->input('end_date'));
        $getDebts = $query->with('user')->orderBy('s_id', 'desc')->where('type_delete', 1)
        ->with('user')
        ->with('customer')->paginateQuery();

        $getDebts->appends($request->only(['search' , 'perPage', 'start_date', 'end_date' , 'ExSearch','CustSearchKo','CustSearchTak' , 'Note','NotDiv']));

        $getDebtsResource = GetDebtsResource::collection($getDebts);

        return inertia('System/Invoices/ListInvoice', [
            'getDebts' => $getDebtsResource
        ]);
    }
    public function ListInvoiceAll(Request $request)
    {
        $query = Invoice::search([
            'name|code' => $request->input('SearchProduct'),
        ]);
        if ($searchKo = $request->input('SearchCustomer')) {
            $query->whereHas('customer', function ($query) use ($searchKo) {
                $query->where('name_customer', 'like', '%' . $searchKo . '%')
                      ->where('type_customer', 1);
            });
        }
        if ($searchKo = $request->input('SearchCustomerTak')) {
            $query->whereHas('customer', function ($query) use ($searchKo) {
                $query->where('name_customer', 'like', '%' . $searchKo . '%')
                      ->where('type_customer', 0);
            });
        }
        if ($searchGetDebtId = $request->input('search')) {
            $query->ExactSearch(['getDebt.s_id' => $searchGetDebtId]);
        }
        if ($searchCustomer_Id = $request->input('searchCustId')) {
            $query->ExactSearch(['customer_id' => $searchCustomer_Id]);
        }
        if ($searchProduct_Id = $request->input('searchProdId')) {
            $query->ExactSearch(['product_id' => $searchProduct_Id]);
        }
        if ($searchCategory_Id = $request->input('searchCateId')) {
            $query->ExactSearch(['category_id' => $searchCategory_Id]);
        }
        $query->whereHas('getDebt', function ($q) {
            $q->where('type_delete', 1);
        });
        $query->searchByDate($request->input('start_date'), $request->input('end_date'));
        $invoices = $query->orderBy('id', 'desc')->with('user')->with('getDebt')->with('customer')->paginateQuery();
        $invoices->appends($request->only(['search', 'perPage', 'start_date', 'end_date','SearchProduct','SearchCustomer','SearchCustId','SearchProdId','searchCateId','SearchCustomerTak']));
        $InvoicesResource = InvoicesResource::collection($invoices);
        $products = Product::where('type_delete',1)->get();
        $products =  ProductsResource::collection($products);
        $customers = Customer::where('type_delete',1)->where('type_customer',1)->get();
        $customers =  CustomersResource::collection($customers);
        $customersTak = Customer::where('type_delete',1)->where('type_customer',0)->get();
        $customersTak =  CustomersResource::collection($customersTak);
        $categories = Category::where('type_delete',1)->get();
        $categories =  CategoriesResource::collection($categories);
        return inertia('System/Invoices/AllListInvoice', ['invoices' => $InvoicesResource,'products' => $products,'customers'=> $customers , 'customersTak'=>$customersTak,'categories'=>$categories]);
    }


    public function repairAll()
    {
        $customers = Customer::where('type_delete', 1)->get();
        foreach ($customers as $customer) {

            $customer->updateFirstGetDebtOldDebt($customer->id);

            $getDebts = GetDebt::where('customer_id', $customer->id)
                                ->where('type_delete', 1)
                                ->orderBy('s_id', 'asc')
                                ->get();
            if ($getDebts->isEmpty()) {
                Customer::where('id', $customer->id)->update(['debt_customer' => $customer->debt_first]);
                continue;
            }

            $lastNewDebt = $customer->debt_first;

            foreach ($getDebts as $index => $getDebt) {

                $price_all = GetDebt::where('get_debts.id', $getDebt->id)
                                    ->join('invoices', 'invoices.get_debt_id', '=', 'get_debts.id')
                                    ->sum('invoices.price_all');

                $newDebt = $getDebt->old_debt + $price_all - $getDebt->amount_of_debt - $getDebt->discount;
                $getDebt->update(['new_debt' => $newDebt]);
                $lastNewDebt = $newDebt;

                if (isset($getDebts[$index + 1])) {
                    $getDebts[$index + 1]->update(['old_debt' => $newDebt]);
                }
            }

            Customer::where('id', $customer->id)->update(['debt_customer' => $lastNewDebt]);

        }

        return back();
    }
    public function DestroyFromInvoice(GetDebt $getDebt)
    {
        $getDebt->delete();

        return to_route('before.create.invoice');
    }

}

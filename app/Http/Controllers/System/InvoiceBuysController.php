<?php

namespace App\Http\Controllers\System;

use App\Models\Seller;
use App\Models\Product;
use App\Models\RepDebt;
use App\Models\Category;
use App\Models\InvoiceBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\RepDebtsRequest;
use App\Http\Requests\System\InvoiceBuysRequest;
use App\Http\Resources\System\InvoiceBuysResource;
use App\Models\Customer;

class InvoiceBuysController extends Controller
{

    public function BeforeCreate()
    {

        return inertia('System/InvoiceBuys/BeforeCreate');
    }


    public function BeforeStore()
    {
        $maxS_id = RepDebt::max('s_id');
        $nextS_id = $maxS_id + 1;
       $RepDebt = RepDebt::create([
            'seller_id' => null,
            'user_id' => auth()->id(),
            'office_id' => null,
            'old_debt' => 0,
            'amount_of_debt' => 0,
            'amount_curr' => 0,
            'discount' => 0,
            'discount_curr' => 0,
            'new_debt' => 0,
            'name_of_recipient' => null,
            'name_of_office' => null,
            'notice_of_debt' => null,
            'curr' => 1,
            'type_notice' => 0,
            'type_curr' => 0,
            'type_invoice' => 1,
            'type_delete' => 1,
            's_id' =>$nextS_id,
            'id_off_conn' => 0,
        ]);
        return to_route('repdebts.invoicebuys.index' , $RepDebt->id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request ,$id)
    {
        $repDebt = RepDebt::with('seller')->where('type_delete',1)->where('type_invoice', 1)->findOrFail($id);


        $sellers = Seller::where('type_delete',1)->get();


       $invoiceBuys = InvoiceBuy::search(['name|code' => $request->input('search')])
        ->orderBy('id', 'desc')
        ->where('rep_debt_id', $id)
        ->paginateQuery();


      $invoiceBuys = $invoiceBuys->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

         $products = Product::where('type_delete',1)
        ->get();



        $categories = Category::where('type_delete',1)->get();
        $totalBoxes = InvoiceBuy::where('rep_debt_id', $id)->sum('box');
        $totalPriceAll = InvoiceBuy::where('rep_debt_id', $id)->sum('price_all');


        $invoiceBuys = InvoiceBuysResource::collection($invoiceBuys);

        return inertia('System/InvoiceBuys/Index' , [
            'repDebt' => $repDebt,
            'invoiceBuys' => $invoiceBuys,
            'sellers' => $sellers,
            'products' => $products,
            'categories' => $categories,
            'totalBoxes' => $totalBoxes,
            'totalPriceAll' => $totalPriceAll,
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
    public function store(InvoiceBuysRequest $request,RepDebt $repdebt)
    {


        $product_id = $request->input('product_id');
        $productID = Product::find($product_id);
        if(is_null($productID)){
           $InvoiceBuy =  InvoiceBuy::create([
                'rep_debt_id' => $repdebt->id,
                'seller_id' => $repdebt->seller_id,
                'category_id' => 0,
                'user_id' => auth()->id(),
                'name' => $request->name,
                'code' => $request->code,
                'box' => $request->box,
                'quantity_box' => $request->quantity_box,
                'quantity' => $request->quantity,
                'p_buy' => $request->p_buy,
                'p_buy_curr' => $request->p_buy_curr ?? 0,
                'expense' => $request->expense ?? 0,
                'expense_curr' => $request->expense_curr ?? 0,
                'p_all_buy' => $request->p_all_buy,
                'p_all_buy_curr' => $request->p_all_buy_curr ?? 0,
                'price_all' =>  $request->price_all,
                'price_all_curr' => $request->price_all_curr ?? 0,
                'sell_ko' => $request->sell_ko,
                'sell_tak' => $request->sell_tak,
            ]);


            if ($InvoiceBuy['code'] == null) {
                $maxCode = Product::max('code_of_product');
                $nextCode = $maxCode ? $maxCode + 1 : 1;
                $InvoiceBuy['code'] = $nextCode;
            }

            $product = new Product([
                'category_id' => $InvoiceBuy['category_id'],
                'name_of_product' => $InvoiceBuy['name'],
                'code_of_product' => $InvoiceBuy['code'],
                'quantity_of_box' => $InvoiceBuy['quantity_box'],
                'quantity_of_store' => $InvoiceBuy['quantity'],
                'price_of_buy' => $InvoiceBuy['p_all_buy'],
                'alert_of_out' => 15,
                'price_of_sell_tak' => $InvoiceBuy['sell_tak'],
                'price_of_sell_ko' => $InvoiceBuy['sell_ko'],
                'ShowSelect' => 1,
            ]);

            if ($InvoiceBuy['product_id'] == null) {
                $InvoiceBuy['product_id'] = $product->id;
            }

            $product->save();

            $product_id = $product->id;

        }else{
            $InvoiceBuy =  InvoiceBuy::create([
                'rep_debt_id' => $repdebt->id,
                'seller_id' => $repdebt->seller_id,
                'product_id' => $productID->id,
                'category_id' => $request->category_id,
                'user_id' => auth()->id(),
                'name' => $productID->name_of_product,
                'code' => $productID->code_of_product,
                'box' => $request->box,
                'quantity_box' => $request->quantity_box,
                'quantity' => $request->quantity,
                'p_buy' => $request->p_buy,
                'p_buy_curr' => $request->p_buy_curr ?? 0,
                'expense' => $request->expense ?? 0,
                'expense_curr' => $request->expense_curr ?? 0,
                'p_all_buy' => $request->p_all_buy,
                'p_all_buy_curr' => $request->p_all_buy_curr ?? 0,
                'price_all' =>  $request->price_all,
                'price_all_curr' => $request->price_all_curr ?? 0,
                'sell_ko' => $request->sell_ko,
                'sell_tak' => $request->sell_tak,
            ]);


            $productID->update([
                'quantity_of_store' => $productID->quantity_of_store + $InvoiceBuy['quantity'],
                'quantity_of_box' => $InvoiceBuy['quantity_box'],
                'price_of_buy' => $InvoiceBuy['p_all_buy'],
                'price_of_sell_tak' => $InvoiceBuy['sell_tak'],
                'price_of_sell_ko' => $InvoiceBuy['sell_ko'],
            ]);


        }



          return back();
    }

    public function RepDebtUpdate(RepDebtsRequest $request, RepDebt $repDebt)
    {
        $originalSellerId = $repDebt->getOriginal('seller_id');
        $orgiinalS_id = $repDebt->getOriginal('s_id');
        $repDebt->fill([
            'amount_of_debt' => $request->amount_of_debt ?? 0,
            'discount' => $request->discount ?? 0,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'type_curr' => $request->type_curr,
            'type_notice' => $request->type_notice,
            'seller_id' => $request->seller_id,
            'curr' => $request->curr ?? 0,
            'amount_dollar' => $request->amount_dollar ?? 0,
            'amount_dinar' => $request->amount_dinar ?? 0,
        ]);
        $isSellerIdChanged = $repDebt->isDirty('seller_id');
        $repDebt->save();
        $newSellerId = $repDebt->seller_id;
        if ($isSellerIdChanged) {
            /// first step
            $greaterIdExists = RepDebt::where('seller_id', $newSellerId)
            ->where('s_id', '>', $orgiinalS_id)
            ->exists();
                if ($greaterIdExists) {
                $maxS_id = RepDebt::max('s_id');
                $repDebt->s_id = $maxS_id + 1;
                $repDebt->save();
                }

                $price_all = RepDebt::where('rep_debts.id', $repDebt->id)
                ->join('invoice_buys', 'invoice_buys.rep_debt_id', '=', 'rep_debts.id')
                ->sum('invoice_buys.price_all');
                /// second step
                if($originalSellerId) {
                    $oldSeller = Seller::find($originalSellerId);
                    $oldDebtSeller = $oldSeller ? $oldSeller->debt_seller : 0;
                    $oldSeller->debt_seller = $oldDebtSeller - $price_all + ($repDebt->discount + $repDebt->amount_of_debt);
                    $oldSeller->save();
                    $decrementAmount = $price_all;
                    $incrementAmount = $repDebt->discount + $repDebt->amount_of_debt;

                    // For old_debt
                    DB::table('rep_debts')
                        ->where('seller_id', $originalSellerId)
                        ->where('s_id', '>', $repDebt->s_id)
                        ->decrement('old_debt', $decrementAmount);
                    DB::table('rep_debts')
                        ->where('seller_id', $originalSellerId)
                        ->where('s_id', '>', $repDebt->s_id)
                        ->increment('old_debt', $incrementAmount);

                    // For new_debt
                    DB::table('rep_debts')
                        ->where('seller_id', $originalSellerId)
                        ->where('s_id', '>', $repDebt->s_id)
                        ->decrement('new_debt', $decrementAmount);
                    DB::table('rep_debts')
                        ->where('seller_id', $originalSellerId)
                        ->where('s_id', '>', $repDebt->s_id)
                        ->increment('new_debt', $incrementAmount);
                }
                if($newSellerId) {
                    $newSeller = Seller::find($newSellerId);
                    $newDebtSeller = $newSeller ? $newSeller->debt_seller : 0;
                    $newSeller->debt_seller = $newDebtSeller + $price_all - ($repDebt->discount + $repDebt->amount_of_debt);
                    $newSeller->save();
                    $repDebt->new_debt = $newDebtSeller + $price_all - ($repDebt->discount + $repDebt->amount_of_debt);
                    $repDebt->old_debt = $newDebtSeller;
                    $repDebt->save();
                }
        }

        $Seller = Seller::find($newSellerId);
        if ($Seller) {
            $repDebt->type_curr = $Seller->type_curr;
            $repDebt->save();
        }

        InvoiceBuy::whereHas('repDebt', function ($query) use ($repDebt) {
            $query->where('id', $repDebt->id);
        })->update(['seller_id' => $repDebt->seller_id]);


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
        //.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepDebt $repDebt,$id)
    {
       $repDebt->invoiceBuys()->findOrFail($id)->delete();

        return back();
    }
}

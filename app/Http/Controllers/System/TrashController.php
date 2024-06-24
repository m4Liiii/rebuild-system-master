<?php

namespace App\Http\Controllers\System;

use App\Models\Debtor;
use App\Models\Office;
use App\Models\Seller;
use App\Models\GetDebt;
use App\Models\OffDebt;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\OnlyDebt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\System\OfficesResource;
use App\Http\Resources\System\SellersResource;
use App\Http\Resources\System\GetDebtsResource;
use App\Http\Resources\System\OffDebtsResource;
use App\Http\Resources\System\ProductsResource;
use App\Http\Resources\System\CustomersResource;
use App\Http\Resources\System\CategoriesResource;

class TrashController extends Controller
{
    public function category_delete(Category $category)
    {
        $category->type_delete = 0;
        $category->save();
        Product::where('category_id', $category->id)->update(['type_delete' => 0]);
        return back();
    }
    public function product_delete(Product $product)
    {
        $product->type_delete = 0;
        $product->save();
        return back();
    }
    public function getdebt_delete(GetDebt $getdebt)
    {
        DB::transaction(function () use ($getdebt) {
            $getdebt->type_delete = 0;
            $getdebt->save();
            $totalInvoicePrice = $getdebt->invoices->sum('price_all');
            $diffAmountOfDebt = $getdebt->amount_of_debt;
            $diffDiscount = $getdebt->discount;
            $incrementValueOfDebt = ($diffAmountOfDebt + $diffDiscount);
            $icrementAll = ($incrementValueOfDebt - $totalInvoicePrice);
            if ($getdebt->customer) {
                $getdebt->customer->increment('debt_customer', $icrementAll);
            }
            GetDebt::where('customer_id', $getdebt->customer_id)
                   ->where('id', '>', $getdebt->id)
                   ->where('type_delete', 1)
                   ->increment('new_debt',$icrementAll);

            GetDebt::where('customer_id', $getdebt->customer_id)
                   ->where('id', '>', $getdebt->id)
                   ->where('type_delete', 1)
                   ->increment('old_debt',$icrementAll);

                   foreach ($getdebt->invoices as $invoice) {
                    $product = $invoice->product;
                    if($product) {
                        $product->quantity_of_store += $invoice->quantity;
                        $product->save();
                    } else {}
                }
        });

        return back();
    }
    public function getdebt_delete_inv(GetDebt $getdebt)
    {
        DB::transaction(function () use ($getdebt) {
            $getdebt->type_delete = 0;
            $getdebt->save();
            $totalInvoicePrice = $getdebt->invoices->sum('price_all');
            $diffAmountOfDebt = $getdebt->amount_of_debt;
            $diffDiscount = $getdebt->discount;
            $incrementValueOfDebt = ($diffAmountOfDebt + $diffDiscount);
            $icrementAll = ($incrementValueOfDebt - $totalInvoicePrice);
            if ($getdebt->customer) {
                $getdebt->customer->increment('debt_customer', $icrementAll);
            }
            GetDebt::where('customer_id', $getdebt->customer_id)
                   ->where('id', '>', $getdebt->id)
                   ->where('type_delete', 1)
                   ->increment('new_debt',$icrementAll);

            GetDebt::where('customer_id', $getdebt->customer_id)
                   ->where('id', '>', $getdebt->id)
                   ->where('type_delete', 1)
                   ->increment('old_debt',$icrementAll);

                   foreach ($getdebt->invoices as $invoice) {
                    $product = $invoice->product;
                    if($product) {
                        $product->quantity_of_store += $invoice->quantity;
                        $product->save();
                    } else {}
                }
        });

        return to_route('before.create.invoice');
    }
    public function offdebt_delete(OffDebt $offdebt)
    {
        DB::transaction(function () use ($offdebt) {
            $offdebt->type_delete = 0;
            $offdebt->save();
            $diffAmountOfDebt = $offdebt->amount_of_debt;
            $diffDiscount = $offdebt->discount;
            $incrementValueOfDebt = ($diffAmountOfDebt + $diffDiscount);

            $icrementAll = $incrementValueOfDebt;
            if ($offdebt->office) {
                $offdebt->office->increment('debt_office', $icrementAll);
            }
            OffDebt::where('office_id', $offdebt->office_id)
                   ->where('id', '>', $offdebt->id)
                   ->where('type_delete', 1)
                   ->increment('new_debt',$icrementAll);

            OffDebt::where('office_id', $offdebt->office_id)
                   ->where('id', '>', $offdebt->id)
                   ->where('type_delete', 1)
                   ->increment('old_debt',$icrementAll);


        });

        return back();
    }

    public function customer_delete(Customer $customer)
    {
        $customer->type_delete = 0;
        $customer->save();
        GetDebt::where('customer_id', $customer->id)->update(['type_delete' => 0]);
        return back();
    }
    public function seller_delete(Seller $seller)
    {
        $seller->type_delete = 0;
        $seller->save();
        // GetDebt::where('seller_id', $seller->id)->update(['type_delete' => 0]);
        return back();
    }
        public function office_delete(Office $office)
    {
        $office->type_delete = 0;
        $office->save();
        OffDebt::where('office_id', $office->id)->update(['type_delete' => 0]);
        return back();
    }
        public function debtor_delete(Debtor $debtor)
    {
        $debtor->type_delete = 0;
        $debtor->save();
        OnlyDebt::where('debtor_id', $debtor->id)->update(['type_delete' => 0]);
        return back();
    }
    public function category_restore(Category $category)
    {
        $category->type_delete = 1;
        $category->save();
        Product::where('category_id', $category->id)->update(['type_delete' => 1]);
        return back();
    }
    public function product_restore(Product $product)
    {
        Category::where('id', $product->category_id)->update(['type_delete' => 1]);

        $product->update(['type_delete' => 1]);

        return back();
    }

    public function getdebt_restore(GetDebt $getdebt)
    {
        Customer::where('id', $getdebt->customer_id)->update(['type_delete' => 1]);
        $getdebt->type_delete = 1;
        $getdebt->save();
        $getdebt->repairGetDebts($getdebt->customer_id);
        DB::transaction(function () use ($getdebt) {
                   foreach ($getdebt->invoices as $invoice) {
                    $product = $invoice->product;
                    if($product) {
                        $product->quantity_of_store -= $invoice->quantity;
                        $product->save();
                    } else {}
                }
        });


        return back();
    }
    public function offdebt_restore(OffDebt $offdebt)
    {
        Office::where('id', $offdebt->office_id)->update(['type_delete' => 1]);
        $offdebt->type_delete = 1;
        $offdebt->save();
        $offdebt->repairOffDebts($offdebt->office_id);

        return back();
    }
    public function customer_restore(Customer $customer)
    {
        $customer->type_delete = 1;
        $customer->save();
        GetDebt::where('customer_id', $customer->id)->update(['type_delete' => 1]);
        return back();
    }
    public function seller_restore(Seller $seller)
    {
        $seller->type_delete = 1;
        $seller->save();
        // GetDebt::where('seller_id', $seller->id)->update(['type_delete' => 1]);
        return back();
    }
    public function office_restore(Office $office)
    {
        $office->type_delete = 1;
        $office->save();
        OffDebt::where('office_id', $office->id)->update(['type_delete' => 1]);
        return back();
    }
    public function debtor_restore(Debtor $debtor)
    {
        $debtor->type_delete = 1;
        $debtor->save();
        OnlyDebt::where('debtor_id', $debtor->id)->update(['type_delete' => 1]);
        return back();
    }
    public function category_show(Request $request)
    {
        $categories = Category::search([
            'name|code' => $request->input('search'),
        ])
        ->where('type_delete',0)
        ->orderBy('id', 'desc')
        ->paginateQuery();

        $categories = $categories->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $CategoriesResource = CategoriesResource::collection($categories);

        return inertia('System/Trash/Category', ['categories' => $CategoriesResource]);
    }
    public function product_show(Request $request)
    {
        $products = Product::search([
            'name_of_product|code_of_product' => $request->input('search'),
        ])
        ->with('category')
        ->where('type_delete',0)
        ->orderBy('id', 'desc')
        ->paginateQuery();


        $products = $products->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $ProductsResource = ProductsResource::collection($products);

        return inertia('System/Trash/Product', ['products' => $ProductsResource]);
    }
    public function getdebt_show(Request $request)
    {

        $getDebts = GetDebt::search([
            's_id|customer.name_customer' => $request->input('search'),
        ])
        ->with('user')
        ->with('customer')
        ->where('type_delete',0)
        ->orderBy('s_id', 'desc')
        ->paginateQuery();


        $getDebts = $getDebts->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $getDebtsResource = GetDebtsResource::collection($getDebts);


        return inertia('System/Trash/GetDebt',['getDebts' => $getDebtsResource]);
    }
    public function offdebt_show(Request $request)
    {

        $offDebts = OffDebt::search([
            'id|office.name_office' => $request->input('search'),
        ])
        ->with('user')
        ->with('office')
        ->where('type_delete',0)
        ->orderBy('id', 'desc')
        ->paginateQuery();


        $offDebts = $offDebts->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $offDebtsResource = OffDebtsResource::collection($offDebts);


        return inertia('System/Trash/OffDebt',['offDebts' => $offDebtsResource]);
    }
    public function customer_show(Request $request)
    {
        $query = Customer::search([
            'name_customer|address|phone_number|social_number' => $request->input('search'),
        ]);
         $customers = $query
         ->orderBy('debt_customer', 'desc')
         ->where('type_delete',0)
         ->paginateQuery();


         $customers = $customers->appends([
             'search' => $request->input('search'),
             'perPage' => $request->input('perPage'),
         ]);

         $CustomersResource = CustomersResource::collection($customers);

        return inertia('System/Trash/Customer', ['customers' => $CustomersResource]);
    }
    public function seller_show(Request $request)
    {
        $query = seller::search([
            'name_seller|address|phone_number|social_number' => $request->input('search'),
        ]);
         $sellers = $query
         ->orderBy('debt_seller', 'desc')
         ->where('type_delete',0)
         ->paginateQuery();


         $sellers = $sellers->appends([
             'search' => $request->input('search'),
             'perPage' => $request->input('perPage'),
         ]);

         $sellersResource = SellersResource::collection($sellers);

        return inertia('System/Trash/Seller', ['sellers' => $sellersResource]);
    }
    public function office_show(Request $request)
    {
        $query = Office::search([
            'name_office|address|phone_number|social_number' => $request->input('search'),
        ]);
         $offices = $query
         ->orderBy('debt_office', 'desc')
         ->where('type_delete',0)
         ->paginateQuery();


         $offices = $offices->appends([
             'search' => $request->input('search'),
             'perPage' => $request->input('perPage'),
         ]);

         $OfficesResource = OfficesResource::collection($offices);

        return inertia('System/Trash/Office', ['offices' => $OfficesResource]);
    }

    public function category_restore_all()
{

    Category::where('type_delete', 0)->update(['type_delete' => 1]);

    Product::whereIn('category_id', function ($query) {
        $query->select('id')->from('categories')->where('type_delete', 1);
    })->update(['type_delete' => 1]);

    return back();
}
public function category_delete_all()
{
    Category::where('type_delete', 0)->delete();

    return back();
}
public function customer_restore_all()
{

    Customer::where('type_delete', 0)->update(['type_delete' => 1]);

    GetDebt::whereIn('customer_id', function ($query) {
        $query->select('id')->from('customers')->where('type_delete', 1);
    })->update(['type_delete' => 1]);

    return back();
}
public function customer_delete_all()
{
    Customer::where('type_delete', 0)->delete();

    return back();
}
public function seller_restore_all()
{

    Seller::where('type_delete', 0)->update(['type_delete' => 1]);

    // GetDebt::whereIn('seller_id', function ($query) {
    //     $query->select('id')->from('sellers')->where('type_delete', 1);
    // })->update(['type_delete' => 1]);
    return back();
}
public function seller_delete_all()
{
    Seller::where('type_delete', 0)->delete();

    return back();
}
public function office_restore_all()
{

    Office::where('type_delete', 0)->update(['type_delete' => 1]);

    OffDebt::whereIn('office_id', function ($query) {
        $query->select('id')->from('offices')->where('type_delete', 1);
    })->update(['type_delete' => 1]);

    return back();
}
public function office_delete_all()
{
    Office::where('type_delete', 0)->delete();
    return back();
}
public function debtor_restore_all()
{

    Debtor::where('type_delete', 0)->update(['type_delete' => 1]);

    OnlyDebt::whereIn('debtor_id', function ($query) {
        $query->select('id')->from('debtors')->where('type_delete', 1);
    })->update(['type_delete' => 1]);

    return back();
}
public function debtor_delete_all()
{
    Debtor::where('type_delete', 0)->delete();
    return back();
}
public function product_restore_all()
{
    $products = Product::where('type_delete', 0)->get();
    foreach ($products as $product) {
        Category::where('id', $product->category_id)->update(['type_delete' => 1]);
        $product->update(['type_delete' => 1]);
    }
    return back();
}

public function product_delete_all()
{
    Product::where('type_delete', 0)->delete();

    return back();
}

public function getdebt_restore_all()
{
    $getdebts = GetDebt::where('type_delete', 0)->get();

    foreach ($getdebts as $getdebt) {
        Customer::where('id', $getdebt->customer_id)->update(['type_delete' => 1]);
        $getdebt->update(['type_delete' => 1]);
    }
    return back();
}

public function getdebt_delete_all()
{
    GetDebt::where('type_delete', 0)->delete();

    return back();
}
public function offdebt_restore_all()
{
    $offdebts = OffDebt::where('type_delete', 0)->get();
    foreach ($offdebts as $offdebt) {
        Office::where('id', $offdebt->office_id)->update(['type_delete' => 1]);
        $offdebt->update(['type_delete' => 1]);
    }
    return back();
}

public function offdebt_delete_all()
{
    OffDebt::where('type_delete', 0)->delete();

    return back();
}


}

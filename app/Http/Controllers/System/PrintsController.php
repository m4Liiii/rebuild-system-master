<?php

namespace App\Http\Controllers\System;

use Inertia\Response;
use App\Models\GetDebt;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\ProductsRequest;
use App\Http\Resources\System\ProductsResource;
use App\Http\Resources\System\CategoriesResource;
use App\Models\Customer;
use PDF;

class PrintsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ProductShow(Request $request, Category $category)
    {
        // Retrieve the filtered results based on the search query.
        $products = $category->products()
            ->search([
                'name_of_product' => $request->input('search'),
                'code_of_product' => $request->input('search')
            ])
            ->orderBy('id', 'desc')
            ->get(); // Retrieves a Collection of models.

            $selectedTable = $request->query('selectedTable');  // Get selectedTable from the request

        // Transform the products and category into resources.
        $ProductsResource = ProductsResource::collection($products);
        $categoryResource = new CategoriesResource($category);

        // Return the Inertia response with the resources.
        return inertia('System/Print/ProductShow', [
            'products' => $ProductsResource,
            'category' => $categoryResource,
            'search' => $request->input('search'),
            'selectedTable' => $selectedTable,
        ]);
    }

    public function PrintInvoice(GetDebt $getdebt)
    {
        $invoices = Invoice::where('get_debt_id',$getdebt->id)->get();
        $getDebt = GetDebt::with('customer')->where('id', $getdebt->id)->first();
        $totalPriceAll = Invoice::where('get_debt_id', $getdebt->id)->sum('price_all');
        $totalBox = Invoice::where('get_debt_id', $getdebt->id)->sum('box');
        return inertia('System/Print/InvoicePrintList',['invoices'=>$invoices,'totalBox'=>$totalBox,'totalPriceAll' =>$totalPriceAll,'getDebt'=>$getDebt]);
    }


    public function PrintInvoiceIQD(GetDebt $getdebt)
    {
        $invoices = Invoice::where('get_debt_id',$getdebt->id)->get();
        $getDebt = GetDebt::with('customer')->where('id', $getdebt->id)->first();
        $totalPriceAll = Invoice::where('get_debt_id', $getdebt->id)->sum('price_all');
        $totalBox = Invoice::where('get_debt_id', $getdebt->id)->sum('box');
        return inertia('System/Print/IQDinvoice',['invoices'=>$invoices,'totalBox'=>$totalBox,'totalPriceAll' =>$totalPriceAll,'getDebt'=>$getDebt]);
    }
    public function PrintInvoiceDownload(GetDebt $getdebt)
    {
        $invoices = Invoice::where('get_debt_id',$getdebt->id)->get();
        $getDebt = GetDebt::with('customer')->where('id', $getdebt->id)->first();
        $totalPriceAll = Invoice::where('get_debt_id', $getdebt->id)->sum('price_all');
        $totalBox = Invoice::where('get_debt_id', $getdebt->id)->sum('box');
        return inertia('System/Print/MountInvoiceDownload',['invoices'=>$invoices,'totalBox'=>$totalBox,'totalPriceAll' =>$totalPriceAll,'getDebt'=>$getDebt]);
    }

    public function PrintInvoiceIQDDownload(GetDebt $getdebt)
    {
        $invoices = Invoice::where('get_debt_id',$getdebt->id)->get();
        $getDebt = GetDebt::with('customer')->where('id', $getdebt->id)->first();
        $totalPriceAll = Invoice::where('get_debt_id', $getdebt->id)->sum('price_all');
        $totalBox = Invoice::where('get_debt_id', $getdebt->id)->sum('box');
        return inertia('System/Print/IQDMountinvoice',['invoices'=>$invoices,'totalBox'=>$totalBox,'totalPriceAll' =>$totalPriceAll,'getDebt'=>$getDebt]);
    }



}

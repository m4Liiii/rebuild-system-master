<?php

namespace App\Http\Controllers\System;

use App\Models\GetDebt;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\GetDebtsRequest;
use App\Http\Requests\System\CustomersRequest;
use App\Http\Resources\System\InvoicesResource;
use App\Http\Resources\System\ProductsResource;
use App\Http\Resources\System\CustomersResource;
use App\Http\Resources\System\CategoriesResource;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function index(Request $request)
     {


        $query = Customer::search([
            'name_customer|address|phone_number|social_number' => $request->input('search'),
            'address' => $request->input('searchAddress'),
            'phone_number|social_number' => $request->input('searchPhone'),
            'name_customer' => $request->input('searchName'),
        ]);
         $OnlyDebtors = $request->input('OnlyDebtors');
         if ($OnlyDebtors == 'greater') {
             $query->NumFilt('debt_customer', $OnlyDebtors);
         }
         $typeCustomer = $request->input('typeCustomer');
         if ($typeCustomer != null) {
             $query->where('type_customer', $typeCustomer);
         } else {
             $query->where('type_customer', 1);
         }
         $customers = $query
         ->orderBy('debt_customer', 'desc')
         ->where('type_delete',1)
         ->paginateQuery();


         $customers = $customers->appends([
             'search' => $request->input('search'),
             'searchAddress' => $request->input('searchAddress'),
             'searchPhone' => $request->input('searchPhone'),
             'searchName' => $request->input('searchName'),
             'perPage' => $request->input('perPage'),
             'OnlyDebtors' => $OnlyDebtors,
             'typeCustomer' => $typeCustomer,
         ]);

         $CustomersResource = CustomersResource::collection($customers);

         return inertia('System/Customers/Index', ['customers' => $CustomersResource]);
     }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia('System/Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomersRequest $request)
    {
         Customer::create($request->validated());

        return to_route('customers.index');
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
    public function edit(Customer $customer)
    {
        return inertia('System/Customers/Edit' , [
            'customer' => new CustomersResource($customer),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomersRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return to_route('customers.index');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back();
    }

    public function ShowInvoiceCustomer(Request $request,Customer $customer)
    {

    $query = Invoice::where('customer_id', $customer->id)
    ->search([
            'name|code' => $request->input('SearchProduct'),
        ]);
        if ($searchGetDebtId = $request->input('search')) {
            $query->ExactSearch(['getDebt.s_id' => $searchGetDebtId]);
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
        $invoices->appends($request->only(['search', 'perPage', 'start_date', 'end_date','SearchProduct','SearchProdId','searchCateId']));
        $InvoicesResource = InvoicesResource::collection($invoices);
        $products = Product::where('type_delete',1)->get();
        $products =  ProductsResource::collection($products);
        $categories = Category::where('type_delete',1)->get();
        $customerResource = new CustomersResource($customer);
        $categories =  CategoriesResource::collection($categories);
        return inertia('System/Customers/ShowInvoice', ['invoices' => $InvoicesResource,'products' => $products,'categories'=>$categories,'customer'=>$customerResource]);
    }


}

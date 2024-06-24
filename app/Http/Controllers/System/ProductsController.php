<?php

namespace App\Http\Controllers\System;

use Inertia\Response;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\ProductsRequest;
use App\Http\Resources\System\ProductsResource;
use App\Http\Resources\System\CategoriesResource;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category)
    {
        $products = $category->products()
        ->search([
            'name_of_product|code_of_product' => $request->input('search'),
        ])
        ->where('type_delete',1)
        ->orderBy('id', 'desc')
        ->paginateQuery();


        $products = $products->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $ProductsResource = ProductsResource::collection($products);

        // Transform the category model instance to a resource.
        $categoryResource = new CategoriesResource($category);

        return inertia('System/Products/Index', ['products' => $ProductsResource, 'category' => $categoryResource]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $categoryResource = new CategoriesResource($category);

        return inertia('System/Products/Create' ,[
            'category' => $categoryResource
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request , Category $category)
    {
        Product::create($request->validated());

        return to_route('categories.products.index' , $category->id);
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
    public function edit(Category $category, $id)
    {
        $product = $category->products()->findOrFail($id);

        return inertia('System/Products/Edit', [
            'category' => new CategoriesResource($category),
            'product'  => new ProductsResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductsRequest $request, Category $category, $id)
    {

        $product = $category->products()->findOrFail($id);

        $product->update($request->validated());

        return to_route('categories.products.index', $category->id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $id)
    {

        $category->products()->findOrFail($id)->delete();

        return back();
    }


    public function FixNumber(Product $product)
    {
        DB::transaction(function () use ($product) {

            $originalQuantity = $product->getOriginal('quantity_of_store');


            $product->fix_number += $originalQuantity;

            $product->quantity_of_store = 0;

            $product->save();
        });

        return back();
    }



}

<?php

namespace App\Http\Controllers\System;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\CategoriesRequest;
use App\Http\Resources\System\CategoriesResource;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::search([
            'name|code' => $request->input('search'),
        ])
        ->where('type_delete',1)
        ->orderBy('id', 'desc')
        ->withCount(['products' => function ($product) {
            $product->where('type_delete', 1);
        }])
        ->paginateQuery();

        $categories = $categories->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $CategoriesResource = CategoriesResource::collection($categories);

        return inertia('System/Categories/Index', ['categories' => $CategoriesResource]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia('System/Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
         Category::create($request->validated());

        return to_route('categories.index');
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
    public function edit(Category $category)
    {
        if ($category->id == 1) {
            return to_route('categories.index');
        }
        return inertia('System/Categories/Edit' , [
            'category' => new CategoriesResource($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        $category->update($request->validated());
        return to_route('categories.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back();
    }


}

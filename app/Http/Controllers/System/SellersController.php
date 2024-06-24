<?php

namespace App\Http\Controllers\System;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\SellersRequest;
use App\Http\Resources\System\SellersResource;


class SellersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Seller::search([
            'name_seller||address|phone_number|social_number' => $request->input('serach'),
            'address' => $request->input('searchAddress'),
            'phone_number|social_number' => $request->input('searchPhone'),
            'name_seller' => $request->input('searchName'),
        ]);
         $OnlyDebtors = $request->input('OnlyDebtors');
         if ($OnlyDebtors == 'greater') {
             $query->NumFilt('debt_seller', $OnlyDebtors);
         }
         $sellers = $query
         ->orderBy('debt_seller', 'desc')
         ->where('type_delete',1)
         ->paginateQuery();

         $sellers = $sellers->appends([
            'search' => $request->input('search'),
            'searchAddress' => $request->input('searchAddress'),
            'searchPhone' => $request->input('searchPhone'),
            'searchName' => $request->input('searchName'),
            'perPage' => $request->input('perPage'),
            'OnlyDebtors' => $OnlyDebtors,
        ]);

        $SellersResource = SellersResource::collection($sellers);

        return inertia('System/Sellers/Index',['sellers' => $SellersResource]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('System/Sellers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SellersRequest $request)
    {
        Seller::create($request->validated());

        return to_route('sellers.index');
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
    public function edit(Seller $seller)
    {


        return inertia('System/Sellers/Edit' , [
            'seller' => new SellersResource($seller),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SellersRequest $request,Seller $seller)
    {
        $seller->update($request->validated());
        return to_route('sellers.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();

        return back();
    }
}

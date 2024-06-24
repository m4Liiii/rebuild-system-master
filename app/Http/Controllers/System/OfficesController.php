<?php

namespace App\Http\Controllers\System;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\OfficesRequest;
use App\Http\Resources\System\OfficesResource;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Office::search([
            'name_office|address|phone_number|social_number' => $request->input('search'),
            'address' => $request->input('searchAddress'),
            'phone_number|social_number' => $request->input('searchPhone'),
            'name_office' => $request->input('searchName'),
        ]);
         $OnlyDebtors = $request->input('OnlyDebtors');
         if ($OnlyDebtors == 'greater') {
             $query->NumFilt('debt_office', $OnlyDebtors);
         }

         $offices = $query
         ->orderBy('debt_office', 'desc')
         ->where('type_delete',1)
         ->paginateQuery();



         $offices = $offices->appends([
            'search' => $request->input('search'),
            'searchAddress' => $request->input('searchAddress'),
            'searchPhone' => $request->input('searchPhone'),
            'searchName' => $request->input('searchName'),
            'perPage' => $request->input('perPage'),
            'OnlyDebtors' => $OnlyDebtors,

        ]);

        $OfficesResource = OfficesResource::collection($offices);

        return inertia('System/Offices/Index', ['offices' => $OfficesResource]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('System/Offices/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfficesRequest $request)
    {
        Office::create($request->validated());

        return to_route('offices.index');
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
    public function edit(Office $office)
    {
        return inertia('System/Offices/Edit',[
            'office' => new OfficesResource($office),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Office $office,OfficesRequest $request)
    {
        $office->update($request->validated());
        return to_route('offices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $office->delete();
        return back();
    }
}

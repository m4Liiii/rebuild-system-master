<?php

namespace App\Http\Controllers\System;

use App\Models\Debtor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\DebtorsRequest;
use App\Http\Resources\System\DebtorsResource;

class DebtorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Debtor::search([
            'name_debtor|address|phone_number|social_number' => $request->input('search'),
            'address' => $request->input('searchAddress'),
            'phone_number|social_number' => $request->input('searchPhone'),
            'name_debtor' => $request->input('searchName'),
        ]);
         $OnlyDebtors = $request->input('OnlyDebtors');
         if ($OnlyDebtors == 'greater') {
             $query->NumFilt('debt_debtor', $OnlyDebtors);
         }

         $debtors = $query
         ->orderBy('debt_debtor', 'desc')
         ->where('type_delete',1)
         ->paginateQuery();



         $debtors = $debtors->appends([
            'search' => $request->input('search'),
            'searchAddress' => $request->input('searchAddress'),
            'searchPhone' => $request->input('searchPhone'),
            'searchName' => $request->input('searchName'),
            'perPage' => $request->input('perPage'),
            'OnlyDebtors' => $OnlyDebtors,

        ]);

        $debtorsResource = DebtorsResource::collection($debtors);

        return inertia('System/Debtors/Index', ['debtors' => $debtorsResource]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('System/Debtors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DebtorsRequest $request)
    {
        Debtor::create($request->validated());

        return to_route('debtors.index');
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
    public function edit(Debtor $Debtor)
    {
        return inertia('System/Debtors/Edit',[
            'debtor' => new DebtorsResource($Debtor),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Debtor $Debtor,DebtorsRequest $request)
    {
        $Debtor->update($request->validated());
        return to_route('debtors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debtor $Debtor)
    {
        $Debtor->delete();
        return back();
    }
}

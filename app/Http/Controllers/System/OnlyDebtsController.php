<?php

namespace App\Http\Controllers\System;

use App\Models\Debtor;
use App\Models\OnlyDebt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\OnlyDebtsRequest;
use App\Http\Resources\System\DebtorsResource;
use App\Http\Resources\System\OnlyDebtsResource;

class OnlyDebtsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Debtor $debtor)
    {
        $query = OnlyDebt::where('debtor_id', $debtor->id);
        if ($searchId = $request->input('search')) {$query->ExactSearch(['id' => $searchId]);}
        $query->searchByDate($request->input('start_date'), $request->input('end_date'));

        $OnlyDebts = $query->with('user')->orderBy('id', 'desc')->where('type_delete',1)->paginateQuery();
        $OnlyDebts->appends($request->only(['search', 'perPage', 'start_date', 'end_date']));
        $OnlyDebtsResource = OnlyDebtsResource::collection($OnlyDebts);
        $debtorResource = new DebtorsResource($debtor);
        return inertia('System/OnlyDebts/Index', [
            'onlyDebts' => $OnlyDebtsResource,
            'debtor' => $debtorResource
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Debtor $debtor)
    {
        $debtorResource = new DebtorsResource($debtor);
        return inertia('System/OnlyDebts/Create',['debtor' => $debtorResource]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OnlyDebtsRequest $request, Debtor $debtor)
    {
        $amount_of_debt = $request->amount_of_debt ?? 0;
        $discount = $request->discount ?? 0;
        $old_debt = $debtor->debt_debtor;

        OnlyDebt::create([
            'debtor_id' => $debtor->id,
            'user_id' => auth()->id(),
            'old_debt' => $old_debt,
            'amount_of_debt' => $amount_of_debt,
            'discount' => $discount,
            'name_of_recipient' => $request->name_of_recipient,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'type_delete' => 1,

        ]);


        $debtor->save();
        return to_route('debtors.onlydebts.index', $debtor->id);
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
    public function edit(Debtor $debtor, $id)
    {

        $onlyDebt = $debtor->onlyDebts()->findOrFail($id);
        return inertia('System/OnlyDebts/Edit', [
            'debtor' => new DebtorsResource($debtor),
            'onlyDebt'  => $onlyDebt,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OnlyDebtsRequest $request, Debtor $debtor, $id)
    {
        $onlyDebt = $debtor->onlyDebts()->findOrFail($id);
        $data = $request->validated();
        $data['amount_of_debt'] = $data['amount_of_debt'] ?? 0;
        $data['discount'] = $data['discount'] ?? 0;
        $onlyDebt->update($data);
        return to_route('debtors.onlydebts.index', $debtor->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function repairDebts(Debtor $debtor)
    {
        $debtor->repairOnlyDebts($debtor->id);
        return back();
    }
}

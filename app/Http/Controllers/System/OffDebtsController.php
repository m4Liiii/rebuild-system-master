<?php

namespace App\Http\Controllers\System;

use App\Models\Office;
use App\Models\OffDebt;
use App\Models\RepDebt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\OffDebtsRequest;
use App\Http\Resources\System\OfficesResource;
use App\Http\Resources\System\OffDebtsResource;

class OffDebtsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Office $office)
    {
        $query = OffDebt::where('office_id', $office->id);
        if ($searchId = $request->input('search')) {$query->ExactSearch(['id' => $searchId]);}
        $query->searchByDate($request->input('start_date'), $request->input('end_date'));

        $offDebts = $query->with('user')->orderBy('id', 'desc')->where('type_delete',1)->paginateQuery();
        $offDebts->appends($request->only(['search', 'perPage', 'start_date', 'end_date']));
        $offDebtsResource = OffDebtsResource::collection($offDebts);
        $officeResource = new OfficesResource($office);
        return inertia('System/OffDebts/Index', [
            'offDebts' => $offDebtsResource,
            'office' => $officeResource
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Office $office)
    {
        $officeResource = new OfficesResource($office);

        return inertia('System/OffDebts/Create' , [
            'office' => $officeResource,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OffDebtsRequest $request, Office $office)
    {
        $amount_of_debt = $request->amount_of_debt ?? 0;
        $discount = $request->discount ?? 0;
        $old_debt = $office->debt_office;

         OffDebt::create([
            'office_id' => $office->id,
            'user_id' => auth()->id(),
            'old_debt' => $old_debt,
            'amount_of_debt' => $amount_of_debt,
            'discount' => $discount,
            'name_of_recipient' => $request->name_of_recipient,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'type_delete' => 1,
            't_curr_op' => 0,
            'curr_op' => 0,
        ]);

        $office->save();

        return to_route('offices.offdebts.index', $office->id);
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
    public function edit(Office $office, $id)
    {

        $offDebt = $office->offDebts()->findOrFail($id);
        return inertia('System/OffDebts/Edit', [
            'office' => new OfficesResource($office),
            'offDebt'  => $offDebt,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OffDebtsRequest $request, Office $office, $id)
    {
        $offDebt = $office->offDebts()->findOrFail($id);
        $data = $request->validated();
        $data['amount_of_debt'] = $data['amount_of_debt'] ?? 0;
        $data['discount'] = $data['discount'] ?? 0;



        $offDebt->update($data);

        $RevAmount = -($request->amount_of_debt * $request->curr_op);

        if ($offDebt->id_rep_conn) {
                $repDebt = RepDebt::find($offDebt->id_rep_conn);
                if ($repDebt) {
                    $repDebt->update([
                        'amount_of_debt' => $RevAmount,
                        'amount_curr' => $request->amount_of_debt
                    ]);
                }
            }
        return to_route('offices.offdebts.index', $office->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office, $id)
    {
        $office->offDebts()->findOrFail($id)->delete();
        return back();
    }
    public function repairDebts(Office $office)
    {
        $office->repairOffDebts($office->id);
        return back();
    }
}

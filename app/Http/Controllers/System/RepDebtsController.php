<?php

namespace App\Http\Controllers\System;

use App\Models\Office;
use App\Models\Seller;
use App\Models\OffDebt;
use App\Models\RepDebt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\RepDebtsRequest;
use App\Http\Resources\System\OfficesResource;
use App\Http\Resources\System\SellersResource;
use App\Http\Resources\System\RepDebtsResource;

class RepDebtsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,Seller $seller)
    {
        $query = RepDebt::where('seller_id', $seller->id);
        if ($searchId = $request->input('search')) {$query->ExactSearch(['id' => $searchId]);}
        $query->searchByDate($request->input('start_date'), $request->input('end_date'));
        $TypeNote = $request->input('Note');
        if ($TypeNote == 'greater') {
            $query->NumFilt('type_notice', $TypeNote);
        }
        $repDebts = $query->with('user')->orderBy('s_id', 'desc')->where('type_delete',1)->paginateQuery();
        $repDebts->appends($request->only(['search', 'perPage', 'start_date', 'end_date','Note','NotDiv']));
        $repDebtsResource = RepDebtsResource::collection($repDebts);
        $sellerResource = new SellersResource($seller);
        return inertia('System/RepDebts/Index', [
            'repDebts' => $repDebtsResource,
            'seller' => $sellerResource
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Seller $seller)
    {
        $sellerResource = new SellersResource($seller);
        $offices = Office::where('type_delete',1)->get();
        return inertia('System/RepDebts/Create' , [
            'seller' => $sellerResource,
            'offices'=>$offices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepDebtsRequest $request ,Seller $seller )
    {
        $amount_of_debt = $request->amount_of_debt ?? 0;
        $discount = $request->discount ?? 0;

        $amount_curr = $request->amount_curr ?? 0;
        $discount_curr = $request->discount_curr ?? 0;

        $old_debt = $seller->debt_seller;
        $new_debt = $old_debt - $request->amount_of_debt - $request->discount;
        $maxS_id = RepDebt::max('s_id');
        $nextS_id = $maxS_id + 1;

         $repDebt = RepDebt::create([
            'seller_id' => $seller->id,
            'user_id' => auth()->id(),
            'old_debt' => $old_debt,
            'amount_of_debt' => $amount_of_debt,
            'discount' => $discount,
            'new_debt' => $new_debt,
            'name_of_recipient' => $request->name_of_recipient,
            'name_of_office' => $request->name_of_office,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'amount_curr' => $amount_curr,
            'discount_curr' => $discount_curr,
            'curr' => $request->curr,
            'delivery' => 1,
            'type_curr' => $seller->type_curr,
            'type_invoice' => 0,
            'type_notice' => 0,
            'type_delete' => 1,
            's_id' =>  $nextS_id,
            'office_id' => $request->office_id,
            'id_off_conn' => 0,

        ]);

        $seller->debt_seller = $new_debt;
        $seller->save();

        if (!is_null($request->office_id)) {

            $office = Office::where('id', $request->office_id)->first();

            if ($office) {
                $revAmount = - ($amount_of_debt / $request->curr);

               $offDebt = OffDebt::create([
                    'office_id' => $office->id,
                    'user_id' => auth()->id(),
                    'old_debt' => $office->debt_office,
                    'amount_of_debt' => $revAmount,
                    'discount' => $discount,
                    'name_of_recipient' => null,
                    't_curr_op' => $seller->type_curr,
                    'curr_op' => $request->curr,
                    'notice_of_debt' => "بدل حساب ( {$seller->name_seller} )",
                    'created_at' => $request->created_at,
                    'type_delete' => 1,
                    'id_rep_conn' => $repDebt->id,
                ]);
            }
            $repDebt->update(['id_off_conn' => $offDebt->id]);


        }
        return to_route('sellers.repdebts.index', $seller->id);
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
    public function edit(Seller $seller, $id)
    {
        $offices = Office::where('type_delete',1)->get();
        $repDebt = $seller->repDebts()->where('type_invoice',0)->findOrFail($id);
        return inertia('System/RepDebts/Edit' ,[
            'seller' => new SellersResource($seller),
            'repDebt' => $repDebt,
            'offices' => $offices
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RepDebtsRequest $request,Seller $seller, $id)
    {
        $repDebt = $seller->repDebts()->findOrFail($id);
        $data = $request->validated();
        $data['amount_of_debt'] = $data['amount_of_debt'] ?? 0;
        $data['discount'] = $data['discount'] ?? 0;
        $data['amount_curr'] = $data['amount_curr'] ?? 0;
        $data['discount_curr'] = $data['discount_curr'] ?? 0;

        $RevAmount = -($data['amount_of_debt'] / $data['curr'] ?? 1);

        $repDebt->update($data);

        if ($repDebt->id_off_conn) {
            $offDebt = OffDebt::find($repDebt->id_off_conn);
            if ($offDebt) {
                $offDebt->update([
                    'amount_of_debt' => $RevAmount,
                ]);
            }
        }
        return to_route('sellers.repdebts.index', $seller->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

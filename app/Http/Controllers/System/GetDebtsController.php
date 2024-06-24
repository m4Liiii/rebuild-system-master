<?php

namespace App\Http\Controllers\System;

use App\Models\GetDebt;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\GetDebtsRequest;
use App\Http\Resources\System\GetDebtsResource;
use App\Http\Resources\System\CustomersResource;

class GetDebtsController extends Controller
{
    public function repairDebts(Customer $customer)
    {
        $customer->repairGetDebts($customer->id);

        return back();

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Customer $customer)
    {
        $query = GetDebt::where('customer_id', $customer->id);
        if ($searchId = $request->input('search')) {$query->ExactSearch(['id' => $searchId]);}
        $query->searchByDate($request->input('start_date'), $request->input('end_date'));
        $NotDelivered = $request->input('NotDiv');
        if ($NotDelivered == 'equal') {
            $query->NumFilt('delivery', $NotDelivered);
        }
        $TypeNote = $request->input('Note');
        if ($TypeNote == 'greater') {
            $query->NumFilt('type_notice', $TypeNote);
        }
        $getDebts = $query->with('user')->orderBy('s_id', 'desc')->where('type_delete',1)->paginateQuery();
        $getDebts->appends($request->only(['search', 'perPage', 'start_date', 'end_date','Note','NotDiv']));
        $getDebtsResource = GetDebtsResource::collection($getDebts);
        $customerResource = new CustomersResource($customer);
        return inertia('System/GetDebts/Index', [
            'getDebts' => $getDebtsResource,
            'customer' => $customerResource
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer)
    {
        $customerResource = new CustomersResource($customer);

        return inertia('System/GetDebts/Create',[
            'customer' => $customerResource,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GetDebtsRequest $request, Customer $customer)
    {
        $amount_of_debt = $request->amount_of_debt ?? 0;
        $discount = $request->discount ?? 0;

        $amount_dollar = $request->amount_dollar ?? 0;
        $amount_dinar = $request->amount_dinar ?? 0;

        $old_debt = $customer->debt_customer;
        $new_debt = $old_debt - $request->amount_of_debt - $request->discount;
        $maxS_id = GetDebt::max('s_id');
        $nextS_id = $maxS_id + 1;
         GetDebt::create([
            'customer_id' => $customer->id,
            'user_id' => auth()->id(),
            'old_debt' => $old_debt,
            'amount_of_debt' => $amount_of_debt,
            'discount' => $discount,
            'new_debt' => $new_debt,
            'name_of_recipient' => $request->name_of_recipient,
            'name_of_office' => $request->name_of_office,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'type_amount' => $request->type_amount,
            'amount_dollar' => $amount_dollar,
            'amount_dinar' => $amount_dinar,
            'curr' => $request->curr,
            'delivery' => 1,
            'type_notice' => 0,
            'type_price' => 0,
            'type_invoice' => 0,
            'type_delete' => 1,
            's_id' =>  $nextS_id,

        ]);

        $customer->debt_customer = $new_debt;
        $customer->save();

        return to_route('customers.getdebts.index', $customer->id);
    }

    public function StoreFromCustomer(GetDebtsRequest $request, Customer $customer)
    {

        $amount_of_debt = $request->amount_of_debt ?? 0;
        $discount = $request->discount ?? 0;

        $amount_dollar = $request->amount_dollar ?? 0;
        $amount_dinar = $request->amount_dinar ?? 0;

        $old_debt = $customer->debt_customer;
        $new_debt = $old_debt - $request->amount_of_debt - $request->discount;
        $maxS_id = GetDebt::max('s_id');
        $nextS_id = $maxS_id + 1;
          GetDebt::create([
            'customer_id' => $customer->id,
            'user_id' => auth()->id(),
            'old_debt' => $old_debt,
            'amount_of_debt' => $amount_of_debt,
            'discount' => $discount,
            'new_debt' => $new_debt,
            'name_of_recipient' => $request->name_of_recipient,
            'name_of_office' => $request->name_of_office,
            'notice_of_debt' => $request->notice_of_debt,
            'created_at' => $request->created_at,
            'type_amount' => $request->type_amount,
            'amount_dollar' => $amount_dollar,
            'amount_dinar' => $amount_dinar,
            'curr' => $request->curr,
            'delivery' => 0,
            'type_notice' => 0,
            'type_price' => 0,
            'type_invoice' => 0,
            'type_delete' => 1,
            's_id' => $nextS_id,
        ]);

        $customer->debt_customer = $new_debt;
        $customer->save();

        return back();
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
    public function edit(Customer $customer, $id)
    {

        $getDebt = $customer->getDebts()->where('type_invoice', 0)->findOrFail($id);
        return inertia('System/GetDebts/Edit', [
            'customer' => new CustomersResource($customer),
            'getDebt'  => $getDebt,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(GetDebtsRequest $request, Customer $customer, $id)
    {
        $getDebt = $customer->getDebts()->findOrFail($id);
        $data = $request->validated();
        $data['amount_of_debt'] = $data['amount_of_debt'] ?? 0;
        $data['discount'] = $data['discount'] ?? 0;
        $data['amount_dollar'] = $data['amount_dollar'] ?? 0;
        $data['amount_dinar'] = $data['amount_dinar'] ?? 0;
        $getDebt->update($data);
        return to_route('customers.getdebts.index', $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer,$id)
    {
        $customer->getDebts()->findOrFail($id)->delete();

        return back();
    }
    public function UpdateDelivery(Request $request , GetDebt $getdebt)
    {

        $getdebt->update([
            'delivery' => $request->delivery,
        ]);

        return back();
    }
}

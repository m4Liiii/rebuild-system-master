<?php

namespace App\Traits;


use App\Models\Debtor;
use App\Models\Office;
use App\Models\GetDebt;
use App\Models\OffDebt;
use App\Models\Customer;
use App\Models\OnlyDebt;
use Illuminate\Support\Facades\Log;

trait HandlesDebtRepairs
{


    public function updateFirstGetDebtOldDebt($customer_id)
    {
        $firstGetDebt = GetDebt::where('customer_id', $customer_id)
                                ->where('type_delete', 1)
                                ->orderBy('s_id', 'asc')
                                ->first();
        $customer = Customer::find($customer_id);

        $customer->debt_customer = $customer->debt_first;
        if ($firstGetDebt) {
            $firstGetDebt->old_debt = $customer->debt_first;
            $firstGetDebt->save();
        }
    }

    public function repairGetDebts($customer_id)
    {
        $customer = Customer::find($customer_id);
        $this->updateFirstGetDebtOldDebt($customer_id);
        $getDebts = GetDebt::where('customer_id', $customer_id)
                            ->where('type_delete', 1)
                            ->orderBy('s_id', 'asc')
                            ->get();

        $lastNewDebt = $customer->debt_first;
        foreach ($getDebts as $index => $getDebt) {
            $price_all = GetDebt::where('get_debts.id', $getDebt->id)
                    ->join('invoices', 'invoices.get_debt_id', '=', 'get_debts.id')
                    ->sum('invoices.price_all');
            $newDebt = $getDebt->old_debt + $price_all - $getDebt->amount_of_debt - $getDebt->discount;
            $getDebt->update(['new_debt' => $newDebt]);
            $lastNewDebt = $newDebt;
            if (isset($getDebts[$index + 1])) {
                $getDebts[$index + 1]->update(['old_debt' => $newDebt]);
            }
        }
        Customer::where('id', $customer_id)->update(['debt_customer' => $lastNewDebt]);
    }

    public function updateFirstOffDebtOldDebt($office_id)
    {
        $firstOffDebt = OffDebt::where('office_id', $office_id)
                                ->where('type_delete', 1)
                                ->orderBy('id', 'asc')
                                ->first();
        $office = Office::find($office_id);

        $office->debt_office = $office->debt_first;

        if ($firstOffDebt) {
            $firstOffDebt->old_debt = $office->debt_first;
            $firstOffDebt->save();
        }
    }
    public function repairOffDebts($office_id)
    {
        $office = Office::find($office_id);
        $this->updateFirstOffDebtOldDebt($office_id);
        $offDebts = OffDebt::where('office_id', $office_id)
                            ->where('type_delete', 1)
                            ->orderBy('id', 'asc')
                            ->get();

        $lastNewDebt = $office->debt_first;
        foreach ($offDebts as $index => $offDebt) {

            $newDebt = $offDebt->old_debt - $offDebt->amount_of_debt - $offDebt->discount;
            $offDebt->update(['new_debt' => $newDebt]);
            $lastNewDebt = $newDebt;
            if (isset($offDebts[$index + 1])) {
                $offDebts[$index + 1]->update(['old_debt' => $newDebt]);
            }
        }
        Office::where('id', $office_id)->update(['debt_office' => $lastNewDebt]);
    }
    public function updateFirstOnlyDebtOldDebt($debtor_id)
    {
        $firstOnlyDebt = OnlyDebt::where('debtor_id', $debtor_id)
                                ->where('type_delete', 1)
                                ->orderBy('id', 'asc')
                                ->first();
        $debtor = Debtor::find($debtor_id);

        $debtor->debt_debtor = $debtor->debt_first;

        if ($firstOnlyDebt) {
            $firstOnlyDebt->old_debt = $debtor->debt_first;
            $firstOnlyDebt->save();
        }
    }
    public function repairOnlyDebts($debtor_id)
    {
        $debtor = debtor::find($debtor_id);
        $this->updateFirstOnlyDebtOldDebt($debtor_id);
        $onlyDebts = OnlyDebt::where('debtor_id', $debtor_id)
                            ->where('type_delete', 1)
                            ->orderBy('id', 'asc')
                            ->get();

        $lastNewDebt = $debtor->debt_first;
        foreach ($onlyDebts as $index => $onlyDebt) {

            $newDebt = $onlyDebt->old_debt - $onlyDebt->amount_of_debt - $onlyDebt->discount;
            $onlyDebt->update(['new_debt' => $newDebt]);
            $lastNewDebt = $newDebt;
            if (isset($onlyDebts[$index + 1])) {
                $onlyDebts[$index + 1]->update(['old_debt' => $newDebt]);
            }
        }
        Debtor::where('id', $debtor_id)->update(['debt_debtor' => $lastNewDebt]);
    }
}


<?php

namespace App\Models;

use App\Models\GetDebt;
use App\Models\Invoice;
use App\Traits\NumFilt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, Searchable, Paginateable , NumFilt,HandlesDebtRepairs;

    protected $fillable = [
        'name_customer',
        'debt_customer',
        'debt_first',
        'alert_of_debt',
        'address',
        'phone_number',
        'social_number',
        'notice',
        'type_customer',
        'type_delete',
    ];

    protected static function booted() {
        static::creating(function ($customer) {
            if (is_null($customer->alert_of_debt)) {
                $alert = 15;

                $customer->alert_of_debt = $alert;
            }
            if (is_null($customer->debt_customer)) {
                $Debt = 0;

                $customer->debt_customer = $Debt;
            }
            if (is_null($customer->debt_first)) {
                $customer->debt_first = $customer->debt_customer;
            }
        });
    }


    public function getDebts()
    {
        return $this->hasMany(GetDebt::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}

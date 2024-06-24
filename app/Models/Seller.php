<?php

namespace App\Models;

use App\Models\RepDebt;
use App\Traits\NumFilt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends Model
{
    use HasFactory;

    use HasFactory, Searchable, Paginateable , NumFilt,HandlesDebtRepairs;

    protected $fillable = [
        'name_seller',
        'debt_seller',
        'debt_first',
        'alert_of_debt',
        'address',
        'phone_number',
        'social_number',
        'notice',
        'type_curr',
        'type_delete',
    ];

    protected static function booted() {
        static::creating(function ($seller) {
            if (is_null($seller->debt_seller)) {
                $Debt = 0;
                $seller->debt_seller = $Debt;
            }
            if (is_null($seller->debt_first)) {
                $seller->debt_first = $seller->debt_seller;
            }
        });
    }

    public function repDebts()
    {
        return $this->hasMany(RepDebt::class);
    }
}

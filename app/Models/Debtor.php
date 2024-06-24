<?php

namespace App\Models;

use App\Traits\NumFilt;
use App\Models\OnlyDebt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Debtor extends Model
{
    use HasFactory, Searchable , Paginateable, NumFilt,HandlesDebtRepairs;

    protected $fillable = [
      'name_debtor',
       'debt_debtor',
       'debt_first',
      'address',
      'phone_number',
      'social_number',
       'notice',
       'type_delete',
    ];

    protected static function booted() {
        static::creating(function ($debtor) {
            if (is_null($debtor->debt_debtor)) {
                $Debt = 0;
                $debtor->debt_debtor = $Debt;
            }
            if (is_null($debtor->debt_first)) {
                $debtor->debt_first = $debtor->debt_debtor;
            }
        });
    }
    public function onlyDebts()
{
    return $this->hasMany(OnlyDebt::class);
}
}



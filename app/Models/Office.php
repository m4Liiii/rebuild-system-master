<?php

namespace App\Models;

use App\Models\OffDebt;
use App\Models\RepDebt;
use App\Traits\NumFilt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory, Searchable , Paginateable, NumFilt,HandlesDebtRepairs;

    protected $fillable = [
      'name_office',
       'debt_office',
       'debt_first',
      'address',
      'phone_number',
      'social_number',
       'notice',
       'type_delete',
    ];

    protected static function booted() {
        static::creating(function ($office) {
            if (is_null($office->debt_office)) {
                $Debt = 0;
                $office->debt_office = $Debt;
            }
            if (is_null($office->debt_first)) {
                $office->debt_first = $office->debt_office;
            }
        });
    }
    public function offDebts()
{
    return $this->hasMany(OffDebt::class);
}
public function repdebts()
{
    return $this->hasMany(RepDebt::class);
}
}



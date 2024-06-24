<?php

namespace App\Models;

use App\Models\Debtor;
use App\Traits\NumFilt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\SearchByDate;
use App\Traits\ExactSearchable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlyDebt extends Model
{
    use HasFactory, Searchable, Paginateable,HandlesDebtRepairs, NumFilt , ExactSearchable, SearchByDate;

    protected $fillable = [
        'debtor_id',
        'user_id',
        'old_debt',
        'amount_of_debt',
        'discount',
        'new_debt',
        'name_of_recipient',
        'notice_of_debt',
        'type_delete',
    ];
    protected static function booted()
    {
        static::updating(function($onlyDebt){
            DB::transaction(function() use ($onlyDebt){
                $original = $onlyDebt->getOriginal();
                $diffAmountOfDebt = $onlyDebt->amount_of_debt - $original['amount_of_debt'];
                $diffDiscount = $onlyDebt->discount - $original['discount'];
                $ValueOfDebt = ($diffAmountOfDebt + $diffDiscount);
                $onlyDebt->debtor->decrement('debt_debtor', $ValueOfDebt);
                    OnlyDebt::where('debtor_id', $onlyDebt->debtor_id)
                        ->where('id', '>=', $onlyDebt->id)
                        ->where('type_delete', 1)
                        ->decrement('new_debt', $ValueOfDebt);
                    OnlyDebt::where('debtor_id', $onlyDebt->debtor_id)
                        ->where('id', '>', $onlyDebt->id)
                        ->where('type_delete', 1)
                        ->decrement('old_debt', $ValueOfDebt);
            });
        });
        static::creating(function($onlyDebt){
            DB::transaction(function() use ($onlyDebt){
                $diffAmountOfDebt = $onlyDebt->amount_of_debt;
                $diffDiscount = $onlyDebt->discount;
                $ValueOfDebt = ($diffAmountOfDebt + $diffDiscount);
                $onlyDebt->debtor->decrement('debt_debtor', $ValueOfDebt);
                $onlyDebt->new_debt = $onlyDebt->debtor->debt_debtor;
            });

        });
    }
    public function debtor()
    {
        return $this->belongsTo(Debtor::class);
    }
   public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use App\Models\User;
use App\Models\Office;
use App\Models\RepDebt;
use App\Traits\NumFilt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\SearchByDate;
use App\Traits\ExactSearchable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OffDebt extends Model
{
    use HasFactory, Searchable, Paginateable,HandlesDebtRepairs, NumFilt , ExactSearchable, SearchByDate;

    protected $fillable = [
        'office_id',
        'user_id',
        'old_debt',
        'amount_of_debt',
        'discount',
        'new_debt',
        'name_of_recipient',
        'notice_of_debt',
        'type_delete',
        'curr_op',
        't_curr_op',
        'id_rep_conn'
    ];
    protected static function booted()
    {
        static::updating(function($offDebt){
            DB::transaction(function() use ($offDebt){

                $original = $offDebt->getOriginal();
                $diffAmountOfDebt = $offDebt->amount_of_debt - $original['amount_of_debt'];
                $diffDiscount = $offDebt->discount - $original['discount'];
                $ValueOfDebt = ($diffAmountOfDebt + $diffDiscount);

                    $offDebt->office->decrement('debt_office', $ValueOfDebt);



                    OffDebt::where('office_id', $offDebt->office_id)
                        ->where('id', '>=', $offDebt->id)
                        ->where('type_delete', 1)
                        ->decrement('new_debt', $ValueOfDebt);

                    OffDebt::where('office_id', $offDebt->office_id)
                        ->where('id', '>', $offDebt->id)
                        ->where('type_delete', 1)
                        ->decrement('old_debt', $ValueOfDebt);



            });

        });
        static::creating(function($offDebt){
            DB::transaction(function() use ($offDebt){
                $diffAmountOfDebt = $offDebt->amount_of_debt;
                $diffDiscount = $offDebt->discount;
                $ValueOfDebt = ($diffAmountOfDebt + $diffDiscount);
                $offDebt->office->decrement('debt_office', $ValueOfDebt);
                $offDebt->new_debt = $offDebt->office->debt_office;
            });

        });
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
   public function user()
    {
        return $this->belongsTo(User::class);
    }
}

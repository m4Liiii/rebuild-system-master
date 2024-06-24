<?php

namespace App\Models;

use App\Models\User;
use App\Models\Invoice;
use App\Traits\NumFilt;
use App\Models\Customer;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\SearchByDate;
use App\Traits\ExactSearchable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GetDebt extends Model
{
    use HasFactory, Searchable, Paginateable,HandlesDebtRepairs, NumFilt , ExactSearchable, SearchByDate;
    protected $fillable = [
        'customer_id',
        'user_id',
        'old_debt',
        'delivery',
        'amount_of_debt',
        'new_debt',
        'discount',
        'curr',
        'name_of_recipient',
        'name_of_office',
        'notice_of_debt',
        'created_at',
        'type_notice',
        'type_price',
        'type_amount',
        'type_invoice',
        'amount_dollar',
        'amount_dinar',
        'type_delete',
        's_id',
    ];


    protected static function booted()
    {
        static::updating(function ($getDebt) {
            DB::transaction(function () use ($getDebt) {
                $original = $getDebt->getOriginal();
                $diffAmountOfDebt = $getDebt->amount_of_debt - $original['amount_of_debt'];
                $diffDiscount = $getDebt->discount - $original['discount'];
                $decrementValueOfDebt = ($diffAmountOfDebt + $diffDiscount);

                if ($getDebt->customer) {
                    $getDebt->customer->decrement('debt_customer', $decrementValueOfDebt);
                }

                if ($getDebt->customer_id) {
                    GetDebt::where('customer_id', $getDebt->customer_id)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->where('type_delete', 1)
                        ->decrement('new_debt', $decrementValueOfDebt);

                    GetDebt::where('customer_id', $getDebt->customer_id)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->where('type_delete', 1)
                        ->decrement('old_debt', $decrementValueOfDebt);
                }

                GetDebt::where('customer_id', $getDebt->customer_id)
                ->where('s_id', $getDebt->s_id)
                ->where('type_delete', 1)
                ->decrement('new_debt', ($decrementValueOfDebt));
            });

        });
    }
    
    //     static::deleting(function ($getDebt) {
    //         DB::transaction(function () use ($getDebt) {

    //             $diffAmountOfDebt = $getDebt->amount_of_debt;
    //             $diffDiscount = $getDebt->discount;
    //             $incrementValueOfDebt = ($diffAmountOfDebt + $diffDiscount);

    //             if ($getDebt->customer) {
    //                 $getDebt->customer->increment('debt_customer', $incrementValueOfDebt);
    //             }

    //             GetDebt::where('customer_id', $getDebt->customer_id)
    //             ->where('id', '>', $getDebt->id)
    //             ->increment('new_debt', $incrementValueOfDebt);

    //             GetDebt::where('customer_id', $getDebt->customer_id)
    //                 ->where('id', '>', $getDebt->id)
    //                 ->increment('old_debt', $incrementValueOfDebt);

    //         });
    //     });
    // }


        public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}

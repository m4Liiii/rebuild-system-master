<?php

namespace App\Models;

use App\Models\User;
use App\Models\RepDebt;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\SearchByDate;
use App\Traits\ExactSearchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceBuy extends Model
{
    use HasFactory, Searchable, Paginateable, ExactSearchable, SearchByDate;

    protected $fillable = [
        'rep_debt_id',
        'seller_id',
        'product_id',
        'category_id',
        'user_id',
        'name',
        'code',
        'box',
        'quantity_box',
        'quantity',
        'p_buy',
        'p_buy_curr',
        'expense',
        'expense_curr',
        'p_all_buy',
        'p_all_buy_curr',
        'price_all',
        'price_all_curr',
        'sell_ko',
        'sell_tak',
    ];

    protected static function booted()
    {
    static::created(function ($invoiceBuy) {
        DB::transaction(function () use ($invoiceBuy) {
        // Update the 'new_debt' and 'old_debt' fields of the related 'RepDebt' record
        $repDebt = $invoiceBuy->RepDebt;
        $repDebt->new_debt + $invoiceBuy->price_all;
        $repDebt->old_debt + $invoiceBuy->price_all;
        $repDebt->save();

        // Update 'new_debt' and 'old_debt' fields of all 'RepDebt' records with the same 'seller_id' but greater 'id'
        if ($repDebt->seller_id !== null) {

            RepDebt::where('seller_id', $repDebt->seller_id)
            ->where('s_id', '>', $repDebt->s_id)
            ->where('type_delete', 1)
            ->increment('new_debt', $invoiceBuy->price_all);


            RepDebt::where('seller_id', $repDebt->seller_id)
            ->where('s_id', '>', $repDebt->s_id)
            ->where('type_delete', 1)
            ->increment('old_debt', $invoiceBuy->price_all);


        }
            RepDebt::where('seller_id', $repDebt->seller_id)
            ->where('s_id', '=', $repDebt->s_id)
            ->where('type_delete', 1)
            ->increment('new_debt', $invoiceBuy->price_all);


            if ($repDebt->seller) {
                $repDebt->seller->increment('debt_seller', $invoiceBuy->price_all);
            }





    });
});
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function repDebt()
    {
        return $this->belongsTo(RepDebt::class);
    }
}

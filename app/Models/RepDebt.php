<?php

namespace App\Models;

use App\Models\User;
use App\Models\Office;
use App\Models\Seller;
use App\Traits\NumFilt;
use App\Models\InvoiceBuy;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\SearchByDate;
use App\Traits\ExactSearchable;
use App\Traits\HandlesDebtRepairs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepDebt extends Model
{
    use HasFactory, Searchable, Paginateable,HandlesDebtRepairs, NumFilt , ExactSearchable, SearchByDate;
    protected $fillable = [
        'id',
        's_id',
        'seller_id',
        'user_id',
        'office_id',
        'old_debt',
        'amount_of_debt',
        'amount_curr',
        'new_debt',
        'discount',
        'discount_curr',
        'created_at',
        'type_curr',
        'type_delete',
        'type_invoice',
        'type_notice',
        'curr',
        'name_of_recipient',
        'name_of_office',
        'notice_of_debt',
        'id_off_conn',


     ];


     protected static function booted()
     {
         static::updating(function ($repDebt) {
             DB::transaction(function () use ($repDebt) {

                $original = $repDebt->getOriginal();
                $diffAmountOfDebt = $repDebt->amount_of_debt - $original['amount_of_debt'];
                $diffDiscount = $repDebt->discount - $original['discount'];
                $decrementValueOfDebt = ($diffAmountOfDebt + $diffDiscount);



                if ($repDebt->seller) {
                    $repDebt->seller->decrement('debt_seller', $decrementValueOfDebt);
                }

                if ($repDebt->seller_id) {
                    RepDebt::where('seller_id', $repDebt->seller_id)
                        ->where('s_id', '>', $repDebt->s_id)
                        ->where('type_delete', 1)
                        ->decrement('new_debt', $decrementValueOfDebt);

                    RepDebt::where('seller_id', $repDebt->seller_id)
                        ->where('s_id', '>', $repDebt->s_id)
                        ->where('type_delete', 1)
                        ->decrement('old_debt', $decrementValueOfDebt);

                        // if ($repDebt->id_off_conn) {
                        //     $offDebt = OffDebt::find($repDebt->id_off_conn);
                        //     if ($offDebt) {
                        //         $offDebt->update([
                        //             'amount_of_debt' => $RevAmount,
                        //         ]);
                        //     }
                        // }
                }

                RepDebt::where('seller_id', $repDebt->seller_id)
                ->where('s_id', $repDebt->s_id)
                ->where('type_delete', 1)
                ->decrement('new_debt', ($decrementValueOfDebt));

             });
            });
        }
     public function user()
     {
         return $this->belongsTo(User::class);
     }


     public function seller()
     {
         return $this->belongsTo(Seller::class);
     }
     public function office()
     {
         return $this->belongsTo(Office::class);
     }


    public function invoiceBuys()
    {
        return $this->hasMany(InvoiceBuy::class);
    }

}

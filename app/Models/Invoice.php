<?php

namespace App\Models;

use App\Models\User;
use App\Models\GetDebt;
use App\Models\Product;
use App\Models\Customer;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use App\Traits\SearchByDate;
use App\Traits\ExactSearchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory, Searchable, Paginateable, ExactSearchable, SearchByDate;


    protected $fillable = [
        'get_debt_id',
        'customer_id',
        'product_id',
        'category_id',
        'user_id',
        'name',
        'code',
        'box',
        'quantity_box',
        'quantity',
        'profit',
        'price',
        'price_all',
    ];
    protected static function booted()
    {
        static::created(function ($invoice) {
            DB::transaction(function () use ($invoice) {
            $getDebt = $invoice->getDebt;
            $getDebt->new_debt += $invoice->price_all;
            $getDebt->save();
            if ($getDebt->customer_id !== null) {
                GetDebt::where('customer_id', $getDebt->customer_id)
                ->where('s_id', '>', $getDebt->s_id)
                ->where('type_delete', 1)
                ->increment('new_debt', $invoice->price_all);

                GetDebt::where('customer_id', $getDebt->customer_id)
                ->where('s_id', '>', $getDebt->s_id)
                ->where('type_delete', 1)
                ->increment('old_debt', $invoice->price_all);

            }
                if ($getDebt->customer) {
                    $getDebt->customer->increment('debt_customer', $invoice->price_all);
                }
                $product = $invoice->product;
                if($product) {
                    $product->quantity_of_store -= $invoice->quantity;
                    $product->save();
                } else {}
            });
            });

            static::updating(function ($invoice) {
                DB::transaction(function () use ($invoice) {
                    $oldPriceAll = $invoice->getOriginal('price_all');
                    $oldQuantity = $invoice->getOriginal('quantity');
                    $priceAllDiff = $invoice->price_all - $oldPriceAll;
                    $quantityDiff = $invoice->quantity - $oldQuantity;
                    $getDebt = $invoice->getDebt;
                    $getDebt->new_debt += $priceAllDiff;
                    $getDebt->save();
                    if ($getDebt->customer_id !== null) {
                        GetDebt::where('customer_id', $getDebt->customer_id)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->where('type_delete', 1)
                        ->increment('new_debt', $priceAllDiff);
                        GetDebt::where('customer_id', $getDebt->customer_id)
                        ->where('s_id', '>', $getDebt->s_id)
                        ->where('type_delete', 1)
                        ->increment('old_debt', $priceAllDiff);

                    }
                    if ($getDebt->customer) {
                        $getDebt->customer->increment('debt_customer', $priceAllDiff);
                    }
                    $product = $invoice->product;
                    if ($product) {
                        $product->quantity_of_store -= $quantityDiff;
                        $product->save();
                    } else {}
                });
            });
            static::deleting(function ($invoice) {
                DB::transaction(function () use ($invoice) {
                $getDebt = $invoice->getDebt;
                $getDebt->new_debt -= $invoice->price_all;
                $getDebt->save();
                if ($getDebt->customer_id !== null) {
                    GetDebt::where('customer_id', $getDebt->customer_id)
                           ->where('s_id', '>', $getDebt->s_id)
                           ->where('type_delete', 1)
                           ->decrement('new_debt', $invoice->price_all);
                    GetDebt::where('customer_id', $getDebt->customer_id)
                           ->where('s_id', '>', $getDebt->s_id)
                           ->where('type_delete', 1)
                           ->decrement('old_debt', $invoice->price_all);
                }
                if ($getDebt->customer) {
                    $getDebt->customer->decrement('debt_customer', $invoice->price_all);
                }
                        $product = $invoice->product;
                        if($product) {
                            $product->quantity_of_store += $invoice->quantity;
                            $product->save();
                        } else {}
                    });
            });


        }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDebt()
    {
        return $this->belongsTo(GetDebt::class);
    }
    public function product()
{
    return $this->belongsTo(Product::class);
}

public function customer()
{
    return $this->belongsTo(Customer::class);
}

}

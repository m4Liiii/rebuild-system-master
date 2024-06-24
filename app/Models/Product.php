<?php

namespace App\Models;

use App\Models\Category;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Searchable, Paginateable;

    protected $fillable = [
        'category_id',
        'name_of_product',
        'code_of_product',
        'alert_of_out',
        'quantity_of_box',
        'quantity_of_store',
        'price_of_buy',
        'price_of_sell_tak',
        'price_of_sell_ko',
        'ShowSelect',
        'fix_number',
        'type_delete',
    ];
    protected static function booted() {
        static::creating(function ($product) {
            // Check if code is null or not set
            if (is_null($product->code_of_product)) {
                $nextCode = 1; // Start from 1

                while (self::where('code_of_product', $nextCode)->exists()) {
                    $nextCode++; // Increment until you find a non-existing code
                }

                $product->code_of_product = $nextCode;
            }
            if (is_null($product->alert_of_out)) {
                $nextCode = 15;
                $product->alert_of_out = $nextCode;
            }

            if (is_null($product->fix_number)) {
                $nextFix_number = 0;
                $product->fix_number = $nextFix_number;
            }
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}

<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\Searchable;
use App\Traits\Paginateable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Searchable, Paginateable;

    protected $fillable = [
        'name',
        'code',
        'type_delete',
    ];


    protected static function booted() {
        static::creating(function ($category) {
            if (is_null($category->code)) {
                $nextCode = 1;
                while (self::where('code', $nextCode)->exists()) {
                    $nextCode++;
                }
                $category->code = $nextCode;
            }


        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

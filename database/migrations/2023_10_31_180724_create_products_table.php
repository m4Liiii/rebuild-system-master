<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name_of_product');
            $table->string('code_of_product');
            $table->integer('quantity_of_box');
            $table->integer('quantity_of_store');
            $table->integer('fix_number');
            $table->integer('alert_of_out');
            $table->decimal('price_of_buy', 27, 3);
            $table->decimal('price_of_sell_tak', 27, 3);
            $table->decimal('price_of_sell_ko', 27, 3);
            $table->integer('ShowSelect');
            $table->tinyInteger('type_delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

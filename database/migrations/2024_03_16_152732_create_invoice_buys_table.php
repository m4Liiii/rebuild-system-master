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
        Schema::create('invoice_buys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rep_debt_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('code');
            $table->integer('box');
            $table->integer('quantity_box');
            $table->integer('quantity');

            $table->decimal('p_buy', 27, 3);
            $table->decimal('p_buy_curr', 27, 3);

            $table->decimal('expense', 27, 3);
            $table->decimal('expense_curr', 27, 3);


            $table->decimal('p_all_buy', 27, 3);
            $table->decimal('p_all_buy_curr', 27, 3);



            $table->decimal('price_all', 27, 3);
            $table->decimal('price_all_curr', 27, 3);

            $table->decimal('sell_ko', 27, 3);
            $table->decimal('sell_tak', 27, 3);

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_buys');
    }
};

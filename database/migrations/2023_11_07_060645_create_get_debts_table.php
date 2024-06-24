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
        Schema::create('get_debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_id')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('old_debt', 27, 3);
            $table->decimal('amount_of_debt', 27, 3);
            $table->decimal('amount_dollar', 27, 3);
            $table->Integer('amount_dinar');
            $table->decimal('discount', 27, 3);
            $table->decimal('new_debt', 27, 3);
            $table->text('name_of_recipient')->nullable();
            $table->text('name_of_office')->nullable();
            $table->text('notice_of_debt')->nullable();
            $table->Integer('curr');
            $table->tinyInteger('delivery');
            $table->tinyInteger('type_notice');
            $table->tinyInteger('type_price');
            $table->tinyInteger('type_amount');
            $table->tinyInteger('type_invoice');
            $table->tinyInteger('type_delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('get_debts');
    }
};

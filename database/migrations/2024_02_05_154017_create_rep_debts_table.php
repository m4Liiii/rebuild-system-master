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
        Schema::create('rep_debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_id')->unique();
            $table->foreignId('seller_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('office_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('old_debt', 27, 3);
            $table->decimal('amount_of_debt', 27, 3);
            $table->decimal('amount_curr', 27, 3);
            $table->decimal('discount', 27, 3);
            $table->decimal('discount_curr', 27, 3);
            $table->decimal('new_debt', 27, 3);
            $table->text('name_of_recipient')->nullable();
            $table->text('name_of_office')->nullable();
            $table->text('notice_of_debt')->nullable();
            $table->Integer('curr');
            $table->tinyInteger('type_curr');
            $table->tinyInteger('type_invoice');
            $table->tinyInteger('type_notice');
            $table->tinyInteger('type_delete');
            $table->integer('id_off_conn')->defualt(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rep_debts');
    }
};

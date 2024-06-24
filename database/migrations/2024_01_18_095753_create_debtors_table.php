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
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();
            $table->string('name_debtor');
            $table->decimal('debt_debtor', 27, 3);
            $table->decimal('debt_first', 27, 3);
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('social_number')->nullable();
            $table->text('notice')->nullable();
            $table->tinyInteger('type_delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debtors');
    }
};

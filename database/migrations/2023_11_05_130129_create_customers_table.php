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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name_customer');
            $table->decimal('debt_customer', 27, 3);
            $table->decimal('debt_first', 27, 3);
            $table->integer('alert_of_debt')->default(0);
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('social_number')->nullable();
            $table->text('notice')->nullable();
            $table->integer('type_customer');
            $table->tinyInteger('type_delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

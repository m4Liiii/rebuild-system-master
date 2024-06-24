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
        Schema::create('off_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('old_debt', 27, 3);
            $table->decimal('amount_of_debt', 27, 3);
            $table->decimal('discount', 27, 3);
            $table->decimal('new_debt', 27, 3);
            $table->text('name_of_recipient')->nullable();
            $table->text('notice_of_debt')->nullable();
            $table->integer('curr_op')->defualt(0);
            $table->tinyinteger('t_curr_op')->defualt(0);
            $table->tinyInteger('type_delete');
            $table->integer('id_rep_conn')->defualt(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('off_debts');
    }
};

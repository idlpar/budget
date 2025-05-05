<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_head_id')->constrained()->onDelete('cascade');
            $table->decimal('debit', 15, 2)->default(0.00);
            $table->decimal('credit', 15, 2)->default(0.00);
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->timestamps();

            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('transaction_entries', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['account_head_id']);
            $table->dropForeign(['expense_id']);
        });
        Schema::dropIfExists('transaction_entries');
    }
}

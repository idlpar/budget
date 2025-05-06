<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_head_id')->nullable();
            $table->unsignedBigInteger('budget_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('serial'); // Not primary key, will be managed in controller
            $table->string('financial_year')->nullable();
            $table->unique(['serial', 'financial_year']);
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->foreign('account_head_id')->references('id')->on('account_heads')->onDelete('set null');
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['account_head_id']);
            $table->dropForeign(['budget_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['transaction_id']);
        });
        Schema::dropIfExists('expenses');
    }
}

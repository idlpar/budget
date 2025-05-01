<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('expense_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained()->onDelete('cascade');
            $table->foreignId('approver_id')->constrained('users')->onDelete('cascade');
            $table->enum('level', ['section', 'department', 'division']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('expense_approvals', function (Blueprint $table) {
            $table->dropForeign(['expense_id']);
            $table->dropForeign(['approver_id']);
        });
        Schema::dropIfExists('expense_approvals');
    }
}

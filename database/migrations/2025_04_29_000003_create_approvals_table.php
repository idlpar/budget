<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_head_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('section_id');
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('account_head_id')->references('id')->on('account_heads')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}

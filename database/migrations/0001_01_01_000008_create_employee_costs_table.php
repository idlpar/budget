<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCostsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_costs', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->decimal('cost', 15, 2);
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_costs');
    }
}

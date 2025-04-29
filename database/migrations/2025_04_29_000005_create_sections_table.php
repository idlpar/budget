<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
}

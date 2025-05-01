<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_head_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_head_id')->constrained()->onDelete('cascade');
            $table->string('field_name');
            $table->string('old_value');
            $table->string('new_value');
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_head_changes');
    }
};

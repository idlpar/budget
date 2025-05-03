<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('field_name');
            $table->text('old_value')->nullable();
            $table->text('new_value');
            $table->foreignId('changed_by')->constrained('users')->onDelete('set null');
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['user_id', 'field_name', 'changed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_changes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions_entries', function (Blueprint $table) {
            $table->foreignId('expense_id')->nullable()->constrained('expenses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transactions_entries', function (Blueprint $table) {
            $table->dropForeign(['expense_id']);
            $table->dropColumn('expense_id');
        });
    }
};

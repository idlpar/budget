<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('previous_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->timestamp('name_changed_at')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->enum('role', ['admin', 'division_head', 'department_head', 'section_head', 'staff'])->default('staff'); // Added
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null'); // Added
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null'); // Added
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null'); // Added
            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('name_changed_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

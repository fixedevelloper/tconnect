<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->integer('user_type')->default(1)->comment("0:admin,1:other");
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('activated')->default(false);
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('document_id')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_recto')->nullable();
            $table->string('document_verso')->nullable();
            $table->boolean('phone_verified')->default(false);
            $table->boolean('email_verified')->default(false);
            $table->string('unique_number')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date_born')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(App\Helpers\Helper::STATUSPENDING);
            $table->integer('place')->default(1);
            $table->decimal('amount',14,2)->default(0.0);
            $table->string('method_payment')->nullable();
            $table->foreignId('trajet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('passager_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

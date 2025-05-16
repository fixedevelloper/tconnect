<?php

use App\Helpers\Helper;
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
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->decimal('price',14,2);
            $table->integer('place')->default(1);
            $table->integer('place_rest')->default(1);
            $table->date('date_from');
            $table->date('date_to');
            $table->time('time_from');
            $table->time('time_to');
            $table->string('quarter_to')->nullable();
            $table->string('quarter_from')->nullable();
            $table->integer('status')->default(Helper::STATUSPENDING);
            $table->foreignId('city_from_id')->nullable()->constrained('cities','id')->nullOnDelete();
            $table->foreignId('city_to_id')->nullable()->constrained('cities','id')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vehicule_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};

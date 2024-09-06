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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('ptype_id');
            $table->string('amenitie_id');
            $table->integer('agent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('code');
            $table->string('min_price')->nullable();
            $table->string('max_price')->nullable();
            $table->string('size')->nullable();
            $table->string('video')->nullable();
            $table->string('property_status')->nullable();
            $table->string('property_thumbnail');
            $table->text('short_des')->nullable();
            $table->text('long_des')->nullable();
            $table->string('bedrooms')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('garage')->nullable();
            $table->string('garage_size')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('featured')->nullable();
            $table->string('hot')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

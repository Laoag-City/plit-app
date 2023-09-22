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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id('business_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('classification_id');
            $table->string('business_id_number')->unique();
            $table->string('business_name');
            $table->string('location_coordinates');
            $table->timestamps();

            $table->foreign('owner_id')
                    ->references('owner_id')
                    ->on('owners')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('address_id')
                    ->references('address_id')
                    ->on('addresses')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('classification_id')
                    ->references('classification_id')
                    ->on('classifications')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

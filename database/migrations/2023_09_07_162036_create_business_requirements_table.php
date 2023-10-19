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
        Schema::create('business_requirements', function (Blueprint $table) {
            $table->id('business_requirement_id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('requirement_id');
            $table->string('requirement_params_value')->nullable();
            $table->boolean('complied');
            $table->timestamps();

            $table->foreign('business_id')
                    ->references('business_id')
                    ->on('businesses')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('requirement_id')
                    ->references('requirement_id')
                    ->on('requirements')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_requirements');
    }
};

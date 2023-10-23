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
        Schema::create('remarks', function (Blueprint $table) {
            $table->id('remark_id');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('business_id');
            $table->string('remarks');
            $table->unsignedTinyInteger('inspection_count');
            $table->timestamps();

            $table->foreign('office_id')
                    ->references('office_id')
                    ->on('offices')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('business_id')
                    ->references('business_id')
                    ->on('businesses')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remarks');
    }
};

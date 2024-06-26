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
            //$table->unsignedBigInteger('classification_id');
            $table->string('id_no')->unique();
            $table->string('name');
            $table->string('location_specifics')->nullable();
            $table->string('coordinates')->nullable();
            $table->unsignedTinyInteger('inspection_count')->default(0);
            $table->date('inspection_date')->nullable();
            $table->date('re_inspection_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table->index('name');

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

            /*
            $table->foreign('classification_id')
                    ->references('classification_id')
                    ->on('classifications')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            */
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

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
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->boolean('pending');
            $table->integer('sub_amount');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('diamond_id');
            $table->timestamps();

            $table->foreign('user_id')->references('_id')->on('users')->onDelete('cascade');
            $table->foreign('diamond_id')->references('_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};

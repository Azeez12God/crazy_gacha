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
        Schema::create('prize_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('prize_id')->constrained();
            $table->integer('count');
            $table->primary(['user_id', 'prize_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

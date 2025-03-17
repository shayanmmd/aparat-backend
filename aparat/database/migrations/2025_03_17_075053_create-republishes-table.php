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
        Schema::create('republishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user-id')->nullable();
            $table->unsignedBigInteger('video-id');
            $table->timestamps();

            $table->foreign('user-id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('video-id')
                ->references('id')
                ->on('videos')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('republishes');
    }
};

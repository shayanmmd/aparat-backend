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
        Schema::create('playlist-videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('video-id');
            $table->unsignedBigInteger('playlist-id');

            $table->foreign('video-id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('playlist-id')
                ->references('id')
                ->on('playlists')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist-videos');
    }
};

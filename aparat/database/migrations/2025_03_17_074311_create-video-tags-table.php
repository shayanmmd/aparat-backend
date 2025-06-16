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
        Schema::create('video-tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('video-id');
            $table->unsignedBigInteger('tag-id');
            
            $table->foreign('video-id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tag-id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video-tags');
    }
};

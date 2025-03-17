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
        Schema::create('report-videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('video-id');
            $table->unsignedBigInteger('report-category-id');
            $table->unsignedBigInteger('user-id');
            $table->text('info');
            $table->integer('first-time')->nullable();
            $table->integer('second-time')->nullable();
            $table->integer('third-time')->nullable();
            $table->timestamps();

            $table->foreign('video-id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('report-category-id')
                ->references('id')
                ->on('report-categories')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user-id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report-videos');
    }
};

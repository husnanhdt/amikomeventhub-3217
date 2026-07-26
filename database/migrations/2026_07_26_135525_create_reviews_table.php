<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned(); // 1-5 bintang
            $table->text('review')->nullable();
            $table->timestamp('review_date')->nullable();
            $table->timestamps();
            
            // Pastikan 1 user hanya bisa review 1 event sekali
            $table->unique(['user_id', 'event_id']);
            
            // Index untuk performa
            $table->index('event_id');
            $table->index(['event_id', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
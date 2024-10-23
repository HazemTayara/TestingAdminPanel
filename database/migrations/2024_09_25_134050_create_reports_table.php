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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('product_id')->references('id') ->on('products')
             ->onDelete('cascade');
            $table->foreignId('researcher_id')->references('id')->on('researchers')
            ->onDelete('cascade');
            $table->string('title');
            $table->string('file');
            $table->enum('status',['pending','accept','reject','done'])->default('pending');
            $table->boolean('review_status');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')
            ->onDelete('cascade');
            $table->text('canceled_note');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

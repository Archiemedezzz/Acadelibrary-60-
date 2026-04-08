<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folder_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_folder_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['personal_folder_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folder_items');
    }
};

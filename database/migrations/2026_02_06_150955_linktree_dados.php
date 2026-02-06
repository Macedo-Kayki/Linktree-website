<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('linktreedados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('linktree_id'); 
            $table->string('name_link', 100);
            $table->string('url_link', 300);
            $table->string('icon')->nullable(); // Ícone do botão
            $table->foreign('linktree_id')->references('id')->on('linktrees')->onDelete('cascade');
            $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linktreedados');
    }
};

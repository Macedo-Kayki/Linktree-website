<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('linktrees', function (Blueprint $table) {
            $table->string('bg_image')->nullable();
            $table->string('text_color')->default('#ffffff')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('linktrees', function (Blueprint $table) {
            $table->dropColumn(['bg_image', 'text_color']);
        });
    }
};

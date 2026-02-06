<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add background color to linktrees table
        Schema::table('linktrees', function (Blueprint $table) {
            $table->string('bg_color')->default('#1f2937')->nullable();
        });

        // Add button color to linktreedados table
        Schema::table('linktreedados', function (Blueprint $table) {
            $table->string('button_color')->default('#ffffff')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('linktrees', function (Blueprint $table) {
            $table->dropColumn('bg_color');
        });

        Schema::table('linktreedados', function (Blueprint $table) {
            $table->dropColumn('button_color');
        });
    }
};

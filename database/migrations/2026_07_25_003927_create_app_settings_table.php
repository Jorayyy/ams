<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert initial default pristine values into the matrix
        \Illuminate\Support\Facades\DB::table('app_settings')->insert([
            ['key' => 'hero_title', 'value' => 'Student Attendance Management System'],
            ['key' => 'hero_subtitle', 'value' => 'An institutional framework engineered for accurate rolling count records, dynamic analytics reporting, and structural access metrics.'],
            ['key' => 'hero_image', 'value' => ''], // Empty indicates fallback standard CSS gradient banner
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};

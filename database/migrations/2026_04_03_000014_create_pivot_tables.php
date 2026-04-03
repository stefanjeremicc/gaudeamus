<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listing_skill', function (Blueprint $table) {
            $table->foreignId('job_listing_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->primary(['job_listing_id', 'skill_id']);
        });

        Schema::create('skill_student_profile', function (Blueprint $table) {
            $table->foreignId('student_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->primary(['student_profile_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_student_profile');
        Schema::dropIfExists('job_listing_skill');
    }
};

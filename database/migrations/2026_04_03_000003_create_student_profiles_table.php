<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();
            $table->enum('employment_status', ['student', 'unemployed'])->default('student');
            $table->string('university')->nullable();
            $table->string('faculty')->nullable();
            $table->tinyInteger('year_of_study')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('region_id')->nullable()->constrained();
            $table->json('bio')->nullable();
            $table->string('jmbg')->nullable();
            $table->string('bank_account')->nullable();
            $table->date('cooperative_member_since')->nullable();
            $table->boolean('is_active_member')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};

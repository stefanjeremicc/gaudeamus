<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'accepted', 'rejected', 'withdrawn'])->default('pending');
            $table->text('employer_notes')->nullable();
            $table->timestamps();

            $table->unique(['job_listing_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('description');
            $table->json('requirements')->nullable();
            $table->json('additional_conditions')->nullable();
            $table->foreignId('job_category_id')->constrained();
            $table->foreignId('region_id')->constrained();
            $table->string('city')->nullable();
            $table->unsignedSmallInteger('positions_count')->default(1);
            $table->decimal('hourly_rate_min', 8, 2)->nullable();
            $table->decimal('hourly_rate_max', 8, 2)->nullable();
            $table->string('currency', 3)->default('RSD');
            $table->unsignedSmallInteger('working_hours_per_week')->nullable();
            $table->enum('shift_type', ['morning', 'afternoon', 'night', 'flexible'])->default('flexible');
            $table->enum('ad_type', ['full_time', 'part_time', 'seasonal', 'one_time']);
            $table->enum('employment_status_required', ['student', 'unemployed', 'both'])->default('both');
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'active', 'closed', 'expired'])->default('draft');
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('applications_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('region_id');
            $table->index('job_category_id');
            $table->index('company_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};

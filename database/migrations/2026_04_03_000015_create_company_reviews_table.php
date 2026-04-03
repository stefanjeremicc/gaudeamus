<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->unique(['company_id', 'user_id']);
        });

        // Add avg_rating column to companies
        Schema::table('companies', function (Blueprint $table) {
            $table->decimal('avg_rating', 2, 1)->default(0)->after('is_verified');
            $table->unsignedInteger('reviews_count')->default(0)->after('avg_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_reviews');
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['avg_rating', 'reviews_count']);
        });
    }
};

<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignId('job_type_id')->constrained()->cascadeOnDelete();
            $table->integer('vacancy');
            $table->integer('salary')->nullable();
            $table->string('location');
            $table->text('description')->nullable();
            $table->text('Benefits')->nullable();
            $table->text('Responsibility')->nullable();
            $table->text('Qualifications')->nullable();
            $table->text('Keywords')->nullable();
            $table->string('experience');
            $table->string('company_name');
            $table->string('company_location')->nullable();
            $table->string('company_website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

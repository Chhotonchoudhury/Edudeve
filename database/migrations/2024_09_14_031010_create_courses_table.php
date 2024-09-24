<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->string('title'); // Course title
      $table->text('description'); // Detailed course description
      $table->string('instructor')->nullable(); // Instructor name
      $table->string('duration_type'); // Duration type (e.g., days, weeks, months, years)
      $table->integer('duration_value')->unsigned(); // Duration value (e.g., 6)
      $table->string('level'); // Course difficulty level (e.g., Beginner, Intermediate, Advanced)
      $table->decimal('admission_fee', 8, 2); // Admission fee
      $table->decimal('course_fee', 8, 2); // Course fee
      $table->decimal('total_fee', 10, 2)->storedAs('admission_fee + course_fee'); // Total package fee
      $table->bigInteger('category_id'); // Course category (e.g., Science, Arts)
      $table->bigInteger('university_id');
      $table
        ->integer('max_students')
        ->unsigned()
        ->nullable();
      $table->date('start_date')->nullable(); // Course start date
      $table->date('end_date')->nullable(); // Course end date
      $table->string('language')->default('English'); // Course language
      $table->string('thumbnail')->nullable(); // Path to the course thumbnail image
      $table->string('brochure')->nullable(); // Path to the course brochure (PDF or image)
      $table->json('attachments')->nullable(); // Extra attachments as JSON (store multiple file paths)
      $table->string('status')->default('draft'); // Course status (e.g., draft, published)
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('courses');
  }
};

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
    Schema::create('student_qualifications', function (Blueprint $table) {
      $table->id();
      $table
        ->foreignId('student_id')
        ->constrained()
        ->onDelete('cascade'); // Assuming you have a students table
      $table->string('degree'); // e.g., Bachelor of Science
      $table->year('passing_year'); // e.g., 2023
      $table->decimal('cgpa', 3, 2); // e.g., 3.80
      $table->string('institution'); // e.g., Example University
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_qualifications');
  }
};

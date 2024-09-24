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
    Schema::create('course_requirements', function (Blueprint $table) {
      $table->id();
      $table
        ->foreignId('course_id')
        ->constrained()
        ->onDelete('cascade'); // Relation to the courses table
      $table->string('title'); // Title of the requirement (e.g., "Transcripts", "ID Proof")
      $table->text('description')->nullable(); // Description of the requirement
      $table->boolean('is_required')->default(true); // Indicate if the requirement is mandatory
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_requirements');
  }
};

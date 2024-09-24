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
    Schema::create('student_activities', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('student_id');
      $table->string('activity_type');
      $table->date('activity_date'); // Date when the activity occurred
      $table->time('activity_time')->nullable(); // Time when the activity occurred
      $table->string('contact_person')->nullable(); // Name of the person involved in the activity
      $table->string('contact_number')->nullable(); // Phone number or other contact information
      $table->string('result')->nullable();
      $table->enum('status', ['Pending', 'Completed', 'Cancelled'])->default('Pending'); // Status of the activity
      $table->string('attachment')->nullable();
      $table->enum('direction', ['incoming', 'outgoing']);
      $table->text('remarks')->nullable();
      $table->bigInteger('entry_id');
      $table->bigInteger('updated_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_activities');
  }
};

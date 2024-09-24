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
    Schema::create('students', function (Blueprint $table) {
      $table->id();
      $table->string('student_id')->unique(); // Unique student ID field
      $table->string('name');
      $table->string('email')->unique();
      $table->bigInteger('country_code');
      $table->string('country')->nullable(true);
      $table->bigInteger('phone');
      $table->string('city')->nullable(true);
      $table->text('address')->nullable(true);
      $table->date('dob')->nullable(true);
      $table->string('age')->nullable(true);
      $table->string('photo')->nullable(true);
      $table->string('interested_category')->nullable(true);
      $table->string('interested_course')->nullable(true);
      $table->string('last_degree')->nullable(true);
      $table->bigInteger('lead_source')->nullable(true);
      $table->tinyInteger('lead_online')->default('0');
      // Add 'address' field
      $table->bigInteger('course_id')->nullable(true);
      $table->bigInteger('university_id')->nullable(true);

      $table->tinyInteger('enq_id')->nullable(true);

      $table->tinyInteger('status_id')->nullable(true);
      $table->tinyInteger('emg_status')->nullable(true);
      $table->tinyInteger('payment_status')->nullable(true);

      $table->tinyInteger('process_status')->default('0');
      $table->tinyInteger('priority')->default(0);

      $table->tinyInteger('active_status')->default('1');
      $table->tinyInteger('verify')->default('0');
      $table->tinyInteger('verified_by')->nullable(true);
      $table->tinyInteger('refer_to')->nullable(true);

      $table->tinyInteger('archive_status')->default('0');

      $table->timestamp('email_verified_at')->nullable();
      $table->string('password')->nullable();

      $table->text('remarks')->nullable(true);
      $table->string('passport_no')->nullable(true);
      $table->text('doc')->nullable(true);
      $table->text('notify')->nullable(true);

      $table->bigInteger('entry_id')->nullable(true);

      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('students');
  }
};

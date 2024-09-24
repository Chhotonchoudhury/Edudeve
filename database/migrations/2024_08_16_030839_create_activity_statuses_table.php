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
    Schema::create('activity_statuses', function (Blueprint $table) {
      $table->id();
      $table->string('Activity_name');
      $table->string('Activity_description');
      $table->enum('status', ['Active', 'Inactive'])->default('Active');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('activity_statuses');
  }
};

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
    Schema::create('email_settings', function (Blueprint $table) {
      $table->id();
      $table->string('smtp_host')->nullable();
      $table->string('smtp_port')->nullable();
      $table->string('smtp_user')->nullable();
      $table->string('smtp_password')->nullable();
      $table->string('smtp_encryption')->nullable();
      $table->string('sender_name')->nullable();
      $table->string('sender_email')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('email_settings');
  }
};

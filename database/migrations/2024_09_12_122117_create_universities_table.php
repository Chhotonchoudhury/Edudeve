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
    Schema::create('universities', function (Blueprint $table) {
      $table->id();
      $table->string('name'); // Name of the university
      $table->string('acronym')->nullable(); // Acronym or short form
      $table->text('description')->nullable(); // Description or overview
      $table->string('address'); // Main address
      $table->string('country_code'); // City where the university is located
      $table->string('city'); // City where the university is located
      $table->string('state'); // State or province
      $table->string('postal_code'); // Postal or ZIP code
      $table->string('country'); // Country
      $table->string('phone')->nullable(); // Contact phone number
      $table->string('email')->nullable(); // Contact email address
      $table->string('website')->nullable(); // Website URL
      $table->string('logo')->nullable(); // Logo image path
      $table->string('banner')->nullable(); // Banner image path
      $table->string('favicon')->nullable(); // Favicon image path
      $table->text('mission_statement')->nullable(); // Mission statement of the university
      $table->text('vision_statement')->nullable(); // Vision statement of the university
      $table->boolean('is_active')->default(true); // Status if the university is active or not
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('universities');
  }
};

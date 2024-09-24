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
    Schema::create('companyinfos', function (Blueprint $table) {
      $table->id();
      $table->string('company_name')->nullable(); // Column for the company name
      $table->string('company_moto')->nullable(); // Column for the company moto
      $table->string('small_logo')->nullable(); // For small logo
      $table->string('wide_logo')->nullable(); // For wide logo
      $table->string('favicon')->nullable(); // For favicon
      $table->text('address')->nullable(); // Column for the company address
      $table->string('email')->nullable(); // Column for the company email
      $table->string('phone')->nullable(); // Column for the company phone number
      $table->text('description')->nullable(); // Column for a company description or about section
      $table->string('website')->nullable(); // Column for the company website URL
      $table->string('social_links')->nullable(); // Column for social media links, you might want to use a JSON format
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('companyinfos');
  }
};

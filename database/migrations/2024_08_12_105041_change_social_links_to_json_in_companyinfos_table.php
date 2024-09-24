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
    Schema::table('companyinfos', function (Blueprint $table) {
      // Modify the 'social_links' column to be JSON type
      $table
        ->json('social_links')
        ->nullable()
        ->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('companyinfos', function (Blueprint $table) {
      // Revert 'social_links' column back to string
      $table
        ->string('social_links')
        ->nullable()
        ->change();
    });
  }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companyinfo extends Model
{
  use HasFactory;

  // Allow all attributes to be mass assignable
  protected $guarded = [];

  protected $casts = [
    'social_links' => 'array',
  ];
}

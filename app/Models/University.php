<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
  use HasFactory;
  public $guarded = [];

  public function courses()
  {
    return $this->hasMany(Course::class, 'university_id');
  }
}

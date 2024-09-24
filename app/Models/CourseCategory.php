<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
  use HasFactory;
  // Specify the fields that can be mass assigned
  public $guarded = [];

  public function courses()
  {
    return $this->hasMany(Course::class, 'category_id');
  }
}

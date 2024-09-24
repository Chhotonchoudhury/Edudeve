<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
  use HasFactory;
  public $guarded = [];

  public function course()
  {
    return $this->belongsTo(Course::class, 'course_id'); // 'course_id' is the foreign key, 'id' is the local key
  }
}

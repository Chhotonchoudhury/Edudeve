<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  use HasFactory;
  public $guarded = [];

  public function category()
  {
    return $this->belongsTo(CourseCategory::class, 'category_id');
  }

  public function university()
  {
    return $this->belongsTo(University::class, 'university_id');
  }

  public function requirements()
  {
    return $this->hasMany(CourseRequirement::class, 'course_id'); // 'course_id' is the foreign key, 'id' is the local key
  }

  //   public function students()
  //   {
  //     return $this->belongsToMany(Student::class, 'course_student');
  //   }
}

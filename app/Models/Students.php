<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
  use HasFactory;
  public $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class, 'entry_id');
  }

  public function enqstatus()
  {
    return $this->belongsTo(EnquiryStatus::class, 'enq_id');
  }

  //verified user
  public function verify_user()
  {
    return $this->belongsTo(User::class, 'verified_by');
  }
  //refered user
  public function refer_user()
  {
    return $this->belongsTo(User::class, 'refer_to');
  }

  public function courses()
  {
    return $this->belongsToMany(Course::class, 'course_student');
  }

  public function course()
  {
    return $this->belongsTo(Course::class, 'course_id');
  }

  public function university()
  {
    return $this->belongsTo(University::class, 'university_id');
  }

  public function document()
  {
    return $this->belongsToMany(StudentDoc::class, 'student_id');
  }
}

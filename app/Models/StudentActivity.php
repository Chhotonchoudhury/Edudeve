<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
  use HasFactory;
  public $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class, 'entry_id'); // Specify the foreign key if it's not the default 'user_id'
  }
}

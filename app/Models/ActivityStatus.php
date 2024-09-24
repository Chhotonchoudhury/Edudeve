<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityStatus extends Model
{
  use HasFactory;
  protected $fillable = ['Activity_name', 'Activity_description', 'status'];
}

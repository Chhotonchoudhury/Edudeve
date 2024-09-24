<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmgsStatus extends Model
{
  use HasFactory;
  protected $fillable = ['EMGstatus_name', 'EMGstatus_description'];
}

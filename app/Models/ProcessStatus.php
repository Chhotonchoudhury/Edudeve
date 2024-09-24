<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStatus extends Model
{
  use HasFactory;
  protected $fillable = ['Pstatus_name', 'Pstatus_description'];
}

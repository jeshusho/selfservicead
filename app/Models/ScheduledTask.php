<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledTask extends Model
{
    use HasFactory;
    protected $fillable = ['run','exec_date','exec_datetime'];
}

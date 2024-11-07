<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfserviceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'phone',
        'code',
        'sms_api_response',
        'expiration_code',
        'expiration_date',
        'code_result',
        'status'
    ];
}

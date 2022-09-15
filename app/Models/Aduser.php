<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduser extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'display_name',
        'given_name',
        'mail',
        'department',
        'password_expired',
        'expiration_date',
        'expiration_str',
        'expiration_days',
        'last_notification',
        'active'
    ];
}

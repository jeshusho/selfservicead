<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $with = ['aduser'];
    protected $fillable = ['aduser_id','sending_time', 'days'];

    public function aduser()
    {
        return $this->belongsTo(Aduser::class)
            ->select('id','username','display_name','mail');
    }
}

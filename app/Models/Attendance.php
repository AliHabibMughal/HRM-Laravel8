<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'check_in',
        'check_out',
        'leave',
        'explanation',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

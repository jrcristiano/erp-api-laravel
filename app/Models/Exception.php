<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'line',
        'code',
        'trace',
        'exception',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
}

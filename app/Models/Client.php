<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'cpf_cnpj',
        'phone',
        'zip_code',
        'street',
        'district',
        'city',
        'uf',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
}

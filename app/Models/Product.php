<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceAttribute()
    {
        $explode = explode('.', $this->attributes['price']);
        $value = $explode[0];
        $cents = substr($explode[1], 0, 2);
        
        return "{$value}.{$cents}";
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = number_format($price, 4, '.', '');
    }
}

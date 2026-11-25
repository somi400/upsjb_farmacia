<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'category_id', 'name', 'generic_name', 'presentation',
        'price', 'stock', 'expiration_date', 'image', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

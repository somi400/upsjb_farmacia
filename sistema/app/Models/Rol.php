<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description', 'status'];

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}

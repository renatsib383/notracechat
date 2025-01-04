<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'owner'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

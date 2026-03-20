<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'economic_activity',
        'legal_name',
        'phone',
        'address',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

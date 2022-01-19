<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonTrust extends Model
{
    protected $fillable = ['name', 'number', 'imageProfil'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

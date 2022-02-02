<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonTrust extends Model
{
    protected $fillable = ['name', 'phoneNumber', 'imageProfil', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

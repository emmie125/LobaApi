<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['state', 'user_id', 'conseil_id'];
    public function user_like()
    {
        return $this->belongsTo(User::class);
    }
    public function conseil_like()
    {
        return $this->belongsTo(Conseil::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    protected $fillable = ['image', 'description', 'type_conseil_id'];
    public function type_conseil()
    {
        return $this->belongsTo(TypeConseil::class);
    }
}

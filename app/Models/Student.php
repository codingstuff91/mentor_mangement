<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matiere()
    {
        return $this->belongsTo('App\Models\Matiere');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function cours()
    {
        return $this->hasMany('App\Models\Cours');
    }
}

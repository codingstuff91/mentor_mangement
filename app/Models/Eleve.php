<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matiere()
    {
        return $this->belongsTo('App\Models\Matiere');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function cours()
    {
        return $this->hasMany('App\Models\Cours');
    }
}

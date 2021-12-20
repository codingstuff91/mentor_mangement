<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Un eleve est lié a une matiere
    public function matiere()
    {
        return $this->hasOne('App\Models\Matiere');
    }

    // Un eleve est lié a un client
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }
}

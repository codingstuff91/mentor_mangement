<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function facture()
    {
        return $this->belongsTo('App\Models\Facture');
    }
    public function eleve()
    {
        return $this->hasOne('App\Models\Eleve');
    }
}

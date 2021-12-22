<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Un cours est lié a une facture
    public function facture()
    {
        return $this->hasOne('App\Models\Facture');
    }

    // Un cours est lié a un élève
    public function eleve()
    {
        return $this->belongsTo('App\Models\Eleve');
    }
}

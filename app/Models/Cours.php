<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cours extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateFormatedAttribute()
    {
        $date = new Carbon($this->date_debut);
        return $date->format('d/m/Y');
    }

    public function getHeureDebutAttribute()
    {
        $date = new Carbon($this->date_debut);
        return $date->format('H:i');
    }

    public function getHeureFinAttribute()
    {
        $date = new Carbon($this->date_fin);
        return $date->format('H:i');
    }
  
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

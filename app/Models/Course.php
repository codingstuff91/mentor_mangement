<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateFormatedAttribute()
    {
        $date = new Carbon($this->date_debut);
        return $date->format('d/m/Y');
    }

    public function getDateDebutEditedAttribute()
    {
        $date = new Carbon($this->date_debut);
        return $date->format('Y-m-d');
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

    public function getTotalPriceAttribute()
    {
        return $this->taux_horaire * $this->nombre_heures;
    }

    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}

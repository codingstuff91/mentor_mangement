<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Facture extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Une facture est lié a un client
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function getMonthYearCreationAttribute()
    {
        return $this->created_at->format('M-Y');
    }
}

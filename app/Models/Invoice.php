<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Une facture est lié a un client
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function getMonthYearCreationAttribute()
    {
        return $this->created_at->format('M-Y');
    }

    // Une facture est liée à plusieurs cours
    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }
}

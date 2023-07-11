<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'start_hour' => 'datetime',
        'end_hour' => 'datetime',
    ];

    public function getTotalPriceAttribute()
    {
        return $this->hourly_rate * $this->hours_count;
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

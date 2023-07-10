<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'paid' => 'boolean',
    ];

    protected $guarded = [];

    public function scopePaid($query)
    {
        return $query->where('paid', true);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('paid', false);
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function getMonthYearCreationAttribute()
    {
        return $this->created_at->format('M-Y');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }
}

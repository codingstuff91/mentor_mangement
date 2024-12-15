<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}

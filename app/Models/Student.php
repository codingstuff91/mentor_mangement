<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }
}

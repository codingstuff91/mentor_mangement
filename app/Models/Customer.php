<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoice()
    {
        return $this->hasMany('App\Models\Invoice');
    }
    public function eleve()
    {
        return $this->hasOne('App\Models\Eleve');
    }
}

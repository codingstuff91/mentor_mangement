<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Une facture est lié a un client
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }
}

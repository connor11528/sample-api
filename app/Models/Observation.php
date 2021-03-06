<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function capybara()
    {
        return $this->hasOne(Capybara::class);
    }
}

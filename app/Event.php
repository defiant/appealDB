<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [];


    public function appeal()
    {
        return $this->belongsTo(Appeal::class);
    }
}

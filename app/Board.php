<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';
    protected $fillable = [];

    public function appeal()
    {
        return $this->belongsTo(Appeal::class);
    }
}

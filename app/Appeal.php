<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $table = 'appeals';
    protected $fillable = ['event_id', 'board_id', 'player_north', 'player_south', 'player_east', 'player_west', 'director', 'committee', 'facts', 'appeal_reason', 'decision', 'appeal_time'];
    protected $dates = ['created_at', 'updated_at', 'appeal_time'];

    public function board()
    {
        return $this->hasOne(Board::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }
}

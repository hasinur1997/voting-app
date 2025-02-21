<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'poll_id',
        'option_text',
        'votes',
    ];
    
    /**
     * Get the poll that owns the option.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}

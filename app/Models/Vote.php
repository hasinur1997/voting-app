<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'poll_id',
        'poll_option_id',
        'user_ip'
    ];

    /**
     * Get the poll option associated with the vote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollOption()
    {
        return $this->belongsTo(PollOption::class);
    }
}

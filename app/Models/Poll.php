<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['question', 'slug'];

    /**
     * Get the options for the poll.
     */
    public function options()
    {
        return $this->hasMany(PollOption::class);
    }
}

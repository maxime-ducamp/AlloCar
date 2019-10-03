<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $fillable = ['from_id', 'to_id', 'subject', 'body', 'read_at'];

    protected $with = [
        'sender', 'receiver'
    ];

    /**
     * A PrivateMessage belongs to a sender (User)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * A PrivateMessage belongs to a receiver (User)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}

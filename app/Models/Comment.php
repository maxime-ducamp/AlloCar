<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Defines the fillable attributes through mass assignement
     * @var array
     */
    protected $fillable = ['journey_id', 'body'];

    /**
     * Defines the models that should be eager loaded
     * @var array
     */
    protected $with = ['user'];

    /**
     * A Comment belongs to one User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A comment belongs to one Journey
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}

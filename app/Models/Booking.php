<?php

namespace App;

use App\Notifications\BookingRequestNotification;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['journey_id', 'pending', 'approved'];

    protected $casts = [
        'pending' => 'boolean',
        'approved' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($booking) {
           $booking->journey->driver->notify(new BookingRequestNotification($booking));
        });
    }

    /**
     * A Booking belongs to a User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Booking belongs to a Journey
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}

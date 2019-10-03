<?php

namespace App;

use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingDeniedNotification;
use App\Notifications\JourneyDeletedNotification;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;
use phpDocumentor\Reflection\Types\Boolean;

class Journey extends Model
{
    /**
     * Defines the fillable attributes through mass assignement
     * @var array
     */
    protected $fillable = [
        'departure', 'arrival', 'seats', 'allows_pets', 'allows_smoking', 'driver_comment',
        'departure_datetime', 'arrival_datetime', 'completed_at',
    ];

    /**
     * Defines the models that should be eager loaded
     * @var array
     */
    protected $with = ['driver', 'bookings'];

    protected static function boot()
    {
        parent::boot();

        /**
         * Call to an external API before the model is saved to the database to estimate
         * the distance between the provided cities
         */
        static::creating(function($model) {
            $model->estimated_distance = 20;
//            $client = new Client();
//
//            $uri = 'https://fr.distance24.org/route.json?stops=' . $model->departure . '|' . $model->arrival;
//
//            $res = $client->get($uri);
//
//
//            if ($res->getStatusCode() === 200) {
//                $data = json_decode($res->getBody());
//
//                if (isset($data->distances[0])) {
//                    $model->estimated_distance = $data->distances[0];
//                } else {
//                    $model->estimated_distance = 'N/A';
//                }
//            } else {
//                $model->estimated_distance = 'N/A';
//            }
        });

        static::deleting(function($journey) {
           foreach($journey->bookings as $booking) {
               $booking->user->notify(new JourneyDeletedNotification($journey));
           }
        });
    }

    /**
     * A Journey references its associated creator as "driver"
     * A Journey belongs to a User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * A Journey can have many Comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * A Journey can have many Bookings
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * A Journey can accept a booking and decrease its number of available seats
     * @param Booking $booking
     * @return bool
     * @throws \Exception
     */
    public function approveBooking(Booking $booking)
    {
        if ($this->seats > 0) {
            $this->decrement('seats');

            $booking->update([
                'pending' => 0,
                'approved' => 1,
            ]);

            $booking->user->notify(new BookingApprovedNotification($this));
            return true;
        }

        $booking->delete();
        return false;
    }

    public function denyBooking(Booking $booking)
    {
        $booking->update([
            'pending' => 0,
            'approved' => 0,
        ]);

        $booking->user->notify(new BookingDeniedNotification($this));
    }

    public function hasBookingForUser(User $user)
    {
        return $this->bookings()->where(['user_id' => $user->id])->exists();
    }

    public function markAsCompleted()
    {
        foreach($this->bookings as $booking) {
            $booking->delete();
        }

        $this->completed_at = Carbon::now();
        $this->save();
        $this->driver->addExperience(10);
    }

    public function getHoursFor($which)
    {
        if ($which === 'departure') {
            return Date::parse($this->departure_datetime)->format('H');
        } elseif ($which === 'arrival') {
            return Date::parse($this->arrival_datetime)->format('H');
        }
    }

    public function getMinutesFor($which)
    {
        if ($which === 'departure') {
            return Date::parse($this->departure_datetime)->format('i');
        } elseif ($which === 'arrival') {
            return Date::parse($this->arrival_datetime)->format('i');
        }
    }

    public function participants()
    {
        $collection = new Collection();

        foreach ($this->bookings as $booking) {
            if ($booking->approved) {
                $collection->add($booking->user);
            }
        }

        return $collection;
    }
}

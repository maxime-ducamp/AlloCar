<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PrivateMessageReceivedNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The User model uses the "name" column for Route-Model binding
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * A User can have many Journeys
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }

    /**
     * A User can have many Comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * A User can have many Bookings
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * A User can belong to many Roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * A User can send many PrivateMessages
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sent()
    {
        return $this->hasMany(PrivateMessage::class,'from_id');
    }

    /**
     * A User can receive many PrivateMessages
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function received()
    {
        return $this->hasMany(PrivateMessage::class, 'to_id');
    }

    /**
     * Checks if a record exists that links the given role name to a user
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        $role = Role::where(['name' => $name])->firstOrFail();

        return $this->roles()->where(['role_id' => $role->id])->exists();
    }

    /**
     * Creates a relation between the user and a given role
     * @param $name
     * @return $this
     */
    public function addRole($name)
    {
        $role = Role::where(['name' => $name])->first();

        if ($role) {
            $this->roles()->attach($role);

        }
        return $this;
    }

    public function removeRole($name)
    {
        $role = Role::where(['name' => $name])->firstOrFail();

        if ($role) {
            $this->roles()->detach($role);
        }

        return $this;
    }

    public function sendMessageTo(User $to, $subject, $body)
    {
        $private_message = $this->sent()->create([
            'to_id' => $to->id,
            'subject' => $subject,
            'body' => $body
        ]);

        if ($private_message) {
            $to->notify(new PrivateMessageReceivedNotification($private_message));
            return true;
        } else {
            return false;
        }
    }

    public function addExperience($value)
    {
        $this->experience += $value;
        $this->save();
    }

    public function getReadableExperience()
    {
        if ($this->experience < 300) {
            return 'Novice';
        } elseif ($this->experience >= 300 and $this->experience < 600) {
            return 'Aguérri(e)';
        } else {
            return 'Pro';
        }
    }
}

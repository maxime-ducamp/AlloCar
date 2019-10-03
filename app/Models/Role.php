<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    /**
     * A Role can belong to many Users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }



    public function getReadableName()
    {
        switch($this->name) {
            case 'super_admin':
                $name = 'Super Administrateur';
                break;
            case 'admin':
                $name = 'Administrateur';
                break;
            case 'moderator':
                $name = 'Modérateur';
                break;
        }

        return $name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{
    HasMany,
    MorphMany,
};

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Get the topics for the admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * Get all of the message's.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}

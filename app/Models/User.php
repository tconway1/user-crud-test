<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['firstname', 'lastname'];

    /**
     * @return Attribute
     */
    protected function lastname(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => last(explode(' ', $attributes['name'])),
        );
    }

    /**
     * @return Attribute
     */
    protected function firstname(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $namePieces = explode(' ', $attributes['name']);
                array_pop($namePieces);
                return implode(' ', $namePieces);
            }
        );
    }

}

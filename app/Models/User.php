<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorite_pokemon(): HasOne {
        return $this->hasOne(Pokemon::class, 'id', 'favorite_pokemon_id');
    }

    public function pokemons(): BelongsToMany {
        return $this->belongsToMany(Pokemon::class, 'users_pokemons');
    }

    public function setEmailAttribute(string $email): void {
        $this->attributes['email'] = $email;
        $this->attributes['email_verified_at'] = null;
    }

    public function getScore(): int {
        $n_common_pokemons = $this->pokemons()->where('rareness', 'COMMON')->count();
        $n_rare_pokemons = $this->pokemons()->where('rareness', 'RARE')->count();
        $n_legendary_pokemons = $this->pokemons()->where('rareness', 'LEGENDARY')->count();

        return $n_common_pokemons + $n_rare_pokemons * 2 + $n_legendary_pokemons * 3;
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }
}

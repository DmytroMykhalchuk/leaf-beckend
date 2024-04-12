<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public const CoachRole = 'coach';

    public const StudentRole = 'student';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
    
    protected function picture(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => env('BASE_APP_URL') . $value,
        );
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function authProviders()
    {
        return $this->hasMany(UserProvider::class, 'user_id', 'id');
    }

    public function changeEmails()
    {
        return $this->hasMany(UserChangeEmail::class, 'user_id', 'id');
    }
}

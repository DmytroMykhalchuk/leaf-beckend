<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProvider extends Model
{
    use HasFactory;

    protected $table = 'user_providers';

    protected $fillable = [
        'user_id',
        'prover_id',
        'provider_name',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

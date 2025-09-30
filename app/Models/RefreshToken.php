<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/RefreshToken.php
// app/Models/RefreshToken.php
class RefreshToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'revoked',
    ];

    protected $casts = [
        'revoked' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function isValid(): bool
    {
        return ! $this->revoked && ! $this->isExpired();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    protected $fillable = [
        'user_id',
        'phone_verified',
        'address_verified',
        'biometric_verified',
        'phone_number',
        'address',
        'id_type',
        'id_front_path',
        'id_back_path',
        'selfie_path',
        'stage',
        'max_transactions'
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
        'address_verified' => 'boolean',
        'biometric_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 
<?php
// app/Models/Otp.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Otp extends Model
    {
    protected $fillable = [
    'user_id',
    'phone',
    'otp_hash',
    'expires_at',
    ];

    protected $casts = [
    'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }
}

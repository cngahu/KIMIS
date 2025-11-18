<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\OtpCode;

use Illuminate\Support\Str;
use Carbon\Carbon;
class OTPService
{
    public function generate(User $user)
    {
        $code = rand(100000, 999999);

        $otp = OtpCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Send email with user included
        Mail::to($user->email)->send(new \App\Mail\SendOTP($code, $user));

        return $otp;
    }


    public function validateCode($user, $code)
    {
        $otp = OtpCode::where('user_id', $user->id)
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        return $otp;
    }

    public function markUsed($otp)
    {
        $otp->update(['used' => true]);
    }
}

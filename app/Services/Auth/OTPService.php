<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\OtpCode;
use App\Services\AdvantaSmsService;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OTPService
{
    public function __construct(
        protected AdvantaSmsService $smsService, // inject SMS service
    ) {}

    /**
     * Generate an OTP for the user and send it via the chosen channel.
     *
     * @param  User   $user
     * @param  string $channel  'email' or 'sms'
     * @return OtpCode
     */
    public function generate(User $user, string $channel = 'email'): OtpCode
    {
        // 6-digit OTP
        $code = random_int(100000, 999999);

        // Optionally: mark any previous codes as used
        OtpCode::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        $otp = OtpCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => Carbon::now()->addMinutes(5),
            'used'       => false,
        ]);

        if ($channel === 'sms') {
            // === SEND VIA SMS ===
            if (empty($user->phone)) {
                // Fail clearly if no phone number available
                throw new \RuntimeException('User does not have a phone number set.');
            }

            $message = "Your KIHBT portal verification code is {$code}. It expires in 5 minutes.";

            // uses App\Services\AdvantaSmsService::sendSms(string $mobile, string $message)
            $this->smsService->sendSms($user->phone, $message);

        } else {
            // === SEND VIA EMAIL (default) ===
            Mail::to($user->email)->send(new \App\Mail\SendOTP($code, $user));
        }

        return $otp;
    }

    /**
     * Validate an OTP code for the given user.
     *
     * @param  User   $user
     * @param  string $code
     * @return OtpCode|null
     */
    public function validateCode(User $user, string $code): ?OtpCode
    {
        return OtpCode::where('user_id', $user->id)
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    /**
     * Mark the OTP as used.
     *
     * @param  OtpCode $otp
     * @return void
     */
    public function markUsed(OtpCode $otp): void
    {
        $otp->update(['used' => true]);
    }
}

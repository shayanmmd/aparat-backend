<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\VerifyChangeEmailRequest;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    const CACHE_KEY_EMAIL_VERIFICATION_CODE = 'change-email-verification-code-';

    public function changeEmail(ChangeEmailRequest $request)
    {
        $userEmail = $request->user()->email;
        $code = generateCodeRandom();
        $expirationTime = config('app.change_email_verification_code_expiration_in_seconds', 120);

        Cache::put(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail, [$request->email, $code], $expirationTime);
        //TODO:ارسال کد تایید برای تغییر ایمیل در ایمیل شخص
        dd(Cache::get(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail));
    }

    public function verifyChangeEmail(VerifyChangeEmailRequest $request)
    {
        $userEmail = $request->user()->email;
        $newEmailAndVerificationCode = Cache::get(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail);
        if ($newEmailAndVerificationCode == null) {
            return response()->json([
                'کد تایید منقضی شده است'
            ], Response::HTTP_BAD_REQUEST);
        }

        // dd($newEmailAndVerificationCode[1]);
        if ($request->code != $newEmailAndVerificationCode[1]) {
            return response()->json([
                'کد تایید اشتباه است'
            ], Response::HTTP_BAD_REQUEST);
        }
        User::where('email', '=', $userEmail)->update([
            'email' => $newEmailAndVerificationCode[0]
        ]);
        Cache::delete(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail);
        return response()->json([
            'ایمیل با موفقیت تغییر کرد'
        ], 200);
    }
}

<?php

namespace App\Repositories\User;

use App\Helpers\CustomResponse;
use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\VerifyChangeEmailRequest;
use App\Interfaces\Models\User\UserRespositoryInterface;
use App\Interfaces\Services\Email\EmailServiceInterface;
use App\Models\User;
use Auth;
use Cache;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserRespository implements UserRespositoryInterface
{
    const CACHE_KEY_EMAIL_VERIFICATION_CODE = 'change-email-verification-code-';

    public function __construct(
        private EmailServiceInterface $emailServiceInterface
    ) {}

    public function changeEmail(ChangeEmailRequest $request): CustomResponse
    {
        $res = new CustomResponse;
        try {
            $userEmail = $request->user()->email;
            $code = generateCodeRandom();
            $expirationTime = config('app.change_email_verification_code_expiration_in_seconds', 120);

            Cache::put(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail, [$request->email, $code], $expirationTime);

            $this->emailServiceInterface->send($code);

            return $res->succeed([
                "data" => 'ایمیل موقتا ثبت شد... در انتظار تایید'
            ]);
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function verifyChangeEmail(VerifyChangeEmailRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        $userEmail = $request->user()->email;

        $newEmailAndVerificationCode = Cache::get(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail);

        if ($newEmailAndVerificationCode == null) {
            return $res->failed(
                [
                    "data" => 'کد تایید منقضی شده است'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($request->code != $newEmailAndVerificationCode[1]) {
            return $res->failed(
                [
                    "data" => 'کد تایید اشتباه است'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        User::where('email', '=', $userEmail)->update([
            'email' => $newEmailAndVerificationCode[0]
        ]);

        Cache::delete(self::CACHE_KEY_EMAIL_VERIFICATION_CODE . $userEmail);

        return $res->succeed(
            [
                "data" => 'ایمیل با موفقیت تغییر کرد'
            ]
        );
    }

    public function changePassword(ChangePasswordRequest $request): CustomResponse
    {
        $res = new CustomResponse;

        try {
            $user = Auth::user();

            if (!Hash::check($request->old_password, $user->password))
                return $res->failed(['message' => 'پسوورد قدیمی با پسوورد فعلی مطابقت ندارد']);

            $isUpdated = $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            if (!$isUpdated)
                return $res->failed(['message' => 'پسوورد با موفقیت تغییر نیافت دوباره تلاش کنید']);

        } catch (\Throwable $th) {
            return $res->tryCatchError();
        }

        return $res->succeed(['message' => 'پسوورد با موفقیت تغییر یافت']);
    }
}

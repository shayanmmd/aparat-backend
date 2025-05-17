<?php

namespace App\Repositories\User;

use App\Helpers\CustomResponse;
use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\VerifyChangeEmailRequest;
use App\Interfaces\Models\User\UserRespositoryInterface;
use App\Interfaces\Services\Email\EmailServiceInterface;
use App\Models\User;
use Cache;
use Exception;
use Illuminate\Http\Response;

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
}

<?php

namespace App\Actions\Authorization;

use App\Actions\Authorization\Objects\InitAccount;
use App\Actions\Authorization\Objects\Provider;
use App\Http\Resources\Profile\InitProfileResource;
use App\Http\Services\ImageService;
use App\Mail\AuthEmailCode;
use App\Models\User;
use App\Models\UserProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthorizationAction
{
    private ImageService $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    public function checkNicknameUnique(string $nickname): array
    {
        $user = User::where('nickname', $nickname)->first();

        $isExist = (bool)$user;

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully checked',
            'data' => [
                'isExist' => $isExist,
            ],
        ];
    }

    public function checkEmailUnique(string $email): array
    {
        $user = User::where('email', $email)->first();

        $isExist = (bool)$user;

        return [
            'code' => 200,
            'status' => 'success',
            'messsage' => 'Successfully checked',
            'data' => [
                'isExist' => $isExist,
            ],
        ];
    }

    public function initAccount(InitAccount $initAccount, Provider $provider): array
    {
        $user = new User();
        $user->nickname = $initAccount->getNickname();
        $user->email = $initAccount->getEmail();
        $user->locale = $initAccount->getLocale();
        $user->is_email_notify = $initAccount->getIsEmailNotify();
        $user->country = $initAccount->getCountry();
        $user->role = $initAccount->getRole();

        $savePuctireName = $this->imageService->saveProfilePicture($initAccount->getPicture());
        $user->picture = $savePuctireName;

        $user->save();

        if ($provider->getId()) {
            $userProvider = new UserProvider();

            $userProvider->provider_name = $provider->getName();
            $userProvider->provider_id = $provider->getId();
            $userProvider->user_id = $user->id;
            $userProvider->save();

            $user->email_verified_at = Carbon::now();
            $user->save();

            return $this->authorizeUser($user);
        }

        return [
            'code' => 200,
            'status' => 'success',
            'messsage' => 'Successfully inited',
            'data' => [],
        ];
    }

    public function requestEmailCode(string $email): array
    {
        $user = User::where('email', $email)->firstOrFail();

        if (!$user || $user->email_verified_at) {
            return [
                'code' => 422,
                'status' => 'error',
                'message' => 'Not found user or email alredy verified',
                'data' => [],
            ];
        }

        if ($user->email_code_send_at) {
            $timeExpiresAt = Carbon::parse($user->email_code_send_at)->addMinute(1);

            if ($timeExpiresAt->gt(Carbon::now())) {
                return [
                    'code' => 429,
                    'status' => 'error',
                    'message' => 'Too many request',
                    'data' => [],
                ];
            }
        }

        $code = random_int(10000, 99999);

        $user->email_code_send_at = Carbon::now();
        $user->email_code = $code;
        $user->save();

        Mail::to($user->email)->send(new AuthEmailCode($code));

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully sended',
            'data' => [],
        ];
    }

    public function confirmEmailCode(string $email, int $code): array
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($user->email_verified_at) {
            return [
                'code' => 403,
                'status' => 'error',
                'message' => 'Alredy verified',
                'data' => [],
            ];
        }

        if ($user->email_code !== $code) {
            return [
                'code' => 400,
                'status' => 'error',
                'message' => 'Wrong code',
                'data' => [],
            ];
        }

        $user->email_verified_at = Carbon::now();
        $user->email_code = null;
        $user->email_code_send_at = null;

        $user->save();

        return $this->authorizeUser($user);
    }

    public function loginByGoogle(string $email, string $providerId): array
    {
        $providerName = 'google';

        $provider = UserProvider::where([
            'provider_id' => $providerId,
            'provider_name' => $providerName,
        ])->first();


        if ($provider) {
            return $this->authorizeUser($provider->user);
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $provider = new UserProvider();

            $provider->provider_name = $providerName;
            $provider->provider_id = $providerId;
            $provider->user_id = $user->id;
            $provider->save();

            return $this->authorizeUser($user);
        }

        return [
            'code' => 404,
            'status' => 'error',
            'message' => 'Provider not found',
            'data' => [],
        ];
    }

    public function confirmEmailByProvider(string $email, Provider $provider): array
    {
        $user = User::where('email', $email)->first();

        $userProvider = new UserProvider();

        $userProvider->user_id = $user->id;
        $userProvider->provider_name = $provider->getName();
        $userProvider->provider_id = $provider->getId();

        $userProvider->save();

        return $this->authorizeUser($user);
    }

    private function authorizeUser(User $user): array
    {
        $token = Auth::login($user);

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully logined',
            'data' => new InitProfileResource($user),
            'authorization' => [
                'token' => $token,
            ],
        ];
    }
}

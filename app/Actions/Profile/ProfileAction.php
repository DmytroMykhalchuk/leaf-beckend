<?php

namespace App\Actions\Profile;

use App\Actions\Profile\Objects\ProviderUpdate;
use App\Actions\Profile\Objects\UpdateProfile;
use App\Http\Resources\Profile\InitProfileResource;
use App\Http\Services\ImageService;
use App\Mail\AuthEmailCode;
use App\Models\User;
use App\Models\UserChangeEmail;
use App\Models\UserProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ProfileAction
{
    private ImageService $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    public function updateProfile(UpdateProfile $profile): array
    {
        $user = User::find(auth()->user()->id);

        $user->nickname = $profile->getNickname();
        $user->is_email_notify = $profile->getIsEmailNotify();
        $user->country = $profile->getCountry();
        $user->role = $profile->getRole();

        if ($profile->getPicture()) {

            $this->imageService->deleteProfilePicture($user->picture);

            $savePuctireName = $this->imageService->saveProfilePicture($profile->getPicture());
            $user->picture = $savePuctireName;
        }

        $user->save();

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully updated',
            'data' => new InitProfileResource($user),
        ];
    }

    public function changeEmail(string $email): array
    {
        auth()->user()->changeEmails()->delete();

        $code = random_int(10000, 99999);

        $userChangeEmailModel = new UserChangeEmail();

        $userChangeEmailModel->user_id = auth()->user()->id;
        $userChangeEmailModel->email = $email;
        $userChangeEmailModel->email_code = $code;

        $userChangeEmailModel->save();

        Mail::to($email)->send(new AuthEmailCode($code));

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully sended',
            'data' => [],
        ];
    }

    public function confirmEmailChanging(int $code): array
    {
        $user = User::find(auth()->user()->id);

        $userChangingEmailRequest = $user->changeEmails()->where('email_code', $code)->first();

        if (!$userChangingEmailRequest) {
            return [
                'code' => 400,
                'status' => 'error',
                'message' => 'Wrong code',
                'data' => [],
            ];
        }

        $user->email = $userChangingEmailRequest->email;
        $user->save();

        $userChangingEmailRequest->delete();

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully changed',
            'data' => [],
        ];
    }

    public function changeEmailProvider(ProviderUpdate $providerUpdate): array
    {
        $user = User::find(auth()->user()->id);

        $user->authProviders()->delete();

        $userProviderModel = new UserProvider();

        $userProviderModel->provider_id = $providerUpdate->getId();
        $userProviderModel->provider_name = $providerUpdate->getName();
        $userProviderModel->user_id = $user->id;

        $userProviderModel->save();

        $user->email = $providerUpdate->getEmail();
        $user->save();

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully updated',
            'data' => [],
        ];
    }

    public function requestEmailCode(): array
    {
        $user = User::find(auth()->user()->id);

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

    public function confirmEmailCode(int $code): array
    {
        $user = User::find(auth()->user()->id);

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

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully confirmed',
            'data' => [],
        ];
    }
}

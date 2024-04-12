<?php

namespace App\Actions\Profile;

use App\Actions\Profile\Objects\UpdateProfile;
use App\Http\Resources\Profile\InitProfileResource;
use App\Http\Services\ImageService;
use App\Mail\AuthEmailCode;
use App\Models\User;
use App\Models\UserChangeEmail;
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

        $userChangingEmailRequest = $user->changeEmails()->where('email_code', $code);

        if (!$userChangingEmailRequest) {
            return [
                'code' => 422,
                'status' => 'error',
                'message' => 'Wrong code',
                'data' => [],
            ];
        }

        $user->email=$userChangingEmailRequest->email;
        $user->save();

        $userChangingEmailRequest->delete();

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully changed',
            'data' => [],
        ];
    }
}

<?php

namespace App\Http\Controllers\Profile;

use App\Actions\Profile\Objects\ProviderUpdate;
use App\Actions\Profile\Objects\UpdateProfile;
use App\Actions\Profile\ProfileAction;
use App\Http\Controllers\AbstractController;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Profile\ChangeEmailProvider;
use App\Http\Requests\Profile\ChangeEmailRequest;
use App\Http\Requests\Profile\ConfirmCurrentEmailRequest;
use App\Http\Requests\Profile\ConfirmEmailChangingRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Faker\Provider\Base;

class ProfileController extends BaseController
{
    private ProfileAction $profileAction;

    public function __construct(ProfileAction $profileAction)
    {
        $this->middleware('auth:api');
        $this->profileAction = new ProfileAction();
    }

    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $profile = new UpdateProfile(
            $updateProfileRequest->getNickname(),
            $updateProfileRequest->getPicture(),
            $updateProfileRequest->getIsEmailNotify(),
            $updateProfileRequest->getCountry(),
            $updateProfileRequest->getRole(),
        );

        $data = $this->profileAction->updateProfile($profile);

        return $this->formatResponse($data);
    }

    public function changeEmail(ChangeEmailRequest $changeEmailRequest)
    {
        $data = $this->profileAction->changeEmail(
            $changeEmailRequest->getEmail(),
        );

        return $this->formatResponse($data);
    }

    public function confirmEmailChanging(ConfirmEmailChangingRequest $confirmEmailChangingRequest)
    {
        $data = $this->profileAction->confirmEmailChanging(
            $confirmEmailChangingRequest->getCode(),
        );

        return $this->formatResponse($data);
    }

    public function changeEmailProvider(ChangeEmailProvider $changeEmailProvider)
    {
        $providerUpdate = new ProviderUpdate(
            $changeEmailProvider->getProviderId(),
            $changeEmailProvider->getProviderName(),
            $changeEmailProvider->getEmail(),
        );

        $data = $this->profileAction->changeEmailProvider($providerUpdate);

        return $this->formatResponse($data);
    }

    public function requestEmailCode()
    {
        $data = $this->profileAction->requestEmailCode();

        return $this->formatResponse($data);
    }

    public function confirmCurrentEmail(ConfirmCurrentEmailRequest $confirmCurrentEmailRequest)
    {
        $data = $this->profileAction->confirmEmailCode(
            $confirmCurrentEmailRequest->getCode(),
        );

        return $this->formatResponse($data);
    }
}

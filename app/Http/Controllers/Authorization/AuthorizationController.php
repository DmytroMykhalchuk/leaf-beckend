<?php

namespace App\Http\Controllers\Authorization;

use App\Actions\Authorization\AuthorizationAction;
use App\Actions\Authorization\Objects\InitAccount;
use App\Actions\Authorization\Objects\Provider;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Authorization\ConfirmEmailByProviderRequest;
use App\Http\Requests\Authorization\ConfirmEmailCodeRequest;
use App\Http\Requests\Authorization\EmailCodeRequest;
use App\Http\Requests\Authorization\EmailUniqueRequest;
use App\Http\Requests\Authorization\InitAccountRequest;
use App\Http\Requests\Authorization\LoginByGoogleRequest;
use App\Http\Requests\Authorization\NicknameUniqueRequest;

class AuthorizationController extends BaseController
{
    private AuthorizationAction $authorizationAction;

    public function __construct()
    {
        $this->authorizationAction = new AuthorizationAction();
    }

    public function checkNicknameUnique(NicknameUniqueRequest $nicknameUniqueRequest)
    {
        $data = $this->authorizationAction->checkNicknameUnique(
            $nicknameUniqueRequest->getNickname(),
        );

        return $this->formatResponse($data);
    }

    public function checkEmailUnique(EmailUniqueRequest $emailUniqueRequest)
    {
        $data = $this->authorizationAction->checkEmailUnique(
            $emailUniqueRequest->getEmail(),
        );

        return $this->formatResponse($data);
    }

    public function initAccount(InitAccountRequest $initAccountRequest)
    {
        $provider = new Provider(
            $initAccountRequest->getProviderName(),
            $initAccountRequest->getProviderId(),
        );

        $accountData = new InitAccount(
            $initAccountRequest->getNickname(),
            $initAccountRequest->getEmail(),
            $initAccountRequest->getLocale(),
            $initAccountRequest->getPicture(),
            $initAccountRequest->getIsEmailNotify(),
        );

        $data = $this->authorizationAction->initAccount($accountData, $provider);

        return $this->formatResponse($data);
    }

    public function requestEmailCode(EmailCodeRequest $emailCodeRequest)
    {
        $data = $this->authorizationAction->requestEmailCode(
            $emailCodeRequest->getEmail(),
        );

        return $this->formatResponse($data);
    }

    public function confirmEmailCode(ConfirmEmailCodeRequest $confirmEmailCodeRequest)
    {
        $data = $this->authorizationAction->confirmEmailCode(
            $confirmEmailCodeRequest->getEmail(),
            $confirmEmailCodeRequest->getCode(),
        );

        return $this->formatResponse($data);
    }

    public function loginByGoogle(LoginByGoogleRequest $loginByGoogleRequest)
    {
        $data = $this->authorizationAction->loginByGoogle(
            $loginByGoogleRequest->getEmail(),
            $loginByGoogleRequest->getGoogleId(),
        );

        return $this->formatResponse($data);
    }

    public function confirmEmailByProvider(ConfirmEmailByProviderRequest $confirmEmailByProviderRequest)
    {
        $provider = new Provider(
            $confirmEmailByProviderRequest->getProviderName(),
            $confirmEmailByProviderRequest->getProviderId(),
        );

        $data = $this->authorizationAction->confirmEmailByProvider(
            $confirmEmailByProviderRequest->getEmail(),
            $provider,
        );

        return $this->formatResponse($data);
    }
}

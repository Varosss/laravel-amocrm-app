<?php

use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;

include_once __DIR__ . '/bootstrap.php';

$access_token = getToken();

$api_client->setAccessToken($access_token)
    ->setAccountBaseDomain($access_token->getValues()['baseDomain'])
    ->onAccessTokenRefresh(
        function (AccessTokenInterface $access_token, string $baseDomain) {
            saveToken(
                [
                    'accessToken' => $access_token->getToken(),
                    'refreshToken' => $access_token->getRefreshToken(),
                    'expires' => $access_token->getExpires(),
                    'baseDomain' => $baseDomain,
                ]
            );
        }
    );

$leads_service = $api_client->leads();
$leads_collection = json_decode(json_encode($leads_service->get()), true);
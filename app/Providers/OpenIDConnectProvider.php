<?php

namespace App\Providers;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

class OpenIDConnectProvider extends GenericProvider
{
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new OpenIDResourceOwner($response);
    }
}

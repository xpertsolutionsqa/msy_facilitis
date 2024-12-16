<?php
namespace App\Providers;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class OpenIDResourceOwner implements ResourceOwnerInterface
{
    protected $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response['sub'];
    }

    public function getName()
    {
        return $this->response['name'] ?? null;
    }

    public function getEmail()
    {
        return $this->response['email'] ?? null;
    }

    public function toArray()
    {
        return $this->response;
    }
}

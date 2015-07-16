<?php

namespace Kong\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\GenericResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Store extends GenericResourceOwner implements ResourceOwnerInterface
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->response[ 'name' ] ?: null;
    }
}
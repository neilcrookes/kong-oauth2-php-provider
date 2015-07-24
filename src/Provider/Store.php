<?php

namespace Kong\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\GenericResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Store extends GenericResourceOwner implements ResourceOwnerInterface
{
    /**
     * @return mixed
     */
    public function getStoreName()
    {
        return $this->response[ 'name' ] ?: null;
    }
    /**
     * @return mixed
     */
    public function getOwnerFirstName()
    {
        return $this->response[ 'owner' ][ 'first_name' ] ?: null;
    }
    /**
     * @return mixed
     */
    public function getOwnerLastName()
    {
        return $this->response[ 'owner' ][ 'last_name' ] ?: null;
    }
    /**
     * @return mixed
     */
    public function getOwnerName()
    {
        return $this->response[ 'owner' ][ 'name' ] ?: null;
    }
    /**
     * @return mixed
     */
    public function getOwnerEmail()
    {
        return $this->response[ 'owner' ][ 'email' ] ?: null;
    }
}
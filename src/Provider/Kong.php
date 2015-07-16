<?php

namespace Kong\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Kong extends AbstractProvider
{
    /**
     * @var string Key used in the access token response to identify the resource owner.
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'store_id';

    /**
     * @var string
     */
    protected $storeAdminDomain;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://'.$this->getStoreAdminDomain().'/'.$this->getLocale().'/admin/apps/authorize';
    }

    /**
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://'.$this->getStoreAdminDomain().'/oauth/access_token';
    }

    /**
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://'.$this->getStoreAdminDomain().'/'.$this->getLocale().'/api/store';
    }

    /**
     * @return string
     */
    public function getStoreAdminDomain()
    {
        return $this->storeAdminDomain;
    }

    /**
     * @param string $storeAdminDomain
     */
    public function setStoreAdminDomain($storeAdminDomain)
    {
        $this->storeAdminDomain = $storeAdminDomain;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [ 'read_store' ];
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ( $response->getStatusCode() != 200
            || ! is_array( $data ))
        {
            throw new IdentityProviderException( null, null, $response );
        }
    }

    /**
     * Generate a resource owner object from a successful resource owner details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new Store( $response, $token->getResourceOwnerId() );
    }

    /**
     * Builds request options used for requesting an access token.
     *
     * @param  array $params
     * @return array
     */
    protected function getAccessTokenOptions(array $params)
    {
        $options = parent::getAccessTokenOptions( $params );
        $options['headers']['Content-type'] = 'application/x-www-form-urlencoded';
        return $options;
    }
}
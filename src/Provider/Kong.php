<?php

namespace Kong\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\UserInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Kong extends AbstractProvider
{
    /**
     * @var string Key used in the access token response to identify the user.
     */
    const ACCESS_TOKEN_UID = 'store_id';

    /**
     * @var string
     */
    protected $storeAdminDomain;

    /**
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://'.$this->getStoreAdminDomain().'/en-gb/admin/apps/authorize';
    }

    /**
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://'.$this->getStoreAdminDomain().'/en-gb/apps/access';
    }

    /**
     * @param AccessToken $token
     * @return string
     */
    public function getUserDetailsUrl(AccessToken $token)
    {
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
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
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
            || ! is_array( $data )
            || ! array_key_exists( 'access_token', $data ) )
        {
            throw new IdentityProviderException( null, null, $response );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return UserInterface
     */
    protected function createUser(array $response, AccessToken $token)
    {
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
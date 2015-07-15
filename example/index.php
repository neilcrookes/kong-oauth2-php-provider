<?php

/**
 * Put this file in the document root of your application, adjust the settings below, then visit it in your browser
 */

use League\OAuth2\Client\Token\AccessToken;

require 'vendor/autoload.php';

/**
 * Just edit these settings:
 */
$provider = new Kong\OAuth2\Client\Provider\Kong([
    'clientId'      => 'XXXX', // Get this from your app settings in Kong
    'clientSecret'  => 'XXXX', // Get this from your app settings in Kong
    'redirectUri'   => 'http://my-app-domain.com/', // This is the URL of your app, and must match what you added in Kong when you created the app
    'storeAdminDomain' => 'my-test-store.kong365.com', // In reality you need to prompt the user to provide this
    'locale'        => 'en-gb', // This should come from the initial incoming request to your app, in the `locale` query string param
]);

/**
 * You shouldn't need to edit anything below here - it's just a demo after all
 */

session_start();

if ( isset( $_GET[ 'reset' ] ) )
{
    unset( $_SESSION['accessToken'] );
    header('Location: /');
    exit;
}
elseif ( isset( $_SESSION['accessToken'] ) )
{
    /** @var AccessToken $accessToken */
    $accessToken = $_SESSION['accessToken'];
    if ( $accessToken->hasExpired() )
    {
        $grant = new League\OAuth2\Client\Grant\RefreshToken();
        $_SESSION['accessToken'] = $provider->getAccessToken($grant, ['refresh_token' => $accessToken->getRefreshToken()]);
    }
    print_r($_SESSION['accessToken']);
    echo '<a href="/?reset=1">Reset</a>';
}
elseif ( isset( $_GET['code'] ) )
{
    if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    }

    $_SESSION['accessToken'] = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    header('Location: /');
    exit;
}
elseif ( isset( $_GET['error'] ) )
{
    echo htmlspecialchars( $_GET[ 'error_description' ] );
    echo '<a href="/">Try again</a>';
    exit;
}
else
{
    $authUrl = $provider->getAuthorizationUrl( [
        'scope' => [
            'write_products'
        ],
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;
}
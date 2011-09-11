<?php

function getScheme() {
    $scheme = 'http';
    if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
        $scheme .= 's';
    }
    return $scheme;
}

function getTrustRoot() {
    return sprintf("%s://%s:%s%s/", getScheme(), $_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'], dirname($_SERVER['PHP_SELF']));
}

// Includes required files
set_include_path(get_include_path() . PATH_SEPARATOR . $basePath . "lib/openid-php/");
require_once "Auth/OpenID/Consumer.php";
require_once "Auth/OpenID/FileStore.php";
require_once "Auth/OpenID/AX.php";

function login() {
    // Just tested this with/for Google, needs trying with others ...
    $oid_identifier = 'https://www.google.com/accounts/o8/id';
    // Create file storage area for OpenID data
    $store = new Auth_OpenID_FileStore('lib/openid-php/oid_store');
    // Create OpenID consumer
    $consumer = new Auth_OpenID_Consumer($store);
    // Create an authentication request to the OpenID provider
    $auth = $consumer->begin($oid_identifier);

    // Create attribute request object
    // See http://code.google.com/apis/accounts/docs/OpenID.html#Parameters for parameters
    // Usage: make($type_uri, $count=1, $required=false, $alias=null)
    $attribute[] = Auth_OpenID_AX_AttrInfo :: make('http://axschema.org/contact/email', 2, 1, 'email');
    $attribute[] = Auth_OpenID_AX_AttrInfo :: make('http://axschema.org/namePerson/first', 1, 1, 'firstname');
    $attribute[] = Auth_OpenID_AX_AttrInfo :: make('http://axschema.org/namePerson/last', 1, 1, 'lastname');

    // Create AX fetch request
    $ax = new Auth_OpenID_AX_FetchRequest;

    // Add attributes to AX fetch request
    foreach ($attribute as $attr) {
        $ax->add($attr);
    }

    // Add AX fetch request to authentication request
    $auth->addExtension($ax);
    $_SESSION['returnURL'] = curPageURL();
    // Redirect to OpenID provider for authentication
    $url = $auth->redirectURL(getTrustRoot(), $_SESSION['returnURL']);
    header('Location: ' . $url);
}

function auth() {
    if ($_SESSION['authed'] == true)
        return true;

    // Create file storage area for OpenID data
    $store = new Auth_OpenID_FileStore('lib/openid-php/oid_store');
    // Create OpenID consumer
    $consumer = new Auth_OpenID_Consumer($store);
    // Create an authentication request to the OpenID provider
    $response = $consumer->complete($_SESSION['returnURL']);

    if ($response->status == Auth_OpenID_SUCCESS) {
        // Get registration informations
        $ax = new Auth_OpenID_AX_FetchResponse();
        $obj = $ax->fromSuccessResponse($response);
        $email = $obj->data['http://axschema.org/contact/email'][0];
        var_dump($email);
        if ($email != "maxious@gmail.com") {
            die("Access Denied");
        } else {
            $_SESSION['authed'] = true;
        }
    } else {
        login();
    }
}

if ($_REQUEST['janrain_nonce'])
    auth();
?>
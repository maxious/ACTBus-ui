<?php
require $basePath.'lib/openid.php';
$openid = new LightOpenID($_SERVER['HTTP_HOST']);
 
function login()
{
 global $openid;
 if(!$openid->mode) {
    $openid->required = array('contact/email');
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            header('Location: ' . $openid->authUrl());
 }
    } 


function auth()

{
  if ($_SESSION['authed'] == true) return true;
 global $openid;
  
  if($openid->mode) {
      $attr = $openid->getAttributes();
        if ($attr["contact/email"] != "maxious@gmail.com") {
            die("Access Denied");
             } else {
               $_SESSION['authed'] = true;
             }
        } else {
        login();
         } 
    } 
?>
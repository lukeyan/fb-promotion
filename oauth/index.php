<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '124146804457429',
  'secret' => '9c79885267629569e95ff20dcf8f7471',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_friendlist = $facebook->api('/me/friends');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
  
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_groups = $facebook->api('/me/groups');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'publish_stream,user_groups'));
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
    $(function(){
        $('#getdata').click(function(){
            $.getJSON('https://www.facebook.com/chris.coles.733/friends',function(data){
                $("#showres").html(data);
            });
        });
        
        $('#getbaidu').click(function(){
            $.getJSON('test.php',function(data){
                $("#showres").html(data);
            });
        });
    });
    </script>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>   
    
    <pre><?php 
    $data = $_SESSION;
    array_shift($data);
    $link = "<a href='http://facebook.iyanlang.com/facebook/token/";
    foreach($data as $k=>$v){
    $link .=$v."/"; 
    }
    $link .="'>Enter</a>";
    echo $link;
    ?>
    </pre>
    
    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
      <pre><?php print_r($user_friendlist); ?></pre>
      <pre><?php print_r($user_groups); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
      <button id="getdata">getdata</button>
       <button id="getbaidu">getbaidu</button>
      <div id="showres"></div>
    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?>
  </body>
</html>

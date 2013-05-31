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
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'user_groups'));
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
  </head>
  <body>
    <div class="fbgroupwrapper">
<div id="fbgroupform" class="groupform">
<form id="form" name="form" method="post" action="process.php">
<h1>Post to Facebook Group Wall</h1>
<p>Choose a group to post. <?php
/*
Get Log out URL
Due to some bug or whatever, SDK still thinks user is logged in even
after user logs out. To deal with it, user is redirected to another page "logged-out.php" after logout
it is working fine for me with this trick. Hope it works for you too.
*/
$logOutUrl = $facebook->getLogoutUrl(array('next'=>$homeurl.'logged-out.php'));
echo '<a href="'.$logOutUrl.'">Log Out</a>';
?>
</p>
<label>Groups
<span class="small">Select a Group</span>
</label>
<select name="usergroups" id="ugroups">
	<?php
        $fql_query = 'select gid, name from group where gid IN (SELECT gid FROM group_member WHERE uid='.$user.')';
		
		//FQL query to list only groups where user is administrator.(administrator='true')
		//$fql_query = 'select gid, name from group where gid IN (SELECT gid FROM group_member WHERE uid='.$fbuser.' AND administrator=\'true\')';
		$postResults = $facebook->api(array( 'method' => 'fql.query', 'query' => $fql_query ));
    foreach ($postResults as $postResult) {
            echo '<option value="'.$postResult["gid"].'">'.$postResult["name"].'</option>';
        }
    ?>
</select>
<label>Message
<span class="small">Write something to post!</span>
</label>
<textarea name="message"></textarea>
<button type="submit" class="button" id="submit_button">Post Message</button>
<div class="spacer"></div>
</form>
</div>
</div>
  </body>
</html>

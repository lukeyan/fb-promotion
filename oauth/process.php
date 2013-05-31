<?php
require '../src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '124146804457429',
  'secret' => '9c79885267629569e95ff20dcf8f7471',
));

$fbuser = $facebook->getUser();
if($_POST)
{
	//Post variables we received from user
	$userGroupId 	= $_POST["usergroups"];
	$userMessage 	= $_POST["message"];
	
	if(strlen($userMessage)<1) 
	{
		//message is empty
		$userMessage = 'No message was entered!';
	}
	
		//HTTP POST request to GROUP_ID/feed with the publish_stream
		$post_url = '/'.$userGroupId.'/feed';
		
		//posts link on group wall 
		/*
		$msg_body = array(
		'link' => 'http://www.saaraan.com',
		'message' => $userMessage,
		);
		*/
		
		
		//posts statuses message on group wall 
		$msg_body = array(
		'message' => $userMessage,
		);
	
	if ($fbuser) {
	  try {
			$postResult = $facebook->api($post_url, 'post', $msg_body );
		} catch (FacebookApiException $e) {
		echo $e->getMessage();
	  }
	}else{
//	 $loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
//	 header('Location: ' . $loginUrl);
	}
	
	//Show sucess message
	if($postResult)
	 {
		 echo '<html><head><title>Message Posted</title><link href="style.css" rel="stylesheet" type="text/css" /></head><body>';
		 echo '<div id="fbgroupform" class="groupform" align="center">';
		 echo '<h1>Your message is posted on your facebook group wall.</h1>';
		 echo '<a class="button" href="'."#".'">Back to Main Page</a> <a target="_blank" class="button" href="http://www.facebook.com/groups/'.$userGroupId.'">Visit Your Group</a>';
		 echo '</div>';
		 echo '</body></html>';
	 }
}

if($_GET)
{
    echo $fbuser;
	//Post variables we received from user
	$userGroupId 	= $_GET["usergroups"];
	$userMessage 	= $_GET["message"];
	
	if(strlen($userMessage)<1) 
	{
		//message is empty
		$userMessage = 'No message was entered!';
                 echo $userMessage;
	}
	
		//HTTP POST request to GROUP_ID/feed with the publish_stream
		$post_url = '/'.$userGroupId.'/feed';
		
		//posts link on group wall 
		/*
		$msg_body = array(
		'link' => 'http://www.saaraan.com',
		'message' => $userMessage,
		);
		*/
		
		
		//posts statuses message on group wall 
		$msg_body = array(
		'message' => $userMessage,
		);
	
	if ($fbuser) {
	  try {
			$postResult = $facebook->api($post_url, 'post', $msg_body );
                        echo $postResult;
		} catch (FacebookApiException $e) {
		echo $e->getMessage();
	  }
	}else{
//	 $loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
//	 header('Location: ' . $loginUrl);
            echo "eeee";
	}
	
	//Show sucess message
        if($postResult) echo "ok";
        
}
 
?>

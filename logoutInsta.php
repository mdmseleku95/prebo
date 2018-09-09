<?php

include('classes/DB.php');
include('classes/Login.php');

session_start();

if(Login::isLoggedIn()){
    $userid = Login::isLoggedIn();
}
	
// if user is logged in, destroy all  sessions
if( isset($_SESSION['user_info']) or isset($_SESSION['login']) ){
	unset( $_SESSION['user_info'] ); // destroy
	unset( $_SESSION['login'] ); // destroy
    $name = 'instagram';
    
    header("location: integrations.php"); // redirect user to index page
}

else{ // if user is not logged in
	header("location: integrations.php"); // redirect user to index page
}

?>
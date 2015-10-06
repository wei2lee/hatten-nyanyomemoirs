<?php 

error_reporting(0); 
// error_reporting(E_ALL); 

$isDev=false; $actual_link="http://" . $_SERVER[ "HTTP_HOST"] . $_SERVER[ "REQUEST_URI"]; 

if (strpos($actual_link, '127.0.0.1') !==false) $isDev=true; 
if (strpos($actual_link, 'localhost') !==false) $isDev=true; 
if (strpos($actual_link, 'staging') !==false) $isDev=true; 

$config=array( 
	"smtp"=> array( 
		"user" => 'infr5625', 
		"pass" => 'y_4a8Aq2', 
		// "host" => "mail.infradigital.com.my", 
		"host" => '202.157.177.148',
		"port" => 587 ), 
	"isDev" => $isDev ); 
?>
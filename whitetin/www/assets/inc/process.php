<?php

// Enable sessions
session_start();

// Include necessary files
include_once '../../../sys/config/db-conf.php';

// Define constants for config info
foreach ( $C as $name => $val ) {
	define($name, $val);
}

// Create a lookup array for form actions
$actions = array(
	'user_login' => array(
		'object' => 'Admin',
		'method' => 'processLoginForm',
		'header' => '../../content.php'
		),

	'user_logout' => array(
		'object' => 'Admin',
		'method' => 'processLogout',
		'header' => '../../'
		),
		
	'print_page' => array(
		'object' => 'PrintP',
		'method' => 'printPage',
		'header' => '../../content.php'
		)

	);

// Make sure the anti-CSRF token was passed and that the requested action exists in the lookup array

if ( $_POST['token']==$_SESSION['token'] && isset($actions[$_POST['action']]) )
{
	$use_array = $actions[$_POST['action']];
	$obj = new $use_array['object']; //($dbo);

	if ( TRUE === $msg=$obj->$use_array['method']() )
	{
		header("Location: " . $use_array['header']);
		exit;
	}
	else
	{		// If an error occured, output it and end execution
		$css_files = array('style.css', );
		$script_files = array( );
		include_once '../common/header.php';
		die ( "ERROR: " . $msg );
	}
}

else
{		// Redirect to the main index if the token/action is invalid
	header("Location: ../../");
	exit;
}

function __autoload($class_name)
{
	$filename = '../../../sys/class/class.' . strtolower($class_name) . '.php';
	if ( file_exists($filename) )
	{
		include_once $filename;
	}
}

?>
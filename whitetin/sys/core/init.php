<?php

// Enable sessions
session_start();

// Generate an anti-CSRF token if one doesn't exist
if ( !isset($_SESSION['token']) )
{
	$_SESSION['token'] = sha1(time());
}

// Include the necessary configuration info
include_once '../sys/config/db-conf.php';

// Define constants for configuration info
foreach ( $C as $name => $val ) {
	define($name, $val);
}

// Create a PDO object
$dsn = "sqlsrv:server=" . serverName . ";Database=" . dbase;
$dbo = new PDO( $dsn, username, password );
$dbo -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

// Define the auto-load function for classes
function __autoload($class) {

	$filename = "../sys/class/class." . strtolower($class) . ".php";
	if ( file_exists($filename) )
	{
		include_once $filename;
	}
}
<?php

class Admin		// Manages administrative actions
{
	private $_saltLength = 7;		// Determines the length of the salt to use in hashed passwords

	public function __construct($saltLength=NULL)			// Sets the salt length (length for the password hash)
	{
		if ( is_int($saltLength) )			// If an int was passed, set the length of the salt
		{
			$this->_saltLength = $saltLength;
		}
	}

	public function processLoginForm()		// Checks login credentials for a valid user; returns TRUE on success, message on error
	{
		if ( $_POST['action']!='user_login' )		// Fails if the proper action was not submitted
		{
			return "В processLoginForm передано недействительное значение атрибута action.";
		}

		// Escapes the user input for security

		$uname = htmlentities($_POST['uname'], ENT_QUOTES);
		$pword = htmlentities($_POST['pword'], ENT_QUOTES);
		
		$hash1 = $this->_getSaltedHash(password);		// Get the hash of the stored password

		If (($uname == username)) 		// Checks username and creates a user
		{
			$user = array(
				'user_name' => $uname,
				'user_pass' => $hash1,
				);
		}

		if ( !isset($user) )		// Fails if username doesn't match
		{
			return "Неверное имя пользователя или пароль.";
		}

		$hash = $this->_getSaltedHash($pword, $user['user_pass']);		// Get the hash of the user-supplied password

		if ( $user['user_pass']==$hash )		// Checks if the hashed password matches the stored hash
		{
			// Stores user info in the session as an array

			$_SESSION['user'] = array(
				'name' => $user['user_name'],
			);

			return TRUE;
		}

		else		// Fails if the passwords don't match

		{
			return "Неверное имя пользователя или пароль.";
		}
	}

	public function processLogout()			// Logs out the user, returns TRUE on success or messsage on failure
	{

		if ( $_POST['action']!='user_logout' )		// Fails if the proper action was not submitted
		{
			return "В processLogout передано недействительное значение атрибута action.";
		}

		unset($_SESSION['user']);		// Removes the user array from the current session
		session_destroy();

		return TRUE;
	}

	private function _getSaltedHash($string, $salt=NULL)		// Generates a salted hash of a supplied string
	{

		if ( $salt==NULL )		// Generate a salt if no salt is passed
		{
			$salt = substr(md5(time()), 0, $this->_saltLength);
		}

		else		// Extract the salt from the string if one is passed
		{
			$salt = substr($salt, 0, $this->_saltLength);
		}

		return $salt . sha1($salt . $string);		// Add the salt to the hash and return it
	}
}

?>
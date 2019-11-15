<?php

class DB_Connect {		// Establishes a database connection

	protected $db;		// Stores a database object

	protected function __construct($dbo=NULL)		// Checks for a DB object or creates one if one isn't found ($dbo is a database object)
	{
		if ( is_object($dbo) )
		{
			$this->db = $dbo;
		}
		else
		{		// Constants are defined in /sys/config/db-conf.php

			$dsn = "sqlsrv:server=" . serverName . ";Database=" . dbase;
			try
			{
				$conn = new PDO($dsn, username, password);
				$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$this->db = $conn;
			}
			catch ( Exception $e )
			{		// If the DB connection fails, output the error
				die ( $e->getMessage() );
			}
		}
	}
}
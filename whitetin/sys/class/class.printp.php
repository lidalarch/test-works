<?php

class PrintP		// Makes printable version
{
	private $_printable;

	public function __construct($printable=NULL)			// Sets the printable marker
	{
		if ( is_bool($printable) )			// If a bool was passed, set the printable marker
		{
			$this->_printable = $printable;
		}
	}

	public function printPage()		// Provides marker for css file to change to a printable version; returns TRUE on success, message on error
	{
		if ( $_POST['action']!='print_page' )		// Fails if the proper action was not submitted
		{
			return "В printPage передано недействительное значение атрибута action.";
		}

		$this->_printable = TRUE;

		return $this->_printable;
	}
}
?>
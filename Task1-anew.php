<?php

function getNumber($N) {

	$arrDiv = array(); //array of dividers
	for ($dv = 9; (($dv != 1) && ($N != 1)); $dv--) { //finding dividers (in reverse order to lessen the quantity of digits in arrDiv)
	
		while ($N % $dv == 0) {
		
		$N = $N / $dv;
		$arrDiv[] = $dv;
		}
	}

	sort($arrDiv); //sorts array in ascending order
	
	$number = ""; //connecting digits into a number
	foreach ($arrDiv as $dv) {
	
	$number .= "$dv";
	}
	if (strlen($number) < 2 ){ //if there are less then 2 one-digit dividers
		$result = 0;
	} else {
		$result = (int) $number;
	}
	
	return $result;
}

?>
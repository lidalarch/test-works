<?php

function getPrimePalindrome($N) {

	function isPrime($number) {
		for ($i=2; ($i <= (sqrt($number)+1)); $i++) {
			if (($number % $i) == 0) {
				return False;
			}
		}
		return True;
	}
	
	function isPalindrome($number) {
		$str1 = (string) $number;
		$str2 = strrev($str1); //string in reverse order
		return ($str1 == $str2);
	}
	
	$curNumber = $N + 1;
	while (True) {
		if (isPrime($curNumber) && isPalindrome($curNumber)) {
			return $curNumber;
		}
		$curNumber += 1;
	}
}

?>
<?php

function countWords($text) {

	$text1 = strtolower($text);

	$text2 = preg_replace('/[-,.)(;:"!?]/' , ' ' , $text1); //replace any punctuation with spaces

	$arrWords = preg_split('/[\s]+/', $text2, -1, PREG_SPLIT_NO_EMPTY); //split the text into array of words

	$arrWords2 = preg_grep('/^(?:[aeiouy][bcdfghjklmnpqrstvwxz])+[aeiouy]?$|^(?:[bcdfghjklmnpqrstvwxz][aeiouy])+[bcdfghjklmnpqrstvwxz]?$/' , $arrWords);    //select only "striped" words

	$result = count($arrWords2);

	return $result;
}

?>


1.Заменить знаки препинания пробелами (кроме') preg_replace /[-,.)(;:"!?]/ \s  strtolower 
2.разделить строку на слова по пробелам, записать в массив preg_split (без пустых!)
3.найти по маске полосатые в другой массив preg_grep  (?i:saturday|sunday)  [aeiouy]{1,} +? ^$
4.посчитать

/^(?:[aeiouy][bcdfghjklmnpqrstvwxz])+[aeiouy]?$|^(?:[bcdfghjklmnpqrstvwxz][aeiouy])+[bcdfghjklmnpqrstvwxz]?$/
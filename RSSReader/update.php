<?php
if ((isset($_POST['itemID'])) && (isset($_POST['pubTime'])) && (preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9_'.+-]*@[a-zA-Z0-9.-]+\.[a-z]{2,5}$/", $_POST['email'])) && (!(empty($_POST['comm']))) ) {
	//данные, переданные AJAX
	$uid =$_POST['itemID'];
	$uemail =$_POST['email'];
	$ucomm =$_POST['comm'];
	$utime =$_POST['pubTime'];

	//соединение с БД комментариев
	$host = "127.0.0.1"; //localhost
	$user = "rssread";
	$pass = "12qaws34";
	$db_name = "comments";
	$link = mysqli_connect($host, $user, $pass, $db_name);
	if (!$link) {
			echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
			echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
			exit;
	}
	
	//экранируем строки
	$euid = mysqli_real_escape_string($link, $uid);
	$euemail = mysqli_real_escape_string($link, $uemail);
	$eucomm = mysqli_real_escape_string($link, $ucomm);
	$eutime = mysqli_real_escape_string($link, $utime);
	
	//добавляем комментарий в базу
	$sqlUpd = mysqli_query($link, "INSERT INTO `comments`(`ITEMID`, `EMAIL`, `COMM`, `TIME`, `NAME`) VALUES ('$euid', '$euemail', '$eucomm', '$eutime', '0')");

	$rtime = substr($eutime,4,20); //формат времени добавления комментария
	//добавляем комментарий на страницу
	$reshtml = <<<MARKUP
	<h3>{$euemail}</h3>
	<p class="pub-date">{$rtime}</p>
	<p>{$eucomm}</p>
MARKUP;
	echo $reshtml;
	
	mysqli_close($link);
}
?>
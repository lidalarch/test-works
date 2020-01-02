<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		if (!((file_exists("page.rss"))&&(filemtime("page.rss") > (time() - 3600)))) { //если нет кешированной версии, измененной менее часа назад
			$xml = file_get_contents("http://lenta.ru/rss"); //записываем новую версию xml
			file_put_contents("page.rss", $xml);
		}
		$rss = simplexml_load_file("page.rss"); //берем записанную версию xml
		
		$page_title = $rss->channel->title;
		$subtitle = $rss->channel->description;
		
		
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
	?>
	
	<meta http-equiv="Content-Type" type="text/html" charset="utf-8">	
	<title><?php echo $page_title; ?></title>
	
	<link rel="stylesheet" type="text/css" media="screen,projection" href="style.css">
	
	<script src="google_jsapi.js"></script>
    <script> google.load("jquery", "1.7.1"); </script>
	<script src="process.js"></script>
</head>

<body>
	<div id="header">
		<h1><?php echo $page_title; ?></h1>
		<p><?php echo $subtitle; ?></p>
	</div>
	<?php
		foreach ($rss->channel->item as $item) {
			$itemID = md5($item->pubDate . $item->title); //строка числа-буквы 32 символа
			$commPlace = "commPlace".$itemID;
			$email = "email".$itemID;
			$comm = "comm".$itemID;
			
			$rpubDate = substr($item->pubDate, 4, 21);
			$html = <<<MARKUP
			<h2><a href="$item->link">$item->title</a></h2>
			<p class="pub-date">$rpubDate</p>
			<p>$item->description</p>
			<div class="commPlace" id = "$commPlace" >
MARKUP;
			echo $html;
			$sql = mysqli_query($link, "SELECT `EMAIL`, `COMM`, `TIME` FROM `comments` WHERE `ITEMID`='$itemID' ORDER BY `TIME`");
			if (($sql != False) && (mysqli_num_rows($sql) != 0)) {
				while ($result = mysqli_fetch_array($sql)) {
					$rtime = substr($result['TIME'], 4, 20);
					$reshtml = <<<MARKUP
					<h3>{$result['EMAIL']}</h3>
					<p class="pub-date">{$rtime}</p>
					<p>{$result['COMM']}</p>
MARKUP;
					echo $reshtml;
				}
				mysqli_free_result($sql);
			}
			$html1 = <<<MARKUP
				</div>
				<form method="post" action="">
					<input type="text" class="email" name="email" id="$email"></input><p class="form">Ваш e-mail</p>
					<input type="text" class="comm" name="comm" id="$comm">
					<div class="buttonPlace">
						<input type="button" class="button" name="button" onclick="send('$itemID')" value="Отправить комментарий">
					</div>
				</form>
MARKUP;
			echo $html1;
		}
		mysqli_close($link);
	?>
</body>
</html>
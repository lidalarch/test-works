<!DOCTYPE html>
<html lang="ru">

<head>
	<meta http-equiv="Content-Type"
	content="text/html;charset=utf-8" />

	<title>
	<?php echo $page_title; ?>
	</title>

	<?php foreach ( $css_files as $css ): ?>

		<link rel="stylesheet" type="text/css" media="screen,projection"
		href="assets/css/<?php echo $css; ?>" />

	<?php endforeach; ?>

	<?php if ($pr->printPage() === TRUE) { ?>
	
		<link rel="stylesheet" type="text/css" media="print,screen,projection"
		href="assets/css/print.css" />
		
	<?php } ?>
	
	<?php foreach ( $script_files as $script ): ?>

		<script src="assets/js/<?php echo $script; ?>"></script>

	<?php endforeach; ?>

</head>

<body>
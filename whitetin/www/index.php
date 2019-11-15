<?php

// Include necessary files
include_once '../sys/core/init.php';

$pr = new PrintP;

// Set up the page title and CSS files
$page_title = "Пожалуйста, зарегистрируйтесь - Please Log In";
$css_files = array("style.css", "admin.css");
$script_files = array('jquery-1.10.2.js', 'jquery-ui.js', 'settings.js', );

// Output the header
include_once 'assets/common/header.php';

?>

<div id="content">
	<form action="assets/inc/process.php" method="post">
		<fieldset>
			<legend>Пожалуйста, зарегистрируйтесь</legend>
			<label for="uname">Логин</label>
			<input type="text" name="uname" id="uname" value="" />
			<label for="pword">Пароль</label>
			<input type="password" name="pword" id="pword" value="" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
			<input type="hidden" name="action" value="user_login" />
			<input type="submit" name="login_submit" value="OK" />
		</fieldset>
	</form>
</div><!-- end #content -->

<?php

// Output the footer
include_once 'assets/common/footer.php';
?>
<?php

// Include necessary files
include_once '../sys/core/init.php';

// If the user is not logged in, send them to the main file
if ( !isset($_SESSION['user']) )
{
    header("Location: /index.php");
    exit;
}

$pr = new PrintP;

// Set up the page title and CSS files
$page_title = "Белая жесть - White tin";
$css_files = array('style.css', 'jquery-ui.css', );
$script_files = array('jquery-1.10.2.js', 'jquery-ui.js', 'settings.js', );

// Output the header
include_once 'assets/common/header.php';

//Display the datepicker form & select the date
if ($pr->printPage() !== TRUE) {
	$formD = new Form;
	echo $formD->buildForm();
}

//Load the balance to date table
$date=$formD->date;
$bal = new Balance ($dbo, $date);

?>

<div id="logout">
	<form action="assets/inc/process.php" method="post">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
		<input type="hidden" name="action" value="user_logout" />
		<input type="submit" name="logout_submit" value="Выход" />
	</form>
</div><!-- end #logout -->

<div id="print">
	<form action="assets/inc/process.php" method="post">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
		<input type="hidden" name="action" value="print_page" />
		<input type="submit" name="print_button" value="Версия для печати" />
	</form>
</div><!-- end #print -->


<div id="content">
<?php

// Display the balance to date table HTML
echo $bal->buildBalance();

?>
</div><!-- end #content -->

<?php

// Include the footer
include_once 'assets/common/footer.php';

?>
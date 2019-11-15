<?php

class Form {

	public $date;		//The date for which the balance should be built, stored in DD.MM.YYYY format

	public function buildForm()		//Returns HTML markup for date selection
	{
		$html = "";
		if ( $_POST['token']==$_SESSION['token'])
		{
			$this->date = $_POST['datepicker'];
			$DateF = new DateTime($this->date);
			$DateF = $DateF->format('d.m.Y');
			$this->date = "$DateF";
		}

		$html .= <<<FORM_MARKUP
				<div id="dateinput">
					<form method="post">

					<p>Задайте дату: <input type="text" id="datepicker" name="datepicker"> <input type="submit" name="submit" value="OK">
						<input type="hidden" name="token" value="$_SESSION[token]"></p>

					</form>
				</div><!-- end #dateinput -->
FORM_MARKUP;

		return $html;
	}

}

?>
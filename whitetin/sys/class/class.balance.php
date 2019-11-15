<?php

class Balance extends DB_Connect {

	protected $_useDate;		//The date for which the balance should be built, stored in DD.MM.YYYY format

	protected $sql = "select PART, NPACH, PROF, TOL, SHIR, DLIN, VID, Ves, DATAOP, XAR from nalDat(:date), SPROF, SVID, SXAR where nalDat.KPROF = SPROF.KPROF and nalDat.KVID = SVID.KVID and nalDat.KXAR = SXAR.KXAR";

	public function __construct($dbo=NULL, $date=NULL)	// Creates a database object ($dbo) and stores relevant data
// Upon instantiation, this class accepts a database object and calls the parent constructor to ensure $db is a database object. If null, a new PDO object is created and stored instead.
	{
		parent::__construct($dbo); // Calls the parent constructor to check for a database object

		if ( isset($date) )
		{
			$this->_useDate = $date;
		}
		else
		{
			$this->_useDate = date('d.m.Y'); //current date if $date is not set
		}
	}

	protected function _loadBalance($date=NULL)	// Loads DB data into an array
	{
		try
		{
			$stmt = $this->db->prepare($this->sql);
			if ( !empty($date) )	// Bind the parameter if a date was passed
			{
				$stmt->bindParam(':date', $date, PDO::PARAM_STR);
			}
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $results;
		}
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
	}

	protected function FormatNumber($Num)
	{						//Formatting int number as 1 234

		$strN = "$Num";
		$len = strlen($strN)-1;

		$strNf = "";				//Or "00," for 1 234,00

		for ($n=$len, $i=1; $n>=0; $n--, $i++) {

			$strNf .= $strN[$n];

			if ($i%3 == 0) {
				$strNf .= " ";
			}
		}

		$len = strlen($strNf)-1;

		for ($n=$len; $n>=0; $n--) {

			$number .= $strNf[$n];
		}

		return $number;
	}

	public function buildBalance()		//Returns HTML markup to display the balance to date table
	{
		$balance = $this->_loadBalance($this->_useDate);
		$html = "";
		$DateF = new DateTime($this->_useDate);
		$DateF = $DateF->format('d.m.Y');
		$html .= <<<TABLE_MARKUP
				<div id="caption">
					<p>Наличие белой жести на складе ЛПЦ-3 ($DateF):</p>
				</div><!-- end #caption -->

				<table id="balance">
					<thead>
						<tr>
							<th>Партия</th>
							<th>№ пачки</th>
							<th>Профиль</th>
							<th>Толщина<br />мкм:</th>
							<th>Ширина<br />мм:</th>
							<th>Длина<br />мм:</th>
							<th>Назначение</th>
							<th>Вес</th>
							<th>Дата получения</th>
							<th>Характеристика</th>
						</tr>
					</thead>
					<tbody>
TABLE_MARKUP;

		$count = 0;
		$weight = 0;
		foreach ( $balance as $row ) 
		{
			$count++;
			$html .= "<tr>";
			foreach ( $row as $key => $value )
			{
				if ( $key == "DATAOP" ) {

					$DateSF = new DateTime($value);
					$DateSF = $DateSF->format('d.m.Y');
					$html .= "<td>$DateSF</td>";

				}
				else {

				$html .= "<td>$value</td>";

				}

				if ( $key == "Ves" ) {
			
					$weight += $value;
				}
			}

			$html .= "</tr>";
		}

		$countF = $this->FormatNumber($count);
		$weightF = $this->FormatNumber($weight);

		$html .= <<<TABLE_MARKUP
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">Количество пачек (шт): <div>$countF</div></td>
							<td colspan="5">Суммарный вес (кг): <div>$weightF</div></td>
						</tr>
					</tfoot>
				</table>			
TABLE_MARKUP;

		return $html;
	}

}
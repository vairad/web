<?php 

// diky extends mohu pouzivat metody db - jako DBSelect ...
class mista extends db
{
	// konstruktor
	public function mista($connection)
	{
		// timto si nastavim pripojeni k DB, ktere jsem dostal od app()
		$this->connection = $connection;	
	}
	
	
	public function InsertMisto($predmet)
	{
		
	}
	
	
	public function DeleteMisotByID($predmet_id)
	{
		
	}
	
	
	public function GetMistoByID($predmet_id)
	{
       $where_array[] =
        $misto = $this->DBSelectOne(TABLE_MISTA, "*", $where_array, $limit_string = "");

	}
	
	
	public function LoadAllMista()
	{
		$table_name = TABLE_MISTA;
		$select_columns_string = "*"; 
		$where_array = array();
		$limit_string = "";
		$order_by_array = array();
	
		// vrati pole zaznamu v podobe asociativniho pole: sloupec = hodnota
		$predmety = $this->DBSelectAll($table_name, $select_columns_string, $where_array, $limit_string, $order_by_array);
		//printr($predmety);
		
		// tady jeste neco pripadne dochroupat - docist vsechna potrebna data
		
		// vratit data
		return $predmety;
	}
}


?>
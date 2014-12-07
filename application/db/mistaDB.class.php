<?php 

// diky extends mohu pouzivat metody db - jako DBSelect ...
class mistaDB extends db
{
	// konstruktor
	public function mistaDB($connection)
	{
		// timto si nastavim pripojeni k DB, ktere jsem dostal od app()
		$this->connection = $connection;
	}


    /**
     * @param misto $misto
     */
	public function InsertMisto($misto)
	{
        $item["nazev"] = $misto->getName();
        $item["ulice"] = $misto->getStreet();
        $item["cp"] = $misto->getCp();
        $item["gps"] = $misto->getGps();
        $item["popis"] = $misto->getText();
        $item["kapacita"] = $misto->getCapacity();

        printr($item);

        return $this->DBInsert(TABLE_MISTA,$item);
	}
	
	
	public function DeleteMisotByID($misto_id)
	{
        $where_arr[0]["column"]= "id";
        $where_arr[0]["value"]= "$misto_id";
        $where_arr[0]["symbol"]= "=";

        $misto = $this->DBSelectOne(TABLE_MISTA, "*", $where_arr, $limit_string = "");
        return $misto;
	}
	
	
	public function GetMistoByID($misto_id)
	{
        $where_arr[0]["column"]= "id";
        $where_arr[0]["value"]= "$misto_id";
        $where_arr[0]["symbol"]= "=";

        $misto = $this->DBSelectOne(TABLE_MISTA, "*", $where_arr, $limit_string = "");
        return $misto;
	}
	
	
	public function LoadAllMista()
	{
		$table_name = TABLE_MISTA;
		$select_columns_string = "*"; 
		$where_array = array();
		$limit_string = "";
		$order_by_array = array();

		$mista = $this->DBSelectAll($table_name, $select_columns_string, $where_array, $limit_string, $order_by_array);
		//printr($predmety);

		// vratit data
		return $mista;
	}
}


?>
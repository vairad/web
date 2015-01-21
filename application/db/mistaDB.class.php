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
        $item = $misto->getItemDB();
       // printr($item);
        return $this->DBInsert(TABLE_MISTA,$item);
	}

    /**
     * @param int $misto_id
     * @return array[]
     */
	public function GetMistoByID($misto_id)
	{
        $where_arr[0]["column"]= "id_mista";
        $where_arr[0]["value"]= "$misto_id";
        $where_arr[0]["symbol"]= "=";

        $misto = $this->DBSelectOne(TABLE_MISTA, "*", $where_arr, $limit_string = "");
        return $misto;
	}

	/**
	 * @param int $misto_id
	 */
	public function DeleteMistoByID($misto_id){
		$where_arr[0]["column"]= "id_mista";
		$where_arr[0]["value"]= "$misto_id";
		$where_arr[0]["symbol"]= "=";

		$uvedeni = $this->DBDelete(TABLE_MISTA, $where_arr, $limit_string = "");
		return $uvedeni;
	}

	/**
	 * @param misto $misto
	 */
	public function UpdateMistobyID($misto_id, $misto){
		$item = $misto->getItemDB();

		$where_str= "id_mista = $misto_id";

		$limit_string = "";

		return $this->DBUpdate(TABLE_MISTA, $item, $where_str, $limit_string);
	}

	public function LoadAllMista()
	{
		$table_name = TABLE_MISTA;
		$select_columns_string = "*";
		$where_arr = array();
		$limit_string = "";
		$order = array();

		$order[0]["column"]="nazev";
		$order[0]["sort"]="asc";

		$mista = $this->DBSelectAll($table_name, $select_columns_string, $where_arr, $limit_string, $order);

		return $mista;
	}


}


?>
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
        $item= $misto->getItem();
       // printr($item);
        return $this->DBInsert(TABLE_MISTA,$item);
	}

	/*public function DeleteMisotByID($misto_id)
	{
        //TODO dodělat!!!
        $where_arr[0]["column"]= "id";
        $where_arr[0]["value"]= "$misto_id";
        $where_arr[0]["symbol"]= "=";

        $misto = $this->DBSelectOne(TABLE_MISTA, "*", $where_arr, $limit_string = "");
        return $misto;
	}*/

    /**
     * @param int $misto_id
     * @return array[]
     */
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
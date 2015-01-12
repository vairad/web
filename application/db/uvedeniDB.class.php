<?php

class uvedeniDB extends db
{
    public function uvedeniDB($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param uvedeni $uvedeni
     */
    public function InsertUvedeni($uvedeni){
        $item= $uvedeni->getItemDB();
        // printr($item);
        return $this->DBInsert(TABLE_UVEDENI,$item);
    }

    /**
     * @param int $uvedeni_id
     * @return array[]
     */
    public function GetUvedeniByID($uvedeni_id){
        $where_arr[0]["column"]= "id_uvedeni";
        $where_arr[0]["value"]= "$uvedeni_id";
        $where_arr[0]["symbol"]= "=";

        $uvedeni = $this->DBSelectOne(TABLE_UVEDENI, "*", $where_arr, $limit_string = "");
        return $uvedeni;
    }

    public function GetUvedeniInfoByID($uvedeni_id){
        $table_name = TABLE_UVEDENI."`, `".TABLE_HRY."`, `".TABLE_MISTA;
        $select_columns_string = "*, ".TABLE_HRY.".nazev as nazevHry";
        $where_arr = array();
        $limit_string = "";
        $order = array();

        $where_arr[0]["column"]= "id_uvedeni";
        $where_arr[0]["value"]= "$uvedeni_id";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "misto";
        $where_arr[1]["value_mysql"]= "`id_mista`";
        $where_arr[1]["symbol"]= "=";

        $where_arr[2]["column"]= "hra";
        $where_arr[2]["value_mysql"]= "`id_hry`";
        $where_arr[2]["symbol"]= "=";

        $order[0]["column"]="zacatek";
        $order[0]["sort"]="asc";

        $item = $this->DBSelectOne($table_name, $select_columns_string, $where_arr, $limit_string, $order);

        // vratit data

            $item["zacatek"]=cze_datum($item["zacatek"]);

        return $item;
    }

    /**
     * @param int $uvedeni_id
     */
    public function DeleteUvedeniByID($uvedeni_id){
        $where_arr[0]["column"]= "id_uvedeni";
        $where_arr[0]["value"]= "$uvedeni_id";
        $where_arr[0]["symbol"]= "=";

        $uvedeni = $this->DBDelete(TABLE_UVEDENI, $where_arr, $limit_string = "");
        return $uvedeni;
    }


    public function LoadAllUvedeniInfo()
    {
        $table_name = TABLE_UVEDENI."`, `".TABLE_HRY."`, `".TABLE_MISTA;
        $select_columns_string = "*, ".TABLE_HRY.".nazev as nazevHry";
        $where_arr = array();
        $limit_string = "";
        $order = array();

        $where_arr[0]["column"]= "hra";
        $where_arr[0]["value_mysql"]= "`id_hry`";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "misto";
        $where_arr[1]["value_mysql"]= "`id_mista`";
        $where_arr[1]["symbol"]= "=";

        $order[0]["column"]="zacatek";
        $order[0]["sort"]="asc";

        $uvedeni = $this->DBSelectAll($table_name, $select_columns_string, $where_arr, $limit_string, $order);

        // vratit data
        foreach($uvedeni as &$item){
            $item["zacatek"]=cze_datum($item["zacatek"]);
        }
        return $uvedeni;
    }

    public function setFlag($uvedeni){

        $where_str = "id_uvedeni= $uvedeni AND flag = false";

        $item["flag"] = true;

        $result = $this->DBUpdate(TABLE_UVEDENI, $item, $where_str, "");
        return $result;
    }

    public function unsetFlag($uvedeni){

        $where_str = "id_uvedeni= $uvedeni AND flag = true";

        $item["flag"] = false;

        $result = $this->DBUpdate(TABLE_UVEDENI, $item, $where_str, "");
        return $result;
    }

    /**
     * @param int $uvedeni_id
     * @return array[]
     */
    public function GetUvedeniByOrg($org_id){
        $where_arr[0]["column"]= "id_osoby";
        $where_arr[0]["value"]= "$org_id";
        $where_arr[0]["symbol"]= "=";

        $where_arr[0]["column"]= "id_hry";
        $where_arr[0]["value_mysql"]= "`hra`";
        $where_arr[0]["symbol"]= "=";

        $uvedeni = $this->DBSelectAll(TABLE_UVEDENI."`, `".TABLE_HRY, "*", $where_arr, $limit_string = "");
        return $uvedeni;
    }

}


?>
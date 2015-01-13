<?php
/**
 * Created by PhpStorm.
 * User: Radek
 * Date: 8.12.2014
 * Time: 13:37
 */

class hryDB extends db {

    // konstruktor
    public function hryDB($connection)
    {
        $this->connection = $connection;
    }


    /**
     * @param hra $hra
     */
    public function InsertHra($hra)
    {
        $item = $hra->getItemDB();
       // printr($item);
        return $this->DBInsert(TABLE_HRY,$item);
    }


   /* public function DeleteHraByID($hra_id)
    {
        //TODO dodělat
        $where_arr[0]["column"]= "id";
        $where_arr[0]["value"]= "$hra_id";
        $where_arr[0]["symbol"]= "=";

        $hra = $this->DBSelectOne(TABLE_HRY, "*", $where_arr, $limit_string = "");
        return $hra;
    }*/


    /**
     * @param int $hra_id
     * @return array[]
     */
    public function getHraByID($hra_id)
    {
        $where_arr[0]["column"]= "id_hry";
        $where_arr[0]["value"]= "$hra_id";
        $where_arr[0]["symbol"]= "=";

        $hra = $this->DBSelectOne(TABLE_HRY, "*", $where_arr, $limit_string = "");
        return $hra;
    }


    public function LoadAllHry()
    {
        $table_name = TABLE_HRY;
        $select_columns_string = "*";
        $where_array = array();
        $limit_string = "";
        $order_by_array = array();
        $order_by_array[0]["column"]="nazev";
        $order_by_array[0]["sort"]="asc";

        $hry = $this->DBSelectAll($table_name, $select_columns_string, $where_array, $limit_string, $order_by_array);
        //printr($predmety);

        // vratit data
        return $hry;
    }

    public function DeleteHraByID($hra_id){
        $where_arr[0]["column"]= "id_hry";
        $where_arr[0]["value"]= "$hra_id";
        $where_arr[0]["symbol"]= "=";

        $result = $this->DBDelete(TABLE_HRY, $where_arr, $limit_string = "");
        return $result;
    }

    /**
     * @param hra $hra
     * @param $hra_id id_hry
     */
    public function UpdateHrabyID($hra_id, $hra){
        $item = $hra->getItemDB();

        $where_str= "id_hry = $hra_id";

        $limit_string = "";

        //TODO check

        return $this->DBUpdate(TABLE_HRY, $item, $where_str, $limit_string);
    }

} 
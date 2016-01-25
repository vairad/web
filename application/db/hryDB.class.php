<?php

/***********************************************************************************************************************
 * Class hryDB
 *
 * Třída určená pro komunikaci s tabulkou her. Jednotlivé metody představují speciální pohledy a příkazy nad danou
 * tabulkou, které jsou vystavěné nad základními operacemi ve třídě db.
 *
 * @author Radek VAIS
 */

class hryDB extends db {

    /*******************************************************************************************************************
     * Konstruktor
     *
     * @param $connection - třída PDO connection
     */
    public function hryDB($connection)
    {
        $this->connection = $connection;
    }

    /*******************************************************************************************************************
     * Vloží hru do databáze dle objektu hra
     *
     * @param $hra hra - objekt pro záznam do databáze
     * @return
     */
    public function InsertHra($hra)
    {
        $item = $hra->getItemDB();
        return $this->DBInsert(TABLE_HRY,$item);
    }

    /*******************************************************************************************************************
     *
     */
    public function getHraByID($hra_id)
    {
        $where_arr[0]["column"]= "id_hry";
        $where_arr[0]["value"]= "$hra_id";
        $where_arr[0]["symbol"]= "=";

        $hra = $this->DBSelectOne(TABLE_HRY, "*", $where_arr, $limit_string = "");
        return $hra;
    }


    /*******************************************************************************************************************
     *
     *
     */
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

    /*******************************************************************************************************************
     *
     *
     */
    public function LoadAllHryNoServis()
    {
        $table_name = TABLE_HRY;
        $select_columns_string = "*";
        $where_array = array();
        $limit_string = "";
        $order_by_array = array();
        $order_by_array[0]["column"]="nazev";
        $order_by_array[0]["sort"]="asc";

        $where_array[1]["column"]= "servis";
        $where_array[1]["value_mysql"]= "0";
        $where_array[1]["symbol"]= "=";

        $hry = $this->DBSelectAll($table_name, $select_columns_string, $where_array, $limit_string, $order_by_array);
        //printr($predmety);

        // vratit data
        return $hry;
    }


    /*******************************************************************************************************************
     * Metoda smaže hru dle zvoleného id z databáze.
     *
     * @param $hra_id int - identifikátor hry (id_hry)
     * @return int - počet smazaných řádků
     */
    public function DeleteHraByID($hra_id){

        $where_arr[0]["column"]= "id_hry";
        $where_arr[0]["value"]= "$hra_id";
        $where_arr[0]["symbol"]= "=";

        $result = $this->DBDelete(TABLE_HRY, $where_arr, $limit_string = "");
        return $result;
    }

    /*******************************************************************************************************************
     * Aktualizuje záznam dle zadaného id na hodnoty objektu hra
     *
     * @param $hra hra - objekt data/hra.class s nastavenými, pro úpravu
     * @param $hra_id int - identifikátor hry v databázi
     */
    public function UpdateHrabyID($hra_id, $hra){
        $item = $hra->getItemDB();

        $where_str= "id_hry = $hra_id";

        $limit_string = "";

        return $this->DBUpdate(TABLE_HRY, $item, $where_str, $limit_string);
    }

} 
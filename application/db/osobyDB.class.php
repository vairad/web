<?php

// diky extends mohu pouzivat metody db - jako DBSelect ...
class osobyDB extends db
{

    public function osobyDB($connection)
    {
        $this->connection = $connection;
    }


    /***
     * @param $hrac_class hrac
     */
    public function InsertOsoba($hrac_class)
    {
       $item = $hrac_class->getItem();
        // uložení do db
        //printr($item);
      return $this->DBInsert(TABLE_OSOBY, $item);
    }

    /**
     * @return bool | item osoba
     * */
    public function GetOsobaByLogin($mail,$pass)
    {
        $where_arr[0]["column"]= "email";
        $where_arr[0]["value"]= "%".$mail."%";
        $where_arr[0]["symbol"]= "LIKE";

        $where_arr[1]["column"]= "heslo";
        $where_arr[1]["value"]= sha1($pass);
        $where_arr[1]["symbol"]= "=";

        return $this->DBSelectOne(TABLE_OSOBY,"*",$where_arr);
    }

    /**
     * @return bool | item osoba
     * */
    public function UpdatePassByIDandPass($id ,$pass, $new_pass)
    {
       /* $where_arr[0]["column"]= "id_osoby";
        $where_arr[0]["value"]= "$id";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "heslo";
        $where_arr[1]["value"]= sha1($pass);
        $where_arr[1]["symbol"]= "="; */

        $where_str = "id_osoby = $id and heslo = '".sha1($pass)."'";

        $item["heslo"] = sha1($new_pass);

        return $this->DBUpdate(TABLE_OSOBY, $item, $where_str);
    }

    public function GetOsobaName($id)
    {
        $where_arr[0]["column"]= "id_osoby";
        $where_arr[0]["value"]= "$id";
        $where_arr[0]["symbol"]= "=";

        return $this->DBSelectOne(TABLE_OSOBY,"jmeno, prijmeni, prezdivka",$where_arr);
    }

    /**
     * @param int $rights_val
     * @return array[]
     */
    public function GetOsobyByRights($rights_val)
    {
        $where_arr[0]["column"]= "typuctu";
        $where_arr[0]["value"]= $rights_val;
        $where_arr[0]["symbol"]= ">=";

        $order = $this->abecedne();
        return $this->DBSelectAll(TABLE_OSOBY,"id_osoby, jmeno, prijmeni, prezdivka",$where_arr, "", $order);
    }

    /**
     *
     * @param int $rights_val
     * @return
     */
    public function UpdateOsobaRights($osoba, $rights_val)
    {
        $item["typuctu"]=$rights_val;

        return $this->DBUpdate(TABLE_OSOBY, $item, "id_osoby = $osoba and typuctu != ".CREATE_RIGHTS, "");
    }



    public function SelectAllOsobyInfo()
    {
        $table_name = TABLE_OSOBY;
        $select_columns_string = "id_osoby, jmeno, prijmeni, prezdivka, datnar, pohlavi, email, mobil, typuctu";
        $where_array = array();
        $limit_string = "";
        $order_by_array = $this->abecedne();

        $mista = $this->DBSelectAll($table_name, $select_columns_string, $where_array, $limit_string, $order_by_array);
        //printr($predmety);

        // vratit data
        return $mista;
    }

    private function abecedne(){
        $order = array();
        $order[0]["column"]="prijmeni";
        $order[0]["sort"]="asc";

        $order[1]["column"]="jmeno";
        $order[1]["sort"]="asc";

        $order[2]["column"]="prezdivka";
        $order[2]["sort"]="asc";
        return $order;
    }
}


?>
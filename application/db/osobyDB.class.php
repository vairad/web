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
       $item["jmeno"]=$hrac_class->getName();
       $item["prijmeni"]=$hrac_class->getSurname();
       $item["prezdivka"]=$hrac_class->getNick();

       $item["datnar"]=$hrac_class->getDate();
       $item["pohlavi"]=$hrac_class->getSex();

       $item["mobil"]=$hrac_class->getMobil();
       $item["email"]=$hrac_class->getMail();
       $item["heslo"]=$hrac_class->getPass();

        // uložení do db
      return $this->DBInsert(TABLE_OSOBY, $item);
    }

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



    public function DeleteOsobaByID($predmet_id)
    {

    }


    public function GetOsobaByID($predmet_id)
    {

    }


    public function LoadAllOsoby()
    {

    }
}


?>
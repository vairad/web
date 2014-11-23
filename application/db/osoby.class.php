<?php

// diky extends mohu pouzivat metody db - jako DBSelect ...
class osoby extends db
{

    public function osoby($connection)
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
       $this->DBInsert(TABLE_OSOBY, $item);
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
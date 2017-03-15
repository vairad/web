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
    public function insertText()
    {
        //todo proyslet automatizaci
    }

    /**
     * @return bool | item osoba
     * */
    public function getTextByKey($key)
    {
        $where_arr[0]["column"]= "key";
        $where_arr[0]["value"]= "$key";
        $where_arr[0]["symbol"]= "=";

        return $this->DBSelectOne(TABLE_TEXTY,"*",$where_arr);
    }


    /**
     * @return bool | item osoba
     * */
    public function updateTextByKey($key , $new_text)
    {
        $where_str = "key = $key";

        $item["text"] = $new_text;

        return $this->DBUpdate(TABLE_TEXTY, $item, $where_str);
    }


}


?>
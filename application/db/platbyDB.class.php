<?php


class platbyDB extends db
{
    public function platbyDB($connection)
    {
        $this->connection = $connection;
    }


    public function platil($uziv){
        $where_arr[0]["column"]= "kdo";
        $where_arr[0]["value"]= "$uziv";
        $where_arr[0]["symbol"]= "=";

        $platby = $this->DBSelectAll(TABLE_PLATBY,"castka" ,$where_arr);
        $sum = 0;
        foreach($platby as $castka){
            $sum += $castka["castka"];
        }
        return $sum;
    }
}

?>
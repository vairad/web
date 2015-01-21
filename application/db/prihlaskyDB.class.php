<?php


class prihlaskyDB extends db
{
    public function prihlaskyDB($connection)
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

    public function prihlas($uziv, $uvedeni){
        if($_SESSION[MY_SES]["user"]["pohlavi"] == 1){
            //prihlas muze
            if($this->obsazenoM($uvedeni) && $this->obsazenoH($uvedeni)){
                return false;
            }else{
                $item["hrac"] = $uziv;
                $item["uvedeni"] = $uvedeni;
                return $this->DBInsert(TABLE_PRIHLASKY,$item);
            }
        }
        if($_SESSION[MY_SES]["user"]["pohlavi"] == 0){
            // prihlas zenu
            if($this->obsazenoZ($uvedeni) && $this->obsazenoH($uvedeni)){
                return false;
            }else{
                $item["hrac"] = $uziv;
                $item["uvedeni"] = $uvedeni;
                return $this->DBInsert(TABLE_PRIHLASKY,$item);
            }
        }
    }

    public function odhlas($uziv, $uvedeni){

        $where_arr[0]["column"]= "hrac";
        $where_arr[0]["value"]= "$uziv";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "uvedeni";
        $where_arr[1]["value"]= "$uvedeni";
        $where_arr[1]["symbol"]= "=";

        return $this->DBDelete(TABLE_PRIHLASKY,$where_arr,"");
    }

    public function prihlasen($uziv, $uvedeni){
        $where_arr[0]["column"]= "hrac";
        $where_arr[0]["value"]= "$uziv";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "uvedeni";
        $where_arr[1]["value"]= "$uvedeni";
        $where_arr[1]["symbol"]= "=";

        return count($this->DBSelectAll(TABLE_PRIHLASKY,"*" ,$where_arr));
    }

    public function mojeUvedeni($uziv){
        $table_name = TABLE_UVEDENI.", ".TABLE_HRY.", ".TABLE_MISTA.", ".TABLE_PRIHLASKY;

        $select_columns_string = "*, ".TABLE_HRY.".nazev as nazevhry";
        $where_arr = array();
        $limit_string = "";
        $order = array();

        $where_arr[0]["column"]= "hrac";
        $where_arr[0]["value"]= "$uziv";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "hra";
        $where_arr[1]["value_mysql"]= "id_hry";
        $where_arr[1]["symbol"]= "=";

        $where_arr[2]["column"]= "misto";
        $where_arr[2]["value_mysql"]= "id_mista";
        $where_arr[2]["symbol"]= "=";

        $where_arr[3]["column"]= "uvedeni";
        $where_arr[3]["value_mysql"]= "id_uvedeni";
        $where_arr[3]["symbol"]= "=";

        $order[0]["column"]="zacatek";
        $order[0]["sort"]="asc";

        $uvedeni = $this->DBSelectAll($table_name, $select_columns_string, $where_arr, $limit_string, $order);

        // vratit data
        foreach($uvedeni as &$item){
            $item["z"] = timestamp($item["zacatek"]);
            $item["zacatek"]=cze_datum($item["zacatek"]);
        }
        return $uvedeni;
    }

    public function nestihnes($uziv, $uvedeni){

        return false;
    }

    public function obsazenoM($uvedeni_id){
        $uvedeniDB = new uvedeniDB($this->connection);
        $hryDB = new hryDB($this->connection);
        $uvedeni = $uvedeniDB->GetUvedeniByID($uvedeni_id);
        $hra = $hryDB->getHraByID($uvedeni["hra"]);

        if($this->pocet_muzu($uvedeni_id) >= $hra["pocet_m"]){
            return true;
        }
        return false;
    }

    public function obsazenoZ($uvedeni_id){
        $uvedeniDB = new uvedeniDB($this->connection);
        $hryDB = new hryDB($this->connection);
        $uvedeni = $uvedeniDB->GetUvedeniByID($uvedeni_id);
        $hra = $hryDB->getHraByID($uvedeni["hra"]);

        if($this->pocet_zen($uvedeni_id) >= $hra["pocet_z"]){
            return true;
        }
        return false;
    }

    public function obsazenoH($uvedeni_id){
        $uvedeniDB = new uvedeniDB($this->connection);
        $hryDB = new hryDB($this->connection);
        $uvedeni = $uvedeniDB->GetUvedeniByID($uvedeni_id);
        $hra = $hryDB->getHraByID($uvedeni["hra"]);

        $kapacita = 0 + $hra["pocet_m"]+$hra["pocet_z"]+$hra["pocet_h"];
        if($kapacita == 0){
            return true;
        }

        $kapacita -= $this->pocet_muzu($uvedeni_id);
        $kapacita -= $this->pocet_zen($uvedeni_id);

        if($kapacita <= 0){
            return true;
        }
        return false;
    }

    public function obsazeno($uvedeni){
        $bool = $this->obsazenoM($uvedeni);
        $bool &= $this->obsazenoZ($uvedeni);
        $bool &= $this->obsazenoH($uvedeni);
        return $bool;
    }

    public function pocet_muzu($uvedeni){
        $where_arr[0]["column"]= "uvedeni";
        $where_arr[0]["value"]= "$uvedeni";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "pohlavi";
        $where_arr[1]["value"]= "1";
        $where_arr[1]["symbol"]= "=";

        $where_arr[2]["column"]= "hrac";
        $where_arr[2]["value_mysql"]= "id_osoby";
        $where_arr[2]["symbol"]= "=";

        return count($this->DBSelectAll(TABLE_PRIHLASKY.", ".TABLE_OSOBY, "*", $where_arr));
    }

    public function pocet_zen($uvedeni){
        $where_arr[0]["column"]= "uvedeni";
        $where_arr[0]["value"] = "$uvedeni";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "pohlavi";
        $where_arr[1]["value"]= "0";
        $where_arr[1]["symbol"]= "=";

        $where_arr[2]["column"]= "hrac";
        $where_arr[2]["value_mysql"]= "id_osoby";
        $where_arr[2]["symbol"]= "=";

        return count($this->DBSelectAll(TABLE_PRIHLASKY.", ".TABLE_OSOBY, "*", $where_arr));
    }

    public function prihlaseni($uvedeni){
        $where_arr[0]["column"]= "uvedeni";
        $where_arr[0]["value"]= "$uvedeni";
        $where_arr[0]["symbol"]= "=";

        $where_arr[1]["column"]= "hrac";
        $where_arr[1]["value_mysql"]= "id_osoby";
        $where_arr[1]["symbol"]= "=";

        return $this->DBSelectAll(TABLE_PRIHLASKY.", ".TABLE_OSOBY, "*", $where_arr);

    }


}

?>
<?php
/**
 * Created by PhpStorm.
 * User: Radek
 * Date: 7.12.2014
 * Time: 17:50
 */

class uvedeni {
    private $id;

    /**@var hra */
    private $game;
    /** @var  misto */
    private $place;

    private $start;

    public $set_up = array();

    //===========================================================


    public function uvedeniFromDB($item, $connection)
    {
        $this->setStartDB($item["zacatek"]);
        $this->setID($item["id_uvedeni"]);
        $this->setGame($item["hra"], $connection);
        $this->setPlace($item["misto"], $connection);
    }

    public function uvedeni()
    {
        $this->set_up["game"] = false;
        $this->set_up["place"] = false;
        $this->set_up["start"] = false;
    }

    public function getItem(){
        $item["zacatek"] = $this->getStart();
        $item["misto"] = $this->place->getID();
        $item["hra"] = $this->game->getID();

        return $item;
    }

    //===========================================================

    /**
     * @param uvedeniDB
     * @return bool
     */
    public function toDB($db){
        $bool = true;
        //  $debug[]= $bool;
        // $debug["index"]= array();
        foreach($this->set_up as $index ) {
            $bool &= $index;
            //      $debug[]=$bool;
            //      $debug["index"][]=$index;
        }
        //  printr($debug);
        if($bool) {
            return $db->InsertUvedeni($this);
        }
        return false;
    }

    //===========================================================

    /**
     * @param int id of chosen game
     * @param  conection to the database
     */
    public function setGame($idGame, $connection){
        global $data;

        $db = new hryDB($connection);
        $game = new hra();
        $DBitem = $db->getHraByID($idGame);
        $game->hraFromDB($DBitem);
        if($game !=false){
            $this->set_up["game"] = true;
            $this->game = $game;
        }else{
            $data["per_fail"]["game"]=1;
            $data["data"]["error"][]="Hra v databázi nebyla nalezena";
            $this->set_up["game"] = false;
        }
    }

    /**
     * @param int id of chosen place
     * @param  conection to the database
     */
    public function setPlace($idGame, $connection){
       global $data;

        $db = new mistaDB($connection);
        $DBitem = $db->getMistoByID($idGame);
        $place = new misto();
        $place->mistoFromDb($DBitem);
        if($place !=false){
            $this->set_up["place"] = true;
            $this->place = $place;
        }else{
            $data["per_fail"]["place"]=1;
            $data["data"]["error"][]="Místo v databázi nebylo nalezeno";
            $this->set_up["place"] = false;
        }
    }

    /**
     * @param $datetime
     */
    public function setStart($timestamp){
       global $data;

        if(!empty($timestamp) && $timestamp)
        {
            $date = timeToData($timestamp);
            if($date != false){
                $this->start=$date;
                $this->set_up["start"]=true;
            }
            else{
                $data["per_fail"]["start"]=1;
                $this->set_up["start"]=false;
            }
        }
        else {
            $data["per_fail"]["start"]=1;
            $data["data"]["error"][]="Začátek uvedení není existující čas!";
            $this->set_up["start"]=false;
        }


    }

    /**
     * @param $timeDB
     */
    public function setStartDB($timeDB){
        $this->set_up["start"]=true;
        $this->start=$timeDB;
    }

    /**
     * @param $timeDB
     */
    public function setID($id){
        $this->set_up["id"]=true;
        $this->id=$id;
    }

    public function getStart(){
        return $this->start;
    }

    public function getID(){
        return $this->id;
    }

    //==========================================================




}

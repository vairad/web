<?php

class hra {
    private $id;

    private $name;
    private $need, $text;
    private $num_m, $num_f, $num_h, $num_p, $min;
    private $length, $cost;
    private $web;
    private $org;
    private $servis = "FALSE";

    public $set_up = array();

    //===========================================================

    public function hraFromDb($item){
        $this->setID($item["id_hry"]);
        $this->setName($item["nazev"]);

        $this->setText($item["popis"]);
        $this->setNeed($item["special"]);

        $this->setNumM($item["pocet_m"]);
        $this->setNumF($item["pocet_z"]);
        $this->setNumH($item["pocet_h"]);
        $this->setNumP($item["pocet_p"]);
        $this->setMin($item["min"]);

        $this->setLength($item["delka"]);
        $this->setCost($item["cena"]);

        $this->setWeb($item["web"]);
        $this->setOrg($item["organizator"]);

        $this->setServis($item["servis"]);
    }


    public function hra()
    {
        $this->set_up["name"] = false;
        $this->set_up["text"] = false;
        $this->set_up["num_m"] = false;
        $this->set_up["num_f"] = false;
        $this->set_up["num_h"] = false;
        $this->set_up["min"] = false;
        $this->set_up["length"] = false;
        $this->set_up["cost"] = false;
        $this->set_up["web"] = false;
        $this->set_up["org"] = false;
        $this->set_up["servis"] = true;

    }


    public function getItemDB(){
        $item["nazev"] = $this->getName();
        $item["popis"] = $this->getText();
        $item["delka"] = $this->getLength();
        $item["cena"] = $this->getCost();
        $item["pocet_m"] = $this->getNumM();
        $item["pocet_z"] = $this->getNumF();
        $item["pocet_h"] = $this->getNumH();
        $item["pocet_p"] = $this->getNumP();
        $item["min"] =  $this->getMin();
        $item["organizator"] = $this->getOrg();
        $item["web"] = $this->getWeb();
        $item["special"] = $this->getNeed();
        $item["servis"] = $this->getServis();

        return $item;
    }

    public function getItemForm(){
        $item["name"] = $this->getName();
        $item["text"] = $this->getText();
        $item["length"] = $this->getLength();
        $item["cost"] = $this->getCost();
        $item["num_m"] = $this->getNumM();
        $item["num_f"] = $this->getNumF();
        $item["num_h"] = $this->getNumH();
        $item["num_p"] = $this->getNumP();
        $item["num_min"] =  $this->getMin();
        $item["org"] = $this->getOrg();
        $item["web"] = $this->getWeb();
        $item["special"] = $this->getNeed();
        $item["servis"] = $this->getServis() == "TRUE";

        return $item;
    }

    //===========================================================

    /**
     * @param hryDB $hra_db_class
     * @return bool
     */
    public function toDB($hra_db_class){
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
            return $hra_db_class->InsertHra($this);
        }
        return false;
    }

    /**
     * @param hryDB $hra_db_class
     * @return bool
     */
    public function updateDB($hra_db_class, $id_game){
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
            $bool = $hra_db_class->UpdateHrabyId($id_game, $this) > 0;
            return $bool ;
        }
        return false;
    }

    //=================================================================
    /**
     * @param int $cost
     */
    public function setCost($cost)
    {
        $this->set_up["cost"] = true;
        $this->cost = $cost;
    }

    /**
     * @param int $cost
     */
    public function setID($id)
    {
        $this->set_up["id"] = true;
        $this->id = $id;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->set_up["length"] = true;
        $this->length = $length;
    }

    /**
     * @param int $min
     */
    public function setMin($min)
    {
        $this->set_up["min"] = true;
        $this->min = $min;
    }

    /**
     * @param int $mun_m
     */
    public function setNumM($mun_m)
    {
        $this->set_up["num_m"] = true;
        $this->num_m = $mun_m;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->set_up["name"] = true;
        $this->name = $name;
    }

    /**
     * @param string $need
     */
    public function setNeed($need)
    {
        $this->set_up["need"] = true;
        $this->need = $need;
    }

    /**
     * @param int $num_f
     */
    public function setNumF($num_f)
    {
        $this->set_up["num_f"] = true;
        $this->num_f = $num_f;
    }

    /**
     * @param int $num_h
     */
    public function setNumH($num_h)
    {
        $this->set_up["num_h"] = true;
        $this->num_h = $num_h;
    }

    /**
     * @param int $num_p
     */
    public function setNumP($num_p)
    {
        $this->set_up["num_p"] = true;
        $this->num_p = $num_p;
    }

    /**
     * @param int $org
     */
    public function setOrg($org)
    {
        $this->set_up["org"] = true;
        $this->org = $org;
    }

    /**
     * @param string $web
     */
    public function setWeb($web)
    {
        $this->set_up["web"] = true;
        $this->web = $web;
    }

    /**
     * @param string $text with html tags
     */
    public function setText($text)
    {
        $this->set_up["text"] = true;
        $this->text = $text;
    }

    /**
     * @param bool $servis if
     */
    public function setServis($bool)
    {
        $this->set_up["servis"] = true;
        $this->servis = $bool == true ? "TRUE" : "FALSE";

    }

    //==================================================================

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getNeed()
    {
        return $this->need;
    }

    /**
     * @return mixed
     */
    public function getNumF()
    {
        return $this->num_f;
    }

    /**
     * @return mixed
     */
    public function getNumH()
    {
        return $this->num_h;
    }

    /**
     * @return mixed
     */
    public function getNumP()
    {
        return $this->num_p;
    }

    /**
     * @return mixed
     */
    public function getNumM()
    {
        return $this->num_m;
    }

    /**
     * @return mixed
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * @return array
     */
    public function getSetUp()
    {
        return $this->set_up;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @return mixed
     */
    public function getServis()
    {
        return $this->servis;
    }
    //==================================================================

} 
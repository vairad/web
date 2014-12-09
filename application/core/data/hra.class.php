<?php

class hra {
    private $name, $text;
    private $num_m, $num_f, $num_h, $min;
    private $length, $cost;
    private $web;
    private $org;

    public $set_up = array();

    //===========================================================

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

    }


    public function getItem(){
        $item["nazev"] = $this->getName();
        $item["popis"] = $this->getText();
        $item["delka"] = $this->getLength();
        $item["cena"] = $this->getCost();
        $item["pocet_m"] = $this->getNumM();
        $item["pocet_z"] = $this->getNumF();
        $item["pocet_h"] = $this->getNumH();
        $item["min"] =  $this->getMin();
        $item["organizator"] = $this->getOrg();

        return $item;
    }

    //===========================================================

    /**
     * @param hryDB $mista_db_class
     * @return bool
     */
    public function toDB($mista_db_class){
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
            return $mista_db_class->InsertHra($this);
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


    //==================================================================

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
    //==================================================================

} 
<?php
/**
 * Created by PhpStorm.
 * User: Radek
 * Date: 7.12.2014
 * Time: 17:50
 */

class misto {
    private $id;

    private $name;
    private $street, $cp;
    private $gps;
    private $text;
    private $capacity;

    public $set_up = array();

    //===========================================================

    public function mistoFromDb($item){
        $this->setID($item["id_mista"]);
        $this->setCapacity($item["kapacita"]);
        $this->setCp($item["cp"]);
        $this->setGps($item["gps"]);
        $this->setName($item["nazev"]);
        $this->setStreet($item["ulice"]);
        $this->setText($item["popis"]);
    }

    public function misto()
    {
        $this->set_up["name"] = false;
        $this->set_up["street"] = false;
        $this->set_up["cp"] = false;
        $this->set_up["gps"] = false;
        $this->set_up["text"] = false;
        $this->set_up["capacity"] = false;
    }

    public function getItemDB(){
        $item["nazev"] = $this->getName();
        $item["ulice"] = $this->getStreet();
        $item["cp"] = $this->getCp();
        $item["gps"] = $this->getGps();
        $item["popis"] = $this->getText();
        $item["kapacita"] = $this->getCapacity();

        return $item;
    }

    public function getItemForm(){
        $item["name"] = $this->getName();
        $item["street"] = $this->getStreet();
        $item["cp"] = $this->getCp();
        $item["gps"] = $this->getGps();
        $item["text"] = $this->getText();
        $item["capacity"] = $this->getCapacity();

        return $item;
    }

    //===========================================================

    /**
     * @param mistaDB $mista_db_class
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
           return $mista_db_class->InsertMisto($this);
        }
        return false;
    }

    /**
     * @param mistaDB $mista_db_class
     * @return bool
     */
    public function updateDB($mista_db_class, $id_mista){
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
            $bool = $mista_db_class->UpdateMistobyID($id_mista, $this) > 0;
            return true;
        }
        return false;
    }

    //===========================================================

    /**
     * @param int $id
     */
    public function setID($id){
        $this->set_up["id"] = true;
        $this->id = $id;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity($capacity)
    {
        $this->set_up["capacity"] = true;
        $this->capacity = $capacity;
    }

    /**
     * @param int $cp
     */
    public function setCp($cp)
    {
        $this->set_up["cp"] = true;
        $this->cp = $cp;
    }

    /**
     * @param string $gps
     */
    public function setGps($gps)
    {
        $this->set_up["gps"] = true;
        $this->gps = $gps;
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
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->set_up["street"] = true;
        $this->street = $street;
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
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }


    /**
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }
    /**
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @return string
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getSetUp()
    {
        return $this->set_up;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string with html tags
     */
    public function getText()
    {
        return $this->text;
    }
    //==========================================================




}

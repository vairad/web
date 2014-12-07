<?php

class hrac {
    private $name, $surname, $nick;
    private $sex;
    private $date;
    private $mail, $mobil;

    private $pass;
    private $type;
    private $last, $create;

    public $set_up = array();

    function __construct()
    {

    }

    //===========================================================

    /**
     * @param osobyDB $osoby_db_class
     * @return bool
     */
    public function toDB($osoby_db_class){
       return $osoby_db_class->InsertOsoba($this);
    }

   //===========================================================


    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->set_up["date"]=true;
        $this->date = $date;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->set_up["mail"]=true;
        $this->mail = $mail;
    }

    /**
     * @param mixed $mobil
     */
    public function setMobil($mobil)
    {
        $this->set_up["mobil"]=true;
        $this->mobil = $mobil;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->set_up["name"]=true;
        $this->name = $name;
    }

    /**
     * @param mixed $nick
     */
    public function setNick($nick)
    {
        $this->set_up["nick"]=true;
        $this->nick = $nick;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->set_up["pass"]=true;
        $this->pass = sha1($pass);
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->set_up["sex"]=true;
        $this->sex = $sex;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->set_up["surname"]=true;
        $this->surname = $surname;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->set_up["type"]=true;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCreate()
    {
        return $this->create;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @return mixed
     */
    public function getMobil()
    {
        return $this->mobil;
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
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

//=====================================================================




} 
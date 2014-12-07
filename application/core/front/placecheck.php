<?php

global $data;
global $misto;

$misto = new misto();

if(!isset($_POST["name"]))$_POST["jmeno"]="";

if(!isset($_POST["street"]))$_POST["street"]="";
if(!isset($_POST["cp"]))$_POST["cp"]="";
if(!isset($_POST["gps"]))$_POST["gps"]="";

if(!isset($_POST["text"]))$_POST["text"]="";

if(!isset($_POST["capacity"]))$_POST["capacity"]="";

$err = array();

/*proměnná jmeno*/
if( !empty($_POST["name"]) and delka(3,$_POST["name"],60) )
{
    $name=trim($_POST["name"]);
    $name=strip_tags($name);

    $data["place"]["name"]=$name;
    $misto->setName($name);
    $misto->set_up["name"]=true;
}
else {
    $data["place_fail"]["name"]=1;
}

/*proměnná street*/
if( !empty($_POST["street"]) and delka(3,$_POST["street"],100) )
{
    $street=trim($_POST["street"]);
    $street=strip_tags($street);

    $data["place"]["street"]=$street;
    $misto->setStreet($street);
    $misto->set_up["street"]=true;
}
else {
    $data["place_fail"]["street"]=1;
    $misto->set_up["street"]=false;
    $err[]="Název ulice musí mít minimálně 3 písmena.";
}


/* proměnná gps */
if( !empty($_POST["gps"]) and delka(0,$_POST["gps"],45) )
{
    $gps=trim($_POST["gps"]);
    $gps=strip_tags($gps);

    $data["place"]["gps"]=$gps;
    $misto->setGps($gps);
    $misto->set_up["gps"]=true;
}
else {
    $data["place_fail"]["gps"]=1;
    $misto->set_up["gps"]=false;
}


/* proměnná capacity  */
if( !empty($_POST["capacity"]))
{
    $capacity=trim($_POST["capacity"]);
    if (is_numeric($capacity) and delka(1,$capacity,11) ){
        $data["place"]["capacity"]=$capacity;
        $misto->setCapacity($capacity);
        $misto->set_up["capacity"]=true;
    }
    else {
        $data["place_fail"]["capacity"]=1;
        $misto->set_up["capacity"]=false;
        $err[]="Kapacita musí být číslo větší než nula";
    }
}
else {
    $data["place_fail"]["capacity"]=1;
    $misto->set_up["capacity"]=true;
   $err[]="Kapacita musí být zadána";
}


/* proměnná cp  */
if( !empty($_POST["cp"]))
{
    $cp=trim($_POST["cp"]);
    if (is_numeric($cp) and delka(0,$cp,11) ){
        $data["place"]["cp"]=$cp;
        $misto->setcp($cp);
        $misto->set_up["cp"]=true;
    }
    else {
        $data["place_fail"]["cp"]=1;
        $misto->set_up["cp"]=false;
        $err[]="Číslo popisné musí být číslo";
    }
}
else {
   //muze byt prazdne
  //  $data["place_fail"]["cp"]=1;
    $misto->set_up["cp"]=true;
}


/*proměnná text*/
if(!empty($_POST["text"]))
{
    $text=trim($_POST["text"]);
   // $text=strip_tags($text);

    $data["place"]["text"]=$text;
    $misto->setText($text);
    $misto->set_up["text"]=true;
}
else {
    $data["place_fail"]["text"]=1;
    $err[]="Musíte zadat popis místa.";
}

if(isset($err[0])){
    $data["data"]["error"] = array();
    $data["data"]["error"] = $err;
}


?>
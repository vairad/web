<?php
/**
 * Created by PhpStorm.
 * User: Radek
 * Date: 7.12.2014
 * Time: 22:33
 */

//magic number 123

global $data;
global $hra;

$hra = new hra();

if(VERBOSE) {
    printr($_POST);
}

if(!isset($_POST["name"]))$_POST["name"]="";

if(!isset($_POST["num_m"]))$_POST["num_m"]="";
if(!isset($_POST["num_f"]))$_POST["num_f"]="";
if(!isset($_POST["num_h"]))$_POST["num_h"]="";
if(!isset($_POST["num_p"]))$_POST["num_p"]="";

if(!isset($_POST["num_min"]))$_POST["num_min"]="";

if(!isset($_POST["text"]))$_POST["text"]="";
if(!isset($_POST["web"]))$_POST["web"]="";

if(!isset($_POST["length"]))$_POST["length"]="";

$err = array();

/*proměnná jmeno*/
if( !empty($_POST["name"]) and delka(3,$_POST["name"],60) )
{
    $name=trim($_POST["name"]);
    $name=strip_tags($name);

    $data["game"]["name"]=$name;
    $hra->setName($name);
    $hra->set_up["name"]=true;
}
else {
    $data["game_fail"]["name"]=1;
    $err[]="Název musí mít alespoň tři znaky";
}

//===================================================================================================================
/* proměnná num_m  */
if( is_numeric($_POST["num_m"]))
{
    $num_m=trim($_POST["num_m"]);
    if (delka(1,$num_m,11) ){
        $data["game"]["num_m"]=$num_m;
        $hra->setNumM($num_m);
        $hra->set_up["num_m"]=true;
    }
    else {
        $data["game_fail"]["num_m"]=1;
        $hra->set_up["num_m"]=false;
        $err[]="Počet mužských rolí musí být číslo.";
    }
}
else {
    $data["game_fail"]["num_m"]=1;
    $hra->set_up["num_m"]=false;
    $err[]="Počet mužských rolí musí být zadán.";
}


//===================================================================================================================
/* proměnná num_f  */

if(is_numeric($_POST["num_f"]))
{
    $num_f=trim($_POST["num_f"]);
    if(delka(1,$num_f,11) ){
        $data["game"]["num_f"]=$num_f;
        $hra->setNumF($num_f);
        $hra->set_up["num_f"]=true;
    }
    else {
        $data["game_fail"]["num_f"]=1;
        $hra->set_up["num_f"]=false;
        $err[]="Počet ženských rolí musí být číslo.";
    }
}
else {
    $data["game_fail"]["num_f"]=1;
    $hra->set_up["num_f"]=true;
    $err[]="Počet ženských rolí musí být zadán.";
}


//===================================================================================================================
/* proměnná num_h  */
if( is_numeric($_POST["num_h"]))
{
    $num_h=trim($_POST["num_h"]);
    if(delka(1,$num_h,11) ){
        $data["game"]["num_h"]=$num_h;
        $hra->setNumH($num_h);
    }
    else {
        $data["game_fail"]["num_h"]=1;
        $hra->set_up["num_h"]=false;
        $err[]="Počet obojetných rolí musí být číslo.";
    }
}
else {
     $data["game_fail"]["num_h"]=1;
     $hra->set_up["num_h"]=false;
     $err[]="Počet obojetných rolí musí být zadán.";
}


//===================================================================================================================
/* proměnná num_min  */
if( !empty($_POST["num_min"]))
{
    $num_min=trim($_POST["num_min"]);
    if (is_numeric($num_min) and delka(1,$num_min,11) ){
        $data["game"]["num_min"]=$num_min;
        $hra->setMin($num_min);
    }
    else {
        $data["game_fail"]["num_min"]=1;
        $hra->set_up["num_min"]=false;
        $err[]="Minimální počet hráčů musí být číslo.";
    }
}
else {
   //nula prázdné pole = 0
    $hra->setMin(0);
}

//===================================================================================================================
/* proměnná num_p  */
if(is_numeric($_POST["num_p"]))
{
    $num_p=trim($_POST["num_p"]);
    if(delka(1,$num_p,11) ){
        $data["game"]["num_p"]=$num_p;
        $hra->setNumP($num_p);
        $hra->set_up["num_p"]=true;
    }
    else {
        $data["game_fail"]["num_p"]=1;
        $hra->set_up["num_p"]=false;
        $err[]="Počet prémiových míst musí být číslo.";
    }
}
else {
    $data["game_fail"]["num_p"]=1;
    $hra->set_up["num_p"]=true;
    $err[]="Počet prémiových míst musí být zadán.";
}
//===================================================================================================================

/* proměnná cost  */
if( !empty($_POST["cost"]))
{
    $cost=trim($_POST["cost"]);
    if (is_numeric($cost) and delka(1,$cost,11) ){
        $data["game"]["cost"]=$cost;
        $hra->setCost($cost);
    }
    else {
        $data["game_fail"]["cost"]=1;
        $hra->set_up["cost"]=false;
        $err[]="Cena musí být číslo.";
    }
}
else {
    $data["game_fail"]["cost"]=1;
    $hra->set_up["cost"]=false;
    $err[]="Cena musí být zadána.";
}

//===================================================================================================================

/* proměnná length  */
if( !empty($_POST["length"]))
{
    $length=trim($_POST["length"]);
    if (is_numeric($length) and delka(1,$length,11) ){
        $data["game"]["length"]=$length;
        $hra->setLength($length);
    }
    else {
        $data["game_fail"]["length"]=1;
        $hra->set_up["length"]=false;
        $err[]="Délka hry musí být číslo.";
    }
}
else {
    $data["game_fail"]["length"]=1;
    $hra->set_up["length"]=false;
    $err[]="Délka hry musí být zadána.";
}

//===================================================================================================================

/* proměnná org magické číslo 123 */
if( !empty($_POST["org"]))
{
    $org=trim($_POST["org"]);
    if (is_numeric($org) and delka(1,$org,11) ){
        $data["game"]["org"]=$org;
        $hra->setOrg($org-123); //magic number
    }
    else {
        $data["game_fail"]["org"]=1;
        $hra->set_up["org"]=false;
        $err[]="Problém se zadáním organozátora, prosím kontaktujte administrátora webu.";
    }
}
else {
    $data["game_fail"]["org"]=1;
    $hra->set_up["org"]=false;
    $err[]="Organizátor musí být zadán.";
}

//===================================================================================================================

/*proměnná text*/
if(!empty($_POST["text"]))
{
    $text=trim($_POST["text"]);
    // $text=strip_tags($text);

    $data["game"]["text"]=$text;
    $hra->setText($text);
}
else {
    $data["game_fail"]["text"]=1;
    $err[]="Musíte zadat popis hry.";
}
//===================================================================================================================

/*proměnná special*/
if(!empty($_POST["special"]))
{
    $text=trim($_POST["special"]);

    $data["game"]["special"]=$text;
    $hra->setNeed($text);
}
else {
   // speciální potřeby nejsou nutné
}

//===================================================================================================================

/*proměnná web*/

    $web=trim($_POST["web"]);
    $web=strip_tags($web);

    $data["game"]["web"]=$web;
    $hra->setWeb($web);

//===================================================================================================================

/*proměnná servis*/

if(!isset($_POST["servis"])){
    $servis=false;
}else{
    $servis=true;
}

$data["game"]["servis"]=$servis;
$hra->setServis($servis);

//===================================================================================================================
//výpis chyb

if(isset($err[0])){
    $data["data"]["error"] = array();
    $data["data"]["error"] = $err;
}


?>
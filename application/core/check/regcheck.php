<?php
global $data;
global $hrac;

$hrac = new hrac();

if(!isset($_POST["rights"]))$_POST["rights"]=FALSE;

if(!isset($_POST["name"]))$_POST["jmeno"]="";
if(!isset($_POST["surname"]))$_POST["prijmeni"]="";
if(!isset($_POST["nick"]))$_POST["prezdivka"]="";

if(!isset($_POST["pass_1"]))$_POST["heslo_1"]="";
if(!isset($_POST["pass_2"]))$_POST["heslo_2"]="";

if(!isset($_POST["mail_1"]))$_POST["mail_1"]="";
if(!isset($_POST["mail_2"]))$_POST["mail_2"]="";
if(!isset($_POST["mobil"]))$_POST["mobil"]="";

if(!isset($_POST["date"]))$_POST["date"]="";

if(!isset($_POST["sex"]))$_POST["sex"]="";

/*proměnná jmeno*/
if( !empty($_POST["name"]) and delka(3,$_POST["name"],50) )
{
    $name=trim($_POST["name"]);
    $name=strip_tags($name);

    $data["reg"]["name"]=$name;
    $hrac->setName($name);
    $hrac->set_up["name"]=true;
}
else {
    $data["reg_fail"]["name"]=1;
    $hrac->set_up["name"]=false;
}

/*proměnná prijmeni*/
if( !empty($_POST["surname"]) and delka(3,$_POST["surname"],50) )
{
    $surname=trim($_POST["surname"]);
    $surname=strip_tags($surname);

    $data["reg"]["surname"]=$surname;
    $hrac->setSurname($surname);
    $hrac->set_up["surname"]=true;
}
else {
    $data["reg_fail"]["surname"]=1;
    $hrac->set_up["surname"]=false;
}

//   echo " <script> alert(\"prijmeni\")</script>";

/*proměnná MAIL */
if( !empty($_POST["mail_1"]) and !empty($_POST["mail_2"]) and $_POST["mail_1"]==$_POST["mail_2"] and je_mail($_POST["mail_1"]))
{
    $mail=trim($_POST["mail_1"]);
    $mail=strip_tags($mail);
    $mail=strtolower($mail);

    $data["reg"]["mail_1"]=$mail;
    $data["reg"]["mail_2"]=$mail;
    $hrac->setMail($mail);
    $hrac->set_up["mail"]=true;

}
else {

    if(empty($_POST["mail_1"]) or empty($_POST["mail_2"])){
        $data["data"]["error"][] = "Nezadal email dvakrát pro kontrolu překlepu.";
    }elseif($_POST["mail_1"]!=$_POST["mail_2"]){
        $data["data"]["error"][] = "Zadané emaily se neshodují.";
    }elseif(!je_mail($_POST["mail_1"])){
        $data["data"]["error"][] = "Zadaný email neodpovídá syntaxi emailové adresy.";
    }

    $data["reg_fail"]["mail"]=1;
    $hrac->set_up["mail"]=false;
}

/*proměnná HESLO */
if( !empty($_POST["pass_1"]) and $_POST["pass_1"]==$_POST["pass_2"] and delka(3,$_POST["pass_1"],50))
{
    $heslo=trim($_POST["pass_1"]);

    $hrac->setPass($heslo);
    $hrac->set_up["pass"]=true;

}
else {
    $data["reg_fail"]["pass"]=1;
    $hrac->set_up["pass"]=false;
}


/* proměnná DATNAR */
// echo $_POST["date"];
if(!empty($_POST["date"]))
{
    $date = dateToData($_POST["date"]);
    if($date != false){
        $data["reg"]["date"]=$_POST["date"];
        $hrac->setDate($date);
        $hrac->set_up["date"]=true;
    }
    else{
        $data["reg_fail"]["date"]=1;
        $hrac->set_up["date"]=false;
    }
}
else {
    $data["reg_fail"]["date"]=1;
    $hrac->set_up["date"]=false;
}


//mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )



/* proměnná PREZDIVKA */
if( !empty($_POST["nick"]) and delka(0,$_POST["nick"],50) )
{
    $prezdivka=trim($_POST["nick"]);
    $prezdivka=strip_tags($prezdivka);

    $data["reg"]["nick"]=$prezdivka;
    $hrac->setNick($prezdivka);
    $hrac->set_up["nick"]=true;
}
else {
    $data["data"]["error"][] = "Vyplň prosím přezdívku abychom věděli jak Tě vhodně oslovit.";
    $data["reg_fail"]["nick"]=1;
    $hrac->set_up["nick"]=false;
}


/* proměnná MOBIL  */
if( !empty($_POST["mobil"]))
{
    $mobil=trim($_POST["mobil"]);
    if (is_numeric($mobil) and delka(9,$mobil,9) ){
        $data["reg"]["mobil"]=$mobil;
        $hrac->setMobil($mobil);
        $hrac->set_up["mobil"]=true;
    }
    else {
        $data["reg_fail"]["mobil"]=1;
        $hrac->set_up["mobil"]=false;
        }
}
else {
    $data["reg_fail"]["mobil"]=1;
    $hrac->set_up["mobil"]=false;
}

/* proměnná POHLAVÍ  */
if( $_POST["sex"]=="male"  )
{
    $data["reg"]["sex"]=$_POST["sex"];
    $data["reg"]["male"]="checked";
    $hrac->setSex(1);
    $hrac->set_up["nick"]=true;
}
else if ($_POST["sex"]=="female"){
    $data["reg"]["sex"]=$_POST["sex"];
    $hrac->setSex(0);
    $hrac->set_up["nick"]=true;
}
else{
    $data["reg_fail"]["sex"]=1;
    $hrac->set_up["sex"]=false;
}

?>

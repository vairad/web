<?php

/**
 * Hlavní třída aplikace, které se stará o zobrazení a zpracování správné stránky aplikace.
 * Probíhá zde kontrola oprávnění k prováděným činnostem.
 *
 */

class app
{
    // objekt konektivity s databází...
    private $db = null;


    public function app()
    {
        $this->db = new db();
    }

    public function GetConnection()
    {
        return $this->db->GetConnection();
    }

    /**
     * Pripojit k databazi.
     */
    public function Connect()
    {
        $this->db->Connect();
    }

    //===============================================================================================================
    //===============================================================================================================
    //===============================================================================================================
    //===============================================================================================================

    /**
    Zpracuj url = vypočti vše potřebné
     */
    public function zpracujPoz(){
        global $data;

        //nastav title stránky
        $data["title"] = TITLE;
        //nastav první položku vodorovného menu
        $this->appendNavbar(TITLE, "index.php");

        // najdi elementy id a do v $_post/$_get/$_cookie
        $id = @$_REQUEST["id"];
        $do = @$_REQUEST["do"];

        // booleovské proměnné kontroly práv
        $admin = isset($_SESSION[MY_SES]["user"]["rights"]) && $_SESSION[MY_SES]["user"]["rights"]>=ADMIN_RIGHTS;
        $prihl = isset($_SESSION[MY_SES]["user"]["flag"]) && $_SESSION[MY_SES]["user"]["flag"]==true;

        // nastav aktivní prvky menu
        $data["menu"][$id]["aktiv"]="active";
        $data["menu_member"][$id]["aktiv"]="active";
        $data["menu_admin"][$id]["aktiv"]="active";


        // jeden dlouhy else-if, ve kterem se rozhodne, co zpracovat

//=============ADMIN============================================

        if($id=="vhra" && $admin) {//==================================== správa her
            $this->appendNavbar("Vytvoř hru", "index.php?id=vhra");
            $this->stranaSpravaHer($do);

        }elseif($id=="vmisto" && $admin){//============================== správa míst
            $this->appendNavbar("Správa míst", "index.php?id=vmisto");
            $this->stranaSpravaMist($do);

        }elseif($id=="vuved" && $admin){//=============================== správa uvedení
            $this->appendNavbar("Správa uvedení", "index.php?id=vuved");
            $this->stranaVytvorUvedeni($do);

        }elseif($id=="prava" && $admin){//=============================== nastavení práv
            $this->appendNavbar("Nastavení oprávnění", "index.php?id=prava");
            $this->stranaPrava($do);

        }elseif($id=="uzivatele" && $admin){//=========================== seznam uživatelů
            $this->appendNavbar("Seznam uživatelů", "index.php?id=uzivatele", true);
            $this->stranaSeznamUziv($do);

//============PRIHLASENY=========================================

        }elseif($id=="prihl" && $prihl){//=============================== přihlašování na hry
            $this->appendNavbar("Přihlašování na hry", "index.php?id=prihl");
            $data["nadpis"]="Přihlašování na hry";
            $this->stranaPrihlasovani();

        }elseif($id=="mujprog" && $prihl){//============================= můj program
            $this->appendNavbar("Můj program", "index.php?id=mujprog");
            $data["nadpis"]="Můj program";
            $this->stranaMujProgram();

        }elseif($id=="mujucet" && $prihl){//============================== můj účet
            $this->appendNavbar("Můj účet", "index.php?id=mujucet");
            $data["nadpis"]="Můj účet";
            $this->mujUcet($do);

        }elseif($id=="misto" && $prihl){//================================ informace o místě
            $this->appendNavbar("Detail místa", "", true);
            $this->stranaMisto(@$_REQUEST["val"]);

        }elseif($id=="orghry" && $prihl){//=============================== hráči na hrách
            $this->appendNavbar("Mé uvedení", "index.php?id=orghry");
            $data["nadpis"]="Mé uvedení";
            $this->stranaMeHry();

//===========PUBLIC==============================================

        }elseif($id=="akce"){//=========================================== informace o akci
            $this->appendNavbar("O akci", "index.php?id=akce");
            $data["nadpis"]="Akce";
            $data["content"]="text";
            $data["obsah"] = TEXT_O_AKCI;

        }elseif($id=="hry"){//============================================ uváděné hry
            $this->appendNavbar("Uváděné hry", "index.php?id=hry");

            if(isset($_REQUEST["val"])){
                $val = @$_REQUEST["val"];
            }else{
                $val = "none";
            }
            $this->stranaHra($val);

        }elseif($id=="letos"){//========================================== letošní ročník
            $this->appendNavbar("Letošní ročník", "index.php?id=letos");
            $data["nadpis"]="Letošní ročník";
            $data["content"]="text";
            $data["obsah"]= TEXT_LETOS;

        }elseif($id=="cena"){//=========================================== cena
            $this->appendNavbar("Cena", "index.php?id=cena");
            $data["nadpis"]="Cena";
            $data["content"]="text";
            $data["obsah"]= TEXT_CENA;

        }elseif($id=="reg" && !$prihl){//================================= registrace
            $this->appendNavbar("Registrace", "index.php?id=reg");
            $this->stranaRegistrace($do);

        }elseif($id=="forgot" && !$prihl){//================================= zapomenuté heslo
            $this->appendNavbar("Zapomenuté heslo", "", true);
            $this->stranaNoveHeslo($do);

        }else{//========================================================== index
            $this->resetNavbar();
            $this->appendNavbar(TITLE, "index.php");
            $this->stranaIndex();
        }
    }

    //===============================================================================================================
    //===============================================================================================================
    //===============================================================================================================
    //===============================================================================================================

    /**
     * Funkce nastaví hodnoty odkazů zobrazovaných v patičce stránky
     */
    public function setFooter(){
        global $data;
        $data["footer_left_a"]="http://www.pilirionos.org/pro-verejnost";
        $data["footer_left"]="Co je to larp?";

        $data["footer_right_a"]="http://www.pilirionos.org/";
        $data["footer_right"]="Pilirion o.s.";
    }

    //===============================================================================================================
    //===============================================================================================================

    /**
     * Funkce nastaví vlajky a základní data k zobrazení do šablony
     */
    public function setLogged(){
        global $data;
        if(isset($_SESSION[MY_SES]["user"]["flag"]) && $_SESSION[MY_SES]["user"]["flag"] == true){
            $data["logged"]=$_SESSION[MY_SES]["user"]["rights"];
            $data["user"]["name"]=$_SESSION[MY_SES]["user"]["name"];
            $data["user"]["nick"]=$_SESSION[MY_SES]["user"]["nick"];
            $data["user"]["surname"]=$_SESSION[MY_SES]["user"]["surname"];
        }else{
            $data["logged"]=false;
            $_SESSION[MY_SES]["user"]["flag"]=false;
        }
    }

    /**
     * Funkce provede přihlášení v závislosti na nastavení hodnot v poli $_POST
     * a nastaví informace o uživateli do $session...[user] proměnné
     */
    public function login(){
        global $data;

        $osoby = new osobyDB($this->GetConnection());
        $user = $osoby->GetOsobaByLogin(trim($_POST["login"]), trim($_POST["pass"]));

        if(!isset($user["jmeno"]) || $user["jmeno"]==""){
            $data["data"]["error"] = array();
            $data["data"]["error"][]="Špatná kombinace jména a hesla.";
        }else{
            $data["data"]["success"]="Přihlášení bylo úspěšné";
            $_SESSION[MY_SES]["user"]= array();
            $_SESSION[MY_SES]["user"]["flag"]=true;
            $_SESSION[MY_SES]["user"]["name"]="".$user["jmeno"];
            $_SESSION[MY_SES]["user"]["nick"]="".$user["prezdivka"];
            $_SESSION[MY_SES]["user"]["surname"]="".$user["prijmeni"];
            $_SESSION[MY_SES]["user"]["id"]=0 + $user["id_osoby"];
            $_SESSION[MY_SES]["user"]["rights"]=0 + $user["typuctu"];
            $_SESSION[MY_SES]["user"]["pohlavi"]=0 + $user["pohlavi"];
        }
    }

    /**
     * Funkce provede odhlášení, zruší proměnnou session...[user]
     */
    public function logout(){
        global $data;
        $_SESSION[MY_SES] = array();
        unset($_SESSION[MY_SES]["user"]);
        unset($_SESSION[MY_SES]);
        session_unset();
        $data["data"]["success"]="Odhlášení proběhlo úspěšně.";
    }

    //===============================================================================================================
    //===============================================================================================================

    public function stranaHra($val){
        if($val == 'none'){
            $this->seznamHer();
        }else{
            $this->jendaHra($val);
        }
    }

    public function seznamHer(){
        global $data;

        $data["nadpis"]="Uváděné hry";
        $data["content"]="seznamHer";

        //pole her
        $hryDB = (new hryDB($this->GetConnection()));
        $hry = $hryDB->LoadAllHry();
        $data["games"] = array();
        $data["games"] = $hry;
    }

    public function jendaHra($val){
        global $data;

        $hryDB = (new hryDB($this->GetConnection()));
        $data["game"] =  $hryDB->getHraByID($val);

        $this->appendNavbar($data["game"]["nazev"], "", true);

        $osobyDB = new osobyDB($this->GetConnection());
        $org = $osobyDB->GetOsobaName($data["game"]["organizator"]);

        $data["game"]["organizator"] = $org["jmeno"]." \"".$org["prezdivka"]."\" ".$org["prijmeni"];
        $data["nadpis"]=$data["game"]["nazev"];
        $data["content"]="infoHra";

    }

    //===============================================================================================================
    //===============================================================================================================

    public function stranaMisto($val){
        if($val == 'none'){
            $this->seznamMist();
        }else{
            $this->jendoMisto($val);
        }
    }

    public function seznamMist(){
        global $data;

        $data["nadpis"]="Reálná místa";
        $data["content"]="seznamMist";

        //pole her
        $mistaDB = (new mistaDB($this->GetConnection()));
        $hry = $mistaDB->LoadAllMista();
        $data["places"] = array();
        $data["places"] = $hry;
    }

    public function jendoMisto($val){
        global $data;

        $mistaDB = (new mistaDB($this->GetConnection()));
        $data["place"] =  $mistaDB->getMistoByID($val);

        $data["place"]["googleGPS"]=googleGPS($data["place"]["gps"]);
        $this->appendNavbar($data["place"]["nazev"], "", true);

        $data["nadpis"]=$data["place"]["nazev"];
        $data["content"]="infoMisto";

    }

    //===============================================================================================================
    //===============================================================================================================


    public function  stranaSpravaHer($do){
        global $data;

        if($do == 'new' || $do == 'create') { //create case ================
            $this->appendNavbar("Tvorba hry", "", true);
            $this->stranaFormularHra($do);


        } else if($do == 'delete'){ //delete case ================

            /*smazat místo*/
            $hryDB = new hryDB($this->GetConnection());
            $result = $hryDB->DeleteHraByID((@$_REQUEST["val"]-456)); //magic hash number
            if($result == 1){
                $data["data"]["success"]="Hra byla úspěšně smazána";
            }else{
                if(isset($result[0]) && ($result[0] == 23000 || $result[0] == 23503 )){ //check sql error value
                    $data["data"]["error"][]="Nelze odstranit hru. Je naplánované její uvedení.";
                }else{
                    $data["data"]["error"][]="Chyba při operaci s databází, hra nebyla smazána.";
                }
            }
            //show list
            $this->appendNavbar("Seznam všech her", "", true);
            $this->stranaSeznamHer($do);


        } else if($do == 'manage'){ //list case ================

            $this->appendNavbar("Seznam všech her", "", true);
            $this->stranaSeznamHer($do);

        }else if($do == 'edit'){//edit case ================

            $hryDB = new hryDB($this->GetConnection());
            $item = $hryDB->GetHraByID(@$_REQUEST["val"]-456); //magic hash number
            $hra = new hra();
            $hra->hraFromDb($item);
            $formItem = $hra->getItemForm();

            $data["game"] = array();
            $data["game"] = $formItem;

            $this->appendNavbar("Uprav hru", "", true);
            $this->stranaFormularHra($do);

        }else{ //place menu case ================
            $data["nadpis"] = "Správa her";
            $data["content"] = "smisto";

            $data["info"] = "Pro spravování her zvolte jednu z možností.";

            $data["a"] = array();
            $data["a"][0]["title"] = "Vytvořit novou hru";
            $data["a"][0]["href"] = "index.php?id=vhra&do=new#body";
            $data["a"][1]["title"] = "Seznam všech her";
            $data["a"][1]["href"] = "index.php?id=vhra&do=manage#body  ";
        }

    }

    //===============================================================================================================
    //===============================================================================================================


    public function stranaMujProgram(){ //TODO better view
        global $data;

        $data["content"]="proglist";
        $data["obsah"] = TEXT_MUJ_PROGRAM;

        $prihlaskyDB = new prihlaskyDB($this->GetConnection());
        $data["performances"] = $prihlaskyDB->mojeUvedeni($_SESSION[MY_SES]["user"]["id"]);
    }

    //===============================================================================================================
    //===============================================================================================================

    public function mujUcet($do){
        global $data;

        if($do == 'pass'){
            $this->stranaZmenHeslo();
        }
        elseif($do == 'acount'){
            $this->stranaZmenUdaje();
        }else{
            $this->stranaInfoUdaje();
        }

    }

    public function stranaZmenHeslo(){
        global $data;

        $bool = isset($_POST["pass_old"]); // musí být nastavené nějaké staré heslo
        $bool &= isset($_POST["pass_1"]); // nové heslo
        $bool &= isset($_POST["pass_2"]); // nové heslo pro kontrolu překlepu
        $bool &= $bool && $_POST["pass_1"] == $_POST["pass_2"]; // samotná kontrola bool je zde napsán kvůli
                                                                // neúplnému zpracování booleaovských proměnných
                                                                // pokud nebudou definovány, neprovede se porovnání

        if($bool){

            //interface databáze
            $osobyDB = new osobyDB($this->GetConnection());

            //samotná změna
            $result = $osobyDB->UpdatePassByIDandPass($_SESSION[MY_SES]["user"]["id"],
                                                        $_POST["pass_old"],
                                                        $_POST["pass_1"]
                                                        );
            // kontrola výsledku
            if($result == 1){
                $data["data"]["success"] = "Heslo bylo úspěšně změněno.";
                $this->stranaInfoUdaje();

                return; //skok na stranu změny údajů, proto návrat z této metody

            }else{
                $data["data"]["error"][] = "Heslo NEBYLO změněno.";
            }
        }

        $this->appendNavbar("Změna hesla", "", true);
        $data["nadpis"] = "Změna hesla";
        $data["info"] = HESLO_INFO;
        $data["content"] = "change_pass";

    }

    public function stranaZmenUdaje(){

    }

    public function stranaInfoUdaje(){
        global $data;

        $data["Nadpis"] = "Můj účet";
        $data["content"] = "info_osoba";

        $data["a"] = array();
        $data["a"][0]["title"] = "Změnit heslo";
        $data["a"][0]["href"] = "index.php?id=mujucet&do=pass#body";

       /* $data["a"][1]["title"] = "Změnit údaje";
        $data["a"][1]["href"] = "index.php?id=mujucet&do=acount#body";*/
    }

    //===============================================================================================================
    //===============================================================================================================

    public function stranaSeznamHer(){
        global $data;

        $data["nadpis"]="Seznam her";
        $data["content"]="lhra";

        //pole uvedení do seznamu pod formulář
        $hryDB = (new hryDB($this->GetConnection()));
        $hry = $hryDB->LoadAllHry();
        $data["games"] = array();
        $data["games"] = $hry;

        // vytvořeni tlačítek pro smazání
        foreach ($data["games"] as &$value){
            $msg = "Opravdu chcete smazat hru: \\n"
                .$value["nazev"];
            $value["delA"] = "confimElement(\"".$msg."\", \"vhra\", ".($value["id_hry"]+456).", \"delete\")"; //magic hash number
        }

        // vytvořeni tlačítek pro editaci
        foreach ($data["games"] as &$value){
            $msg = "Chcete upravit hru: \\n"
                .$value["nazev"];
            $value["updateA"] = "confimElement(\"".$msg."\", \"vhra\", ".($value["id_hry"]+456).", \"edit\")"; //magic hash number
        }
    }

    //===============================================================================================================
    //===============================================================================================================

    public function stranaFormularHra($do){
        global $data;

        //pole organizátorů do formuláře
        $osobyDB = new osobyDB($this->GetConnection());
        $orgove = $osobyDB->GetOsobyByRights(ORG_RIGHTS);
        $data["orgove"] = array();
        $data["orgove"] = $orgove;

        //nastavení minule zvoleného
        if(isset($_POST["org"]) || isset($data["game"]["org"])) {
            if(isset($data["game"]["org"])){
                $_POST["org"] = $data["game"]["org"]+123;
            }
            for ($i = 0; $i< count($data["orgove"]); $i++) {
                if ($data["orgove"][$i]["id_osoby"] == ($_POST["org"]-123)) { //magic 123 hash number
                    $data["orgove"][$i]["selected"] = "selected";
                }
            }
        }

        if(isset($_REQUEST["val"])){
            $data["nadpis"]="Uprav hru";
            $data["content"]="vhra";
            $data["formSubmit"]="Uprav hru!";

            $data["game"]["val"] = "&val=".$_REQUEST["val"];

            if($do != 'edit') {
                $hra = new hra();
                require_once("check/gamecheck.php");
                $hryDB = new hryDB($this->GetConnection());

                $database = $hra->updateDB($hryDB, $_REQUEST["val"]-456);

                if ($database == true) {
                    $data["data"]["success"] = "Hra byla úspěšně upravena";
                    //zobrazit prázdný formulář
                    $this->stranaSeznamHer();
                } else {
                    if (!isset($data["data"]["error"][0])) {
                        $data["data"]["error"][] = "Nebylo možné upravit hru.";
                    }
                }
            }
        }else{

            $data["nadpis"] = "Vytvoř hru";
            $data["content"] = "vhra";
            $data["formSubmit"]="Vytvoř hru!";

            //printr($_POST);
            // die;
            if($do=="create"){
                // kontrola dat a uložení do databáze
                $hra = new hra();
                require_once("check/gamecheck.php");
                $hry = new hryDB($this->GetConnection());
                $database = $hra->toDB($hry);

                // výpis uživateli
                if($database == true){
                    $data["data"]["success"]="Hra byla úspěšně vytvořena";
                    //zobrazit prázdný formulář
                    unset($data["game"]);
                }
                else {
                    if(!isset($data["data"]["error"][0])) {
                        $data["data"]["error"][] = "Hra se stejným názvem již existuje";
                    }
                }
            }
        }
    }

    //===============================================================================================================
    //===============================================================================================================


    public function stranaSpravaMist($do){
        global $data;

        if($do == 'new' || $do == 'create') { //create case ================
            $this->appendNavbar("Tvorba místa", "", true);
            $this->stranaFormularMisto($do);


        } else if($do == 'delete'){ //delete case ================

            /*smazat místo*/
            $mistaDB = new mistaDB($this->GetConnection());
            $result = $mistaDB->DeleteMistoByID((@$_REQUEST["val"]-456)); //magic hash number
            if($result == 1){
                $data["data"]["success"]="Místo bylo úspěšně smazáno.";
            }else{
                if(isset($result[0]) && ($result[0] == 23000  || $result[0] == 23503)){ //check sql error value
                    $data["data"]["error"][]="Nelze odstranit místo. Je používáno pro uvedení her.";
                }else{
                    $data["data"]["error"][]="Chyba při operaci s databází, místo nebylo smazáno.";
                }
            }
                    //show list
            $this->appendNavbar("Seznam všech míst", "", true);
            $this->stranaSeznamMist($do);


        } else if($do == 'manage'){ //list case ================

            $this->appendNavbar("Seznam všech míst", "", true);
            $this->stranaSeznamMist($do);

        }else if($do == 'edit'){//edit case ================

            $mistaDB = new mistaDB($this->GetConnection());
            $item = $mistaDB->GetMistoByID(@$_REQUEST["val"]-456); //magic hash number
            $misto = new misto();
            $misto->mistoFromDb($item);
            $formItem = $misto->getItemForm();

            $data["place"] = array();
            $data["place"] = $formItem;

            $this->appendNavbar("Uprav místo", "", true);
            $this->stranaFormularMisto($do);

        }else{ //place menu case ================
            $data["nadpis"] = "Správa míst";
            $data["content"] = "smisto";

            $data["info"] = "Pro spravování míst zvolte jednu z výše uvedených možností.";

            $data["a"] = array();
            $data["a"][0]["title"] = "Vytvořit nové místo";
            $data["a"][0]["href"] = "index.php?id=vmisto&do=new#body";
            $data["a"][1]["title"] = "Seznam všech míst";
            $data["a"][1]["href"] = "index.php?id=vmisto&do=manage#body  ";
        }

    }

    public function stranaFormularMisto($do){
        global $data;

        if(isset($_REQUEST["val"])){
            $data["nadpis"]="Uprav místo";
            $data["content"]="vmisto";
            $data["formSubmit"]="Uprav místo!";

            $data["place"]["val"] = "&val=".$_REQUEST["val"];

            if($do != 'edit') {
                $misto = new misto();
                require_once("check/placecheck.php");
                $mista = new mistaDB($this->GetConnection());

                $database = $misto->updateDB($mista, $_REQUEST["val"]-456);

                if ($database == true) {
                    $data["data"]["success"] = "Místo bylo úspěšně upraveno";
                    //zobrazit prázdný formulář
                    $this->stranaSeznamMist();
                } else {
                    if (!isset($data["data"]["error"][0])) {
                        $data["data"]["error"][] = "Nebylo možné upravit místo.";
                    }
                }
            }
        }else{
            $data["nadpis"]="Vytvor misto";
            $data["content"]="vmisto";
            $data["formSubmit"]="Vytvoř místo!";

            if($do=="create"){
                $misto = new misto();
                require_once("check/placecheck.php");
                $mista = new mistaDB($this->GetConnection());
                $database = $misto->toDB($mista);
                if($database == true){
                    $data["data"]["success"]="Místo bylo úspěšně vytvořeno";
                    //zobrazit prázdný formulář
                    unset($data["place"]);
                }
                else {
                    if(!isset($data["data"]["error"][0])) {
                        $data["data"]["error"][] = "Místo se stejným názvem již existuje";
                    }
                }
            }
        }
    }

    public function stranaSeznamMist(){
        global $data;

        $data["nadpis"]="Seznam mist";
        $data["content"]="lmisto";

        //pole uvedení do seznamu pod formulář
        $mistaDB = (new mistaDB($this->GetConnection()));
        $mista = $mistaDB->LoadAllMista();
        $data["places"] = array();
        $data["places"] = $mista;

        // vytvořeni tlačítek pro smazání
        foreach ($data["places"] as &$value){
            $msg = "Opravdu chcete smazat místo: \\n"
                .$value["nazev"]." (".$value["ulice"]." ".$value["cp"].")";
            $value["delA"] = "confimElement(\"".$msg."\", \"vmisto\", ".($value["id_mista"]+456).", \"delete\")"; //magic hash number
        }

        // vytvořeni tlačítek pro editaci
        foreach ($data["places"] as &$value){
            $msg = "Chcete upravit místo: \\n"
                .$value["nazev"]." (".$value["ulice"]." ".$value["cp"].")";
            $value["updateA"] = "confimElement(\"".$msg."\", \"vmisto\", ".($value["id_mista"]+456).", \"edit\")"; //magic hash number
        }
    }

    //===============================================================================================================
    //===============================================================================================================

    public function stranaVytvorUvedeni($do){
        global $data;

        $data["nadpis"]="Správa uvedení";
        $data["content"]="vuved";
        $data["titleform"]="Uvést hru";
        $data["titlelist"]="Naplánované hry";

        //pole her do formuláře
        $hryDB = new hryDB($this->GetConnection());
        $hry = $hryDB->LoadAllHry();
        $data["games"] = array();
        $data["games"] = $hry;

        //pole míst do formuláře
        $mistaDB = (new mistaDB($this->GetConnection()));
        $mista = $mistaDB->LoadAllMista();
        $data["places"] = array();
        $data["places"] = $mista;

        //nastavení minule zvolene hry
        if(isset($_POST["game"])) {
            for ($i = 0; $i< count($data["games"]); $i++) {
                if ($data["games"][$i]["id_hry"] == ($_POST["game"])) {
                    $data["games"][$i]["selected"] = "selected";
                    break; // jen jeden zvoleny
                }
            }
        }  //nastavení minule zvoleného mista
        if(isset($_POST["place"])) {
            for ($i = 0; $i< count($data["places"]); $i++) {
                if ($data["places"][$i]["id_mista"] == ($_POST["place"])) {
                    $data["places"][$i]["selected"] = "selected";
                    break; // jen jeden zvoleny
                }
            }
        }

        //========== CREATE CASE
        if($do=="create"){
            $uvedeni = new uvedeni();
            if(isset($_POST["game"])){
                 $uvedeni->setGame($_POST["game"], $this->GetConnection());
            }
            if(isset($_POST["place"])){
                $uvedeni->setPlace($_POST["place"], $this->GetConnection());
            }
            if(isset($_POST["date"]) && isset($_POST["hours"]) && isset($_POST["minutes"])){
                $data["per"]["date"]=$_POST["date"];
                $data["per"]["minutes"]=$_POST["minutes"];
                $data["per"]["hours"]=$_POST["hours"];

                $datetime=$_POST["date"].".".(0+$_POST["hours"]).".".(0+$_POST["minutes"]);
                $timestamp=DateTimeToTimestamp($datetime);

                $uvedeni->setStart($timestamp);
            }
            $uvedeniDB = new uvedeniDB($this->GetConnection());
            $database = $uvedeni->toDB($uvedeniDB);


            if($database == true){
                $data["data"]["success"]="Uvedení bylo úspěšně vytvořeno";
                unset($data["per"]); // vyčisti formulář
            }
            else {
                if(!isset($data["data"]["error"][0])) { //pokud není oznámena jiná chyba informuj obecně
                    $data["data"]["error"][] = "Uvedení nebylo uloženo do databáze";
                }
            }
        }
        //========== DELETE CASE
        if($do == "delete"){
            $uvedeniDB = new uvedeniDB($this->GetConnection());
            $result = $uvedeniDB->DeleteUvedeniByID((@$_REQUEST["val"]-456)); //magic hash number
            if($result > 0){
                $data["data"]["success"]="Uvedení bylo úspěšně smazáno.";
            }else{
                $data["data"]["error"][]="Chyba při operaci s databází, uvedení nebylo smazáno.";
            }
        }

        //pole uvedení do seznamu pod formulář
        $uvedeniDB = (new uvedeniDB($this->GetConnection()));
        $uvedeni = $uvedeniDB->LoadAllUvedeniInfo();
        $data["performances"] = array();
        $data["performances"] = $uvedeni;

        // vytvořeni tlačítek pro smazání
        foreach ($data["performances"] as &$value){
            $msg = "Opravdu chcete smazat uvedení: \\n"
                .$value["zacatek"]." hra: ".$value["nazevhry"]." místo: ".$value["nazev"];
            $value["delA"] = "confimElement(\"".$msg."\", \"vuved\", ".($value["id_uvedeni"]+456).", \"delete\")"; //magic hash number
        }

    }
    //===============================================================================================================
    //===============================================================================================================

    public function stranaRegistrace($do){
        global $data;

        $data["nadpis"]="Registrace";
        $data["content"]="regform";
        $data["info"] = TEXT_REG_INFO;
        if($do=="reg"){
            $hrac = new hrac();
            require_once("check/regcheck.php");
            $osoby = new osobyDB($this->GetConnection());
           // printr($hrac);
            $database = $hrac->toDB($osoby);
            if($database == true){
                $data["data"]["success"]="Byl jste úspěšně zaregistrován";
                //zobrazit hlavni stranku
                $this->stranaIndex();
            }
            else{
                if(!isset($data["data"]["error"][0])) {
                    $data["data"]["error"][] = "Chyba při registraci. Vaše e-mailová adresa již byla použita.";
                }
            }
        }
    }

    //===============================================================================================================
    //===============================================================================================================

    /**
     * Zobrazí  stranu index
     * */
    public function stranaIndex(){
        global $data;

        foreach( $data["menu"] as $item){
            $item["aktive"]="";
        }


        $data["nadpis"]=TITLE;
        $data["content"]="title";
        $data["obsah"] = TEXT_PIVKO;
    }

    //===============================================================================================================
    //===============================================================================================================

    public  function stranaSeznamUziv($do){
        global $data;

        $data["nadpis"]="Seznam uživatelů";
        $data["content"]="table_user";
        $data["admin"] = 'typ';

        $osobyDB = new osobyDB($this->GetConnection());
        $data["users"]= $osobyDB->SelectAllOsobyInfo();

        foreach($data["users"] as &$user){
            $user["pohlaviS"] = pohlaviS($user["pohlavi"]);
            $user["vek"]=vek($user["datnar"]);
            $user["typuctuS"]= typustuS($user["typuctu"]);
        }
    }

    //==================================================================================================================
    //==================================================================================================================

    /***************************************
     * Tato metoda naplní globální proměnnou $data informacemi pro vyobrazení stránky s formulářem pro nastavení práv a
     * tabulku uživatelů.
     *
     * @param $do string - vlajka k onznačení činnosti metody
     */
    public function stranaPrava($do){
        global $data;

        $data["nadpis"] = "Nastav oprávnění";
        $data["content"] = "rights";

        $data["formSubmit"] = "Nastav oprávnění";

        $data["rights"] = array();
        $data["rights"][0]["value"] = 0+USER_RIGHTS;
        $data["rights"][0]["text"] = typustuS(USER_RIGHTS);

        $data["rights"][1]["value"] = 0+PREMIUM_RIGHTS;
        $data["rights"][1]["text"] = typustuS(PREMIUM_RIGHTS);

        $data["rights"][12]["value"] = 0+ORG_RIGHTS;
        $data["rights"][12]["text"] = typustuS(ORG_RIGHTS);

        $data["rights"][20]["value"] = 0+ADMIN_RIGHTS;
        $data["rights"][20]["text"] = typustuS(ADMIN_RIGHTS);

        $osobyDB = new osobyDB($this->GetConnection());

        if($do == 'setup'){
            $result = $osobyDB->UpdateOsobaRights($_POST["user"]-123, $_POST["right"]-123 );
            if($result == 1){
                $data["data"]["success"] = "Oprávnění ".typustuS($_POST["right"]-123)." byla přidělěna.";

            }elseif($result > 1){
                $data["data"]["error"][]="Bylo upraveno více účtů, proveďte kontrolu oprávnění.";

            }else{
                $data["data"]["error"][]="Oprávnění ".typustuS($_POST["right"]-123)." nebylo uděleno.";
            }
        }

        $data["users"]= $osobyDB->SelectAllOsobyInfo();

        foreach($data["users"] as &$user){
            $user["typuctuS"]= typustuS($user["typuctu"]);
        }
    }

    //==================================================================================================================
    //==================================================================================================================

    public function stranaPrihlasovani(){
        global $data;
        $data["content"] = "prihl";

        //ochrana přihlašování
        //==========================================================================================
        $bool_before = START_TIME > time(); // true pokud je jeste pred spusteni přihlašování
        $bool_after = END_TIME < time(); // true pokud je prihlasovani uzavreno

        if($bool_before == true){
            $alert_msg = "Přihlašování ještě nebylo spuštěno. \\n"
                ."čas spuštění přihlašování: ".timeToCZE(START_TIME)."\\n"
                ."čas serveru: ".timeToCZE(time())."\\n";
            echo"<script>alert(\"".$alert_msg."\")</script>";
        }

        if($bool_after == true){
            $alert_msg = "Již se nelze odhlásit ze hry. V případě problému kontaktujte organizátory.";
            echo"<script>alert(\"".$alert_msg."\")</script>";
        }
        //=============================================================================================

        $uvedeniDB = new uvedeniDB($this->GetConnection());
        $prihlaskyDB = new prihlaskyDB($this->GetConnection());
        $uziv = $_SESSION[MY_SES]["user"]["id"];

        if(isset($_POST["action"]) && $_POST["action"] == 'prihl' && $bool_before == false){

            if($uvedeniDB->setFlag($_POST["val"]) == true){
                if($prihlaskyDB->prihlas($uziv, $_POST["val"]) == true){
                    $data["data"]["success"] = "Byl jste úspěšně přihlášen";
                }else{
                    $data["data"]["error"][] = "Přihlášení nebylo provedeno.";
                }
                $uvedeniDB->unsetFlag($_POST["val"]);
            }else{
                $data["data"]["error"][] = "Omlováme se. Došlo ke kolizi přihlášení, nebo je hra blokována. Zkuste obnovit stránku (F5).";
            }
        }
        if(isset($_POST["action"]) && $_POST["action"] == 'odhlas' && $bool_after == false ){
            if($uvedeniDB->setFlag($_POST["val"]) == true){
                if($prihlaskyDB->odhlas($uziv, $_POST["val"])){
                    $data["data"]["success"] = "Byl jste úspěšně odhlášen.";
                }else{
                    $data["data"]["error"][] = "Odhlášení nebylo provedeno.";
                }
                $uvedeniDB->unsetFlag($_POST["val"]);
            }else{
                $data["data"]["error"][] = "Omlováme se. Došlo ke kolizi přihlášení, nebo je hra blokována. Zkuste obnovit stránku (F5).";
            }
        }


        $data["performances"] = $uvedeniDB->LoadAllUvedeniInfo();


        $moje_hry = $prihlaskyDB->mojeUvedeni($_SESSION[MY_SES]["user"]["id"]);
        foreach( $moje_hry as &$u){
            $u["k"] = $u["z"] + $u["delka"]*60; //delka je v minutach a čas v sekundach
        }

        //set separator TODO dynamické zpracování vstupu

        $data["separator"] = array();

        $data["separator"][0]["text"] = "Pátek 27.2.2015";
        $data["separator"][0]["time"] = timestamp("2015-02-27 00:00:00");

        $data["separator"][1]["text"] = "Sobota 28.2.2015";
        $data["separator"][1]["time"] = timestamp("2015-02-28 00:00:00");

        $data["separator"][2]["text"] = "Neděle 1.3.2015";
        $data["separator"][2]["time"] = timestamp("2015-03-01 00:00:00");

        // vytvořeni tlačítek pro smazání
        foreach ($data["performances"] as &$value){
            $value["k"] = $value["z"] + $value["delka"]*60; //delka je v minutach a čas v sekundach
            $id_u = $value["id_uvedeni"];

            //======================== počítání nestihnutí
            $stihnes = true;
            foreach( $moje_hry as $prihlasena){
                $cela_pred = $prihlasena["z"] < $value["z"] && $prihlasena["k"] < $value["z"];
                $cela_za = $prihlasena["z"] > $value["k"] && $prihlasena["k"] > $value["k"];
                $stihnes &= ($cela_pred || $cela_za);
            }
            //========================

          // jak se má chovat tlačítko
           if($bool_before == true) { //=================================================== case blok přihlašování
               $value["disabled"] = "disabled";
               $value["submitVal"] = "Přihlašování není spuštěno";
               $value["action"] = "none";

           }elseif($prihlaskyDB->prihlasen($uziv, $id_u)){//============================== case jsem přihlášen

                if($bool_after == true){
                    $value["disabled"] = "disabled";
                }else{
                    $value["disabled"] = "";
                }
                $value["submitVal"] = "Odhlásit";
                $value["action"] = "odhlas";

           }elseif($prihlaskyDB->obsazeno($id_u)){//====================================== case obsazeno
               $value["disabled"] = "disabled";
               $value["submitVal"] = "Hra je plně obsazena.";
               $value["action"] = "no";

           }elseif(!$stihnes == true){//================================================== case nestihneš
               $value["disabled"] = "disabled";
               $value["submitVal"] = "Tuto hru nestihneš!";
               $value["action"] = "no";

           }elseif($_SESSION[MY_SES]["user"]["pohlavi"] == 1){//========================== case prihlas muze

               if($prihlaskyDB->obsazenoM($id_u) && $prihlaskyDB->obsazenoH($id_u)) {
                    $value["disabled"] = "disabled";
                    $value["submitVal"] = "Mužské role obsazeny.";
                    $value["action"] = "no";
                }else{
                            // zbývají obojetná místa
                    $value["disabled"] = "";
                    $value["submitVal"] = "Přihlaš";
                    $value["action"] = "prihl";
                }

           }elseif($_SESSION[MY_SES]["user"]["pohlavi"] == 0){//========================= case prihlas zenu

               if($prihlaskyDB->obsazenoZ($id_u) && $prihlaskyDB->obsazenoH($id_u)) {
                   $value["disabled"] = "disabled";
                   $value["submitVal"] = "Ženské role obsazeny.";
                   $value["action"] = "no";
               }else{
                   // zbývají obojetná místa
                   $value["disabled"] = "";
                   $value["submitVal"] = "Přihlaš";
                   $value["action"] = "prihl";
               }

           }else{ // sem by to nikdy nemělo dojít zabere můž nebo žena (snad)

               $value["disabled"] = "disabled";
               $value["submitVal"] = "Chyba výpočtu, kontaktuj admina.";
               $value["action"] = "none";
           }


        }


    }

    //==================================================================================================================
    //==================================================================================================================

    /**
     * Vytvoží náhodnou posloupnost znaků abecedy a číslic dle zadané délky
     * @param $delka int - počet znaků generované posloupnosti
     * @return string - vygenerovaná posloupnost
     */
    private function nove_heslo($delka){
        $noveHeslo = "";
        for($i=0; $i < $delka; $i++){
            $mnozinaZnaku='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
            $noveHeslo=$noveHeslo."".substr($mnozinaZnaku,mt_rand(0,strlen($mnozinaZnaku)-1),1);
        }
        return $noveHeslo;
    }

    //TODO upravit - zasadit jinam, promyslet zařazení zasílání mailů do aplikace
    private function posli_mail($noveHeslo, $mail, $KONTAKT){
        $zprava="
                                Dobrý den,<br />
                                toto je automaticky generovaná odpověď na žádost o změnu hesla uživatele: $mail do registračního systému PIVKo\n<br />                           <br />
                                Vaše nové dočasné heslo je: **$noveHeslo** (**vašeNovéHeslo**)  \n<br /><br /><br />
                                Bezproblémové používání systému Vám přeje     \n<br />
                                Organizační tým<br />
                                PS: Veškeré problémy a nesrovnalosti rádi vyřešíme mailem $KONTAKT.
                               "    ;

        $dopis = Mail::prepareGmail();

        $dopis->Subject  = "Nové heslo";
        $dopis->Body     =  $zprava;
        $dopis->AltBody  =  "Vaše nove heslo je:**$noveHeslo**(**VašeNovéHeslo**)";
        $dopis->AddAddress(''.$mail.'');

        if(!($dopis->Send()))
        {
            echo'<script> alert("Omlouváme se, ale při vykonávání vašeho požadavku na změnu hesla došlo k chybě.\\nKontaktujte prosím organizátory:\\n'.$KONTAKT.'"); </script>';

            if(VERBOSE == true){
                printr($dopis->ErrorInfo);
            }
        }
        else{
            echo '<script> alert("Vaše nové heslo Vám bylo odesláno na email."); </script>';
        }
    }

    /**
     * Zpracuje požadavky na stranu generování nového hesla
     * @param $do string - strana reaguje na hodnotu pass, kdy provede vytvoření a odeslání nového hesla
     */
    public function stranaNoveHeslo($do){
        global $data;

        if($do == "pass" && isset($_POST["mail"])){

            if(VERBOSE == true){
                printr("pass");
            }

            $osobyDB = new osobyDB($this->GetConnection());
            $acount = $osobyDB->GetOsobaIdByMail($_POST["mail"]);

            if(VERBOSE == true){
                printr($acount);
            }

            if($acount != false){
                $noveHeslo = $this->nove_heslo(6);
                $result = $osobyDB->UpdatePassByID($acount["id_osoby"], $noveHeslo);

                if(VERBOSE == true){
                    printr($result);
                }

                if($result == true){
                    $data["data"]["success"] = "Heslo bylo změněno";
                    $this->posli_mail($noveHeslo, $acount["email"], "pivko.pilirion@gmail.com");
                    $this->stranaIndex();
                }
            }
        }


        $data["nadpis"] = "Nové heslo";
        $data["info"] = "Pokud neznáte heslo k Vašemu účtu, není jednodužší způsob, než si vygenerovat"
                        ." heslo nové. Generování odešle nové heslo na mail spojený s Vaším účtem. Pokud neobdržíte"
                        ." nové heslo do několika hodin, kontaktujte prosím organizátory PIVKa.";
        $data["content"] = "forgot_pass";

    }

    //==================================================================================================================
    //==================================================================================================================

    public function stranaMeHry(){
        global $data;

        if(isset($_GET["val"]) && is_numeric($_GET["val"])){
            $data["content"] = 'table_user';

            $uvedeniDB = new uvedeniDB($this->GetConnection());
            $uvedeni = $uvedeniDB->GetUvedeniInfoByID($_GET["val"]);

            $data["nadpis"] = $uvedeni["nazevhry"];
            $data["podtitul"] = $uvedeni["zacatek"]." - ".$uvedeni["nazev"];

            $prihlaskyDB = new prihlaskyDB($this->GetConnection());
            $data["users"] = $prihlaskyDB->prihlaseni($_GET["val"]);

            foreach($data["users"] as &$user){
                $user["pohlaviS"] = pohlaviS($user["pohlavi"]);
                $user["vek"]=vek($user["datnar"]);
                $user["typuctuS"]= typustuS($user["typuctu"]);
            }

            return;
        }

        $data["content"] = "orglist";

        $uvedeniDB = new uvedeniDB($this->GetConnection());
        $uvedeni = $uvedeniDB->GetUvedeniByOrg($_SESSION[MY_SES]["user"]["id"]);
        if($_SESSION[MY_SES]["user"]["rights"]==99){
            $uvedeni = $uvedeniDB->LoadAllUvedeniInfo();
        }

        //printr($uvedeni);

        $data["performances"] = $uvedeni;

    }

    //==================================================================================================================
    //==================================================================================================================

    /**
    Do pole global nastaví menu
     */

    public function  setUpMenu(){
        $this->Menu();
        $this->userMenu();
        $this->AdminMenu();
    }
    //==================================================================================================================
    /**
     * Připraví návštěvnické menu
     * */
    private function Menu(){
        global $data;
        $data["menu"]["akce"]["text"]="O akci";
        $data["menu"]["akce"]["href"]="?id=akce";

        $data["menu"]["hry"]["text"]="Uváděné hry";
        $data["menu"]["hry"]["href"]="?id=hry";

        $data["menu"]["letos"]["text"]="Letošní ročník";
        $data["menu"]["letos"]["href"]="?id=letos";

        $data["menu"]["cena"]["text"]="Cena";
        $data["menu"]["cena"]["href"]="?id=cena";


        if(!isset($_SESSION[MY_SES]["user"]["flag"]) || $_SESSION[MY_SES]["user"]["flag"] == false) {
            $data["menu"]["reg"]["text"] = "Registrace";
            $data["menu"]["reg"]["href"] = "?id=reg";
        }
    }
    //==================================================================================================================
    /**
     * Připraví uživatelské menu
     * */
    private function userMenu(){
        global $data;

        $data["menu_member"]["prihl"]["text"]="Přihlašování na hry";
        $data["menu_member"]["prihl"]["href"]="?id=prihl";

        $data["menu_member"]["mujprog"]["text"]="Můj program";
        $data["menu_member"]["mujprog"]["href"]="?id=mujprog";

        $data["menu_member"]["mujucet"]["text"]="Můj účet";
        $data["menu_member"]["mujucet"]["href"]="?id=mujucet";

        if(isset($_SESSION[MY_SES]["user"]["rights"]) && $_SESSION[MY_SES]["user"]["rights"] >= ORG_RIGHTS) {
            $data["menu_member"]["mojehry"]["text"] = "Moje uvedení";
            $data["menu_member"]["mojehry"]["href"] = "?id=orghry";
        }
    }
    //==================================================================================================================
    /**
     * Připraví administrátorské menu
     * */
    private function AdminMenu(){
        global $data;

        $data["menu_admin"]["vmisto"]["text"]="Správa míst";
        $data["menu_admin"]["vmisto"]["href"]="?id=vmisto";

        $data["menu_admin"]["vhra"]["text"]="Správa her";
        $data["menu_admin"]["vhra"]["href"]="?id=vhra";

        $data["menu_admin"]["vuved"]["text"]="Správa uvedení";
        $data["menu_admin"]["vuved"]["href"]="?id=vuved";

        $data["menu_admin"]["uzivatele"]["text"]="Seznam uživatelů";
        $data["menu_admin"]["uzivatele"]["href"]="?id=uzivatele";

        $data["menu_admin"]["prava"]["text"]="Nastav oprávnění";
        $data["menu_admin"]["prava"]["href"]="?id=prava";

    }


    //==================================================================================================================

   /**
    * připojí na konec pole navigační lišty další prvek
   */
    private function appendNavbar($title, $href, $last = false){
        global $data;

        if($last==true){
            $data["navbar_last"]=$title;
            return;
        }

        if(isset($data["navbar"])){
            $n=count($data["navbar"]);

        }else{
            $n=0;
        }

        $data["navbar"][$n]["text"]=$title;
        $data["navbar"][$n]["href"]=$href;
    }

    //================================================
    /**
    Vyčistí pole navigační lišty
     */
    private function resetNavbar(){
        global $data;

        $data["navbar"]=array();
    }
}

?>
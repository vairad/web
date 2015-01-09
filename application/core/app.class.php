<?php

/**
 * Komentar k tomuto objektu. Popis vstupu, vystupu a pouziti.
 *
 */

class app
{
    // pripojeni k db - pomocny objekt
    private $db = null;

    /**
     * Konstruktor.
     */
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

    public function zpracujPoz(){
        global $data;


        $this->appendNavbar("Pivko", "index.php");

        $id = @$_REQUEST["id"];

        $do = @$_REQUEST["do"];
        $data["data"]["error"]=array();

       // printr($_POST);

        $prihl = isset($_SESSION[MY_SES]) && $_SESSION[MY_SES]["user"]["flag"]==true;

      //  printr($prihl);

        $data["title"]="Semestrání práce WEB";
        $data["menu"][$id]["aktiv"]="active";
        $data["menu_member"][$id]["aktiv"]="active";
        $data["menu_admin"][$id]["aktiv"]="active";
        $data["content"]="text";

        if($id=="vhra" && $prihl) {
            $this->appendNavbar("Vytvoř hru", "index.php?id=vhra");
            $this->stranaVytvorHru($do);

        }elseif($id=="vmisto" && $prihl){
            $this->appendNavbar("Správa míst", "index.php?id=vmisto");
            $this->stranaSpravaMist($do);

        }elseif($id=="vuved" && $prihl){
            $this->appendNavbar("Správa uvedení", "index.php?id=vuved");
            $this->stranaVytvorUvedeni($do);

        }elseif($id=="uzivatele" && $prihl){
            $this->appendNavbar("Seznam uživatelů", "index.php?id=uzivatele", true);
            $this->stranaSeznamUziv($do);

        }elseif($id=="akce"){
            $this->appendNavbar("O akci", "index.php?id=akce");
            $data["nadpis"]="Akce";

        }elseif($id=="hry"){
            $this->appendNavbar("Uváděné hry", "index.php?id=hry");
            $data["nadpis"]="Hry";

        }elseif($id=="letos"){
            $this->appendNavbar("Letošní ročník", "index.php?id=letos");
            $data["nadpis"]="Letošní ročník";

        }elseif($id=="reg"){
            $this->appendNavbar("Registrace", "index.php?id=reg");
            $this->stranaRegistrace($do);

        }else{
            $this->resetNavbar();
            $this->appendNavbar("Pivko", "index.php");
            $this->stranaIndex();
        }
    }

    //===============================================================================================================

    public function setFooter(){
        global $data;
        $data["footer_left_a"]="http://www.pilirionos.org/pro-verejnost";
        $data["footer_left"]="Co je to larp?";

        $data["footer_right_a"]="http://www.pilirionos.org/";
        $data["footer_right"]="Pilirion o.s.";
    }

    //===============================================================================================================

    public function setLogged(){
        global $data;
        if(isset($_SESSION[MY_SES]["user"]["flag"]) && $_SESSION[MY_SES]["user"]["flag"] == true){
            $data["logged"]=$_SESSION[MY_SES]["user"]["rights"];
            $data["user"]["name"]=$_SESSION[MY_SES]["user"]["name"];
            $data["user"]["nick"]=$_SESSION[MY_SES]["user"]["nick"];
            $data["user"]["surname"]=$_SESSION[MY_SES]["user"]["surname"];
        }else{
            $data["logged"]=false;
        }
    }

    public function login(){
        global $data;
        $osoby = new osobyDB($this->GetConnection());
        $user = $osoby->GetOsobaByLogin(trim($_POST["login"]), trim($_POST["pass"]));
        if(!isset($user["jmeno"])){
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
        }
    }

    public function logout(){
        global $data;
        unset( $_SESSION[MY_SES]["user"]);
        unset( $_SESSION[MY_SES]);
        session_unset();
        $data["data"]["success"]="Odhlášení proběhlo úspěšně.";
    }

    //===============================================================================================================
    //===============================================================================================================

    public function stranaVytvorHru($do){
        global $data;

        $data["nadpis"] = "Vytvor hru";
        $data["content"] = "vhra";

        //pole organizátorů do formuláře
        $osobyDB = new osobyDB($this->GetConnection());
        $orgove = $osobyDB->GetOsobyByRights(ORG_RIGHTS);
        $data["orgove"] = array();
        $data["orgove"] = $orgove;

        // printr($_POST);
        // die;
        if($do=="create"){
            //nastavení minule zvoleného
            if(isset($_POST["org"])) {
                for ($i = 0; $i< count($data["orgove"]); $i++) {
                    if ($data["orgove"][$i]["id_osoby"] == ($_POST["org"]-123)) { //magic 123 hash number
                        $data["orgove"][$i]["selected"] = "selected";
                    };
                }
            }
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

    //===============================================================================================================


    public function stranaSpravaMist($do){
        global $data;

        $show = @$_REQUEST["con"];

        if($show == 'create') {
            $this->appendNavbar("Nové místo", "index.php?id=vmisto&con=create#h1", true);
            $this->stranaVytvorMisto($do);
        }
        else if($show == 'manage'){
            $this->appendNavbar("Seznam všech míst", "index.php?id=vmisto&con=manage#h1", true);
            $this->stranaSeznamMist($do);
        }else if($do == 'delete'){

            /*smazat místo*/
            $mistaDB = new mistaDB($this->GetConnection());
            $result = $mistaDB->DeleteMistoByID((@$_REQUEST["val"]-456)); //magic hash number
            if($result > 0){
                $data["data"]["success"]="Místo bylo úspěšně smazáno.";
            }else{
                $data["data"]["error"][]="Chyba při operaci s databází, místo nebylo smazáno.";
            }

            /*zobrazit seznam*/
            $this->appendNavbar("Seznam všech míst", "index.php?id=vmisto&con=manage#h1", true);
            $this->stranaSeznamMist($do);

        }else if($do == 'edit'){


        }else{
            $data["nadpis"] = "Správa míst";
            $data["content"] = "smisto";

            $data["info"] = "Pro spravování míst zvolte jednu z výše uvedených možností.";

            $data["a"] = array();
            $data["a"][0]["title"] = "Vytvořit nové místo";
            $data["a"][0]["href"] = "index.php?id=vmisto&con=create#h1";
            $data["a"][1]["title"] = "Seznam všech míst";
            $data["a"][1]["href"] = "index.php?id=vmisto&con=manage#h1  ";
        }

    }

    public function stranaVytvorMisto($do){
        global $data;

        $data["nadpis"]="Vytvor misto";
        $data["content"]="vmisto";

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

    public function stranaSeznamMist($do){
        global $data;

        $data["nadpis"]="Seznam mist";
        $data["content"]="lmisto";

        //pole uvedení do seznamu pod formulář
        $mistaDB = (new mistaDB($this->GetConnection()));
        $mista = $mistaDB->LoadAllMistaInfo();
        $data["places"] = array();
        $data["places"] = $mista;

        // vytvořeni tlačítek pro smazání
        foreach ($data["places"] as &$value){
            $msg = "Opravdu chcete smazat místo: \\n"
                .$value["nazev"]." (".$value["ulice"]." ".$value["cp"].")";
            $value["delA"] = "confimElement(\"".$msg."\", \"vmisto\", ".($value["id_mista"]+456).")"; //magic hash number
        }
    }

    //===============================================================================================================

    public function stranaVytvorUvedeni($do){
        global $data;

        $data["nadpis"]="Správa uvedení";
        $data["content"]="vuved";
        $data["titleform"]="Uvést hru";
        $data["titlelist"]="Naplánované hry";

        //pole her do formuláře
        $hryDB = new hryDB($this->GetConnection());
        $hry = $hryDB->LoadAlHry();
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
        $uvedeni = (new uvedeniDB($this->GetConnection()))->LoadAllUvedeniInfo();
        $data["performances"] = array();
        $data["performances"] = $uvedeni;

        // vytvořeni tlačítek pro smazání
        foreach ($data["performances"] as &$value){
            $msg = "Opravdu chcete smazat uvedení: \\n"
                .$value["zacatek"]." hra: ".$value["nazevHry"]." místo: ".$value["nazev"];
            $value["delA"] = "confimElement(\"".$msg."\", \"vuved\", ".($value["id_uvedeni"]+456).")"; //magic hash number
        }

    }
    //===============================================================================================================

    public function stranaRegistrace($do){
        global $data;

        $data["nadpis"]="Registrace";
        $data["content"]="regform";
        $data["info"]="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egesta";

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

    public function stranaIndex(){
        global $data;

        foreach( $data["menu"] as $item){
            $item["aktive"]="";
        }


        $data["nadpis"]="Index";
        $data["content"]="text";
        $data["obsah"]='   <p class="text-justify">šablonou ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>';
    }

    //===============================================================================================================

    public  function stranaSeznamUziv($do){
        global $data;

        $data["nadpis"]="Seznam uživatelů";
        $data["content"]="table_user";

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
    public function  setUpMenu(){
        $this->Menu();
        $this->userMenu();
        $this->AdminMenu();
    }
    //==================================================================================================================
    private function Menu(){
        global $data;
        $data["menu"]["akce"]["text"]="O akci";
        $data["menu"]["akce"]["href"]="?id=akce";

        $data["menu"]["hry"]["text"]="Hry";
        $data["menu"]["hry"]["href"]="?id=hry";

        $data["menu"]["letos"]["text"]="Letošní ročník";
        $data["menu"]["letos"]["href"]="?id=letos";

        $data["menu"]["reg"]["text"]="Registrace";
        $data["menu"]["reg"]["href"]="?id=reg";
    }
    //==================================================================================================================
    private function userMenu(){
        global $data;
        $data["menu_member"]["mujucet"]["text"]="Můj účet";
        $data["menu_member"]["mujucet"]["href"]="?id=mujucet";
    }
    //==================================================================================================================
    private function AdminMenu(){
        global $data;

        $data["menu_admin"]["vmisto"]["text"]="Správa míst";
        $data["menu_admin"]["vmisto"]["href"]="?id=vmisto";

        $data["menu_admin"]["vhra"]["text"]="Vytvoř hru";
        $data["menu_admin"]["vhra"]["href"]="?id=vhra";

        $data["menu_admin"]["vuved"]["text"]="Správa uvedení";
        $data["menu_admin"]["vuved"]["href"]="?id=vuved";

        $data["menu_admin"]["uzivatele"]["text"]="Seznam uživatelů";
        $data["menu_admin"]["uzivatele"]["href"]="?id=uzivatele";
    }


    //==================================================================================================================
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
    private function resetNavbar(){
        global $data;

        $data["navbar"]=array();
    }
}

?>
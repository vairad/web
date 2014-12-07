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
        $id = @$_REQUEST["id"];

        $do = @$_REQUEST["do"];
        $data["data"]["error"]=array();

       // printr($_POST);

        $prihl = isset($_SESSION[MY_SES]) && $_SESSION[MY_SES]["user"]["flag"]==true;

      //  printr($prihl);

        $data["title"]="Semestrání práce WEB";
        $data["menu"][$id]["aktiv"]="active";
        $data["content"]="text";
        site:
        if($id=="vhra" && $prihl) {
            //printr($_POST);
                $data["nadpis"] = "Vytvor hru";
                $data["content"] = "vhra";

        }elseif($id=="vmisto" && $prihl){
                $data["nadpis"]="Vytvor misto";
                $data["content"]="vmisto";
                if($do=="create"){
                    $misto = new misto();
                    require_once("front/placecheck.php");
                    $mista = new mistaDB($this->GetConnection());
                    $database = $misto->toDB($mista);
                    if($database == true){
                        $data["data"]["succes"]="Hra byla úspěšně vytvořena";
                        //zobrazit prázdný formulář
                        unset($data["place"]);
                    }
                    else {
                        if(!isset($data["data"]["error"][0])) {
                            $data["data"]["error"][] = "Hra se stejným názvem již existuje";
                        }
                    }
                }


}elseif($id=="akce"){
                $data["nadpis"]="Akce";
        }elseif($id=="hry"){
                $data["nadpis"]="Hry";
        }elseif($id=="letos"){
                $data["nadpis"]="Letošní ročník";
        }elseif($id=="reg"){
                if($do=="reg"){
                    $hrac = new hrac();
                    require_once("front/regcheck.php");
                    $osoby = new osobyDB($this->GetConnection());
                    $database = $hrac->toDB($osoby);
                    if($database == true){
                        $data["data"]["succes"]="Byl jste úspěšně zaregistrován";
                        //zobrazit hlavni stranku
                        $id="akce";
                        goto site;
                    }
                    else{
                        if(!isset($data["data"]["error"][0])) {
                            $data["data"]["error"][] = "Chyba při registraci. Vaše e-mailová adresa již byla použita.";
                        }
                    }

                }
                $data["nadpis"]="Registrace";
                $data["content"]="regform";
                $data["info"]="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egesta";
        }else{
                $data["nadpis"]="Index";
                $data["obsah"]='   <p class="text-justify">šablonou ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>';
        }
    }

    public function setFooter(){
        global $data;
        $data["footer_left_a"]="http://www.pilirionos.org/pro-verejnost";
        $data["footer_left"]="Co je to larp?";

        $data["footer_right_a"]="http://www.pilirionos.org/";
        $data["footer_right"]="Pilirion o.s.";
    }

    public function setLogged(){
        global $data;
        if(isset($_SESSION[MY_SES]["user"]["flag"]) && $_SESSION[MY_SES]["user"]["flag"] == true){
            $data["logged"]=$_SESSION[MY_SES]["user"]["rights"];
            $data["user"]["name"]=$_SESSION[MY_SES]["user"]["name"];
            $data["user"]["nick"]=$_SESSION[MY_SES]["user"]["nick"];
            $data["user"]["surname"]=$_SESSION[MY_SES]["user"]["surname"];
        }else{
            $data["logged"]=0;
        }
    }

    public function login(){
        global $data;
        $osoby = new osoby($this->GetConnection());
        $user = $osoby->GetOsobaByLogin(trim($_POST["login"]), trim($_POST["pass"]));
        if(!isset($user["jmeno"])){
            $data["data"]["error"][]="Špatná kombinace jména a hesla.";
        }else{
            $data["data"]["succes"]="Přihlášení bylo úspěšné";
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
        $data["data"]["succes"]="Odhlášení proběhlo úspěšně.";
    }

    public function testDat(){
        global $data;

        $data["menu"]["akce"]["text"]="O akci";
        $data["menu"]["akce"]["href"]="?id=akce";

        $data["menu"]["hry"]["text"]="Hry";
        $data["menu"]["hry"]["href"]="?id=hry";

        $data["menu"]["letos"]["text"]="Letošní ročník";
        $data["menu"]["letos"]["href"]="?id=letos";

        $data["menu"]["reg"]["text"]="Registrace";
        $data["menu"]["reg"]["href"]="?id=reg";


        $data["menu_member"]["mujucet"]["text"]="Můj účet";
        $data["menu_member"]["mujucet"]["href"]="?id=mujucet";

        $data["menu_admin"][0]["text"]="Vytvor misto";
        $data["menu_admin"][0]["href"]="?id=vmisto";

        $data["menu_admin"][1]["text"]="Vytvor hru";
        $data["menu_admin"][1]["href"]="?id=vhra";

        $data["navbar"][3]["text"]="Prvnu bod";
        //$data["menu"][3]["href"]="";


        $data["navbar"][2]["text"]="druhy bod";
        //$data["menu"][2]["href"]="";

        $data["navbar_last"]="Aktualni stranka";
    }


}

?>
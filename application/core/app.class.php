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


    public function Secti($a, $b)
    {
        $c = $a + $b;
        return $c;
    }

    public function zpracujHTML(){
        global $data;
        $id = @$_REQUEST["id"];

        $do = @$_REQUEST["do"];

        $data["title"]="Semestrání práce WEB";
        $data["menu"][$id]["aktiv"]="active";
        $data["content"]="text";
        echo $id;
        if($id=="akce"){
                $data["nadpis"]="Akce";
        }elseif($id=="hry"){
                $data["nadpis"]="Hry";
        }elseif($id=="letos"){
                $data["nadpis"]="Letošní ročník";
        }elseif($id=="reg"){
                if($do=="reg"){
                    $hrac = new hrac();
                    require_once("front/regcheck.php");
                    $osoby = new osoby($this->GetConnection());
                    $osoby->InsertOsoba($hrac);
                }
                $data["nadpis"]="Registrace";
                $data["content"]="regform";
                $data["info"]="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egesta";
        }else{
                $data["nadpis"]="Index";
        }
        $data["logged"]=1;
    }

    public function testDat(){
        global $data;
        // nacist vstupy - napr. ID clanku, ktery mam zobrazit
        $id = @$_REQUEST["id"];

        $data["obsah"]='   <p class="text-justify">šablonou ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>
                    <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales arcu non fermentum vestibulum. Sed sed cursus risus. Donec porta urna in tellus sodales, ut congue velit blandit. In porttitor vulputate enim, vel viverra nulla mattis eu. Fusce mollis, diam egestas fringilla lobortis, tellus erat sodales ipsum, vitae auctor arcu lectus nec justo. Sed rhoncus, ex in condimentum rhoncus, velit est ultricies urna, sed posuere mauris lectus ac dui. Nullam tincidunt ligula nec congue commodo. Praesent pellentesque luctus pharetra. Maecenas at blandit nisi. Etiam vitae nulla lectus. Quisque sed augue elementum nisl tincidunt vulputate nec a est.
                    </p>';

        $data["footer_left_a"]="http://www.pilirionos.org/pro-verejnost";
        $data["footer_left"]="Co je to larp?";

        $data["footer_right_a"]="http://www.pilirionos.org/";
        $data["footer_right"]="Pilirion o.s.";


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

        $data["menu_admin"]["mujucet"]["text"]="Můj účet";
        $data["menu_admin"]["mujucet"]["href"]="?id=mujucet";

        $data["navbar"][3]["text"]="Prvnu bod";
        //$data["menu"][3]["href"]="";


        $data["navbar"][2]["text"]="druhy bod";
        //$data["menu"][2]["href"]="";

        $data["navbar_last"]="Aktualni stranka";
    }
    

}

?>
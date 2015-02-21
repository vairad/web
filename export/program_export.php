<?php

// nacist konfiguraci
require '../conf/config.inc.php';
require '../conf/const.inc.php';
require '../conf/functions.inc.php';					// pomocne funkce

// nacist objekty - soubory .class.php
require '../application/core/app.class.php';	    // drzi hlavni funkcionalitu cele aplikace, obsahuje routing = navigovani po webu


require '../application/db/db.class.php';			// zajisti pristup k db a spolecne metody pro dalsi pouziti
require '../application/db/mistaDB.class.php';		// zajisti pristup ke konkretnim db tabulkam - objekt vetsinou zajisti pristup k cele sade souvisejicich tabulek
require '../application/db/osobyDB.class.php';
require '../application/db/hryDB.class.php';
require '../application/db/uvedeniDB.class.php';
require '../application/db/prihlaskyDB.class.php';

//##################################################################################

$db = new db();
$db->Connect();

$osobyDB = new osobyDB($db->GetConnection());
$prihlaskyDB = new prihlaskyDB($db->GetConnection());
$hryDB = new hryDB($db->GetConnection());
$mistaDB = new mistaDB($db->GetConnection());
$uvedeniDB = new uvedeniDB($db->GetConnection());


$osoby = $osobyDB->SelectAllOsobyInfo();
    //$osoby = $osobyDB->GetOsobyByRights(CREATE_RIGHTS);
$export = "";

foreach ($osoby as $osoba){
    $program = $prihlaskyDB->mojeUvedeni($osoba["id_osoby"]);
    //printr($program);
    if(count($program)>0){

        $jmeno = $osoba["jmeno"]." \"".$osoba["prezdivka"]."\" ".$osoba["prijmeni"];

        $empty["hra"] = " ";
        $empty["misto"] = " ";
        $empty["cas"] = " ";

        $hrac[0] = array();
        $hrac[1] = array();
        $hrac[2] = array();
        $hrac[3] = array();
        $hrac[4] = array();
        $hrac[5] = array();
        $hrac[0] = $empty;
        $hrac[1] = $empty;
        $hrac[2] = $empty;
        $hrac[3] = $empty;
        $hrac[4] = $empty;
        $hrac[5] = $empty;

        $cas = mktime(20, 00, 00, 02, 27, 2015);

        $pp = 0; //program pointer
        for($i = 0; $i < count($hrac); $i++){

         /*   echo "zacatek: ".$program[$i]["z"]." cas hodin: ".$cas;
            echo "<br>";*/

            if(isset($program[$pp]) && $program[$pp]["z"] < $cas ){
                $hrac[$i]["hra"] = $program[$pp]["nazevhry"];
                $hrac[$i]["misto"] = $program[$pp]["nazev"];
                $hrac[$i]["cas"] = $program[$pp]["doba"];
                $pp++;
            }

          //  echo cze_datum_cas(timeToData($cas))."<br>";
            $cas += 8*60*60; //osm hodin v sekundách
        }

        echo $jmeno.";";
        echo typustuS($osoba["typuctu"]).";";
      //  echo "<br>";

        for($i = 0; $i<count($hrac); $i++){
            echo $hrac[$i]["hra"].";";
            echo $hrac[$i]["cas"].";";
            echo $hrac[$i]["misto"].";";
        //    echo "<br>";
        }
        echo "\n";
        //funkcni kod
    }
}

?>
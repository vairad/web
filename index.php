<?php

	// nacist konfiguraci
	require 'conf/config.inc.php';
	require 'conf/functions.inc.php';					// pomocne funkce

	// nacist objekty - soubory .class.php
	require 'application/core/app.class.php';			// drzi hlavni funkcionalitu cele aplikace, obsahuje routing = navigovani po webu
	require 'application/db/db.class.php';			// zajisti pristup k db a spolecne metody pro dalsi pouziti
	require 'application/db/mista.class.php';		// zajisti pristup ke konkretnim db tabulkam - objekt vetsinou zajisti pristup k cele sade souvisejicich tabulek



    // připojení twigu
    require_once("application/view/twig/lib/Twig/Autoloader.php");


	// start the application
	$app = new app();

	// pripojit k db
	$app->Connect();

	// pripojeni k db
	$db_connection = $app->GetConnection();

	// vytvorit objekt, ktery mi poskytne pristup k DB a vlozit mu connector k DB
	$mista = new mista($db_connection);


	// nacist vstupy - napr. ID clanku, ktery mam zobrazit
		$id = @$_REQUEST["id"] + 0;

		// nebo q = pozadovane url, ktere jsem dostal z .htaccess


	// zpracovat si data pro vystup
		// nejake vypocty apod
		$a = 1;
		$b = 2;
		//$c = $a + $b;
		$c = $app->Secti($a, $b);


	// nacist vsechny predmety
		$predmety_data = $mista->LoadAllMista();
		echo "Mista:";
		printr($predmety_data);	// specialni funkce pro vypis

	// Vypis dat
		// TODO nevypisovat to primo, ale s vyuzitim sablonovaciho systemu
		// v nejhorsim to musi byt aspon v oddelenem souboru v casti templates nebo view

		echo "<html>";
			echo "<head>";
                echo "<meta charset=\"utf-8\">";
			echo "</head>";
			echo "<body>";
				echo "<h1>Moje aplikace</h1>";

				echo "Použitá databáze: ".DB_DATABASE_NAME."<br/>";
				echo "c = $c <br/>";
			echo "</body>";
		echo "</html>";
	// Konec vypis dat
?>
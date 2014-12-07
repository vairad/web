<?php
    /** @var data vypsani do sablony $data */
    $data = array();

    session_start();

	// nacist konfiguraci
	require 'conf/config.inc.php';
    require 'conf/style.inc.php';
    require 'conf/functions.inc.php';					// pomocne funkce

	// nacist objekty - soubory .class.php
	require 'application/core/app.class.php';	    // drzi hlavni funkcionalitu cele aplikace, obsahuje routing = navigovani po webu


    require 'application/db/db.class.php';			// zajisti pristup k db a spolecne metody pro dalsi pouziti
	require 'application/db/mistaDB.class.php';		// zajisti pristup ke konkretnim db tabulkam - objekt vetsinou zajisti pristup k cele sade souvisejicich tabulek
    require 'application/db/osobyDB.class.php';

    //datove struktury
    require 'application/core/data/hrac.class.php';
    require 'application/core/data/misto.class.php';

    // připojení twigu
    require_once("application/view/twig/lib/Twig/Autoloader.php");

	// start the application
	$app = new app();
	// pripojit k db
	$app->Connect();

    $app->setFooter();

    if(isset($_POST["do"]) && ($_POST["do"])=="login"){
        $app->login();
    }
    if(@$_REQUEST["do"] =="logout"){
        $app->logout();
    }

    $app->setLogged();
    $app->zpracujPoz();
    $app->testDat();


        Twig_Autoloader::register();

        // cesta k adresari se sablonama - od index.php
        $loader = new Twig_Loader_Filesystem('application/view');
        $twig = new Twig_Environment($loader); // takhle je to bez cache

        // nacist danou sablonu z adresare
        $template = $twig->loadTemplate(TEMPLATE);


        echo $template->render($data);
?>
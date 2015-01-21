<?php

    session_start();

    /** @var array[] poměnná pro data předaná šabloně*/
    $data = array();
    //preparation of database arrays
    $data["data"] = array();
    $data["data"]["error"] = array();

	// nacist konfiguraci
	require 'conf/config.inc.php';
    require 'conf/const.inc.php';
    require 'conf/style.inc.php';
    require 'conf/texts.inc.php';
    require 'conf/functions.inc.php';					// pomocne funkce

	// nacist objekty - soubory .class.php
	require 'application/core/app.class.php';	    // drzi hlavni funkcionalitu cele aplikace, obsahuje routing = navigovani po webu


    require 'application/db/db.class.php';			// zajisti pristup k db a spolecne metody pro dalsi pouziti
	require 'application/db/mistaDB.class.php';		// zajisti pristup ke konkretnim db tabulkam - objekt vetsinou zajisti pristup k cele sade souvisejicich tabulek
    require 'application/db/osobyDB.class.php';
    require 'application/db/hryDB.class.php';
    require 'application/db/uvedeniDB.class.php';
    require 'application/db/prihlaskyDB.class.php';

    //datove struktury
    require 'application/core/data/hrac.class.php';
    require 'application/core/data/misto.class.php';
    require 'application/core/data/hra.class.php';
    require 'application/core/data/uvedeni.class.php';

    //php mailer
    require 'application/core/PHPMailer/class.phpmailer.php';

    // připojení twigu
    require_once("application/view/core/twig/lib/Twig/Autoloader.php");

	// start the application
	$app = new app();
	// pripojit k db
	$app->Connect();

    if(isset($_GET["do"]) && ($_GET["do"])=="login"){
        $app->login();
    }
    if(@$_REQUEST["do"] =="logout"){
        $app->logout();
    }

    $app->setLogged();

    $app->setUpMenu();
    $app->setFooter();

    $app->zpracujPoz();

  // printr($data);

    Twig_Autoloader::register();

        // cesta k adresari se sablonama - od index.php
    $loader = new Twig_Loader_Filesystem('application/view/templates');
    $twig = new Twig_Environment($loader); // takhle je to bez cache

        // nacist danou sablonu z adresare
    $template = $twig->loadTemplate(TEMPLATE);

  //  printr($data);

    echo $template->render($data);
?>
<?php
    global $data;

	// nacist konfiguraci
	require 'conf/config.inc.php';
    require 'conf/style.inc.php';
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


        $data["nadpis"]="Blábol";
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


        Twig_Autoloader::register();

        // cesta k adresari se sablonama - od index.php
        $loader = new Twig_Loader_Filesystem('application/view');
        $twig = new Twig_Environment($loader); // takhle je to bez cache

        // nacist danou sablonu z adresare
        $template = $twig->loadTemplate('default.html');

        // render vrati data pro vypis nebo display je vypise
        // v poli jsou data pro vlozeni do sablony

        echo $template->render($data);
?>
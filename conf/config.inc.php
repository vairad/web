<?php

/**
 * Hlavni konfiguracni soubor.
 * 
 * Tady by mely byt vsechny duletize informace typu pripojeni k db, 
 * prefixy db tabulek a nazvy tabulek. Pro nazvy sloupcu tabulek neni treba
 * zakladat vlastni konstanty.
 *  
 */

	/**
	 * Configuration for: Error reporting
	 * Useful to show every little problem during development, but only show hard errors in production
	 */
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	/**
	 * URL projektu.
	 * Lokalni stroj: "127.0.0.1" nebo "localhost" + cesta k home adresari projektu s index.php
	 */
	define('WEB_DOMAIN', 'http://localhost/app');

	/**
	 * Pripojeni k DB.
	 */
	
	// lokalni
	define('DB_TYPE', 'mysql');
	define('DB_HOST', '127.0.0.1');
	define('DB_DATABASE_NAME', 'pivko');
	define('DB_USER_LOGIN', 'root');
	define('DB_USER_PASSWORD', '');

	// online
/*
	define('DB_TYPE', 'pgsql');
	define('DB_HOST', 'pivko.pilirion.org');
	define('DB_DATABASE_NAME', 'aki');
	define('DB_USER_LOGIN', 'aki');
	define('DB_USER_PASSWORD', 'aki_heslo');
*/
	
	/**
	 * Tady jsou ruzna databazova nastaveni.
	 */
	
	// prefix vsech mych tabulek
	define('TABLE_PREFIX', '');

	// tabulka predmetu
	define('TABLE_MISTA', TABLE_PREFIX.'mista');
    define('TABLE_HRY', TABLE_PREFIX.'hry');
    define('TABLE_OSOBY', TABLE_PREFIX.'osoby');
    define('TABLE_UVEDENI', TABLE_PREFIX.'uvedeni');
    define('TABLE_PRIHLASKY', TABLE_PREFIX.'prihlasky');



    define('MY_SES', "pivko_session");

?>

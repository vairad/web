<?php
global $data;

define("USER_RIGHTS", 1);
define("ORG_RIGHTS", 50);
define("ADMIN_RIGHTS", 90);
define("CREATE_RIGHTS", 99);


function typustuS($typuctu){
    switch($typuctu){
        case ORG_RIGHTS: return "Organizátor";
        case ADMIN_RIGHTS: return "Administrátor";
        case USER_RIGHTS: return "Uživatel";
        case CREATE_RIGHTS: return "Zakladatel";
    }
    return "Ryba mimo háček";
}


$data["startDay"]="20.2.2015";
$data["endDay"]="20.3.2015";




?>
<?php
global $data;

define("USER_RIGHTS", 1);
define("ORG_RIGHTS", 50);
define("ADMIN_RIGHTS", 99);

$data["startDay"]="20.2.2015";
$data["endDay"]="20.3.2015";

function typustuS($typuctu){
    switch($typuctu){
        case ORG_RIGHTS: return "Organizator";
        case ADMIN_RIGHTS: return "Administrator";
        case USER_RIGHTS: return "Uživatel";
    }
    return "Ryba mimo háček";
}




?>
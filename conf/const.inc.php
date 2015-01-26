<?php
global $data;

define("USER_RIGHTS", 1);
define("PREMIUM_RIGHTS", 30);
define("ORG_RIGHTS", 50);
define("ADMIN_RIGHTS", 90);
define("CREATE_RIGHTS", 99);


function typustuS($typuctu){
    switch($typuctu){
        case ORG_RIGHTS: return "Organizátor";
        case ADMIN_RIGHTS: return "Administrátor";
        case USER_RIGHTS: return "Uživatel";
        case PREMIUM_RIGHTS: return "Prémiový uživatel";
        case CREATE_RIGHTS: return "Zakladatel";
    }
    return "Ryba mimo háček";
}

/*int mktime ([ int $hour = date("H") [,
                int $minute = date("i") [,
                int $second = date("s") [,
                int $month = date("n") [,
                int $day = date("j") [,
                int $year = date("Y") [,
                int $is_dst = -1 ]]]]]]] )*/

$data["startDay"]="20.2.2015";
$data["endDay"]="20.3.2015";




?>
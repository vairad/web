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

/*int mktime ([ int $hour = date("H") [,
                int $minute = date("i") [,
                int $second = date("s") [,
                int $month = date("n") [,
                int $day = date("j") [,
                int $year = date("Y") [,
                int $is_dst = -1 ]]]]]]] )*/

define("START_TIME", mktime(20, 00, 00, 01, 29, 2014)); // snad 29.01.2015 20:00:00
define("END_TIME", mktime(20, 00, 00, 02, 27, 2015)); // snad 27.02.2015 20:00:00

$data["startDay"]="20.2.2015";
$data["endDay"]="20.3.2015";




?>
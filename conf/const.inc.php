<?php

define("USER_RIGHTS", 1);
define("ORG_RIGHTS", 50);
define("ADMIN_RIGHTS", 99);

function typustuS($typuctu){
    switch($typuctu){
        case ORG_RIGHTS: return "Organizator";
        case ADMIN_RIGHTS: return "Administrator";
        case USER_RIGHTS: return "Uživatel";
    }
    return "Ryba mimo háček";
}

?>
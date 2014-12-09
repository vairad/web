<?php


/*************************************
 * Funkce transformace a kontroly dat
 * @param $mail mail ke kontorle
 * @return bool
 */
function je_mail($mail) {
    $test=mb_ereg_match("^.+@.+\..+$",$mail);
    if($test==TRUE)return TRUE;
    else return FALSE;      }

/***
 * funkce pro omezení délky řetězce, vrací TRUE FALSE string ja dlouhý od a do b
 *
 * @param $a int min delka
 * @param $string string ke kontrole
 * @param $b int max delka
 * @return bool
 */
function delka($a,$string,$b){
    if ( (strlen($string)<=$b) and (strlen($string)>=$a) ) return TRUE;
    else return FALSE;
};

function dateToData($date){
    $dateARR = explode(".", $date);
    $timestamp = mktime(0,0,0,$dateARR[1],$dateARR[0],$dateARR[2]);
    if($timestamp != false){
        return timeToData($timestamp);
    }
    else{
        return false;
    }
}

function timeToData($timestamp){
    $datum=date("Y-m-d H:i:s.u",$timestamp) ;
   // echo ($datum);
    return $datum;
}


// specialni vypis
function printr($val)
{
    echo "<hr><pre>";
    print_r($val);
    echo "</pre><hr>";
}


?>
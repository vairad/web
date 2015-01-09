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
/**
 * @param $date strig
 * @return bool|string
 */
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

/**
 * @param $date strig dd.mm.yyyy.hh.mm
 * @return bool false pokud selže  |string
 */
function DateTimeToTimestamp($date){
    $dateARR = explode(".", $date);

    if($dateARR[4] > 59 || $dateARR[4] < 0)return false; // standardní rozsah minut 0 - 59
    if($dateARR[3] > 23 || $dateARR[3] < 0)return false; // standardni rozsah hodin 0 - 23

    $timestamp = mktime($dateARR[3],$dateARR[4],0,$dateARR[1],$dateARR[0],$dateARR[2]);
   return $timestamp;
}

/**
 * @param $timestamp
 * @return bool|string
 */
function timeToData($timestamp){
    $datum=date("Y-m-d H:i:s.u",$timestamp) ;
   // echo ($datum);
    return $datum;
}

function pohlaviS($bool){
    if($bool){
        return "muž";
    }
    else{
        return "žena";
    }
}

function vek($dateDB){
   $now = date("Y-m-d");
    return $now-$dateDB;
}

function cze_datum($datetime) {
    $datum=explode (" ", $datetime) ;
    $denmesic=explode ("-", $datum[0]) ;
    $hms=explode (":", $datum[1]) ;
    $mesic=round($denmesic[1],0);
    $den=round($denmesic[2],0);
    $rok=$denmesic[0];
    $hodina=$hms[0];
    $minuta=$hms[1];
    return "".$den.".".$mesic.".".$rok." ".$hodina.":".$minuta."";
}

// specialni vypis
function printr($val)
{
    echo "<hr><pre>";
    print_r($val);
    echo "</pre><hr>";
}


?>
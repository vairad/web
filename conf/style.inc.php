<?php
global $data;
//název použité šablony
define("NAME", "default");

/** pozice části view v adresářové struktuře*/
define('VIEW', "./application/view");

// nastavení cest k bootstrapu
$data["bootstrap_css"]=VIEW."/bootstrap/css/bootstrap.min.css";
$data["bootstrap_theme"]=VIEW."/bootstrap/css/bootstrap-theme.min.css";
$data["bootstrap_js"]=VIEW."/bootstrap/js/bootstrap.min.js";
$data["bootstrap_datepicker"]=VIEW."/bootstrap-datepicker/bootstrap-datepicker.js";
$data["bootstrap_dp_css"]=VIEW."/bootstrap-datepicker/css/datepicker3.css";
$data["bootstrap_dp_locale"]=VIEW."/bootstrap-datepicker/locales/bootstrap-datepicker.cs.js";

// nastavení konkrétního šablony dle názvu
define('TEMPLATE', NAME.".html");
$data["my_css"]=VIEW."/".NAME.".css";
$data["header_img"]=VIEW."/picture/".NAME."_header.png";


?>
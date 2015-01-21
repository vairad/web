<?php
global $data;
//název použité šablony
define("NAME", "default");

/** pozice části view v adresářové struktuře*/
define('VIEW_CORE', "./application/view/core");
/** pozice části view v adresářové struktuře*/
define('VIEW_TEMPLATES', "./application/view/templates");


// nastavení cest k bootstrapu
$data["bootstrap_css"]=VIEW_CORE."/bootstrap/css/bootstrap.min.css";
$data["bootstrap_theme"]=VIEW_CORE."/bootstrap/css/bootstrap-theme.min.css";
$data["bootstrap_js"]=VIEW_CORE."/bootstrap/js/bootstrap.min.js";
$data["bootstrap_datepicker"]=VIEW_CORE."/bootstrap-datepicker/bootstrap-datepicker.js";
$data["bootstrap_dp_css"]=VIEW_CORE."/bootstrap-datepicker/css/datepicker3.css";
$data["bootstrap_dp_locale"]=VIEW_CORE."/bootstrap-datepicker/locales/bootstrap-datepicker.cs.js";

//nastavení cest k tinyMCE
$data["tinymce_js"]=VIEW_CORE."/tinymce/js/tinymce/tinymce.min.js";


// nastavení konkrétní šablony dle názvu
define('TEMPLATE', NAME.".html");

$data["my_css"]=VIEW_TEMPLATES."/".NAME.".css";
$data["header_img"]=VIEW_TEMPLATES."/picture/".NAME."_header.png";
$data["favico"]=VIEW_TEMPLATES."/picture/".NAME."_favicon.png";

?>
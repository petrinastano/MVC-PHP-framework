<?php

/*
 * ---------------------------------------------------------------
 *  Zadefinujeme potrebne konstanty
 * ---------------------------------------------------------------
 */

// definujeme si root webu
define("BASE_PATH", dirname(realpath(__FILE__))."/");

// zachyt adresarovu strukturu bootstrapera index.php
define("BASE_DIR", dirname($_SERVER['PHP_SELF'])."/");

// zachyt adresu od kontrolera
define("APP_URL", str_replace(BASE_DIR, "",  $_SERVER['REQUEST_URI']));


/*
 * ---------------------------------------------------------------
 *  Spristupni system pre tvorbu a ulozenie instancii tried
 * ---------------------------------------------------------------
 */

require_once(BASE_PATH.'system/core/getclasses.php');


//Smerovac dostane URL adresu,na jej zaklade zavola prislusny controler
$url = &returnClass('url', 'system/core');

//vrat => controller,metoda,parameter
$parseURL = $url->parseURL($_SERVER['REQUEST_URI']);


//Hlavný controller
require_once(BASE_PATH.'system/core/controller.php');

//pristup k instanciam
function &instances(){
  return Controller::instances();
}

//---------------------------------------------------------------


//Podme na to... ;)
$url->runApp($parseURL);

?>




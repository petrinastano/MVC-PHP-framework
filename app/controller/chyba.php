<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Chyba extends Controller{

 	public function error(){
 		// Hlavička požadavky
        header("HTTP/1.0 404 Not Found");

        $this->data['title'] = "404";
        $this->data['error'] = "Stranka ktoru hladas neexistuje";

        $this->loadView('chyba');
 	}

 }

?>
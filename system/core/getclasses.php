
<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );


/*
* ---------------------------------------------------------------
*  Spustime zakladne triedy
* ---------------------------------------------------------------
*/
 
/*
* ---------------------------------------------------------------
*  Tato funkcia bude sluzit ako tovarna pre vytvorenie a ulozenie
*  instancii tried s ktorymi aplikacia pracuje. Zmiesame navrhove 
*  vzory Singleton a Factory method
* ---------------------------------------------------------------
*/

/**
* 
*
* @access	public
* @param	string	nazov triedy ktoru chceme
* @param	string	kde ma aplikacia hladat triedu
* @return	object
*/

if ( ! function_exists('returnClass')){
 function &returnClass($class, $dir=""){

	//trezor :)
	static $instances = array();


	if(!array_key_exists($class, $instances)){
		//inak zapoj subor
		require_once($dir.'/'.$class.'.php');

		//vytvor a uloz instanciu
		$instances[$class] = new $class;

		//sleduj vytvorene instancie,prihod do suflika :)
		loadedClass($instances);
	}

	$instance = & $instances[$class];

	//print_r($instance);
	return $instance;

 }


//---------------------------------------------------------------


/**
* Odchyt nacitane triedy,prihod so suflika
*
* @param	array
* @return	array
*/


if ( ! function_exists('loadedClass')){
	function loadedClass($instances=""){

		//suflik pre nacitane triedy
		static $loaded = array();

		//Pokial boli vytvorene nove instancie,skontrolujeme a ulozime
		if($instances != ""){
			foreach ($instances as $key => $value) {
				if(!array_key_exists($key, $loaded)){
					$loaded[$key] = $value;
				}
			}
		}

		else
			return $loaded;

	}
}


}

?>


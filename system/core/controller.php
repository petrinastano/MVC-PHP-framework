
<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Controller{

    protected $data = array();

    private static $core;


    public function __construct(){

    	self::$core = & $this;

    	//spusti autoloader
    	$this->autoload();

    	//vsetky instancie tried nastav ako premenne,pristupne z vonka
    	foreach (loadedClass() as $key => $value) {
    		$this->$key = &returnClass($key);
    	}

    }


    public function &instances(){
    	return self::$core;
    }


 	// --------------------------------------------------------------------

	/**
	 * Nacitaj subor s pozadovanym vystupom
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @return	
	 */

 	public function loadView($template,$view=""){
 		  if(count($this->data)>0){
 		  	//vytvor z pola $vars potrebne premenne
 		  	extract($this->data);
 			extract($this->xssFilter($this->data),EXTR_PREFIX_ALL, "");
 		  }

 		  //zapoj template subor
 		  require(BASE_PATH.'app/view/'.$template.'.php');

 	}

 	//velice provizorny xss filter :D :D
 	private function xssFilter($variables){
 		foreach ($variables as $key => $value) {
 			$variables[$key] = htmlspecialchars($value,ENT_QUOTES);
 		}

 		return $variables;
 	}

 	// --------------------------------------------------------------------

	/**
	 * Naloaduj model,pripoj sa k DB
	 *
	 * @access	public
	 * @param	string
	 */

	public function loadModel($model){
		//Pripojenie na databazu
		require_once(BASE_PATH.'system/database/database.php');
		Database::connect();

		if(is_array($model)){
			foreach ($model as $value) {
			   $this->$value = &returnClass($value, 'app/model');
			}
		}
		else
		    $this->$model = &returnClass($model, 'app/model');
	}



	// --------------------------------------------------------------------

	/**
	 * Naloaduj knižnicu
	 *
	 * @access	public
	 * @param	string / array
	 */

	public function loadLib($library,$dir=""){
	    //Moznost loadnut viac kniznic - zoznam volanych kniznic v array()
		if(is_array($library)){
		  //pokial chce nacitat vsetky subory z rovnakeho priecinka
		  //potrebne zadefinovat $dir="priecinok" a $library ako pole s nazvami
		  if($dir != ""){
		  	foreach ($library as $value) {
			    $this->$value = &returnClass($value, ''.$dir.'/libraries');
			}
		  }

		  //V opacom pripade moze nacitavat naraz subory z roznych priecinkov
		  //teda $library = array("priecinok" => "subor");
		  else{
		  	foreach ($library as $key => $value) {
			   $this->$value = &returnClass($value, ''.$key.'/libraries');
			}
		  }
		}

		else
			$this->$library = &returnClass($library, ''.$dir.'/libraries');
	}

	// --------------------------------------------------------------------

	/**
	 * Naloaduj helper
	 *
	 * @access	public
	 * @param	string / array
	 */

	public function loadHelper($helper,$dir=""){
		//Moznost loadnut viac helperov - zoznam volanych helperov v array()
		if(is_array($helper)){
		  //Odtran pripadne duplicitne helpre :)
		  $helper = array_unique($helper);

		  //pokial chce nacitat vsetky subory z rovnakeho priecinka
		  //potrebne zadefinovat $dir="priecinok" a $library ako pole s nazvami
		  if($dir != ""){
		  	foreach ($helper as $value) {
			  //Pripoj subor
			  require_once(BASE_PATH.''.$dir.'/helpers/'.$value.'.php');
			}
		  }

		  //V opacom pripade moze nacitavat naraz subory z roznych priecinkov
		  //teda $library = array("priecinok" => "subor");
		  else{
		  	foreach ($helper as $key => $value) {
			   //Pripoj subor
			  require_once(BASE_PATH.''.$key.'/helpers/'.$value.'.php');
			}
		  }
		}

		else
			require_once(BASE_PATH.''.$dir.'/helpers/'.$helper.'.php');
	}

	// --------------------------------------------------------------------

	/**
	 * Metoda autoloader,automaticke nacitavanie kniznic,helperov,modelov...
	 * Nastavenia v subore "app/config/autoload.php"
	 *
	 * @access	private
	 */

	private function autoload(){

		include(BASE_PATH.'app/config/autoload.php');

		foreach ($autoload as $key => $value) {
		  //pokial chceme naozaj nieco nacitat :)
		  if(count($value)){
		  	  switch ($key) {
				case 'helpers':
				   $this->loadHelper($value);
				break;

				case 'libraries':
				   $this->loadLib($value);
				break;

				case 'model':
				   $this->loadModel($value);
				break;
			  }
		  }
		}

	}

 }

?>
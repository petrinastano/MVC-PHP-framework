<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Url{

   //ktorý controller
   private $default_controller;

   //ktorá metóda sa má zavolat ako prva
   private $method;


   // --------------------------------------------------------------------

	/**
	 * Smerovac odchyti pekny tvar adresy napr. kategoria/sport/udalost/futbal
	 *
	 * @access	public
	 * @param	string
	 * @return	
	 */

   public function routerParser($niceUrl){
 		//$niceUrl je maska skutocneho tvaru "systemovej" url adresy

 		//nase nepekne tvary url adresy ulozime na jedno miesto
 		include(BASE_PATH.'app/config/route.php');

 		//najskor uloz hlavny controler a metodu
 		$this->default_controller = $route['default_controller'];
 		$this->method             = $route['method'];

 		foreach ($route as $key => $value) {
 			if(preg_match('#^'.$key.'$#', $niceUrl)){

 				if (strpos($value, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$value = preg_replace('#^'.$key.'$#', $value, $niceUrl);

				}

					return explode('/', $value);

 			}
 		}

 	}


    // --------------------------------------------------------------------

	/**
	 * Rozbi URL adresu
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */

    public function parseURL($url){
      /**
       * rozbi url na zaklade adresarovej struktury suboru index.php napr.(projekt/nazov)
       * http://localhost/projekt/nazov/auta/medo/ => /auta/medo/
       */

    	$explode = explode(BASE_DIR, $url);

   		//osetri "/" ktorym mozu parametre zacinat alebo koncit,odstran biele znaky
   		$explode[1] = ltrim(rtrim($explode[1],"/"),"/");
   		$explode[1] = trim($explode[1]);

   		//rozbi url s controllermi,metodami a parametrami
   		if($explode[1] != ""){
   			return explode('/', $explode[1]);
   		}

   		//pokial nebol definovany controller,zober jeho defaultnu hodnotu
   		$defaultURL = array($this->default_controller,$this->method);

   		return $defaultURL;
    }


	// --------------------------------------------------------------------

	/**
	 * Osetri neexistujucu adresu,controler + metodu
	 *
	 * @access	public
	 * @param	string
	 */

	public function existController($controller){
		//over controller
		if(!file_exists(BASE_PATH.'app/controller/'.$controller.'.php'))
			$this->redirect(BASE_DIR.'chyba/error');

	}

	// --------------------------------------------------------------------

	/**
	 * Osetri neexistujucu metodu,presmeruj na chybovu hlasku
	 * Skontroluj pristup k existujucej metode
	 *
	 * @access	public
	 * @param	string
	 * @return	object
	 */

	public function existMethod($object, $methodName){
		if(!method_exists($object, $methodName))
 			$this->redirect(BASE_DIR.'chyba/error');
 		else{
 			//Odchyt nazov triedy z jej objectu
 			$className = get_class($object);

 			//over aky je pristup k metode(private,protected)
 			$reflection = new ReflectionMethod($className, $methodName);

 			//Zavolaj metodu pokial je jej pristup nastaveny na "public"
 			if(!($reflection->isPublic()))
 				$this->redirect(BASE_DIR.'chyba/error');	
 		}

 		return $reflection;
	}


	// --------------------------------------------------------------------

	/**
	 * Nastav parametre metody
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @return	array
	 */



	public function setParams($explode, $countParams){
		$params = array();//sem uloz parametre metody

		//počet na zaciatku
		$count = count($explode);

		//Zisti pocet zadanych parametrov v URL adrese
		for ($i=2; $i < $count; $i++) {
			$p = $i-1;
		}

		//ak je pocet parametrov vacsi ako ma byt :)
		if($p>$countParams){
		  //odstran prebytocne segmenty/parametre
		  for ($i=2+$countParams; $i < $count; $i++) { 
		  	unset($explode[$i]);
		  }

		  //print_r($explode);

		  //Po upraveni presmeruj naspat na adresu su spravnym poctom parametrov
		  $url = BASE_DIR.implode('/', $explode);

		  $this->redirect($url);
		}

		if($count>3){
		  for ($i=2; $i < $count; $i++){ 
			$params[] = $explode[$i];
		  }
		}
		else
		  	$params[] = $explode[2];


		return $params;
	}

	// --------------------------------------------------------------------

	/**
	 * Zachyť metodu a jej parametre
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @return	array
	 */

	public function runApp($parseURL){
		//skontroluj ci maskujeme nejaky skutocny tvar URL
		if($router = $this->routerParser(APP_URL)){
			$parseURL = $router;
		}

		//odchyt nazov controllera
		$controller = (isset($parseURL[0]))? $parseURL[0]:$this->default_controller;

		//Skontroluj ci je tento controller vobec dostupny
		$this->existController($controller);

		//vloz potrebny controller,vytvor instanciu
		$myObject = &returnClass($controller,'app/controller');

		//zachyt metódu
		$methodName = (isset($parseURL[1]))? $parseURL[1]:$this->method;



		//skontroluj metodu,pripadne vrat reflection object
		$refl = $this->existMethod($myObject, $methodName);


		//zachyt parametre metody pokial boli zadane a skontroluj ci metoda tieto parametre vezme
		if(isset($parseURL[2]) && $countParams = $refl->getNumberOfParameters()){
			$params = $this->setParams($parseURL,$countParams);

		  	//Zavolaj metodu,zahrn potrebne parametre
 			call_user_func_array(array($myObject, $methodName), $params);
		}
		//Volaj metodu bez parametrov
		else
			$myObject->$methodName();

	}

	// --------------------------------------------------------------------

	/**
	 * Presmeruj kam treba
	 *
	 * @access	public
	 */

	public function redirect($redirectTo){
		echo $redirectTo;

		header("Location: $redirectTo");
        header("Connection: close");
        exit;
	}

 }

?>




<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

  
   class Formvalid{

   		//uloz input "name" a metody cez ktore budu data overovane
   	    public $inputs  = array();

   		//ukladáme chybové hlášky(input pole => nazov chyby)
   		public $errors = array();

   		//z ktorym polom pracujem
   		public $field = "";


   		// --------------------------------------------------------------------

		/**
	 	  * "Rozhranie" ktorym volame potrebne validacne metody na pole input
	 	  * @access	public
	 	  * @param	string
	 	  * @param	string
	 	  * @return	object
	 	*/

	 	public function validRules($inputName, $name, $rules){
	 		//spracuj nazvy valid metod ,rozbit $rules-ulozit do pola,osetrit duplicity
	 		$validMethods = array_unique(explode('/', $rules));

	 		//uloz input "name","labelname" a metody
	 		$this->inputs[$inputName] = array('labelname' => $name, 
	 										  'methods'   => $validMethods);

	 		//Uloz data z formularu,ak su dostupne - orez prazdne znaky
	 		$this->inputs[$inputName]['value'] = (isset($_POST[$inputName]))? trim($_POST[$inputName]):'';

	 		return $this;
	 	}


	 	// --------------------------------------------------------------------

		/**
	 	  * Spusti validaciu
	 	  * @access	public
	 	  * @return	bool
	 	*/

	 	public function runValidation(){
	 		//boli nastavene inputy na validaciu
	 		if(count($this->inputs)){
	 			//prebehni inputy
	 			foreach ($this->inputs as $key => $value) {
	 				//nastav aktualne validovane pole
	 				$this->field = $key;

	 				//vytiahni data pola z  $this->inputs
	 				$inputData = $this->inputs[$this->field]['value'];

	 				//prebehni nazvy metod
	 				foreach ($value['methods'] as $value) {
	 					//zavolaj valid metody,skontroluj ci beru parametre napr. "match[data]"
	 					if(strpos($value, '[') !== false){
	 						//parametre medzi znakmi "[ ]"
	 						preg_match('/\[(.*?)\]/',$value,$param);

	 						//vytiahni nazov metody pred znakom "["
	 						$method = explode('[', $value)[0];

	 						//zavolaj metodu,vloz parametre
	 						$this->$method($param[1]);
	 					}
	 					else
							$this->$value($inputData);
	 				}
	 			}

	 			//Pokial sa nasli chyby,vypis potrebne chyb.hlasky
	 			if(count($this->errors)){
	 				//subor s chyb. hlaskami - dostupne pole $form
	 				include(BASE_PATH.'system/language/sk/formvalid_sk.php');

	 				//vytvor attribut form pre moznost pristupu k chybam z helperu
	 				$formArr = 'form';

	 				$this->$formArr = $form; //array chybovych hlasok -subor "formvalid_sk.php"

	 				//MVC suflik :)
	 				$object = &instances();

	 				//zavolaj helper ktorym vo "view" vypiseme chyby - showValidErr()
	 				$object->loadHelper('show_form_errors','system');

	 				//uloz chyby ktore neskor cez tuto funkciu vypises
	 				showValidErr();

	 				return false;
	 			}
	 		}

	 		else
	 			die('Pred zavolanim metody "runValidation" nastav potrebne inputy v metode "validRules()"');
	 	}


	 	// --------------------------------------------------------------------

		/**
	 	  * Over format emailovej adresy
	 	  * @access	public
	 	  * @param  array  ("name" input pola => data)
	 	*/

	 	public function email($email){
	 		//PHP funkcia filter_var() podporovana od verzie 5.2.0,budme ohladuplny pre pripadne starsie verzie
	 		if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
    			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    				//nastav chybovu hlasku
    				$this->set_error($this->field,'email');
    			}
			}

			// < 5.2.0
			else{
			   // zdroj - http://lxr.php.net/xref/PHP_5_4/ext/filter/logical_filters.c#501
			   // Michael Rushton 2009-10
	 		   $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

	 		   if(!preg_match($pattern,$email)){
	 				$this->set_error($this->field,'email');
	 			}
			}
	 	}



	 	// --------------------------------------------------------------------

		/**
	 	  * Nastav chybove hlasky
	 	  * @access	private
	 	  * @param  string
	 	  * @param  array  ("name" input pola => data)
	 	*/

	 	private function set_error($errField,$errType){
	 		$this->errors[$errField] = $errType;
	 	}

   }


?>
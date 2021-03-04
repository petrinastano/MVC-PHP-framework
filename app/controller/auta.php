<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Auta extends Controller{

 	public function __construct(){
 		parent::__construct();
 	}


 	public function index(){

 		$this->data['title'] = "Login";

 		$this->loadView('templates/logintemplate','login');

 	}


 	
 	public function login(){

 		//Form validation - system kniznica
 		$this->loadLib('formvalid','system');

 		//Over spravny format dat z formularu - iba pre test
 		//(zatial spravena len "email" metoda v system/libraries/formavalid.php)
 		$this->formvalid->validRules('email', 'Email', 'email')
 						->validRules('pass', 'Hesielko', 'email');

 		//pokial neboli data v spravnom formate,vypis chybove hlasky
 		if(!$this->formvalid->runValidation()){
 			$this->index();
 		}
 		else{
 			//over data z DB nastav session
 			$model = $this->loadModel('test');

 			//autentifikacna kniznica
 			$this->loadLib('auth', "system");

 			//nastav s ktorym modelom bude kniznica pracovat
 			$this->auth->initModel($model);

 			//potom len zavolat potrebnu metodu z modelu,overit data z formu a presmerovat kam treba :)
 		}

 		//$this->loadHelper('simple_hash');

 		//echo hash_pass("Secret");	
 	}


    public function template(){
    	$this->data['title'] = "Home";

    	$this->loadView('templates/template','template_content_home');
    }

 }

?>
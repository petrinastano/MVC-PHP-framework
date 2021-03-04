<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Auth{

  private $instance = &instances();

  private $model;


  private function initModel($model){
  		$this->model = $model;
  }

  public function findUser($username){
    //najdi usera v DB...
  }


  public function auth($username, $password){

  //over ci data existuju
 	$sql    = 'SELECT COUNT(*) FROM users WHERE email=? AND pass=?';
 	$params = array($username , $password); 

 	if($this->instance->test->countWhere($sql, $params))
    //po zhode ideme dalej :) ...
  }

 }

?>
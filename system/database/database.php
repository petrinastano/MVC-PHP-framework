<?php

 if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Database{

 	//Pripojenie k DB
 	private static $connect;

 	//Nastavenia PDO vsrstvy
 	private static $optionsPDO = array(
 		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false
    );

 	//Nastavenie pristupovych prav k DB
    private static $connectData = array(
    	'hostname' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database' => 'mymvc'
    );
 	
    //Vykonaj pripojenie k DB pokial nebolo vytvorene,inak uloz do $connect
 	public static function connect(){
 		if(!isset(self::$connect)){
 			self::$connect = @new PDO(
 				'mysql:host='.self::$connectData['hostname'].';dbname='.self::$connectData['database'].'',
                self::$connectData['username'],
                self::$connectData['password'],
                self::$optionsPDO
 			);
 		}
 	}

    //vsetky zaznamy / alebo pocet najdenych zaznamov $getCount = true
 	public static function queryAll($query, $params = array() ,$getCount = false) {
 	  try {
 	  	$return = self::$connect->prepare($query);
        $return->execute($params);

        return ($getCount)? $return->fetchColumn():$return->fetchAll();
 	  } 
 	  catch (PDOException $e) {
 	  	throw new Exception($e->getMessage());
 	  }
	}

 }

?>
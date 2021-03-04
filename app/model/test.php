<?php

if ( ! defined('BASE_PATH') )
    exit( 'No direct script access allowed' );

 class Test{

 	//Vyber data za urcitej podmienky
 	function selectWhere($columns, $where, $value, $table){
 		  $query = 'SELECT '.$columns.'
 		  			FROM '.$table.'
 		  		    WHERE '.$where.' = ?';

 		  return Database::queryAll($query, $params = array($value));
 	}

 	//Spocitaj zaznamy za urcitej podmienky, (bool)true - vrat pocet
 	function countWhere($where, $value, $table){
 		$query = 'SELECT COUNT(*)
 				  FROM '.$table.'
 				  WHERE '.$where.' = ?';

 		return Database::queryAll($query, $params = array($value), true);
 	}


 	//Spocitaj zaznamy za urcitej podmienky - sql
 	function countWhere($sql, $params){
 		return Database::queryAll($sql, $params, true);
 	}


 }

?>
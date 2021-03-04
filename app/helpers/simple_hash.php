<?php

 //velmi dobry clanok o bezpecnom ukladani hesiel
 //http://php.vrana.cz/ukladani-hesel-bezpecne.php
 
/*
* ---------------------------------------------------------------
*  Bcrypt, PBKDF2 a Scrypt
*  Všetky tri sa pre ukladanie hesiel daju pouzit, vsetky maju 
*  parameter umoznujuci nastavit, kolko iterací hasovania se ma previest
*  Ten je vhodne nastavit tak, aby se jedno zadané heslo overilo na vasich
*  serveroch v rozumnom case, napr. do pol sekundy. 
*  Vasich uzivatelov to nijak vyrazne neobmedzi a utocnika to podstatne zpomali
* ---------------------------------------------------------------
*/

 function hash_pass($pass ,$i=""){
 	$options = ($i)? array('cost' => $i):array('cost' => 12); // 2^cost je pocet iteracii do pol sekundy

 	return password_hash($pass, PASSWORD_BCRYPT, $options);
 }


 function verify($pass, $pass_hash){
 	return password_verify($pass, $pass_hash);
 }

?>
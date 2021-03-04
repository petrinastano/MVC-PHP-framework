<?php

/*
* ---------------------------------------------------------------
*  system helper
*  Funkcia volana pri vyskyte chyb po osetreni vstupov z formularu
* ---------------------------------------------------------------
*/

function showValidErr($wrap='<p>', $end_wrap='</p>'){

	//MVC suflik :) chceme pristupit k atributom triedy "Formvalid"
	$object = &instances();

	//statika pre ukladanie chybovych hlasok
	static $errString = array();

	//pokial sa nasli chyby,vypis chyby - pri prvom volani uloz chyby do static,pri druhom vypis
	if(count($object->formvalid->errors)){

		foreach ($object->formvalid->errors as $inputName => $errType) {
		   $errString[]=str_replace('%s', $object->formvalid->inputs[$inputName]['labelname'], $object->formvalid->form[$errType]);
		}


		//Vycisti pole s chybami
		$object->formvalid->errors = array();
	}

	else{
		$html = "";

		foreach ($errString as $value) {
			$html.= $wrap.$value.$end_wrap;
		}

		return $html;
	}

}

?>
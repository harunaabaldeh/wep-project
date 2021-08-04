<?php
function sanitizeFormOther($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = strtolower($inputText);
	return $inputText;
}


function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormName($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = ucwords($inputText, " ");
	return $inputText;
}

function cleanData($data) {
	// $str = urldecode ($str );
	//$str =  strip_tags($inputText);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data ;
}


?>
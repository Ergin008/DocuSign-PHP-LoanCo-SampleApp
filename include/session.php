<?php
session_name("LoanCo"); 
session_start();

$_SESSION["debug"]=true;


// read some options from options.php
if(!isset($_SESSION["OptionsSet"]) ) {
	include("include/options.php");

	if(strlen($options["AccessCode"]) > 0 ) {
		$_SESSION["AccessCode"] = $options["AccessCode"];
	} 
	if(isset($options["SigningLocation"])) {
		$_SESSION["SigningLocation"] = $options["SigningLocation"];
	} else {
		$_SESSION["SigningLocation"] = "Embedded";
	}
	if(isset($options["Authentication"])) {
		$_SESSION["Authentication"] = $options["Authentication"];
	} else {
		$_SESSION["Authentication"] = "None";
	}
	
	$_SESSION["OptionsSet"] = true;
	
	
}

// common functions

function isLoggedIn(){
	$retval = false;
	if (isset($_SESSION["LoggedIn"]) && ($_SESSION["LoggedIn"] === true )){
		$retval = false;
	}
	return $retval;
}

function loginCheck($redirectURL){
	if (!isset($_SESSION["LoggedIn"]) || ($_SESSION["LoggedIn"] <> true )){
		header("Location: " . $redirectURL);
	}
	
}

function CheckSessionValue($key, $val){
	$retval = false;
	if((isset($_SESSION[$key])) && ($_SESSION[$key]==$val)){
		$retval = true;
	}
	return $retval;
}

function xmlpp($xml, $html_output=false) {  
    $level = 4;  
    $indent = 0; // current indentation level  
    $pretty = array(); 
 		$retval = "";
	try {
    $xml_obj = new SimpleXMLElement($xml);  
    // get an array containing each XML element  
    $xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));  

    // shift off opening XML tag if present  
    if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {  
      $pretty[] = array_shift($xml);  
    }  

    foreach ($xml as $el) {
	  	// remove password
		$pos = strpos($el, "PasswordText");
		if($pos > 0){
			$start = $pos + 14;
			$end = strpos($el, "</wsse:Password>", $start);
			$newEl = substr($el, 0, $start) . "xxxxxxxxxxxx" . substr($el,$end, strlen($el));
			$el = $newEl;
		}

      if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {  
          // opening tag, increase indent  
          $pretty[] = str_repeat(' ', $indent) . $el;  
          $indent += $level;  
      } else {  
        if (preg_match('/^<\/.+>$/', $el)) {              
          $indent -= $level;  // closing tag, decrease indent  
        }  
        if ($indent < 0) {  
          $indent += $level;  
        }  
        $pretty[] = str_repeat(' ', $indent) . $el;  
      }  
    }     
    $xml = implode("\n", $pretty); 
    $retval = ($html_output) ? htmlentities($xml) : $xml;
	} catch(Exception $excp){
		
	}
    return $retval;  
}

function addToLog($desc, $msg){
   $d =  date('d/m/Y H:i:s');
	if(!isset($_SESSION["traceLog"])){
		$_SESSION["traceLog"] = array();
		$_SESSION["traceLog"][] = "Log Started - " . $d . "<br/>";
	}
	if(count($_SESSION["traceLog"]) > 10 ){
		array_shift($_SESSION["traceLog"]);
	}
   $_SESSION["traceLog"][] = "[".$_SERVER['REMOTE_ADDR']."] - ".$d.": ".$desc ."<br/>" . $msg . "<br/>";

}

function requireOrDie($arr){
	$missingFields = array();
	foreach($arr as $var) {
		if(!isset($_POST[$var]) ){
			$missingFields[]=$var;
		}
	}
	if(count($missingFields)>0) {
		echo(join($missingFields,",") . " fields are required but not present");
		die();
	}
}


?>
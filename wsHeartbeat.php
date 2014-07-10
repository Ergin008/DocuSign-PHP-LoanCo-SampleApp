<?php
/**
 * @copyright Copyright (C) DocuSign, Inc.  All rights reserved.
 *
 * This source code is intended only as a supplement to DocuSign SDK
 * and/or on-line documentation.
 * This sample is designed to demonstrate DocuSign features and is not intended
 * for production use. Code and policy for a production application must be
 * developed to meet the specific data and security requirements of the
 * application.
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
 * PARTICULAR PURPOSE.
 */
 
// start session and some helper functions
include("include/session.php");

$f1 = false;
$f2 = false;
$webserviceType = $_REQUEST['webservice'];
if ( $webserviceType == "credential") {
	try {
        include("Envelope.php");
        $client = new SoapClient("https://demo.docusign.net/API/3.0/Credential.asmx?WSDL");
        $arr = array();
        $response = $client->Ping($arr);    
        if ($response->PingResult=="1") echo("true");    
    } catch (Exception $e) {        
        echo($e);
    }
} else {
	try {
    
        $ini_array = parse_ini_file("Credentials.ini");
        $IntegratorsKey = $ini_array["IntegratorsKey"];
        $username = $_SESSION["Email"];
        $password = $_SESSION["Password"];
        
        $client = new SoapClient("https://demo.docusign.net/API/3.0/Credential.asmx?WSDL");
        $arr = array("Email" => $username, "Password" => $password);
        $response = $client->Login($arr);
        if ($response->LoginResult->AuthenticationMessage=="Successful authentication") $f2 = true;
	} catch (Exception $e) {        
        echo($e);
   }
}
    if ($f1 && $f2) echo("true");
?>
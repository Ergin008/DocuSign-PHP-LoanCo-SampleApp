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

//  credential api service proxy classes and soapclient
include("api/CredentialService.php");
// transaction api service proxy classes and soapclient
include("api/APIService.php");

// initialize our api proxies here
// get creds from ini file
if(!isset($_SESSION["CredentialsSet"])){
	// check php config
	if(extension_loaded('soap') && extension_loaded('curl') && extension_loaded('mcrypt') && extension_loaded('xml') && extension_loaded('dom') && extension_loaded('openssl')){
		//all present
	} else {
		// send to config check page
		header("Location: configcheck.php");
		die();
	}

	$ini_array = parse_ini_file("api/Credentials.php");

	if(isset($ini_array["APIUserEmail"]) ) $username = $ini_array["APIUserEmail"];
	if(isset($ini_array["Password"])) $password = $ini_array["Password"];
	if(isset($ini_array["IntegratorsKey"]) ) $IntegratorsKey = $ini_array["IntegratorsKey"];
	if(isset($ini_array["APIAccountID"]) ) $APIAccountID = $ini_array["APIAccountID"];
	if(isset($ini_array["APIHost"]))  $APIHost = $ini_array["APIHost"];

	if(!isset($username) || !isset($password) || !isset($APIAccountID) || !isset($APIHost) || !isset($IntegratorsKey) || $IntegratorsKey == ""){
		$_SESSION["errorMessage"] = "Please make sure credentials are set (in credentials.php).";
		header("Location: error.php");
		die();
	}
	// setup credential api - we only use this when logging in s
	$creds_endpoint= $APIHost . "/api/3.0/Credential.asmx";
	$creds_wsdl = "api/CredentialService.wsdl";
	$creds_options = array('location'=>$creds_endpoint,'trace'=>true,'features' => SOAP_SINGLE_ELEMENT_ARRAYS);

	$credService = new CredentialService($creds_wsdl, $creds_options);

	// login
	$login = new Login();
	$login->Email="[" . $IntegratorsKey . "]" . $username;
	$login->Password=$password;

	try {
		$response = $credService->Login($login);
	} catch( SoapFault $fault) {
		$_SESSION["errorMessage"] = $fault;
		//$_SESSION["lastRequest"] = $api->_lastRequest;
		header("Location: error.php");
		die();
	}

	// verify that the API AccountID in the creds file is linked to this user
	$bfound = false;
	foreach($response->LoginResult->Accounts->Account as $account){
		if($account->AccountID == $APIAccountID){
			$bfound = true;
		}
	}

	if($bfound===false){
		$_SESSION["errorMessage"] = "The User is not a member of the specified Account (Check your credentials)";
		header("Location: error.php");
		die();

	}

	$_SESSION["UserID"] = $response->LoginResult->Accounts->Account[0]->UserID;
	$_SESSION["UserName"] = $response->LoginResult->Accounts->Account[0]->UserName;
	$_SESSION["Email"] = $response->LoginResult->Accounts->Account[0]->Email;
	$_SESSION["AccountName"] = $response->LoginResult->Accounts->Account[0]->AccountName;
	$_SESSION["AccountID"] = $APIAccountID;
	$_SESSION["Password"] = $password;
	$_SESSION["APIHost"] = $APIHost;
	$_SESSION["IntegratorsKey"] = $IntegratorsKey;
	if (!isset($IntegratorsKey)) {
	    $_SESSION["errorMessage"] = "The Integrator key must be set (in Credentials.php)";
		header("Location: error.php");
		die();
	}

	$_SESSION["CredentialsSet"] = true;

}

// setup api connection
$api_endpoint= $_SESSION["APIHost"] . "/api/3.0/api.asmx";
$api_wsdl = "api/APIService.wsdl";
$api_options =  array('location'=>$api_endpoint,'trace'=>true,'features' => SOAP_SINGLE_ELEMENT_ARRAYS);
$api = new APIService($api_wsdl, $api_options);
// set credentials on the api object
$api->setCredentials("[" . $_SESSION["IntegratorsKey"] . "]" . $_SESSION["UserID"], $_SESSION["Password"]);

// functions

// helper function to make tabs
function MakeTab($docID, $recID, $PageNumber, $X=null, $Y=null, $Type, $Name=null, $TabLabel=null, $Value=null,$AnchorTabString=null, $AnchorXOffset=null, $AnchorYOffset=null){
	$tab = new Tab();
	$tab->DocumentID = $docID;
	$tab->RecipientID = $recID;
	$tab->PageNumber =  $PageNumber;
	if(isset($X)){
		$tab->XPosition = $X;
	}
	if(isset($Y)){
		$tab->YPosition = $Y;
	}
	$tab->Type = $Type;
	if(isset($Name)){
		$tab->Name = $Name;
	}
	if(isset($TabLabel)){
		$tab->TabLabel = $TabLabel;
	}
	if(isset($Value)){
		$tab->Value = $Value;
	}
	if(isset($AnchorTabString)){
		$tab->AnchorTabItem->AnchorTabString = $AnchorTabString;
	}
	if(isset($AnchorXOffset)){
		$tab->AnchorTabItem->XOffset = $AnchorXOffset;
	}
	if(isset($AnchorYOffset)){
		$tab->AnchorTabItem->YOffset = $AnchorYOffset;
	}
	return $tab;
}

function makeISO8601Date(){
   return date("c", time());
}

function getClientCallbackURLS(){
	$ClientURLS = new RequestRecipientTokenClientURLs();
	$ClientURLs->OnViewingComplete = getCallbackURL("pop.html?id=2");
   $ClientURLs->OnCancel = getCallbackURL("pop.html?id=3");
   $ClientURLs->OnDecline = getCallbackURL("pop.html?id=4");
   $ClientURLs->OnSessionTimeout = getCallbackURL("pop.html?id=5");
   $ClientURLs->OnTTLExpired = getCallbackURL("pop.html?id=6");
   $ClientURLs->OnException = getCallbackURL("pop.html?id=7");
   $ClientURLs->OnAccessCodeFailed = getCallbackURL("pop.html?id=8");
   $ClientURLs->OnSigningComplete = getCallbackURL("pop.html?id=9");
   $ClientURLs->OnIdCheckFailed = getCallbackURL("pop.html?id=1");

	return $ClientURLs;
}

function makeFakeID(){
	return "ID:" . time();
}

function makeRecipient($firstname, $lastname, $email, $useEmbeddedSigning){
	$Recipient = new Recipient();
	$Recipient->ID = "1";
	$Recipient->Email = $email;
	$Recipient->UserName = $firstname." ".$lastname;
	$Recipient->Type = "Signer";
	$Recipient->RequireIDLookup = false;
	// if the option to use embedded signing is set then set the CaptiveInfo element which will tell docusign to not send email invitations
	if( $useEmbeddedSigning===true ) {
		// normally the ClientUserId would be a meaningful value but it only needs to be unique within an envelope context so we'll just use sessionId
		$Recipient->CaptiveInfo->ClientUserId = session_id();
		// signature info is optional but useful to set for embedded
		$Recipient->SignatureInfo->SignatureInitials = $firstname[0].$lastname[0];
		$Recipient->SignatureInfo->SignatureName = $firstname." ".$lastname;
		$Recipient->SignatureInfo->FontStyle = "BradleyHandITC";
	}

	return $Recipient;
}

	// security
	// This section will request an ID Lookup based on the recipients name and address, so we'll prefill those
	// values from the form data.
function AddIDLookupToRecipient($recipient, $address1=null, $address2=null, $city=null, $state=null, $zip=null){
	$recipient->RequireIDLookup = true;
	$recipient->IDCheckConfigurationName = "ID Check $";
	// prefill address
	if($address1<> null) {
		$recipient->IDCheckInformationInput->AddressInformationInput->AddressInformation->Street1 = $address1;
	}
	if($address2<> null) {
		$recipient->IDCheckInformationInput->AddressInformationInput->AddressInformation->Street2 = $address2;
	}
	if($city<> null) {
		$recipient->IDCheckInformationInput->AddressInformationInput->AddressInformation->City = $city;
	}
	if($state<> null) {
		$recipient->IDCheckInformationInput->AddressInformationInput->AddressInformation->State = $state;
	}
	if($zip<> null) {
		$recipient->IDCheckInformationInput->AddressInformationInput->AddressInformation->Zip = $zip;
	}
	$recipient->IDCheckInformationInput->AddressInformationInput->DisplayLevel = "Editable";
	$recipient->IDCheckInformationInput->AddressInformationInput->ReceiveInResponse = true;
	return $recipient;

}

function AddAccessCodeToRecipient($recipient, $accesscode){
	if(strlen($accesscode) > 0) {
		$recipient->AccessCode = $accesscode;
	}
	return $recipient;
}

function AddPhoneAuthToRecipient($recipient, $phonenumber){
   $recipient->RequireIDLookup = true;
	$recipient->IDCheckConfigurationName = "Phone Auth $";
   $recipient->PhoneAuthentication->SenderProvidedNumbers->SenderProvidedNumber[] = $_POST["Phone"];
   $recipient->PhoneAuthentication->RecipMayProvideNumber = true;
	$recipient->PhoneAuthentication->RecordVoicePrint = true;

	return $recipient;
}


function curPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function getCallbackURL($callbackPage){
	$urlbase =  curPageURL();
	$urlbase = substr($urlbase, 0, strrpos($urlbase, '/'));
	$urlbase = $urlbase . "/" . $callbackPage;
	return $urlbase;
}

function makeRequestRecipientToken(){
	// build RequestRecipientToken  - this is used when hosting an embedded signing. the return value
	// is an URL that will open up a signing session for the listed recipient. We will store the return value
	// in session and pull it out on the next page (DocuSign.php) that is actuallly hosting the signing
   $RequestRecipientToken = new RequestRecipientToken();
   $RequestRecipientToken->EnvelopeID = $_SESSION["EnvelopeID"];
   $RequestRecipientToken->ClientUserID = session_id();
   $RequestRecipientToken->Username = $_POST["FirstName"]." ".$_POST["LastName"];
   $RequestRecipientToken->Email = $_POST["Email"];

	// an authentication assertion is a statement by the hosting code (i.e. this code) to docusign that
	// the recipient has been authenticated locally, and providing a record of what that authentication method was.
	$RequestRecipientToken->AuthenticationAssertion->AssertionID = makeFakeID();

   $RequestRecipientToken->AuthenticationAssertion->AuthenticationInstant = makeISO8601Date();
   $RequestRecipientToken->AuthenticationAssertion->AuthenticationMethod = "Password";
   $RequestRecipientToken->AuthenticationAssertion->SecurityDomain = $_SERVER['HTTP_HOST'];

	// Client URLS indicate where the signing session will redirect to when it is finished - because the user
	// signed, or cancelled, or failed ID check, etc. You can set separate pages for these or just use
	// one page and use a param like 'id' to differentiate the events.
   $RequestRecipientToken->ClientURLs= getClientCallbackURLS();

	return $RequestRecipientToken;

}


?>
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

// init api and some helper functions
include("api/api.php");

ini_set('display_errors', '0');

if($_SERVER["REQUEST_METHOD"]=="POST"){  
// get form data from post - since we handle two different forms we'll switch based on formId
// and build our tabs collection for the form we're handling.
	switch($_POST["formid"]) {
		case "form1":
			requireOrDie(array("FirstName","LastName","Address1","City","State","ZIP","Phone","Email"));
		 // and set session vars for later use   
			$_SESSION["FirstName"] = $_POST["FirstName"];
			$_SESSION["LastName"] = $_POST["LastName"];
			$_SESSION["Email"] = $_POST["Email"];
			// pdf file
			$pdffile = "pdfs/SampleDoc.pdf";
			// tabs for envelope form fields and signatures
			$tabs[] = MakeTab("1","1","1","190","186","Custom","Email","Email",$_POST["Email"]);
			$tabs[] = MakeTab("1","1","1","190","173","Custom","Phone","Phone",$_POST["Phone"]);
			$tabs[] = MakeTab("1","1","1","342","160","Custom","Zip","Zip",$_POST["ZIP"]);
			$tabs[] = MakeTab("1","1","1","255","160","Custom","State","State",$_POST["State"]);
			$tabs[] = MakeTab("1","1","1","190","160","Custom","City","City",$_POST["City"]);
			$tabs[] = MakeTab("1","1","1","190","134","Custom","Address1","Address1",$_POST["Address1"]);
			if(isset($_POST["Address2"])){
				$tabs[] = MakeTab("1","1","1","190","147","Custom","Address2","Address2",$_POST["Address2"]);
			}
			$tabs[] = MakeTab("1","1","1","190","118","FullName");
			$tabs[] = MakeTab("1","1","1","373","185","SignHere");
			$tabs[] = MakeTab("1","1","2","190","532","DateSigned");
			$tabs[] = MakeTab("1","1","2","190","465","InitialHereOptional");

		break;
		case "form2":
			requireOrDie(array("FirstName","LastName","Phone","Email","Amount"));
		 // and set session vars for later use   
			$_SESSION["FirstName"] = $_POST["FirstName"];
			$_SESSION["LastName"] = $_POST["LastName"];
			$_SESSION["Email"] = $_POST["Email"];
			// pdf file
			$pdffile = "pdfs/Loan 1.pdf";
			// tabs for envelope form fields and signatures
			// note that here we are using anchor tabs, which will automatically place themselves by matching string locations in the document
			$tabs[] = MakeTab("1","1","1",null,null, "Custom","Email","Email",$_POST["Email"],"E-mail:","200","-2");
			$tabs[] = MakeTab("1","1","1",null,null,"Custom","Phone","Phone",$_POST["Phone"],"Phone:","200","-2");
			$tabs[] = MakeTab("1","1","1",null,null,"FullName",null,null,null,"Name:","200","-2");
			$tabs[] = MakeTab("1","1","1",null,null,"Custom","Amount","Amount",$_POST["Amount"],"Amount:","200","-2");
			$tabs[] = MakeTab("1","1","1",null,null,"SignHere",null,null,null,"X:","30","8");
		
		break;
	}
    
            
    // Here we'll start building our Envelope object to send to docusign. 
	// build CreateAndSendEnvelope and set basic properties
	$CreateAndSendEnvelopeParam = new CreateAndSendEnvelope();
	$CreateAndSendEnvelopeParam->Envelope->AccountId = $_SESSION["AccountID"];
	// EnvelopeIDStamping controls whether the EnvelopeID is printed on the final documents or not
	$CreateAndSendEnvelopeParam->Envelope->EnvelopeIDStamping = "true";
	$CreateAndSendEnvelopeParam->Envelope->Subject = "Loan Application";
	$CreateAndSendEnvelopeParam->Envelope->EmailBlurb = "Please sign the Loan application to start the application process.";

	// add our document. The php soap client will convert the file bytes to base64 encoding automatically when it sends the request
	$CreateAndSendEnvelopeParam->Envelope->Documents->Document->ID = "1";
	$CreateAndSendEnvelopeParam->Envelope->Documents->Document->Name = "Document";    
	$CreateAndSendEnvelopeParam->Envelope->Documents->Document->PDFBytes = file_get_contents($pdffile);

	// initialize a Recipient object with typical values and then overwrite as needed
	$useEmbedded = $_SESSION["SigningLocation"]=="Embedded"?true:false;
 	$Recipient = makeRecipient($_POST["FirstName"],$_POST["LastName"], $_POST["Email"], $useEmbedded);

	// security checks - we'll alter the Recipient object based on the security settings
	if($_SESSION["Authentication"]=="IDLookup"){
		if($_POST["formid"]=="form1") {
			//only form1 has the address information so we'll prefill it
			$address2 = isset($_POST["Address2"])?$_POST["Address2"]:null;
			$Recipient = AddIDLookupToRecipient($Recipient, $_POST["Address1"], $address2 , $_POST["City"], $_POST["State"], $_POST["ZIP"]);
		} else {
			// in this case the address information will be entered during the ID Lookup
			$Recipient = AddIDLookupToRecipient($Recipient);
		}
	}

	if ($_SESSION["Authentication"]=="Phone"){
		$Recipient = AddPhoneAuthToRecipient($Recipient, $_POST["Phone"]);
	}

	if(isset($_SESSION["AccessCode"]) && strlen($_SESSION["AccessCode"]) > 0){
		$Recipient = AddAccessCodeToRecipient($Recipient,$_SESSION["AccessCode"]);
	}

	// Add the Recipient to the Envelope
	$CreateAndSendEnvelopeParam->Envelope->Recipients->Recipient[] = $Recipient;
		// Add the Tabs to the envelope
	$CreateAndSendEnvelopeParam->Envelope->Tabs=$tabs;
	

	try {
		$Envelopes = $api->CreateAndSendEnvelope($CreateAndSendEnvelopeParam);
		$_SESSION["EnvelopeID"] = $Envelopes->CreateAndSendEnvelopeResult->EnvelopeID;
		if(isset($_SESSION["debug"]) && $_SESSION["debug"]===true){
			addToLog("CreateAndSendEnvelope Request", xmlpp($api->_lastRequest, true));
			addToLog("CreateAndSendEnvelope Response", xmlpp($api->__getLastResponse(), true));
		}

	} catch( SoapFault $fault) {
		$_SESSION["errorMessage"] = $fault;
		if(isset($_SESSION["debug"]) && $_SESSION["debug"]===true){
			addToLog("CreateAndSendEnvelope Request", xmlpp($api->_lastRequest, true));
			addToLog("CreateAndSendEnvelope Response", xmlpp($api->__getLastResponse(), true));
		}
		header("Location: error.php");
		die();
	}
	
	// Now that we've sent the envelope, we need to see if we're going to host an embedded signing session. If so, 
	// we'll need to get a RecipientToken for the signing session. The recipientToken is just a url that will open 
	// a signing session for the specified recipient on the envelope. 
	if($_SESSION["SigningLocation"]=="Embedded") {
		$RequestRecipientToken = makeRequestRecipientToken();
		try {
			$RequestRecipientTokenResponse = $api->RequestRecipientToken($RequestRecipientToken);
			$_SESSION["EmbeddedToken"] = $RequestRecipientTokenResponse->RequestRecipientTokenResult;
				if(isset($_SESSION["debug"]) && $_SESSION["debug"]===true){
					addToLog("RequestRecipientToken Request", xmlpp($api->_lastRequest, true));
					addToLog("RequestRecipientToken Response", xmlpp($api->__getLastResponse(), true));
				}
			} catch( SoapFault $fault) {
			$_SESSION["errorMessage"] = $fault;
			if(isset($_SESSION["debug"]) && $_SESSION["debug"]===true){
				addToLog("CreateAndSendEnvelope Request", xmlpp($api->_lastRequest, true));
				addToLog("CreateAndSendEnvelope Response", xmlpp($api->__getLastResponse(), true));
			}
			header("Location: error.php");
			die();
		}
		$RedirectPage = "embeddedhost.php";
	} else {
		// if we aren't hosting the signing, we'll just display a page to the user informing them of that.
		$RedirectPage = "remotesign.php";
	}


   header( 'Location: ' . $RedirectPage ) ;
}
?>
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

	$RequestPDFParam = new RequestPDF();
	$RequestPDFParam->EnvelopeID = $_GET["EnvelopeID"];
	try{
		$EnvelopePDF = $api->RequestPDF($RequestPDFParam);
	} catch(SoapFault $fault) {
		$_SESSION["errorMessage"]=$fault;
		header("Location: error.php");
		die();
	}
	
	$PDFBytes = $EnvelopePDF->RequestPDFResult->PDFBytes;
	header("Content-type:application/pdf");
	echo($PDFBytes);
?>
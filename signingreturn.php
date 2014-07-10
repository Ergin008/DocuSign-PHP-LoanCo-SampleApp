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

	$RequestStatus = new RequestStatus();
	$RequestStatus->EnvelopeID = $_SESSION["EnvelopeID"];

	try {
		$RequestStatusResponse = $api->RequestStatus($RequestStatus);
	} catch( SoapFault $fault) {
		$_SESSION["errorMessage"] = $fault;
		header("Location: error.php");
		die();
	}

	$id = $_GET["id"];
	$msg = "";
	if ($id==1) $msg = "The ID Check has failed.  The user was denied an opportunity to view or sign the document.";
	if ($id==2) $msg = "The user has viewed the document without signing it.";
	if ($id==3) $msg = "The user has cancelled out of the signing experience.";
	if ($id==4) $msg = "The user has declined to sign the document.";
	if ($id==5) $msg = "The user did not sign the document in time.  The timeout is set to 20 minutes.";
	if ($id==6) $msg = "Trusted connection has expired.  The server communication might be a problem.";
	if ($id==7) $msg = "An exception has occurred on the server.  Please check the parameters passed to the Web Service Methods.";
	if ($id==8) $msg = "The access code verification has failed.  The user was denied an opportunity to view or sign the document.";
	if ($id==9) $msg = "The user has completed the signing.  The legally binding document with signatures is stored on the DocuSign, Inc. server.";                                    

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
    <title>DocuSign, Inc. ESIGN Sample</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"></link>
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/webservice-status.js"></script>
    <script language="javascript" type="text/javascript" src="js/validation.js"></script>
    <script language="javascript" type="text/javascript">
    <!-- 
    
    /**
     * Validation the form and set validation errors if applicable.
     */
    function checkForm() {
        var why = "";
        
        var signForm = document.forms[0];
        
        why += isEmpty(signForm.FirstName.value, "FirstName");
        why += isEmpty(signForm.LastName.value, "LastName");
        why += isEmpty(signForm.Address1.value, "Address1");
        why += isEmpty(signForm.City.value, "City");
        why += isEmpty(signForm.State.value, "State");
        why += isEmpty(signForm.ZIP.value, "ZIP");
        why += checkPhone(signForm.Phone.value, "Phone");
        why += checkEmail(signForm.Email.value, "Email" );
            
        document.getElementById("formErrorText").innerHTML = why;

        if (why != "") {
            return false;
        }
        else {
            return true;
        }
    }
    
    // -->
    </script>
  </head>
  <body>
	<?php include("include/standardheader.php"); ?>
                <div class="content-section">
						<div style="margin: 10px; font-size: 10pt;">
						The integrated signing has returned to the LoanCo.com.
							<br />
							<?php echo($msg); ?>
							<br/>
							<br/>
							<span>Completed Information</span>
							<br/>
							<?php if (count($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus)>5) {  ?>
								AddressLine1: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[5]->TabValue); ?><br/>
								AddressLine2: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[6]->TabValue); ?><br/>
								City: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[4]->TabValue); ?><br/>
								State: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[3]->TabValue); ?><br/>
								Zip: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[2]->TabValue); ?><br/>
								Phone: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[1]->TabValue); ?><br/>
								E-mail: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[0]->TabValue); ?><br/>
							<?php } ?>
							<?php if (count($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus)<=5) {  ?>
								Name: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[3]->TabValue); ?><br/>
								Phone: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[1]->TabValue); ?><br/>
								E-mail: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[0]->TabValue); ?><br/>
								Amount: <?php  echo($RequestStatusResponse->RequestStatusResult->RecipientStatuses->RecipientStatus[0]->TabStatuses->TabStatus[2]->TabValue); ?><br/>
							<?php } ?>
							<br/>

						</div>
	
                   <div style="margin-left: 230px;">
                       <a href="viewPDF.php?EnvelopeID=<?php echo $_SESSION["EnvelopeID"]?>" target="viewpdf"><input type="submit" value="ViewPDF" /></a>
                       <br />
                   </div>
<!--                   <div style="margin-left: 230px;">
                       <a href="viewDocuments.php?EnvelopeID=<?php echo $_SESSION["EnvelopeID"]?>" target="viewdocs"><input type="submit" value="View Documents" /></a>
                       <br />
                   </div>
-->                </div>

	<?php include("include/standardfooter.php"); ?>
  </body>
</html>
<?php
    
    unset($_SESSION["AddressLine1"]);
    unset($_SESSION["AddressLine2"]);
    unset($_SESSION["City"]);
    unset($_SESSION["State"]);
    unset($_SESSION["Zip"]);
    unset($_SESSION["HomePhone"]);
    unset($_SESSION["Email"]);
    unset($_SESSION["Amount"]);
?>

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
include("api/api.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Fill out an application - Contact - DocuSign, Inc. ESIGN Sample</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"></link>
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/webservice-status.js"></script>
    <script language="javascript" type="text/javascript" src="js/validation.js"></script>
    <script language="javascript" type="text/javascript">
    <!-- 
    function checkForm() {
        var why = "";

        var signForm = document.getElementById("signForm");
        
        why += isEmpty(signForm.FirstName.value, "FirstName");
        why += isEmpty(signForm.LastName.value, "LastName");
        why += checkPhone(signForm.Phone.value, "Phone");
        why += checkFloat(signForm.Amount.value, "Amount");
        why += checkEmail(signForm.Email.value, "Email" );
                
        document.getElementById("formErrorText").innerHTML = why; 
        
        if (why != "") {
            return false;
        } else {
            return true;
        }
    }
    // -->
    </script>
  </head>
  <body>
 <?php include("include/standardheader.php"); ?>
              <div class="content-section">
	            <form action="formhandler.php" id="signForm" method="post" onsubmit="return checkForm();">
                <div id="formErrorText" class="red"></div>
                <table style="width: 420px;">
                  <tbody>
                    <tr>
                      <td colspan="2"><strong>Loan Information:</strong></td>
                    </tr>
                    <tr>
                      <td>Desired loan amount:</td>
                      <td><input type="text" class="form" name="Amount" /></td>
                    </tr>
<!--
                   <tr>
                      <td>If refinance, why:</td>
                      <td>
                        <select class="form" name="LoanPdf">
                          <option selected>Loan 1</option>
                          <option selected>Loan 2</option>
                        </select>
                      </td>
                    </tr>
-->
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                      <td colspan="2"><strong>Contact Information:</strong></td>
                    </tr>
                    <tr>
                      <td>First Name:</td>
                      <td><input type="text" class="form" style="width: 150px;" name="FirstName" /></td>
                    </tr>
                    <tr>
                      <td>Last Name:</td>
                      <td><input type="text" class="form" style="width: 150px;" name="LastName" /></td>
                    </tr>
                    <tr>
                      <td>Enter your e-mail address:</td>
                      <td><input type="text" class="form" style="width: 150px;" name="Email" /></td>
                    </tr>
                    <tr>
                      <td>Your phone number here:</td>
                      <td><input type="text" class="form" style="width: 150px;" name="Phone" /></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>

                      <td colspan="2" align="right"><input type="image" src="images/send.jpg" style="border: 0px; margin-right: 52px;" /></td>
                    </tr>
                  </tbody>
                </table>
						<input type="hidden" name="formid" id="formid" value="form2">

	            </form>
              </div>
<?php include("include/standardfooter.php"); ?>
  </body>
</html>
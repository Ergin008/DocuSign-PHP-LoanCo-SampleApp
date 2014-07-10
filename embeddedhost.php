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

if(!isset($_SESSION["EmbeddedToken"])){
	$_SESSION["errorMessage"] = "No Embedded Token found";
	header("Location: error.php");
	die();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
    <title>DocuSign, Inc. ESIGN Sample</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"></link>

  </head>
  <body>
		<div id="header">
			<div class="logo">&nbsp;</div>
			<div class="logorepeat">&nbsp;</div>
		</div>
		<div id="content">
         <iframe src="<?php echo($_SESSION["EmbeddedToken"]) ?>" scrolling="yes" width="100%" height="800" frameborder="0">
		</div>
      <div id="footer">&nbsp;</div>
    </div>
  </body>
</html>

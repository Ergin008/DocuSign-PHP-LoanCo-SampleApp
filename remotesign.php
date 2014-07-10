<?php
include("include/session.php");

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
  </head>
  <body>
 <?php include("include/standardheader.php"); ?>
                <div class="content-section">
					<p>The Envelope has been sent. Please check your email inbox for an invitation to sign from DocuSign.</p>
					<p><a href="index.php">Back to Start</a>
                </div>
 <?php include("include/standardfooter.php"); ?>
  </body>
</html>
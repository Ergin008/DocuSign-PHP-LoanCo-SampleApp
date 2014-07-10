<?php
include("include/session.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){  
	// update session from post
	$_SESSION["Authentication"] = $_POST["Authentication"];
	$_SESSION["SigningLocation"] = $_POST["SigningLocation"];
	
	if(isset($_POST["AccessCode"]) && strlen($_POST["AccessCode"])>0){
		$_SESSION["AccessCode"] = $_POST["AccessCode"];
	} else {
		if(isset($_SESSION["AccessCode"])) {
			unset($_SESSION["AccessCode"]); 
		}
	}
	header("Location: index.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Mortgage Tools - DocuSign, Inc. ESIGN Sample</title>
  <script language="javascript" type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
  <script language="javascript" type="text/javascript" src="js/webservice-status.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css"></link>

  </head>
  <body>
 <?php include("include/standardheader.php"); ?> 
           <div class="content-section" style="line-height: 12px;">
					            <form action="demooptions.php" id="optionsform" method="post">
				                <div id="formErrorText" class="red"></div>
				                <table style="width: 420px;">
				                  <tbody>
				                    <tr>
				                      <td colspan="2"><strong>Demo Options:</strong></td>
				                    </tr>
				                    <tr>
				                      <td valign="top">Signing Location?</td>
				                      <td>
													<input type="radio" class="form" name="SigningLocation" value="Embedded" <?php if($_SESSION["SigningLocation"]=="Embedded") echo("checked"); ?>>Embedded</input><br/>
													<input type="radio" class="form" name="SigningLocation" value="Remote" <?php if($_SESSION["SigningLocation"]=="Remote") echo("checked"); ?>>Remote</input><br/>
												</td>
				                    </tr>
				                    <tr>
				                      <td colspan="2">&nbsp;</td>
				                    </tr>
				                    <tr>
				                      <td  valign="top">Extra Authentication?</td>
				                      <td>
													<input type="radio" class="form" name="Authentication" value="None" <?php if($_SESSION["Authentication"]=="None") echo("checked"); ?>>None</input><br/>
													<input type="radio" class="form" name="Authentication" value="IDLookup" <?php if($_SESSION["Authentication"]=="IDLookup") echo("checked"); ?>>IDLookup</input><br/>
													<input type="radio" class="form" name="Authentication" value="Phone" <?php if($_SESSION["Authentication"]=="Phone") echo("checked"); ?>>Phone</input><br/>
				                    </tr>
				                    <tr>
				                      <td colspan="2">&nbsp;</td>
				                    </tr>
				                    <tr>
				                     <td>Access Code<br/>
											</td>
				                      <td><input type="text" class="form" id="AccessCode" name="AccessCode" value="<?php  if(isset($_SESSION["AccessCode"])) {echo $_SESSION["AccessCode"];} ?>">
											</td>
				                    </tr>
				                    <tr><td>&nbsp;</td></tr>
				                    <tr>
												<td colspan="2" align="right">
												<input type="submit" id="submit" style="border: 0px; margin-right: 52px;" onclick="return validate();" value="Save Options"/></td>
				                    </tr>
				                  </tbody>
				                </table>
					            </form>
            </div>
<?php include("include/standardfooter.php"); ?>

</body>
</html>

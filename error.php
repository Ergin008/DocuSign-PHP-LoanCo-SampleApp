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
	// grab error message from session
	if(isset($_SESSION["errorMessage"])) {
		$error= $_SESSION["errorMessage"];
		unset($_SESSION["errorMessage"]);
	} else {
		$error = "Session Error Message not set";
	}  
	$demoTitle = "Error";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>


<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Mortgage Tools - DocuSign, Inc. ESIGN Sample</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head><body>
<form style="margin: 0pt; padding: 0pt;" action="" id="form">
<table style="height: 100%;" border="0" cellpadding="0" cellspacing="0" width="766">
    <tbody><tr>
        <td valign="top">
        <table style="height: 100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td height="706" valign="top">
                <table style="height: 100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td style="background: transparent url(images/bbg1.jpg) repeat-y scroll left top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; height: 277px;" valign="top">
									<table width="749" height="277" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td rowspan="3">
												<img src="images/header/index_01.jpg" width="230" height="123" alt=""></td>
											<td colspan="2" width="519" height="48"></td>
										</tr>
										<tr>
											<td width="297" height="32"></td>
											<td>
									        	<table width="222" height="32" border="0" cellpadding="0" cellspacing="0">
									                <tr>
									                    <td>
									                        <a href="index.php"><img src="images/header/menu_top_01.jpg" border="0" onMouseOver="this.src='images/header/menu_top_01_on.jpg'" onMouseOut="this.src='images/header/menu_top_01.jpg'" width="58" height="32" alt=""></a></td>
									                    <td>
									                        <a href="#"><img src="images/header/menu_top_02.jpg" border="0" onMouseOver="this.src='images/header/menu_top_02_on.jpg'" onMouseOut="this.src='images/header/menu_top_02.jpg'" width="84" height="32" alt=""></a></td>
									                    <td>
									                        <a href="#"><img src="images/header/menu_top_03.jpg" border="0" onMouseOver="this.src='images/header/menu_top_03_on.jpg'" onMouseOut="this.src='images/header/menu_top_03.jpg'" width="80" height="32" alt=""></a></td>
									                </tr>
									            </table>
									        </td>
										</tr>
										<tr>
											<td colspan="2">
												<img src="images/header/index_05.gif" width="519" height="43" alt=""></td>
										</tr>
										<tr>
											<td>
									        	<table width="230" height="154" border="0" cellpadding="0" cellspacing="0">
									                <tr>
									                    <td rowspan="5">
									                        <img src="images/header/menu_01.jpg" width="10" height="154" alt=""></td>
									                    <td>
									                        <a href="index.php"><img src="images/header/menu_02.jpg" border="0" onMouseOver="this.src='images/header/menu_02_on.jpg'" onMouseOut="this.src='images/header/menu_02.jpg'" width="200" height="33" alt=""></a></td>
									                    <td rowspan="5">
									                        <img src="images/header/menu_03.jpg" width="20" height="154" alt=""></td>
									                </tr>
									                <tr>
									                    <td>
									                        <a href="index-1.php"><img src="images/header/menu_04.jpg" border="0" onMouseOver="this.src='images/header/menu_04_on.jpg'" onMouseOut="this.src='images/header/menu_04.jpg'" width="200" height="28" alt=""></a></td>
									                </tr>
									                <tr>
									                    <td>
									                       <a href="index-2.php"><img src="images/header/menu_05.jpg" border="0" onMouseOver="this.src='images/header/menu_05_on.jpg'" onMouseOut="this.src='images/header/menu_05.jpg'" width="200" height="28" alt=""></a></td>
									                </tr>
									                <tr>
									                    <td>
									                        <a href="index-3.php"><img src="images/header/menu_06.jpg" border="0" onMouseOver="this.src='images/header/menu_06_on.jpg'" onMouseOut="this.src='images/header/menu_06.jpg'" width="200" height="28" alt=""></a></td>
									                </tr>
									                <tr>
									                    <td>
									                        <a href="index-4.php"><img src="images/header/menu_07.jpg" border="0" onMouseOver="this.src='images/header/menu_07_on.jpg'" onMouseOut="this.src='images/header/menu_07.jpg'" width="200" height="37" alt=""></a></td>
									                </tr>
									            </table>
									        </td>
											<td colspan="2">
												<img src="images/header/index_07.jpg" width="519" height="154" alt=""></td>
										</tr>
									</table>                        </td>
                    </tr>
                    <tr>
                        <td height="100%" valign="top">
                        <table style="height: 100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td style="background-image: url(images/px.gif); height: 379px;" class="white" width="230" valign="top">
                                
                                </td>
                                <td style="height: 379px;" valign="top">
                                    <div style="margin:12px; font-size:12px">
													<h2>An Error Occurred</h2>
													<p>
														<?php echo $error; ?>
														</p>
													<p>
														<?php if(isset($_SESSION["lastRequest"])) echo(xmlpp($_SESSION["lastRequest"]));?>
													</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td height="50" valign="top">
                        <table style="height: 100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td style="background: transparent url(images/px_copy.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;" class="copy" width="736" valign="top">
                                <div style="margin: 14px 31px 0px 0px;" align="right">
                                LoanCo.com © 2006 | &nbsp; Sample Code</div>
                                </td>
                                <td width="30" valign="top"></td>
                            </tr>
                        </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                </td>
            </tr>
            <tr>
                <td height="100%" valign="top">
                <table style="height: 100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td style="background-color: rgb(125, 122, 122);" width="736" valign="top">
                        </td>
                        <td width="30" valign="top"></td>
                    </tr>
                </tbody></table>
                </td>
            </tr>
        </tbody></table>
        </td>
    </tr>
</tbody></table>
</form>
</body></html>
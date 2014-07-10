<!--
<div id="webserviceHeartbeat">
  <a href="LoanCo.log" target="_blank">
    <img src="images/script.png" style="border: 0px;" />
    <span style="font-size: 0.75em;">View LoanCo Event Log</span>
  </a>
  <br/>
  <img id="ws3_0_img" src="images/spinner.gif" />
  <span style="font-size: 0.75em;">(WS3_0 webservice)</span>
</div>
-->
<div id="webserviceHeartbeat">
	<a class="menu-label"  href="demooptions.php">Demo Options</a>
	
<?php if(isset($_SESSION["debug"]) && $_SESSION["debug"]===true) {?>
	<a class="menu-label" href="sessionlog.php" target="sessionlog">Session Log</a>
<?php } ?>	
</div>

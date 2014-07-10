
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>How it works - DocuSign, Inc. ESIGN Sample</title>
  <script language="javascript" type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
  <script language="javascript" type="text/javascript" src="js/webservice-status.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css"></link>
  </head>
  <body>
 <?php include("include/standardheader.php"); ?>
              <div class="content-section">
                  <strong>How DocuSign® Enterprise Works</strong><br />DocuSign Enterprise is a web service designed for high-volume applications. Most customers deploy Enterprise via the DocuSign Gateway API, which allows them to easily integrate online signing into their applications and web sites.
                  <div>
                  <ul>
                      <li><a href="http://www.docusign.com/products/demos/" target="_blank">Request a demo</span></li>
                      <li><a href="http://www.docusign.com/trial/" target="_blank">Free evaluation</a></li>
                  </ul>
                  </div>
                  <br />
                  The following is a typical workflow showing how DocuSign Enterprise integrates with an application:
                  <br/>
                  <ol>
                    <li>An external application generates a document that must be signed by a customer. This might be a loan document or an application for enrollment.</li>
                    <li>The document in XML format is submitted to DocuSign via the SOAP Gateway API, along with the signing instructions that are encoded into the XML. The sending application has complete control of the signing process.</li>
                    <li>The DocuSign web service executes the signing process as defined by the external application. This includes informing signers they need to sign, collecting the signatures, and responding to the sending application that the transaction is complete.</li>
                  </ol>
                  DocuSign understands that customers may require several different signature processes. Our advanced architecture enables us to support three main types of signature process:<br />
                  <ol>
                    <li>Remote Signing: The customer completes information on a web site or with a call center. An email notifies the customer that they have a document ready to sign. Following a hyperlink in the email, the customer signs online.</li>
                    <li>In-Session Signing: The customer logs on to a web site to complete a form or review a document, and clicks 'sign now.' The customer is then asked to create a DocuSign signature and to sign by clicking the familiar yellow 'sign here' and 'initial here' tabs. From the customer’s perspective, the entire experience takes place inside the web site.</li>
                    <li>High Volume Templates: The remote application sends out thousands of contracts per day. The contracts are all boilerplate, except for key fields such as name. Using the DocuSign system, the remote application sends only the dynamic data as XML, and DocuSign merges this data with the boilerplate and executes the signing.</li>
                  </ol>
                  The external application completely controls the signing process at all times through the API. The DocuSign web service operates as a secure 'black box,' processing the signing instructions per the XML definition. The DocuSign system is deployed across multiple servers in a high-availability, SAS70-compliant data center that is monitored 7x24x365 days per year. The distributed service architecture allows massive scaling for enterprise-class customers, ensuring the application will be available at all times. The signing experience can be co-branded to enhance customer confidence in the signing process <a href="http://www.docusign.com/resources/index.php" target="_blank">read more</a>
              </div>
<?php include("include/standardfooter.php"); ?>
  </body>
</html>

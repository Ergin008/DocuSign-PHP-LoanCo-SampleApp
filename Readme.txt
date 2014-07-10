PHP LoanCo Readme
===========================================================================

This project is an example of using the DocuSign webservice client in a web
application.  This example demonstrates the following:
-	envelope creation / sending 
-	signing / sending envelopes via DocuSign web interface 
-	confirmation of sign status 
-	retrieval of signed PDF

Installation
---------------------------------------------------------------------------

This sample code requires a DocuSign DevCenter account. If you do not
already have a DevCenter account please go to
http://www.docusign.com/devcenter/ and sign up for one. This sample will
not function without a valid DevCenter account.

System requirements for PHP samples:
-	PHP Version 5.3+
- 	mcrypt/2.5.7 libcurl/7.19.4 OpenSSL/0.9.8k zlib/1.2.3 

Sample PHP LoanCo solution instructions
---------------------------------------------------------------------------

The IntegratorsKey MUST be set in the api/Credentials.php file for authentication
to succeed. The other values can be entered as part of the online login or in the
Credentials file.

Recursively copy all files to your server and execute the index.php file to
begin.

<?php 
$dbhost = 'localhost'; 
$dbuser = 'root'; 
$dbpass = 'password'; 
$dbname = 'dbName'; 

$today = date("m\/d\/Y");  // todays system date
$date_ = mktime(0, 0, 0, date("m"), date("d")+1, date("Y")); // adding specific number of days to date to get reminder of subscription expiration.
$tomorrow = date("m/d/Y", $date_);  //formatting the date time according to your database format
$Renewal = (string)$tomorrow;

$ordernumber="";
$conn = mysql_connect($dbhost, $dbuser, $dbpass); 
if(!$conn) { 
die('Failed to connect to server: ' . mysql_error()); 
} 
mysql_select_db($dbname); 
$sql="SELECT * FROM users WHERE subscription = true"; 
$result = mysql_query($sql); 

$email = "from@domain.com"; 
$emailto = "to@domain.com"; 
$emailcc = "cc@domain.com"; 
$emailcc = "";
$subject = "Customer Subscription information"; 
$headers = "From: $email" . "\r\n" . "CC: $emailcc"; 

while($row=mysql_fetch_array($result)) { 
$body .= " \n "
."Following are the people whoes subscription will expire tomorrow"." \n "." \n "
."First Name : ".$row['FirstName']." \n "
."Last Name : ".$row['LastName'] ." \n "
."Email : ".$row['Email'] ." \n "
."Address : ".$row['Address'] ." \n "
."Country : ".$row['Country'] ." \n "
."Phone No. : ".$row['PhoneNo'] ." \n "
."Product : ".$row['Product'] ." \n "
."Version : ".$row['Version'] ." \n "
."Renwal Date : ".$row['Renewal']. "\n"
."\n". "\n". "==============================". "\n"; 
} 

// send email 
if(mysql_num_rows($result) > 0)
{
$send = mail($emailto, $subject . ' ' . $ordernumber, $body, $headers); 
}
mysql_close($conn); 
?>
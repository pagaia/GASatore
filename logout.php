<?php
// you have to open the session to be able to modify or remove it 
 session_start(); 

 // this would destroy the session variables 
 session_destroy(); 
 
 header ('location: login.php'); exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thank you</title>
</head>

<body>
 <div style="width:500px; margin:auto; text-align:center"> You are not logged. Go to <a href='index.php'>login</a> page.</div>
</body>
</html>

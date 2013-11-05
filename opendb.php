<?php
// This is an example opendb.php
$conn = mysql_connect(MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD) or die ('Error connecting to mysql');
mysql_select_db(MYSQL_DATABASE);
?>

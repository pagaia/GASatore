<?php

/*  Author : Christopher M. Natan 
    MySQL connection
*/

class Db  {
  function connect() {
       $connect      = mysql_connect(MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD);
	   $select_db    = mysql_select_db (MYSQL_DATABASE, $connect); 
		if (!$connect) {
		   $errno  = mysql_errno();
		   switch($errno) {
		      case 1045 : { $this->error(); break; }
		    }
		}
		elseif(!$select_db) {$this->error(); break;}
		$strSQL = "SELECT * from ".USERS_TABLE_NAME." limit 1";
        $result = mysql_query ($strSQL); 
		if($result==null) {
		   $this->create_table();
		   die();
		}
   }
   function error() {
        echo "<div style='width:350;margin:auto;text-align:center;font-family:Arial'>
			     <span style='font-size:15px;color:red'>MYSQL SERVER ERROR : ".mysql_error()."</span> 	
			  </div>";
		echo "<div style='width:350;margin:auto;text-align:center;margin-top:10px;font-family:Arial'>
				 You must edit first the <b>config.php</b> file and input your correct MySQL account, that file 
				 is located under this <b>login</b> folder.
				 <p>Note: if database TABLE doesn't exist Ajax Login Module will automatically create one.</p>
				 <p>After done editing refresh this page</p>.
			  </div>";	  
	    die();
   }
   function create_table() {
      $strSQL = " CREATE TABLE `".USERS_TABLE_NAME."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `username` varchar(200) NOT NULL DEFAULT '',
					  `password` varchar(200) DEFAULT NULL,
					   PRIMARY KEY (`id`)
				   )   ENGINE=MyISAM DEFAULT CHARSET=utf8;
	            ";
      $result = mysql_query ($strSQL); 
	  $strSQL = "INSERT INTO `".USERS_TABLE_NAME."` (`id`,`username`,`password`) VALUES (1,'admin','admin');";
	  $result = mysql_query ($strSQL); 
	  echo ('<meta http-equiv="refresh" content="0;">');
   }
	 
	  
 }  
?>  
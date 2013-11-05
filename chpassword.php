<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Change password</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
</head>

<body>
<div>
<?php 
#print_r ( $_SESSION);
#print_r($_POST);
#
?>
</div>
<?php
require 'opendb.php';
require 'functions.php';
require 'header.php';

function CreateDiv(){
echo "<div id='Content'>
  <form name='chpassword' method='post' onSubmit='return checkPwd(new_pwd, new_pwd_check);'>
    <div class='row'>
      <label for='old_pwd'>Old password:</label><span class='formw'><input type='password'  name='old_pwd'></span>
    </div>
    <div class='row'>
      <label for='new_pwd'>New password:</label><span class='formw'><input type='password' name='new_pwd'  /></span>
    </div>
    <div class='row'>
      <label for='new_pwd_check'>New password (confirm):</label><span class='formw'><input type='password' name='new_pwd_check' /></span>
    </div>
  <div class='spacer'>
  &nbsp;
  </div>
<input type='reset' value='Cancel' />
        <input type='submit' name='chpassword' value='Submit' />
 </form>


</div>";

}

if( isset($_POST["chpassword"]) && isset($_POST['new_pwd'])){
	
	$old_pwd = $_POST["old_pwd"];
	$new_pwd = $_POST["new_pwd"];
	$userId = $_SESSION['user_id'];
	
	if($new_pwd != "" && $userId != ""){
		$sql = "SELECT * FROM user where id=$userId and password='$old_pwd'";
		$result = mysql_query($sql,$conn);
		if (!$result){
                          die('Error: ' . mysql_error());
                }
		$num_rows = mysql_num_rows($result);
		if($num_rows == 1){
			$sql = "UPDATE user SET password='$new_pwd' where id=$userId";
                	echo "<div id='Content'> ";
			if (!mysql_query($sql,$conn)){
                		echo "<div class='Error'> Some error occurs during the change password process.</div>";
			}else{
                		echo " <h2> Your password has been changed. </h2> ";
			}
                	echo "</div>";
				
		}else{
			echo "<div class='Error'> Your old password is not correct. Please try again.</div>";
			CreateDiv();
		}
	}else{
        	echo "<div class='Error'> Some error occurs during the change passowrd process.</div>";
	}
	
}else{

CreateDiv();

}

require 'closedb.php';
include 'footer.php';
?> 




</body>
</html>

<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Sudo User</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
</head>

<body>
<?php
require 'opendb.php';
require 'functions.php';
require 'header.php';

## if not ADMINISTRATOR nothing will be shown..
if(!isAdmin($conn, $_SESSION['user_id'])){
        echo "<div id='Content'> ";
        echo "<h2>You don't have the right to see this page.</h2>";
        echo "</div> ";
}else{

		echo "<div id='Content'> ";
	
	 	echo "<form name='sudoUser' method='post' action='welcome.php' >";
		$userList = getUsersByProject($_SESSION['project_id'], $conn);
	        echo '<label for="user_list">Select a user</label> <select name="user_list" onchange="this.form.submit();">';
	        echo '<option value="-1">Select </option>';
		
		$count = count($userList);
                for ($i = 0; $i < $count; $i++) {
	                echo '<option value="'.$userList[$i]['id'].'">'.$userList[$i]['name'].' '. $userList[$i]['surname'].'	('.$userList[$i]['company'].')</option>\n';
                }

	        echo '</select>';
	        echo '</form>';
	        echo "<br>";
	        echo "</div> ";

}	


require 'closedb.php';
include 'footer.php';
?>

</body>
</html>

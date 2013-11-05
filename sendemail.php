<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Send REMINDER</title>\n"; ?>
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
        echo "<h2>You don't have the right to see these information</h2>";
	echo "</div> ";
}else{

	if( isset($_POST["sendEmail"]) && isset($_POST["template"]) && isset($_POST["subject"]) && isset($_POST['from']) && isset($_POST['userid']) ){
	
	   	$usersId=""; 
	    	foreach ( $_POST['userid'] as $k=> $c){$usersId .= $c .", ";  }
	 	if($usersId != ""){$usersId = substr($usersId, 0, strlen($usersId) -2);}

		$sql = "select name, surname, username, password, email 
		from user join project_user_lk as p on p.user_id=user.id WHERE p.project_id=".$_SESSION['project_id'] . " and id in ($usersId )" ;
			
		$result = mysql_query($sql);
	
	 	echo "<div id='Content'> ";
		echo "<p>The following emails have been just sent </p>";
		$count=1;
		$from=$_POST['from'];
	        while($row = mysql_fetch_array($result)){
			$email = $_POST["template"];
			$email = str_replace("#NAME#", $row['name'], $email);
			$email = str_replace("#SURNAME#", $row['surname'], $email);
			$email = str_replace("#USERNAME#", $row['username'], $email);
			$email = str_replace("#PASSWORD#", $row['password'], $email);
	
			$to      = $row['email'];
			$subject = $_POST["subject"];
			$headers = "From: $from" . "\r\n" . "Reply-To: $from" . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	
			mail($to, $subject, $email, $headers);
			echo "Email: $count ";
			echo "<pre>";
			echo "To: $to\n";
			echo "Subject: $subject \n";
			echo "$headers\n";
			echo "$email";
			echo "</pre>";
	
			$count++;
	        }
	        echo "</div>";
	
	
	
		
	}else{
		
		echo "<div id='Content'>";
		
		echo "<p> This is a template wich will be sent to all users of the Project selected. Please insert the following placeholder which will be replaced by the real value extracted by the database, and select at least one user: 
	<ul>
	<li>#NAME#</li> 
	<li>#SURNAME#</li> 
	<li>#USERNAME# </li>
	<li>#PASSWORD#</li>
	</ul>
	</p>";
		echo "<form name='sendReminder' method='post' onSubmit='return validate();'>\n";

 		echo "<table><tr><th><input type='checkbox' name='userAll' value='Select all' onclick='javascript:selectAll(this, \"userid[]\");'/></th><th>User</th><th>Email</th><th>Company</th></tr>\n";
                $listUsers = getUsersByProject($_SESSION['project_id'], $conn);

                $count = count($listUsers);
                for ($i = 0; $i < $count; $i++) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='userid[]' value='".$listUsers[$i]['id']."' /></td>";
                        echo "<td>".$listUsers[$i]['name']." ".$listUsers[$i]['surname']." </td>";
                        echo "<td>".$listUsers[$i]['email']."</td>";
                        echo "<td>".$listUsers[$i]['company']."</td>";
                        echo "</tr>";
                }
                echo "</table> <br/><br/>";

		echo "<div class='row'><label for='from'>From: </label><input name='from' type='text' class='email'></div>";
		echo "<div class='row'><label for='subject'>Subject: </label><input name='subject' type='text' class='email' ></div>";
		echo "<div class='row'>";
		echo '<label for="template">Email: </label>
	<textarea name="template" rows="10" cols="80" >Dear partner,

In the context of the GEOWOW project we have to monitor  the partners effort
utilisation during the months.

To this scope we built up a specific tool to monthly collect such infomation
from you.

We ask you to monthly fill-up the form indicating the hours spent in that
month from your personnel (as a whole) for each workpackage.

The usage of the tool is rather simple, you have to:

1.  login at the following address:

http://car2.esrin.esa.int/effort/index.php

with the following information:

username=#USERNAME#
password=#PASSWORD#

2. once you are logged inside the system you have to select GEOWOW project
and then press Submit button.

3.  On the next page you will have to select "Monthly Report" on the left menu

4. As the form with the workpackages appears you have to select the correct
month and then fill in the boxes with the corresponding effort hours.

5. At the end please press submit button


Please   insert  effort  values  for  September  and  October 2011 until next
monday 21st November.



I  thank  you  a  lot  for  your  support and remain at your disposal for any
further clarification.



Best regards,



Alessandro

	</textarea>';	
		echo "</div>";
	
		echo "<br><br>
		<input type='submit' name='sendEmail' value='Submit' />";
		echo "</form>";
		echo "</div>";
	} 
	
}



require 'closedb.php';


?> 

<?php
include 'footer.php';
?>



</body>
</html>

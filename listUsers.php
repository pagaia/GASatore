<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Users list</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
</head>

<body>
<?php
require 'header.php';
$connectedUser = new User($db, $log, $_SESSION['user_id']);
## if not ADMINISTRATOR nothing will be shown..
//if(  isAdmin($conn, $_SESSION['user_id'])){
if(  !$connectedUser->isAdmin()){
	echo "<div id='Content'> ";
        echo "<h2>Non hai diritti per accedere a queste informazioni.</h2>";
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
	
		echo "<div><form name='addUser' method='post' action='useradd.php'>\n";
		echo "<input type=submit name='new' value='Inserisci nuovo gaabista'/>";
		echo "</form></div>";	
		
		echo "<br><br>\n";
		echo "<p> Qui di seguito tutti i gaabisti presenti in anagrafica </p>\n";

 		echo "<table><tr><th><input type='checkbox' name='userAll' value='Select all' onclick='javascript:selectAll(this, \"userid[]\");'/></th>
		<th>Gaabista</th><th>Email</th><th>stato</th>
		<th>Tel</th><th>Mobile</th><th>Email2</th><th>Address</th><th>Tessera</th><th>Fee</th><th>Donazine</th><th>Data iscrizione</th>
		</tr>\n";
		$listUsers =  User::listUser($db, $log);
#                $listUsers = getUsersByProject($_SESSION['project_id'], $conn);

                $count = count($listUsers);
                for ($i = 0; $i < $count; $i++) {
			$myU = $listUsers[$i];
                        echo "<tr ".( ($i % 2 == 0)?"class='even'":"" ).">\n";
                        echo "<td><input type='checkbox' name='userid[]' value='".$myU->id."' /></td>";
                        echo "<td>".$myU->name." ".$myU->surname." </td>";
                        echo "<td><a href='user.php?uId=".$myU->id."' >".$myU->email."</a></td>";
                        echo "<td>".$myU->status->status."</td>";
                        echo "<td>".$myU->tel."</td>";
                        echo "<td>".$myU->mobile."</td>";
                        echo "<td>".$myU->email2."</td>";
                        echo "<td>".$myU->address."</td>";
                        echo "<td>".$myU->tesseraCasale."</td>";
                        echo "<td>".$myU->entrance_fee."</td>";
                        echo "<td>".$myU->donation->type."</td>";
                        echo "<td>".$myU->subscription_date."</td>";
                        echo "</tr>";
                }
                echo "</table> <br/><br/>";

		echo "</div>";
	} 
	
}


?> 

<?php
include 'footer.php';
?>



</body>
</html>

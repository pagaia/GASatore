<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - User add</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
 <script type='text/javascript' src='files/jquery-1.3.2.min.js'></script> 
<!-- <script type='text/javascript' src='files/jquery-1.10.2.js'></script> -->
<script type='text/javascript' src='files/script.js'></script>
</head>

<body>
<?php
#require 'functions.php';
require 'header.php';

echo "<div id='test'></div>";
echo "<div id='Content'> ";


// Aggiungi un nuovo utente e mostra le sue informazioni

	$user = new User($db, $log, $_GET['uId']);
	if($user->username){	
		echo "<div class='row'><label for='username'>Username:</label><span>".$user->username."</span></div>\n";
	 	echo "<div class='row'><label for='name'>Name:</label><span class='formw'>".$user->name."</span></div>\n";
	 	echo "<div class='row'><label for='surname'>Surname:</label><span class='formw'>".$user->surname."</span></div>\n";
	 	echo "<div class='row'><label for='email'>Email:</label><span class='formw'>".$user->email."</span></div>\n";
	 	echo "<div class='row'><label for='email2'>Email2:</label><span class='formw'>".$user->email2."</span></div>\n";
	 	echo "<div class='row'><label for='tel'>Telefono:</label><span class='formw'>".$user->tel."</span></div>\n";
	 	echo "<div class='row'><label for='mobile'>Mobile:</label><span class='formw'>".$user->mobile."</span></div>\n";
	 	echo "<div class='row'><label for='status'>Status:</label><span class='formw'>".$user->status->status."</span></div>\n";
	
	 	echo "<div class='row'><label for='tessera'>Tessera:</label><span class='formw'>".$user->tesseraCasale."</span></div>\n";
	 	echo "<div class='row'><label for='quota_ingresso'>Quota ingresso:</label><span class='formw'>".$user->entrance_fee."</span></div>\n";
	 	echo "<div class='row'><label for='date_subscription'>Data iscrizione:</label><span class='formw'>".$user->subscription_date."</span></div>\n";
	
		echo "";
	
	 	echo "<br><br>\n";
		echo "<form action='useredit.php' method='post'>\n";
		echo"        <input type='hidden' name='uId' value='".$_GET['uId']."' />\n";
		echo"        <input type='submit' name='edit' value='Modifica' />\n";
		echo"        <input type='submit' name='disable' value='Disabilita' />\n";
	        echo "</form>";
	}else{
		echo "<h2> Impossibile recuperare le informazioni richieste. Riprova </h2>";
	}

echo "</div>";



	

require 'closedb.php';

include 'footer.php';
?>

</body>
</html>

<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Welcome</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
</head>

<body>

<?php
//require 'opendb.php';
//require 'functions.php';
// change user  
/*if( isset($_POST["user_list"]) && ($_POST['user_list'] > 0) && isAdmin($conn, $_SESSION['user_id']) ){
	setSuUser($_POST["user_list"],$_SESSION['user_id'], $conn);
}
if(isset($_GET["resetAdmin"]) && ($_SESSION['admin_id'] > 0)){
	exitSuUser($conn);
}
*/
require 'header.php';
//require 'library/classes.php';
//$user= new User($db);
//$user->loadUser(1);
//echo "Utente: ".$user->name.", surname: ".$user->surname;

echo "<div id='Content'>
<h2>Welcome! You are now logged in as <span style='color:red;'>".$_SESSION['user_name']." ". $_SESSION['user_surname'] ."</span>.<br/>
</h2>";
echo "</div>";

include 'footer.php';

echo "</body>
</html>
";
?>

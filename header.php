<?php
if(isset($_SESSION['project_name'])){
	echo "<div id='Logo'>
		<img src='files/logo/project_".$_SESSION['project_id'].".jpg' alt='Project ".$_SESSION['project_name']."' />
	</div>\n";
	echo "<div id='Header'>";
	echo "<span> <h1 style='float:left;'> ". $_SESSION['project_name'] ." effort and cost report </h1>";
	echo "<span id='userinfo'>User: <em style='color:red;'>".$_SESSION['user_name']." ". $_SESSION['user_surname']."(".$_SESSION['company_short'].")</em></span></span>";
	echo "</div>";
}else{
 	echo "<div id='Logo'></div>\n";
        echo "<div id='Header'>";
        echo "<span> <h1 style='float:left;'> ".PROJECT." </h1>";
	echo "<span id='userinfo'>User: <em style='color:red;'>".$_SESSION['user_name']." ". $_SESSION['user_surname']."</em></span></span>";
	echo "</div>";
}

if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
	echo "<div id='Error'>".$_SESSION['error']."</div>\n";
	unset($_SESSION['error']);
}else{
	echo "<div id='Error'></div>\n";

}

echo "<div id='Menu'>
        <ul>\n";
	
	echo "<li><a href='listUsers.php'>Gaabisti</a></li>\n";
	echo "<li><a href='listCategories.php'>Categorie prodotti</a></li>\n";
	echo "<li><a href='listProducts.php'>Prodotti</a></li>\n";
	echo "<li><a href='bookingadd.php'>Nuova Prenotazione</a></li>\n";
	echo "<li><a href='listBookings.php'>Prenotazioni</a></li>\n";
//	if(isset($_SESSION['project_name'])){
		echo "<li><a href='chpassword.php'>Change Password</a></li>\n";
	 	if($_SESSION['role_id'] == 1){
	 		echo "<li><a href='logs.php'>Logs</a></li>\n";
	 		echo "<li><a href='sendemail.php'>Send Email</a></li>\n";
	 		echo "<li><a href='sudo_user.php'>Su User</a></li>\n";
		}
	
		if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
	     		echo "<li><a href='welcome.php?resetAdmin=1'>Exit from current User</a></li>\n";
		}	
//	}
	     echo "<li><a href='help.php'>Help</a></li>\n<li><a href='logout.php'>Logout</a></li>
	 </ul>
</div>\n";

?>


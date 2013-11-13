<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Bookings list</title>\n"; ?>
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

		setlocale(LC_ALL, 'it_IT');
	
		$listProducts = Product::listProducts($db, $log);
		$listBooking  = userBooking::listBookings($db, $log);
		echo "<div id='Content'>";
		echo "<pre>";
		
		$bookingArray = array();
		foreach($listBooking as $uB){
			$singleUserB = array();
			$singleUserB['user_id'] = $uB->user->id;
			$singleUserB['user_name'] = $uB->user->name;
			$singleUserB['user_surname'] = $uB->user->surname;
			foreach ($uB->booking_list as $booking){
				if(!$singleUserB['bookingday']){
					$singleUserB['bookingday'] = $booking->booking_date_id->day;
				}
 				if(!$singleUserB['pickupday']){ 
                                        $singleUserB['pickupday'] = $booking->pickup_date_id->day;
                                }

				$singleUserB["id_".$booking->product_id->id] = $booking->quantity;
				$singleUserB["unitprice_".$booking->product_id->id] = $booking->product_id->unitprice;
				$singleUserB["price_".$booking->product_id->id] = $booking->tot_price;
			}	
			$singleUserB['total'] = $uB->totalCost;

				
			$bookingArray[] = $singleUserB; 
		}
		echo "</pre>";
		echo "<p> Qui di seguito tutte le prenotazioni dei gaabisti</p>\n";
                echo "<table>";
                echo "<tr><th class='vtext'>Booking</th><th class='vtext'>Gaabista</th><th class='vtext'>pickup</th>";
                foreach($listProducts as $p){
                        echo "<th class='ncol'>$p->name ".($p->price>0? "($p->price &euro;)":"")."</th>";
                }
		echo "<th class='vtext'>costo totale</th>";
                echo "</tr>\n";

                $count = 0;
		foreach($bookingArray as $v){
			echo "<tr ".( ($count++ % 2 == 0)?"class='even'":"" ).">\n";
			echo "<td> ".strftime("%a %d %b %g", strtotime($v['bookingday']))."</td>";
			echo "<td style='text-align:left;'> <a href='user.php?uId=".$v['user_id']."'>" .$v['user_surname']." ".$v['user_name']."</a></td>";
			echo "<td> ".strftime("%a %d %b %g", strtotime($v['pickupday']))."</td>";
 			foreach($listProducts as $p){
				switch($v["id_".$p->id]){
				case "1":
				{echo "<td >" .$v["id_".$p->id]."</td>";}
				break;
				case "0":
				{echo "<td >" .$v["price_".$p->id]."&euro;</td>";}
				break;
				default:
				echo "<td ></td>";
				}
		
			}
			echo "<td> ". number_format ($v['total'], 2)." &euro;</td>";
			echo "</tr>\n";
		
		}
		echo "</table>";
	
		echo "</div>";
	} 
	
}


?> 

<?php
include 'footer.php';
?>



</body>
</html>

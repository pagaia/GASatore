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
		//$log->LogDebug($listProducts);
		$listaPrenotazioni  = bookingList::listBookings($db, $log);
		echo "<div id='Content'>";
		
		$bookingArray = array();
		foreach($listaPrenotazioni as $uB){
			$singleUserB = array();
			$singleUserB['uBid'] = $uB->id;
			$singleUserB['user_id'] = $uB->user->id;
			$singleUserB['user_name'] = $uB->user->name;
			$singleUserB['user_surname'] = $uB->user->surname;
			$singleUserB['bookingday'] = $uB->booking_date_id->day;
			$singleUserB['pickupday'] = $uB->pickup_date_id->day;
			$singleUserB['owed'] = $uB->owed;
			$singleUserB['paied'] = $uB->paied;
			$singleUserB['changeback'] = $uB->changeback;
			$singleUserB['total_cache'] = $uB->total_cache;
			$singleUserB['debit'] = $uB->debit_credit;
		
			$num_book = count($uB->listBooking);	
			foreach ($uB->listBooking as $k => $myb){
				$singleUserB["p_".$myb->product_id->id] = $myb->quantity;
				$singleUserB["unitprice_".$myb->product_id->id] = $myb->product_id->unitprice;
				$singleUserB["price_".$myb->product_id->id] = $myb->tot_price;
			}	

				
			$bookingArray[] = $singleUserB; 
			$log->LogDebug($singleUserB);
				
		}
		echo "<p> Qui di seguito tutte le prenotazioni dei gaabisti</p>\n";
                echo "<table>";
                echo "<tr><th>Mod</th><th class='vtext'>BookingDate</th><th class='vtext'>Gaabista</th><th class='vtext'>PickupDate</th>";
                foreach($listProducts as $p){
                        echo "<th class='ncol'>$p->name ".($p->unitprice==1? "($p->price &euro;)":"")."</th>";
                }
		echo "<th class='vtext'>dovuto</th>";
		echo "<th class='vtext'>pagato</th>";
		echo "<th class='vtext'>Resto</th>";
		echo "<th class='vtext'>Totale Cassa</th>";
		echo "<th class='vtext'>debito/credito</th>";
                echo "</tr>\n";

                $count = 0;
		foreach($bookingArray as $v){
			echo "<tr ".( ($count++ % 2 == 0)?"class='even'":"" ).">\n";
			echo "<td><a href='bookingedit.php?id=".$v['uBid']."'>Edit</a> </td>";
			echo "<td> ".strftime("%a %d %b %g", strtotime($v['bookingday']))."</td>";
			echo "<td style='text-align:left;'> <a href='user.php?uId=".$v['user_id']."'>" .$v['user_surname']." ".$v['user_name']."</a></td>";
			echo "<td> ".strftime("%a %d %b %g", strtotime($v['pickupday']))."</td>";
 			foreach($listProducts as $p){
				$key = 'unitprice_'.$p->id;
				switch($v["$key"]){
				case "1":
				{echo "<td >" .$v["p_".$p->id]."</td>";}
				break;
				case "0":
				{echo "<td >" .$v["price_".$p->id]."&euro;</td>";}
				break;
				default:
				echo "<td></td>";
				}
		
			}

			echo "<td> ". number_format ($v['owed'], 2)." &euro;</td>";
			echo "<td> ". number_format ($v['paied'], 2)." &euro;</td>";
			echo "<td> ". number_format ($v['changeback'], 2)." &euro;</td>";
			echo "<td> ". number_format ($v['total_cache'], 2)." &euro;</td>";
			echo "<td> ". number_format ($v['debit'], 2)." &euro;</td>";
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

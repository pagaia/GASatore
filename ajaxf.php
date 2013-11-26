<?php
require 'session.php';

switch($_GET['element']){

	case ("username"):
	if(User::usernameAlreadyUsed($db, $log, $_GET['value'])){
		echo "Username già utilizzato. Sceglierne un altro.";
	}else{ echo "OK";}
	break;

	case "email":
	case "email2":
	if(User::emailAlreadyUsed($db, $log, $_GET['value']) ){
		echo "Email già utilizzata. L'utente potrebbe già esistere.";
	}elseif(!filter_var($_GET['value'], FILTER_VALIDATE_EMAIL)) {
		echo "Email non valida. Controllare";
	}else{ echo "OK";}
	break;


   	case "category":
        if(productCategory::categoryAlreadyExists($db, $log, $_GET['value']) ){
                echo "Categoria già esistente!";
        }else{ echo "OK";}
        break;

	case "donationpaied":
        $donation_amount = User::getDonationbyUserId($db, $log, $_GET['value']);
	echo json_encode($donation_amount);
	break;
	
	default:
	echo "Error on parameters";
	break;
}
?>

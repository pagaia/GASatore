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
	$dPaied = new donationPaied($db, $log, null, $_GET['value']);	
	echo json_encode($dPaied);
	break;
	
	default:
	echo "Error on parameters";
	break;
}
?>

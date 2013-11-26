<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - User edit</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
 <script type='text/javascript' src='files/jquery-1.3.2.min.js'></script> 
<!-- <script type='text/javascript' src='files/jquery-1.10.2.js'></script> -->

<script type='text/javascript' src='files/script.js'></script>
<script type="text/javascript">

	var error=new Array();
	function checkValue(el,warning){
                                el.change(function( objEvent ){
                                                // Clear status list.
                                                $( "#ajax-status" ).empty();
                                                // Launch AJAX request.
                                                $.ajax( {
                                                                // The link we are accessing.
                                                                url:  "ajaxf.php?element="+this.id+"&value="+this.value,
                                                                // The type of request.
                                                                type: "get",
                                                                // The type of data that is getting returned.
                                                                dataType: "html",
                                                                error: function(){   warning.html( "<p>Error on check value</p>" ); },
//                                                                beforeSend: function(){       ShowStatus( "AJAX - beforeSend()" );     },
  //                                                              complete: function(){ ShowStatus( "AJAX - complete()" );            },
                                                                success: function( strData ){
                                                                        // Load the content in to the page.
                                                                        warning.html( strData );
									if(strData != 'OK'){ error[element]=1;}
									else{ error[element]=0;}
                                                                }
                                                        }                                                       
                                                        );
                                                
                                                // Prevent default click.
                                                return( false );                                        
                                        }
                                        );
                                
	}


$(function(){
	$("#Error").text("Controllare la validazione dei valori....");
	$("#Error").show();
checkValue($("#username"),$("#usernamecheck"));
checkValue($("#email"),$("#emailcheck"));
checkValue($("#email2"),$("#email2check"));
});
		

		function checkSelection(el,append){
			var error = false; 
			if(el.val() == -1){
				append.text("Selezionare un elemento");
				error[el]=1;
				error=true;
			}else{ error[el]=0; error= false;}
			return error;
		}
		
		function checkSubmit(){
			checkSelection($("#status"), $("#statusdiv"));
			checkSelection($("#donation"), $("#quotadiv"));
			for (var i = 0; i < error.length; i++){
			      if(error[i]){return false;}
			}	
			return true;
		}
	</script>
</head>

<body>
<?php
#require 'functions.php';
require 'header.php';

echo "<div id='test'></div>";
echo "<div id='Content'> ";

$user = new User($db, $log, $_POST['uId']);

if(!$user->username){
                echo "<h2>Nessun gaabista da modificare</h2>";
}elseif($_POST['edit2']){
        if($user->updateUser($_POST['name'],$_POST['surname'],$_POST['tel'],$_POST['mobile'],$_POST['email'],$_POST['email2'],$_POST['address'],$_POST['tessera'],$_POST['entrance_fee'],$_POST['status'],$_POST['donationType'],$_POST['subscription_date'])){
                        $user->loadInfo($user->id);
                        echo "<h2>Gaabista modificato! Attendi l'aggiornamento....</h2>";
                        echo "<script > 
                        setTimeout(function(){ window.location = 'user.php?uId=".$_POST['uId']."'; }, 2000);
                        </script>";


        }else{
                echo "<h2>Errore nella modifica del gaabista</h2>";
        }
}else{

        echo "<h2> Modifica il gaabista</h2>";
        echo "<form name='newUser' method='post' onsubmit='return checkSubmit();'>\n";
        echo "<div class='row'><label for='username'>Username:</label><span> <input type='text' name='username' id='username' value='".$user->username."' disabled /></span><span id='usernamecheck'></span></div>\n";
        echo "<div class='row'><label for='name'>Name:</label><span class='formw'><input type='text' name='name' value='".$user->name."'  /></span></div>\n";
        echo "<div class='row'><label for='surname'>Surname:</label><span class='formw'><input type='text' name='surname' value='".$user->surname."'  /></span></div>\n";
        echo "<div class='row'><label for='email'>Email:</label><span class='formw'><input type='text' name='email' id='email' value='".$user->email."'  /></span><span id='emailcheck'></span></div>\n";
        echo "<div class='row'><label for='email2'>Email2:</label><span class='formw'><input type='text' name='email2' id='email2' value='".$user->email2."'  /></span><span id='email2check'></span></div>\n";
        echo "<div class='row'><label for='tel'>Telefono:</label><span class='formw'><input type='text' name='tel' value='".$user->tel."'  /></span></div>\n";
        echo "<div class='row'><label for='mobile'>Mobile:</label><span class='formw'><input type='text' name='mobile'  value='".$user->mobile."'  /></span></div>\n";

        echo "<div class='row'><label for='status'>Status:</label><span class='formw'>\n";
 
	//$userStatus = getUserStatus($conn);
	$userStatus = userStatus::listUserStatus($db, $log);
                echo '<select name="status" id="status">';
                echo '<option value="-1">---------</option>';

                $count = count($userStatus);
                for ($i = 0; $i < $count; $i++) {
			if($user->status->id == $userStatus[$i]['id']){
                        	echo '<option value="'.$userStatus[$i]['id'].'" selected >'.$userStatus[$i]['status'].'</option>\n';
			}else{
	                        echo '<option value="'.$userStatus[$i]['id'].'" >'.$userStatus[$i]['status'].'</option>\n';
			}
			
                }
                echo '</select>';
	echo "</span><span id='statusdiv' class='warning' ></span></div>\n";

        echo "<div class='row'><label for='tessera'>Tessera:</label><span class='formw'><input type='text' name='tessera' value='".$user->tesseraCasale."' /></span></div>\n";
        echo "<div class='row'><label for='quota_ingresso'>Quota ingresso:</label><span class='formw'><input type='text' name='entrance_fee' value='".$user->entrance_fee."' /></span></div>\n";
        echo "<div class='row'><label for='date_subscription'>Data iscrizione:</label><span class='formw'><input type='text' name='subscription_date' value='".$user->subscription_date."'  /></span></div>\n";

 echo "<div class='row'><label for='quota'>Quota gaabista:</label><span class='formw'>\n";

        //Type of quota: ridotta, ordinaria, sostenitore
        $donationType = donationType::listDonationType($db, $log);
                echo '<select name="donationType" id="donation" >';
                echo '<option value="-1">---------</option>';

                $count = count($donationType);
                for ($i = 0; $i < $count; $i++) {
			$dT = $donationType[$i];
    			if($user->donation->id == $dT->id){                        
                                echo '<option value="'.$dT->id.'" selected >'.$dT->type.'</option>\n';
                        }else{                        
                                echo '<option value="'.$dT->id.'" >'.$dT->type.'</option>\n';
                        }

//                        echo '<option value="'.$donationType[$i]['id'].'">'.$donationType[$i]['type'].'</option>\n';
                }

                echo '</select>';
        echo "</span><span id='quotacheck' ></span></div>\n";

        echo "";

        echo "<br><br>\n";
        echo"        <input type='hidden' name='uId' value='".$_POST['uId']."' />\n";
        echo"        <input type='reset' name='reset' value='Resetta campi' />\n";
        echo"        <input type='submit' name='cancel' value='Torna indietro' />\n";
        echo"        <input type='submit' name='edit2' value='Modifica' />\n";

        echo "</form>";


}

	
	echo "</div>";



	

require 'closedb.php';

include 'footer.php';
?>

</body>
</html>

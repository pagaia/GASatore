<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Add new booking</title>\n"; ?>
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

	$(document).ready(function() {
	
	        $("#user_id").change(function() {
			var userId = this.options[this.selectedIndex].value;
			$.getJSON( "ajaxf.php", "element=donationpaied&value="+userId, function( data ) {
				$("#donation_first").val(data.first);
				$("#donation_second").val(data.second);
				$("#donation_third").val(data.third);
				$("#donation_fourth").val(data.fourth);
				
			});
});

		});
	
	</script>
</head>

<body>
<?php
require 'header.php';

echo "<div id='Content'> ";

if($_POST['book']){

	$founds = "<pre>";
        $pIds = explode("_",$_POST['all_products_id']);
        foreach( $pIds as $pId){
                $pQuantity =    $_POST["p_$pId"];
		if($pQuantity >0){
	                $pPrice =       $_POST["price_$pId"];
	                $pTPrice =      $_POST["tprice_$pId"];
	                $founds .= "Found: product $pId, quantity $pQuantity, prezzo $pPrice, Tot: $pTPrice\n";
		}
        }

        $founds .= "UserId: ".$_POST['user_id']."\n";
        $founds .= "Booking date: ".$_POST['booking_date_id']."\n";
        $founds .= "Pickup date: ".$_POST['pickup_date_id']."\n";

 	$founds .= "</pre>";

        echo $founds;


	$listBooking = array();
	foreach($pIds as $pId){
		if($_POST["p_$pId"] >0 ){
		$booking = new booking($db, $log);
		if($booking->newBooking($_POST['booking_date_id'], $_POST['user_id'], $_POST['pickup_date_id'], $pId, $_POST["p_$pId"], $_POST["tprice_$pId"])){
			$listBooking[] = $booking;
		}

		}
	}
	echo "<pre>
	";
	var_dump($listBooking);
	echo "</pre>";
//	$dPaied = new DonationPaied($db, $log);
//	$myB = $listBooking[0];
//	$dPaied->newDonation($_POST['user_id'], $myB->user_id->donation->id, (($_POST['donation_first'] >0)?$_POST['donation_first']:null),(($_POST['donation_second'] >0)?$_POST['donation_second']:null),(($_POST['donation_third'] >0)?$_POST['donation_third']:null),(($_POST['donation_fourt'] >0)?$_POST['donation_fourth']:null));
                  
	echo "<h2> Prenotazione inserita! Attendi l'aggiornamento</h2>";
#	echo "<script > 
#		setTimeout(function(){ window.location = 'listBooking.php'; }, 2000);
#	</script>";
#
	echo "Guarda il debug:>";			
//	}else{
//		echo "<h2>Errore nella creazione del nuovo gaabista</h2>";
//	}
}else{
  
	setlocale(LC_ALL, 'it_IT');
 	$founds = "<pre>";
        $pIds = explode("_",$_POST['all_products_id']);
        foreach( $pIds as $pId){
		 $pQuantity =    $_POST["p_$pId"];
                $pPrice =       $_POST["price_$pId"];
                $pTPrice =      $_POST["tprice_$pId"];
                $founds .= "Found: product $pId, quantity $pQuantity, prezzo $pPrice, Tot: $pTPrice\n";
        }
       
	$founds .= "UserId: ".$_POST['user_id']."\n";
	$founds .= "Booking date: ".$_POST['booking_date_id']."\n";
	$founds .= "Pickup date: ".$_POST['pickup_date_id']."\n";
 
	 $founds .= "</pre>";

	echo $founds;

        echo "<h2> Inserisci una nuova prenotazione</h2>";
        echo "<form name='newBooking' method='post' onsubmit='return checkSubmit();'>\n";

	echo "<fieldset>
	<legend>Box example:</legend>";
	echo "<div class='row'><label for='user_id'>User:</label><span class='formw'>\n";
        $userList = User::listUser($db, $log);
                echo '<select name="user_id" id="user_id">';
                echo '<option value="-1">--------------------</option>\n';
                $count = count($userList);
                for ($i = 0; $i < $count; $i++) {
			$u = $userList[$i];
                        echo '<option value="'.$u->id.'">'.$u->surname.' '.$u->name.'</option>\n';
                }
                echo '</select>';
        echo "</span><span id='userchecker' class='warning' ></span></div>\n";

        echo "<div class='row'><label for='booking_date_id'>Booking day:</label><span class='formw'>\n";
        $bookingCal = calendar::listCalendar($db, $log, 1);
                echo '<select name="booking_date_id" id="booking_date_id">';
                echo '<option value="-1">--------------------</option>\n';
                $count = count($bookingCal);
                for ($i = 0; $i < $count; $i++) {
                        $cal = $bookingCal[$i];
                        echo '<option value="'.$cal->id.'">'.strftime("%a %d %B %G", strtotime("$cal->day")).'</option>\n';
                }
                echo '</select>';
        echo "</span><span id='bookingchecker' class='warning' ></span></div>\n";

	echo "<div class='row'><label for='pickup_date_id'>Pickup day:</label><span class='formw'>\n";
        $pickupCal = calendar::listCalendar($db, $log, 1);
                echo '<select name="pickup_date_id" id="pickup_date_id">';
                echo '<option value="-1">--------------------</option>\n';
                $count = count($pickupCal);
                for ($i = 0; $i < $count; $i++) {
                        $cal = $pickupCal[$i];
                        echo '<option value="'.$cal->id.'">'.strftime("%a %d %B %G", strtotime("$cal->day")).'</option>\n';
                }
                echo '</select>';
        echo "</span><span id='pickupchecker' class='warning' ></span></div>\n";

/* DONATION PARAGRAPH */
	echo "</fieldset>";
	echo "<fieldset>
	<legend>Donazioni</legend>";


//	$donationPaied = new donationPaied($db, $log, null, 1 );
	echo "<div class='row'>
                <label for='header'>donazioni</label>
		<span class='header'>Prima</span>
		<span class='header'>Seconda</span>
		<span class='header'>Terza</span>
		<span class='header'>Quarta</span>
	</div><br>";

                echo "<div class='row'>
                <label for='donation_paied'>Quote Saldate</label>";
                echo "<input type='text' class='tnumber red' name='donation_first'  id='donation_first' value='' disabled='true' />\n";
                echo "<input type='text' class='tnumber red' name='donation_second'  id='donation_second' value='' disabled='true' />\n";
                echo "<input type='text' class='tnumber red' name='donation_third'  id='donation_third' value='' disabled='true'/>\n";
                echo "<input type='text' class='tnumber red' name='donation_fourth'  id='donation_fourth' value='' disabled='true'/>\n";
                echo "<span id='p_{$product->id}checker'>checker</span>
                </div>\n";

	echo "<div class='row'>
                <label for='select_donation'>Paga donazione del trimestre</label>\n";
        echo '<select name="select_donation" id="select_donation">';
                echo '<option value="-1">--------------------</option>\n';
		$trimestri = array( 'first' => 'Primo',
		'second' => 'Secondo',
		'third'  => 'Terzo',
		'fourth' => 'Quarto');
                        
		foreach ($trimestri as $k => $v){
                        echo '<option value="'.$k.'">'.$v.'</option>\n';
                }
                echo '</select>';

        echo "<span id='bookingchecker' class='warning' ></span>\n";
 	echo "<input type='text' class='tnumber red' name='pay_donation'  id='pay_donation' />\n";
        echo "</div>";
	echo "</fieldset>";

	
	echo "<div class='row'>
                <label for='header'>Prodotti </label>
		<span class='header'>Quantità</span>
		<span class='header'>Prezzo unitario</span>
		<span class='header'>Totale per prodotto</span>
	</div><br>";
	$productsList = Product::listActiveProduct($db, $log);
	foreach($productsList as $product){
	       	echo "<div class='row'>
		<label for='p_$product->id'>$product->name</label>
		<input type='text' class='tnumber' name='p_$product->id' id='p_$product->id' />
		<input type='text' class='tnumber' name='price_$product->id'  id='price_$product->id' value='$product->price'  readOnly='true'/>
		<input type='text' class='tnumber red' name='tprice_$product->id' id='tprice_$product->id'  value='0.00' readOnly='true'/>
		<span id='p_{$product->id}checker'>checker</span>
		</div>\n";
	}
 
	echo "<br><div class='row'>
                <label for='total_cost' style='color:red;'>Costo totale</label>
                <input type='text' class='tnumber red' name='total_cost' id='total_cost'  value='0.00' readonly='true'/>
                </div>\n";


	echo "<script>
	    $(function() {
	";
 
	// sum all cost per product
	$total_cost = "var tot = ";
	$all_products_id = "";
        foreach($productsList as $product){
                $total_cost .= " parseFloat($('#tprice_$product->id').val()) + ";
		$all_products_id .= "$product->id" ."_";
        }
        $total_cost = substr($total_cost,0,(strlen($total_cost)-2)) . ";";
        $all_products_id = substr($all_products_id,0,(strlen($all_products_id)-1));

          echo "
		var newDonation= 0;
		$( '#pay_donation').change(function( index ) {
			sumCost();
		});

        	function sumDonation(){
			newDonation = parseFloat($('#pay_donation').val());
		} 

	       function sumCost(){
                        $total_cost     
			sumDonation();
			tot = tot + newDonation;
                        tot = tot.toFixed(2);
                        $('#total_cost').val( tot);
                    }
                ";


	
   	foreach($productsList as $product){
       		echo "
	    	$('#p_$product->id').change( function() {
			var punit= $('#price_$product->id').val();
			var quantity = $('#p_$product->id').val();
			var tot = punit*quantity;
			tot = tot.toFixed(2);
		        $('#tprice_$product->id').val( tot);
			sumCost();
		    });
		";

        }


	echo "});
	</script>";
        
	echo "";
	echo "<input type='hidden' name='all_products_id' value='$all_products_id' /> ";
        echo "<br><br>\n";
        echo "<div class='right'> ";
	echo "<input type='reset' name='reset' value='Resetta campi' />\n";
        echo "        <input type='submit' name='book' value='Prenota' />\n";
        echo "        <input type='submit' name='pay' value='Prenota&Paga' />\n";
	echo "</div>";
        echo "</form>";


}
	
	echo "</div>";



	

include 'footer.php';
?>

</body>
</html>

<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Modifica Prodotto</title>\n"; ?>
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

echo "<div id='Content'> ";

$pId= ($_POST['pId']? $_POST['pId']:$_GET['pId']);
$product = new Product($db, $log, $pId);

if(!$product->name){
                echo "<h2>Nessun prodotto da modificare</h2>";
}elseif($_POST['edit2']){
        if($product->update($_POST['name'],$_POST['description'],$_POST['category_id'],$_POST['price'],$_POST['disable'])){
                        echo "<h2>Prodotto modificato! Attendi l'aggiornamento....</h2>";
                        echo "<script > 
                        setTimeout(function(){ window.location = 'listProducts.php'; }, 2000);
                        </script>";


        }else{
                echo "<h2>Errore nella modifica del prodotto</h2>";
        }
}else{

        echo "<h2> Modifica il prodotto</h2>";
        echo "<form name='newProduct' method='post' onsubmit='return checkSubmit();'>\n";
        echo "<div class='row'><label for='name'>Name:</label><span class='formw'><input type='text' name='name' value='".$product->name."'  /></span></div>\n";
        echo "<div class='row'><label for='description'>Description:</label><span class='formw'><textarea rows=4 cols=50 name='description'>".$product->description."</textarea></span></div>\n";

        echo "<div class='row'><label for='category_id'>Category:</label><span class='formw'>\n";
 
	//$userStatus = getUserStatus($conn);
	$pCategory = productCategory::listCategory($db, $log);
                echo '<select name="category_id" id="category_id">';
                $count = count($pCategory);
                for ($i = 0; $i < $count; $i++) {
			$cat = $pCategory[$i];
			if($product->category->id == $cat->id){
                        	echo '<option value="'.$cat->id.'" selected >'.$cat->name.'</option>\n';
			}else{
                        	echo '<option value="'.$cat->id.'" >'.$cat->name.'</option>\n';
			}
			
                }
                echo '</select>';
	echo "</span><span id='categorycheck' class='warning' ></span></div>\n";

        echo "<div class='row'><label for='price'>Price</label><span class='formw'><input type='text' class='tnumber' name='price' value='".$product->price."' /></span><span id='pricecheck' class='warning'> Usare il punto (.) come separatore decimale</span> </div>\n";
        echo "<div class='row'><label for='disable'>Disable:</label><span class='formw'>\n";
        echo '<select name="disable" id="disable" >';
        echo '<option value="0" '.($product->disable?"":"selected").' >Disponibile</option>';
        echo '<option value="1" '.($product->disable?"selected":"").' >NON disponibile</option>';
        echo '</select>';
        echo "</span><span id='disablecheck' ></span></div>\n";

        echo "";

        echo "<br><br>\n";
        echo"        <input type='hidden' name='pId' value='$pId' />\n";
        echo"        <input type='reset' name='reset' value='Resetta campi' />\n";
        echo"        <input type='submit' name='edit2' value='Modifica' />\n";

        echo "</form>";


}

	
	echo "</div>";



	

require 'closedb.php';

include 'footer.php';
?>

</body>
</html>

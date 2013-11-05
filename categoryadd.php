<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - View Monthly Report</title>\n"; ?>
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
require 'header.php';

echo "<div id='Content'> ";

if($_POST['add']){
    	$cat = new productCategory($db, $log);
        if($last_id = $cat->newCategory($_POST['name'], $_POST['description'])){
                        echo "<h2> Nuova categoria inserita! Attendi l'aggiornamento</h2>";
			echo "<script > 
			setTimeout(function(){ window.location = 'listCategories.php'; }, 2000);
			</script>";
			
	}else{
		echo "<h2>Errore nella creazione della nuova categoria</h2>";
	}
}else{

        echo "<h2> Inserisci nuova categoria</h2>";
        echo "<form name='newCategory' method='post' onsubmit='return checkSubmit();'>\n";
        echo "<div class='row'><label for='name'>Name:</label><span> <input type='text' name='name' id='name' /></span><span id='usernamecheck'></span></div>\n";
        echo "<div class='row'><label for='description'>Description:</label><span class='formw'><textarea name='description' rows='4' cols='50'></textarea></span></div>\n";
        echo "";

        echo "<br><br>\n";
        echo"        <input type='reset' name='reset' value='Resetta campi' />\n";
        echo"        <input type='submit' name='add' value='Aggiungi' />\n";

        echo "</form>";


}
	
	echo "</div>";



	

require 'closedb.php';

include 'footer.php';
?>

</body>
</html>

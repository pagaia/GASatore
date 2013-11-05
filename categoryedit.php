<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Modifica Categorie </title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
 <script type='text/javascript' src='files/jquery-1.3.2.min.js'></script> 
<!-- <script type='text/javascript' src='files/jquery-1.10.2.js'></script> -->

<script type='text/javascript' src='files/script.js'></script>
<script type="text/javascript">

var myJSONError = {"error": [
        {"name": "0"},
        {"desc": "0"}
    ]
};	

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
									if(strData != 'OK'){ myJSONError.error[0].this.id=1;}
									else{ myJSONError.error[0].this.id=0;}
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
	checkValue($("#name"),$("#namechecker"));
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

$cId = (isset($_POST['cId'])?$_POST['cId']: $_GET['cId']);
$cat = new productCategory($db, $log, $cId);

if(!$cat->name){
                echo "<h2>Nessuna categoria da modificare</h2>";
}elseif($_POST['edit2']){
        if($cat->update($_POST['name'],$_POST['description'])){
                        echo "<h2>Categoria modificata! Attendi l'aggiornamento....</h2>";
                        echo "<script > 
                        setTimeout(function(){ window.location = 'listCategories.php?'; }, 2000);
                        </script>";


        }else{
                echo "<h2>Errore nella modifica della categoria</h2>";
        }
}else{

        echo "<h2> Modifica la categoria di prodotto</h2>";
        echo "<form name='editCategory' method='post' onsubmit='return checkSubmit();'>\n";
        echo "<div class='row'><label for='name'>Name:</label><span class='formw'><input type='text' name='name' id='name' value='".$cat->name."'  /></span><span id='namechecker'></span></div>\n";
        echo "<div class='row'><label for='description'>Description:</label><span class='formw'><textarea name='description' rows='4' cols='50'>".$cat->description."</textarea></span></div>\n";
        echo "";

        echo "<br><br>\n";
        echo"        <input type='hidden' name='cId' value='".$cId."' />\n";
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

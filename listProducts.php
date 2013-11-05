<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Prodotti</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
</head>

<body>
<?php
require 'header.php';
$connectedUser = new User($db, $log, $_SESSION['user_id']);
## if not ADMINISTRATOR nothing will be shown..
if(  !$connectedUser->isAdmin()){
	echo "<div id='Content'> ";
        echo "<h2>Non hai diritti per accedere a queste informazioni.</h2>";
	echo "</div> ";
}else{

		echo "<div id='Content'>";
	
		echo "<div><form name='addProduct' method='post' action='productadd.php'>\n";
		echo "<input type=submit name='new' value='Inserisci un nuovo prodotto'/>";
		echo "</form></div>";	
		
		echo "<br><br>\n";
		echo "<p> Qui di seguito tutti i  prodotti</p>\n";

 		echo "<table><tr><th><input type='checkbox' name='userAll' value='Select all' onclick='javascript:selectAll(this, \"userid[]\");'/></th>
		<th>Nome</th><th>Descrizione</th><th>Categoria</th><th>Prezzo</th><th>Disponibile</th>\n";
		$listProducts =  Product::listProducts($db, $log);

                $count = count($listProducts);
                for ($i = 0; $i < $count; $i++) {
			$myP = $listProducts[$i];
                        echo "<tr ".( ($i % 2 == 0)?"class='even'":"" ).">\n";
                        echo "<td><input type='checkbox' name='productid[]' value='".$myP->id."' /></td>";
                        echo "<td><a href='productedit.php?pId=".$myP->id."' >".$myP->name."</a></td>";
                        echo "<td>".$myP->description."</td>";
                        echo "<td>".$myP->category->name."</td>";
                        echo "<td>".$myP->price." &euro;</td>";
                        echo "<td>".($myP->disable?"NON disponibile":"Disponibile" )."</td>";
                        echo "</tr>";
                }
                echo "</table> <br/><br/>";

		echo "</div>";
	
}


?> 

<?php
include 'footer.php';
?>



</body>
</html>

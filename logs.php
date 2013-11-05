<?php require 'session.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Audit Report</title>\n"; ?>
<style type="text/css" media="all">@import "files/tablesort.css";</style>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
<script type="text/javascript" src="files/jquery.tablesorter.min.js"></script>
<script type="text/javascript" id="js">
$(document).ready(function() {
	// call the tablesorter plugin
	$("table").tablesorter();
}); </script>

</head>

<body>
<?php 
#print_r ( $_SESSION);
#print_r($_POST);
#
?>
<?php
require 'opendb.php';
require 'functions.php';
require 'header.php';


echo "<div id='Content'> ";

if(isAdmin($conn, $_SESSION['user_id'])){

	
	//print the audit 
	$rows = getAudit( $_SESSION['project_id'], $conn);
	$count = count($rows);
	if($count > 0){
	   	echo "<br><br>";
	        echo "<table id='myTable' class='tablesorter'>\n";
		echo "<thead><tr><th>Company</th><th>Report</th><th>User</th><th>Time</th><th>Operation</th></tr></thead>";
	        echo "<tbody>\n";
	
		for ($i = 0; $i < $count; $i++) {
		
			echo "<tr>";
			echo "<td>" . $rows[$i]['company'] . "</td>";
			echo "<td>" . $rows[$i]['period'] . "</td>";
			echo "<td>" . $rows[$i]['name'] ." ".$rows[$i]['surname']. "</td>";
			echo "<td>" . $rows[$i]['time'] . "</td>";
			echo "<td>" . $rows[$i]['operation'] . "</td>";
			echo "</tr>\n";
		} 
		echo "</tbody></table>";
	}else{
	 	echo "<h2>There is nothing to show</h2>";
	}

}else{
	echo "<h2>You don't have the right to see these information</h2>";
}

echo "</div>";



	

require 'closedb.php';

include 'footer.php';
?>

</body>
</html>

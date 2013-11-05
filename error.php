<?php
  /* if not logged in then back to login page */
  session_start();
  if(!isset($_SESSION['is_successful_login']) || $_SESSION['is_successful_login'] == false){ 
    header ('location: index.php'); exit;
  }
  error_reporting(E_ALL);
  ini_set('display_errors', '1');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>".PROJECT." v1.1 - Error</title>
<style type="text/css" media="all">@import "files/main.css";</style>
</head>

<body>


<?php
echo "<div id='Header'>";
if(isset($_SESSION['project_name'])){
        echo "<h1> ". $_SESSION['project_name'] ." FP7 projects effort and cost Report UNDER DEVELOPMENT</h1>";
}else{
        echo "<h1 >FP7 effort and cost report - UNDER DEVELOPMENT</h1>";

}
echo "</div>";
?>

<div id='Error'>
</div>

<div id='Menu'>
        <ul>
<?php
        echo "<li><a href='project.php'>Select Project</a></li>";
        if(isset($_SESSION['project_name'])){
                echo "<li><a href='monthly.php'>Monthly Report</a></li>
                      <li><a href='show_monthly.php'>Show M. Report</a></li>
                      <li><a href='sixmonthly.php'>Six-Monthly Report</a></li>
                      <li><a href='show_sixmonthly.php'>Show SM Report</a></li>
                      <li><a href='export.php'>Export Report</a></li>
                ";
        }else{
                echo "<li><a href='#'>Monthly Report</a></li>
                      <li><a href='#'>Show M. Report</a></li>
                      <li><a href='#'>Six-Monthly Report</a></li>
                      <li><a href='#'>Show SM Report</a></li>
                ";
        }
           ?>

              <li><a href='logout.php'>Logout</a></li>
         </ul>
</div>

<?php
require 'config.php';

echo "<div id='Error'>".$_SESSION['error']."</div> \n";

$_SESSION['error']="";
?>

</body>
</html>

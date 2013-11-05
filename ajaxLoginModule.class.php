<?php
 /*  Ajax Login Module v1.0 
  *  @author : Christopher M. Natan
  *	 
  *	 Simple and nice Ajax Login Page that very easy to plug into your existing web application
  *	 no need more configuration and programming.
  *	  
 */
 


#include('files/db.php');
include('library/mysql.php');
class ajaxLoginModule  {
  private $timeout         = null;
  private $target_element  = null;
  private $wait_text       = null;
  private $form_element    = null;
  private $wait_element    = null;
  private $notify_element  = null;
   
  function __construct() {
     include ('config.php'); 
	 $msql  = new Database;
	 $msql->connect();
	 $this->is_login();
  } 

  function get_config() {
	 $this->set_ajax_config();
  } 

  function set_ajax_config() {
     $this->timeout         = AJAX_TIMEOUT;
     $this->target_element  = AJAX_TARGET_ELEMENT;
     $this->wait_text       = AJAX_WAIT_TEXT;
     $this->wait_element    = AJAX_WAIT_ELEMENT;
     $this->notify_element  = AJAX_NOTIFY_ELEMENT;
     $this->form_element    = AJAX_FORM_ELEMENT;
  }

  function initLogin($arg = array()) {
	 $this->get_config();
	 $this->login_script();   	 
  }

  function initJquery() { 
	 return "<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>";
  }

  function login_script() { 
	 include ('files/login_script.php');
  }

  function is_login() {
      if(isset($_POST['username']))  {
     	 $username   = $_POST['username'];
	 $password   = $_POST['password'];
	 $strSQL = "SELECT * FROM ".USERS_TABLE_NAME."
			    WHERE username ='$username' AND password = '$password' ";

        $result  = mysql_query ($strSQL); 
		$row     = mysql_fetch_row($result);
		$exist   = count($row);
		if($exist >=2) { 
			$this->log("Logged in $username");		
			$this->jscript_location($row[0]);  
		} 
		else {
                        $this->log("Logged FAIL $username");
			$this->notify_show();
		}
		exit;		
	  }   
  }

  function notify_show() {
    echo "<script>$('.".AJAX_NOTIFY_ELEMENT."').fadeIn();</script>";
  }

  function jscript_location($user_id) {
    $this->set_session($user_id);
    echo "<script> $('#container').fadeOut();window.location.href='".SUCCESS_LOGIN_GOTO."'</script>";
  }
  
  function set_session($user_id) {
      session_start();
	  $_SESSION['is_successful_login'] = true;

	$this->set_user($user_id);
  }  	

  function set_user($user_id) {
	$strSQL = "SELECT  ut.id as user_id, ut.name, surname, r.id as role_id
		FROM ".USERS_TABLE_NAME." as ut 
		INNER JOIN role as r ON r.id=ut.role_id
		WHERE ut.id=$user_id ";

	$result  = mysql_query ($strSQL);
	$row = mysql_fetch_assoc($result);
 	$_SESSION['user_id'] = $row['user_id'];
 	$_SESSION['user_name'] = $row['name'];
        $_SESSION['user_surname'] = $row['surname'];
        $_SESSION['role_id'] = $row['role_id'];
  	$_SESSION['timeout'] = time();

	$this->log($strSQL);

  }

function log($msg){
	$myFile = "log.txt";
	$fh = fopen($myFile, 'a') or die("can't open file");
	fwrite($fh, date('Y-m-d H:i:s') ." $msg\n");
	fclose($fh);
} 
	  
}  
?>  

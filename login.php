<?php
 /*  Ajax Login Module v1.0 
  *  @author : Christopher M. Natan
  *	 
  *	 Simple and nice Ajax Login Page that very easy to plug into your existing web application
  *	 no need more configuration and programming.
  *	 
  *  check easy-install.txt for small instruction
 */
   include('ajaxLoginModule.class.php');

   $ajaxLoginModule = new ajaxLoginModule();
   require 'config.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo "<title>".PROJECT." ".VERSION." - Login</title>\n"; ?>
<link href="files/login.css" rel="stylesheet" type="text/css" />
<?php echo $ajaxLoginModule->initJquery();?>
</head>
<body>
<div id="container" style="display:none;">
  <?php echo "<div class='title'>".PROJECT." ".VERSION."</div>" ?>
  <form action="" method="post" class="ajax_form">
    <ul>
      <li class="label"> Username</li>
      <li class="field">
        <input name="username" type="text" class="text" />
      </li>
      <li class="label"> Password</li>
      <li class="field">
        <input name="password" type="password" class="text"/>
      </li>
      <li class="label"> </li>
      <li class="field"> <img src="files/isubmit.jpg" class="submit" onclick="$('.<?php echo AJAX_FORM_ELEMENT?>').submit();"/>
        <input name="submit" type="submit" style="display:none" />
      </li>
      <li class="invalid_message">
        <div class="ajax_notify" style="display:none; clear:both"> 
          Error : Invalid username or password. Please try again.
          <!--don't delete this div class="ajax_notify"-->
        </div>
      </li>
      <li class="label status"> 
        <span class="ajax_wait">
        <!--don't delete this span class="ajax_wait"-->
        </span> </li>
    </ul>
    <div class="ajax_target">
      <!--don't delete this div class="ajax_target" -->
    </div>
  </form>
  <?php 
   echo $ajaxLoginModule->initLogin();
 ?>
</div>
</body>
</html>

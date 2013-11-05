<?php
 /*  Ajax Login Module v1.0 configuration
  *  @author : Christopher M. Natan
  *	 
  *	 Simple and nice Ajax Login Page that very easy to plug into your existing web application
  *	 no need more configuration and programming.
  *	 
  *  check easy-install.txt for small instruction
 */
 
 /* 
  * MySQL Server Configuration 
  * Im sure you will edit this section.
 */
  error_reporting(1);
  // set the local it language for conversione of day in italian
  //setlocale(LC_ALL, 'it_IT');
  
  define('MYSQL_HOSTNAME',  'localhost');  /* hostname */
  define('MYSQL_USERNAME',  'gaabe');       /* username */
  define('MYSQL_PASSWORD',  'gaabe');   /* password */
  define('MYSQL_DATABASE',  'gasatore'); /* database */
  /* If user exist in the DB then it will redirected to */
  define('SUCCESS_LOGIN_GOTO'   ,'index.php');

  // start database connection
  require_once 'library/mysql.php';
  $db  = new Database();
 
  /* if the TABLE NAME below doesn't exist Ajax Login Module will automatically create this TABLE
   * You can change the TABLE NAME whatever you want.
  */
  define('USERS_TABLE_NAME','user');
  
  /* Advance Configuration - no need to edit this section */
  define('AJAX_TIMEOUT',        '10000000');
  define('AJAX_TARGET_ELEMENT', 'ajax_target');
  define('AJAX_WAIT_TEXT',      'Please wait...');
  define('AJAX_FORM_ELEMENT',   'ajax_form');
  define('AJAX_WAIT_ELEMENT',   'ajax_wait');
  define('AJAX_NOTIFY_ELEMENT', 'ajax_notify');

  /* VERSION of the Project*/
  define('VERSION',	'v0.1');

  /* PRJECT NAME*/
  define('PROJECT', "GASatore");

  /* for debug set the variable to TRUE */
  define('DEBUG',	TRUE);
  
  /* set LOG level */
  //define('LOG',	'KLogger::DEBUG'); // One of this level KLogger::DEBUG KLogger::INFO KLogger::WARN  KLogger::ERROR  KLogger::FATAL KLogger::OFF   
  //define('LOG_FILE', 'log.txt');
  require_once 'library/KLogger.php';	
  $log = new KLogger ( "/var/www/html/gasatore/log.txt" , KLogger::DEBUG );


?>

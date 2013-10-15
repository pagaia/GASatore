<?php

require_once 'mysql.php';
//require_once 'user.php';
require_once 'KLogger.php';
//require_once 'prodotto.php';
require_once 'classes.php';

$log = new KLogger ( "log.txt" , KLogger::DEBUG );
// Do database work that throws an exception
$log->LogError("An exception was thrown in ThisFunction()");
$time_ms= date("yyy"); 
// Print out some information
$log->LogInfo("Internal Query Time: $time_ms milliseconds");
 
// Print out the value of some variables


// start database connection
$db = new Database('localhost', 'gaabe', 'gaabe', 'gasatore');

$user= new User($db);
//$user->newUser($db,'username', 'password', 'tess', 'surnae', 'tel', 'mobile', 'email', 'status');
$user->newUser('username', 'password', 'Cristina', 'Ananasso', 'tel', 'mobile', 'cri.ananasso@hotmail.it', 'second email', 'address', 1001,0,1,1,2);
$user2 = new User($db);
$user2->newUser('username', 'password', 'Remo', 'Moro', 'tel', 'mobile', 'remo.moro@gmail.com', 'second email', 'address', 1002,0,1,1,1);



//add Product category
$pcategory = new productCategory($db);
$pcategory->newCategory("pane", "Tutti i prodotti di pane");

$cat2 = new productCategory($db);
$cat2->newCategory("uova", "Tutti i tipi di uova");

$p = new Product($db);
$p->newProduct('uova da 4', 'pacchetto di 4 uova', 2, "4.10");

$p2 = new Product($db);
$p2->newProduct('pane 4 cereali', 'pane 4 cereali', 2, "4.10");


$roles = role::listRole($db);
$userStatus = userStatus::listUserStatus($db);

$listUser = User::listUser($db);

//$user->loadInfo(null, $db);
//echo var_dump($user);
//$log->LogDebug("User Count: $user");

/* $jsonenc = json_encode($user);
echo "json encoded: $jsonenc\n";
 
echo "json decode 1 case " . var_dump(json_decode($jsonenc, true));
echo "json second case " . var_dump(json_decode($jsonenc));
*/
?>

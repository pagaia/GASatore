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

$pr = new Product($db);
$pr->newProduct('uova da 4', 'pacchetto di 4 uova', 2, "4.10");

$p2 = new Product($db);
$p2->newProduct('pane 4 cereali', 'pane 4 cereali', 2, "4.10");


$roles = role::listRole($db);
$userStatus = userStatus::listUserStatus($db);

$listUser = User::listUser($db);

$products_list = array();
$p['booking_date_id'] = 1;
$p['user_id'] = 1;
$p['pickup_date_id'] =2;
$p['product_id'] = 1;
$p['quantity'] = 2;
$p['tot_price'] = 20;

$products_list[] = $p;

$p1['booking_date_id'] = 1;
$p1['user_id'] = 1;
$p1['pickup_date_id'] =2;
$p1['product_id'] = 2;
$p1['quantity'] = 3;
$p1['tot_price'] = 30;

$products_list[] = $p1;

$u = new userBooking($db,null,null,null);
$u->newBooking($products_list);
$u->stampa();

/*$booking = new booking($db);
$booking->newBooking(1, 1, 2, 1,  2, 20);

$bo2 = new  booking($db);
$bo2->newBooking(1, 1, 2, 2, 3, 30);
*/
//$user->loadInfo(null, $db);
//echo var_dump($user);
//$log->LogDebug("User Count: $user");

/* $jsonenc = json_encode($user);
echo "json encoded: $jsonenc\n";
 
echo "json decode 1 case " . var_dump(json_decode($jsonenc, true));
echo "json second case " . var_dump(json_decode($jsonenc));
*/
?>

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

  define('MYSQL_HOSTNAME',  'localhost');  /* hostname */
  define('MYSQL_USERNAME',  'gaabe');       /* username */
  define('MYSQL_PASSWORD',  'gaabe');   /* password */
  define('MYSQL_DATABASE',  'gasatore'); /* database */

// start database connection
$db = new Database();

$user= new User($db, $log);
//$user->newUser($db,'username', 'password', 'tess', 'surnae', 'tel', 'mobile', 'email', 'status');
$user->newUser('cristina', 'cristina', 'Cristina', 'Surname', 'tel', 'mobile', 'cristina@email.it', 'second email', 'address', 1001,0,1,1,null,2);
$user2 = new User($db, $log);
$user2->newUser('rmoro', 'rmoro', 'Remo', 'Moro', 'tel', 'mobile', 'remo.moro@mail.com', 'second email', 'address', 1002,0,1,1,null,1);
$u3 = new User($db, $log);
$u3->newUser('remo', 'remo', 'Remo2', 'Moro', 'tel', 'mobile', 'remo@mail.com', 'second email', 'address', 1003,0,1,1,null,1);

//add Product category
$category = array();
$category[] = array('Sportina', 'Sportine di frutta e verdura');
$category[] = array('Donazioni', 'Donazioni trimestrali e quota d\'ingresso');
$category[] = array('Prodotti senza prezzo unitario', 'Prodotti vari senza prezzo unitario');
$category[] = array('Pane', 'Tutti i tipi di pane');
$category[] = array('Yogurt', 'Yogurt dell\'associazione Barikamà');
$category[] = array('Pesche', 'Pesche');
$category[] = array('Uova' , 'Uova da 4 o 6 ');
$category[] = array('Formaggi' , 'Formaggi');

$count=0;
foreach($category as $v){
	$cat = new productCategory($db, $log);
	$cat->newCategory($v[0], $v[1], ++$count);
}

//add Products
$product = array();
$product[] = array('Sportina piccola','Sportina da 5kg','1','8.50',0,1);
$product[] = array('Sportina GRANDE','Sportina da 10kg',1,"17.00",0,1);
$product[] = array('Carne','Carne',3,"1,00",0,0);
$product[] = array('Pane 4 cereali','Pane 4 cereali',4,"4.05",0,1);
$product[] = array('Pane integrale','Pane integrale',4,"4.05",0,1);
$product[] = array('Pane bianco','Pane bianco',4,"4.05",0,1);
$product[] = array('Yogurt piccolo','Yogurt piccolo',5,"2.00",0,1);
$product[] = array('Yogurt medio','Yogurt medio',5,"3.00",0,1);
$product[] = array('Yogurt grande','Yogurt Grande',5,"4.00",0,1);
$product[] = array('Pesche','Pesche',6,"4.00",1,1);
$product[] = array('Uova da 4','Uova da 4',7,"2.00",0,1);
$product[] = array('Uova da 6','Uova da 6',7,"4.00",0,1);
$product[] = array('Quota ingresso','Quota di ingresso 5 euro',2,"1.00",0,0);
$product[] = array('Restituzione','Resituisco al gaabista dei soldi',3,"1.00",0,0);
$product[] = array('Altri prodotti','Altri prodotti venduti',3,"1.00",0,0);
$product[] = array('Fuori sporta','Frutta e verdura fuori sporta',3,"1.00",0,0);
$product[] = array('Prima quota trim.','Prima quota trimestrale',2,"1.00",0,0);
$product[] = array('Seconda quota trim.','Seconda quota trimestrale',2,"1.00",0,0);
$product[] = array('Terza quota trim.','Terza quota trimestrale',2,"1.00",0,0);
$product[] = array('Quarta quota trim.','Quarta quota trimestrale',2,"1.00",0,0);

foreach($product as $v){
	$pro = new Product($db, $log);
	$pro->newProduct($v[0], $v[1], $v[2], $v[3], $v[4], $v[5]);
}



$roles = role::listRole($db, $log);
$userStatus = userStatus::listUserStatus($db, $log);

$listUser = User::listUser($db, $log);

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

//$uB = new userBooking($db, $log);
//$uB->newUserBooking($products_list);
//$uB->stampa();

echo "USER ID : $user->id\n";
echo "USER2 ID : $user2->id\n";

//$tot_price = $uB->totalCost;
//echo "TOT PRICE: $tot_price\n";

//$payment = new userPayment($db, $log);
//$payment->newPayment($user->id, '2013-10-10', "$tot_price", '55' );

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

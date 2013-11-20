<?php

require_once 'KLogger.php';

class base extends KLogger{
 protected $_db;
 protected $log;

 public function stampa(){
  echo var_dump($this);
 }

/* public static function log($msg){
  $time = date("Y-m-d h:i:s -");
  if(is_array($msg)){ echo "$time ". json_encode($msg)."\n";}
	else{echo "$time ".$msg."\n";}
 }
*/
}

class role extends base{
 public $id; 
 public $name;
 public $description;


 public function __construct($db, $log, $id = null)  {
	$this->log = $log;
//        $this->log->LogInfo( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if($id){ $this->loadInfo($id);}
 }

 public function loadInfo($id){
   // query database
        if($id) {
                $q = "SELECT * FROM role where id=$id ORDER BY name";
        }
        $a = $this->_db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
	        $this->id = $v['id'];
	        $this->name = $v['name'];
	        $this->description = $v['description'];
          }

        }

 }

 public static function listRole($db, $log){
	$result= array();
	
	if($db) {
                $q = "SELECT * FROM role";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result['id']= $v['id'];
                $result['name'] = $v['name'];
                $result['description'] = $v['description'];
		$log->LogDebug($result);
          }
        }
	return $result;
 }
}
 

class calendar extends base{
 public $id;
 public $day;
 public $status;
 public $booking;
 public $pickup;

 public function __construct($db, $log, $id = null)  {
        $this->log = $log;
  //      $this->log->LogInfo('The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
        if($id){ $this->loadInfo($id);}

 }

 public function loadInfo($id){
   // query database
        if($id) {
                $q = "SELECT * FROM calendar where id=$id ORDER BY id";
        }
        $a = $this->_db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $this->id = $v['id'];
		$this->day = $v['day'];
                $this->status = $v['status'];
                $this->booking = $v['booking'];
		$this->pickup = $v['pickup'];
          }

        }

 }


 public static function listCalendar($db, $log, $booking = null, $pickup = null){
        $result = array();

        if($db) {
                $q = "SELECT * FROM calendar ";
		$where= "WHERE ";
		if($booking && $pickup){ 
			$where .= " booking=1 and pickup=1 ";
		}elseif($booking){  
			$where .= " booking=1 "; 
		}elseif($pickup){
			$where .= " pickup=1 ";
		}

		if(strlen($where)>6){
			$q .= $where;
		}
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
		$result[] = new calendar($db, $log, $v['id']);
                $log->logInfo($result);
          }
        }
        return $result;
 }


}


class userStatus extends base{
 public $id;
 public $status;
 public $description;


 public function __construct($db, $log, $id = null)  {
        $this->log = $log;
//	$this->log->LogInfo('The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
 	if($id){ $this->loadInfo($id);}

 }

 public function loadInfo($id){
   // query database
        if($id) {
                $q = "SELECT * FROM user_status where id=$id ORDER BY id";
        }
        $a = $this->_db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $this->id = $v['id'];
                $this->status = $v['status'];
                $this->description = $v['description'];
          }

        }

 }

 public static function listUserStatus($db, $log){
        $result = array();

        if($db) {
                $q = "SELECT * FROM user_status";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[$k]['id']= $v['id'];
                $result[$k]['status'] = $v['status'];
                $result[$k]['description'] = $v['description'];
                $log->logInfo($result);
          }
        }
        return $result;
 }


}

class donationType extends base{
 public $id;
 public $type;


 public function __construct($db, $log, $id = null)  {
	$this->log = $log;
//	$this->log->LogInfo('The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if($id){ $this->loadInfo($id);}
 }

 public function loadInfo($id){
   // query database
        if($id) {
                $q = "SELECT * FROM donation_type where id=$id ORDER BY id";
        }
        $a = $this->_db->fetch_all_array($q);
 	
	$this->log->LogDebug("DonationType Query: $q");

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $this->id = $v['id'];
                $this->type = $v['type'];
          }

        }

 }

 public static function listDonationType($db, $log){
        $result= array();

        if($db) {
                $q = "SELECT * FROM donation_type";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
		$result[] = new donationType($db, $log,  $v['id']);
                $log->logDebug($result);
          }
        }
        return $result;
 }


}


class donation extends base{
 public $id;
 public $name;
 public $type; //Another class
 public $amount;


 public function __construct($db, $log, $id = null)  {
        $this->log = $log;
//	$this->LogInfo( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if($id){ $this->loadInfo($id);}

 }

 public function loadInfo($id){
   // query database
        if($id) {
                $q = "SELECT * FROM donation where id=$id ORDER BY id";
        }
        $a = $this->_db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $this->id = $v['id'];
                $this->name = $v['name'];
                $this->type = new donationType($this->_db, $this->log, $v['type_id']);
                $this->amount = $v['amount'];
          }

        }

 }

 public static function listDonation($db, $log){
        $result= array();

        if($db) {
                $q = "SELECT * FROM donation";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
 #               $result['id']= $v['id'];
 #               $result['name'] = $v['name'];
 #               $result['type_id'] = $v['type_id'];
 #               $result['amount'] = $v['amount'];
		$result[] = new donation($db, $log,  $v['id']);
                $log->logDebug($result);
          }
        }
        return $result;
 }


 public static function listDonationGroupByName($db, $log){
        $result= array();

        if($db) {
		$q = "SELECT * FROM donation group by name order by id";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new donation($db, $log,  $v['id']);
                $log->logDebug($result);
          }
        }
        return $result;
 }




}


class donationPaied extends base{
 public $id;
 public $user_id; //user Class
// public $donation_type; //Another class
 public $first;
 public $second;
 public $third;
 public $fourth;


 public function __construct($db, $log, $id = null, $userId = null)  {
	$this->log = $log;
       // $this->log->logDebug( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if($id){ $this->loadInfo($id);}
	if($userId){ $this->loadInfoByUser($userId);}
	

 }

 public function loadInfo($id){
   // query database
        if($id) {
		$q = "SELECT * FROM user u left join donation_paied d on d.user_id=u.id WHERE d.id=$id";

        }
        $a = $this->_db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $this->id = $v['id'];
                $this->user_id = new User($this->_db, $this->log, $v['user_id']);
 //               $this->donation_type = new donationType($this->_db, $this->log, $v['donation_type_id']);
                $this->first  = $v['first'];
                $this->second = $v['second'];
                $this->third  = $v['third'];
                $this->fourth = $v['fourth'];
          }

        }

 }
 
 public function loadInfoByUser($userid){
   // query database
        if($userid) {
                $q = "SELECT * FROM user u left join donation_paied d on d.user_id=u.id WHERE u.id=$userid";
        
		$this->log->LogDebug("LoadInfoByUser: $q");
        	$a = $this->_db->fetch_all_array($q);

		 if (!empty($a)) {
	          foreach ($a as $k => $v) {
	                $this->id = $v['id'];
                	$this->user_id = new User($this->_db, $this->log, $v['user_id']);
   //             	$this->donation_type = new donationType($this->_db, $this->log, $v['donation_type_id']);
	               // $this->user_id = $v['user_id'];
	               // $this->donation_type = $v['donation_type'];
	                $this->first  = $v['first'];
	                $this->second = $v['second'];
	                $this->third  = $v['third'];
	                $this->fourth = $v['fourth'];

			return $v['id'];
	          }
	
	        }

	}else{
		return false;
	}

 }


 public function newDonation($user_id, $first=null, $second=null, $third=null, $fourth=null){
 
	$q = sprintf("INSERT INTO donation_paied (user_id, first, second, third, fourth)  values (%d, %f, %f, %f, %f)", 
	$user_id, $first, $second, $third, $fourth);


        $this->log->LogDebug("Donation Paid by: $q");
        if($this->_db->query($q)){
                $this->loadInfo($this->_db->last_id());
                return $this->_db->last_id();
        }

	
 }

/* 
 public static function listDonationPaiedByUser($db, $log, $user_id){
        $result= array();

        if($user_id) {
                $q = "SELECT *  FROM donation_type as dt join donation as d on dt.id=d.type_id  join donation_paied as dp   on dp.donation_id=d.id where user_id=$user_id";
        	$a = $db->fetch_all_array($q);

        	if (!empty($a)) {
        	  foreach ($a as $k => $v) {
			$result[] = new donationPaied($db,$log, $v['id']);
        	        $log->logDebug($result);
        	  }
        	}
        
		return $result;
        }else{
		return false;
	}
 }

*/
 public static function DonationPaiedxTrimestre($db, $log){
        $result= array();

        if($user_id) {
		//$q = "SELECT d.name quota, dp.amount as tot_quota FROM donation_type as dt join donation as d on dt.id=d.type_id  left join donation_paied as dp   on dp.donation_id=d.id group by d.name";
		$q = "select sum(first) as first, sum(second) as second, sum(third) as third, sum(fourth) as fourth from donation_paied";
                $a = $db->fetch_all_array($q);

                if (!empty($a)) {
                  foreach ($a as $k => $v) {
                        $result['first']= $v['first'];
                        $result['second']= $v['second'];
                        $result['third']= $v['third'];
                        $result['fourth']= $v['fourth'];
                        $log->logDebug($result);
                  }
                }

                return $result;
        }else{
                return false;
        }
 }



}


class User extends base{

 public $id;
 public $username;
 public $password;
 public $name;
 public $surname;
 public $tel;
 public $mobile;
 public $email;
 public $email2;
 public $address;
 public $tesseraCasale; // number for the tessera
 public $entrance_fee; // quota d'ingresso
 public $subscription_date; // data di iscrizione

 public $role; // role class 
 public $status; // another class of status
 public $donation; // another class for the donationType 

 private $_isAdmin; 

 public function __construct($db, $log, $id = null)  {  
	$this->log = $log;
//	$msg = "The class '". __CLASS__. "' was initiated!";
       // $this->log->LogInfo($msg); 
	$this->_db = $db;
	if($id){$this->loadInfo($id);}
 } 

 public function loadInfo($id){
	// query database
	if($id) {
		$q = "SELECT * FROM user where id=$id ORDER BY name";
	}else{
		$q = "SELECT * FROM user  ORDER BY name";
	}
	$this->log->LogInfo($q); 
	$a = $this->_db->fetch_all_array($q);
	
	if (!empty($a)) {
	  foreach ($a as $k => $v) {
		$this->id = $v['id'];
		$this->name = $v['name'];
	  	$this->surname = $v['surname'];
	  	$this->username = $v['username'];
	  	$this->password = $v['password'];
	  	$this->tel = $v['tel'];
	  	$this->mobile = $v['mobile'];
	  	$this->email = $v['email'];
	  	$this->email2 = $v['email2'];
	 
	 	$this->address = $v['address'];
		$this->tesseraCasale = $v['tesseraCasale']; // number for the tessera
	 	$this->entrance_fee =  $v['entrance_fee']; // quota d'ingresso
	 	
	 	$this->status = new userStatus($this->_db, $this->log, $v['status_id']); // another class of status
	 	$this->donation = new donationType($this->_db, $this->log, $v['donation_type_id']); // anothr class for the donation 
	 	$this->role = new role($this->_db, $this->log, $v['role_id']); // another class for the role
 		$this->subscription_date = $v['subscription_date']; // data di iscrizione

		$this->_isAdmin = $v['role_id'];
	  }

 	}
 }


 public function isAdmin(){
	if($this->_isAdmin == 1){return true;}
	else{ return false;}
 }


 public function newUser($username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $subscription_date, $role_id){

	if(!$subscription_date ){ $subscription_date = date('Y-m-d');}
 	$q = sprintf("INSERT INTO user (username, password, name, surname, tel, 
	mobile, email, email2, address, tesseraCasale, entrance_fee, status_id, donation_type_id, subscription_date, role_id) 	
	values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %f, %d, %d, '%s', %d)", 
	$username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $subscription_date, $role_id);

	$this->log->LogDebug("User: adding user $username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $role_id ");
	if($this->_db->query($q)){
		$this->log->LogDebug("User: added user $name ");
		$this->loadInfo($this->_db->last_id());
		// adding a new record for the donation
		$dPaied = new DonationPaied($this->_db, $this->log);
      		$dPaied->newDonation($this->id, 0,0,0,0);


		return $this->_db->last_id();
	}else{
		return false;
	}

}

 public function updateUser($name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $subscription_date){
	if($this->id){	
		$q = sprintf("update user set name='%s', surname='%s', tel='%s', mobile='%s', email='%s', email2='%s', address='%s', tesseraCasale='%s', entrance_fee=%f, status_id=%d, donation_type_id=%d, subscription_date='%s' where id=%d", $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $subscription_date, $this->id);
		
		$this->log->LogDebug("updateUser: $name");
		$this->_db->query($q);
		$this->loadInfo($this->id);
		return true;
	}else{
		return false;
	}
}

 public static function listUser($db, $log){
        $result= array();

        if($db) {
                $q = "SELECT * FROM user order by surname";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new User($db, $log, $v['id']);
                $log->logDebug($result);
          }
        }
        return $result;
 }

 public static function usernameAlreadyUsed($db, $log, $username){

        if($db) {
                $q = sprintf("SELECT * FROM user WHERE username='%s'", $username);
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
		return true;
        }else {
		return false;
	}
 }

 public static function emailAlreadyUsed($db, $log, $email){

        if($db) {
                $q = sprintf("SELECT * FROM user WHERE email='%s'", $email);
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
                return true;
        }else {
                return false;
        }
 }



 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.<br />'; 
 }

}


class productCategory extends base{
 
 public $id;
 public $name;
 public $description;



 public function __construct($db, $log, $id = null)  {
	$this->log = $log;
//        $this->log->logInfo('The class "'. __CLASS__. '" was initiated!');
	$this->_db = $db;
	if($id){ $this->loadInfo($id);}
 }

 public function loadInfo($id){
        // query database
        if($id) {
                $q = "SELECT * FROM product_category where id='$id' ORDER BY name";
	        $a = $this->_db->fetch_all_array($q);
	        if (!empty($a)) {
	          foreach ($a as $k => $v) {
	        	$this->id = $v['id'];
		        $this->name = $v['name'];
		        $this->description = $v['description'];
			
		   }
		}
	}
 }
 
 public function newCategory($name, $description, $orderby = 0){
        $q = sprintf("INSERT INTO product_category (name, description, orderby) values ('%s', '%s', %d)", $name, addslashes($description), $orderby);
        if($this->_db->query($q)) {
		$this->loadInfo($this->_db->last_id());
		return $this->_db->last_id();
	}else{
		return false;
	}
}

 public function update($name, $description){

        $q = sprintf("update product_category set name='%s', description='%s' where id=%d",
        $name, addslashes($description), $this->id);
        $this->log->LogDebug("my sql string: $q");
        if($this->_db->query($q)) {
		$this->loadInfo($id);
		return true;
	}else{
		return false;
	}

}

 public static function listCategory($db, $log){
        $result = array();

        if($db) {
                $q = "SELECT * FROM product_category ORDER BY orderby";
        }
        $a = $db->fetch_all_array($q);

  	if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new productCategory($db, $log, $v['id']);
		$log->logDebug("Log ListCategory");
      //          $log->logDebug($result);
          }
        }
        return $result;
 }

 public static function categoryAlreadyExists($db, $log, $name){

        if($db) {
                $q = sprintf("SELECT * FROM product_category WHERE name='%s'", addslashes($name));
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
                return true;
        }else {
                return false;
        }
 }




} // end Category



class Product extends base{ 

 public $id;
 public $name;
 public $category; //another class for category
 public $price;
 public $unitprice; // if true (1) the product have a unit price otherwise not
 public $disable;
 public $description;
 

 public function __construct($db, $log, $id = null)  {  
	$this->log = $log;
       // $this->log->logInfo( 'The class "'. __CLASS__. '" was initiated!'); 
	$this->_db = $db;
 	if($id){$this->loadInfo($id);}    
 } 

 public function loadInfo($id){
	// query database
	if($id) {
		$q = "SELECT * FROM product where id=$id ORDER BY name";
		$a = $this->_db->fetch_all_array($q);
		
		if (!empty($a)) {
		  foreach ($a as $k => $v) {
			$this->id = $v['id'];
			$this->name = $v['name'];
			$this->price = $v['price'];
			$this->unitprice = $v['unitprice'];
			$this->category = new productCategory($this->_db, $this->log,$v['category_id']);
	 		$this->description = $v['description'];
			$this->disable = $v['disable'];
	  	  }

 		}
	}else{
		return false;
	}
}

 public function newProduct($name, $description, $category_id, $price, $disable = 0, $unitprice = 1){
	$q = sprintf("INSERT INTO product (name, description, category_id , price, disable, unitprice) 
	values ('%s', '%s', %d, %f, %d, %d)", 
	$name, addslashes($description), $category_id, $price, $disable, $unitprice);
	
	$this->log->logDebug("newProduct: $q");
	if($this->_db->query($q)){
	 	$this->loadInfo($this->_db->last_id());
		return $this->id;
	}else{
		return false;
	}
}

 public function update($name, $description, $category_id, $price, $disable, $unitprice){
	$q = sprintf("update product set name='%s', description='%s', category_id=%d , price=%f, disable=%d , unitprice=%d where id=%d", 
	$name, addslashes($description), $category_id, "$price", $disable, $unitprice, $this->id);
	$this->log->logDebug("updateProduct: $q");
	if($this->_db->query($q)){
	  	$this->loadInfo($this->_db->last_id());
		return $this->id;
	}else{
		return false;
	}
 } 

 public function disable($disable){
        $q = sprintf("update product set disable='%d' where id=%d", $disable, $this->id);
        $this->log->logDebug("Disable product $id"); 
        $this->_db->query($q);
	$this->disable = $disable;
 }

 public static function listActiveProduct($db, $log){
	return Product::listProducts($db, $log, 0, 1);
 }

 public static function listProducts($db, $log, $active = null, $unitprice = null){
        $result= array();

        if($db) {
                $q = "SELECT * FROM product ";
		$where = "WHERE ";
		if(!is_null($active ) ){
			$where .= "disable=$active and ";
		}
		if(!is_null($unitprice ) ){
			$where .= "unitprice=$unitprice and ";
		}
		if(strlen($where) > 7){
			$q .= substr($where,0, strlen($where)-4);
		}
        }
        $log->logDebug("ListProducts: $q");
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new Product($db, $log, $v['id']);
       //         $log->logDebug($result);
          }
        }
        return $result;
 }

 public static function listProductsByCategory($db, $log, $category, $disable=null){
        $result= array();

        if($db) {
                $q = "SELECT p.id as id FROM product p JOIN product_category c on p.category_id=c.id WHERE c.id=$category ";
                if(!is_null($disable) ){
                        $q .= " and disable=$disable ";
                }
		$q .= " ORDER BY orderby";
        }
        $log->logDebug("ListProducts: $q");
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new Product($db, $log, $v['id']);
                $log->logDebug("listProductsByCategory $k");
//                $log->logDebug($result);
          }
        }
        return $result;
 }


 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.<br />'; 
 }

}

class booking extends base{

 private $id;
 public $user_booking_id; // User Booking id
 public $product_id; // class product
 public $quantity;
 public $tot_price;


 public function __construct($db, $log, $id = null)  {
        $this->log = $log;
	// $this->log->logInfo( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
        if($id){$this->loadInfo($id);}
 }

 public function loadInfo($id){
        // query database
        if($id) {
                $q = "SELECT * FROM booking where id=$id";
                $a = $this->_db->fetch_all_array($q);

                if (!empty($a)) {
                  foreach ($a as $k => $v) {
                        $this->id = $v['id'];
                        $this->user_booking_id = $v['user_booking_id'];
                        $this->product_id = new Product($this->_db, $this->log, $v['product_id']);
                        $this->quantity = $v['quantity'];
                        $this->tot_price = $v['tot_price'];
                  }

                }
		return $this->id;
        }else{
                return false;
        }
 }

 public function newBooking($user_booking_id, $item){
	//$user_id, $pickup_date_id, $product_id, $quantity, $tot_price){
 
	$q = sprintf("INSERT INTO booking (user_booking_id, product_id, quantity, tot_price) values (%d, %d, %d, %f)", 
	$user_booking_id, $item['product_id'], $item['quantity'], $item['tot_price']);

        $this->log->logDebug("newBooking: $q");
        if($this->_db->query($q)){
	        $this->loadInfo($this->_db->last_id());
		return $this->id;
	}else{
		return false;
	}

 }

 public function update($user_booking_id, $item){ 
	$q = sprintf("update booking set user_booking_id=%d, product_id=%d, quantity=%d, tot_price=%f where id=%d",
	$user_booking_id, $item['product_id'], $item['quantity'], $item['tot_price'] , $this->id);
	$this->log->logDebug("updateBooking: $q");
	if($this->_db->query($q)){
	        $this->loadInfo($this->_db->last_id());
		return $this->id;
	}else{
		return false;
	}
 }

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.';
 }
 

}



class bookingList extends base{

 public $booking_list; // a list of booking for the same user
 public $user; // the user information
 public $totalCost;

 protected function clean(){
	unset($booking_list);
	unset($user);
	unset($totalCost);
 }
 
 public function __construct($db, $log, $user_id = null, $booking_date_id = null, $pickup_date_id = null)  {
        $this->log = $log;
//	$this->log->logDebug( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if($user_id && ($booking_date_id || $pickup_date_id)){$this->loadInfo($user_id, $booking_date_id, $pickup_date_id);}
 }

 public function loadInfo($user_id, $booking_date_id, $pickup_date_id){
       
	$this->clean(); 
	// query database
	// tutte le prenotazioni fatte da un utente in una data precisa
	// praticamente è come fare il filtro del foglio prenotazioni fissando la data di prenotazione e l'utente
        if($user_id && $booking_date_id) {
                $q = "SELECT user_id, b.id as b_id, b.tot_price as price
		FROM user as u 
		JOIN booking as b on b.user_id=u.id 
		WHERE u.id=$user_id and b.booking_date_id=$booking_date_id";

		$this->log->LogDebug("UserBooking loadInfo: $q");
                $a = $this->_db->fetch_all_array($q);

		$this->totalCost=0;
                if (!empty($a)) {
                  foreach ($a as $k => $v) {
			if(!$this->user){ $this->user = new User($this->_db, $this->log, $v['user_id'] );}
                        $this->booking_list[] = new booking($this->_db, $this->log, $v['b_id']);
			$this->totalCost += $v['price'];
                  }

			return true;
                }
	// tutte le prenotazioni fatte da un utente PER una data precisa
	// praticamente è come fare il filtro del foglio prenotazioni fissando la data di ritiro e l'utente
        }elseif($user_id && $pickup_date_id) {
                $q = "SELECT user_id, b.id as b_id, b.tot_price as price
                FROM user as u 
                JOIN booking as b on b.user_id=u.id 
                WHERE u.id=$user_id and b.pickup_date_id=$pickup_date_id";

		$this->log->LogDebug("UserBooking loadInfo: $q");
                $a = $this->_db->fetch_all_array($q);

                $this->totalCost=0;
                if (!empty($a)) {
                  foreach ($a as $k => $v) {
                        if(!$this->user){ $this->user = new User($this->_db, $this->log, $v['user_id'] );}
                        $this->booking_list[] = new booking($this->_db, $this->log, $v['b_id']);
                        $this->totalCost += $v['price'];
                  }
		return true;
                }
 
        }else {
			return false;
	}

 }

 public static function listBookings($db, $log, $userId = null, $bookingDateId = null, $pickupDateId= null){
        $result= array();

        if($db) {
                $q = "SELECT * FROM user_booking "; 
                
		if(!is_null($userId ) || !is_null($bookingDateId) || !is_null($pickupDateId) ){
                        $q .= "WHERE ";
	                if(!is_null($userId )){
				$q .= "user_id=$userId and ";
			}
  			if(!is_null($booingDateId )){
                                $q .= "booking_date_id=$bookingDateId and ";
                        }
			if(!is_null($pickupDateId )){
                                $q .= "pickup_date_id=$pickupDateId and ";
                        }
			$q = substr($q, 0, strlen($q)-4);
                }
		
		$q .= " GROUP BY user_id, booking_date_id, pickup_date_id ORDER by booking_date_id, pickup_date_id,user_id";
	
        }
        $log->logDebug("ListBooking: $q");
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new userBooking($db, $log, $v['id']);
          }
                $log->logDebug($result);
        }
        return $result;
 }

/*
 public function newUserBooking($booking_list){	
	if($booking_list && count($booking_list)){
		$this->clean(); 
		
                $this->totalCost=0;
		foreach ( $booking_list as $b){
			if(!$this->user){
				$this->user = new User($this->_db, $this->log, $b['user_id']);
			}
			$myBookingItem = new booking($this->_db, $this->log);
			$myBookingItem->newBooking($b['booking_date_id'], $b['user_id'], $b['pickup_date_id'], $b['product_id'], $b['quantity'], $b['tot_price']);
			$this->booking_list[] = $myBookingItem;
			
		 	$this->totalCost += $b['tot_price'];

		}		
 	}else{
		return false;
	}
}
*/

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.';
 }
 

}



class userBooking extends base{

 public $id;
 public $user; //class of user
 public $timestamp;
 public $booking_date_id; // class of Calendar
 public $pickup_date_id; // Calss of Calendar
 public $owed;
 public $paied;  
 public $changeback;  
 public $total_cache;  
 public $debit_credit;

 public $listBooking; // array of booking class

 public function __construct($db, $log, $id = null)  {
        $this->log = $log;
	//$this->log->logInfo( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if(!is_null($id)){$this->loadInfo($id);}
 }

 public function loadInfo($id){
       
        // query database
        if($id) {
		//$q = "SELECT *, ub.id as ubid, b.id as bid  FROM user_booking ub JOIN booking b on b.user_booking_id=ub.id WHERE ub.id=$id";
		$q = "SELECT * FROM user_booking WHERE id=$id";
		$this->log->logDebug("LoadInfo UserBooking: $q");
                $a = $this->_db->fetch_all_array($q);

                if (!empty($a)) {
		$count=0;
		$listBooking = array();
                  foreach ($a as $k => $v) {
                        if(!$count++){
		                $this->log->logDebug("Count vale $count. Dentro il  foreach");

				$this->id = $v['id'];
				$this->user = new User($this->_db, $this->log, $v['user_id']);
				$this->timestamp = $v['timestamp'];
 				$this->booking_date_id = new calendar ($this->_db, $this->log, $v['booking_date_id']);
 				$this->pickup_date_id = new calendar ($this->_db, $this->log, $v['pickup_date_id']);
				$this->owed = $v['owed'];
				$this->paied = $v['paied'];
				$this->changeback = $v['changeback'];
				$this->total_cache= $v['total_cache'];
				$this->debit_credit = $v['debit_credit'];
			}
			

                  }
		
		$this->loadBooking();
#		$this->log->logDebug("Aridump delle prenotazioni dell'utente ");
#		foreach($listBooking as $book){		$this->log->logDebug($book); }
#
                }
		
		return true;
        }else{ 
                return false;
        }
 }

 public function loadBooking(){
                $q = sprintf("SELECT b.id as bId FROM user_booking ub JOIN booking as b on b.user_booking_id=ub.id WHERE ub.id=%d",$this->id);
		$this->log->logDebug("UserBooking -> loadBooking: $q");
                $a = $this->_db->fetch_all_array($q);

                if (!empty($a)) {
                $count=0;
                $this->listBooking = array();
                  foreach ($a as $k => $v) {
			$mybook = new booking($this->_db, $this->log, $v['bId']);                  
		        $this->listBooking[$mybook->product_id->id] = $mybook;
                  }

                }

                return $listBooking;
 }
 
 public function addItems($itemsList){

	foreach($itemsList as $item){
		$this->log->LogDebug($item);
		$booking = new booking($this->_db, $this->log);
		$booking->newBooking($this->id, $item);
		$this->listBooking[] = $booking;
	}
	
	return true;
 }

 protected function deleteItems(){


        $q = sprintf("DELETE from booking WHERE user_booking_id=%d", $this->id);

        $this->log->logDebug("deleteItems: $q");
	if($this->_db->query($q)){
		return true;
	}else{
		return false;
	}
 }

 public function updateItems($itemsList){

	//first delete old booking
	$this->deleteItems();
	// then add new booking
        foreach($itemsList as $item){
                $this->log->LogDebug($item);
                $booking = new booking($this->_db, $this->log);
                $booking->newBooking($this->id, $item);
                $this->listBooking[] = $booking;
        }
	return true;
 }
 
 public function newUserBooking($user_id, $booking_date_id, $pickup_date_id, $owed, $paied, $changeback, $total_cache, $debitCredit){
	
	 
//	if(!$debitCredit){ $debitCredit = $payed - $owed;}
	$q = sprintf("INSERT INTO user_booking (user_id, booking_date_id, pickup_date_id, owed, paied, changeback, total_cache, debit_credit) values (%d, %d, %d, %f, %f, %f, %f, %f)",
        $user_id, $booking_date_id, $pickup_date_id, $owed, $paied, $changeback, $total_cache, $debitCredit);

        $this->log->logDebug("newUserBooking: $q");
        $this->_db->query($q);
        $this->loadInfo($this->_db->last_id());


	return $this->id;
}

 public function update($user_id, $booking_date_id, $pickup_date_id, $owed, $paied, $changeback, $total_cache, $debitCredit){
	$this->log->logDebug("userBooking -> Update params: $user_id, $booking_date_id, $pickup_date_id, $owed, $paied, $changeback, $total_cache, $debitCredit");
       if($this->id){
                $q = sprintf("update user_booking set user_id=%d, booking_date_id=%d, pickup_date_id=%d, owed=%f, paied=%f, changeback=%f, total_cache=%f, debit_credit=%f where id=%d",
                $user_id, $booking_date_id, $pickup_date_id, $owed, $paied, $changeback, $total_cache, $debitCredit, $this->id);
                $this->log->logDebug("userBooking -> Update $q");
                $this->_db->query($q);
                $this->loadInfo($this->id);
		return true;
        }else{
                return false;
        }
 }

 public function getSumProduct($db, $log){
        $result= array();

        if($db) {
                $q = "SELECT select ub.user_id, c.name as catName, c.id as catId , sum(tot_price) as sum FROM user_booking ub join booking b on ub.id=b.user_booking_id join product p on p.id=b.product_id join product_category c on c.id=p.category_id where ub.id=$this->id group by c.id order by c.id ;
";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new User($db, $log, $v['id']);
                $log->logDebug($result);
          }
        }
        return $result;
 }

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.';
 }
 

}




?>

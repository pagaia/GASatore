<?php

class base{
 protected $_db;

 public function stampa(){
  echo var_dump($this);
 }

 public static function log($msg){
  $time = date("Y-m-d h:i:s -");
  if(is_array($msg)){ echo "$time ". json_encode($msg)."\n";}
	else{echo "$time ".$msg."\n";}
 }
}

class role extends base{
 public $id; 
 public $name;
 public $description;


 public function __construct($db, $id = null)  {
        role::log( 'The class "'. __CLASS__. '" was initiated!');
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

 public static function listRole($db){
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
		base::log($result);
          }
        }
	return $result;
 }
}
 


class userStatus extends base{
 public $id;
 public $status;
 public $description;


 public function __construct($db, $id = null)  {
        base::log ('The class "'. __CLASS__. '" was initiated!');
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

 public static function listUserStatus($db){
        $result= array();

        if($db) {
                $q = "SELECT * FROM user_status";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result['id']= $v['id'];
                $result['status'] = $v['status'];
                $result['description'] = $v['description'];
                base::log($result);
          }
        }
        return $result;
 }


}

class donationType extends base{
 public $id;
 public $type;


 public function __construct($db, $id = null)  {
        base::log ('The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
	if($id){ $this->loadInfo($id);}
 }

 public function loadInfo($id){
   // query database
        if($id) {
                $q = "SELECT * FROM donation_type where id=$id ORDER BY id";
        }
        $a = $this->_db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $this->id = $v['id'];
                $this->type = $v['type'];
          }

        }

 }

 public static function listDonationType($db){
        $result= array();

        if($db) {
                $q = "SELECT * FROM donation_type";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result['id']= $v['id'];
                $result['type'] = $v['type'];
                base::log($result);
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


 public function __construct($db, $id = null)  {
        base::log( 'The class "'. __CLASS__. '" was initiated!');
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
                $this->type = new donationType($this->_db,$v['type_id']);
                $this->amount = $v['amount'];
          }

        }

 }

 public static function listDonation($db){
        $result= array();

        if($db) {
                $q = "SELECT * FROM donation";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result['id']= $v['id'];
                $result['name'] = $v['name'];
                $result['type_id'] = $v['type_id'];
                $result['amount'] = $v['amount'];
                base::log($result);
          }
        }
        return $result;
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
 public $donation; // another class for the donation 
 


 public function __construct($db, $id = null)  {  
	$msg = "The class '". __CLASS__. "' was initiated!";
        base::log ($msg); 
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
	 	
	 	$this->status = new userStatus($this->_db, $v['status_id']); // another class of status
	 	$this->donation = new donation($this->_db, $v['donation_type_id']); // anothr class for the donation 
	 	$this->role = new role($this->_db, $v['role_id']); // another class for the role

	  }

 	}
 }





 public function newUser($username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $role_id){
 	$q = sprintf("INSERT INTO user (username, password, name, surname, tel, mobile, email, email2, address, tesseraCasale, entrance_fee, status_id, donation_type_id, role_id) 	values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %f, %d, %d, %d)", $username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $role_id);


	base::log("User: added user $name ");
	if($this->_db->query($q)){
		$this->loadInfo($this->_db->last_id());
		return $this->_db->last_id();
	}

}

 public function updateUser($username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $role_id){
	if($this->id){	
		$q = sprintf("update user set name='%s', surname='%s', username='%s', password='%s', tel='%s', mobile='%s', email='%s', email2='%s', address='%s', tesseraCasale='%s', entrance_fee=%f, status_id=%d, donation_type_id=%d, role_id=%d where id=%d", $username, $password, $name, $surname, $tel, $mobile, $email, $email2, $address, $tesseraCasale, $entrance_fee, $status_id, $donation_id, $role_id, $this->id);
		
		base::log("updateUser: $name");
		$this->_db->query($q);
	}else{
		return false;
	}
}

 public static function listUser($db){
        $result= array();

        if($db) {
                $q = "SELECT * FROM user";
        }
        $a = $db->fetch_all_array($q);

        if (!empty($a)) {
          foreach ($a as $k => $v) {
                $result[] = new User($db,$v['id']);
                base::log($result);
          }
        }
        return $result;
 }


 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.<br />'; 
 }

}


class productCategory extends base{
 
 public $id;
 public $name;
 public $description;



 public function __construct($db, $id = null)  {
        base::log('The class "'. __CLASS__. '" was initiated!');
	
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
 
 public function newCategory($name, $description){
        $q = sprintf("INSERT INTO product_category (name, description) values ('%s', '%s')", $name, $description);
        $this->_db->query($q);
	$this->loadInfo($this->_db->last_id());
}

 public function update($id,$name, $description){

        $q = sprintf("update product_category set name='%s', description='%s' where id=%d",
        $name, $description, $this->id);
        echo "my sql string: $q";
        $this->_db->query($q);
	$this->loadInfo($id);

}



} // end Category



class Product extends base{ 

 public $id;
 public $name;
 public $category; //another class for category
 public $price;
 public $disable;
 public $description;
 

 public function __construct($db, $id = null)  {  
         base::log( 'The class "'. __CLASS__. '" was initiated!'); 
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
			$this->category = new productCategory($v['category_id']);
	 		$this->description = $v['description'];
			$this->disable = $v['disable'];
	  	  }

 		}
	}else{
		return false;
	}
}

 public function newProduct($name, $description, $category_id, $price, $disable = 1){
	$q = sprintf("INSERT INTO product (name, description, category_id , price, disable) values ('%s', '%s', %d, %f, %d)", $name, $description, $category_id, $price, $disable);
	
	base::log("newProduct: $name, $description, $category_id, $price, $disable");
	$this->_db->query($q);
  	$this->loadInfo($this->_db->last_id());
}

 public function update($name, $description, $category_id, $price, $disable ){
	$q = sprintf("update product set name='%s', description='%s', category_id=%d , price=%f, disable=%d where id=%d", 
	$name, $description, $category_id, $price, $disable, $this->id);
	base::log("updateProduct: $name, $description, $category_id, $price, $disable");
	$this->_db->query($q);
  	$this->loadInfo($this->_db->last_id());
}

public function disable($disable){
        $q = sprintf("update product set disable='%d' where id=%d", $disable, $this->id);
        base::log("Disable product $id"); 
        $this->_db->query($q);
	$this->disable = $disable;
}

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.<br />'; 
 }

}

class booking extends base{

 private $id;
 public $booking_date_id;
 public $user_id; 
 public $pickup_date_id;
 public $product_id;
 public $quantity;
 public $tot_price;


 public function __construct($db, $id = null)  {
        base::log( 'The class "'. __CLASS__. '" was initiated!');
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
                        $this->booking_date_id = $v['booking_date_id'];
                        $this->user_id = $v['user_id'];
                        $this->pickup_date_id = $v['pickup_date_id'];
                        $this->product_id = $v['product_id'];
                        $this->quantity = $v['quantity'];
                        $this->tot_price = $v['tot_price'];
                  }

                }
        }else{
                return false;
        }
 }

 public function newBooking($booking_date_id, $user_id, $pickup_date_id, $product_id, $quantity, $tot_price){
 
	$q = sprintf("INSERT INTO booking (booking_date_id, user_id, pickup_date_id , product_id, quantity, tot_price) values (%d, %d, %d, %d, %d, %f)", 
	$booking_date_id, $user_id, $pickup_date_id, $product_id, $quantity, $tot_price);

        base::log("newBooking: $booking_date_id, $user_id, $pickup_date_id, $product_id, $quantity, $tot_price");
        $this->_db->query($q);
        $this->loadInfo($this->_db->last_id());

 }

 public function update($booking_date_id, $user_id, $pickup_date_id, $product_id, $tot_price ){
	if(!$this->$id){
	        $q = sprintf("update booking set booking_date_id=%d, user_id=%d, pickup_date_id=%d , product_id=%d, tot_price=%f where id=%d",
	        $booking_date_id, $user_id, $pickup_date_id, $product_id, $tot_price, $this->id);
	        base::log("updateBooking: $booking_date_id, $user_id, $pickup_date_id, $product_id, $tot_price");
	        $this->_db->query($q);
	        $this->loadInfo($this->_db->last_id());
	}else{
		return false;
	}
 }

 public function disable($disable){
        $q = sprintf("update product set disable='%d' where id=%d", $disable, $this->id);
        base::log("Disable product $id");
        $this->_db->query($q);
        $this->disable = $disable;
 }

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.';
 }
 

}



class userBooking extends base{

 public $booking_list; // a list of booking for the same user
 public $user; // the user information
 public $totalCost;

 protected function clean(){
	unset($booking_list);
	unset($user);
	unset( $totalCost);
 }
 
 public function __construct($db,$user_id = null, $booking_date_id = null, $pickup_date_id = null)  {
        base::log( 'The class "'. __CLASS__. '" was initiated!');
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
		WHERE u.id=$id and b.booking_date_id=$booking_date_id";

                $a = $this->_db->fetch_all_array($q);

		$this->totalCost=0.0;
                if (!empty($a)) {
                  foreach ($a as $k => $v) {
			if(!$this->user){ $this->user = new USer($this->_db, $v['user_id'] );}
                        $this->booking_list[] = new booking($this->_db,$v['b_id']);
			$this->totalCost += $v['price'];
                  }

                }
	// tutte le prenotazioni fatte da un utente PER una data precisa
	// praticamente è come fare il filtro del foglio prenotazioni fissando la data di ritiro e l'utente
        }elseif($user_id && $pickup_date_id) {
                $q = "SELECT user_id, b.id as b_id, b.tot_price as price
                FROM user as u 
                JOIN booking as b on b.user_id=u.id 
                WHERE u.id=$id and b.pickup_date_id=$pickup_date_id";

                $a = $this->_db->fetch_all_array($q);

                $this->totalCost=0.0;
                if (!empty($a)) {
                  foreach ($a as $k => $v) {
                        if(!$this->user){ $this->user = new USer($this->_db, $v['user_id'] );}
                        $this->booking_list[] = new booking($this->_db,$v['b_id']);
                        $this->totalCost += $v['price'];
                  }

                }
 
                return false;
        }
 }

 public function newUserBooking($booking_list){	
	if($booking_list && count($booking_list)){
		$this->clean(); 
		
                $this->totalCost=0.0;
		foreach ( $booking_list as $b){
			if(!$this->user){
				$this->user = new User($this->_db, $b['user_id']);
			}
			$myBookingItem = new booking($this->_db);
			$myBookingItem->newBooking($b['booking_date_id'], $b['user_id'], $b['pickup_date_id'], $b['product_id'], $b['quantity'], $b['tot_price']);
			$this->booking_list[] = $myBookingItem;
			
		 	$this->totalCost += $b['tot_price'];

		}		
 	}
}

 public function update($booking_date_id, $user_id, $pickup_date_id, $product_id, $quantity, $tot_price ){
        if(!$this->$id){
                $q = sprintf("update booking set booking_date_id=%d, user_id=%d, pickup_date_id=%d , product_id=%d, quantity=%d, tot_price=%f where id=%d",
                $booking_date_id, $user_id, $pickup_date_id, $product_id, $quantity, $tot_price, $this->id);
                base::log("updateBooking: $booking_date_id, $user_id, $pickup_date_id, $product_id, $quantity, $tot_price");
                $this->_db->query($q);
                $this->loadInfo($this->_db->last_id());
        }else{
                return false;
        }
 }

 public function disable($disable){
        $q = sprintf("update product set disable='%d' where id=%d", $disable, $this->id);
        base::log("Disable product $id");
        $this->_db->query($q);
        $this->disable = $disable;
 }

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.';
 }
 

}



class userPayment extends base{

 public $id;
 public $user;
 public $date;
 public $owed;
 public $payed;  
 public $debit_credit;

 public function __construct($db)  {
        base::log( 'The class "'. __CLASS__. '" was initiated!');
        $this->_db = $db;
//        if($user_id && ($booking_date_id || $pickup_date_id)){$this->loadInfo($user_id, $booking_date_id, $pickup_date_id);}
 }

 public function loadInfo($id){
       
        // query database
        if($id) {
                $q = "SELECT * FROM user_payment WHERE id=$id";

                $a = $this->_db->fetch_all_array($q);

                if (!empty($a)) {
                  foreach ($a as $k => $v) {
                        $this->user = new User($v['user_id']);
 			$this->date = $v['date'];
			$this->owed = $v['owed'];
			$this->payed = $v['payed'];
			$this->debit_credit = $v['debit_credit'];
                  }

                }
        }else{ 
                return false;
        }
 }

 public function newPayment($user_id, $date, $owed, $payed, $debitCredit = null){
 
	if(!$debitCredit){ $debitCredit = $payed - $owed;}
	$q = sprintf("INSERT INTO user_payment (user_id, date, owed, payed, debit_credit) values (%d, '%s', %f, %f, %f)",
        $user_id, $date, $owed, $payed, $debitCredit);

        base::log("newPayment: $user_id, $date, $owed, $payed, $debitCredit");
        $this->_db->query($q);
        $this->loadInfo($this->_db->last_id());


}

 public function update($user_id, $date, $owed, $payed, $debitCredit){
        if(!$this->$id){
                $q = sprintf("update user_payment set user_id=%d, date='%s', owed=%f, payed=%f, debiti_credit=%f where id=%d",
                $user_id, $date, $owed, $payed, $debitCredit, $this->id);
                base::log("updatePayment: $user_id, $date, $owed, $payed, $debitCredit, ".$this->id);
                $this->_db->query($q);
                $this->loadInfo($this->_db->last_id());
        }else{
                return false;
        }
 }

 public function __destructor (){
        echo 'The class "', __CLASS__, '" was destroyed.';
 }
 

}




?>

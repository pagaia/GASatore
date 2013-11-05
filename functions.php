<?php 


function log2($msg){
  $TIME = date("Y-m-d G:i:s");
  $myFile = "debug.log";
  $fh = fopen($myFile, 'a') or die("can't open file");
  if(is_array ($msg)){
        foreach ($msg as $key=>$value){
                fwrite($fh, "$value \n");
        }
  }else{
       fwrite($fh, "$TIME\t".$msg . " \n");
  }
  fclose($fh);
}


function getUserStatus($conn){
 	$result = array();
        $sql = "select * from user_status";

         log2(" getUserStatus: $sql");

        $rquery = mysql_query($sql, $conn);
        if (!$rquery) {
                 die('Could not query:' . mysql_error());
         }
		$count=0;
                while ($row = mysql_fetch_assoc($rquery)) {
                        $result[$count]['id'] = $row['id'];
                        $result[$count]['status'] = $row['status'];
			$count++;
                }

        return $result;

}

#this function add a new user on Database
#return TRUE if successful
#	FALSE if error	
function addUser($username, $password, $name, $surname, $email, $tel, $mobile, $address, $status, $tesseraCasale, $quota_ingresso, $date_subscription, $conn) {

        $result=TRUE;
        if(isset($username) && isset($name) && isset($surname) && isset($email) && (isset($mobile) || isset($tel))){
                // insert new gassista
                $sql = "INSERT INTO user (username,password,name,surname,email,tel,mobile,fax,address,status,tesseraCasale,quota_ingresso,date_subscription)
                            values ('$username','$password', '$name', '$surname', '$email', '$tel', '$mobile', '$address', '$status', '$tesseraCasale', $quota_ingresso, '$date_subscription' )";
                log2("AddUser: $sql");
                if (!mysql_query($sql,$conn)){
                         die('Error: ' . mysql_error());
                        $result=FALSE;
                }
        }

        return $result;

}


#this function return all users of the gas
function getUsers($conn){
  	$result = array();
        $sql = "SELECT user.*, user_status.status as sstatus
FROM user join user_status on user_status.id=user.status";

	 log2($sql);

        $rquery = mysql_query($sql, $conn);
        if (!$rquery) {
                 die('Could not query:' . mysql_error());
         }
                
                $count=0;
                while ($row = mysql_fetch_assoc($rquery)) {
                        $result[$count]['id'] = $row['id'];
                        $result[$count]['name'] = $row['name'];
                        $result[$count]['surname'] = $row['surname'];
                        $result[$count]['email'] = $row['email'];
                        $result[$count]['status'] = $row['sstatus'];
                      $count++;
                }

        return $result;

}


# This function return User details on Anagrafica 
# get in input
#       $uId: the user Id
#       $conn: the open connection for mysql
function getUserAnagrafica($uId, $conn){
   	$result = array();
        if($uId != ""){
 		$sql = "SELECT u.*, us.status as sstatus, us.id as status_id 
FROM user as u 
INNER JOIN user_status as us on us.id=u.status 
WHERE u.id=$uId
ORDER BY u.surname";
 	log2($sql);

                $rquery = mysql_query($sql, $conn);
                if (!$rquery) {
                       die('Could not query:' . mysql_error());
                }
	        
                while ($row = mysql_fetch_assoc($rquery)) {
                        $result['id'] = $row['id'];
                        $result['username'] = $row['username'];
                        $result['name'] = $row['name'];
			$result['surname'] = $row['surname'];
			$result['email'] = $row['email'];
			$result['tel'] = $row['tel'];
			$result['mobile'] = $row['mobile'];
			$result['address'] = $row['address'];
			$result['status'] = $row['sstatus'];
			$result['status_id'] = $row['status_id'];
			$result['tesseraCasale'] = $row['tesseraCasale'];
			$result['quota_ingresso'] = $row['quota_ingresso'];
			$result['date_subscription'] = $row['date_subscription'];
			break;
                }


        }
        return $result;

}

/*
#
# NEED TO BE CHECKED
#
#
#
# This function return a list of report submitted by a company
# get in input
#       $cId: the company Id
#       $pId: the project Id
#       $conn: the open connection for mysql
#function getReportByCompanyId($pId, $cId, $conn){
#        $result = array();
#        if($uId != ""){
#                $sql = "SELECT p.* FROM
#user as u
#INNER JOIN project_user_lk as lk on lk.user_id=u.id
#INNER JOIN project as p on p.id=lk.project_id
#WHERE u.id=$uId
#ORDER BY p.id";
#
#                $rquery = mysql_query($sql, $conn);
#                if (!$rquery) {
#                       die('Could not query:' . mysql_error());
#                }
#
#                $count=0;
#                while ($row = mysql_fetch_assoc($rquery)) {
#                        $result[$count]['id'] = $row['id'];
#                        $result[$count]['name'] = $row['name'];
#                      $count++;
#                }
#
#
#        }
#        return $result;
#
#}


# This function return a list of projects
# get in input
#       $conn: the open connection for mysql
function getProjects($conn){
        $result = array();
        $sql = "SELECT p.* FROM project as p ORDER BY p.id";

        $rquery = mysql_query($sql, $conn);
                if (!$rquery) {
                       die('Could not query:' . mysql_error());
                }

                $count=0;
                while ($row = mysql_fetch_assoc($rquery)) {
                        $result[$count]['id'] = $row['id'];
                        $result[$count]['name'] = $row['name'];
                      $count++;
                }


        return $result;

}


# This function return the name of the project
# get in input
#       $pId: the project Id 
#       $conn: the open connection for mysql
function getProjectById($pId, $conn){
        $result = array();
        if($pId != ""){
                $sql = "SELECT * FROM project WHERE id=$pId ORDER BY id";

                $rquery = mysql_query($sql, $conn);
                if (!$rquery) {
                       die('Could not query:' . mysql_error());
                }
                while ($row = mysql_fetch_assoc($rquery)) {
                        $result[$row['id']] = $row['name'];
                }

        }
        return $result;

}

*/

# This function return 1 if the user has the Admin role 0 otherwise
# get in input
#       $userId: the user Id
#       $conn: the open connection for mysql
function isAdmin($conn, $userId){
	$result=0;

	if(isset($userId)){ 
		$sql="SELECT * from user_role_lk as lk join role as r on r.id=lk.role_id where user_id=$userId and name='Admin'";

		$rquery = mysql_query($sql, $conn);
	        if (!$rquery) {
        	     die('Could not query:' . mysql_error());
	        }

		$num_rows = mysql_num_rows($rquery);
		if($num_rows == 1){
		        $result=1;
		}
	}else{
		log2("IsAdmin ERROR. The userId parameter is empty");
	}

        return $result;

	
}

/*
# This function return a list of insert and update made for the report for all companies
# get in input
#	$proId: the project Id
#       $conn: the open connection for mysql
function getAudit($proId,$conn){
 	$result = array();

	 if(isset($proId)){

		$sql = "SELECT c.short as company, p.period, u.name, u.surname, tstamp as time, operation FROM audit as a join period as p on p.id=a.period_id join user as u on u.id=a.user_id JOIN company as c ON c.id=u.company_id WHERE p.project_id=$proId ORDER BY time";
		$rquery = mysql_query($sql, $conn);
	        if (!$rquery) {
	             die('Could not query:' . mysql_error());
	        }
	        
		$count=0;
	        while ($row = mysql_fetch_assoc($rquery)) {
	               $result[$count]['company'] = $row['company'];
	               $result[$count]['period'] = $row['period'];
	               $result[$count]['name'] = $row['name'];
	               $result[$count]['surname'] = $row['surname'];
	               $result[$count]['time'] = $row['time'];
	               $result[$count]['operation'] = $row['operation'];
	               $count++;
	        }
	}

	return $result;

}


# This function insert the operation made for the period ( every period is match with one report)
# get in input
#       $user_id: user Id
#       $period_id: the id of the period
#	$operation: the operation made (INSERT, UPDATE)
#       $conn: the open connection for mysql
function audit($user_id,$period_id, $operation, $conn){
	$result=TRUE;
	if(isset($user_id) && isset($period_id)){
	  	// insert the link-table
        	$sql = "INSERT INTO audit(user_id, period_id, tstamp, operation )
                            values ($user_id,$period_id, NOW(), '$operation')";
		log2("Audit: $sql");
                if (!mysql_query($sql,$conn)){
                         die('Error: ' . mysql_error());
			$result=FALSE;
                }
	}

	return $result;

}


# This function return the name of the period
# get in input
#       $pId: the period Id
#       $conn: the open connection for mysql
function getPeriodById($pId, $conn){
        $result="";
        if($pId != ""){
                $sql = "SELECT period FROM period WHERE id=$pId";

                $rquery = mysql_query($sql, $conn);
                if (!$rquery) {
                       die('Could not query:' . mysql_error());
                }
                $row = mysql_fetch_row($rquery);

               $result = $row[0];

        }

       return $result;

}


# This function return the type of the effort ( HOURS of MONTH)
# get in input
#       $pId: the id of the project
#       $conn: the open connection for mysql
function getEffortType($pId, $conn){
	$result="";
        if($pId != ""){
                $sql = "SELECT t.type FROM project_effort_lk as lk join effort_type as t on t.id=lk.effort_type_id WHERE lk.project_id=$pId";

                $rquery = mysql_query($sql, $conn);
                if (!$rquery) {
                       die('Could not query:' . mysql_error());
                }
                $row = mysql_fetch_row($rquery);

               $result = $row[0];

        }

       return $result;

}


# This function return a list of user involved into the project passed by Id
# get in input
#       $pId: the id of the project
#       $conn: the open connection for mysql
function getUsersByProject($pId, $conn){

 	$result = array();
	if(isset($pId) && $pId != ""){
       		 $sql = "SELECT user.id, user.name, user.surname, email, c.short
FROM user JOIN project_user_lk lk on lk.user_id=user.id 
JOIN project p on p.id=lk.project_id 
JOIN company c on c.id=user.company_id
WHERE lk.project_id=$pId";
       		
log2("getUsersByProject: $sql");

	 	$rquery = mysql_query($sql, $conn);
       		 if (!$rquery) {
       		      die('Could not query:' . mysql_error());
       		 }

       		 $count=0;
       		 while ($row = mysql_fetch_assoc($rquery)) {
       		        $result[$count]['id'] = $row['id'];
       		        $result[$count]['name'] = $row['name'];
       		        $result[$count]['surname'] = $row['surname'];
       		        $result[$count]['email'] = $row['email'];
       		        $result[$count]['company'] = $row['short'];
       		        $count++;
       		 }
	}
        return $result;

}



# This function return a list of companies involved into the project passed by Id
# get in input
#       $pId: the id of the project
#       $conn: the open connection for mysql
function getCompaniesByProject($pId, $conn){

        $result = array();
        if(isset($pId) && $pId != ""){
                 $sql = "SELECT id, short FROM company join project_company_lk as lk on lk.company_id=id AND project_id=$pId ORDER BY id";

                $rquery = mysql_query($sql, $conn);
                 if (!$rquery) {
                      die('Could not query:' . mysql_error());
                 }
                 while ($row = mysql_fetch_assoc($rquery)) {
                        $result[$row['id']] = $row['short'];
                 }
        }
        return $result;

}

# This function return the company data  by company Id
# get in input
#       $cId: the company id 
#       $conn: the open connection for mysql
function getCompanyById($cId, $conn){
        $result = array();
        if(isset($cId) && $cId != ""){
                 $sql = "SELECT * FROM company WHERE id=$cId ORDER BY id";

                $rquery = mysql_query($sql, $conn);
                 if (!$rquery) {
                      die('Could not query:' . mysql_error());
                 }
 
		$row = mysql_fetch_assoc($rquery);
		$result['id'] = $row['id'];
		$result['name'] = $row['name'];
		$result['short'] = $row['short'];
		$result['address'] = $row['address'];
        }
        return $result;

}


# This function load the user data on SESSION variable
# get in input
#       $uId: the user Id
#       $conn: the open connection for mysql
function setUser($uId,$conn){


        if( isset($uId) && ($uId > 0) ){

                $strSQL = "SELECT  ut.id as user_id, ut.name, surname, ct.id as company_id, ct.name as company_name, ct.short as company_short, r.id as role_id
                        FROM user as ut
                        INNER JOIN company as ct ON ut.company_id=ct.id
                        INNER JOIN user_role_lk as lk ON lk.user_id=ut.id
                        INNER JOIN role as r ON r.id=lk.role_id
                        WHERE ut.id=$uId" ;

                $result  = mysql_query ($strSQL);
                $row = mysql_fetch_assoc($result);
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_surname'] = $row['surname'];
                $_SESSION['role_id'] = $row['role_id'];
                $_SESSION['company_id'] = $row['company_id'];
                $_SESSION['company_name'] = $row['company_name'];
                $_SESSION['company_short'] = $row['company_short'];

        }else{
                die('Error: Something was wrong on setUser function' );
        }

}


# This function let the admin user to become an other user like the linux su command
# get in input
#       $uId: the user Id
#       $adminId: the admin Id
#       $conn: the open connection for mysql
function setSuUser($uId,$adminId, $conn){


	if( isset($uId) && ($uId > 0) && isAdmin($conn, $adminId) ){
                // save the admin id
                $_SESSION['admin_id'] = $adminId ;
		setUser($uId,$conn);
        }else{
		die('Error: Something was wrong on su user function' );
	}

}

# This function load all data for the user in SESSION var
# get in input
#       $conn: the open connection for mysql
function exitSuUser($conn){

	setUser($_SESSION['admin_id'],$conn);

	// destroy the old admin Id
	unset($_SESSION['admin_id']);

}

# This function return a list of reports submitted by a company
# get in input
#       $pId: the project Id
#       $cId: the company Id
#       $conn: the open connection for mysql
function getReportsByCompany($pId,$cId, $conn){

        $result = array();
        if(isset($pId) && $pId != "" && isset($cId) && $cId != "" ){
		$sql = "SELECT r.id, p.period, 'effort' as type, submitted FROM report_effort as r inner join effort as e ON r.id=e.report_id join period as p on p.id=e.period_id where company_id=$cId AND p.project_id=$pId 
UNION 
SELECT  r.id, p.period, 'cost' as type, submitted FROM report_cost as r inner join cost as c ON r.id=c.report_id join period as p on p.id=c.period_id where company_id=$cId AND p.project_id=$pId ";
                
		 $rquery = mysql_query($sql, $conn);
                 if (!$rquery) {
                      die('Could not query:' . mysql_error());
                 }

                 $count=0;
                 while ($row = mysql_fetch_assoc($rquery)) {
                        $result[$count]['report_id'] = $row['id'];
                        $result[$count]['period'] = $row['period'];
                        $result[$count]['type'] = $row['type'];
                        $result[$count]['submitted'] = $row['submitted'];
                        $count++;
                 }
        }
        return $result;

}
*/
?>


<?php
ob_start();
/**
*  Common database class
**/

	// ** prevent attack, secure input
	function escapeInput($str) {
	  $str = (is_array($str)) ? $str : htmlentities($str, ENT_QUOTES, 'UTF-8');
	  $str = get_magic_quotes_gpc()?stripslashes($str):$str;
	  $str = (is_array($str)) ? $str : mysql_real_escape_string($str);
	  return $str;
	}
	// ** secure all POST and GET data
	function secureSuperGlobals() {
	        	// Escape POST data for SQL Injection
				foreach($_POST AS $key => $value) { $_POST[$key] = escapeInput($value); }
				// Escape GET data for SQL Injection
				foreach($_GET AS $key => $value) { $_GET[$key] = escapeInput($value); }
	}
	// ** build query
	function setQuery($args) {
		call_user_func_array('query', $args);
	}
	// ** execute query
	function query($query) {
		$args = func_get_args();
		if (count($args) > 1) {
			/* array_shift($args);
			$args = array_map('escapeInput', $args);
			array_unshift($args, $query); */
			$query = call_user_func_array('sprintf', $args);
		}
		//DeBUGGING
		//echo "SEND QUERY: $query\n";
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		return $result;
	}
	// ** retrieve a single row in query resultset as object
	function getRow($result = '', $query = null) {
		if ($query) {
			$args = func_get_args();
			$result = setQuery($args);
		}
		if ($result) {
			if ($row = mysql_fetch_assoc($result)) {
				return (object) $row;
			}
		}
		return false;
	}
	// ** retrieve an array of objects from query resultset
	function getRowList($result = '', $query = null) {
		if ($query) {
			$args = func_get_args();
			$result = setQuery($args);
		}
		if ($result) {
			$rows = array();
			while($row = mysql_fetch_assoc($result)) {
				$rows[] = (object) $row;
			}
			return $rows;
		} else {
			return false;
		}
	}
	// ** retrieve an array from query resultset
	function getRowListarray($result = '', $query = null) {
		if ($query) {
			$args = func_get_args();
			$result = setQuery($args);
		}
		if ($result) {
			$rows = array();
			$rows = mysql_fetch_assoc($result);
			return $rows;
		} else {
			return false;
		}
	}
	// ** Retrieve a single result
	function getResult($result = '', $query = null) {
		if ($query) {
			$args = func_get_args();
			$result = setQuery($args);
		}
		if ($result) {
			if ($row = mysql_fetch_row($result)) {
				return $row[0];
			}
		}
		return false;
	}
	// ** retrieve number of rows affected in last insert|update query
	function getAffectedRows($result) {
		return mysql_affected_rows($result);
	}
	// ** get the auto-increment column of the last insert
	function getInsertId($result) {
		return mysql_insert_id($result);
	}
	// ** retrieve number of rows affected in last select
	function getNumRows($result) {
		return mysql_num_rows($result);
	}
	

	function writeForm($table =''){
	// rather than recursively calling query, insert all rows with one query
		GLOBAL $general;
		$reservation_date = $_SESSION['selectedDate'];
		$recurring_date = $_SESSION['selectedDate'];
		$_SESSION['errors'] = array();
	// prepare POST data for storage in database:
	// $keys
	// $values 
	if($table) {
		$keys = array();
		$values = array();
		$i=1;
		
		// prepare arrays for database query
		foreach($_POST as $key => $value) {
			if ($key == 'saison_start_month' || $key == 'saison_start_day' || $key == 'saison_end_month' || $key == 'saison_end_day') {
				$saison_start = $_POST['saison_start_month'].$_POST['saison_start_day'];
				$saison_end = $_POST['saison_end_month'].$_POST['saison_end_day'];
			}else if($key == 'outlet_closeday'){
				$keys[$i] = $key;
				$values[$i] = "'".implode(',',$value)."'";
			}else if($key == 'password'){
				if($value != "EdituseR"){
					$keys[$i] = $key;
					$insert = new flexibleAccess();
					$password = $insert->hash_password($value);
					$values[$i] = "'".$password."'";
				}
			}else if( $key != "action"
				 && $key != "email_type"
				 && $key != "recurring_date"
				 && $key != "recurring_dbdate"
				 && $key != "password2"
				 && $key != "eventID"
				 && $key != "s_datepicker"
				 && $key != "MAX_FILE_SIZE"
				 && $key != "propertyID"
				 && $key != "token"
				 && $key != "verify"){
					$keys[$i] = $key;
					$values[$i] = "'".$value."'";
			}
			
			// remember some values
			if( $key == "reservation_date" ){
		    	$reservation_date = strtotime($value);
				$recurring_date = $reservation_date;
			}else if( $key == "recurring_dbdate" && $value !=''){
		    	$recurring_date = strtotime($value);
			}else if($key == 'repeat_id'){	
				$repeatid = "'".$value."'";
			}else if($key == 'reservation_booker_name'){	
				$_SESSION['author'] = $value;
			}else if($key == 'reservation_time'){	
				$_SESSION['reservation_time'] = "'".$value."'";
			}else if($key == 'reservation_pax'){	
					$_SESSION['reservation_pax'] = "'".$value."'";
			}
			$i++;
		}
		
		// img upload
		// ----------
		if ($_FILES['img']['error'] > 0){
		  $_SESSION['errors'][] = _sorry;
		}else{
			if (($_FILES['img']["type"] == "image/gif")
			  || ($_FILES['img']["type"] == "image/jpeg")
			  || ($_FILES['img']["type"] == "image/png" )
			  && ($_FILES['img']["size"] < 100000))
			  {
			  $imgName 	  = $_FILES['img']['name'];
			  $uploadpath = substr(dirname(__FILE__),0,-7);
			  $result     = move_uploaded_file($_FILES['img']["tmp_name"],"../uploads/img/".$imgName);
				$keys[$i] = 'img_filename';
				$values[$i] = "'".$imgName."'";
			  }else{
			  	$_SESSION['errors'][] = _sorry;
			  }
		}
		
			$_SESSION['reservation_date'] = date('Y-m-d',$reservation_date);
			$_SESSION['recurring_date'] = date('Y-m-d',$recurring_date);
		
		// outlets build start and enddate
		if($saison_start!='' && $saison_end!=''){
			$keys[] = 'saison_start';
	    	$values[] = "'".$saison_start."'";
			$keys[] = 'saison_end';
	    	$values[] = "'".$saison_end."'";
		}

		//
		// store in database
		//
		if ($table == 'reservations') {
			// clear old booking number
			$_SESSION['booking_number'] = '';
			// variables
			$res_pax = ($_POST['reservation_pax']) ? (int)$_POST['reservation_pax'] : 0;
			// memorize selected date
			$selectedDate = $_SESSION['selectedDate'];
			// res_dat is the beginning of circling through recurring dates 
			$res_dat = $reservation_date;
			
			// sanitize old booking numbers
			$clr = querySQL('sanitize_unique_id');
			
			// create and store booking number
			if (!$_POST['reservation_id'] || $_POST['reservation_id']=='') {
			    $_SESSION['booking_number'] = uniqueID();
			    $keys[] = 'reservation_bookingnumber';
			    $values[] = "'".$_SESSION['booking_number']."'";
			}
		    
			//store recurring reservation
			if ($recurring_date != $reservation_date){
				$repeatid = querySQL('res_repeat');
			 	$keys[] = 'repeat_id';
	    	 	$values[] = "'".$repeatid."'";
			}
			
			
			//
			// store the recurring reservation
			//	
		 while ( $res_dat <= $recurring_date) {
			// A reservation to store
			// enter in database
			// -----
			
			// bulid new reservation date
			$index = array_search('reservation_date',$keys);
			// build for availability calculation
			$_SESSION['selectedDate'] = date('Y-m-d',$res_dat);
			if($index){
				$values[$index] = "'".$_SESSION['selectedDate']."'";
			}
			$index = array_search('reservation_wait',$keys);
			if($index){
				$values[$index] = '1';
			}
			// get Pax by timeslot
			$resbyTime = reservationsByTime();
			// get availability by timeslot
			$occupancy = getAvailability($resbyTime,$general['timeintervall']);
			//cut both " ' " from reservation_pax
			$res_pax = substr($_SESSION['reservation_pax'], 0, -1);
			$res_pax = substr($_SESSION['reservation_pax'], 1);
			
			//Check availability
			$startvalue = $_SESSION['reservation_time'];
			$startvalue = substr($startvalue, 0, -1);
			$startvalue = substr($startvalue, 1);

			$leftspace = $_SESSION['outlet_max_capacity']-$occupancy[$startvalue];

			if( (int)$res_pax > $leftspace ){
				//stop double entry 	
				$index = array_search('reservation_wait',$keys);
				if($index>0){
					if ($values[$index] == '0') {
						$_SESSION['errors'][] = date($general['dateformat'],strtotime($_SESSION['selectedDate']))." "._wait_list;
					}				
					$values[$index] = '1';
				}else{
			 		$keys[] = 'reservation_wait';
	    	 		$values[] = '1';
					$_SESSION['errors'][] = date($general['dateformat'],strtotime($_SESSION['selectedDate']))." "._wait_list;	
				}
			}
			
			// number of database fields
			$max_keys = count($keys);
			// enter in database
			// -----
			$query = "INSERT INTO `$table` (".implode(',', $keys).") VALUES (".implode(',', $values).") ON DUPLICATE KEY UPDATE ";
			// Build 'on duplicate' query
			for ($i=1; $i <= $max_keys; $i++) {
				if($keys[$i]!=''){
			 		$query .= $keys[$i]."=".$values[$i].",";
				}else{
					$max_keys++;
				}
			}
			// run sql query 				
			$query = substr($query,0,-1);				   
			$result = query($query);
			$_SESSION['result'] = $result;

			// -----
			// increase reservation date
			$res_dat += (60*60*24);
		 } // end while
		
			// send email
			if ( $_POST['email_type'] != 'no' ) {
				include('classes/email.class.php');
			}
			
			// store changes in history
			$result = query("INSERT INTO `res_history` (reservation_id,author) VALUES ('%d','%s')",$_POST['reservation_id'],$_POST['reservation_booker_name']);
			
			// set back selected date
			$_SESSION['selectedDate'] = $selectedDate;
		}else{
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			// No reservations, everything else to store
			// enter in database
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		
			// number of database fields
			$max_keys = count($keys);
			$query = "INSERT INTO `$table` (".implode(',', $keys).") VALUES (".implode(',', $values).") ON DUPLICATE KEY UPDATE ";
				// Build 'on duplicate' query
				for ($i=1; $i <= $max_keys; $i++) {
					if($keys[$i]!=''){
				 		$query .= $keys[$i]."=".$values[$i].",";
					}else{
						$max_keys++;
					}
				} 
			// run sql query 				
			$query = substr($query,0,-1);
			    //DEbugging
			    //echo $query;				   
			$result = query($query);
			$new_id = mysql_insert_id();
			
			// Set STANDARD general settings for new outlet
			if ($table == 'properties' && $_POST['id']=='') {
			  $query = "INSERT INTO `settings` VALUES (NULL, $new_id, 'en_EN', 'Europe/Berlin', 24, 15, 'd.m.y', 'd.m.', 'dd.mm.yy', 'mySeat XT', 8, 120, 5, '', '', '')";
			  $result = query($query);
			}
			
			
			// -----
			return $new_id;
			
		}
	 }
	}

?>
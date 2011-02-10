<?php

// calculate and print select list with intervall times
function timeList($format,$intervall,$field='',$select,$open_time='00:00:00',$close_time='24:00:00',$showtime=0) 
{ 
		GLOBAL $availability, $tbl_availability;
		// calculate after midnight
		$day    = date("d");
		$endday = ($open_time < $close_time) ? date("d") : date("d")+1;
		$month  = date("m");
		$year   = date("Y");
		
		// init timeslots array
		$timeslots = array();
		
		// build list of timeslots from starttime to endtime
		// in predefined intervall
		list($h1,$m1)		= explode(":",$open_time);
		list($h2,$m2)		= explode(":",$close_time);
		$value  		= mktime($h1+0,$m1+0,0,$month,$day,$year);
		$endtime		= mktime($h2+0,$m2+0,0,$month,$endday,$year);
		$i 			= 1;
		
		echo"<select name='$field' id='$field' size='1' class='drop required' title=' ' >\n";
		echo "<option value='' ";
		if ($select=='') {
			echo "selected='selected'";
		}
		echo ">--</option>\n";
		while( $value <= $endtime )
		{ 
			// Generating the time drop down menu
				echo "<option value='".date('H:i',$value)."'";
				if ( $select == date('H:i:s',$value) ) {
					echo " selected='selected' ";
				}
				
				 $tbl_capacity = $_SESSION['outlet_max_tables']-$tbl_availability[date('H:i',$value)];
				 $pax_capacity = ($tbl_capacity >=1) ? $_SESSION['outlet_max_capacity']-$availability[date('H:i',$value)] : 0;
				 if ( $pax_capacity == 0 ) {
					echo " disabled='disabled' ";
				 }
				
				echo " >";
				
				$txt_value = ($format == 24) ? date('H:i',$value) : date("g:i a", $value);
				echo $txt_value;
				
				if ($showtime == 1) {
					echo " - ".$pax_capacity." Seats free";
				}
				echo"</option>\n";
			$value = mktime($h1+0,$m1+$i*$intervall,0,$month,$day,$year); 
			$i++;
		} 
		echo"</select>\n";
}

function outletList($outlet_id = 1, $disabled = 'enabled',$tablename='outlet_id'){
	echo"<select name='".$tablename."' id='".$tablename."' class='drop' size='1' $disabled>\n";
		
		$outlets = querySQL('db_outlets');
		
		foreach($outlets as $row) {
		 if ( ($row->saison_start<=$row->saison_end 
			 && $_SESSION['selectedDate_saison']>=$row->saison_start 
			 && $_SESSION['selectedDate_saison']<=$row->saison_end)
			&& $row->webform == 1 
			) {
				// get day off days
				$dayoff = getDayoff();
				
				 echo "<option value='".$row->outlet_id."' ";
				 echo ($outlet_id==$row->outlet_id && $dayoff==0) ? "selected='selected'" : "";
				 echo ($dayoff > 0) ? "disabled='disabled'" : "";
				 echo ">".$row->outlet_name."</option>\n";
				
			}
		}
	echo "</select>\n";
}

function personsList($max_pax = '12', $standard = '4',$tablename='reservation_pax'){
	echo"<select name='".$tablename."' id='".$tablename."' class='drop required' size='1' $disabled>\n";	
		
		for ($i=1; $i <= $max_pax; $i++) { 
			 echo "<option value='".$i."'";
			echo ($i == $standard) ? "selected='selected'" : "";
			echo ">".$i."</option>\n";
		}

	echo "</select>\n";
}

function titleList($title='',$disabled=''){
	        // translation
		GLOBAL $lang;
   
		echo "<select name='reservation_title' id='reservation_title' class='drop required' title=' ' size='1' $disabled>\n";

		// Empty
		echo "<option value='' ";
		echo ($title=="") ? "selected='selected'" : "";
		echo ">--</option>\n";
		// Sir
		echo "<option value='M' ";
		echo ($title=='M') ? "selected='selected'" : "";
		echo ">".$lang['_M_']."</option>\n";
		// Madam
		echo "<option value='W' ";
		echo ($title=='W') ? "selected='selected'" : "";
		echo ">".$lang['_W_']."</option>\n";
		// Family
		echo "<option value='F' ";
		echo ($title=='F') ? "selected='selected'" : "";
		echo ">".$lang['_F_']."</option>\n";
		// Company
		echo "<option value='C' ";
		echo ($title=='C') ? "selected='selected'" : "";
		echo ">".$lang['_C_']."</option>\n";
		
		echo "</select>\n";
}

function processBooking(){
// rather than recursively calling query, insert all rows with one query
	 GLOBAL $general;
	 // database table to store reservations
	 $table ='reservations';
	 // reservation date
	 $reservation_date = $_SESSION['selectedDate'];

	// prepare POST data for storage in database:
	// $keys
	// $values 
	if( $_POST['action'] == 'submit') {
		$keys = array();
		$values = array();
		$i=1;
		
		// prepare arrays for database query
		foreach($_POST as $key => $value) {
			if( $key != "action"
			      && $key != "dbdate"
			      && $key != "reservation_date"
			      && $key != "recurring_dbdate"
			      && $key != "captcha"
			      && $key != "barrier"
			      && $key != "reservation_author"
			      && $key != "email_type"
			      && $key != "captchaField1"
			      && $key != "captchaField2"
			      && $key != "captchaField3"){
			      	$keys[$i] = $key;
		     		$values[$i] = "'".$value."'";
			}
			// remember some values
			if( $key == "reservation_date" ){
			   $reservation_date = strtotime($value);
			}else if($key == 'reservation_booker_name'){	
			   $_SESSION['author'] = $value;
			}else if($key == 'reservation_time'){	
			   $_SESSION['reservation_time'] = "'".$value."'";
			}else if($key == 'reservation_pax'){	
			   $_SESSION['reservation_pax'] = "'".$value."'";
			}
			
			if( $key == "reservation_date" ){
			   $keys[$i] = $key;
		     	   $values[$i] = "'".$_SESSION['selectedDate']."'";
			}
			
			$i++;
		} // END foreach $_POST

		// =-=-=-=Store in database =-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			// clear old booking number
			$_SESSION['booking_number'] = '';
			// variables
			$res_pax = ($_POST['reservation_pax']) ? (int)$_POST['reservation_pax'] : 0;
			
			// sanitize old booking numbers
			$clr = querySQL('sanitize_unique_id');
			
			// create and store booking number
			if (!$_POST['reservation_id'] || $_POST['reservation_id']=='') {
			    $_SESSION['booking_number'] = uniqueBookingnumber();
			    //$_SESSION['messages'][] = _booknum.":&nbsp;&nbsp;' ".$_SESSION['booking_number']." '";
			    $keys[] = 'reservation_bookingnumber';
			    $values[] = "'".$_SESSION['booking_number']."'";
			}
			
		  // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		  // enter into database
		  // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			
			// build new reservation date
			$index = array_search('reservation_date',$keys);
			// build for availability calculation

			$index = array_search('reservation_wait',$keys);
			if($index){
				$values[$index] = '1';
				$waitlist = '1';
			}
			
			
			//Check Availability
			// =-=-=-=-=-=-=-=-=
			
			// get Pax by timeslot
			$resbyTime = reservationsByTime('pax');
			$tblbyTime = reservationsByTime('tbl');
			// get availability by timeslot
			$occupancy = getAvailability($resbyTime,$general['timeintervall']);
			$tbl_occupancy = getAvailability($tblbyTime,$general['timeintervall']);
			
			//cut both " ' " from reservation_pax
			$res_pax = substr($_SESSION['reservation_pax'], 0, -1);
			$res_pax = substr($_SESSION['reservation_pax'], 1);
			
			$startvalue = $_SESSION['reservation_time'];
			//cut both " ' " from reservation_time
			$startvalue = substr($startvalue, 0, -1);
			$startvalue = substr($startvalue, 1);
			
			  $val_capacity = $_SESSION['outlet_max_capacity']-$occupancy[$startvalue];
			  $tbl_capacity = $_SESSION['outlet_max_tables']-$tbl_occupancy[$startvalue]; 

			if( (int)$res_pax > $val_capacity || $tbl_capacity < 1 ){
				//prevent double entry 	
				$index = array_search('reservation_wait',$keys);
				if($index>0){			
					  $values[$index] = '1'; // = waitlist
					  $waitlist = '1';
				}else{
					  // error on new entry
					  $keys[] = 'reservation_wait';
					  $values[] = '1'; // = waitlist
					  $waitlist = '1';
				}
			}
			// END Availability

		  if ($waitlist != 1){
			// number of database fields
			$max_keys = count($keys);
			// enter into database
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
			
			// Reservation ID
	 		$resID = mysql_insert_id();
		
			// *** send confirmation email
			if ( $_POST['email_type'] != 'no' ) {
				include('../web/classes/email.class.php');
			}
			
			// store new reservation in history
			$result = query("INSERT INTO `res_history` (reservation_id,author) VALUES ('%d','%s')",$resID,$_SESSION['author']);
			// Reservation was done
			$waitlist = 2;
		  }	
			// reservation done, handle back waitlist status
			return $waitlist;
	 }
}
?>
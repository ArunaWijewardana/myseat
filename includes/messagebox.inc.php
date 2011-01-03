<?
$special_events = querySQL('event_data_day');
if ($special_events && $_SESSION['page'] == 2 ) {
	echo "<div class='alert_info'>
	<p style='margin-bottom:6px;'><img src='images/icon_info.png' alt='error' class='middle'/>";
		// special events
		foreach($special_events as $row) {
			echo "<strong>"._sp_events.": ".$row->subject."</strong><div style='margin-left:36px; font-size:0.9em; line-height:1.2em;'>".
			$row->description."<br/>".
			formatTime($row->start_time,$general['timeformat'])." - ".formatTime($row->end_time,$general['timeformat'])."<br/>".
			_ticket_price.": ".number_format($row->price,2)."<br/></div><br/>";
		}
	echo "</p></div>";
}

if (trim($maitre['maitre_comment_day']) != "" && $_SESSION['page'] == 2 ) {
	echo "<div class='alert_warning'>
	<p><img src='images/icon_info.png' alt='error' class='middle'/>";
		// maitre comment
		echo $maitre['maitre_comment_day']."<br>";
	echo "</p></div>";
	$maitre['maitre_comment_day'] = '';	
}

if (($_POST['action'] == 'save' || $_POST['action'] == 'save_set') && $resultQuery >= 1) {
	echo "<div id='messageBox'>";
	echo "<div class='alert_success'><p><img src='images/icons/icon_accept.png' alt='success' class='middle'/>". _new_entry ."</p></div></div>";
}else if ( ($_POST['action'] == 'save' || $_POST['action'] == 'save_set') && $resultQuery == 0 ) {
	echo "<div id='messageBox'>";
	echo "<div class='alert_error'><p><img src='images/icon_error.png' alt='error' class='middle'/>". _sorry ."</p></div></div>";	
}
if (($_POST['action'] == 'save' || $_POST['action'] == 'save_set') && count($_SESSION['errors']) >= 1) {
	echo "<div style='cursor:pointer;'>";
	echo "<div class='alert_error'>
	<p><img src='images/icon_error.png' alt='error' class='middle' />";
	foreach ($_SESSION['errors'] as $key => $value) {
		echo $value."<br>";
	}
	echo "</p></div></div>";	
}

if (count($_SESSION['messages']) >= 1) {
	echo "<div class='alert_warning'>
	<p><img src='images/icon_warning.png' alt='error' class='middle'/>";
	foreach ($_SESSION['messages'] as $key => $value) {
		echo $value."<br>";
	}
	echo "</p></div>";	
}

?>
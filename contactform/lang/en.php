<?php
	//LANGUAGE: ENGLISH

	// PLEASE USE HTML ENTITIES HERE !
	// e.g.: � = &ouml;

	//----------------------------
	// HEADER
	//----------------------------

	// The text before the list of the available language -- "View this page in"
	$lang["change_language"] = 'View this page in';

	// List the available languages sorted in an array, the keys are the slug names that correspond to each language file
	$lang["available_language"] = array(
		"en" => "English",
		"de" => "German"
	);

	// The contact information in the top-right of the page -- "www.openmyseat.com <br /> www.myseat.us"
	$lang["contact_info"] = 'www.openmyseat.com <br /> www.myseat.us';



	//----------------------------
	// CONTENT
	//----------------------------

	// The page title -- "Select your prefered restaurant"
	$lang["title"] = '<strong>Online</strong> Reservation';

	// A line of text before the contact form -- "<h3>Make an instant reservation now!</h3>"
	$lang["contact_form_intro"] = '<p><strong>Make an instant reservation now!
	<br/>For private parties, large bookings or all other queries please call us.</strong></p>';

	// Default text of the contact form -- "Name or Group Name"
	$lang["contact_form_name"] = 'Name or Group Name';

	// Default text of the contact form -- "E-mail address"
	$lang["contact_form_email"] = 'E-mail address';
	
	// Default text of the contact form -- "Security question"
	$lang["security_question"] = 'Security question';
	
	// Default text of the contact form -- "Advertise"
	$lang["contact_form_advertise"] = 'I would like to receive informations by email.';

	// Default text of the contact form -- "Notes"
	$lang["contact_form_notes"] = 'Reservation notes';

	// Default text of the contact form -- "Restaurant"
	$lang["contact_form_restaurant"] = 'Restaurant';

	// Default text of the contact form -- "Time"
	$lang["contact_form_time"] = 'Time';

	// Default text of the contact form -- "Phone"
	$lang["contact_form_phone"] = 'Phone';

	// Default text of the contact form -- "Number of persons"
	$lang["contact_form_pax"] = 'Number of persons';

	// Default text of the contact form -- "Title"
	$lang["contact_form_title"] = 'Title';

	// Default text for the 'captcha' field of the contact form -- "Security question"
	$lang["contact_form_captcha"] = 'Security question';

	// The 'Send' button -- "Book"
	$lang["contact_form_send"] = 'Book';

	// The 'Back' button -- "Back"
	$lang["contact_form_back"] = 'Back';

	// The 'Cancel' button -- "Cancel"
	$lang["contact_form_cxl"] = 'Cancel Reservation';

	// Message text -- "Booking number"
	$lang["book_num"] = 'Booking number';

	// The success message -- "Thank you for your reservation. An email confirmation was sent. Your Booking number is:"
	$lang["contact_form_success"] = 'Thank you for your reservation. An email confirmation was sent.<br/> Your Booking number is: ';

	// The full outlet message -- "An error occurred while booking, please try again."
	$lang["contact_form_full"] = 'The restaurant can\'t be booked for this date, please try another date.';

	// The failure message -- "An error occurred while booking, please try again."
	$lang["contact_form_fail"] = 'An error occurred while booking, please try again.';

	// The success message -- "Thank you for your reservation. An email confirmation was sent. Your Booking number is:"
	$lang["cxl_form_success"] = 'Your reservation has been canceled! Please visit us again!<br/>Feel free to contact us if you have any further questions or concerns.';

	//----------------------------
	// CONTACT FORM
	//----------------------------

	// The titles
	$lang["_M_"] = 'Mr.'; // Mr.
	$lang["_W_"] = 'Ms.'; // Mrs.
	$lang["_F_"] = 'Family'; // Family
	$lang["_C_"] = 'Group'; // Group

	//----------------------------
	// BOOKING
	//----------------------------

	// The emails subject -- "Reservation confirmation for"
	$lang["email_subject"] = 'Reservation confirmation for';

	// The page title -- "Reservation</strong> Process"
	$lang["conf_title"] = '<strong>Reservation</strong> Process';

	// The page title -- "Storno</strong> Cancel your reservation"
	$lang["cxl_title"] = '<strong>Cancel</strong> your reservation';

	// A subline of text I -- "Reservation progress for"
	$lang["conf_intro"] = 'Reservation progress for';

	// A subline of text -- "Directly clear your reservation."
	$lang["cxl_intro"] = 'To cancel your reservation, please enter your booking number and the email address the reservation was sent to.';

	// A subline of text II -- "at"
	$lang["_at_"] = 'at';

	// Day off error message
	$lang["error_dayoff"] = 'The restaurant can\'t be booked for this day.';

	//----------------------------
	// FOOTER
	//----------------------------

	// The content on the first footer column
	$lang["footer_one"] =  '<h3><a href="index.php">Place Reservation</a></h3>
	<p></p>';

	// The content on the second footer column
	$lang["footer_two"] =  '<h3><a href="cancel.php">Cancel your reservation</a></h3>
	<p></p>';

	// The content on the third footer column
	$lang["footer_three"] = '<h3><a href="'.$_SERVER['DOCUMENT_ROOT'].'">Back to Homepage</a></h3>
	<p></p>';

	//----------------------------
	// MINI-FOOTER
	//----------------------------

	// The copyright text, do not change! -- "<a href="#">Copyright &copy; 2010 mySeat</a>"
	$lang["minifooter_copyright"] = '&copy; 2010 by <a href="http://www.openmyseat.com">MYSEAT</a> under the GPL license';


?>
<?php session_start();

// ** SETTINGS **

	// The contact form color scheme
	// light, dark
	$default_style = "light";
	
	// The contact form color scheme
	// black, blue, green, grey, purple, red
	$default_color = "blue";
	
	// The link to your startpage
	// do not forget the slash!
	$base_link = $_SERVER['DOCUMENT_ROOT'];
	$home_link = $base_link."/index.php";

	// The default language
	$default_lang = "en";
	
// ** END SETTINGS **
	
	
	// The relative path to the lang folder
	$lang_folder = "lang";	
	
	//Get the language used by the browser
	$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$language = "";
	
	// Check if the language file exists
	function use_lang($language)
	{
		global $lang_folder;
		if( is_file($lang_folder."/".$language.".php") )
		{
			return true;
		}
	}	
	

	if( isset($_GET['lang']) && use_lang($_GET['lang']) )
	{
		$language = $_GET['lang'];
	}
	else if ( isset($browser_lang) && use_lang($browser_lang) && $_SESSION['lang'] == '' )
	{
		$language = $browser_lang;
	}
	else if( $_SESSION['lang'] == '' )
	{ 
		$language = $default_lang;
	}
	else if( $_SESSION['lang'] != '' )
	{ 
		$language = $_SESSION['lang'];
	}
	
	
	
	$_SESSION['lang'] = $language;
	
	// Include the right language file	
    include($lang_folder."/".$language.".php");
	
	// Helper function to echo the values of the $lang array
	function lang($key)
	{
		global $lang;
		echo $lang[$key];
	}
	
	function language_navigation()
	{
		global $lang;
		$languages = $lang["available_language"];
		foreach( $languages as $single_language )
		{
			echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?lang=' . key($languages) . '">'. $single_language . '</a></li>';
			next($languages);
		}
	}
?>
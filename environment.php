<?php
	if(! defined('ENVIRONMENT') )
	{
		$domain = strtolower($_SERVER['HTTP_HOST']);
		switch($domain) {
			case 'www.techfizone.com' : 			define('ENVIRONMENT', 'production'); 	break;
			case 'techfizone.com' : 			define('ENVIRONMENT', 'production'); 	break;
			case 'adminshopzone.herokuapp.com': 		define('ENVIRONMENT', 'staging'); 		break;
			default : 							define('ENVIRONMENT', 'development'); 	break;
		}
	}
?>
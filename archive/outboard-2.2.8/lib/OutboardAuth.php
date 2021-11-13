<?php

// OutboardAuth.php
//
// Performs authentication for the OutBoard
//
// 2020-09-15  richardf - Updated for PHP7.
// 2007-02-16  richarf	- Added custom time for cookies
// 2005-02-15  richardf - Converted to a class
// 2002-04-11  richardf - Changed to always check for basic auth
// 2001-06-11  Richard F. Feuerriegel (richardf@acesag.auburn.edu)

class OutboardAuth {

public function __construct() { }

// Checks for username using basic authentication (via Apache web 
// server variables)
public function checkBasic() {
	$headers = getallheaders();
	if (isset($headers['authorization'])) {
		$auth=$headers['authorization'];
	} elseif(isset($headers['Authorization'])) {
		$auth=$headers['Authorization'];
	}
	list($BAuthUser, $BAuthPass) = explode(":", base64_decode(substr($auth, 6)));
	if ($BAuthUser != "" and $BAuthPass != "") {
		return $BAuthUser;
	} else {
		return null;
	}
}

public function getSessionCookie() {
	if (! isset($_COOKIE['outboard_session'])) return false;
	return $_COOKIE['outboard_session'];
}

public function setSessionCookie($value = "", $time = "") {
	if ($time == 0) {
		setcookie("outboard_session",$value);
	} else {
		if ($time == "") { $time = 86400; }
		setcookie("outboard_session",$value,time()+$time);
	}
}

}

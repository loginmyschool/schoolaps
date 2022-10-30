<?
///
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 7200);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(7200);
session_start();
global $site;
include('wtosConfig.php'); // load configuration
include($site['application'].'wtTemplate.php');
//header("location:".$site['url-wtos']);


?>





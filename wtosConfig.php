<?php
ini_set('session.cookie_samesite', 'None');
date_default_timezone_set("Asia/Calcutta");
//DEFINE
define("WKHTMLTOPDF_BIN",realpath("/usr/local/bin/wkhtmltopdf"));
define("ANSWERS_PATH", realpath(__DIR__.'/answers/'));
define("CACHE_PATH", realpath(__DIR__.'/cache/'));

$site['base']=$_SERVER['DOCUMENT_ROOT'].'/';

$site['server']='https://'.$_SERVER['SERVER_NAME'].'/';

if(!in_array($_SERVER['SERVER_ADDR'],array('127.0.0.1','::1', '192.168.0.103')))
{
 // 	$wtSystemFolder='project/public_school/';
	// $site['host']='localhost';
	// $site['port']='3306';
	// $site['user']='u990995717_public_scl_usr';
	// $site['pass']='@^klgI|2';
 //    $site['db']='u990995717_public_scl_db';
 //    $site['socket_io_url'] = "https://loginmyschool.com:3000";
	$wtSystemFolder='';
	$site['host']='localhost';
	$site['port']='3306';
	$site['user']='u990995717_school_aps_usr';
	$site['pass']='u06QM?xL!';
    $site['db']='u990995717_school_aps';
    $site['socket_io_url'] = "https://loginmyschool.com:3000";
}
else
{
	$wtSystemFolder='madrasa/'; ## 'wtossystem/'
	$site['host']='localhost';
    $site['port']='3306';
	$site['user']='root';
	$site['pass']='root123';
	$site['db']='new_madrasa_db';
    $site['socket_io_url'] = "http://192.168.0.103:3000";
}





$site['folder']=$wtSystemFolder;


$site['application-folder']=$wtSystemFolder.'wtosApps/';# wtossystem/application/'

$site['library-folder']=$wtSystemFolder.'library/wtosLibrary/'; ##  'wtossystem/library/wtosLibrary/'

$site['uploadImage-folder']=$wtSystemFolder.'wtos-images/';## 'wtossystem/wtos-images/'

$site['admin-folder']=$wtSystemFolder.'wtos/';  // 'wtossystem/wtos/'

$site['global-property-folder']=$wtSystemFolder.'wtos/';

$site['plugin-folder']=$wtSystemFolder.'wtos/';





## non editable area

$site['root']=$site['base'].$site['folder'];

$site['root-wtos']=$site['base'].$site['admin-folder'];

$site['application']=$site['base'].$site['application-folder'];

$site['library']=$site['base'].$site['library-folder'];

$site['root-image']=$site['base'].$site['uploadImage-folder'];

$site['global-property']=$site['base'].$site['global-property-folder'];

$site['root-plugin']=$site['base'].$site['plugin-folder'];



$site['url-library']=$site['server'].$site['library-folder'];

$site['themePath']=$site['server'].$site['application-folder'];

$site['url']=$site['server'].$site['folder'];

$site['url-wtos']=$site['server'].$site['admin-folder'];

$site['url-image']=$site['server'].$site['uploadImage-folder'];

$site['url-plugin']=$site['server'].$site['plugin-folder'];

$site['loginKey']='wtos-'.$site['db'];

$site['loginKey-wtos']='wtos-'.$site['db'].'-wtos';

$site['environment']='-1'; // -1 development  // 0 production

$site['softwaremode']='demo'; // demo/live


const RAZORPAY_KEY_ID = 'rzp_live_p74y2nPqDHo8Lt';
const RAZORPAY_KEY_SECRET = 'Nha3SYhkO75GcZKEO7aeLxYG';
/*
const RAZORPAY_KEY_ID = 'rzp_test_4I4n3MrnPoonEU';
const RAZORPAY_KEY_SECRET = 'wrmIwfucozNVG0hjhyLuy3xx';
*/


function _d($var){echo '<pre>';print_r($var);echo '</pre>';}
// bridge//


 //include('wtosBridgeFunctions.php');


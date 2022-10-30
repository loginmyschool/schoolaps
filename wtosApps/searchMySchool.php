<?php 
session_start();
ob_start();
include('../wtosConfig.php'); // load configuration

$database_name='';
$databaseuser='';
$databasepass='';

if(isset($_GET['d'])) // data from school setup
 {
   $schooldata_enc=$_GET['d'];
   $schooldata=$bridge->dCode($schooldata_enc);
   $schooldata=unserialize($schooldata);
 
   
   $_SESSION['school_database_name']=$schooldata['school_database'];
   $_SESSION['databaseuser']=$schooldata['databaseuser'];
   $_SESSION['databasepass']=$schooldata['databasepass'];
   
   
 }


if(isset($_SESSION['school_database_name'])){
$database_name=$_SESSION['school_database_name'];
$databaseuser=$_SESSION['databaseuser'];
$databasepass=$_SESSION['databasepass'];


}



if($database_name==''){ echo 'SESSION EXPIRED. PLEASE LOGIN .';exit();}
else
{
	$site['db']=$database_name;
	if($databaseuser!=''){
	$site['user']=$databaseuser;
	}
	if($databasepass!=''){
	$site['pass']=$databasepass;
	}
	
	
	
	$site['loginKey']='wtos-'.$site['db'];
	$site['loginKey-wtos']='wtos-'.$site['db'].'-wtos';
	$site['main_website_login']=$site['server'].$bridge->site['portal-folder'];
	$site['root-portal']=$site['base'].$bridge->site['portal-folder'];
}


include('os.php'); // load wtos Library
ob_end_clean();
header("location:".$site['url']);



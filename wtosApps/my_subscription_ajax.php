<?
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?
if($os->get('set_subscription_id')=='OK'){
	if($os->post('subscription_id')>0){
		$_SESSION['paytm']['subscription_id']=$os->post('subscription_id');	
		echo "OK";	
	}
	else{
		echo "Something went wrong....";
	}
	exit();
}
if($os->get('download_pdf')=='OK'){
	if($os->post('subscription_id')>0){
		$_SESSION['paytm']['subscription_id']=$os->post('subscription_id');	
		echo "OK";	
	}
	else{
		echo "Something went wrong....";
	}
	exit();
}
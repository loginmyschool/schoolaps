<? 
if (session_id() === "") { session_start(); }
include('wtosConfigLocal.php');
error_reporting($site['environment']);
include($site['root-wtos'].'wtos.php');
 
?><?

if($os->get('school_admin_login')=='OK' && $os->post('school_login_data')!='' )
{
   		$redirect=$site['main_website_login'];
    	$school_login_data=$os->post('school_login_data');
  
		$school_login_data=json_decode($bridge->dCode($school_login_data),true);
		$login_username=$school_login_data['login_username'];
		$login_password=$school_login_data['login_password'];
		$login_username=str_replace(array("'",'"',';','-'),'',$login_username);
        $login_data=  $os->central_login($login_username,$login_password);
		 
		 
		// _d($login_data);
		// exit();
		if($login_data['redirect']!='')
		{
		 $redirect=$login_data['redirect'];
		}
		
   
  ?>
  <script>
   window.location='<? echo $redirect;?>';
  </script>
  
  <?  
   
} 
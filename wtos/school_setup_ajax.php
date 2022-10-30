<? 
if (session_id() === "") { session_start(); }
include('wtosConfigLocal.php');
error_reporting($site['environment']);
include($site['root-wtos'].'wtos.php');
global $setup_school_arr;
?><?

if($os->get('school_setup')=='OK' && $os->post('setup_school_data')!='' )
{

  $setup_school_data=$os->post('setup_school_data');
   
$setup_form_key=rand(2000,5000);
$setup_form_Value=rand(5000,10000);
$_SESSION['setup_form_key']=$setup_form_key;
$_SESSION['setup_form_Value']=$setup_form_Value;

$setup_form_token=rand(2000,5000);
$setup_form_tokenvalue=rand(5000,10000);
$_SESSION['setup_form_token']=$setup_form_token;
$_SESSION['setup_form_tokenvalue']=$setup_form_tokenvalue;
  
  
 
 
  ?>
  <table width="100%" border="0" cellspacing="3" cellpadding="3">
 
  <tr>
    <td>Name</td>
    <td> <? echo $setup_school_arr['name'] ?> </td>
  </tr>
   <tr>
    <td>school_name</td>
    <td><? echo $setup_school_arr['school_name'] ?> </td>
  </tr>
   <tr>
    <td>school_address</td>
    <td><? echo $setup_school_arr['school_address'] ?> </td>
  </tr>
   <tr>
    <td>login_username</td>
    <td><? echo $setup_school_arr['login_username'] ?> </td>
  </tr>
   <tr>
    <td>login_password</td>
    <td><? echo $setup_school_arr['login_password'] ?> </td>
  </tr>
   <tr>
    <td>schoolCode</td>
    <td><? echo $setup_school_arr['schoolCode'] ?> </td>
  </tr>
   <tr>
    <td>database_name</td>
    <td><? echo $setup_school_arr['database_name'] ?> </td>
  </tr>
</table>
<form action="<? echo $site['url'];?>wtos/school_setup_ajax.php?school_setup_confirm=OK&token<? echo $setup_form_token ?>=<? echo $setup_form_tokenvalue ?>" method="post" >

<input type="hidden" name="setup_school_data"  value="<? echo $setup_school_data  ?>" />
<input type="submit" value="Confirm" />
<input type="hidden" name="Confirm_setup" value="OK" style="cursor:pointer;" />
<input type="hidden" name="setup_form_key<? echo $setup_form_key  ?>" value="<? echo $setup_form_Value  ?>" />

 
</form>
  
  <?
   
}

if($os->post('Confirm_setup')=='OK')
{
$setup_form_key=$_SESSION['setup_form_key'];
$setup_form_Value=$_SESSION['setup_form_Value'];
$setup_form_token=$_SESSION['setup_form_token'];
$setup_form_tokenvalue=$_SESSION['setup_form_tokenvalue'];

$var_setup_form_key='setup_form_key'.$setup_form_key;
$var_setup_form_token='token'.$setup_form_token;

if($os->post($var_setup_form_key)==$setup_form_Value &&  $os->get($var_setup_form_token)==$setup_form_tokenvalue)
{
$setup_school_data=$os->post('setup_school_data');
if($setup_school_data==''){ exit(); }
    $setup_school_arr=json_decode($bridge->dCode($setup_school_data),true);
		
	
	 
	$username=$setup_school_arr['login_username'];
	$User=$os->get_admin(''," username='$username' ");
	$Userdata=$os->mfa($User);
	 
	$adminId=$os->val($Userdata,'adminId');
	 
	if(!$adminId)
	{ 	
	 $msg='ERROR saving data .';		
	$dataToSave['name']=$setup_school_arr['name'];
	$dataToSave['username']=$setup_school_arr['login_username'];
	$dataToSave['password']=$setup_school_arr['login_password'];
	$dataToSave['editDeletePassword']=$setup_school_arr['login_password'];
	$dataToSave['address']=$setup_school_arr['school_address'];
	//$dataToSave['email']=$setup_school_arr['00000000000'];
	$dataToSave['mobileNo']=$setup_school_arr['mobile'];
	if($setup_school_arr['memberType']=='super_admin')
	{
	$dataToSave['adminType']='Super Admin';
	}
	$dataToSave['active']='Active';
	$dataToSave['addedDate']=$setup_school_arr['addedDate'];
	$dataToSave['addedBy']=$setup_school_arr['addedBy']; 
	if($os->save('admin',$dataToSave,'adminId',''))
	{
	 	 	 	 	    
				$dataToSave2['school_name']=$setup_school_arr['school_name'];
				$dataToSave2['address']=$setup_school_arr['school_address'];
				$dataToSave2['contact']=$setup_school_arr['mobile'];
				$dataToSave2['school_id']=$setup_school_arr['school_id'];
				
				
				//$dataToSave2['email']=$setup_school_arr['00000000000'];
				$dataToSave2['database_name']=$setup_school_arr['database_name'];
				 
				 $os->mq('delete from school_setting');
				 $os->save('school_setting',$dataToSave2,'school_setting_id','');	
				 
				 $msg='Data configure successfully .';
	} 
	
}else
{
$msg='Usename/mobile already exist.';

}	 					 
 echo $msg;
}


}
 

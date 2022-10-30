<? 
/*
   # wtos version : 1.1
   # page called by ajax script in adminDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?
if($os->get('WT_adminEditAndSave')=='OK')
{
 $adminId=$os->post('adminId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['username']=addslashes($os->post('username')); 
 $dataToSave['password']=addslashes($os->post('password')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['mobileNo']=addslashes($os->post('mobileNo')); 
 $dataToSave['editDeletePassword']=addslashes($os->post('editDeletePassword')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($adminId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('admin',$dataToSave,'adminId',$adminId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($adminId>0 ){ $mgs= " Data updated Successfully";}
		if($adminId<1 ){ $mgs= " Data Added Successfully"; $adminId=  $qResult;}
		
		  $mgs=$adminId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 

 

 

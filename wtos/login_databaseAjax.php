<? 
/*
   # wtos version : 1.1
   # page called by ajax script in login_databaseDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_login_databaseListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andmobile=  $os->postAndQuery('mobile_s','mobile','%');
$andschool_name=  $os->postAndQuery('school_name_s','school_name','%');
$andschool_address=  $os->postAndQuery('school_address_s','school_address','%');
$andlogin_username=  $os->postAndQuery('login_username_s','login_username','%');
$anddatabase_name=  $os->postAndQuery('database_name_s','database_name','%');
$andactiveStatus=  $os->postAndQuery('activeStatus_s','activeStatus','%');

    $f_lastLoginDate_s= $os->post('f_lastLoginDate_s'); $t_lastLoginDate_s= $os->post('t_lastLoginDate_s');
   $andlastLoginDate=$os->DateQ('lastLoginDate',$f_lastLoginDate_s,$t_lastLoginDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andschoolCode=  $os->postAndQuery('schoolCode_s','schoolCode','%');
$andmemberType=  $os->postAndQuery('memberType_s','memberType','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');
$andloginIP=  $os->postAndQuery('loginIP_s','loginIP','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or mobile like '%$searchKey%' Or school_name like '%$searchKey%' Or school_address like '%$searchKey%' Or login_username like '%$searchKey%' Or database_name like '%$searchKey%' Or activeStatus like '%$searchKey%' Or schoolCode like '%$searchKey%' Or memberType like '%$searchKey%' Or remarks like '%$searchKey%' Or loginIP like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from login_database where login_database_id>0   $where   $andname  $andmobile  $andschool_name  $andschool_address  $andlogin_username  $anddatabase_name  $andactiveStatus  $andlastLoginDate  $andschoolCode  $andmemberType  $andremarks  $andloginIP     order by login_database_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Name</b></td>  
  <td ><b>Mobile</b></td>  
  <td ><b>School Name</b></td>  
  <td ><b>Schoool Address</b></td>  
  <td ><b>User</b></td>  
  <td ><b>Pass</b></td>  
  <td ><b>Database</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Last Login</b></td>  
  <td ><b>School Code</b></td>  
  <td ><b>Member Type</b></td>  
  <td ><b>Remarks</b></td>  
  <td ><b>loginIP</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_login_databaseGetById('<? echo $record['login_database_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?>
<? 
  $recordjson=json_encode($record);
	$schoolsetup=nCode($recordjson); ?>
	
<span onclick="setup_school('<? echo $schoolsetup; ?>')">setup school</span>
</td>  
  <td><?php echo $record['mobile']?> </td>  
  <td><?php echo $record['school_name']?> </td>  
  <td><?php echo $record['school_address']?> </td>  
  <td><?php echo $record['login_username']?> </td>  
  <td><?php echo $record['login_password']?> </td>  
  <td><?php echo $record['database_name']?> </td>  
  <td> <? if(isset($os->activeStatus[$record['activeStatus']])){ echo  $os->activeStatus[$record['activeStatus']]; } ?></td> 
  <td><?php echo $os->showDate($record['lastLoginDate']);?> </td>  
  <td><?php echo $record['schoolCode']?> </td>  
  <td> <? if(isset($os->memberType[$record['memberType']])){ echo  $os->memberType[$record['memberType']]; } ?></td> 
  <td><?php echo $record['remarks']?> </td>  
  <td><?php echo $record['loginIP']?> 

  

</td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_login_databaseEditAndSave')=='OK')
{
 $login_database_id=$os->post('login_database_id');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['mobile']=addslashes($os->post('mobile')); 
 $dataToSave['school_name']=addslashes($os->post('school_name')); 
 $dataToSave['school_address']=addslashes($os->post('school_address')); 
 $dataToSave['login_username']=addslashes($os->post('login_username')); 
 $dataToSave['login_password']=addslashes($os->post('login_password')); 
 $dataToSave['database_name']=addslashes($os->post('database_name')); 
 $dataToSave['activeStatus']=addslashes($os->post('activeStatus')); 
 $dataToSave['schoolCode']=addslashes($os->post('schoolCode')); 
 $dataToSave['memberType']=addslashes($os->post('memberType')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 
   

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($login_database_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('login_database',$dataToSave,'login_database_id',$login_database_id);///    allowed char '\*#@/"~$^.,()|+_-=:�� 	
		if($qResult)  
				{
		if($login_database_id>0 ){ $mgs= " Data updated Successfully";}
		if($login_database_id<1 ){ $mgs= " Data Added Successfully"; $login_database_id=  $qResult;}
		
		  $mgs=$login_database_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_login_databaseGetById')=='OK')
{
		$login_database_id=$os->post('login_database_id');
		
		if($login_database_id>0)	
		{
		$wheres=" where login_database_id='$login_database_id'";
		}
	    $dataQuery=" select * from login_database  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['mobile']=$record['mobile'];
 $record['school_name']=$record['school_name'];
 $record['school_address']=$record['school_address'];
 $record['login_username']=$record['login_username'];
 $record['login_password']=$record['login_password'];
 $record['database_name']=$record['database_name'];
 $record['activeStatus']=$record['activeStatus'];
 $record['schoolCode']=$record['schoolCode'];
 $record['memberType']=$record['memberType'];
 $record['remarks']=$record['remarks'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_login_databaseDeleteRowById')=='OK')
{ 

$login_database_id=$os->post('login_database_id');
 if($login_database_id>0){
 $updateQuery="delete from login_database where login_database_id='$login_database_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

<? 
/*
   # wtos version : 1.1
   # page called by ajax script in libraryDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_libraryListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andlibrary_id=  $os->postAndQuery('library_id_s','library_id','%');
$andname=  $os->postAndQuery('name_s','name','%');
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
$andadmin_id=  $os->postAndQuery('admin_id_s','admin_id','%');
$andcampus_location_id=  $os->postAndQuery('campus_location_id_s','campus_location_id','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( library_id like '%$searchKey%' Or name like '%$searchKey%' Or branch_code like '%$searchKey%' Or admin_id like '%$searchKey%' Or campus_location_id like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from library where library_id>0   $where   $andlibrary_id  $andname  $andbranch_code  $andadmin_id  $andcampus_location_id     order by library_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>library_id</b></td>  
  <td ><b>Name</b></td>  
  <td ><b>Branch</b></td>  
  <td ><b>Admin</b></td>  
  <td ><b>Campus</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_libraryGetById('<? echo $record['library_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['library_id']?> </td>  
  <td><?php echo $record['name']?> </td>  
  <td>  <? echo 
	$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
  <td>  <? echo 
	$os->rowByField('name','admin','adminId',$record['admin_id']); ?></td> 
  <td>  <? echo 
	$os->rowByField('campus_name','campus_location','campus_location_id',$record['campus_location_id']); ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_libraryEditAndSave')=='OK')
{
 $library_id=$os->post('library_id');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['admin_id']=addslashes($os->post('admin_id')); 
 $dataToSave['campus_location_id']=addslashes($os->post('campus_location_id')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($library_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('library',$dataToSave,'library_id',$library_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($library_id>0 ){ $mgs= " Data updated Successfully";}
		if($library_id<1 ){ $mgs= " Data Added Successfully"; $library_id=  $qResult;}
		
		  $mgs=$library_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_libraryGetById')=='OK')
{
		$library_id=$os->post('library_id');
		
		if($library_id>0)	
		{
		$wheres=" where library_id='$library_id'";
		}
	    $dataQuery=" select * from library  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['branch_code']=$record['branch_code'];
 $record['admin_id']=$record['admin_id'];
 $record['campus_location_id']=$record['campus_location_id'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_libraryDeleteRowById')=='OK')
{ 

$library_id=$os->post('library_id');
 if($library_id>0){
 $updateQuery="delete from library where library_id='$library_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

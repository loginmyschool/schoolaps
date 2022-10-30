<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbvenderDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbvenderListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andphone=  $os->postAndQuery('phone_s','phone','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$andcontatPerson=  $os->postAndQuery('contatPerson_s','contatPerson','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or phone like '%$searchKey%' Or email like '%$searchKey%' Or contatPerson like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbvender where rbvenderId>0   $where   $andname  $andphone  $andemail  $andcontatPerson  $andnote     order by rbvenderId desc";
	  
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
  <td ><b>Phone</b></td>  
  <td ><b>Address</b></td>  
  <td ><b>Contat Person</b></td>  
  <td ><b>Note</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbvenderGetById('<? echo $record['rbvenderId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $record['phone']?> </td>  
  <td><?php echo $record['address']?> </td>  
  <td><?php echo $record['contatPerson']?> </td>  
  <td><?php echo $record['note']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbvenderEditAndSave')=='OK')
{
 $rbvenderId=$os->post('rbvenderId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['phone']=addslashes($os->post('phone')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['contatPerson']=addslashes($os->post('contatPerson')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbvenderId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbvender',$dataToSave,'rbvenderId',$rbvenderId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbvenderId>0 ){ $mgs= " Data updated Successfully";}
		if($rbvenderId<1 ){ $mgs= " Data Added Successfully"; $rbvenderId=  $qResult;}
		
		  $mgs=$rbvenderId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbvenderGetById')=='OK')
{
		$rbvenderId=$os->post('rbvenderId');
		
		if($rbvenderId>0)	
		{
		$wheres=" where rbvenderId='$rbvenderId'";
		}
	    $dataQuery=" select * from rbvender  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['phone']=$record['phone'];
 $record['email']=$record['email'];
 $record['address']=$record['address'];
 $record['contatPerson']=$record['contatPerson'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbvenderDeleteRowById')=='OK')
{ 

$rbvenderId=$os->post('rbvenderId');
 if($rbvenderId>0){
 $updateQuery="delete from rbvender where rbvenderId='$rbvenderId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

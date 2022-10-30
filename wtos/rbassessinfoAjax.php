<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbassessinfoDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbassessinfoListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
$andurl=  $os->postAndQuery('url_s','url','%');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andrbcountryId=  $os->postAndQuery('rbcountryId_s','rbcountryId','=');
$andphone=  $os->postAndQuery('phone_s','phone','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$andperson=  $os->postAndQuery('person_s','person','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or url like '%$searchKey%' Or status like '%$searchKey%' Or rbcountryId like '%$searchKey%' Or phone like '%$searchKey%' Or email like '%$searchKey%' Or person like '%$searchKey%' Or details like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbassessinfo where rbassessinfo>0   $where   $andrefCode  $andurl  $andstatus  $andrbcountryId  $andphone  $andemail  $andperson     order by rbassessinfo desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Reffer Code</b></td>  
  <td ><b>Url</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Contact</b></td>  
  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbassessinfoGetById('<? echo $record['rbassessinfo'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['refCode']?> </td>  
  <td><a style="text-decoration: none" target="_blank" href="http://<?php echo $record['url']?>"><?php echo $record['url']?></a> </td> 

  <td> <? if(isset($os->activeInactive[$record['status']])){ echo  $os->activeInactive[$record['status']]; } ?></td> 
  
  <td>
  	<span><b><?php echo $record['person']?></b></span><br>

  	<span style="color: green; font-size: 10px"><?php echo $record['phone']?></span> 
  	<span style="color: blue; font-size: 10px"><?php echo $record['email']?></span>
  	
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
 





if($os->get('WT_rbassessinfoEditAndSave')=='OK')
{
 $rbassessinfo=$os->post('rbassessinfo');
 
 
		 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['url']=addslashes($os->post('url')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['rbcountryId']=addslashes($os->post('rbcountryId')); 
 $dataToSave['phone']=addslashes($os->post('phone')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['person']=addslashes($os->post('person')); 
 $dataToSave['details']=addslashes($os->post('details')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbassessinfo < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbassessinfo',$dataToSave,'rbassessinfo',$rbassessinfo);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbassessinfo>0 ){ $mgs= " Data updated Successfully";}
		if($rbassessinfo<1 ){ $mgs= " Data Added Successfully"; $rbassessinfo=  $qResult;}
		
		  $mgs=$rbassessinfo."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbassessinfoGetById')=='OK')
{
		$rbassessinfo=$os->post('rbassessinfo');
		
		if($rbassessinfo>0)	
		{
		$wheres=" where rbassessinfo='$rbassessinfo'";
		}
	    $dataQuery=" select * from rbassessinfo  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['refCode']=$record['refCode'];
 $record['url']=$record['url'];
 $record['status']=$record['status'];
 $record['rbcountryId']=$record['rbcountryId'];
 $record['phone']=$record['phone'];
 $record['email']=$record['email'];
 $record['person']=$record['person'];
 $record['details']=$record['details'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbassessinfoDeleteRowById')=='OK')
{ 

$rbassessinfo=$os->post('rbassessinfo');
 if($rbassessinfo>0){
 $updateQuery="delete from rbassessinfo where rbassessinfo='$rbassessinfo'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

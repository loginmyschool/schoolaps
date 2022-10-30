<? 
/*
   # wtos version : 1.1
   # page called by ajax script in form_feesDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_form_feesListing')=='OK')
	
{
	$where='';
	$showPerPage= $os->post('showPerPage');
	
	
	$andform_fees_for=  $os->postAndQuery('form_fees_for_s','form_fees_for','%');
	$andyear=  $os->postAndQuery('year_s','year','%');
	$andclass_id=  $os->postAndQuery('class_id_s','class_id','%');
	$andamount=  $os->postAndQuery('amount_s','amount','%');

	
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
		$where ="and ( form_fees_for like '%$searchKey%' Or year like '%$searchKey%' Or class_id like '%$searchKey%' Or amount like '%$searchKey%' )";
		
	}
	
	$listingQuery="  select * from form_fees where form_fees_id>0   $where   $andform_fees_for  $andyear  $andclass_id  $andamount     order by form_fees_id desc";
	
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	
	?>
	<div class="listingRecords">
		<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

		<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
			<tr class="borderTitle" >
				
				<td >#</td>
				<td >Action </td>
				

				
				<td ><b>Form fees for</b></td>  
				<td ><b>Year</b></td>  
				<td ><b>Class</b></td>  
				<td ><b>Amount</b></td>  
				
				
				
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_form_feesGetById('<? echo $record['form_fees_id'];?>')" >Edit</a></span>  <? } ?>  </td>
							
							<td> <? if(isset($os->admissionType[$record['form_fees_for']])){ echo  $os->admissionType[$record['form_fees_for']]; } ?></td> 
							<td><?php echo $record['year']?> </td>  
							<td> <? if(isset($os->classList[$record['class_id']])){ echo  $os->classList[$record['class_id']]; } ?></td> 
							<td><?php echo $record['amount']?> </td>  
							
							
						</tr>
						<? 
						
						
					} ?>  
					
					
					
					
					
				</table> 
				
				
				
			</div>
			
			<br />
			
			
			
			<?php 
			exit();
			
		}
		





		if($os->get('WT_form_feesEditAndSave')=='OK')
		{
			$form_fees_id=$os->post('form_fees_id');
			
			
			
			$dataToSave['form_fees_for']=addslashes($os->post('form_fees_for')); 
			$dataToSave['year']=addslashes($os->post('year')); 
			$dataToSave['class_id']=addslashes($os->post('class_id')); 
			$dataToSave['amount']=addslashes($os->post('amount')); 

			
			
			
			$dataToSave['modifyDate']=$os->now();
			$dataToSave['modifyBy']=$os->userDetails['adminId']; 
			
			if($form_fees_id < 1){
				
				$dataToSave['addedDate']=$os->now();
				$dataToSave['addedBy']=$os->userDetails['adminId'];
			}
			
			
          $qResult=$os->save('form_fees',$dataToSave,'form_fees_id',$form_fees_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
          if($qResult)  
          {
          	if($form_fees_id>0 ){ $mgs= " Data updated Successfully";}
          	if($form_fees_id<1 ){ $mgs= " Data Added Successfully"; $form_fees_id=  $qResult;}
          	
          	$mgs=$form_fees_id."#-#".$mgs;
          }
          else
          {
          	$mgs="Error#-#Problem Saving Data.";
          	
          }
		//_d($dataToSave);
          echo $mgs;		
          
          exit();
          
      } 
      
      if($os->get('WT_form_feesGetById')=='OK')
      {
      	$form_fees_id=$os->post('form_fees_id');
      	
      	if($form_fees_id>0)	
      	{
      		$wheres=" where form_fees_id='$form_fees_id'";
      	}
      	$dataQuery=" select * from form_fees  $wheres ";
      	$rsResults=$os->mq($dataQuery);
      	$record=$os->mfa( $rsResults);
      	
      	
      	$record['form_fees_for']=$record['form_fees_for'];
      	$record['year']=$record['year'];
      	$record['class_id']=$record['class_id'];
      	$record['amount']=$record['amount'];

      	
      	
      	echo  json_encode($record);	 
      	
      	exit();
      	
      }
      
      
      if($os->get('WT_form_feesDeleteRowById')=='OK')
      { 

      	$form_fees_id=$os->post('form_fees_id');
      	if($form_fees_id>0){
      		$updateQuery="delete from form_fees where form_fees_id='$form_fees_id'";
      		$os->mq($updateQuery);
      		echo 'Record Deleted Successfully';
      	}
      	exit();
      }
      

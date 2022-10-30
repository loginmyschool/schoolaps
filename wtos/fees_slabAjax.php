<? 
/*
   # wtos version : 1.1
   # page called by ajax script in fees_slabDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_fees_slabListing')=='OK')
	
{
	$where='';
	$showPerPage= $os->post('showPerPage');
	
	
	$andtitle=  $os->postAndQuery('title_s','title','%');
	$andyear=  $os->postAndQuery('year_s','year','%');
	$andclassId=  $os->postAndQuery('classId_s','classId','%');
	$andnote=  $os->postAndQuery('note_s','note','%');
	$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');

	
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
		$where ="and ( title like '%$searchKey%' Or year like '%$searchKey%' Or classId like '%$searchKey%' Or note like '%$searchKey%' )";
		
	}
	
	$listingQuery="  select * from fees_slab where fees_slab_id>0   $where   $andtitle  $andyear  $andclassId  $andnote $andbranch_code    order by fees_slab_id desc";
	
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	
	
	
	
	
$return_acc=$os->branch_access();
$and_branch='';
if($os->userDetails['adminType']!='Super Admin')
{
    $selected_branch_codes=$return_acc['branches_code_str_query'];
    $and_branch=" and branch_code IN($selected_branch_codes)";
}
$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";

$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
    $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}
	
	?>
	<div class="listingRecords">
		<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

		<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
			<tr class="borderTitle" >
				
				<td >#</td>
				<td >Action </td>
				

				
				<td ><b>Title</b></td>  
				<td ><b>Year</b></td>  
				<td ><b>Class</b></td>  
				<td ><b>Note</b></td>  
				<td ><b>Branch</b></td>  
				
				
				
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_fees_slabGetById('<? echo $record['fees_slab_id'];?>')" >Edit</a></span>  <? } ?>  </td>
							
							<td><?php echo $record['title']?> </td>  
							<td> <? if(isset($os->feesYear[$record['year']])){ echo  $os->feesYear[$record['year']]; } ?></td> 
							<td> <? if(isset($os->classList[$record['classId']])){ echo  $os->classList[$record['classId']]; } ?></td> 
							<td><?php echo $record['note']?> </td>  
							<td><?php echo  $branch_code_arr[$record['branch_code']];?> </td>  
							
							
						</tr>
						<? 
						
						
					} ?>  
					
					
					
					
					
				</table> 
				
				
				
			</div>
			
			<br />
			
			
			
			<?php 
			exit();
			
		}
		





		if($os->get('WT_fees_slabEditAndSave')=='OK')
		{
			$fees_slab_id=$os->post('fees_slab_id');
			
			
			
			$dataToSave['title']=addslashes($os->post('title')); 
			$dataToSave['year']=addslashes($os->post('year')); 
			$dataToSave['classId']=addslashes($os->post('classId')); 
			$dataToSave['note']=addslashes($os->post('note')); 
			$dataToSave['branch_code']=addslashes($os->post('branch_code')); 

			
		 
			
			$dataToSave['modifyDate']=$os->now();
			$dataToSave['modifyBy']=$os->userDetails['adminId']; 
			
			if($fees_slab_id < 1){
				
				$dataToSave['addedDate']=$os->now();
				$dataToSave['addedBy']=$os->userDetails['adminId'];
			}
			
			
          $qResult=$os->save('fees_slab',$dataToSave,'fees_slab_id',$fees_slab_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
          if($qResult)  
          {
          	if($fees_slab_id>0 ){ $mgs= " Data updated Successfully";}
          	if($fees_slab_id<1 ){ $mgs= " Data Added Successfully"; $fees_slab_id=  $qResult;}
          	
          	$mgs=$fees_slab_id."#-#".$mgs;
          }
          else
          {
          	$mgs="Error#-#Problem Saving Data.";
          	
          }
		//_d($dataToSave);
          echo $mgs;		
          
          exit();
          
      } 
      
      if($os->get('WT_fees_slabGetById')=='OK')
      {
      	$fees_slab_id=$os->post('fees_slab_id');
      	
      	if($fees_slab_id>0)	
      	{
      		$wheres=" where fees_slab_id='$fees_slab_id'";
      	}
      	$dataQuery=" select * from fees_slab  $wheres ";
      	$rsResults=$os->mq($dataQuery);
      	$record=$os->mfa( $rsResults);
      	
      	
      	$record['title']=$record['title'];
      	$record['year']=$record['year'];
      	$record['classId']=$record['classId'];
      	$record['note']=$record['note'];

      	
      	
      	echo  json_encode($record);	 
      	
      	exit();
      	
      }
      
      
      if($os->get('WT_fees_slabDeleteRowById')=='OK')
      { 

      	$fees_slab_id=$os->post('fees_slab_id');
      	if($fees_slab_id>0){
      		$updateQuery="delete from fees_slab where fees_slab_id='$fees_slab_id'";
      		$os->mq($updateQuery);
      		echo 'Record Deleted Successfully';
      	}
      	exit();
      }
      

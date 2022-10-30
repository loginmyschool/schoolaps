<? 
/*
   # wtos version : 1.1
   # page called by ajax script in account_headDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_account_headListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andtitle=  $os->postAndQuery('title_s','title','%');
$andparent_head_id=  $os->postAndQuery('parent_head_id_s','parent_head_id','%');
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( title like '%$searchKey%' Or parent_head_id like '%$searchKey%' Or branch_code like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from account_head where account_head_id>0   $where   $andtitle  $andparent_head_id  $andbranch_code     order by account_head_id desc";
	  $os->showPerPage=500;
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
////////	
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
								

		 <td ><b>View Order</b></td> 									
<td ><b>Account Head</b></td>  
  <td ><b>Parent Head</b></td>  
  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_account_headGetById('<? echo $record['account_head_id'];?>')" >Edit</a></span>  <? } ?>  </td>
							
							<td> 
							  <input type="text" style="border:none; width:50px;" value="<?  echo  $record['view_order'];  ?>" id="edit_section<?  echo $record['account_head_id']; ?>"
                               onchange="wtosInlineEdit('edit_section<?  echo $record['account_head_id']; ?>','account_head','view_order','account_head_id','<?  echo $record['account_head_id']; ?>','','','');" />
							
							 </td>
								
<td <?  if(!$record['parent_head_id']){?>  style="font-weight:bold; background-color:#FFFF00; " <?  } else { ?> style="padding-left:30px;"     <? } ?>>    <?php echo $record['title']?> </td>  
  <td>  <?  
	echo $os->rowByField('title','account_head','account_head_id',$record['parent_head_id']); ?></td> 
  <td>  <? echo  $branch_code_arr[$record['branch_code']];
	  ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_account_headEditAndSave')=='OK')
{
 $account_head_id=$os->post('account_head_id');
 
 
		 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['parent_head_id']=addslashes($os->post('parent_head_id')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 
 if($dataToSave['branch_code']==''){
  $dataToSave['branch_code']='010100113'; 
}
    $os->setSession($dataToSave['parent_head_id'], 'parent_head_id');
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($account_head_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('account_head',$dataToSave,'account_head_id',$account_head_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($account_head_id>0 ){ $mgs= " Data updated Successfully";}
		if($account_head_id<1 ){ $mgs= " Data Added Successfully"; $account_head_id=  $qResult;}
		
		  $mgs=$account_head_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_account_headGetById')=='OK')
{
		$account_head_id=$os->post('account_head_id');
		
		if($account_head_id>0)	
		{
		$wheres=" where account_head_id='$account_head_id'";
		}
	    $dataQuery=" select * from account_head  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['title']=$record['title'];
 $record['parent_head_id']=$record['parent_head_id'];
 $record['branch_code']=$record['branch_code'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_account_headDeleteRowById')=='OK')
{ 

$account_head_id=$os->post('account_head_id');
 if($account_head_id>0){
 $updateQuery="delete from account_head where account_head_id='$account_head_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

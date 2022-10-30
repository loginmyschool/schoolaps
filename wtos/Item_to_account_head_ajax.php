<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
 
 
if($os->get('item_list_data')=='OK' && $os->post('item_list_data')=='OK')
{
$searchKey=$os->post('searchKey');
$branch_code=$os->post('branch_code_s');

   $where='';
	if($searchKey!=''){
		$where ="and ( i.item_name like '%$searchKey%' Or i.beng_name like '%$searchKey%' Or i.hindi_name like '%$searchKey%' Or i.keywords like '%$searchKey%')";
 	}
		
	 /* $listingQuery="select i.*, itah.item_to_account_head_id from items i 
						LEFT JOIN  item_to_account_head itah ON(itah.item_id=i.item_id  && itah.branch_code='$branch_code'   )
						where i.item_id>0   $where   
						group by i.item_id 
						order by itah.item_to_account_head_id asc    
						
						 ";*/
						 
						 $listingQuery="select i.*, itah.item_to_account_head_id from items i 
						LEFT JOIN  item_to_account_head itah ON(itah.item_id=i.item_id   )
						where i.item_id>0   $where   
						group by i.item_id 
						order by itah.item_to_account_head_id asc    
						
						 ";
	
	$os->showPerPage=10000;
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	?>
	
	
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
								 	
<td ><b>Item id</b></td>  
  <td ><b>Name</b></td>  
   
   
  
   
  <td ><b>Photo</b></td>  
   
  <td ><b></b></td> 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							 $item_to_account_head_id= $record['item_to_account_head_id'];  
							 
							
						
							 ?>
							<tr class="trListing" <? if($item_to_account_head_id>0){ ?> style="background-color:#9DFF9D;" <? } ?> >
							<td><?php echo $serial; ?></td>						 								
                            <td><?php echo $record['item_id']?></td>  
                           <td title="<?php echo $record['item_name']?>"><b> <?php echo substr( $record['item_name'],0,50);?> </b> 
						    </td>  
   
  
 
  
  
   
  <td> <? if(isset($os->departments[$record['departments']])){ echo  $os->departments[$record['departments']]; } ?> 
  <br />
  <? if(isset($os->category_list[$record['category_id']])){ echo  $os->category_list[$record['category_id']]; } ?>
  </td> 
   
  
  <td>  <? if($record['photo']){ ?>  <img src="<?php  echo $site['url'].$record['photo']; ?>"  height="70" width="70" /> <? } ?></td>  
  
   
    <td>   <a href="javascript:void(0);" onclick="show_account_head('<?php echo $record['item_id']?>')"> Show </a>   </td> 
  
			 				
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table>
	
	<? 
	exit();
}

 
if($os->get('show_account_head')=='OK' && $os->post('show_account_head')=='OK')
{
   
   $branch_code=$os->post('branch_code_s');
   $item_id=$os->post('item_id');
   
   
    $selected_list=array();
    $select="select * from item_to_account_head  where    item_id='$item_id' ";
	$select_rs=$os->mq($select);
	while($row = $os->mfa($select_rs))
	{ 
	  $selected_list[$row['account_head_id']]=$row['account_head_id'];
	}
  //  _d($selected_list);
   
   $where=''; 
	
	$andbranch_code=  $os->postAndQuery('branch_code_s','ah.branch_code','%');	   
	$searchKey=$os->post('account_head_searchKey');
	if($searchKey!=''){
		$where ="and ( ah.title like '%$searchKey%'  )";
 
	}
		
	/*$listingQuery="  select * from account_head  ah
	                 where ah.account_head_id>0   
	                 $where    $andbranch_code     
	                 order by view_order asc";*/
					
					
					  // no branch filter here
					 $listingQuery="  select * from account_head  ah
	                 where ah.account_head_id>0   
	                 $where        
	                 order by view_order asc";
	
	
	
	$os->showPerPage=10000; 
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	  
	   $item_row= $os->rowByField('','items','item_id',$item_id,$where='',$orderby=''); 
	  // _d( $item_row);
 
?>
<div>
<h3><? echo  $item_row['item_id'] ?> . <? echo  $item_row['item_name'] ?></h3>
</div>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >						
	                            <td >#</td>
									<td >Action </td> 
									<td >View </td> 
<td ><b>Account Head</b></td>  
   
  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
							//	 _d($record);
							
						
							 ?>
							<tr class="trListing"  <?  if(in_array($record['account_head_id'], $selected_list)){?> style="background-color:#FFB9B9;"<? } ?>>
							<td><?php echo $serial; ?>     </td>
							<td> 
							       <input type="checkbox" name="account_head_id_<? echo $record['account_head_id']; ?>" 
								   
								    <?  if(in_array($record['account_head_id'], $selected_list)){?>  checked="checked" <? } ?>
								   id="account_head_id_<? echo $record['account_head_id']; ?>" 
								   onclick="set_item_to_account_head('<? echo $item_id; ?>','<? echo $record['account_head_id']; ?>','<? echo $branch_code; ?>')"  />
							  </td>
							  <td> <? echo $record['view_order']; ?></td>
								
<td <?   if(!$record['parent_head_id']){?>  style="font-weight:bold; background-color:#FFFF77;" <?  } else { ?> style="padding-left:30px;"     <? } ?>>    <?php echo $record['title']?> </td>  
  
  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
if($os->get('set_item_to_account_head')=='OK' && $os->post('set_item_to_account_head')=='OK')
{
   
	$branch_code=$os->post('branch_code');
	$item_id=$os->post('item_id');
	$account_head_id=$os->post('account_head_id');
	$check_box_checked=$os->post('check_box_checked');
	
	//$delete_query="delete from item_to_account_head  where account_head_id='$account_head_id' and branch_code='$branch_code' and item_id='$item_id' ";
	$delete_query="delete from item_to_account_head  where account_head_id='$account_head_id'  and item_id='$item_id' ";
	$os->mq($delete_query);
	if($check_box_checked=='yes' &&  $branch_code!=''&&  $item_id!=''&&  $account_head_id!='' )
	{
		$dataToSave=array();
		// $dataToSave['branch_code']=$branch_code; 
		$dataToSave['item_id']=$item_id; 
		$dataToSave['account_head_id']=$account_head_id; 
		$qResult=$os->save('item_to_account_head',$dataToSave,'item_to_account_head_id',''); 
		
		 
	}	
	
	
	echo 'Updated Successfully.';
	 
	  
 
exit();
	
}



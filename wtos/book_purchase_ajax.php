<?

/*

   # wtos version : 1.1

*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
//$pluginName='';
//$os->loadPluginConstant($pluginName);

if($os->get('book_purchase_ajax')=='OK' && $os->post('book_purchase_ajax')=='OK')
{
$searched_booked_id=$os->post('searched_booked_id');  
$wt_action=$os->post('wt_action');
$book_purchase_id=$os->post('book_purchase_id');

   $quantity_be_added=$os->post('quantity_be_added');
   
	if($wt_action=='add_to_list' && $searched_booked_id>0)
	{     
	
				
			$bill_no=$os->post('bill_no');
			$book_vendor_id=$os->post('book_vendor_id');
			$book_amount=$os->post('book_amount');
			$total_amount=$os->post('total_amount');
				
				
				
				
				if($quantity_be_added<1)
				{
				$quantity_be_added=1;
				}

	
	   		if($book_purchase_id<1)
	          {
					$dataToSave=array();					      
					$dataToSave['dated']=$os->now();
					$dataToSave['bill_no']=$bill_no; 
					$dataToSave['book_vendor_id']=$book_vendor_id; 	
					$dataToSave['book_amount']=$book_amount;
					$dataToSave['total_amount']=$total_amount; 
					//$dataToSave['000000']=$amount;
					$dataToSave['addedDate']=$os->now();
					$dataToSave['addedBy']=$os->userDetails['adminId'];
					$book_purchase_id=$os->save('book_purchase',$dataToSave,'book_purchase_id','');///    allowed char '\*#@/"~$^.,()|+_-=:££ 	 
			 }
			        
					
					
					
					$book_id_existed=0;
					$quantity_existed=0;
					
					$duplicate_query="select * from book_purchase_details where book_purchase_id='$book_purchase_id'  and book_id='$searched_booked_id' limit 1 ";
					$book_id_rs=$os->mq($duplicate_query);
					$book_details=$os->mfa($book_id_rs);
					if(isset($book_details['book_id']))
					{
					  $book_id_existed=$book_details['book_id'];
					  $quantity_existed=$book_details['quantity'];
					}
					
					//$book_id=$os->isRecordExist($duplicate_query,'book_id');
					$quantity=(int)$quantity_be_added+(int)$quantity_existed;
					$amount=$os->post('book_amount');
					if(!$book_id_existed)
					{
					   
						$dataToSave=array();					      
						$dataToSave_2['book_purchase_id']=$book_purchase_id;
						$dataToSave_2['book_id']=$searched_booked_id; 
						$dataToSave_2['dated']=$os->now();	
						$dataToSave_2['quantity']=$quantity;
						$dataToSave_2['amount']=$amount; 
					 
						$qResult=$os->save('book_purchase_details',$dataToSave_2,'book_purchase_details_id','');///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
					}else
					{
						
						$update_quantity="update book_purchase_details set quantity='$quantity ' where book_purchase_id='$book_purchase_id'  and book_id='$book_id_existed' ";
						$book_id=$os->mq($update_quantity);
					
					
					}
	
	}
	
	
	  
     
	
	
	
	
	
	 
echo '##--book_purchase_data_form--##';
	// echo '---------tttttttttt-------------';
echo '##--book_purchase_data_form--##';


 $sel="select * from book_purchase where  book_purchase_id='$book_purchase_id' ";
		$book_purchase=$os->mq($sel);
		$book_purchase_data=$os->mfa($book_purchase);
		
		 
		     echo '##--book_purchase_data_json--##';
	       //  echo json_encode($book_purchase_data);
             echo '##--book_purchase_data_json--##';


echo '##--book_purchase_data_list--##';
	   if($book_purchase_id>0)
	   {
	
		
		$queryString="select * from book_purchase_details where  book_purchase_id='$book_purchase_id'  ";
		$bookList= $os->getIdsDataFromQuery($queryString,'book_id','book','book_id',$fields='',$returnArray=true,$relation='121',$otherCondition=''); 
		
		$record_rs=$os->mq($queryString);
		//_d($bookList);
		
		?>
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >		
			<td >#</td>		
			<td ><b>book_purchase_id</b></td>  
			<td ><b>book_id</b></td>  
			<td ><b>quantity</b></td>  
			<td ><b>amount</b></td> 	
		</tr>
	
	<? $serial=0;
		while($record=$os->mfa($record_rs))
		{$serial++;
		
		$book=$bookList[$record['book_id']];
		
		
		 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							 
<td><img src="<?php  echo $site['url'].$book['image']; ?>"  height="50" width="50" /></td>  								
<td><?php echo $book['code']?> </td>  
  <td><?php echo $book['name']?> </td>  
  <td><?php echo $record['quantity']?></td>  
  <td><?php echo $record['amount']?> </td>  
  </tr>
 
  				  
		<? 
						  
		   
		}
		
		?>
		</table>
		
		<? 
	
	}
echo '##--book_purchase_data_list--##';

echo '##--book_purchase_id--##';echo $book_purchase_id;echo '##--book_purchase_id--##';


exit();
}
 
 if($os->get('book_search_ajax')=='OK' && $os->post('book_search_ajax')=='OK')
{
  
$wt_action=$os->post('wt_action');
$search_book_key=$os->post('search_book_key');
 
  
		 
echo '##--book_search_data_form--##';
 $sel="select * from book where  name like '%$search_book_key%' limit 1 ";
	$record_rs=$os->mq($sel);
	
	
	
	while($record=$os->mfa($record_rs))
	{
	    
	   ?>
	    <h1> <?php echo $record['name']?>  </h1>
	   <img src="<?php  echo $site['url'].$record['image']; ?>" id="image_searched_book" style="height:300px; widows:200px;"/>
	   <input type="hidden" name="searched_booked_id" id="searched_booked_id" value="<?php echo $record['book_id']?>" />
	   <br />
	  
	   <? 
	}
	
	 
echo '##--book_search_data_form--##';
echo '##--book_search_data_list--##';
	
	
	 
	
	
	
	 $sel="select * from book where  name like '%$search_book_key%' ";
	$record_rs=$os->mq($sel);
	
	
	?>
	
	 <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >		
			<td >#</td>		
			<td ><b>Code</b></td>  
			<td ><b>Name</b></td>  
			<td ><b>Image</b></td>  
			<td ><b>Author</b></td> 	
		</tr>
							
	<? 
	$serial=0;
	while($record=$os->mfa($record_rs))
	{
	   
						  	 
						 
							 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							 
								
<td><?php echo $record['code']?> </td>  
  <td><?php echo $record['name']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="50" width="50" /></td>  
  <td><?php echo $record['author']?> </td>  
  </tr>
 
                          <? 
						  
						 
						  } ?>  
							
		
		
			
							 
		</table>
	   <? 
	 
echo '##--book_search_data_list--##';

exit(); 
}
if($os->get('purchase_register_ajax')=='OK' && $os->post('purchase_register_ajax')=='OK')
{
  
$wt_action=$os->post('wt_action');
 
	
  
	
	  
     
	
	
	
	
	
	 
echo '##--purchase_register_data_form--##';
	 
echo '##--purchase_register_data_form--##';
echo '##--purchase_register_data_list--##';

$sel="select * from book_purchase order by book_purchase_id DESC";
	$record_rs=$os->mq($sel);
$serial=0;

?>
	
	 <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >		
			<td >#</td>		
			<td ><b>Bill NO</b></td>  
			<td ><b>Purchase id</b></td>  
			<td ><b>Date</b></td>  
			<td ><b>Amount</b></td> 	
		</tr>
							
	<? 	
while($record=$os->mfa($record_rs))
	{
	$serial++;
							    
			   
							 ?>
						<tr class="trListing">
						<td><?php echo $serial; ?>     </td>
						
						<td><?php echo $record['bill_no']?> </td>  
						<td><?php echo $record['book_purchase_id']?> </td>  
						<td><?php echo $os->showDate($record['dated']);?> </td>  
						<td><?php echo $record['total_amount']?> </td>  
						
						</tr>
						
                          <? 
						  
	 
	}
	
	 
echo '##--purchase_register_data_list--##';

exit();
}

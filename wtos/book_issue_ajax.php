<?

/*

   # wtos version : 1.1

*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
//$pluginName='';
//$os->loadPluginConstant($pluginName);

if($os->get('book_issue_ajax')=='OK' && $os->post('book_issue_ajax')=='OK')
{
$searched_booked_id=$os->post('searched_booked_id');  
$wt_action=$os->post('wt_action');

$member_table_id=$os->post('member_table_id');
$member_table=$os->post('member_table');

  $return_to_list_book_id=$os->post('return_to_list_book_id');
  $issue_type=$os->post('issue_type');



if($member_table==''){$member_table='student';}


   $quantity_be_added=$os->post('quantity_be_added');
   
   if($issue_type=='missing')
	{
	$member_table_id=1;
	$member_table='missing';
	}
   
   
	if($wt_action=='add_to_list' && $searched_booked_id>0  && $member_table_id!=''   && $member_table!='')
	{     
	           if($quantity_be_added<1)
				{
				    $quantity_be_added=1;
				}

			
				
				
					
					
					$book_id_existed=0;				
					$duplicate_query="select * from book_issue where 
					member_table_id='$member_table_id' and  member_table='$member_table'  
					and is_return='' and  book_id='$searched_booked_id' limit 1 ";
					
					
					$book_id_rs=$os->mq($duplicate_query);
					$book_details=$os->mfa($book_id_rs);
					if(isset($book_details['book_id']))
					{
					  $book_id_existed=$book_details['book_id'];
					  
					}
					
					if($member_table=='missing') { $book_id_existed=0;} //not need to filter
					
					if(!$book_id_existed)
					{
					   
						$dataToSave=array();					      
						$dataToSave['issue_date']=$os->now();
						$dataToSave['book_id']=$searched_booked_id;
						 
						
						$dataToSave['member_type']=''; 
						$dataToSave['member_table_id']=$member_table_id; 
						$dataToSave['member_table']=$member_table; 
						$dataToSave['is_return']=''; 
						
						$dataToSave['issue_type']=$issue_type; 
						
						
						$dataToSave['addedDate']=$os->now();	
						$dataToSave['addedBy']=$os->userDetails['adminId'];
						 
					 
						$qResult=$os->save('book_issue',$dataToSave,'book_issue_id','');///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
					} 
	
	}
	
	
	  if($wt_action=='return_to_list' && $return_to_list_book_id>0  && $member_table_id!=''   && $member_table!='')
	{
	      $return_date=$os->now();	
	        $subquery= "update book_issue set is_return=1 ,  return_date='$return_date' where  member_table_id='$member_table_id'    and book_issue_id='$return_to_list_book_id'  ";
            $subquery_rs=$os->mq($subquery);    
		
	
	}
     
	
	
	
	
	
	 
echo '##--book_issue_data_form--##';
	// echo '---------tttttttttt-------------';
echo '##--book_issue_data_form--##';
 

      //$sel="select * from book_issue where member_table_id='$member_table_id' and  member_table='$member_table'  
				//	and is_return='' ";
	//	$book_issue=$os->mq($sel);
		///$book_issue_data=$os->mfa($book_issue);
		
		 
		     echo '##--book_issue_data_json--##';
	      //   echo json_encode($book_issue_data);
             echo '##--book_issue_data_json--##';


echo '##--book_issue_data_list--##';
	   if($member_table_id>0)
	   {
	
		
		$queryString="select * from book_issue where member_table_id='$member_table_id' and  member_table='$member_table'  
				 	and is_return='' order by book_issue_id desc   ";
		$bookList= $os->getIdsDataFromQuery($queryString,'book_id','book','book_id',$fields='',$returnArray=true,$relation='121',$otherCondition=''); 
		
		$record_rs=$os->mq($queryString);
		 
		
		?>
	<h3>	Issued Book List </h3>
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >		
			<td >#</td>		
			<td ><b>book_issue_id</b></td>  
			<td ><b>book_id</b></td>  
			<td ><b>quantity</b></td>  
			<td ><b>Issue Date</b></td>  
			<td ><b>action</b></td>  
			 	
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
				<td><?php echo $os->showDate($record['issue_date'])?></td> 
				
				<td> <input type="checkbox"     onclick="check_return('<?php echo $record['book_issue_id']?>')" > Return  </td>
				
				</tr>
 
  				  
		<? 
						  
		   
		}
		
		?>
		</table>
		
		<? 
	
	}
	
	 if($member_table_id>0)
	   {
	
		
		$queryString="select * from book_issue where member_table_id='$member_table_id' and  member_table='$member_table'  
				 	and is_return='1'  ";
		$bookList= $os->getIdsDataFromQuery($queryString,'book_id','book','book_id',$fields='',$returnArray=true,$relation='121',$otherCondition=''); 
		
		$record_rs=$os->mq($queryString);
		 
		
		?>
		<br />
	<h3>	Return List</h3>
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >		
			<td >#</td>		
			<td ><b>book_issue_id</b></td>  
			<td ><b>book_id</b></td>  
			<td ><b>quantity</b></td>  
			<td ><b>Issue Date</b></td>  
			<td ><b>Return Date </b></td>  
			 	
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
				<td><?php echo $os->showDate($record['issue_date']);?></td> 
				
				<td> <?php echo $os->showDate($record['return_date']);?> </td>
				
				</tr>
 
  				  
		<? 
						  
		   
		}
		
		?>
		</table>
		
		<? 
	
	}
echo '##--book_issue_data_list--##';
$book_issue_id=0;
echo '##--book_issue_id--##';echo $book_issue_id;echo '##--book_issue_id--##';


exit();
}
 
 if($os->get('book_search_ajax')=='OK' && $os->post('book_search_ajax')=='OK')
{
  
$wt_action=$os->post('wt_action');
$search_book_key=$os->post('search_book_key');
 
  
		 
echo '##--book_search_data_form--##';
 $sel="select * from book where  name like '%$search_book_key%' limit 1 ";
	$record_rs_book=$os->mq($sel);
	
	
	
	while($record=$os->mfa($record_rs_book))
	{
	    $book_id=$record['book_id'];
		
		 $total_stock="select count(*) cc  from book_purchase_details  where  book_id='$book_id' ";
	     $record_rs=$os->mq($total_stock);
		  $record_rs=$os->mfa($record_rs);
		 $total_stock_count= $record_rs['cc'];
		 
		 $total_issued="select count(*) cc  from book_issue  where  book_id='$book_id' and is_return='' ";
	     $record_rs=$os->mq($total_issued);
		  $record_rs=$os->mfa($record_rs);
		 $total_issued_count= $record_rs['cc'];
		$stock=$total_stock_count-$total_issued_count;
	   ?>
	    <h1> <?php echo $record['name']?>  [<? echo $stock; ?>] </h1>
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
if($os->get('issue_register_ajax')=='OK' && $os->post('issue_register_ajax')=='OK')
{
  
$wt_action=$os->post('wt_action');
	
	 
echo '##--issue_register_data_form--##';
	 
echo '##--issue_register_data_form--##';
echo '##--issue_register_data_list--##';

$sel="select * from book_issue where is_return='' and  member_table!='missing' ";
	$record_rs=$os->mq($sel);
$serial=0;

?>
	
	 <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >		
			<td >#</td>		
			<td ><b>book_id</b></td>  
			<td ><b>member</b></td>  
			<td ><b>Date</b></td>  
			 
		</tr>
							
	<? 	
while($record=$os->mfa($record_rs))
	{
	$serial++;
							 
						    
			   
							 ?>
						<tr class="trListing">
						<td><?php echo $serial; ?>     </td>
						
						<td><?php echo $record['book_id']?> </td>  
						<td><?php echo $record['member_table_id']?> </td>  
						<td><?php echo $os->showDate($record['issue_date']);?> </td>  
						 
						
						</tr>
						
                          <? 
						  
	 
	}
	
	 
echo '##--issue_register_data_list--##';

exit();
}

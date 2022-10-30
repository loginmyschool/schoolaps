<? 

/*

   # wtos version : 1.1

*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
//$pluginName='';
//$os->loadPluginConstant($pluginName);

if($os->get('book_shelf_ajax')=='OK' && $os->post('book_shelf_ajax')=='OK')
{
  
 
	  
     $wt_action=$os->post('wt_action');
    $building_name=$os->post('building_name');
	$floor_name=$os->post('floor_name');
	$type=$os->post('type');
	
	$room=$os->post('room');
	$place=$os->post('place');
	
	$sub_place_A_str=$os->post('sub_place');
	 
	
	
	
	 //$button=$os->post('button');	
	 
	 if($building_name!='' && $floor_name!='' && $room!='' && $place!='' && $sub_place_A_str!='' && $wt_action=='save' )
	{
	   
	 
			$sub_place_A=array_filter(explode(',',$sub_place_A_str));
		 
			 
						foreach($sub_place_A as $sub_place)
					 			{
			
										$dataToSave=array();					      
										$dataToSave['building_name']=$building_name;
										$dataToSave['floor_name']=$floor_name; 
										$dataToSave['room']=$room; 	
										$dataToSave['place']=$place;	
										
										$dataToSave['type']=$type; 
										$dataToSave['sub_place']=$sub_place; 
										
										
										
										$dataToSave['addedDate']=$os->now();
										$dataToSave['addedBy']=$os->userDetails['adminId'];
										$dataToSave['modifyBy']=$os->now();
										$dataToSave['modifyDate']=$os->userDetails['adminId'];
										
										
										$duplicate_query="select * from book_shelf where building_name='$building_name' and floor_name='$floor_name'  
										and  room='$room'  and  place='$place'   and  type='$type'   and  sub_place='$sub_place' ";
										$book_shelf_id=$os->isRecordExist($duplicate_query,'book_shelf_id');
										   if($book_shelf_id<1)
										   {						 
										      $qResult=$os->save('book_shelf',$dataToSave,'book_shelf_id',$book_shelf_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 
										    }	
								  
			 	 		  
							 	    	  
								  }
			  
						  
						   
	   
	 }
	
	 
echo '##--book_shelf_data_form--##';

?>

			 


<?
	 
echo '##--book_shelf_data_form--##';
echo '##--book_shelf_data_list--##';

 
 $sel="select * from book_shelf  ";
	$datars=$os->mq($sel);
	$data_book=array();
	while($record=$os->mfa($datars))
    {
	
	$building_name=$record['building_name'];
	$floor_name=$record['floor_name'];
	$room=$record['room'];
	$place=$record['place'];
	$book_shelf_id=$record['book_shelf_id'];
	
	$data_book[$building_name][$floor_name][$room][$place][$book_shelf_id]=$record;
	
	
 
	}
	
	//_d($data_book);
		
 //$sel="select * from book_shelf  ";
	//$datars=$os->mq($sel);
	//while($record=$os->mfa($datars))
   // {
	
	 
	
	foreach($data_book as $building_name=>$floors )
	{ 
		?>
		 <div class="building_name"> <? echo $building_name; ?></div>
		<? 
		
		foreach($floors as $floor=>$rooms )	
		{  	
		
		?>
		<div class="floor_name"> <? echo $floor; ?></div>
		<? 
		
		foreach($rooms as $room=>$racks )	
		{  
	 ?>	
		<div class="room_name"> <? echo $room; ?></div>
		<? 
		foreach($racks as $rack=>$shelfs )	
		{  
	 ?>	
		<div class="rack_name"> <? echo $rack; ?></div>
		<? 
	 
	 
	 foreach($shelfs as  $shelf )	
		{  
	  
	 
		   
		  
		$book_shelf_id=$shelf['book_shelf_id'];
		 
		 
										 
							  $bookq="select sum(bl.book_count) book_total ,bl.book_id, b.* from book_location bl, book b
							   where bl.book_shelf_id='$book_shelf_id' 
							   and bl.book_id=b.book_id
							   
							    group by bl.book_id
							   
							   
							    "
							   
							   ;
							   $bookrs=$os->mq($bookq);
							 
										 
										?><div class="sub_place" > 
										<!--<div class="shelf_name"> </div>-->
										 <? 
										  while($books=$os->mfa($bookrs))
												{
												   ?>
												   <div class="book_png">
												   
												         <h5> <? echo $books['name']; ?> (<? echo $books['book_total']; ?>) </h5> 
														 
														 <div class="details_book" >
														 <img src="<?php  echo $site['url'].$books['image']; ?>"  height="70" width="70" />
														  <? echo $books['name']; ?> 
														 </div>
														 
													</div>
												   
												   <? 
												 
												} 
										 ?>
										
										
								
										 
												
										      <span class="addbook" title="Add Book To Self" onclick="book_location_assign('<? echo $book_shelf_id; ?>','')"> + </span> <br />
										      
										       </div> <? echo $shelf['sub_place']; ?>  <span class="removeRow_class" onclick="removeRowAjaxFunction('book_shelf','book_shelf_id','<? echo $book_shelf_id ?>','','','')">X</span> 
										
										 <div style="clear:both"> </div>
										<?
	     
	
	}}}}
	
	 }
	 
	 
 
	 
echo '##--book_shelf_data_list--##';

exit();
}
if($os->get('book_location_assign')=='OK' && $os->post('book_location_assign')=='OK')
{
  
 
	  
	$wt_action=$os->post('wt_action');
	
	$book_shelf_id=$os->post('book_shelf_id');
	$book_count_str=$os->post('book_count_str');
	$book_id_list_str=$os->post('book_id_list_str'); 
	
	
	 //$button=$os->post('button');	
	 
	 if($book_shelf_id!='' && $book_count_str!='' && $book_id_list_str!='' && $wt_action=='assign_book' )
	{
	     
	 	  
			    $book_id_list=explode(',',$book_id_list_str);
				 $book_count_list=explode(',',$book_count_str);
				 
				 _d($book_id_list);
				 _d($book_count_list);
				 
				 
		 		foreach($book_id_list as $key=> $book_id)
				{
			                           
									   
									   
									    $book_count= $book_count_list[$key];
										 
										
										$dataToSave=array();					      
										$dataToSave['book_id']=$book_id;
										$dataToSave['book_shelf_id']=$book_shelf_id; 
										$dataToSave['book_count']=$book_count; 	
										
										 	if($book_count>0){					 
										      $qResult=$os->save('book_location',$dataToSave,'book_location_id','');///    allowed char '\*#@/"~$^.,()|+_-=:££
											   } 
										     
								  
			 	 		  
							 	    	  
						}
			  
						  
						   
	   
	 }
	
	 
 

?>

			 


<?
	 
 
echo '##--book_list_data_list--##';
 
 
 	  
 
    $sel="select sum(bpd.quantity) book_count ,bpd.book_id ,b.name from book_purchase_details  bpd  ,book b where b.book_id =  bpd.book_id  group by book_id  ";
	$datars=$os->mq($sel);
	while($record=$os->mfa($datars))
	{
	     
		 						  
		?>
		
		<br />
		  <? echo $record['name'] ?> [<? echo $record['book_count'] ?>] <input type="hidden" name="book_id[]"  value="<? echo $record['book_id'] ?>" /><input type="text" name="book_count[]" value="" /> <br /> 
		  
				 
		
		 
		<?
		
		
	     
	 }
	 
	 ?>
	  <input type="button" value="ASSIGN" onclick="book_location_assign('<? echo $book_shelf_id; ?>','assign_book')"  />
	 <? 
 
	 
echo '##--book_list_data_list--##';

exit();
}
 
 


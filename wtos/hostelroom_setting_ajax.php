<? 

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php 

   #  

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

if($os->get('manage_hostemroom_setting')=='OK' && $os->post('manage_hostemroom_setting')=='OK')
{
  
 
  
    $p=$os->post();
	
	 
 
   $room_list=$os->post('room_list');
	
	$bed_list=$os->post('bed_list');
	$section=$os->post('section');
	$classes=$os->post('classes');
	
	
	 $button=$os->post('button');
	 
	
	 
	 
	 // echo " $room_list    $bed_list        $button  ";
	
	if( $room_list!='' && $bed_list!=''   && $button=='save' && $classes!='' )
	{
	   
	  
			 
						 $room_list_a=array_filter(explode(',',$room_list)); 
						 
						 $bed_list_a=array_filter(explode(',',$bed_list)); 
						 foreach($room_list_a as $key=> $room_id) 
						 {
						   $bed_no_A=array(); 
						    
						   if( $bed_list_a[$key] !='')
						    { 
						       $bed_no_A=explode('-',$bed_list_a[$key]);
							}    
						   	   
						   foreach($bed_no_A as  $bed_no) 
						    { 
							
							  
							  
						$dataToSave=array();					      
						$dataToSave['hostel_room_id']=$room_id;						 
						$dataToSave['bed_no']=$bed_no;						
						$dataToSave['section']='';
						$dataToSave['class_id']=$classes;	
						$dataToSave['addedDate']=$os->now();
						$dataToSave['addedBy']=$os->userDetails['adminId'];
						
						
					     $room_setting_id=$os->isRecordExist("select * from room_setting where  hostel_room_id='$room_id'  and bed_no='$bed_no'  ",'room_setting_id');
						
						$qResult=$os->save('room_setting',$dataToSave,'room_setting_id',$room_setting_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
							  
							  
							  
							
							}
						 
						 
						 }	 	  
						
						
						 		  
			 	 		
			   
	
	}
	
	    
		
	$y=date('Y');
	$bed_occ_by_stu="select hostel_room_id , bed_no from history  where asession= '$y' and bed_no>0 ";
	$beddetailsrs=$os->mq($bed_occ_by_stu);
	while($beddetails=$os->mfa($beddetailsrs))
	{
	   $key=$beddetails['hostel_room_id']."-".$beddetails['bed_no'];
	   $beddetails_array[$key]=$key;
	}
		
	
	$config_array=array();
	$sel="select class_id, hostel_room_id  , group_concat(bed_no) bed_list, count(*) no_of_bed from room_setting where class_id!=''  group by  class_id,hostel_room_id";
	$resset=$os->mq($sel);
	
	 while($record=$os->mfa($resset))
	{
	  
	  $config_array[$record['class_id']][$record['hostel_room_id']]=$record;
	  
	   
	}
	
	$room_array=array();
	 $query="select * from hostel_room    ";
		$rsResults=$os->mq($query);
		while($record=$os->mfa( $rsResults))
		{
		   $room_array[$record['hostel_room_id']]=$record ;
		}	
		 
	 
	 
	echo '##--manage_hostemroom_setting--##';
	
	
	
	
	
	
	?>
	 <table width="100%" border="0" cellspacing="2" cellpadding="2"> 
	<tr style>
	 <td style=" border-bottom:2px solid #000000;">Beds</td>
    <td style=" border-bottom:2px solid #000000;">Class</td>    
    
   
  </tr>
	<?
	
	foreach($config_array as $class=> $val)
	{
	
	
	?>
	 
  <tr >
  
	<td style=" border-bottom:2px solid #000000;"> 
	<?
	$total_bed=0;
	foreach($val as $room_id=> $bed_info)
	{
	 $room_info=$room_array[$room_id];
	 $total_bed=$total_bed+$bed_info['no_of_bed'];
	 
	 $hostel_room_id=$bed_info['hostel_room_id'];
	  ?>
	  <div style=" font-size:16px; color:#007EBB;padding:5px; background-color:#FCF5A9" > <span style="font-size:10px"> Building  </span>: <? echo $room_info['building_name'] ?>  <span style="font-size:10px"> Floor </span> : <? echo $room_info['floor_name'] ?>  <span style="font-size:10px">  Room_name </span> :  <? echo $room_info['room_name'] ?>   <span style="font-size:10px">   Bed count </span> <? echo $bed_info['no_of_bed'] ?>   </div>
	   <div style=" font-size:12px; color:#007EBB; padding:5px; background-color:#FFFFD7" >
	   
	   
	    <?  if($bed_info['bed_list']!='')
		{
		 $beds=explode(',',$bed_info['bed_list']);
		 
		 
		 foreach($beds as $bed_no)
		 {
		 
	             $key_bed=$hostel_room_id."-".$bed_no;
				  $bed_image='bed_normal.jpg';
				  
				  if(in_array($key_bed,$beddetails_array))
				  {
				    $bed_image='bed_normal_filled.jpg';
				  
				  }
				
				
				 ?> 
				 <div class="bed_no"> <img src="<? echo $site['url-wtos'] ?>images/<? echo $bed_image ?>" height="30"   /> <br /> <? echo $bed_no ?> </div>
				 
		 <? } ?>
				  <div style="clear:both"> </div> <? 
		
		}
		
		
		 
		
		
		
		 ?>  
		
		
		
		
		 </div>
	   
	
	<? } ?>
	
	
	</td>
	  <td style=" border-bottom:2px solid #000000;"> 
	<h1>Class <? echo  $os->classList[$class]; ?> </h1>
	
	<h3>  Total Bed : <? echo $total_bed ?></h3>
	
	
	</td>
	
    
  </tr>


	
	
	<?   
	    
	}
	 
	 echo '</table>';
	 
	
 
echo '##--manage_hostemroom_setting--##';

exit();
}
 
 


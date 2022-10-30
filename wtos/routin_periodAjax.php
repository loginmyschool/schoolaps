<? 
/*
   # wtos version : 1.1
   # page called by ajax script in examsettingDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
include('routin_settings/routin_config.php');

$pluginName='';
$os->loadPluginConstant($pluginName); 
?><?




if($os->get('get_routin_data')=='OK')
{  
     
 
		$asession_s=$os->post('asession_s');
		$branch_code_s=$os->post('branch_code_s');
		$gender_type=$os->post('gender_type');
		$action=$os->post('action');
		$no_of_class_arr=$os->post('no_of_class');
		if($action=='save_period'  && $asession_s!='' &&  $branch_code_s!='' && $gender_type!='' )
		{
		
						 $duplicate_query="select * from routin_period where  year='$asession_s' and  branch_code='$branch_code_s' and gender_type='$gender_type'";
						 $routin_period_id=$os->isRecordExist($duplicate_query,'routin_period_id');
						   
						$dataToSave=array();   
						$dataToSave['year']=$asession_s;
						$dataToSave['branch_code']=$branch_code_s;
						$dataToSave['gender_type']=$gender_type;
						$dataToSave['no_of_class']=json_encode($no_of_class_arr);
						if($routin_period_id<1)
						{
							$dataToSave['addedDate']=$os->now();
							$dataToSave['addedBy']=$os->userDetails["adminId"];
						}
						if($routin_period_id>0)
						{
								$dataToSave['modifyBy']=$os->userDetails["adminId"];
								$dataToSave['modifyDate']=$os->now();
						}
				
						$routin_period_id=$os->save('routin_period',$dataToSave,'routin_period_id',$routin_period_id );
						
						 
		
		}
		
		
	 	 $duplicate_query="select * from routin_period where  year='$asession_s' and  branch_code='$branch_code_s' and gender_type='$gender_type' limit 1";
		$routin_period_rs=$os->mq($duplicate_query);
		$routin_period_data=$os->mfa($routin_period_rs);
		$routin_period_id=$routin_period_data['routin_period_id'];
		 
		
		
		//_d($routin_period_data);
		$routin_setting_array=array();
		if(trim($routin_period_data['no_of_class'])!='')
		{
		  $routin_setting_array=json_decode($routin_period_data['no_of_class'],true);	
		}
	   
		 ?>	
		 

		 <div style="height:10px;"> </div>
		 <div style="color:#0033CC; font-weight:bold;"> Number of  class for each period</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:850px;">
						<tr>
						<td>Days</td>
						<? for($i=1;$i<= $os->period; $i++ )
						 { ?>
						<td>Period <? echo $i; ?> </td>
						 <? } ?>
						 <td>Total</td>
						</tr>
   
  
						
						<?      
						     $total_class_week=0;
								 
						 
						  foreach($os->weekday_list as $weekday_no=>$weekday_day)
						  {
						  $day=  $weekday_no;
						?>   
							   
						<tr>
						 
						
						<td><? echo $weekday_day; ?></td>
						
						
						
						 <?
						 
						 $total_class_day=0;
						 for($i=1;$i<= $os->period; $i++ )
						 {
						  $today_class=$os->val($routin_setting_array,$day,$i);
						  $total_class_day=$total_class_day+$today_class;
						  
						 ?>
						 
						 <td><input type="text" name="no_of_class[<? echo $day; ?>][<? echo  $i?>]"   
						id="<? echo $day; ?>_no_of_class_<? echo $i; ?>" style="width:35px; border:none; background:none;" onchange="get_routin_data('save_period');"
						value="<? echo $today_class; ?>"
						 />
						 
						 <? if($today_class>0){ ?>
						<a onclick="show_class_room('<? echo $day; ?>',<? echo  $i?>,'<? echo $today_class; ?>')" href="javascript:void(0)" > <img src="<? echo $site['url-wtos'] ?>/images/view_routin.png" width="15" /> </a>
						<? } ?>
						
						
						
						 </td>
						  
						 <? } ?>
						 
						 <td>  <? echo $total_class_day; ?> </td>
						</tr>  
							   
						<? 	
						
						       $total_class_week= $total_class_week+	$total_class_day;			  
						  }
						?>
						
						<tr style="background-color:#D2E9FF;">
						<td>Total Days</td>
						<? for($i=1;$i<= $os->period; $i++ )
						 { ?>
						<td> </td>
						 <? } ?>
						 <td>  <h3><? echo $total_class_week; ?></h3></td>
						</tr>
						  
						
						</table>

<? 
 }

if($os->get('get_routin_data')=='OK') // same condition bellow to seperate code in a single function call 
{  
       if($routin_period_id<1){ exit();}
       
	   
	    $asession_s=$os->post('asession_s');
		$branch_code_s=$os->post('branch_code_s');
		$gender_type=$os->post('gender_type');
		$action=$os->post('action');
		
		 
		$classId=$os->post('classId');
		$routin_section_arr=$os->post('routin_section'); // multiple select
		$routin_section=implode(',',$routin_section_arr);	
		
		$join_class='';
		if(count($routin_section_arr)>1)
		{
		$join_class='yes';
		
		}
				 
		$subjectId=$os->post('subjectId');
		$admin_id=$os->post('admin_id');
		$no_of_teachers_class=$os->post('no_of_teachers_class');
		$is_first_class=$os->post('is_first_class');
		
		
		
		 
	  // list of teachers
		
		$admins="select * from admin where branch_code='$branch_code_s' and class_teacher='Yes' and active='Active'";
		$teacher_list=array();
		$rsResults=$os->mq($admins);
		while($record=$os->mfa( $rsResults))
		{
			$teacher_list[$record['adminId']]=$record['name'].'-'.$record['username'];
		} 
		
		 // list of subjects
		
		$subjects="SELECT * FROM `subject`";
		$subject_list=array();
		$subjects_rs=$os->mq($subjects);
		while($record=$os->mfa( $subjects_rs))
		{
			$subject_list[$record['subjectId']]=$record['subjectName'];
		} 
		
		
		$no_of_teachers_class=(int)$no_of_teachers_class;
		 
		
		if($action=='save_teachers_class'  && $classId!='' &&  $routin_section!='' && $subjectId!='' && $admin_id!=''&& $no_of_teachers_class>0 && $routin_period_id!='' )
		{
		 			    /*$duplicate_query_tc="select * from routin_teacher_classes where  
						 routin_period_id='$routin_period_id' and  admin_id='$admin_id' and  class_id='$classId' and section='$routin_section'
						 and subject_code='$subjectId'
						 ";
						 $routin_teacher_classes_id=$os->isRecordExist($duplicate_query_tc,'routin_teacher_classes_id');
						   */
						   
						   
						   
						$dataToSave=array();   
						$dataToSave['routin_period_id']=$routin_period_id;
						$dataToSave['class_id']=$classId;
						$dataToSave['admin_id']=$admin_id;
						$dataToSave['section']=$routin_section;
						$dataToSave['subject_code']=$subjectId;
						$dataToSave['join_class']=$join_class;
						$dataToSave['is_first_class']=$is_first_class;
						 
						$dataToSave['no_of_class']=$no_of_teachers_class;  /// not need this field  its for reference input from user
						
						 
						if($routin_teacher_classes_id<1)
						{
							$dataToSave['addedDate']=$os->now();
							$dataToSave['addedBy']=$os->userDetails["adminId"];
						}
						if($routin_teacher_classes_id>0)
						{
								$dataToSave['modifyBy']=$os->userDetails["adminId"];
								$dataToSave['modifyDate']=$os->now();
						}
				
						//$routin_teacher_classes_id=$os->save('routin_teacher_classes',$dataToSave,'routin_teacher_classes_id',$routin_teacher_classes_id );
						for($i=1;$i<=$no_of_teachers_class;$i++)
						{
								$os->save('routin_teacher_classes',$dataToSave,'routin_teacher_classes_id','');
						}
						
						
		
		}
		
		
	 	              
					  
					  
					  $total_class_count=array();
					   $duplicate_query_tc="select * from routin_teacher_classes where routin_period_id='$routin_period_id' ";
					  
						$class_sec_data=array();
						$teacher_class=array();
						$rsResults=$os->mq($duplicate_query_tc);
						while($record=$os->mfa( $rsResults))
						{
						    $key= $record['section'].'-'.$record['subject_code'];
							$routin_teacher_classes_id=$record['routin_teacher_classes_id'];
						 	$teacher_class[$record['admin_id']][$record['class_id']][$key][$routin_teacher_classes_id]=$record;
							$class_sec=$record['class_id'].'-'.$record['section'];
							
							
							$key_for_total= $record['admin_id'].'-'.$record['class_id'].'-'.$record['section'].'-'.$record['subject_code'];
							if($record['day']!='' && $record['period_no']>0)
							{							
						       $total_class_count[$key_for_total]['routine_done']=(int)$total_class_count[$key_for_total]['routine_done']+1;
							   $total_class_count[$record['admin_id']]['routine_done']=(int)$total_class_count[$record['admin_id']]['routine_done'] +  1;
							   $total_class_count['routine_done']=(int)$total_class_count['routine_done'] +  1;
							   
							   $class_sec_data[$class_sec]['routine_done']=(int)$class_sec_data[$class_sec]['routine_done']+1;
							    
							} else
							{
							    $total_class_count[$key_for_total]['routine_not_done']=(int)$total_class_count[$key_for_total]['routine_not_done']+1;
								$total_class_count[$record['admin_id']]['routine_not_done']=  $total_class_count[$record['admin_id']]['routine_not_done']+1;
								$total_class_count['routine_not_done']=(int)$total_class_count['routine_not_done'] +  1;
								
								 $class_sec_data[$class_sec]['routine_not_done']=(int)$class_sec_data[$class_sec]['routine_not_done']+1;
							}	
							
							
						} 
						
						 
						 
			//_d($teacher_class); 	 
			//	$total_class_count		 
 
		
?> <div style="height:10px;"> </div>
    <div style="color:#0033CC; font-weight:bold;"> Number of  class  alloted for teacher per section</div>
	<div style="padding:2px;">
	
	<? 
	 $total_allotted=0;
	foreach($teacher_class as $admin_id_data=>$class_array)
	    {
		  $total_allotted_teacher=0;
		  
		   ?>
		    
		  <div style="border:1px solid #CCCCCC; margin:5px; padding:2px;"> 
		   <h3> <? echo $teacher_list[$admin_id_data]; ?> 
		    <button uk-toggle="target: #open_set_prferences_modal" type="button" onclick="set_prferences('<? echo $admin_id_data; ?>','<? echo $routin_period_id; ?>');">Preferences</button> </h3> 
		   
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:650px; background:#FFFFFF;">
		  <tr>  
				  <td style="width:50px;">Class</td>
				  <td style="width:50px;">Sec</td>
				  <td style="width:150px;">Subject</td>
				  <td style="width:150px;">Class Teacher</td>
				   <td style="width:50px;">Allotted class</td>
				    <td style="width:50px;">Routine done</td>
					 <td style="width:50px;">Routine Not Done</td>
					 <td style="width:50px;"></td>
		  </tr>
		    
						<? foreach($class_array as $class_id_data=>$sec_sub_array)
						{
						?>
						 
						      
									<? foreach($sec_sub_array as $sec_sub=>$no_of_class_arr)
									{
									   
										$sec_sub_ar=explode('-',$sec_sub);
										$sec_data=$sec_sub_ar[0];
										$sub_data=$sec_sub_ar[1];
										$no_of_class=count($no_of_class_arr);
										$routin_teacher_classes_id_str=implode(',',array_keys($no_of_class_arr));					   
									     $total_allotted_teacher= $total_allotted_teacher+$no_of_class;
									    
									   
									      $data_row = array_shift($no_of_class_arr);
									       $is_first_class= $data_row['is_first_class'];
									 
									
									  
									   
									   
									   
									   $key_for_total= $admin_id_data.'-'.$class_id_data.'-'.$sec_data.'-'.$sub_data;
											?>
											<tr>  
											<td> <? echo $os->classList[$class_id_data]; ?></td>
											<td>
											
											<? echo $sec_data  ?>  <button uk-toggle="target: #open_set_prferences_modal" type="button"  style="cursor:pointer;"
											onclick="class_routine_distribution('<? echo $routin_period_id; ?>','<? echo $class_id_data; ?>','<? echo $sec_data  ?>')">view</button> </h3>
											
											 </td>
											<td><? echo  $subject_list[$sub_data];   ?></td>
											<td><? echo  $is_first_class;   ?></td>
											
											<td title="<? echo $routin_teacher_classes_id_str; ?>" ><? echo $no_of_class ; ?></td>
											<td><? echo  $total_class_count[$key_for_total]['routine_done'];   ?></td>
										    <td><? echo  $total_class_count[$key_for_total]['routine_not_done'];   ?></td>
											<td>
											 <button   type="button" style="cursor:pointer;" 
											onclick="class_routine_delete('<? echo $routin_teacher_classes_id_str; ?>')">Del</button>
											</td>
											</tr>	 
											 
									<? 					
									}
									
									
									?>
								         		 
						   
						
						<? 					
						}
						
						?>
						
						<tr>  
											<td>  </td>
											<td> </td>
											<td> </td>
											<td> </td>
											<td><b style="font-size:16px; color:#0066FF;"><? echo $total_allotted_teacher ; ?> </b></td>
											<td><b><? echo $total_class_count[$admin_id_data]['routine_done']; ?> </b></td>
											<td><b><? echo $total_class_count[$admin_id_data]['routine_not_done'] ?> </b></td>
											<td> </td>
											
											
											</tr>
		  </table>
		  
		  
		  </div>
		   
		   
		   
		   
		   <?     
		   $total_allotted= $total_allotted+$total_allotted_teacher ;
		
		}
	   
	?>
	 <div style="border:1px solid #CCCCCC; margin:5px; padding:2px;"> 	   
	   
	    <input type="button"   value="Generate" onclick="fill_empty_slots('<? echo $routin_period_id ?>');" style="cursor:pointer;" />  
		
		<button  onclick="delete_day_period_from_routin_teacher_classes('update_day_period','<? echo $routin_period_id ?>')" class="uk-button uk-border-rounded congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"
                    type="button" onclick=" ">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Empty
            </button >  
	</div>
	 <div style="border:1px solid #CCCCCC; margin:5px; padding:2px;"> 	   
		   <!-- week total -->
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:650px; background:#FFFF99;">
		  <tr style="color:#0000FF; font-size:16px;">  
				  <td style="width:50px;"> </td>
				  <td style="width:50px;"> </td>
				  <td style="width:150px;"> TOTAL </td>
				   <td style="width:50px;"><? echo $total_allotted ; ?></td>
				   <td style="width:50px;"><? echo $total_class_count['routine_done']; ?></td>
				   <td style="width:50px;"><? echo $total_class_count['routine_not_done']; ?></td>
				   
				  
				   
				  
			
			
				   
				   
		  </tr>
	</table>	    
</h3>	
	
	</div>
	
	
	
 <div class="uk-inline" uk-tooltip="Select Teacher">
                <select name="admin_id" id="routin_admin_id" class="textbox fWidth select2">
				<option value=""> </option>	<? $os->onlyOption($teacher_list,$admin_id);	?></select>	 
            </div>
 <div class="uk-inline" uk-tooltip="Select class">
                <select name="classId" id="routin_classId" class="textbox fWidth"  onchange="wt_ajax_chain('html*routin_subjectId*subject,subjectId,subjectName*classId=routin_classId','','','');">
				<option value=""> </option>	<? $os->onlyOption($os->classList,$classId);	?></select>	 
            </div>
			
            <div class="uk-inline" uk-tooltip="Select section" style="display:none;">
                <select name="___routin_section[]" id="___routin_section" class="textbox fWidth" multiple="multiple" style="height:70px; width:60px;" >
				<option value=""> </option>	<? $os->onlyOption($os->routin_section,$routin_section);	?></select>	 
            </div>
			 <div class="uk-inline" uk-tooltip="Select section">
			 <?
			   foreach($os->routin_section as $sec_val)
			   {
			   
			   ?>
			   <input type="checkbox" name="routin_section[]" id="routin_section" value="<? echo $sec_val ?>"  /> <? echo $sec_val ?> &nbsp; 
			   <?
			   
			   }
			 
			 
			 
			  ?> 
			 
                 
            </div>
			
            <div class="uk-inline" uk-tooltip="Select subject">
                <select name="subjectId" id="routin_subjectId" class="textbox fWidth" ><option value=""> </option> </select>
            </div>
			
			
			 <div class="uk-inline" uk-tooltip="No Of Class">
			 
			 
                No Of Class <!--<input type="text" name="no_of_teachers_class" id="no_of_teachers_class" style="width:40px;"  />-->
				
				 <select name="no_of_teachers_class" id="no_of_teachers_class" class="textbox fWidth"   style=" width:60px; height:60px;" >
				<option value=""> </option>	<? $os->onlyOption(array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6));	?></select>	 
				
            </div>
			
			 <div class="uk-inline" uk-tooltip="Class Teacher">
                <select name="is_first_class" id="is_first_class" class="textbox fWidth"   style=" width:60px; height:60px;" >
				<option value=""> </option>	<? $os->onlyOption($os->is_first_class_arr);	?></select>	 
            </div>
			 
			
			<input type="button"   value="Add" onclick="get_routin_data('save_teachers_class');" style="cursor:pointer; background-color:#009900; color:#FFFFFF;" />  
			
			
			
		
			
	 
	
<h3 style="margin:5px;"> Data entry report  	<input type="button" value="Refresh"  onclick="get_routin_data('')"  /> </h3> 
<? 	

   // $teacher_query="select admin_id count(*) row_count 
	//from routin_teacher_classes  where routin_period_id='$routin_period_id' group by  admin_id   "; 
	//$teacher_query_rs=$os->mq($teacher_query);
	
	//d($teacher_class); 	 
			//	$total_class_count		
	 
	?>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table class="noBorder" style="width:350px; background-color:#FFFFFF; ">
		 <tr>  <td>   </td> 
			 <td>Teacher </td> 
			 <td> Class Alloted</td> 
			 <td> Done</td> 
			 <td> Not Done</td> 
		 </tr>
	<? 
	 $ii=0;
	$total_class_aloted=0;
	foreach($teacher_class as $admin_id => $val)
	{
	  $ii++;
		$total_class= $total_class_count[$admin_id];	
		
		$routine_not_done=$total_class['routine_not_done'];
		$routine_done=$total_class['routine_done'];
		$total=$routine_not_done+$routine_done;
		$total_class_aloted=$total_class_aloted + $total;
		
		$total_class_done=$total_class_done + $routine_done;
		$total_class_not_done=$total_class_not_done + $routine_not_done;
	   ?>
	    <tr> <td> <? echo  $ii ?></td>
			 <td> <b style="cursor:pointer;" uk-toggle="target: #open_set_prferences_modal" onclick="set_prferences('<? echo $admin_id; ?>','<? echo $routin_period_id; ?>');" > <? echo $teacher_list[$admin_id]; ?> </b></td> 
			 <td><? echo $total ?> </td> 
			<td><? echo $routine_done ?> </td> 
			<td><? echo $routine_not_done ?> </td>  
			
			 
		 </tr>
		<?   
	} 				  

?>	

<tr>  <td>   </td> 
			 <td>Total  </td> 
			 <td> <? echo $total_class_aloted; ?></td> 
			 <td> <? echo $total_class_done; ?>  </td> 
			 <td>  <? echo $total_class_not_done; ?> </td> 
			 
		 </tr>

 

</table></td>
    <td valign="top">
	
<?  
	
	$class_query="select class_id,section,   count(*) row_count 
	 from routin_teacher_classes  where routin_period_id='$routin_period_id' group by  class_id,section   "; 
	 $class_query_rs=$os->mq($class_query); 
?>
	
	<table class="noBorder" style="width:350px; background-color:#FFFFFF; ">
		 <tr> 
		  <td> </td> 
			 <td>Class </td> 
			 <td> Sec</td> 
			 <td> Allotted  </td> 
			 <td> Done  </td> 
			 <td> Not Done </td> 
			 <td> </td> 
		 </tr>
	<? 
	  
	$total_class_aloted=0;
	$ii=0;
	while($record= $os->mfa($class_query_rs))
	{
	   $ii++;
	   $class_id=$record['class_id'];
	    $section=$record['section'];
		
		$row_count=$record['row_count'];
		 
		$total_class_aloted=$total_class_aloted + $row_count;
		$class_sec=$class_id.'-'.$section;
		
		 
		
		$routine_done=$class_sec_data[$class_sec]['routine_done'];
		$routine_not_done=$class_sec_data[$class_sec]['routine_not_done'];
		 $routine_done_total=$routine_done+$routine_done_total;
		 $routine_not_done_total=$routine_not_done+$routine_not_done_total;
	   ?>
	    <tr> 
		<td> <? echo  $ii ?></td>
			 <td>   <? echo $os->classList[$class_id]; ?> </td> 
			 <td><? echo $section ?> </td> 
			<td><? echo $row_count ?>  </td> 
			<td>  <? echo $routine_done ?>   </td>  
			<td>  <? echo $routine_not_done ?>   </td>  
			<td><button uk-toggle="target: #open_set_prferences_modal" type="button"  style="cursor:pointer;"
											onclick="class_routine_distribution('<? echo $routin_period_id; ?>','<? echo $class_id; ?>','<? echo $section  ?>')">view</button> </td>  
			
		 </tr>
		<?   
	} 				  

?>	

<tr>        <td> </td> 
			 <td>Total  </td> 
			 <td>  </td> 
			 <td> <? echo $total_class_aloted; ?>  </td> 
			 <td>  <? echo $routine_done_total; ?>   </td> 
			 <td><? echo $routine_not_done_total; ?>  </td> 
			  <td> </td> 
		 </tr>

 

</table></td>
  </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:10px; background-color:#FFFFFF;">
	
 
	
	<? 
	
	 $duplicate_query_tc="select * from routin_teacher_classes where routin_period_id='$routin_period_id' ";
	 $day_teacher_period=array();				  
	 $day_class_period=array();
	$rsResults=$os->mq($duplicate_query_tc);
	while($record=$os->mfa( $rsResults))
	{
	
	  $class_name=$os->classList[$record['class_id']];
	  $subject_name=$subject_list[$record['subject_code']];
	  $day_teacher_period[$record['day']][$record['admin_id']][$record['period_no']]=$class_name.'-'.$record['section'].' - '.$subject_name ;
	  
	  $admin_name=$teacher_list[$record['admin_id']];
	  $sec=$record['class_id'].'_'.$record['section'];
	  $day_class_period[$record['day']][$sec][$record['period_no']]=$admin_name.' -'.$subject_name ;
	   
	  // class_id  // section / subject_code
	}
	
	?>
	<ul class="uk-subnav uk-subnav-pill" uk-switcher>
	<? 
	foreach($os->weekday_list as $day_no=>$day_str ) {
	
	?>
    <li><a href="#"> <? echo $day_str; ?>  </a></li>
	<? 
	
	}
	?>
	</ul>
	<ul class="uk-switcher uk-margin">
	<?  
	 
	 
	foreach($os->weekday_list as $day_no=>$day_str ) {
	
	?> <li><? 
	
	
	 ?>
	<div class="day_class" >
	 <div class="day_class_name" > <? echo $day_str; ?>  </div>
	
	 <table class="noBorder" style="width:100%; background-color:#FFFFFF; ">
		 <tr>  <td> #  </td> 
			 <td>Teacher </td> 
			 <? for($period_no=1;$period_no<=$os->period;$period_no++)
			    {
			  ?>
			      <td><? echo $period_no; ?> </td> 
			 <?   }  ?>
			 
			 
			 
		 </tr>
	<? 
	 $ii=0;
	$total_class_aloted=0;
	foreach($teacher_class as $admin_id => $val)
	{
	  $ii++;
		/*$total_class= $total_class_count[$admin_id];	
		
		$routine_not_done=$total_class['routine_not_done'];
		$routine_done=$total_class['routine_done'];
		$total=$routine_not_done+$routine_done;
		$total_class_aloted=$total_class_aloted + $total;
		
		$total_class_done=$total_class_done + $routine_done;
		$total_class_not_done=$total_class_not_done + $routine_not_done;*/
	  
	  
	   ?>
	    <tr> <td> <? echo  $ii ?></td>
			 <td> <b style="cursor:pointer;" uk-toggle="target: #open_set_prferences_modal" onclick="set_prferences('<? echo $admin_id; ?>','<? echo $routin_period_id; ?>');" > <? echo $teacher_list[$admin_id]; ?> </b></td> 
			 <? for($period_no=1;$period_no<=$os->period;$period_no++)
			    {
				
				
				
			  ?>
			      <td>
				  
				  <? echo $day_teacher_period[$day_no][$admin_id][$period_no]; ?> </td> 
			 <?   }  ?>
			
			 
		 </tr>
		<?   
	} 				  

?>	

 
 

</table>

    </div>
   
   
   
   <? 
     ?></li>  <? 
   } ?>
</ul>
<style>
.day_class{ margin:10px; background-color:#FFFFD5; border:1px solid #FF9900; padding:5px;}
.day_class .noBorder td{ border-right:1px solid #CCCCCC; padding:1px; height:auto;}
.day_class_name{ font-size:18px;}
</style>
</td>
   
  </tr>
  
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td style="padding:10px; background-color:#FFFFFF;">
	
 
	
	<? 
	
	   $duplicate_query_tc="select * from routin_teacher_classes where routin_period_id='$routin_period_id' ";
	 $day_teacher_period=array();				  
	 $day_class_period=array();
	$rsResults=$os->mq($duplicate_query_tc);
	while($record=$os->mfa( $rsResults))
	{
	
	  $class_name=$os->classList[$record['class_id']];
	  $subject_name=$subject_list[$record['subject_code']];
	  $day_teacher_period[$record['day']][$record['admin_id']][$record['period_no']]=$class_name.'-'.$record['section'].' <br> '.$subject_name ;
	  
	  $admin_name=$teacher_list[$record['admin_id']];
	  $sec=$record['class_id'].'_'.$record['section'];
	  $day_class_period[$record['day']][$sec][$record['period_no']]=$admin_name.' <br> '.$subject_name ;
	   
	  // class_id  // section / subject_code
	}
	
	//_d($day_class_period);
	
	?>
	<ul class="uk-subnav uk-subnav-pill" uk-switcher>
	<? 
	foreach($os->weekday_list as $day_no=>$day_str ) {
	
	?>
    <li><a href="#"> <? echo $day_str; ?>  </a></li>
	<? 
	
	}
	?>
	</ul>
	<ul class="uk-switcher uk-margin">
	<?  
	 
	 
	foreach($os->weekday_list as $day_no=>$day_str ) {
	
	?> <li><? 
	
	
	 ?>
	<div class="day_class" >
	 <div class="day_class_name" > <? echo $day_str; ?>  </div>
	
	 <table class="noBorder" style="width:100%; background-color:#FFFFFF; ">
		 <tr>  <td> #  </td> 
			 <td>Teacher </td> 
			 <? for($period_no=1;$period_no<=$os->period;$period_no++)
			    {
			  ?>
			      <td><? echo $period_no; ?> </td> 
			 <?   }  ?>
			 
			 
			 
		 </tr>
	<? 
	 $ii=0;
	$total_class_aloted=0;
	$ii=0;
	  $class_query="select class_id,section,   count(*) row_count 
	 from routin_teacher_classes  where routin_period_id='$routin_period_id' group by  class_id,section   "; 
	  $class_query_rs=$os->mq($class_query); 
	while($record= $os->mfa($class_query_rs))
	{
	   $ii++;
	     
		  $sec=$record['class_id'].'_'.$record['section'];
	  
	   ?>
	    <tr> <td>   <button uk-toggle="target: #open_set_prferences_modal" type="button"  style="cursor:pointer;"
											onclick="class_routine_distribution('<? echo $routin_period_id; ?>','<? echo $record['class_id']; ?>','<? echo $record['section'] ?>')">view</button>  <? echo  $ii ?></td>
			 <td> 
			 
			 <? echo $os->classList[$record['class_id']]; ?>  <? echo $record['section'] ?>
			
			 </td> 
			 <? for($period_no=1;$period_no<=$os->period;$period_no++)
			    {
				
				
				
			  ?>
			      <td>
				  
				  <? echo $day_class_period[$day_no][$sec][$period_no]; ?> </td> 
			 <?   }  ?>
			
			 
		 </tr>
		<?   
	} 				  

?>	

 
 

</table>

    </div>
   
   
   
   <? 
     ?></li>  <? 
   } ?>
</ul>

</td>
   
  </tr>
  
  
</table>

	<style>
.day_class{ margin:10px; background-color:#FFFFD5; border:1px solid #FF9900; padding:5px;}
.day_class .noBorder td{ border-right:1px solid #CCCCCC; font-size:11px; color:#333333;}
.day_class_name{ font-size:18px;}
</style>
	
	






<? 
}

 
if($os->get('class_routine_distribution')=='OK')
{
 	 
	$class_id=$os->post('class_id');
	$section=$os->post('section');
	$routin_period_id=$os->post('routin_period_id');
	
	 
	$routin_period= $os->rowByField('',$tables='routin_period',$fld='routin_period_id',$fldVal=$routin_period_id,$where='',$orderby='');
	 
	
	    $subjects="SELECT * FROM `subject`";
		$subject_list=array();
		$subjects_rs=$os->mq($subjects);
		while($record=$os->mfa( $subjects_rs))
		{
			$subject_list[$record['subjectId']]=$record['subjectName'];
		}  
	
	// list of teachers
	$branch_code_s=$routin_period['branch_code'];
		
		$admins="select * from admin where branch_code='$branch_code_s' and class_teacher='Yes' and active='Active'";
		$teacher_list=array();
		$rsResults=$os->mq($admins);
		while($record=$os->mfa( $rsResults))
		{
			$teacher_list[$record['adminId']]=$record['name'].'-'.$record['username'];
		} 
		
		 // list of subjects
		 
	
	    
		 
		
	
	
	                    
	
	                    $grid_routine_done=array();
					    $total_class_count=array();
						
	                    $duplicate_query_tc="select * from routin_teacher_classes where routin_period_id='$routin_period_id' and  class_id='$class_id' and  section LIKE '%$section%'";
					    $routin_class=array();
						$rsResults=$os->mq($duplicate_query_tc);
						$total_class=0;
						while($record=$os->mfa( $rsResults))
						{
						
						 
						$routin_alocated[$record['day']][$record['period_no']]=  $record; 
						$total_class=$total_class+1;
						} 
	
	  
	 
	
	?>
	  
	 <!-- week total -->
	<!-- <div style="border:1px solid #CCCCCC; margin:5px; padding:2px;"> 	   
		   
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:650px; background:#FFFF99;">
		   <tr style="color:#0000FF; font-size:16px;">  
				  <td style="width:50px;">  </td>
				   <td style="width:150px;"> </td>
				  <td style="width:150px;"> TOTAL</td>
				   <td style="width:50px;"><? echo $total_allotted ; ?></td>
				   <td style="width:50px;"><? echo $total_class_count['routine_done']; ?></td>
				   <td style="width:50px;"><? echo $total_class_count['routine_not_done']; ?></td>
		  </tr>
	</table>	    
 </div>	
	 -->
	 
	<div style="color:#0033CC; font-weight:bold;"> Routine for class <? echo $class_id ?>  <? echo $section ?>  Total Class: <? echo $total_class; ?>  </div>
	
	<? 
	
	$routin_grid=json_decode($routin_period['no_of_class'],true);
	
	 
	
	 ?>
	
	
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:1300px;">
						<tr>
						<td>Days</td>
						<? for($i=1;$i<= $os->period; $i++ )
						 { ?>
						<td>Period <? echo $i; ?> </td>
						 <? } ?>
						 
						</tr>
   
  
						
						<?      
						     $total_class_week=0;
								 
						
						  foreach($routin_grid as $day=>$class_counts)
						  {
						?>   
							   
						<tr>
						 
						
						<td style="width:80px;height:50px; border-right:1px solid #EAEAEA;"><? echo $os->weekday_list[$day]; ?></td>
						
						
						
						 <?
						 
						 
						 foreach($class_counts as $period=>$class_count)
						 {
						 
						  
						  
						   $today_class=   $routin_alocated[$day][$period];
						   
						  
						   
						   $admin_id=$today_class['admin_id'];
						    
						  
						   $class_name='';
						 $background_color='';
						 
						  
						  
						 if(count($today_class)>0){ 
						      
                              $background_color='#E6F2FF';
							   
							                   $class_name='Class: '.$os->classList[$today_class['class_id']].' - Sec: '.$today_class['section'];
						  }  
						
						 ?>
						 
						 <td style="border-right:1px solid #EAEAEA;background-color:<? echo  $background_color ?>; font-size:10px;">
						 
						 <? echo $teacher_list[$admin_id]; ?> <br />
						 
						 <? echo $subject_list[$today_class['subject_code'] ];  ?>
						
						 <br /> <div style="font-size:10px; color:#FF3300"><? echo $class_count; ?></div>
						
						 </td>
						  
						 <? } ?>
						 
						 
						</tr>  
							   
						<? 	
						
						        	  
						  }
						?>
						
						 
						  
						
						</table>
	
	<? 
}


if($os->get('set_prferences')=='OK')
{ 
     
	
	$admin_id=$os->post('admin_id');
	$routin_period_id=$os->post('routin_period_id');
	
	$admin= $os->rowByField('',$tables='admin',$fld='adminId',$fldVal=$admin_id,$where='',$orderby='');
	$routin_period= $os->rowByField('',$tables='routin_period',$fld='routin_period_id',$fldVal=$routin_period_id,$where='',$orderby='');
	
	
	
	    $subjects="SELECT * FROM `subject`";
		$subject_list=array();
		$subjects_rs=$os->mq($subjects);
		while($record=$os->mfa( $subjects_rs))
		{
			$subject_list[$record['subjectId']]=$record['subjectName'];
		}  
	
	//_d($admin);
	
	    
		 
		
	
	
	                    
	
	                    $grid_routine_done=array();
					    $total_class_count=array();
						
	                    $duplicate_query_tc="select * from routin_teacher_classes where routin_period_id='$routin_period_id' and  admin_id='$admin_id'";
					    $teacher_class=array();
						$rsResults=$os->mq($duplicate_query_tc);
						while($record=$os->mfa( $rsResults))
						{
						    $key= $record['section'].'-'.$record['subject_code'];
							$routin_teacher_classes_id=$record['routin_teacher_classes_id'];
						 	$teacher_class[$record['admin_id']][$record['class_id']][$key][$routin_teacher_classes_id]=$routin_teacher_classes_id;
							
							
							
							$key_for_total= $record['admin_id'].'-'.$record['class_id'].'-'.$record['section'].'-'.$record['subject_code'];
							if($record['day']!='' && $record['period_no']>0)
							{							
						       $total_class_count[$key_for_total]['routine_done']=(int)$total_class_count[$key_for_total]['routine_done']+1;
							   $total_class_count[$record['admin_id']]['routine_done']=(int)$total_class_count[$record['admin_id']]['routine_done'] +  1;
							   $total_class_count['routine_done']=(int)$total_class_count['routine_done'] +  1;
							    
														
							} else
							{
							    $total_class_count[$key_for_total]['routine_not_done']=(int)$total_class_count[$key_for_total]['routine_not_done']+1;
								$total_class_count[$record['admin_id']]['routine_not_done']=  $total_class_count[$record['admin_id']]['routine_not_done']+1;
								$total_class_count['routine_not_done']=(int)$total_class_count['routine_not_done'] +  1;
							}	
							
							
							
							
							if($record['day']!='' && $record['period_no']>0)
							{
							    $grid_key=$record['day'].'-'.$record['period_no'];
							    $grid_routine_done[$grid_key]=$record;
							   
							}	 				
						
						
						} 
	
	  
	 
	
	?>
	  <? 
	 $total_allotted=0;
	foreach($teacher_class as $admin_id_data=>$class_array)
	    {
		  $total_allotted_teacher=0;
		  
		   ?>
		    
		  <div style="border:1px solid #CCCCCC; margin:5px; padding:2px;"> 
		   <h3> <? echo $admin['name']; ?>  </h3>
		    
		   
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:650px; background:#FFFFFF;">
		  <tr>  
				  <td style="width:50px;">Class</td>
				  <td style="width:50px;">Sec</td>
				  <td style="width:150px;">Subject</td>
				   <td style="width:50px;">Allotted class</td>
				   <td style="width:50px;">Routine Done</td>
				   <td style="width:50px;">Routine not Done</td>
		  </tr>
		    
						<? foreach($class_array as $class_id_data=>$sec_sub_array)
						{
						?>
						 
						      
									<? foreach($sec_sub_array as $sec_sub=>$no_of_class_arr)
									{
									 
										$sec_sub_ar=explode('-',$sec_sub);
										$sec_data=$sec_sub_ar[0];
										$sub_data=$sec_sub_ar[1];
										$no_of_class=count($no_of_class_arr);
										$routin_teacher_classes_id_str=implode(',',$no_of_class_arr);
										$total_allotted_teacher= $total_allotted_teacher+$no_of_class;
										
										$key_for_total= $admin_id_data.'-'.$class_id_data.'-'.$sec_data.'-'.$sub_data;
										
										
											?>
											<tr>  
											<td> <? echo $os->classList[$class_id_data]; ?></td>
											<td><? echo $sec_data  ?> </td>
											<td><? echo  $subject_list[$sub_data];   ?></td>
											 
											
											<td title="<? echo $routin_teacher_classes_id_str; ?>" ><? echo $no_of_class ; ?></td>
											<td><? echo  $total_class_count[$key_for_total]['routine_done'];   ?></td>
										    <td><? echo  $total_class_count[$key_for_total]['routine_not_done'];   ?></td>
											
											
											</tr>	 
											 
									<? 					
									}
									
									
									?>
								         		 
						   
						
						<? 					
						}
						
						?>
						
						<tr>  
											<td>  </td>
											<td> </td>
											<td> </td>
											<td><b style="font-size:16px; color:#0066FF;"><? echo $total_allotted_teacher ; ?> </b></td>
											<td><b><? echo $total_class_count[$admin_id_data]['routine_done']; ?> </b></td>
											<td><b><? echo $total_class_count[$admin_id_data]['routine_not_done'] ?> </b></td>
											</tr>
		  </table>
		  
		  
		  </div>
		   
		   
		   
		   
		   <?     
		   $total_allotted= $total_allotted+$total_allotted_teacher ;
		
		}
	   
	?>
	 <!-- week total -->
	<!-- <div style="border:1px solid #CCCCCC; margin:5px; padding:2px;"> 	   
		   
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:650px; background:#FFFF99;">
		   <tr style="color:#0000FF; font-size:16px;">  
				  <td style="width:50px;">  </td>
				   <td style="width:150px;"> </td>
				  <td style="width:150px;"> TOTAL</td>
				   <td style="width:50px;"><? echo $total_allotted ; ?></td>
				   <td style="width:50px;"><? echo $total_class_count['routine_done']; ?></td>
				   <td style="width:50px;"><? echo $total_class_count['routine_not_done']; ?></td>
		  </tr>
	</table>	    
 </div>	
	 -->
	 
	<div style="color:#0033CC; font-weight:bold;"> Preferences for teacher </div>
	
	<? 
	
	$routin_grid=json_decode($routin_period['no_of_class'],true);
	
	
	
	 ?>
	
	
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:1300px;">
						<tr>
						<td>Days</td>
						<? for($i=1;$i<= $os->period; $i++ )
						 { ?>
						<td>Period <? echo $i; ?> </td>
						 <? } ?>
						 
						</tr>
   
  
						
						<?      
						     $total_class_week=0;
								 
						
						  foreach($routin_grid as $day=>$class_counts)
						  {
						?>   
							   
						<tr>
						 
						
						<td style="width:80px;height:50px; border-right:1px solid #EAEAEA;"><? echo $os->weekday_list[$day]; ?></td>
						
						
						
						 <?
						 
						 
						 foreach($class_counts as $period=>$class_count)
						 {
						 
						  $grid_key=$day.'-'.$period;
						  
						  
						  
						  $slot_details_array=array();
						  if(isset($grid_routine_done[$grid_key]))
						  {
						     $slot_details_array =$grid_routine_done[$grid_key];
						  }
						  
						   $class_name='';
						 $background_color='';
						 
						  
						  
						 if(count($slot_details_array)>0){ 
						      
                              $background_color='#E6F2FF';
							   
							                   $class_name='Class: '.$os->classList[$slot_details_array['class_id']].' - Sec: '.$slot_details_array['section'];
						  }  
						
						 ?>
						 
						 <td style="border-right:1px solid #EAEAEA;background-color:<? echo  $background_color ?>">
						 
						 <? echo $class_name; ?> <br />
						 
						 <? echo $subject_list[$slot_details_array['subject_code'] ];  ?>
						
						 <br /> <div style="font-size:10px; color:#FF3300"><? echo $class_count; ?></div>
						
						 </td>
						  
						 <? } ?>
						 
						 
						</tr>  
							   
						<? 	
						
						        	  
						  }
						?>
						
						 
						  
						
						</table>
	
	<? 
}

if($os->get('show_class_room')=='OK')
{ 

			$post=$os->post();
			$day=$post['day'];
			$periods=$post['periods'];
			$no_of_class=$post['no_of_class'];
			?>
			
			<h3> Day: <? echo $day; ?>    Period: <? echo $periods; ?>  </h3>
			   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:1050px;">
						<tr><td>
						 
						<? for($i=1;$i<= $no_of_class; $i++ )
						 { ?>
						           <div id="class_<? echo $i; ?>" class="classroom_daily"> <? echo $i; ?> </div> 
						 <? } ?>
						  </td>
						</tr>
				</table>
			
	<? 		 
         
}

if($os->get('manage_number_of_class')=='OK')
{ 

			$post=$os->post();
			$day=$post['day'];
			$perod=$post['perod'];
			$fld_val=$post['fld_val'];
			
			 
			
			
			 
			 $file_path='routin_settings/routin_setting.txt';
			
			$routin_setting_array=array();
			$routin_setting =  file_get_contents($file_path);
			if($routin_setting ){
			
			      $routin_setting_array=json_decode($routin_setting,true);
			
			}
			$routin_setting_array[$day][$perod]=$fld_val;
			$routin_setting=json_encode($routin_setting_array);
			
			file_put_contents($file_path, $routin_setting);
			
			
			
			 
			echo 'Setting Updated';
         
}


if($os->get('fill_empty_slots')=='OK')
{ 

      $os->loop=0;
	  

	$routin_period_id=$os->post('routin_period_id'); 
	
	$routin_period_id=$os->post('routin_period_id'); 
	$routin_period= $os->rowByField('',$tables='routin_period',$fld='routin_period_id',$fldVal=$routin_period_id,$where='',$orderby='');
	$routin_slotes=json_decode($routin_period['no_of_class'],true);
	$seqence=1;
	
	
	##======================= seqence 2 ======================================##
	if($seqence==2)
	{
	
	$class_data_query="select * from routin_teacher_classes where routin_period_id='$routin_period_id' 
	order by  class_id asc,section asc ";
	 
	 
	
	 
	
	$rsResults=$os->mq($class_data_query);  
	while($record=$os->mfa( $rsResults))
	{
			$admin_id_rec=$record['admin_id'];
			$class_id_rec=$record['class_id'];
			$section_rec=$record['section'];
			$subject_code_rec=$record['subject_code'];									
			$is_first_class=$record['is_first_class'];		
			$routin_teacher_classes_id=$record['routin_teacher_classes_id'];								
			 
			 
			  
			
			
			
			
			 foreach($os->weekday_list as $current_day_no =>$current_date_str)
			  {   

for($current_period=1;$current_period<=$os->period;$current_period++)
				{	
						
				
				 first_level_searching($routin_period_id,$current_day_no,$current_period,$routin_slotes,$routin_teacher_classes_id ,$admin_id_rec,$class_id_rec,$section_rec ,$subject_code_rec,$is_first_class,$not_allowd_successive_class);													
				
			
			   }
			   
			   }
			
			
			
			 
			 
			 
	} 
	
	echo "loop = ".$os->loop;	
	exit();
	}
	
	##======================= seqence 1 ======================================##
	
	if($seqence==1)
	{
	$teacher_class=array();
	$class_data_query="select * from routin_teacher_classes where routin_period_id='$routin_period_id' 
	order by  join_class asc, class_id asc";
	$rsResults=$os->mq($class_data_query);  
	while($record=$os->mfa( $rsResults))
	{
	
		$admin_id_rec=$record['admin_id'];
		$class_id_rec=$record['class_id'];
		$section_rec=$record['section'];
		$subject_code_rec=$record['subject_code'];									
		$row_id=$record['routin_teacher_classes_id'];
		$teacher_class[$admin_id_rec][$class_id_rec][$section_rec][$subject_code_rec][$row_id]=$record;
		
	} 
	
	
	 $class_data_query="
	select admin_id,class_id,section, subject_code, is_first_class , count(*) row_count 
	from routin_teacher_classes 
	where routin_period_id='$routin_period_id' 
	group by  admin_id,class_id,section, subject_code 
	order by is_first_class desc,  row_count desc, join_class asc, class_id asc					  
	"; 
	
	
	
	 
	 /* $class_data_query="
	select admin_id,class_id,section, subject_code, is_first_class , count(*) row_count 
	from routin_teacher_classes 
	where routin_period_id='$routin_period_id' 
	group by  admin_id,class_id,section, subject_code 
	order by row_count desc,is_first_class desc					  
	"; */
	
	 	
	$rsResults=$os->mq($class_data_query);  
	while($record=$os->mfa( $rsResults))
	{
			$admin_id_rec=$record['admin_id'];
			$class_id_rec=$record['class_id'];
			$section_rec=$record['section'];
			$subject_code_rec=$record['subject_code'];									
			$is_first_class=$record['is_first_class'];								
			$class_list=$teacher_class[$admin_id_rec][$class_id_rec][$section_rec][$subject_code_rec];
			 		 
			  
			 foreach($class_list as $routin_teacher_classes_id =>$class_data_array)
			 {
			  
			
			
			
			
			 foreach($os->weekday_list as $current_day_no =>$current_date_str)
			  {   

for($current_period=1;$current_period<=$os->period;$current_period++)
				{	
						
				
				 first_level_searching($routin_period_id,$current_day_no,$current_period,$routin_slotes,$routin_teacher_classes_id ,$admin_id_rec,$class_id_rec,$section_rec ,$subject_code_rec,$is_first_class,$not_allowd_successive_class);													
				
			
			   }
			   
			   }
			
			
			
			 }
			 
			 
	} 
	
	
						
		echo "loop = ".$os->loop;					 
							 	
							
	}				
					 
}

if($os->get('delete_day_period_from_routin_teacher_classes')=='OK')
{      

       		$action=$os->post('action');
			
			$routin_period_id=$os->post('routin_period_id');
			
			
			if($action=='update_day_period')
			{	   
				 echo  $query="update routin_teacher_classes set day='' , period_no='' where routin_period_id='$routin_period_id' ";
				 $os->mq( $query);
			 }

} 

if($os->get('class_routine_delete')=='OK' && $os->post('class_routine_delete')=='OK')
{      
 
       		 
			$routin_teacher_classes_ids=$os->post('routin_teacher_classes_ids');
			if($routin_teacher_classes_ids!='')
			{
			    
				    $query="delete from  routin_teacher_classes  where routin_teacher_classes_id IN($routin_teacher_classes_ids)";
					//echo $query;
				    $os->mq( $query);
					
					echo "Deleted";
			}else
			{
			   echo "Problem There";
			}	 
			  
exit();
}             
	
								 
								 
								 		

if($os->get('fill_empty_slots--------------------------------------1')=='OK')
{ 

			 
					$routin_period_id=$os->post('routin_period_id'); 
					$routin_period= $os->rowByField('',$tables='routin_period',$fld='routin_period_id',$fldVal=$routin_period_id,$where='',$orderby='');
				    $data_at_start=  routine_getCalcData($routin_period);
					 
					 
					 
					 
					 $query_admin="select distinct(admin_id) admin_id  from routin_teacher_classes    where routin_period_id = '$routin_period_id'  order by  join_class asc,    class_id asc";
					$rsResults=$os->mq($query_admin);
					while($record=$os->mfa( $rsResults))
					{
					
					    $admin_list_class_asc[$record['admin_id']]=$record['admin_id'];
					  
								 
					} 
					 
					  
					
				     foreach($data_at_start['teacher_classes_remaining']  as $row )
					 {
					 
						$data_recent=  routine_getCalcData($routin_period);
						$sugested_slot=array();
						$not_sugested_slot_=array();
						$final_sugested_slot=array();
						
						 
						 $calculated_day=''; 
						 $calculated_period_no=''; 
						
						 $routin_teacher_classes_id=$row['routin_teacher_classes_id'];
						 
						 $class_id=$row['class_id'];
						 $admin_id=$row['admin_id'];
						 $section=$row['section'];
						 $subject_code=$row['subject_code'];
						 
						$sugested_slot[1]= check_same_sec_same_subj($data_recent,$class_id,$section,$subject_code,$admin_id);
						 
						  
						 foreach($sugested_slot as $vals)
						 {
						    foreach($vals as $val)
							{
							 $final_sugested_slot[$val]=$val;
							}
						 } 
						   // remove not suggested slot;
						  
						  
						$day_period=array_key_first($final_sugested_slot);
						$day_period_array=explode('-',$day_period);
						$calculated_day=$day_period_array[0];
						$calculated_period_no=(int)$day_period_array[1];
						
						$valid_slot=   chek_slot($data_recent,$calculated_day,$calculated_period_no);
											
					    if($calculated_day!='' && $calculated_period_no>0 && $valid_slot>0)
						{
							  $dataToSave=array();
							  $dataToSave['day']=$calculated_day;
							  $dataToSave['period_no']=$calculated_period_no;
							  $routin_teacher_classes_id=$os->save('routin_teacher_classes',$dataToSave,'routin_teacher_classes_id',$routin_teacher_classes_id );
						
						}
					 
					 }
					 
					 
					 
					 
					  
					
					 
}					
					
					

  
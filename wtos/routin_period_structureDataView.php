<?
include('wtosConfigLocal.php');
 
include($site['root-wtos'].'top.php');
include('routin_settings/routin_config.php');

$pluginName='';
$listHeader='Subscription Structure Entry';
$ajaxFilePath= 'routin_periodAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$branchCode = $os->getSession($key1='selected_branch_code');
$all_branch_list=$os->get_branches_by_access_name("Exam Settings");
$access_name = "Exam Settings";


?>


<table class="container">
	<tr>
		
		<td  class="middle" style="padding-left:5px;">
			
			
			<div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			
			<!--  ggggggggggggggg   -->
			
<div class="content">
    <div class="item">
	<form id="routin_data_form">
	
        <div class="uk-padding-small uk-padding-remove-bottom">
            
			  <div class="uk-inline" uk-tooltip="Select session">
                <select name="asession_s"
                        id="asession_s"
                        class="uk-select uk-border-rounded congested-form p-left-xxxl" >
                    <option value=""> </option>
                    <?
                    
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select>
            </div>
			<div class="uk-inline" uk-tooltip="Select Branch">
                <select id="branch_code_s" name="branch_code_s"
                        class="uk-select uk-border-rounded congested-form p-left-xxxl select2">

                    <? if(in_array("View", $global_access) || $os->userDetails["adminType"]=="Super Admin"){?>
                        <option value="">Branch</option>
                    <? } ?>
                    <? $os->onlyOption($all_branch_list,'');	?>
                </select>
            </div>
         
			
			<div class="uk-inline" uk-tooltip="">
                <select name="gender_type"
                        id="gender_type"
                        class="uk-select uk-border-rounded congested-form p-left-xxxl" >
                    <option value=""> </option>
                    <?
                    
                    $os->onlyOption($os->gender_type);
                    ?>
                </select>
            </div>
			
			
			
			
           
            <button onclick="get_routin_data('')" class="uk-button uk-border-rounded congested-form
            uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" >
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"
                    type="button" onclick=" ">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>
			
			

        </div>
        <div style="height:10px;"> </div>
        <div class="ajaxViewMainTableTDListSearch" id="get_routin_data_div">
		</div>				
						 
	</form>					
						
<div id="fill_empty_slots_results_div"> resullt </div>
    </div>
</div>
						
						
			<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
				
				<tr>
					
					<td valign="top" class="ajaxViewMainTableTDList">
						
						
						<div  class="ajaxViewMainTableTDListData" id="class_room_area_id">&nbsp;
						
						 
						 </div>
					&nbsp;</td>
				</tr>
			</table>			
			 

			 

<!-- This is the modal -->
 

<div id="open_set_prferences_modal" class="uk-modal-full" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div id="set_prferences_div">
		 
		 </div>
    </div>
</div>
			
			<!--   ggggggggggggggg  -->
			
		</td>
	</tr>
</table>



<style>
.classroom_daily{ height:50px; width:150px; border:1px solid #0099FF; float:left; margin:5px; background-color:#EAEAEA}
</style>
 
 <script>
						
						function get_routin_data(action)
						{
								 
								if(os.check.empty('asession_s','Please select session')==false){ return false;}
								if(os.check.empty('branch_code_s','Please select Branch')==false){ return false;}
								if(os.check.empty('gender_type','Please select Gender')==false){ return false;}
								
								if(action=='save_teachers_class')
								{
								     
										if(os.check.empty('routin_admin_id','Please select Teacher')==false){ return false;}
										if(os.check.empty('routin_classId','Please select Class')==false){ return false;}
										if(os.check.empty('routin_section','Please select section')==false){ return false;}
										if(os.check.empty('routin_subjectId','Please select subject')==false){ return false;}
										if(os.check.empty('no_of_teachers_class','Please put no of class')==false){ return false;}
										 
								
								}
								
								
								
								
								
								var formdata = new FormData(os.getObj('routin_data_form'));
								
								
								formdata.append('action',action);
						     
							    formdata.append('get_routin_data','OK');
								var url='<? echo $ajaxFilePath ?>?get_routin_data=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('get_routin_data_result',url,formdata);
								
								 
						}
						function get_routin_data_result(data)
						{
						   os.setHtml('get_routin_data_div',data);
						   
						   if(document.getElementById('routin_classId')){
						   wt_ajax_chain('html*routin_subjectId*subject,subjectId,subjectName*classId=routin_classId','','','');
						   }
						}
						
						
						
						function manage_number_of_class(day,perod)
						{
								  // function not uses
								
								var formdata = new FormData();
								var fld_val_id=day+'_no_of_class_'+perod;
								var fld_val = os.getVal(fld_val_id);
								
								formdata.append('fld_val',fld_val);
								formdata.append('perod',perod);
								formdata.append('day',day);
								 
								formdata.append('manage_number_of_class','OK');
								var url='<? echo $ajaxFilePath ?>?manage_number_of_class=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('manage_number_of_class_result',url,formdata);
						
						
						}
						function manage_number_of_class_result(data)
						{
						    os.setHtml('class_room_area_id',data);
						
						}
						function show_class_room(day,periods,no_of_class)
						{
						 
						       var formdata = new FormData();
														
								formdata.append('no_of_class',no_of_class);
								formdata.append('periods',periods);
								formdata.append('day',day);
								 
								formdata.append('show_class_room','OK');
								var url='<? echo $ajaxFilePath ?>?show_class_room=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('show_class_room_results',url,formdata);
						
						
						}
						
						function show_class_room_results(data)
						{
						  os.setHtml('class_room_area_id',data);
						
						}
						
						function set_prferences(admin_id,routin_period_id)
						{
						
						       var formdata = new FormData();
														
								formdata.append('admin_id',admin_id);
								formdata.append('routin_period_id',routin_period_id);
								
								
								//formdata.append('periods',periods);
								//formdata.append('day',day);
								 
								formdata.append('set_prferences','OK');
								var url='<? echo $ajaxFilePath ?>?set_prferences=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('set_prferences_results',url,formdata);
						
						}
						function set_prferences_results(data)
						{
						  os.setHtml('set_prferences_div',data);
						
						}
						  
						
						function class_routine_distribution(routin_period_id,class_id,section){
						
						os.setHtml('set_prferences_div','');
						 var formdata = new FormData();
														
								formdata.append('class_id',class_id);
								formdata.append('section',section);
								
								formdata.append('routin_period_id',routin_period_id);
								 
								
								//formdata.append('periods',periods);
								//formdata.append('day',day);
								 
								formdata.append('class_routine_distribution','OK');
								var url='<? echo $ajaxFilePath ?>?class_routine_distribution=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('class_routine_distribution_results',url,formdata);
						
						}
						function class_routine_distribution_results(data)
						{
						  os.setHtml('set_prferences_div',data);
						
						}
						
						
						
						function fill_empty_slots(routin_period_id)
						{
						 
								var p =confirm('Fill empty slots?');
								if(p==false){return false;}
								
								var formdata = new FormData();	 					
								//formdata.append('admin_id',admin_id);
								formdata.append('routin_period_id',routin_period_id);
								
								
								//formdata.append('periods',periods);
								//formdata.append('day',day);
								 
								formdata.append('fill_empty_slots','OK');
								var url='<? echo $ajaxFilePath ?>?fill_empty_slots=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('fill_empty_slots_results',url,formdata);
						
						}
						
						function fill_empty_slots_results(data)
						{
								os.setHtml('fill_empty_slots_results_div',data);
								get_routin_data('');
						}
						
						function delete_day_period_from_routin_teacher_classes(action,routin_period_id)
						{
						 
								var p =confirm(action +  'are you sure? update all data.');
								if(p==false){return false;}
								
								/*var p =confirm('are you sure? update all data.');
								if(p==false){return false;}*/
								
								var formdata = new FormData();	 					
								formdata.append('action',action);
								formdata.append('routin_period_id',routin_period_id);
								 
								 
								formdata.append('delete_day_period_from_routin_teacher_classes','OK');
								var url='<? echo $ajaxFilePath ?>?delete_day_period_from_routin_teacher_classes=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('delete_day_period_from_routin_teacher_classes_rs',url,formdata);
						
						}
						function delete_day_period_from_routin_teacher_classes_rs(data)
						{
						   
						  alert(data);
						  get_routin_data('');
						}
						
						function class_routine_delete(routin_teacher_classes_ids)
						{
						 
								var p =confirm('Are you sure? confirm delete row.');
								if(p==false){return false;}
								
								/*var p =confirm('are you sure? update all data.');
								if(p==false){return false;}*/
								
								var formdata = new FormData();	 					
								 
								formdata.append('routin_teacher_classes_ids',routin_teacher_classes_ids);
								 
								 
								formdata.append('class_routine_delete','OK');
								var url='<? echo $ajaxFilePath ?>?class_routine_delete=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('class_routine_delete_results',url,formdata);
						
						}
						function class_routine_delete_results(data)
						{
						 //  confirm('sure');
						 get_routin_data('');
						  alert(data);
						  
						}
						
						

 
						</script>
<? include($site['root-wtos'].'bottom.php'); ?>
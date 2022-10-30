<? 
/*
   # wtos version : 1.1
   # Edit page: weekly_academic_audit_vxEdit.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><? 

$editPage='weekly_academic_audit_vxEdit.php';
$listPage='weekly_academic_audit_vxList.php';
$primeryTable='weekly_academic_audit_vx';
$primeryField='weekly_academic_audit_vx_id';
$pageHeader='Weekly academic audit V To X';
$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());


##  delete row
if($os->get('operation')=='deleteRow')
{
	if($os->deleteRow($primeryTable,$primeryField,$os->get('delId')))
	{
		$flashMsg='Data Deleted Successfully';

		$os->flashMessage($primeryTable,$flashMsg);
		$os->redirect($site['url-wtos'].$listPage);

	}
}

// branch access
   $return_acc=$os->branch_access();
    $and_branch='';
    if($os->userDetails['adminType']!='Super Admin')
    { $selected_branch_codes=$return_acc['branches_code_str_query'];
        $and_branch=" and branch_code IN($selected_branch_codes)";
    }
	$branch_code_arr=array();
    $branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
    $branch_row_rs= $os->mq($branch_row_q);
    while ($branch_row = $os->mfa($branch_row_rs))    {
        $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'];
    }
    // branch access end


##  fetch row

/* searching */

$andyearA=  $os->andField('year_s','year',$primeryTable,'=');
$year_s=$andyearA['value']; $andyear=$andyearA['andField'];	 
$andmonthA=  $os->andField('month_s','month',$primeryTable,'=');
$month_s=$andmonthA['value']; $andmonth=$andmonthA['andField'];	 

$f_dated_s= $os->setNget('f_dated_s'); $t_dated_s= $os->setNget('t_dated_s');
$anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='23:59:59');
$andbranch_codeA=  $os->andField('branch_code_s','branch_code',$primeryTable,'=');
$branch_code_s=$andbranch_codeA['value']; $andbranch_code=$andbranch_codeA['andField'];
$andweek_noA=  $os->andField('week_no_s','week_no',$primeryTable,'%');
$week_no_s=$andweek_noA['value']; $andweek_no=$andweek_noA['andField'];	 
$andassesment_report_updatedA=  $os->andField('assesment_report_updated_s','assesment_report_updated',$primeryTable,'=');
$assesment_report_updated_s=$andassesment_report_updatedA['value']; $andassesment_report_updated=$andassesment_report_updatedA['andField'];	 
$anddaily_talimA=  $os->andField('daily_talim_s','daily_talim',$primeryTable,'=');
$daily_talim_s=$anddaily_talimA['value']; $anddaily_talim=$anddaily_talimA['andField'];	 
$anddaily_quran_larningA=  $os->andField('daily_quran_larning_s','daily_quran_larning',$primeryTable,'=');
$daily_quran_larning_s=$anddaily_quran_larningA['value']; $anddaily_quran_larning=$anddaily_quran_larningA['andField'];	 
$anddepartmental_meetingA=  $os->andField('departmental_meeting_s','departmental_meeting',$primeryTable,'=');
$departmental_meeting_s=$anddepartmental_meetingA['value']; $anddepartmental_meeting=$anddepartmental_meetingA['andField'];	 
$andall_teacher_meetingA=  $os->andField('all_teacher_meeting_s','all_teacher_meeting',$primeryTable,'=');
$all_teacher_meeting_s=$andall_teacher_meetingA['value']; $andall_teacher_meeting=$andall_teacher_meetingA['andField'];	 
$anddaily_abascus_classA=  $os->andField('daily_abascus_class_s','daily_abascus_class',$primeryTable,'=');
$daily_abascus_class_s=$anddaily_abascus_classA['value']; $anddaily_abascus_class=$anddaily_abascus_classA['andField'];	 

$searchKey=$os->setNget('searchKey',$primeryTable);
$whereFullQuery='';
if($searchKey!=''){
	$whereFullQuery ="and ( year like '%$searchKey%' Or month like '%$searchKey%' Or dated like '%$searchKey%' Or branch_code like '%$searchKey%' Or week_no like '%$searchKey%' Or assesment_report_updated like '%$searchKey%' Or daily_talim like '%$searchKey%' Or daily_quran_larning like '%$searchKey%' Or departmental_meeting like '%$searchKey%' Or all_teacher_meeting like '%$searchKey%' Or daily_abascus_class like '%$searchKey%' )";

}

$listingQuery=" select * from $primeryTable where $primeryField>0   $whereFullQuery    $andyear  $andmonth  $anddated $andbranch_code $and_branch  $andweek_no  $andassesment_report_updated  $anddaily_talim  $anddaily_quran_larning  $anddepartmental_meeting  $andall_teacher_meeting  $anddaily_abascus_class   order by  $primeryField desc  ";

##  fetch row

$resource=$os->pagingQuery($listingQuery,$os->showPerPage);
$records=$resource['resource'];


$os->showFlash($os->flashMessage($primeryTable));




?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "> <?php  echo $pageHeader; ?></h4>
        </div>

        </div>  
    </div>
<div class="content">
<div class="item-content p-m">
<table class="container" border="0"   cellpadding="0" cellspacing="0" style="margin:5px 3px 3px 3px">

	<tr>
		<td >
			<div class="search" style="margin:0px 2px 5px 0px;"  >


				<table cellpadding="0" cellspacing="0" border="0">
					<tr >
						<td class="buttonSa">
							
							
							
							
							Search Key  
							<input type="text" id="searchKey"  value="<? echo $searchKey ?>" />   &nbsp;
							Branch:
							<select name="branch_code" id="branch_code_s" class="textbox fWidth select2"  >
                            <option value="">All Branch</option>
                            <? $os->onlyOption($branch_code_arr,$os->get('branch_code_s'));	?>
                            </select>

						<div style="display:none" id="advanceSearchDiv">

							year:

							<select name="year" id="year_s" class="textbox fWidth" ><option value="">Select year</option>	<? 
							$os->onlyOption($os->examYear,$year_s);	?></select>	
							month:

							<select name="month" id="month_s" class="textbox fWidth" ><option value="">Select month</option>	<? 
							$os->onlyOption($os->rentMonth,$month_s);	?></select>	
							From dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value="<? echo $f_dated_s?>"  /> &nbsp;   To dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value="<? echo $t_dated_s?>"  /> &nbsp;  
							week_no: <input type="text" class="wtTextClass" name="week_no_s" id="week_no_s" value="<? echo $week_no_s?>" /> &nbsp;  assesment_report_updated:

							<select name="assesment_report_updated" id="assesment_report_updated_s" class="textbox fWidth" ><option value="">Select assesment_report_updated</option>	<? 
							$os->onlyOption($os->assesment_report_updated,$assesment_report_updated_s);	?></select>	
							daily_talim:

							<select name="daily_talim" id="daily_talim_s" class="textbox fWidth" ><option value="">Select daily_talim</option>	<? 
							$os->onlyOption($os->yesno,$daily_talim_s);	?></select>	
							daily_quran_larning:

							<select name="daily_quran_larning" id="daily_quran_larning_s" class="textbox fWidth" ><option value="">Select daily_quran_larning</option>	<? 
							$os->onlyOption($os->yesno,$daily_quran_larning_s);	?></select>	
							departmental_meeting:

							<select name="departmental_meeting" id="departmental_meeting_s" class="textbox fWidth" ><option value="">Select departmental_meeting</option>	<? 
							$os->onlyOption($os->departmental_meeting,$departmental_meeting_s);	?></select>	
							all_teacher_meeting:

							<select name="all_teacher_meeting" id="all_teacher_meeting_s" class="textbox fWidth" ><option value="">Select all_teacher_meeting</option>	<? 
							$os->onlyOption($os->yesno,$all_teacher_meeting_s);	?></select>	
							daily_abascus_class:

							<select name="daily_abascus_class" id="daily_abascus_class_s" class="textbox fWidth" ><option value="">Select daily_abascus_class</option>	<? 
							$os->onlyOption($os->yesno,$daily_abascus_class_s);	?></select>	

						</div>

						<a href="javascript:void(0)" onclick="javascript:searchText()" style="text-decoration:none;"><input type="button" value="Search" style="cursor:pointer" /></a>
						&nbsp;
						<a href="javascript:void(0)" onclick="javascript:searchReset()"  style="text-decoration:none;"><input type="button" value="Reset" style="cursor:pointer" /></a>
						
						<a href="" style="margin-left:50px; text-decoration:none;"><input type="button" value="Refesh" style="cursor:pointer; text-decoration:none;" /></a>    
			<a href="javascript:void(0)" style="text-decoration:none;" onclick="os.editRecord('<? echo $editPageLink?>0') "><input type="button" value="Add New Record" style="cursor:pointer;text-decoration:none;" class="add_button"/></a>

					</td>
				</tr>
			</table>
		</div>
		 
	</td>
</tr>	


<tr>

	<td  class="middle" >

		<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <?php  echo $resource['links'];?>		</div>	

		<!--  ggggggggggggggg   -->







		<table  border="0" cellspacing="2" cellpadding="2" class="listTable" >
			<tr class="borderTitle" >
				<td >#</td>
				<td >Action </td>
				<td ><b>Year</b></td>  
				<td ><b>Month</b></td>  
				<td ><b>Date</b></td> 
				<td ><b>Branch</b></td> 
				<td ><b>Week no</b></td>  
				 
			</tr>
			<?php
			$serial=$os->val($resource,'serial');  
			while(  $record=$os->mfa($records )){ 
				$serial++;
				$rowId=$record[$primeryField];



				?>							
				<tr  class="trListing" >
					<td><?php echo $serial?>      </td>

					<td class="actionLink" style="width:180px;">  
						<? if($os->access('wtEdit')){ ?> <a href="javascript:void(0)" onclick="os.editRecord('<?   echo $editPageLink ?><?php echo $rowId  ?>')">Edit</a><? } ?>	
						<? if($os->access('wtDelete')){ ?> 	<a href="javascript:void(0)" onclick="os.deleteRecord('<?php echo  $rowId ?>') ">Delete</a><? } ?>
						<a href="javascript:void(0)" onclick="openPrint('<?php echo  $rowId ?>') ">View</a>
						
					</td>
					<td> <? echo $os->val($os->examYear,$record['year']); ?> </td> 
					<td> <? echo $os->val($os->rentMonth,$record['month']); ?> </td> 
					<td><?php echo $os->showDate($record['dated']);?> </td> 
					<td>  <? echo 
					$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td>  
					<td><?php echo $record['week_no']?> </td>  
					 
				</tr>
			<?php	} ?>
		</table>
		<!--   ggggggggggggggg  -->

	</td>
</tr>
</table>

</div>  
    </div>




<script>
	function	openPrint(id){
		if(id==''){ alert('Please select atleast one record', 'warning'); return false;}
		var URLStr='weekly_academic_audit_vx_print.php?id='+id;
		popUpWindow(URLStr, 10, 10, 1200, 600);
	}
	function searchText(){
		var year_sVal= os.getVal('year_s'); 
		var month_sVal= os.getVal('month_s'); 
		var f_dated_sVal= os.getVal('f_dated_s'); 
		var t_dated_sVal= os.getVal('t_dated_s'); 
		var week_no_sVal= os.getVal('week_no_s'); 
		var assesment_report_updated_sVal= os.getVal('assesment_report_updated_s'); 
		var daily_talim_sVal= os.getVal('daily_talim_s'); 
		var daily_quran_larning_sVal= os.getVal('daily_quran_larning_s'); 
		var departmental_meeting_sVal= os.getVal('departmental_meeting_s'); 
		var all_teacher_meeting_sVal= os.getVal('all_teacher_meeting_s'); 
		var daily_abascus_class_sVal= os.getVal('daily_abascus_class_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 

		var searchKeyVal= os.getVal('searchKey'); 
		// window.location='<?php echo $listPageLink; ?>year_s='+year_sVal +'&month_s='+month_sVal +'&f_dated_s='+f_dated_sVal +'&t_dated_s='+t_dated_sVal +'&week_no_s='+week_no_sVal +'&assesment_report_updated_s='+assesment_report_updated_sVal +'&daily_talim_s='+daily_talim_sVal +'&daily_quran_larning_s='+daily_quran_larning_sVal +'&departmental_meeting_s='+departmental_meeting_sVal +'&all_teacher_meeting_s='+all_teacher_meeting_sVal +'&daily_abascus_class_s='+daily_abascus_class_sVal +'&searchKey='+searchKeyVal +'&';
		window.location='<?php echo $listPageLink; ?>year_s='+year_sVal +'&month_s='+month_sVal +'&f_dated_s='+f_dated_sVal +'&t_dated_s='+t_dated_sVal +'&branch_code_s='+branch_code_sVal +'&week_no_s='+week_no_sVal +'&assesment_report_updated_s='+assesment_report_updated_sVal +'&daily_talim_s='+daily_talim_sVal +'&daily_quran_larning_s='+daily_quran_larning_sVal +'&departmental_meeting_s='+departmental_meeting_sVal +'&all_teacher_meeting_s='+all_teacher_meeting_sVal +'&daily_abascus_class_s='+daily_abascus_class_sVal +'&searchKey='+searchKeyVal +'&';

	}
	function  searchReset()
	{

		// window.location='<?php echo $listPageLink; ?>year_s=&month_s=&f_dated_s=&t_dated_s=&week_no_s=&assesment_report_updated_s=&daily_talim_s=&daily_quran_larning_s=&departmental_meeting_s=&all_teacher_meeting_s=&daily_abascus_class_s=&searchKey=&';	
		window.location='<?php echo $listPageLink; ?>year_s=&month_s=&f_dated_s=&t_dated_s=&branch_code_s=&week_no_s=&assesment_report_updated_s=&daily_talim_s=&daily_quran_larning_s=&departmental_meeting_s=&all_teacher_meeting_s=&daily_abascus_class_s=&searchKey=&';


	}

	// dateCalander();
	
</script>

<style>
.add_button{ background-color:#0078F0; color:#FFFFFF; font-size:12px; font-weight:bold;}
</style>
<? include($site['root-wtos'].'bottom.php'); ?>

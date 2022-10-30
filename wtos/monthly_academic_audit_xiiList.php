<? 
/*
   # wtos version : 1.1
   # Edit page: monthly_academic_audit_xiiEdit.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><? 

$editPage='monthly_academic_audit_xiiEdit.php';
$listPage='monthly_academic_audit_xiiList.php';
$primeryTable='monthly_academic_audit_xii';
$primeryField='monthly_academic_audit_xii_id';
$pageHeader='Monthly academic audit XI and XII';
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
$anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');

$andbranch_codeA=  $os->andField('branch_code_s','branch_code',$primeryTable,'=');
$branch_code_s=$andbranch_codeA['value']; $andbranch_code=$andbranch_codeA['andField'];
$andco_curricular_activityA=  $os->andField('co_curricular_activity_s','co_curricular_activity',$primeryTable,'%');
$co_curricular_activity_s=$andco_curricular_activityA['value']; $andco_curricular_activity=$andco_curricular_activityA['andField'];	 
$andcultural_programmeA=  $os->andField('cultural_programme_s','cultural_programme',$primeryTable,'%');
$cultural_programme_s=$andcultural_programmeA['value']; $andcultural_programme=$andcultural_programmeA['andField'];	 

$searchKey=$os->setNget('searchKey',$primeryTable);
$whereFullQuery='';
if($searchKey!=''){
	$whereFullQuery ="and ( year like '%$searchKey%' Or month like '%$searchKey%' Or dated like '%$searchKey%' Or branch_code like '%$searchKey%'  Or co_curricular_activity like '%$searchKey%' Or cultural_programme like '%$searchKey%' )";

}

$listingQuery=" select * from $primeryTable where $primeryField>0   $whereFullQuery    $andyear  $andmonth  $anddated  $andco_curricular_activity  $andcultural_programme  $andbranch_code $and_branch  order by  $primeryField desc  ";

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

									Year:

									<select name="year" id="year_s" class="textbox fWidth" ><option value="">Select Year</option>	<? 
									$os->onlyOption($os->examYear,$year_s);	?></select>	
									Month:

									<select name="month" id="month_s" class="textbox fWidth" ><option value="">Select Month</option>	<? 
									$os->onlyOption($os->rentMonth,$month_s);	?></select>	
									From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value="<? echo $f_dated_s?>"  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value="<? echo $t_dated_s?>"  /> &nbsp;  
									Cocurricular activity: <input type="text" class="wtTextClass" name="co_curricular_activity_s" id="co_curricular_activity_s" value="<? echo $co_curricular_activity_s?>" /> &nbsp;  Cultural programme: <input type="text" class="wtTextClass" name="cultural_programme_s" id="cultural_programme_s" value="<? echo $cultural_programme_s?>" /> &nbsp; 
								</div>

								<a href="javascript:void(0)" onclick="javascript:searchText()" style="text-decoration:none;"><input type="button" value="Search" style="cursor:pointer" /></a>
								&nbsp;
								<a href="javascript:void(0)" onclick="javascript:searchReset()"  style="text-decoration:none;"><input type="button" value="Reset" style="cursor:pointer" /></a>  <a href="" style="margin-left:50px; text-decoration:none;"><input type="button" value="Refesh" style="cursor:pointer; text-decoration:none;" /></a>    
					<a href="javascript:void(0)" style="text-decoration:none;" onclick="os.editRecord('<? echo $editPageLink?>0') "><input type="button" value="Add New Record" style="cursor:pointer;text-decoration:none;" class="add_button" /></a>

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

						 


					</tr>


					<?php
					$serial=$os->val($resource,'serial');  
					while(  $record=$os->mfa($records )){ 
						$serial++;
						$rowId=$record[$primeryField];



						?>							
						<tr  class="trListing" >
							<td><?php echo $serial?>      </td>

							<td class="actionLink" style="width:170px;">                   


								<? if($os->access('wtEdit')){ ?> <a href="javascript:void(0)" onclick="os.editRecord('<?   echo $editPageLink ?><?php echo $rowId  ?>')">Edit</a><? } ?>	 

								<? if($os->access('wtDelete')){ ?> 	<a href="javascript:void(0)" onclick="os.deleteRecord('<?php echo  $rowId ?>') ">Delete</a><? } ?>	 

								<a href="javascript:void(0)" onclick="openPrint('<?php echo  $rowId ?>') ">View</a>





							</td>

							<td> <? echo $os->val($os->examYear,$record['year']); ?> </td> 
							<td> <? echo $os->val($os->rentMonth,$record['month']); ?> </td> 
							<td><?php echo $os->showDate($record['dated']);?> </td>  
							<td>  <? echo 
							$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
							 



						</tr>



						<?php 
					} 
					?>



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
			var URLStr='monthly_academic_audit_xii_print.php?id='+id;
			popUpWindow(URLStr, 10, 10, 1200, 600);
		}

		function searchText(){
			var year_sVal= os.getVal('year_s'); 
			var month_sVal= os.getVal('month_s'); 
			var f_dated_sVal= os.getVal('f_dated_s'); 
			var t_dated_sVal= os.getVal('t_dated_s'); 
			var co_curricular_activity_sVal= os.getVal('co_curricular_activity_s'); 
			var cultural_programme_sVal= os.getVal('cultural_programme_s'); 
			var branch_code_sVal= os.getVal('branch_code_s'); 

			var searchKeyVal= os.getVal('searchKey'); 
		// window.location='<?php echo $listPageLink; ?>year_s='+year_sVal +'&month_s='+month_sVal +'&f_dated_s='+f_dated_sVal +'&t_dated_s='+t_dated_sVal +'&co_curricular_activity_s='+co_curricular_activity_sVal +'&cultural_programme_s='+cultural_programme_sVal +'&searchKey='+searchKeyVal +'&';
		window.location='<?php echo $listPageLink; ?>year_s='+year_sVal +'&month_s='+month_sVal +'&f_dated_s='+f_dated_sVal +'&t_dated_s='+t_dated_sVal +'&branch_code_s='+branch_code_sVal +'&co_curricular_activity_s='+co_curricular_activity_sVal +'&cultural_programme_s='+cultural_programme_sVal +'&searchKey='+searchKeyVal +'&';
		
	}
	function  searchReset(){
		window.location='<?php echo $listPageLink; ?>year_s=&month_s=&f_dated_s=&t_dated_s=&branch_code_s=&co_curricular_activity_s=&cultural_programme_s=&searchKey=&';
	}
	
	// dateCalander();
	
</script>
<style>
.add_button{ background-color:#0078F0; color:#FFFFFF; font-size:12px; font-weight:bold;}
</style>

<? include($site['root-wtos'].'bottom.php'); ?>

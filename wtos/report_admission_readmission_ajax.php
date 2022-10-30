<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
if($os->get('admissionReadmissionListing')=='OK')
{
	$where='';
	$maleQ="";
	$femaleQ="";
	$genderQ="";
	$admissionQ="";
	$reAdmissionQ="";
	$admissionTypeQ="";
	$adharFilledQ="";
	$adharNotFilled="";
	$adharQ="";
	$accFilledQ="";
	$accNotFilledQ="";
	$accQ="";
	$showPerPage= $os->post('showPerPage');
	$fromAge= $os->post('fromAge');
	$toAge= $os->post('toAge');
	$isMale= $os->post('male');
	$isFemale=$os->post('female');
	$isAdmission= $os->post('admission');
	$isReadmission=$os->post('reAdmission');
	$isAdharFilled= $os->post('adharFilled');
	$isAdharNotFilled=$os->post('adharNotFilled');
	$isBankAccFilled=$os->post('bankAccFilled');
	$isBankAccNotFilled=$os->post('bankAccNotFilled');
	$f_Date_s= $os->post('fromDob'); $t_Date_s= $os->post('toDob');;
	$andDob=$os->DateQ('stu.dob',$f_Date_s,$t_Date_s,$sTime='00:00:00',$eTime='23:59:59');
	if($fromAge>0){
		$fromAgeQ="and stu.age >= '$fromAge'";
	}
	if($toAge>0){
		$toAgeQ="and stu.age <= '$toAge'";
	}
	if($isMale=='Yes'){
		$maleQ="and stu.gender = 'Male'";
	}
	if($isFemale=='Yes'){
		$femaleQ="and stu.gender = 'Female'";
	}
	if($isFemale=='Yes' && $isMale=='Yes'){
		$maleQ="";
		$femaleQ="";
		$genderQ="and (stu.gender = 'Male' OR stu.gender = 'Female')";
	}
	if($isAdmission=='Yes'){
		$admissionQ="and hist.admissionType = 'Admission'";
	}
	if($isReadmission=='Yes'){
		$reAdmissionQ="and hist.admissionType = 'Re Admission'";
	}

	if($isAdmission=='Yes' && $isReadmission=='Yes'){
		$admissionQ="";
		$reAdmissionQ="";
		$admissionTypeQ="and (hist.admissionType = 'Admission' OR hist.admissionType = 'Re Admission')";
	}
	if($isAdharFilled=='Yes'){
		$adharFilledQ="and stu.adhar_no !=''";
	}
	if($isAdharNotFilled=='Yes'){
		$adharNotFilledQ="and stu.adhar_no=''";
	}

	if($isBankAccFilled=='Yes'){
		$accFilledQ="and stu.accNo !=''";
	}
	if($isBankAccNotFilled=='Yes'){
		$accNotFilledQ="and stu.accNo=''";
	}

	if($isBankAccFilled=='Yes' && $isBankAccNotFilled=='Yes'){
		$accFilledQ="";
		$accNotFilledQ="";
		$accQ="";
	}

### Class Section Bolck ### 
	$classQ="";
	foreach ($_POST as $postKey=>$postVal){
			if(strpos($postKey,"class_")==0){
					$classA=explode("_",$postKey);
				 	$classVal=$classA[1];
				 	if(strpos($postKey,"sec_"+$classVal)==0){
				 		 $secA=explode("_",$postKey);
				 		 $secVal=$secA[2];
				 	}
					if($classVal){
						 $secQ="";
						 if($secVal){
							 $secQ="and section ='$secVal'";
						 }
						 $classQ=$classQ."hist.class = ".$classVal." $secQ OR ";
					}
			}
	}
	if($classQ){
			$classQ="and (".rtrim($classQ, 'OR ').")";
	}

###End  Class Section Bolck ###
	$listingQuery="select hist.*,stu.* from history as hist  inner join student as stu on hist.studentId=stu.studentId where hist.historyId>0  $andDob $fromAgeQ $toAgeQ $maleQ $femaleQ $genderQ $admissionQ $reAdmissionQ $admissionTypeQ $adharFilledQ $adharNotFilledQ $adharQ 		$accFilledQ $accNotFilledQ $accQ $classQ order by hist.class asc , hist.section asc";
	$os->setSession($listingQuery, 'download_admission_readmission_report_excel');  
	$os->showPerPage=2000;
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
 	$historyExcelA_selected=array('studentId' ,'name'  ,'dob','gender' ,'class','section','father_name');


?>
<div class="listingRecords" >
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?> 
 <span onclick="showhide('more_download')" style="cursor:pointer; color:#003399; font-style:italic;">View More</span></div>


<div id="more_download" class="more_download" style="display:none;">
<?foreach($os->historyExcelA AS $dbFieldName=>$excelColName){	
	 $selected='';
     if(in_array($dbFieldName,$historyExcelA_selected)){
	 $selected='checked="checked"';
}?>
	<div style="width:152px; float:left; height:25px; font-size:11px;">
		<input <? echo $selected; ?>  type="checkbox" name="columnName[]" id="<?echo $dbFieldName;?>_d"  value="<? echo $dbFieldName; ?>" />  <? echo $excelColName; ?>
	</div>
<?}?> 
<input type="button" value="Download" style="cursor:pointer" onclick="excelDownload()"/>

<input type="button" value="Print" style="cursor:pointer" onclick="admissionReadimssionPrint()"/>
<div style="clear:both"> </div>
</div>
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
					<tr class="borderTitle" >
						<td >#</td>
						<td ><b>Id </b></td>
						<td ><b>Name</b></td>  
						<td ><b>Year</b></td>
						<td ><b>Class</b></td>  
						<td ><b>Sec</b></td>  
						<td ><b>Roll</b></td>  
						<td ><b>DOB</b></td>  
						<td ><b>Father</b></td>   
						<td><b>Mobile No</b></td> 	 
						<td><b>Address</b></td> 
					</tr>		
							<?php
						  	 $serial=$os->val($resource,'serial');  
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							 ?>
								<tr class="trListing" >
									<td><?php echo $serial; ?></td>
									<td><b><?php echo $record['studentId']; ?></b> </td>
									<td> <?php echo $record['name'] ?> </td>
									<td><?php echo $record['asession']; ?></td>	
									<td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?> </td>
									<td><? if(isset($os->section[$record['section']])){ echo  $os->section[$record['section']]; } ?> </td>
									<td><?  echo  $record['roll_no'];  ?> </td>
									<td style="font-style:italic;"><?php echo $os->showDate( $record['dob']); ?> </td>
									<td><?php echo $record['father_name'] ?> </td>
									<td><?php echo $record['mobile_student'] ?> </td>
									<td style="font-size:10px;"><?php echo $record['vill'] ?>,  <?php echo $record['ps'] ?> <br />
									<?php echo $record['dist'] ?>, <?php echo $record['pin'] ?></td>
				 				</tr>
                          <? } ?>  			 
		</table> 
		</div>
		<br />					
<?php 
exit();	
}
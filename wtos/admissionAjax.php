<? 
/*
   # wtos version : 1.1
   # page called by ajax script in admissionDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_admissionListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');

    $f_dob_s= $os->post('f_dob_s'); $t_dob_s= $os->post('t_dob_s');
   $anddob=$os->DateQ('dob',$f_dob_s,$t_dob_s,$sTime='00:00:00',$eTime='59:59:59');
$andfather_name=  $os->postAndQuery('father_name_s','father_name','%');
$andmother_name=  $os->postAndQuery('mother_name_s','mother_name','%');
$andguardian_name=  $os->postAndQuery('guardian_name_s','guardian_name','%');
$andvill=  $os->postAndQuery('vill_s','vill','%');
$andpin=  $os->postAndQuery('pin_s','pin','%');
$andpo=  $os->postAndQuery('po_s','po','%');
$andps=  $os->postAndQuery('ps_s','ps','%');
$anddist=  $os->postAndQuery('dist_s','dist','%');
$andblock=  $os->postAndQuery('block_s','block','%');
$andstate=  $os->postAndQuery('state_s','state','%');
$andgender=  $os->postAndQuery('gender_s','gender','%');
$andcaste=  $os->postAndQuery('caste_s','caste','%');
$andadhar_no=  $os->postAndQuery('adhar_no_s','adhar_no','%');
$andclass=  $os->postAndQuery('class_s','class','%');
$andboard=  $os->postAndQuery('board_s','board','%');
$andaccNo=  $os->postAndQuery('accNo_s','accNo','%');
$andaccHolderName=  $os->postAndQuery('accHolderName_s','accHolderName','%');
$andifscCode=  $os->postAndQuery('ifscCode_s','ifscCode','%');
$andbranch=  $os->postAndQuery('branch_s','branch','%');
$andmobile_student=  $os->postAndQuery('mobile_student_s','mobile_student','%');
$andstudentRemarks=  $os->postAndQuery('studentRemarks_s','studentRemarks','%');
$andapl_bpl=  $os->postAndQuery('apl_bpl_s','apl_bpl','%');
$andadmissionType=  $os->postAndQuery('admissionType_s','admissionType','%');
$andvarificationStatus=  $os->postAndQuery('varificationStatus_s','varificationStatus','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or father_name like '%$searchKey%' Or mother_name like '%$searchKey%' Or guardian_name like '%$searchKey%' Or vill like '%$searchKey%' Or pin like '%$searchKey%' Or po like '%$searchKey%' Or ps like '%$searchKey%' Or dist like '%$searchKey%' Or block like '%$searchKey%' Or state like '%$searchKey%' Or gender like '%$searchKey%' Or caste like '%$searchKey%' Or adhar_no like '%$searchKey%' Or class like '%$searchKey%' Or board like '%$searchKey%' Or accNo like '%$searchKey%' Or accHolderName like '%$searchKey%' Or ifscCode like '%$searchKey%' Or branch like '%$searchKey%' Or mobile_student like '%$searchKey%' Or studentRemarks like '%$searchKey%' Or apl_bpl like '%$searchKey%' Or admissionType like '%$searchKey%' Or varificationStatus like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from admission where admissionId>0   $where   $andname  $anddob  $andfather_name  $andmother_name  $andguardian_name  $andvill  $andpin  $andpo  $andps  $anddist  $andblock  $andstate  $andgender  $andcaste  $andadhar_no  $andclass  $andboard  $andaccNo  $andaccHolderName  $andifscCode  $andbranch  $andmobile_student  $andstudentRemarks  $andapl_bpl  $andadmissionType  $andvarificationStatus     order by admissionId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<style>
.gray{color: #999999;}
</style>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:1200px;" >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Student Image</b></td>  
 <td ><b>Type</b></td>  
  <td ><b>Details</b></td>  
 
  <td ><b>Address</b></td>  
 
  <td ><b>Gender</b></td>  
  <td ><b>Caste</b></td>  
  <td ><b>Adhar No</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Board</b></td>  

  <td ><b>Mobile</b></td>  

  <td ><b>apl/bpl</b></td>  

  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_admissionGetById('<? echo $record['admissionId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>  
  <td valign="top"> <? if(isset($os->admissionType[$record['admissionType']])){ echo  $os->admissionType[$record['admissionType']]; } ?>
  
   <br>

 
 <span class="gray">Form No:</span><b><?php echo $record['admissionId']?></b><br />
  <? $os->editSelect($os->admissionVerificationStatus,$record['varificationStatus'],'admission','varificationStatus','admissionId',$record['admissionId'], $inputNameID='editSelect',$extraParams='class="editSelect" ',$os->admissionVerificationStatusColor) ?>
  
  </td> 
  <td valign="top"><b><?php echo $record['name']?> </b> <br />
<span class="gray">Father:</span><?php echo $record['father_name']?><br />
 <span class="gray">Mother:</span><?php echo $record['mother_name']?> <br />
 
  <span class="gray">Gurdian:</span><?php echo $record['guardian_name']?><br /> 
<span class="gray">Dob: </span><?php echo $os->showDate($record['dob']);?> <br />
<span class="gray">Phone: </span> <? echo $record['mobile_student']; ?> <br />
<span class="gray">Caste: </span> <? if(isset($os->caste[$record['caste']])){ echo  $os->caste[$record['caste']]; } ?> <br />
  
  </td>  
 
  <td valign="top">

 <b><?php echo $record['vill']?> </b> <br />
	   <span class="gray">Po: </span> <?php echo $record['po']?> <br />
      
	     <span class="gray">Dist: </span> <?php echo $record['dist']?> <br />
		   <span class="gray">Block: </span> <?php echo $record['block']?> <br />
		    <span class="gray">Pin: </span> <?php echo $record['pin']?> <br />
	    <span class="gray">State: </span> <? echo $record['state']; ?> <br />   </td>  

  <td> <? if(isset($os->gender[$record['gender']])){ echo  $os->gender[$record['gender']]; } ?></td> 
  <td> <? if(isset($os->caste[$record['caste']])){ echo  $os->caste[$record['caste']]; } ?></td> 
  <td><?php echo $record['adhar_no']?> </td>  
  <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td> 
  <td> <? if(isset($os->board[$record['board']])){ echo  $os->board[$record['board']]; } ?></td> 

  <td><?php echo $record['mobile_student']?> </td>  

  <td> <? if(isset($os->aplOrBpl[$record['apl_bpl']])){ echo  $os->aplOrBpl[$record['apl_bpl']]; } ?></td> 


								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_admissionEditAndSave')=='OK')
{
 $admissionId=$os->post('admissionId');
 
 
		 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['dob']=$os->saveDate($os->post('dob')); 
 $dataToSave['father_name']=addslashes($os->post('father_name')); 
 $dataToSave['mother_name']=addslashes($os->post('mother_name')); 
 $dataToSave['guardian_name']=addslashes($os->post('guardian_name')); 
 $dataToSave['vill']=addslashes($os->post('vill')); 
 $dataToSave['pin']=addslashes($os->post('pin')); 
 $dataToSave['po']=addslashes($os->post('po')); 
 $dataToSave['ps']=addslashes($os->post('ps')); 
 $dataToSave['dist']=addslashes($os->post('dist')); 
 $dataToSave['block']=addslashes($os->post('block')); 
 $dataToSave['state']=addslashes($os->post('state')); 
 $dataToSave['gender']=addslashes($os->post('gender')); 
 $dataToSave['caste']=addslashes($os->post('caste')); 
 $dataToSave['adhar_no']=addslashes($os->post('adhar_no')); 
 $dataToSave['class']=addslashes($os->post('class')); 
 $dataToSave['board']=addslashes($os->post('board')); 
 $dataToSave['accNo']=addslashes($os->post('accNo')); 
 $dataToSave['accHolderName']=addslashes($os->post('accHolderName')); 
 $dataToSave['ifscCode']=addslashes($os->post('ifscCode')); 
 $dataToSave['branch']=addslashes($os->post('branch')); 
 $dataToSave['mobile_student']=addslashes($os->post('mobile_student')); 
 $dataToSave['studentRemarks']=addslashes($os->post('studentRemarks')); 
 $dataToSave['apl_bpl']=addslashes($os->post('apl_bpl')); 
 $dataToSave['admissionType']=addslashes($os->post('admissionType')); 
 $dataToSave['varificationStatus']=addslashes($os->post('varificationStatus')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($admissionId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('admission',$dataToSave,'admissionId',$admissionId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($admissionId>0 ){ $mgs= " Data updated Successfully";}
		if($admissionId<1 ){ $mgs= " Data Added Successfully"; $admissionId=  $qResult;}
		
		  $mgs=$admissionId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_admissionGetById')=='OK')
{
		$admissionId=$os->post('admissionId');
		
		if($admissionId>0)	
		{
		$wheres=" where admissionId='$admissionId'";
		}
	    $dataQuery=" select * from admission  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}
 $record['name']=$record['name'];
 $record['dob']=$os->showDate($record['dob']); 
 $record['father_name']=$record['father_name'];
 $record['mother_name']=$record['mother_name'];
 $record['guardian_name']=$record['guardian_name'];
 $record['vill']=$record['vill'];
 $record['pin']=$record['pin'];
 $record['po']=$record['po'];
 $record['ps']=$record['ps'];
 $record['dist']=$record['dist'];
 $record['block']=$record['block'];
 $record['state']=$record['state'];
 $record['gender']=$record['gender'];
 $record['caste']=$record['caste'];
 $record['adhar_no']=$record['adhar_no'];
 $record['class']=$record['class'];
 $record['board']=$record['board'];
 $record['accNo']=$record['accNo'];
 $record['accHolderName']=$record['accHolderName'];
 $record['ifscCode']=$record['ifscCode'];
 $record['branch']=$record['branch'];
 $record['mobile_student']=$record['mobile_student'];
 $record['studentRemarks']=$record['studentRemarks'];
 $record['apl_bpl']=$record['apl_bpl'];
 $record['admissionType']=$record['admissionType'];
 $record['varificationStatus']=$record['varificationStatus'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_admissionDeleteRowById')=='OK')
{ 

$admissionId=$os->post('admissionId');
 if($admissionId>0){
 $updateQuery="delete from admission where admissionId='$admissionId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

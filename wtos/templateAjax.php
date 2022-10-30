<? 
/*
   # wtos version : 1.1
   # page called by ajax script in generateadmitDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_generateadmitListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andadmitTitle=  $os->postAndQuery('admitTitle_s','admitTitle','%');
$andphase=  $os->postAndQuery('phase_s','phase','%');
$andinstructionHtml=  $os->postAndQuery('instructionHtml_s','instructionHtml','%');
$andsignatoryDesignation=  $os->postAndQuery('signatoryDesignation_s','signatoryDesignation','%');
$andactive=  $os->postAndQuery('active_s','active','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( admitTitle like '%$searchKey%' Or phase like '%$searchKey%' Or instructionHtml like '%$searchKey%' Or signatoryDesignation like '%$searchKey%' Or active like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from template where templateId>0   $where   $andadmitTitle  $andphase  $andinstructionHtml  $andsignatoryDesignation  $andactive     order by templateId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div id="FlashMessageDiv" class="FlashMessageDiv" style="display:none" > 					
         </div>
<style>

.gray{ color:#999999;}
</style>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Title</b></td>  
<td ><b>Type</b></td> 
  <td ><b>Class</b></td>  
 
 
  <td style="display:none;"><b>Stamp Image</b></td>  
  <td style="display:none;"><b>Signature Image</b></td>  
 
	<td><b>Active</b></td>  

	<td ><b>Publish</b></td>  					 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_generateadmitGetById('<? echo $record['generateadmitId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td valign="top"><?php echo $record['admitTitle'];
echo "<br>";echo "<br>";
 if(isset($os->phases[$record['phase']])){ echo  $os->phases[$record['phase']]; } 

?> </td>  
<td valign="top"> <?echo $record['templateType'] ?></td>
  <td valign="top"><?php //echo $record['jobpostId']
  
 echo $classA = trim($record['class'],",");
   
  
  ?> 
  
  
  
  
  
  
  
  </td>  

  
  <td style="display:none;"><img src="<?php  echo $site['url'].$record['stampImage']; ?>"  height="70" width="70" /></td>  
  <td style="display:none;"><img src="<?php  echo $site['url'].$record['signatureImage']; ?>"  height="70" width="70" /></td>  

  <td valign="top">
     <? $os->editSelect($os->admitActive,$record['active'],'template','active','templateId',$record['templateId'], $inputNameID='editSelect',$extraParams='class="editSelect" ',$os->admitStatusColor) ?> 
	
  
  </td> 
    <td valign="top">
  <? $os->editSelect($os->admitPublish,$record['admitPublish'],'template','admitPublish','templateId',$record['templateId'], $inputNameID='editSelect',$extraParams='class="editSelect" ',$os->admitPublishColor) ?> 

    </td> 
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_generateadmitEditAndSave')=='OK')
{
 $templateId=$os->post('templateId');
 
 $class=$os->post('class');
		 
 $dataToSave['admitTitle']=addslashes($os->post('admitTitle')); 
 $dataToSave['class']=addslashes($class); 
 $dataToSave['phase']=addslashes($os->post('phase')); 
 $dataToSave['instructionHtml']=addslashes($os->post('instructionHtml')); 
 $stampImage=$os->UploadPhoto('stampImage',$site['root'].'wtos-images');
				   	if($stampImage!=''){
					$dataToSave['stampImage']='wtos-images/'.$stampImage;}
 $signatureImage=$os->UploadPhoto('signatureImage',$site['root'].'wtos-images');
				   	if($signatureImage!=''){
					$dataToSave['signatureImage']='wtos-images/'.$signatureImage;}
 $dataToSave['signatoryDesignation']=addslashes($os->post('signatoryDesignation')); 
 $dataToSave['active']=addslashes($os->post('active')); 
 
 
 $dataToSave['instruction1']=addslashes($os->post('instruction1')); 
 $dataToSave['instruction2']=addslashes($os->post('instruction2')); 
 $dataToSave['instruction3']=addslashes($os->post('instruction3')); 
 $dataToSave['instruction4']=addslashes($os->post('instruction4')); 
 $dataToSave['instruction5']=addslashes($os->post('instruction5')); 
 $dataToSave['instruction6']=addslashes($os->post('instruction6')); 
 $dataToSave['instruction7']=addslashes($os->post('instruction7')); 
 $dataToSave['instruction8']=addslashes($os->post('instruction8')); 
 $dataToSave['instruction9']=addslashes($os->post('instruction9')); 
 $dataToSave['instruction10']=addslashes($os->post('instruction10')); 
 $dataToSave['instruction11']=addslashes($os->post('instruction11')); 
 $dataToSave['instruction12']=addslashes($os->post('instruction12')); 
 $dataToSave['instruction13']=addslashes($os->post('instruction13')); 
 
 
 
  $dataToSave['instructionBorder1']=addslashes($os->post('instructionBorder1')); 
 $dataToSave['instructionBorder2']=addslashes($os->post('instructionBorder2')); 
 $dataToSave['instructionBorder3']=addslashes($os->post('instructionBorder3')); 
 $dataToSave['instructionBorder4']=addslashes($os->post('instructionBorder4')); 
 $dataToSave['instructionBorder5']=addslashes($os->post('instructionBorder5')); 
 $dataToSave['instructionBorder6']=addslashes($os->post('instructionBorder6')); 
 $dataToSave['instructionBorder7']=addslashes($os->post('instructionBorder7')); 
 $dataToSave['instructionBorder8']=addslashes($os->post('instructionBorder8')); 
 $dataToSave['instructionBorder9']=addslashes($os->post('instructionBorder9')); 
 $dataToSave['instructionBorder10']=addslashes($os->post('instructionBorder10')); 
 $dataToSave['instructionBorder11']=addslashes($os->post('instructionBorder11')); 
 $dataToSave['instructionBorder12']=addslashes($os->post('instructionBorder12')); 
 $dataToSave['instructionBorder13']=addslashes($os->post('instructionBorder13'));
 //$dataToSave['correctWrongMethodImg']=addslashes($os->post('correctWrongMethodImg'));
 
  $dataToSave['templateType']=addslashes($os->post('templateType'));
 
 
  $dataToSave['candidateSign']=addslashes($os->post('candidateSign'));
   $dataToSave['invigilatorSign']=addslashes($os->post('invigilatorSign'));
 
 

  $dataToSave['admitPublish']=addslashes($os->post('admitPublish')); 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($templateId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('template',$dataToSave,'templateId',$templateId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 
		  
		if($qResult)  
				{
		if($templateId>0 ){ $mgs= " Data updated Successfully";}
		if($templateId<1 ){ $mgs= " Data Added Successfully"; $templateId=  $qResult;}
		
		  $mgs=$templateId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_generateadmitGetById')=='OK')
{
		$templateId=$os->post('templateId');
		
		if($templateId>0)	
		{
		$wheres=" where templateId='$templateId'";
		}
	    $dataQuery=" select * from template  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 
 $record['instructionHtml']=$record['instructionHtml'];
 if($record['stampImage']!=''){
						$record['stampImage']=$site['url'].$record['stampImage'];}
 if($record['signatureImage']!=''){
						$record['signatureImage']=$site['url'].$record['signatureImage'];}
 $record['signatoryDesignation']=$record['signatoryDesignation'];
 $record['active']=$record['active'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_generateadmitDeleteRowById')=='OK')
{ 

$generateadmitId=$os->post('generateadmitId');
 if($generateadmitId>0){
 $updateQuery="delete from generateadmit where generateadmitId='$generateadmitId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

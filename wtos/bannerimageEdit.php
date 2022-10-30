<?
/*
   # wtos version : 1.1
   # List Page : bannerimageList.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?

$editPage='bannerimageEdit.php';
$listPage='bannerimageList.php';
$primeryTable='bannerimage';
$primeryField='bannerImageId';
$pageHeader='Add new bannerimage';
 
 
$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());
$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId)
{
 $pageHeader='Edit  bannerimage';
}


##  update row
if($os->post('operation'))
{

	 if($os->post('operation')=='updateField')
	 {
	  $rowId=$os->post('rowId');
	  
	  #---- edit section ----#
	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	    	  	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	  	 	 	
 $dataToSave['imageTitle']=addslashes($os->post('imageTitle')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['htmlText']=addslashes($os->post('htmlText')); 
 $dataToSave['active']=addslashes($os->post('active')); 
 $dataToSave['priority']=addslashes($os->post('priority')); 

																																															
																																															           if($rowId < 1){
			$dataToSave['addedDate']=$os->now();
			$dataToSave['addedBy']=$os->userDetails['adminId'];
			}
																																															
																																															
		
		
	  $os->saveTable($primeryTable,$dataToSave,$primeryField,$rowId);
	 
	 
	  $flashMsg=($rowId)?'Record Updated Successfully':'Record Added Successfully';
	  
	  $os->flashMessage($primeryTable,$flashMsg);
	  
	   $os->redirect($os->post('redirectLink'));
	  #---- edit section end ----#
	
	 }
	
	
}


$pageData='';
if($editRowId)
  {
    
	   $os->data=$os->rowByField('',$primeryTable,$primeryField,$editRowId);
	    
  }

  
$os->showFlash($os->flashMessage($primeryTable));
?>
 
 
	<table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			 <div class="formsection">
						<h3><?php  echo $pageHeader; ?></h3>
						
						<form  action="<? echo $editPageLink ?>" method="post"   enctype="multipart/form-data" id="submitFormDataId">
						
						<fieldset class="cFielSets"  >
						<legend  class="cLegend">Details</legend>
						
				 
						
						<table width="100%" border="0" class="formClass"   >
						
							
<tr >
	  									<td>Image Title </td>
										<td><input value="<?php echo $os->getVal('imageTitle') ?>" type="text" name="imageTitle" id="imageTitle" class="textbox  fWidth "/> </td>						
										</tr><tr >
	  									<td>Image <br><span style="color:red;">Size should be<br> 1600X600 px</span></td>
										<td>
										
										<img id="imagePreview" src="<?php echo $site['url']?><?php echo $os->getVal('image');?>  " height="100"  />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Html Text </td>
										<td><textarea  name="htmlText" id="htmlText" ><?php echo $os->getVal('htmlText') ?></textarea></td>						
										</tr><tr >
	  									<td>Active </td>
										<td>  
	
	<select name="active" id="active" class="textbox fWidth" ><option value="">Select Active</option>	<? 
										 $os->onlyOption($os->bannerImgActive,$os->getVal('active'));?></select>	 </td>						
										</tr><tr >
	  									<td>Priority </td>
										<td><input value="<?php echo $os->getVal('priority') ?>" type="text" name="priority" id="priority" class="textbox  fWidth "/> </td>						
										</tr>
                        </table>
						</fieldset>
						
						
						
						
						 
						
					<? if($os->access('wtEdit')){ ?> 	<input type="button" class="submit"  value="Save" onclick="submitFormData()" />	 <? } ?>	 
                        <input type="button" class="submit"  value="Back to List" onclick="javascript:window.location='<? echo $listPageLink ?>';" />	
						<input type="hidden" name="redirectLink"  value="<? echo $os->server('HTTP_REFERER'); ?>" />
						<input type="hidden" name="rowId" value="<?php   echo  $os->getVal($primeryField) ;?>" />
                        <input type="hidden" name="operation" value="updateField" />
						</form>
					</div>			  </td>
			  </tr>
			</table>


 
<script>
function submitFormData()
{


   

   
  os.submitForm('submitFormDataId');

}
</script>

	 <? include('tinyMCE.php'); ?>
 <script>tmce('htmlText')</script>
 
<? include($site['root-wtos'].'bottom.php'); ?>
 
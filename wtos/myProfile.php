<?
/*
   # wtos version : 1.1
   # List Page : adminList.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?

$editPage='adminEdit.php';
$listPage='adminList.php';
$primeryTable='admin';
$primeryField='adminId';
$pageHeader='Add new admin';
 
 
$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());

if($os->userDetails['adminType']!='Super Admin'){ exit(); }

$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId)
{
 $pageHeader='Edit  admin';
}


##  update row
if($os->post('operation'))
{

	 if($os->post('operation')=='updateField')
	 {
	  $rowId=$os->post('rowId');
	  
	  #---- edit section ----#
	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	    	  	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	  	 	 	
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['adminType']=addslashes($os->post('adminType')); 
 $dataToSave['username']=addslashes($os->post('username')); 
 $dataToSave['password']=addslashes($os->post('password')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['mobileNo']=addslashes($os->post('mobileNo')); 
 
 
 $dataToSave['editDeletePassword']=addslashes($os->post('editDeletePassword')); 
 
 $dataToSave['active']=addslashes($os->post('active')); 
  $accessArr = $os->post('access');
	  
	  $accessString = '';
	  
	  if(is_array($accessArr) && count($accessArr)>0){
	  	$accessString = implode(',',$accessArr);
	  }
	 $dataToSave['access'] = $accessString;
																																															
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
$accessArr=array();
 $accessStr  =  $os->data['access'];
		  if($accessStr!=''){$accessArr = explode(',',$accessStr);}
		  
?>
 
 
	<table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			 <div class="formsection">
						<h3><?php  echo $pageHeader; ?></h3>
						
						<form  action="<? echo $editPageLink ?>" method="post"   enctype="multipart/form-data" id="submitFormDataId">
						
						<fieldset class="cFielSets"  >
						<legend  class="cLegend">Details</legend>
						
				 
						
						<table width="100%" border="0"  class="formClass"   >
						
							
<tr >
	  									<td>Name </td>
										<td><input value="<?php echo $os->getVal('name') ?>" type="text" name="name" id="name" class="textbox  fWidth "/> </td>						
										</tr><tr style="display:none">
	  									<td>Admin Type </td>
										<td>  
	
	<select name="adminType" id="adminType" class="textbox fWidth" ><option value="">Select Admin Type</option>	<? 
										 $os->onlyOption($os->adminType,$os->getVal('adminType'));?></select>	 </td>						
										</tr><tr >
	  									<td>Username </td>
										<td><input value="<?php echo $os->getVal('username') ?>" type="text" name="username" id="username" class="textbox  fWidth "/> </td>						
										</tr><tr >
	  									<td>Password </td>
										<td><input value="<?php echo $os->getVal('password') ?>" type="text" name="password" id="password" class="textbox  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><input value="<?php echo $os->getVal('address') ?>" type="text" name="address" id="address" class="textbox  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="<?php echo $os->getVal('email') ?>" type="text" name="email" id="email" class="textbox  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Mobile No </td>
										<td><input value="<?php echo $os->getVal('mobileNo') ?>" type="text" name="mobileNo" id="mobileNo" class="textbox  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>Password For Edit</td>
										<td><input value="<?php echo $os->getVal('editDeletePassword') ?>" type="text" name="editDeletePassword" id="editDeletePassword" class="textbox  fWidth "/> </td>						
										</tr>
										
										
										
										<tr style="display:none">
	  									<td>Active </td>
										<td>  
	
	<select name="active" id="active" class="textbox fWidth" ><option value="">Select Active</option>	<? 
										 $os->onlyOption($os->adminActive,$os->getVal('active'));?></select>	 </td>						
										</tr>
										
										<tr style="display:none">
	  									<td>Access </td>
											<td>  
											<div style="clear:both; height:1px;"> </div>
											<? if(is_array($os->adminAccess) && count($os->adminAccess)>0){ 
											$c=1;
											foreach($os->adminAccess as $acc=>$lebel){
											
											?>
											
											<div class="accessdiv">
											<input value="<? echo $acc ?>" type="checkbox"  name="access[]" class="textbox fWidth" <? if(is_array($accessArr) && in_array($acc,$accessArr)) { ?> checked="checked" <? } ?> /> <? echo $lebel ?> 
											</div>
											
											
											
											<?php  if($c==5){$c=0;?>
											 
								<?}?>
											
											<?php $c++; } }?>
											<div style="clear:both; height:1px;"> </div>
											</td>
											
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
<style >
.accessdiv{ width:200px; float:left;}
</style>
 
<? include($site['root-wtos'].'bottom.php'); ?>
 
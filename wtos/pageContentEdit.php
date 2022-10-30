<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?>
<? 

$editPage='pageContentEdit.php';
$listPage='pageContent.php';
$primeryTable='pagecontent';
$primeryField='pagecontentId';
$pageHeader='Add Web Pages';
$editPageLink=$site['url-wtos'].$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$site['url-wtos'].$listPage.'?'.$os->addParams(array(),array());
$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId)
{
 $pageHeader='Edit Web Pages';
}


##  update row
if($os->post('operation'))
{

	 if($os->post('operation')=='updateField')
	 {
	  $rowId=$os->post('rowId');
	  
	  #---- edit section ----#
	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 	 	 	    	  	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	  	 	  	 	 	 	 		 	 	 	 	 		 	 	 	 	 	 
		$dataToSave['heading']=$os->post('heading');
		$dataToSave['title']=$os->post('title');
		$dataToSave['content']=addslashes($os->post('content'));
		$dataToSave['langId']=addslashes($os->post('langId'));
	//	$dataToSave['postInclude']=$os->post('postInclude');
		//$dataToSave['preInclude']=$os->post('preInclude');
		$dataToSave['parentPage']=$os->post('parentPage');
		$dataToSave['seoId']=$os->post('seoId');
		$dataToSave['externalLink']=$os->post('externalLink');
		
		$dataToSave['onHead']=$os->post('onHead');
		$dataToSave['onBottom']=$os->post('onBottom');
		$dataToSave['openNewTab']=$os->post('openNewTab');
		
		$dataToSave['metaTitle']=$os->post('metaTitle');
		$dataToSave['metaTag']=$os->post('metaTag');
		$dataToSave['metaDescription']=$os->post('metaDescription');
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$dataToSave['addedDate']=date("Y-m-d h:i:s");
		$dataToSave['pageCss']=$os->post('pageCss');
		$dataToSave['showImage']=$os->post('showImage');
		
	  $image=$os->UploadPhoto('image',$site['root-image']);
	  if($image!='')
	  {
	  	$dataToSave['image']='wtos-images/'.$image;
		
		if($rowId)
		{
		   //   $os->removeImage($primeryTable,$primeryField,$rowId,'image',$site['imgPath']);
		}
		
		
	  }


		
		
	  $os->saveTable($primeryTable,$dataToSave,$primeryField,$rowId);
	 
	 
	  $flashMsg=($rowId)?'Record Updated Successfully':'Record Added Successfully';
	  
	  $os->flashMessage('123',$flashMsg);
	  
	   $os->redirect($os->post('redirectLink'));
	  #---- edit section end ----#
	
	 }
	
	
}


 
if($editRowId)
  {
    
	   $pageData=$os->rowByField('',$primeryTable,$primeryField,$editRowId);
	           
  }

 
?>
 
 
	<table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			 <div class="formsection">
						<h3><?php  echo $pageHeader; ?></h3>
						
						<form  action="<? echo $editPageLink ?>" method="post"   enctype="multipart/form-data">
						
						<fieldset class="cFielSets"  >
						<legend  class="cLegend">Details</legend>
						
				 
						
						<table width="100%" border="0" class="formClass"   >
						
						 
                          <tr >
                            <td width="100">Link Name</td>
                            <td width="300" >
							<input value="<?php if(isset($pageData['title'])){ echo $pageData['title']; } ?>" style="width:300px;" type="text" name="title" class="textbox fWidth" onblur="setSeoId();" id="title" />                       </td>
                            <td colspan="3" >Page Under:  
                            
							 
							<select name="parentPage" id="parentPage" class="textbox fWidth" style="width:150px;">
							
							<option value="0"> No Parent </option>
							<?
							if(isset($pageData['parentPage'])){ $tmpVar= $pageData['parentPage']; }
							$os->optionsHTML($tmpVar,'pagecontentId','title','pagecontent',"active=1 ");
							 
							?>
							</select>						
							
							 Language    <select name="langId" id="langId" class="textbox fWidth" >
							
							 		<?
									if(isset($pageData['langId'])){ $tmpVar= $pageData['langId']; }
							   $os->optionsHTML($tmpVar,'langId','title','lang',"");
							 
							?>
							</select>		
								</td>
                          </tr>
						  
						  
						  
						  <tr>  
                            <td>Page Link</td>
                            <td colspan="5"><input value="<?php if(isset($pageData['seoId'])){ echo $pageData['seoId']; } ?>" style="width:650px;" type="text" name="seoId" class="textbox fWidth"  id="seoId"/></td>
                           
                          
						  </tr>
						  <tr >
							<td  >&nbsp;</td>
							<td style="color:#0000CC;"  ><input type="checkbox" name="onHead" id="onHead" value="1" <?php if(isset($pageData['onHead'])){ if($pageData['onHead']=='1'){ ?> checked="checked" <? } } ?>  />Place on Head Menu</td>
							<td colspan="20"   style="color:#0000CC;"  ><input type="checkbox" name="onBottom" value="1" <?php  if(isset($pageData['onBottom'])){ if($pageData['onBottom']=='1'){ ?> checked="checked" <? } } ?>>
						    Place on Bottom Menu</td>
						</tr>
						  
						   <tr >
                            <td  >Heading</td>
                            <td colspan="5" >
							<input value="<?php if(isset($pageData['heading'])){ echo $pageData['heading']; } ?>" style="width:300px;" type="text" name="heading" class="textbox fWidth" id="heading"/>                            </td>
                             
                          </tr>
						  
 
	  
	  
	  <tr>  
	  
	      <td>External Link</td>
                            <td  ><input value="<?php if(isset($pageData['externalLink'])){ echo $pageData['externalLink']; } ?>" style="width:300px;" type="text" name="externalLink" class="textbox fWidth"/> 
							</td>
							<td colspan="5"> 
							 <input type="checkbox" name="openNewTab" value="1" <?php  if(isset($pageData['openNewTab'])){  if($pageData['openNewTab']=='1'){ ?> checked="checked" <? } } ?>  /> 
							 <font style="color:#0000FF">Open in a new tab</font><font style="font-size:9px; color:#FF0000;"> (Leave if you are not sure &nbsp;) </font>
							</td>
                           
                            
						  </tr>
						   <tr style="display:none;">  
                            <td>Pre Include</td>
                            <td colspan="5"><input value="<?php if(isset($pageData['preInclude'])){ echo $pageData['preInclude']; } ?>" style="width:300px;" type="text" name="preInclude" class="textbox fWidth"/></td>
                           
                            
						  </tr>
                          <tr>
                            <td>Description</td>
                            <td colspan="5">
			                <textarea  name="content" id="description" rows="1" cols="50">
							
							
							
							<?php if(isset($pageData['content'])){ echo stripslashes($pageData['content']); } ?>
							
							
							
							
							</textarea>						</td>
                          </tr>
						  
						   <tr style="display:none;">  
                            <td>Post Include</td>
                            <td colspan="5"><input value="<?php if(isset($pageData['postInclude'])){ echo $pageData['postInclude']; } ?>" style="width:300px;" type="text" name="postInclude" class="textbox fWidth"/></td>
                           
                            
						  </tr>
						  
						  <tr >
							<td>Meta Title:</td>
							<td colspan="5">
							<textarea class="textbox fWidth" name="metaTitle" id="metaTitle"   style="width:650px; height:20px;"><?php if(isset($pageData['metaTitle'])){ echo $pageData['metaTitle']; } ?></textarea>							</td>
						  </tr>
						 
						  <tr >
							<td>Meta Tag:</td>
							<td colspan="5">
							<textarea class="textbox fWidth" name="metaTag" id="metaTag"   style="width:650px; height:20px;"><?php if(isset($pageData['metaTag'])){ echo $pageData['metaTag']; } ?></textarea>							</td>
						  </tr>
						<tr >
							<td>Meta Description:</td>
							<td colspan="5">
								<textarea class="textbox fWidth" name="metaDescription" id="metaDescription"  style="width:650px; height:20px;"><?php if(isset($pageData['metaDescription'])){ echo $pageData['metaDescription']; } ?></textarea>							</td>
						  </tr>
						  
						  <tr>
							<td>Image</td>
											
										
                                         <td colspan="20"> 
										 <? if(isset($pageData['image'])){ ?> 
										 <img src="<?php  echo $site['url'].$pageData['image']; ?>"  height="100"  /><br />
										   <? } ?>
                                           <input type="file" name="image" />
										 
										   
										   <input type="checkbox" name="showImage" value="1" <?php if(isset($pageData['showImage'])){ if($pageData['showImage']=='1'){ ?> checked="checked" <? }} ?>  /> 
							 <font style="color:#0000FF">Show Image</font>
										   </td>
										   </tr>
										   <tr >
							<td>Page Css</td>
							<td colspan="5">
								<textarea class="textbox fWidth" name="pageCss" id="pageCss"  style="width:650px; height:30px;"><?php if(isset($pageData['pageCss'])){ echo $pageData['pageCss']; } ?></textarea>							</td>
						  </tr>
                        </table>
						</fieldset>
						
						
						
						
						 
						
						<input type="submit" class="submit"  value="Save" />	
                        <input type="button" class="submit"  value="Back to List" onclick="javascript:window.location='<? echo $listPageLink ?>';" />	
						<input type="hidden" name="redirectLink"  value="<? echo $os->server('HTTP_REFERER'); ?>" />
						<input type="hidden" name="rowId" value="<?php if(isset($pageData[$primeryField])){ echo $pageData[$primeryField]; } ?>" />
                        <input type="hidden" name="operation" value="updateField" />
						</form>
					</div>			  </td>
			  </tr>
			</table>


 <? include('tinyMCE.php'); ?>
 <script>tmce('description')</script>
 
<? include($site['root-wtos'].'bottom.php'); ?>
 
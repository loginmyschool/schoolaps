<? 
/*
   # wtos version : 1.1
   # Edit page: bannerimageEdit.php 
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
$pageHeader='List bannerimage';
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
 

##  fetch row

/* searching */

$andimageTitleA=  $os->andField('imageTitle_s','imageTitle',$primeryTable,'%');
   $imageTitle_s=$andimageTitleA['value']; $andimageTitle=$andimageTitleA['andField'];	 
$andhtmlTextA=  $os->andField('htmlText_s','htmlText',$primeryTable,'%');
   $htmlText_s=$andhtmlTextA['value']; $andhtmlText=$andhtmlTextA['andField'];	 
$andactiveA=  $os->andField('active_s','active',$primeryTable,'=');
   $active_s=$andactiveA['value']; $andactive=$andactiveA['andField'];	 
$andpriorityA=  $os->andField('priority_s','priority',$primeryTable,'%');
   $priority_s=$andpriorityA['value']; $andpriority=$andpriorityA['andField'];	 

$searchKey=$os->setNget('searchKey',$primeryTable);
$whereFullQuery='';
if($searchKey!=''){
$whereFullQuery ="and ( imageTitle like '%$searchKey%' Or image like '%$searchKey%' Or htmlText like '%$searchKey%' Or active like '%$searchKey%' Or priority like '%$searchKey%' )";

}

$listingQuery=" select * from $primeryTable where $primeryField>0   $whereFullQuery    $andimageTitle  $andhtmlText  $andactive  $andpriority   order by  $primeryField desc  ";

##  fetch row
 
$resource=$os->pagingQuery($listingQuery,$os->showPerPage);
$records=$resource['resource'];

 
$os->showFlash($os->flashMessage($primeryTable));
?>

	<table class="container" border="0" width="99%" cellpadding="0" cellspacing="0" style="margin:5px 3px 3px 3px">
				
			<tr>
			<td >
			<div class="search"  >
						 
			  
			  <table cellpadding="0" cellspacing="0" border="0">
							<tr >
							<td class="buttonSa">
							
							
							
							
	Search Key  
  <input type="text" id="searchKey"  value="<? echo $searchKey ?>" />   &nbsp;
     
	  
	 
   <div style="display:none" id="advanceSearchDiv">
         
 Image Title: <input type="text" class="wtTextClass" name="imageTitle_s" id="imageTitle_s" value="<? echo $imageTitle_s?>" /> &nbsp;   Html Text: <input type="text" class="wtTextClass" name="htmlText_s" id="htmlText_s" value="<? echo $htmlText_s?>" /> &nbsp;  Active:
	
	<select name="active" id="active_s" class="textbox fWidth" ><option value="">Select Active</option>	<? 
										  $os->onlyOption($os->bannerImgActive,$active_s);	?></select>	
   Priority: <input type="text" class="wtTextClass" name="priority_s" id="priority_s" value="<? echo $priority_s?>" /> &nbsp; 
  </div>
							
							<a href="javascript:void(0)" onclick="javascript:searchText()" style="text-decoration:none;"><input type="button" value="Search" style="cursor:pointer" /></a>
						    &nbsp;
						    <a href="javascript:void(0)" onclick="javascript:searchReset()"  style="text-decoration:none;"><input type="button" value="Reset" style="cursor:pointer" /></a>
							
							</td>
							</tr>
					 </table>
					</div>
				<div style="padding:10px;" >
						 
			  <span class="listHeader"> <?php  echo $pageHeader; ?> </span>
			  
			  	 <a href="" style="margin-left:50px; text-decoration:none;"><input type="button" value="Refesh" style="cursor:pointer; text-decoration:none;" /></a>    
			   <a href="javascript:void(0)" style="text-decoration:none;" onclick="os.editRecord('<? echo $editPageLink?>0') "><input type="button" value="Add New Record" style="cursor:pointer;text-decoration:none;"/></a>
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
								
<td ><b>Image Title</b></td>  
  <td ><b>Image</b></td>  
  <td ><b>Html Text</b></td>  
  <td ><b>Active</b></td>  
  <td ><b>Priority</b></td>  
  
								
							</tr>
											
							
							<?php
							 $serial=$os->val($resource,'serial');  
							 while(  $record=$os->mfa($records )){ 
							 $serial++;
							   $rowId=$record[$primeryField];
							 
								
							
							 ?>							
							<tr  class="trListing" >
								<td><?php echo $serial?>      </td>
								
								 <td class="actionLink">                   
                       
						
						<? if($os->access('wtEdit')){ ?> <a href="javascript:void(0)" onclick="os.editRecord('<?   echo $editPageLink ?><?php echo $rowId  ?>')">Edit</a><? } ?>	 
						 
					<? if($os->access('wtDelete')){ ?> 	<a href="javascript:void(0)" onclick="os.deleteRecord('<?php echo  $rowId ?>') ">Delete</a><? } ?>	 
						 
						
						
					 
						
                        
                       </td>
								
<td><?php echo $record['imageTitle']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['htmlText']?> </td>  
  <td> <? echo $os->val($os->bannerImgActive,$record['active']); ?> </td> 
  <td><?php echo $record['priority']?> </td>  
  
								 
														
					</tr>
				 
                            
							
							<?php 
							} 
							 ?>
							
							
							
						</table>
				 
				 	
	         
	  
			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>






 
	<script>
	
	 function searchText()
	 {
	 
	   
 var imageTitle_sVal= os.getVal('imageTitle_s'); 
 var htmlText_sVal= os.getVal('htmlText_s'); 
 var active_sVal= os.getVal('active_s'); 
 var priority_sVal= os.getVal('priority_s'); 
 var searchKeyVal= os.getVal('searchKey'); 
window.location='<?php echo $listPageLink; ?>imageTitle_s='+imageTitle_sVal +'&htmlText_s='+htmlText_sVal +'&active_s='+active_sVal +'&priority_s='+priority_sVal +'&searchKey='+searchKeyVal +'&';
	  
	 }
	function  searchReset()
	{
			
	  window.location='<?php echo $listPageLink; ?>imageTitle_s=&htmlText_s=&active_s=&priority_s=&searchKey=&';	
	   
	
	}
		
	// dateCalander();
	
	</script>

	 
<? include($site['root-wtos'].'bottom.php'); ?>
    
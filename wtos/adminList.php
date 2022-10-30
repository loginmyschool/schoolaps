<? 
/*
   # wtos version : 1.1
   # Edit page: adminEdit.php 
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
$pageHeader='List admin';
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

$andnameA=  $os->andField('name_s','name',$primeryTable,'%');
   $name_s=$andnameA['value']; $andname=$andnameA['andField'];	 
$andadminTypeA=  $os->andField('adminType_s','adminType',$primeryTable,'=');
   $adminType_s=$andadminTypeA['value']; $andadminType=$andadminTypeA['andField'];	 
$andusernameA=  $os->andField('username_s','username',$primeryTable,'%');
   $username_s=$andusernameA['value']; $andusername=$andusernameA['andField'];	 

$searchKey=$os->setNget('searchKey',$primeryTable);
$whereFullQuery='';
if($searchKey!=''){
$whereFullQuery ="and ( name like '%$searchKey%' Or adminType like '%$searchKey%' Or editDeletePassword like '%$searchKey%' Or username like '%$searchKey%' )";

}

$listingQuery=" select * from $primeryTable where $primeryField>0   $whereFullQuery    $andname  $andadminType  $andusername   order by  $primeryField desc  ";

##  fetch row
 
$resource=$os->pagingQuery($listingQuery,5);
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
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="<? echo $name_s?>" /> &nbsp;  Admin Type:
	
	<select name="adminType" id="adminType_s" class="textbox fWidth" ><option value="">Select Admin Type</option>	<? 
										  $os->onlyOption($os->adminType,$adminType_s);	?></select>	
   Username: <input type="text" class="wtTextClass" name="username_s" id="username_s" value="<? echo $username_s?>" /> &nbsp; 
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
									<td ><b>Name</b></td>  
									<td ><b>Image</b></td>  
									<td ><b>Admin Type</b></td>  
									<td ><b>Username</b></td>  
									<td ><b>Mobile No</b></td>
									<td ><b>Access</b></td>  
									<td ><b>Active</b></td>  
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
						 <br />	 <br />
					<? if($os->access('wtDelete')){ ?> 	<a href="javascript:void(0)" onclick="os.deleteRecord('<?php echo  $rowId ?>') ">Delete</a><? } ?>	 
						 
						
 		
					 
						
                        
                       </td>
								
<td><?php echo $record['name']?> </td>
<td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>   
  <td> <? echo $os->val($os->adminType,$record['adminType']); ?> </td> 
  <td><?php echo $record['username']?> 
  <br />
  <?php echo $record['password']?>
   </td>  
  <td><?php echo $record['mobileNo']?> </td>  
    <td>
			<div style="clear:both; height:1px;"> </div>			<?	$accessArr =array();
							if($record['access']!=''){$accessArr = explode(',',$record['access']);}
							
							 if(is_array($os->adminAccess) && count($os->adminAccess)>0){ 
									$c=1;
									foreach($os->adminAccess as $acc=>$lebel){
									
									?>
									
								
											<div class="accessdiv">
							<!-- <input value="<? echo $acc ?>" type="checkbox" disabled="disabled"  class="textbox fWidth" <? if(is_array($accessArr) && in_array($acc,$accessArr)) { ?> checked="checked" <? } ?> />--> 
							<? if(is_array($accessArr) && in_array($acc,$accessArr)) { ?>  <img src="<? echo $site['url-wtos'] ?>images/red_tick.png" style="height:12px;"/><? } else{ ?> <img src="<? echo $site['url-wtos'] ?>images/grey_tick.png" style="height:12px;"/>
							 
							 <? } ?>
							
							<? echo $lebel ?>
							 
							 	</div>
								<?if($c==5){$c=0;?>
								 
								<?}?>
								<? $c++;} }?>	
<div style="clear:both; height:1px;"> </div>								
							 </td>  
  <td> <? echo $os->val($os->adminActive,$record['active']); ?> </td> 
   							
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
	 
	   
 var name_sVal= os.getVal('name_s'); 
 var adminType_sVal= os.getVal('adminType_s'); 
 var username_sVal= os.getVal('username_s'); 
 var searchKeyVal= os.getVal('searchKey'); 
window.location='<?php echo $listPageLink; ?>name_s='+name_sVal +'&adminType_s='+adminType_sVal +'&username_s='+username_sVal +'&searchKey='+searchKeyVal +'&';
	  
	 }
	function  searchReset()
	{
			
	  window.location='<?php echo $listPageLink; ?>name_s=&adminType_s=&username_s=&searchKey=&';	
	   
	
	}
		
	// dateCalander();
	
	</script>
	<style >
.accessdiv{ width:200px; float:left;}
</style>
	 
<? include($site['root-wtos'].'bottom.php'); ?>
    
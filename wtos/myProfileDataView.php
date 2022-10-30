<?
/*
   # wtos version : 1.1
   # main ajax process page : adminAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='My Profile';
$ajaxFilePath= 'myProfileAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
 $userDetails=$os->userDetails;
 //_d($userDetails);
 
 
?>
  

 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td  height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	
	<table border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="<?echo $userDetails['name']?>" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>User Name </td>
										<td><input value="<?echo $userDetails['username']?>" type="text" name="username" id="username" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Password </td>
										<td><input value="<?echo $userDetails['password']?>" type="text" name="password" id="password" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><input value="<?echo $userDetails['address']?>" type="text" name="address" id="address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="<?echo $userDetails['email']?>" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile No </td>
										<td><input value="<?echo $userDetails['mobileNo']?>" type="text" name="mobileNo" id="mobileNo" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr style="display:none;">
	  									<td>Password For Edit</td>
										<td><input value="<?echo $userDetails['editDeletePassword']?>" type="text" name="editDeletePassword" id="editDeletePassword" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="adminId" value="<?echo $userDetails['adminId']?>" />	
	<input type="hidden"  id="WT_adminpagingPageno" value="1" />	
	<div class="formDivButton">						
	<input type="button" value="Save" onclick="WT_adminEditAndSave();" />
	</div> 
	</div>	
	
	 
	
	</td>
   
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 

	
 
function WT_adminEditAndSave()  // collect data and send to save
{

var formdata = new FormData();
var nameVal= os.getVal('name'); 
var usernameVal= os.getVal('username'); 
var passwordVal= os.getVal('password'); 
var addressVal= os.getVal('address'); 
var emailVal= os.getVal('email'); 
var mobileNoVal= os.getVal('mobileNo'); 
var editDeletePasswordVal= os.getVal('editDeletePassword'); 


formdata.append('name',nameVal );
formdata.append('username',usernameVal );
formdata.append('password',passwordVal );
formdata.append('address',addressVal );
formdata.append('email',emailVal );
formdata.append('mobileNo',mobileNoVal );
formdata.append('editDeletePassword',editDeletePasswordVal );
var   adminId=os.getVal('adminId');
formdata.append('adminId',adminId );
var url='<? echo $ajaxFilePath ?>?WT_adminEditAndSave=OK&';
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
os.setAjaxFunc('WT_adminReLoadList',url,formdata);

}	


function WT_adminReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var adminId=parseInt(d[0]);
	if(d[0]!='Error' && adminId>0)
	{
	  os.setVal('adminId',adminId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_adminListing();
}
	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>
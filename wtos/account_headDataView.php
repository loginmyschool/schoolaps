<?
/*
   # wtos version : 1.1
   # main ajax process page : account_headAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Account Head';
$ajaxFilePath= 'account_headAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';






$return_acc=$os->branch_access();
$and_branch='';
 if($os->userDetails['adminType']!='Super Admin')
	{
	  $selected_branch_codes=$return_acc['branches_code_str_query'];
	  $and_branch=" and branch_code IN($selected_branch_codes)";

	 }

$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
     $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}

include('wtosSearchAddAssign.php');
 $parent_head_id_session=$os->getSession( 'parent_head_id');
?>
  

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_account_headDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_account_headEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Account Head </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Parent Head </td>
										<td> <select name="parent_head_id" id="parent_head_id" class="textbox fWidth"  ><option value=""> </option>		  	<? 
								
										  $os->optionsHTML($parent_head_id_session,'account_head_id','title','account_head');?>
							</select> </td>						
										</tr><tr style="display:none;" >
	  									<td>Branch </td>
										<td> <select name="branch_code" id="branch_code" class="textbox fWidth" style="width:300px;"><option value=""> </option>		  	<? 
								
										  $os->onlyOption($branch_code_arr,'');?>
							</select>
							
							<? if($os->userDetails['adminType']=='Super Admin'){ ?> 
									 <span id="SAA_D" class="SAA_Container"> </span>

              				 <script>
              				saa.execute('d','SAA_D','branch_code','branch','branch_code','branch_name,branch_code','Branch,Code','branch_code','','');
              				</script>
							<? } ?>
							
							 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="account_head_id" value="0" />	
	<input type="hidden"  id="WT_account_headpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_account_headDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_account_headEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
  
  Branch:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" style="width:300px;" ><option value=""> </option>		  	<? 
								
										  $os->onlyOption($branch_code_arr,'');?>
							</select>
							 <? if($os->userDetails['adminType']=='Super Admin'){ ?> 
									 <span id="SAA_C" class="SAA_Container"> </span>

              				 <script>
              				saa.execute('c','SAA_C','branch_code_s','branch','branch_code','branch_name,branch_code','Branch,Code','branch_code','','');
              				</script>
							<? } ?>
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Account Head: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Parent Head:
	
	
	<select name="parent_head_id" id="parent_head_id_s" class="textbox fWidth" ><option value="">Select Parent Head</option>		  	<? 
								
										  $os->optionsHTML('','account_head_id','title','account_head');?>
							</select>
   
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_account_headListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_account_headListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_account_headListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var title_sVal= os.getVal('title_s'); 
 var parent_head_id_sVal= os.getVal('parent_head_id_s'); 
 var branch_code_sVal= os.getVal('branch_code_s'); 
formdata.append('title_s',title_sVal );
formdata.append('parent_head_id_s',parent_head_id_sVal );
formdata.append('branch_code_s',branch_code_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_account_headpagingPageno=os.getVal('WT_account_headpagingPageno');
	var url='wtpage='+WT_account_headpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_account_headListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_account_headListDiv',url,formdata);
		
}

WT_account_headListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('title_s',''); 
 os.setVal('parent_head_id_s',''); 
 os.setVal('branch_code_s',''); 
	
		os.setVal('searchKey','');
		WT_account_headListing();	
	
	}
	
 
function WT_account_headEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var titleVal= os.getVal('title'); 
var parent_head_idVal= os.getVal('parent_head_id'); 
var branch_codeVal= os.getVal('branch_code'); 


 formdata.append('title',titleVal );
 formdata.append('parent_head_id',parent_head_idVal );
 formdata.append('branch_code',branch_codeVal );

	
if(os.check.empty('title','Please Add Account Head')==false){ return false;} 
//if(os.check.empty('branch_code','Please Add Branch')==false){ return false;} 

	 var   account_head_id=os.getVal('account_head_id');
	 formdata.append('account_head_id',account_head_id );
  	var url='<? echo $ajaxFilePath ?>?WT_account_headEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_account_headReLoadList',url,formdata);

}	

function WT_account_headReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var account_head_id=parseInt(d[0]);
	if(d[0]!='Error' && account_head_id>0)
	{
	  os.setVal('account_head_id',account_head_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_account_headListing();
}

function WT_account_headGetById(account_head_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('account_head_id',account_head_id );
	var url='<? echo $ajaxFilePath ?>?WT_account_headGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_account_headFillData',url,formdata);
				
}

function WT_account_headFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('account_head_id',parseInt(objJSON.account_head_id));
	
 os.setVal('title',objJSON.title); 
 os.setVal('parent_head_id',objJSON.parent_head_id); 
 os.setVal('branch_code',objJSON.branch_code); 

  
}

function WT_account_headDeleteRowById(account_head_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(account_head_id)<1 || account_head_id==''){  
	var  account_head_id =os.getVal('account_head_id');
	}
	
	if(parseInt(account_head_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('account_head_id',account_head_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_account_headDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_account_headDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_account_headDeleteRowByIdResults(data)
{
	alert(data);
	WT_account_headListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_account_headpagingPageno',parseInt(pageNo));
	WT_account_headListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>
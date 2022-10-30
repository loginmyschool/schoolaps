<?
/*
   # wtos version : 1.1
   # main ajax process page : libraryAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List library';
$ajaxFilePath= 'libraryAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_libraryDeleteRowById('');" /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_libraryEditAndSave();" /><? } ?>

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Branch </td>
										<td> <select name="branch_code" id="branch_code" class="textbox fWidth select2" ><option value="">Select Branch</option>		  	<?

										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select> </td>
										</tr><tr >
	  									<td>Admin </td>
										<td> <select name="admin_id" id="admin_id" class="textbox fWidth select2" ><option value="">Select Admin</option>		  	<?

										  $os->optionsHTML('','adminId','name','admin');?>
							</select> </td>
										</tr><tr >
	  									<td>Campus </td>
										<td> <select name="campus_location_id" id="campus_location_id" class="textbox fWidth" ><option value="">Select Campus</option>		  	<?

										  $os->optionsHTML('','campus_location_id','campus_name','campus_location');?>
							</select> </td>
										</tr>


	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="library_id" value="0" />
	<input type="hidden"  id="WT_librarypagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_libraryDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_libraryEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;



  <div style="display:none" id="advanceSearchDiv">

 library_id: <input type="text" class="wtTextClass" name="library_id_s" id="library_id_s" value="" /> &nbsp;  Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Branch:


	<select name="branch_code" id="branch_code_s" class="textbox fWidth select2" ><option value="">Select Branch</option>		  	<?

										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Admin:


	<select name="admin_id" id="admin_id_s" class="textbox fWidth select2" ><option value="">Select Admin</option>		  	<?

										  $os->optionsHTML('','adminId','name','admin');?>
							</select>
   Campus:


	<select name="campus_location_id" id="campus_location_id_s" class="textbox fWidth" ><option value="">Select Campus</option>		  	<?

										  $os->optionsHTML('','campus_location_id','campus_name','campus_location');?>
							</select>

  </div>


  <input type="button" value="Search" onclick="WT_libraryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_libraryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_libraryListing() // list table searched data get
{
	var formdata = new FormData();


 var library_id_sVal= os.getVal('library_id_s');
 var name_sVal= os.getVal('name_s');
 var branch_code_sVal= os.getVal('branch_code_s');
 var admin_id_sVal= os.getVal('admin_id_s');
 var campus_location_id_sVal= os.getVal('campus_location_id_s');
formdata.append('library_id_s',library_id_sVal );
formdata.append('name_s',name_sVal );
formdata.append('branch_code_s',branch_code_sVal );
formdata.append('admin_id_s',admin_id_sVal );
formdata.append('campus_location_id_s',campus_location_id_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_librarypagingPageno=os.getVal('WT_librarypagingPageno');
	var url='wtpage='+WT_librarypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_libraryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_libraryListDiv',url,formdata);

}

WT_libraryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('library_id_s','');
 os.setVal('name_s','');
 os.setVal('branch_code_s','');
 os.setVal('admin_id_s','');
 os.setVal('campus_location_id_s','');

		os.setVal('searchKey','');
		WT_libraryListing();

	}


function WT_libraryEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var nameVal= os.getVal('name');
var branch_codeVal= os.getVal('branch_code');
var admin_idVal= os.getVal('admin_id');
var campus_location_idVal= os.getVal('campus_location_id');


 formdata.append('name',nameVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('admin_id',admin_idVal );
 formdata.append('campus_location_id',campus_location_idVal );



	 var   library_id=os.getVal('library_id');
	 formdata.append('library_id',library_id );
  	var url='<? echo $ajaxFilePath ?>?WT_libraryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_libraryReLoadList',url,formdata);

}

function WT_libraryReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var library_id=parseInt(d[0]);
	if(d[0]!='Error' && library_id>0)
	{
	  os.setVal('library_id',library_id);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_libraryListing();
}

function WT_libraryGetById(library_id) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('library_id',library_id );
	var url='<? echo $ajaxFilePath ?>?WT_libraryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_libraryFillData',url,formdata);

}

function WT_libraryFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('library_id',parseInt(objJSON.library_id));

 os.setVal('name',objJSON.name);
 os.setVal('branch_code',objJSON.branch_code);
 os.setVal('admin_id',objJSON.admin_id);
 os.setVal('campus_location_id',objJSON.campus_location_id);


}

function WT_libraryDeleteRowById(library_id) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(library_id)<1 || library_id==''){
	var  library_id =os.getVal('library_id');
	}

	if(parseInt(library_id)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('library_id',library_id );

	var url='<? echo $ajaxFilePath ?>?WT_libraryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_libraryDeleteRowByIdResults',url,formdata);
	}


}
function WT_libraryDeleteRowByIdResults(data)
{
	alert(data);
	WT_libraryListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_librarypagingPageno',parseInt(pageNo));
	WT_libraryListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>

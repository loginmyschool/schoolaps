<?
/*
   # wtos version : 1.1
   # main ajax process page : rbserviceAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbservice';
$ajaxFilePath= 'rbserviceAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

  include('wtosSearchAddAssign.php');
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbserviceDeleteRowById('');" /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbserviceEditAndSave();" /><? } ?>

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Service Code </td>
										<td><input value="" type="text" name="serviceCode" id="serviceCode" class="textboxxx  fWidth "/> </td>
										</tr>


	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="rbserviceId" value="0" />
	<input type="hidden"  id="WT_rbservicepagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbserviceDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbserviceEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;



  <div style="display:none" id="advanceSearchDiv">

 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Service Code: <input type="text" class="wtTextClass" name="serviceCode_s" id="serviceCode_s" value="" /> &nbsp;
  </div>


  <input type="button" value="Search" onclick="WT_rbserviceListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbserviceListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_rbserviceListing() // list table searched data get
{
	var formdata = new FormData();


 var name_sVal= os.getVal('name_s');
 var serviceCode_sVal= os.getVal('serviceCode_s');
formdata.append('name_s',name_sVal );
formdata.append('serviceCode_s',serviceCode_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbservicepagingPageno=os.getVal('WT_rbservicepagingPageno');
	var url='wtpage='+WT_rbservicepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbserviceListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_rbserviceListDiv',url,formdata);

}

WT_rbserviceListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s','');
 os.setVal('serviceCode_s','');

		os.setVal('searchKey','');
		WT_rbserviceListing();

	}


function WT_rbserviceEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var nameVal= os.getVal('name');
var serviceCodeVal= os.getVal('serviceCode');


 formdata.append('name',nameVal );
 formdata.append('serviceCode',serviceCodeVal );



	 var   rbserviceId=os.getVal('rbserviceId');
	 formdata.append('rbserviceId',rbserviceId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbserviceEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbserviceReLoadList',url,formdata);

}

function WT_rbserviceReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var rbserviceId=parseInt(d[0]);
	if(d[0]!='Error' && rbserviceId>0)
	{
	  os.setVal('rbserviceId',rbserviceId);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_rbserviceListing();
}

function WT_rbserviceGetById(rbserviceId) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('rbserviceId',rbserviceId );
	var url='<? echo $ajaxFilePath ?>?WT_rbserviceGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbserviceFillData',url,formdata);

}

function WT_rbserviceFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('rbserviceId',parseInt(objJSON.rbserviceId));

 os.setVal('name',objJSON.name);
 os.setVal('serviceCode',objJSON.serviceCode);


}

function WT_rbserviceDeleteRowById(rbserviceId) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(rbserviceId)<1 || rbserviceId==''){
	var  rbserviceId =os.getVal('rbserviceId');
	}

	if(parseInt(rbserviceId)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('rbserviceId',rbserviceId );

	var url='<? echo $ajaxFilePath ?>?WT_rbserviceDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbserviceDeleteRowByIdResults',url,formdata);
	}


}
function WT_rbserviceDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbserviceListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbservicepagingPageno',parseInt(pageNo));
	WT_rbserviceListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>

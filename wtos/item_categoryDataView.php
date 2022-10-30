<?
/*
   # wtos version : 1.1
   # main ajax process page : item_categoryAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Item Category';
$ajaxFilePath= 'item_categoryAjax.php';
$os->loadPluginConstant($pluginName);
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_item_categoryDeleteRowById('');" /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_item_categoryEditAndSave();" /><? } ?>

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="category_name" id="category_name" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Keywords </td>
										<td><textarea  name="category_keywords" id="category_keywords" ></textarea></td>
										</tr>


	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="item_category_id" value="0" />
	<input type="hidden"  id="WT_item_categorypagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_item_categoryDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_item_categoryEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;



  <div style="display:none" id="advanceSearchDiv">

 Name: <input type="text" class="wtTextClass" name="category_name_s" id="category_name_s" value="" /> &nbsp;  Keywords: <input type="text" class="wtTextClass" name="category_keywords_s" id="category_keywords_s" value="" /> &nbsp;
  </div>


  <input type="button" value="Search" onclick="WT_item_categoryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_item_categoryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_item_categoryListing() // list table searched data get
{
	var formdata = new FormData();


 var category_name_sVal= os.getVal('category_name_s');
 var category_keywords_sVal= os.getVal('category_keywords_s');
formdata.append('category_name_s',category_name_sVal );
formdata.append('category_keywords_s',category_keywords_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_item_categorypagingPageno=os.getVal('WT_item_categorypagingPageno');
	var url='wtpage='+WT_item_categorypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_item_categoryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_item_categoryListDiv',url,formdata);

}

WT_item_categoryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('category_name_s','');
 os.setVal('category_keywords_s','');

		os.setVal('searchKey','');
		WT_item_categoryListing();

	}


function WT_item_categoryEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var category_nameVal= os.getVal('category_name');
var category_keywordsVal= os.getVal('category_keywords');


 formdata.append('category_name',category_nameVal );
 formdata.append('category_keywords',category_keywordsVal );


if(os.check.empty('category_name','Please Add Name')==false){ return false;}
if(os.check.empty('category_keywords','Please Add Keywords')==false){ return false;}

	 var   item_category_id=os.getVal('item_category_id');
	 formdata.append('item_category_id',item_category_id );
  	var url='<? echo $ajaxFilePath ?>?WT_item_categoryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_item_categoryReLoadList',url,formdata);

}

function WT_item_categoryReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var item_category_id=parseInt(d[0]);
	if(d[0]!='Error' && item_category_id>0)
	{
	  os.setVal('item_category_id',item_category_id);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_item_categoryListing();
}

function WT_item_categoryGetById(item_category_id) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('item_category_id',item_category_id );
	var url='<? echo $ajaxFilePath ?>?WT_item_categoryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_item_categoryFillData',url,formdata);

}

function WT_item_categoryFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('item_category_id',parseInt(objJSON.item_category_id));

 os.setVal('category_name',objJSON.category_name);
 os.setVal('category_keywords',objJSON.category_keywords);


}

function WT_item_categoryDeleteRowById(item_category_id) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(item_category_id)<1 || item_category_id==''){
	var  item_category_id =os.getVal('item_category_id');
	}

	if(parseInt(item_category_id)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('item_category_id',item_category_id );

	var url='<? echo $ajaxFilePath ?>?WT_item_categoryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_item_categoryDeleteRowByIdResults',url,formdata);
	}


}
function WT_item_categoryDeleteRowByIdResults(data)
{
	alert(data);
	WT_item_categoryListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_item_categorypagingPageno',parseInt(pageNo));
	WT_item_categoryListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>

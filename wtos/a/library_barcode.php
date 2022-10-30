<?
/*
   # wtos version : 1.1
   # main ajax process page : library_barcode_ajax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='Library Barcode';
$ajaxFilePath= 'library_barcode_ajax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_item_uniqueDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_item_uniqueEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>is_ready </td>
										<td><input value="" type="text" name="is_ready" id="is_ready" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="item_unique_id" value="0" />	
	<input type="hidden"  id="WT_item_uniquepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_item_uniqueDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_item_uniqueEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 
  </div>
 
   
  <input type="button" value="Search" onclick="WT_item_uniqueListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_item_uniqueListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_item_uniqueListing() // list table searched data get 
{
	var formdata = new FormData();
	
	

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_item_uniquepagingPageno=os.getVal('WT_item_uniquepagingPageno');
	var url='wtpage='+WT_item_uniquepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_item_uniqueListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_item_uniqueListDiv',url,formdata);
		
}

WT_item_uniqueListing();
function  searchReset() // reset Search Fields
	{
			
		os.setVal('searchKey','');
		WT_item_uniqueListing();	
	
	}
	
 
function WT_item_uniqueEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var is_readyVal= os.getVal('is_ready'); 


 formdata.append('is_ready',is_readyVal );

	

	 var   item_unique_id=os.getVal('item_unique_id');
	 formdata.append('item_unique_id',item_unique_id );
  	var url='<? echo $ajaxFilePath ?>?WT_item_uniqueEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_item_uniqueReLoadList',url,formdata);

}	

function WT_item_uniqueReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var item_unique_id=parseInt(d[0]);
	if(d[0]!='Error' && item_unique_id>0)
	{
	  os.setVal('item_unique_id',item_unique_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_item_uniqueListing();
}

function WT_item_uniqueGetById(item_unique_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('item_unique_id',item_unique_id );
	var url='<? echo $ajaxFilePath ?>?WT_item_uniqueGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_item_uniqueFillData',url,formdata);
				
}

function WT_item_uniqueFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('item_unique_id',parseInt(objJSON.item_unique_id));
	
 os.setVal('is_ready',objJSON.is_ready); 

  
}

function WT_item_uniqueDeleteRowById(item_unique_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(item_unique_id)<1 || item_unique_id==''){  
	var  item_unique_id =os.getVal('item_unique_id');
	}
	
	if(parseInt(item_unique_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('item_unique_id',item_unique_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_item_uniqueDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_item_uniqueDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_item_uniqueDeleteRowByIdResults(data)
{
	alert(data);
	WT_item_uniqueListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_item_uniquepagingPageno',parseInt(pageNo));
	WT_item_uniqueListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>
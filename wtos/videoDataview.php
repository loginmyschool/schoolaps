<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List Video';
$ajaxFilePath= 'videoAjax.php';
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
								<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_videoDeleteRowById('');" /><? } ?>	 
								&nbsp;&nbsp;
								&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

								&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="videoEditAndSave();" /><? } ?>	 

							</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	

								<tr >
									<td>Title </td>
									<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
								</tr>
								<tr >
									<td>Youtube Url </td>
									<td><input value="" type="text" name="youtubeLink" id="youtubeLink" class="textboxxx  fWidth "/> </td>						
								</tr>
								<tr >
									<td>Show In Home </td>
									<td>  

										<select name="show_in_home" id="show_in_home" class="textbox fWidth" style=" width: 150px;"><option value=""></option>	<? 
										$os->onlyOption($os->noYes);	?></select>	 </td>						
									</tr>
									<tr >
										<td>Active </td>
										<td>  

											<select name="active_status" id="active_status" class="textbox fWidth" style=" width: 150px;"><option value=""></option>	<? 
											$os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr><tr >
											<td>Priority </td>
											<td><input value="" type="text" name="view_order" id="view_order" class="textboxxx  fWidth "/> </td>						
										</tr>




									</table>


									<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
									<input type="hidden"  id="video_id" value="0" />	
									<input type="hidden"  id="WT_videopagingPageno" value="1" />	
									<div class="formDivButton">						
										<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_videoDeleteRowById('');" />	<? } ?>	  
										&nbsp;&nbsp;
										&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

										&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="videoEditAndSave();" /><? } ?>	
									</div> 
								</div>	



							</td>
							<td valign="top" class="ajaxViewMainTableTDList">

								<div class="ajaxViewMainTableTDListSearch">
									Search Key  
									<input type="text" id="searchKey" />   &nbsp;


									<input type="button" value="Search" onclick="video_listing();" style="cursor:pointer;"/>
									<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

								</div>
								<div  class="ajaxViewMainTableTDListData" id="WT_videoListDiv">&nbsp; </div>
							&nbsp;</td>
						</tr>
					</table>



					<!--   ggggggggggggggg  -->

				</td>
			</tr>
		</table>



		<script>

function video_listing(){
	var formdata = new FormData();
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_videopagingPageno=os.getVal('WT_videopagingPageno');
	var url='wtpage='+WT_videopagingPageno;
	url='<? echo $ajaxFilePath ?>?video_listing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_videoListDiv',url,formdata);

}

video_listing();
function  searchReset(){		
	os.setVal('searchKey','');
	video_listing();
}


function videoEditAndSave(){

	var formdata = new FormData();
	var titleVal= os.getVal('title');
	var youtubeLinkVal= os.getVal('youtubeLink');
	var show_in_home= os.getVal('show_in_home'); 
	var activeVal= os.getVal('active_status'); 
	var view_orderVal= os.getVal('view_order'); 
	formdata.append('title',titleVal );
	formdata.append('youtubeLink',youtubeLinkVal );
	formdata.append('show_in_home',show_in_home );
	formdata.append('active_status',activeVal );
	formdata.append('view_order',view_orderVal );
	var   video_id=os.getVal('video_id');
	formdata.append('video_id',video_id );
	var url='<? echo $ajaxFilePath ?>?videoEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_videoReLoadList',url,formdata);

}	

function WT_videoReLoadList(data){
console.log(data);
	var d=data.split('#-#');
	var video_id=parseInt(d[0]);
	if(d[0]!='Error' && video_id>0)
	{
		os.setVal('video_id',video_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	video_listing();
}

function WT_videoGetById(video_id){
	var formdata = new FormData();	 
	formdata.append('video_id',video_id );
	var url='<? echo $ajaxFilePath ?>?WT_videoGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_videoFillData',url,formdata);

}

function WT_videoFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('video_id',parseInt(objJSON.video_id));
	os.setVal('title',objJSON.title); 
	os.setVal('show_in_home',objJSON.show_in_home); 
	
	os.setVal('active_status',objJSON.active_status); 
	os.setVal('view_order',objJSON.view_order); 
	os.setVal('youtubeLink',objJSON.youtubeLink); 
}

function WT_videoDeleteRowById(video_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(video_id)<1 || video_id==''){  
		var  video_id =os.getVal('video_id');
	}
	
	if(parseInt(video_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

		formdata.append('video_id',video_id );

		var url='<? echo $ajaxFilePath ?>?WT_videoDeleteRowById=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_videoDeleteRowByIdResults',url,formdata);
	}


}
function WT_videoDeleteRowByIdResults(data)
{
	alert(data);
	video_listing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_videopagingPageno',parseInt(pageNo));
	video_listing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
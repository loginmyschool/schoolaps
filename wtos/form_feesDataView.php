<?
/*
   # wtos version : 1.1
   # main ajax process page : form_feesAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Form Fees';
$ajaxFilePath= 'form_feesAjax.php';
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
								<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_form_feesDeleteRowById('');" /><? } ?>	 
								&nbsp;&nbsp;
								&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

								&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_form_feesEditAndSave();" /><? } ?>	 

							</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	

								<tr >
									<td>Form fees for </td>
									<td>  

										<select name="form_fees_for" id="form_fees_for" class="textbox fWidth" >
											<?$os->onlyOption($os->admissionType);	?></select>	 </td>						
										</tr><tr >
											<td>Year </td>
											<td><input value="" type="text" name="year" id="year" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
											<td>Class </td>
											<td>  

												<select name="class_id" id="class_id" class="textbox fWidth" ><option value="">Select Class</option>	<? 
												$os->onlyOption($os->classList);	?></select>	 </td>						
											</tr><tr >
												<td>Amount </td>
												<td><input value="" type="text" name="amount" id="amount" class="textboxxx  fWidth "/> </td>						
											</tr>	


										</table>


										<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
										<input type="hidden"  id="form_fees_id" value="0" />	
										<input type="hidden"  id="WT_form_feespagingPageno" value="1" />	
										<div class="formDivButton">						
											<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_form_feesDeleteRowById('');" />	<? } ?>	  
											&nbsp;&nbsp;
											&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

											&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_form_feesEditAndSave();" /><? } ?>	
										</div> 
									</div>	



								</td>
								<td valign="top" class="ajaxViewMainTableTDList">

									<div class="ajaxViewMainTableTDListSearch">
										Search Key  
										<input type="text" id="searchKey" />   &nbsp;



										<div style="display:none" id="advanceSearchDiv">

											Form fees for:

											<select name="form_fees_for" id="form_fees_for_s" class="textbox fWidth" ><option value="">Select Form fees for</option>	<? 
											$os->onlyOption($os->admissionType);	?></select>	
											Year: <input type="text" class="wtTextClass" name="year_s" id="year_s" value="" /> &nbsp;  Class:

											<select name="class_id" id="class_id_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
											$os->onlyOption($os->classList);	?></select>	
											Amount: <input type="text" class="wtTextClass" name="amount_s" id="amount_s" value="" /> &nbsp;  
										</div>


										<input type="button" value="Search" onclick="WT_form_feesListing();" style="cursor:pointer;"/>
										<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

									</div>
									<div  class="ajaxViewMainTableTDListData" id="WT_form_feesListDiv">&nbsp; </div>
								&nbsp;</td>
							</tr>
						</table>



						<!--   ggggggggggggggg  -->

					</td>
				</tr>
			</table>



			<script>

function WT_form_feesListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
	var form_fees_for_sVal= os.getVal('form_fees_for_s'); 
	var year_sVal= os.getVal('year_s'); 
	var class_id_sVal= os.getVal('class_id_s'); 
	var amount_sVal= os.getVal('amount_s'); 
	formdata.append('form_fees_for_s',form_fees_for_sVal );
	formdata.append('year_s',year_sVal );
	formdata.append('class_id_s',class_id_sVal );
	formdata.append('amount_s',amount_sVal );

	

	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_form_feespagingPageno=os.getVal('WT_form_feespagingPageno');
	var url='wtpage='+WT_form_feespagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_form_feesListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_form_feesListDiv',url,formdata);

}

WT_form_feesListing();
function  searchReset() // reset Search Fields
{
	os.setVal('form_fees_for_s',''); 
	os.setVal('year_s',''); 
	os.setVal('class_id_s',''); 
	os.setVal('amount_s',''); 
	
	os.setVal('searchKey','');
	WT_form_feesListing();	
	
}


function WT_form_feesEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var form_fees_forVal= os.getVal('form_fees_for'); 
	var yearVal= os.getVal('year'); 
	var class_idVal= os.getVal('class_id'); 
	var amountVal= os.getVal('amount'); 


	formdata.append('form_fees_for',form_fees_forVal );
	formdata.append('year',yearVal );
	formdata.append('class_id',class_idVal );
	formdata.append('amount',amountVal );

	
	if(os.check.empty('form_fees_for','Please Add Form fees for')==false){ return false;} 
	if(os.check.empty('year','Please Add Year')==false){ return false;} 
	if(os.check.empty('class_id','Please Add Class')==false){ return false;} 
	if(os.check.empty('amount','Please Add Amount')==false){ return false;} 

	var   form_fees_id=os.getVal('form_fees_id');
	formdata.append('form_fees_id',form_fees_id );
	var url='<? echo $ajaxFilePath ?>?WT_form_feesEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_form_feesReLoadList',url,formdata);

}	

function WT_form_feesReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var form_fees_id=parseInt(d[0]);
	if(d[0]!='Error' && form_fees_id>0)
	{
		os.setVal('form_fees_id',form_fees_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_form_feesListing();
}

function WT_form_feesGetById(form_fees_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('form_fees_id',form_fees_id );
	var url='<? echo $ajaxFilePath ?>?WT_form_feesGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_form_feesFillData',url,formdata);

}

function WT_form_feesFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('form_fees_id',parseInt(objJSON.form_fees_id));
	
	os.setVal('form_fees_for',objJSON.form_fees_for); 
	os.setVal('year',objJSON.year); 
	os.setVal('class_id',objJSON.class_id); 
	os.setVal('amount',objJSON.amount); 


}

function WT_form_feesDeleteRowById(form_fees_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(form_fees_id)<1 || form_fees_id==''){  
		var  form_fees_id =os.getVal('form_fees_id');
	}
	
	if(parseInt(form_fees_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

		formdata.append('form_fees_id',form_fees_id );

		var url='<? echo $ajaxFilePath ?>?WT_form_feesDeleteRowById=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_form_feesDeleteRowByIdResults',url,formdata);
	}


}
function WT_form_feesDeleteRowByIdResults(data)
{
	alert(data);
	WT_form_feesListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_form_feespagingPageno',parseInt(pageNo));
	WT_form_feesListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
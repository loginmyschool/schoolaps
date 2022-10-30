<?
/*
   # wtos version : 1.1
   # main ajax process page : fees_slabAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Fees Slab';
$ajaxFilePath= 'fees_slabAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';


// branch access--
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
// branch access-- end
 
 
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
								<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_fees_slabDeleteRowById('');" /><? } ?>	 
								&nbsp;&nbsp;
								&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
								
								&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_fees_slabEditAndSave();" /><? } ?>	 
								
							</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
								
								<tr >
									<td>Branch </td>
									<td> <select name="branch_code" id="branch_code"
            class="select2">
            <option value=""> </option>
            <? $os->onlyOption($branch_code_arr,'');	?>
        </select>
					 
								 </td>						
								</tr>
								
								
								<tr >
									<td>Title </td>
									<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
								</tr>
								
								
								
								<tr >
									<td>Year </td>
									<td>  
										
										<select name="year" id="year" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										$os->onlyOption($os->feesYear);	?></select>	 </td>						
									</tr><tr >
										<td>Class </td>
										<td>  
											
											<select name="classId" id="classId" class="textbox fWidth" ><option value="">Select Class</option>	<? 
											$os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
											<td>Note </td>
											<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
										
										
									</table>
									
									
									<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
									<input type="hidden"  id="fees_slab_id" value="0" />	
									<input type="hidden"  id="WT_fees_slabpagingPageno" value="1" />	
									<div class="formDivButton">						
										<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_fees_slabDeleteRowById('');" />	<? } ?>	  
										&nbsp;&nbsp;
										&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
										
										&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_fees_slabEditAndSave();" /><? } ?>	
									</div> 
								</div>	
								
								
								
							</td>
							<td valign="top" class="ajaxViewMainTableTDList">
								
								<div class="ajaxViewMainTableTDListSearch">
									Search Key  
									<input type="text" id="searchKey" />   &nbsp;
									
									  <select name="branch_code_s" id="branch_code_s"
            class="select2">
            <option value="">All Branch</option>
            <? $os->onlyOption($branch_code_arr,'');	?>
        </select> Year
					<select name="year" id="year_s" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										$os->onlyOption($os->feesYear);	?></select>		
										
										Class:
										
										<select name="classId" id="classId_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										$os->onlyOption($os->classList);	?></select>				
									<div style="display:none" id="advanceSearchDiv">
										
										Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Year:
										
										
										
										Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
									</div>
									
									
									<input type="button" value="Search" onclick="WT_fees_slabListing();" style="cursor:pointer;"/>
									<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
									
								</div>
								<div  class="ajaxViewMainTableTDListData" id="WT_fees_slabListDiv">&nbsp; </div>
							&nbsp;</td>
						</tr>
					</table>

					
					
					<!--   ggggggggggggggg  -->
					
				</td>
			</tr>
		</table>
		
		

		<script>
			
function WT_fees_slabListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
	var title_sVal= os.getVal('title_s'); 
	var year_sVal= os.getVal('year_s'); 
	var classId_sVal= os.getVal('classId_s'); 
	var note_sVal= os.getVal('note_s'); 
	formdata.append('title_s',title_sVal );
	formdata.append('year_s',year_sVal );
	formdata.append('classId_s',classId_sVal );
	formdata.append('note_s',note_sVal );
	
	

	var branch_code_sVal= os.getVal('branch_code_s'); 
	formdata.append('branch_code_s',branch_code_sVal );
	
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_fees_slabpagingPageno=os.getVal('WT_fees_slabpagingPageno');
	var url='wtpage='+WT_fees_slabpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_fees_slabListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_fees_slabListDiv',url,formdata);
	
}

WT_fees_slabListing();
function  searchReset() // reset Search Fields
{
	os.setVal('title_s',''); 
	os.setVal('year_s',''); 
	os.setVal('classId_s',''); 
	os.setVal('note_s',''); 
	os.setVal('branch_code_s',''); 
	
	os.setVal('searchKey','');
	WT_fees_slabListing();	
	
}


function WT_fees_slabEditAndSave()  // collect data and send to save
{
	
	var formdata = new FormData();
	var titleVal= os.getVal('title'); 
	var yearVal= os.getVal('year'); 
	var classIdVal= os.getVal('classId'); 
	var noteVal= os.getVal('note'); 


	formdata.append('title',titleVal );
	formdata.append('year',yearVal );
	formdata.append('classId',classIdVal );
	formdata.append('note',noteVal );
	
	
	var branch_codeVal= os.getVal('branch_code'); 
	formdata.append('branch_code',branch_codeVal );
	
	if(os.check.empty('branch_code','Enter Branch Please')==false){ return false;}
	if(os.check.empty('title','Enter title Please')==false){ return false;}
	if(os.check.empty('year','Enter year Please')==false){ return false;}
	if(os.check.empty('classId','Enter class Please')==false){ return false;}
	 

	

	var   fees_slab_id=os.getVal('fees_slab_id');
	formdata.append('fees_slab_id',fees_slab_id );
	var url='<? echo $ajaxFilePath ?>?WT_fees_slabEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_fees_slabReLoadList',url,formdata);

}	

function WT_fees_slabReLoadList(data) // after edit reload list
{
	
	var d=data.split('#-#');
	var fees_slab_id=parseInt(d[0]);
	if(d[0]!='Error' && fees_slab_id>0)
	{
		os.setVal('fees_slab_id',fees_slab_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_fees_slabListing();
}

function WT_fees_slabGetById(fees_slab_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('fees_slab_id',fees_slab_id );
	var url='<? echo $ajaxFilePath ?>?WT_fees_slabGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_fees_slabFillData',url,formdata);
	
}

function WT_fees_slabFillData(data)  // fill data form by JSON
{
	
	var objJSON = JSON.parse(data);
	os.setVal('fees_slab_id',parseInt(objJSON.fees_slab_id));
	
	os.setVal('title',objJSON.title); 
	os.setVal('year',objJSON.year); 
	os.setVal('classId',objJSON.classId); 
	os.setVal('note',objJSON.note); 
	os.setVal('branch_code',objJSON.branch_code); 
	
	

	
}

function WT_fees_slabDeleteRowById(fees_slab_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(fees_slab_id)<1 || fees_slab_id==''){  
		var  fees_slab_id =os.getVal('fees_slab_id');
	}
	
	if(parseInt(fees_slab_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
		
		formdata.append('fees_slab_id',fees_slab_id );
		
		var url='<? echo $ajaxFilePath ?>?WT_fees_slabDeleteRowById=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_fees_slabDeleteRowByIdResults',url,formdata);
	}
	

}
function WT_fees_slabDeleteRowByIdResults(data)
{
	alert(data);
	WT_fees_slabListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_fees_slabpagingPageno',parseInt(pageNo));
	WT_fees_slabListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
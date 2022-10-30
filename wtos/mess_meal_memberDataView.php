<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_meal_memberAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List mess_meal_member';
$ajaxFilePath= 'mess_meal_memberAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
$selected_branch_code=$os->getSession($key1='selected_branch_code'); 
$and_branch="  and branch_code IN('$selected_branch_code')"; 


//_d($os->userDetails);
//exit();
 
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_meal_memberDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_meal_memberEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
                                        <tr >
	  									<td>dated </td>
										<td colspan="10"><input value="<? echo $os->now('d-m-Y') ?>" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth" style="width:80px;"/></td>						
										</tr>
										<tr >
											<td style="width:120px;">  </td>
											<td> Total </td>							 
											<td> Present</td>
											<td>  Absent  </td>						
										</tr>
										<tr >
	  									<td>  Boys </td>
										<td><input value="" type="text" name="total_student_m" id="total_student_m" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>							 
	  									<td><input value="" type="text" name="present_student_m" id="present_student_m" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>
										<td> <span id="absent_student_m"></span>  </td>						
										</tr>
										
										
										<tr >
	  									<td>  Girls </td>
										<td><input value="" type="text" name="total_student_f" id="total_student_f" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_student_f" id="present_student_f" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>
										<td><span id="absent_student_f"></span>  </td>						
										</tr>
										
										
										
										<tr >
	  									<td>Male Teacher </td>
										<td><input value="" type="text" name="total_teacher_m" id="total_teacher_m" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_teacher_m" id="present_teacher_m" class="textboxxx  fWidth " onchange="calculate_absent()"/></td>
										<td><span id="absent_teacher_m"></span>  </td>						
										</tr>
										
										
										
										<tr >
	  									<td>Female Teacher </td>
										<td><input value="" type="text" name="total_teacher_f" id="total_teacher_f" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_teacher_f" id="present_teacher_f" class="textboxxx  fWidth " onchange="calculate_absent()"/></td>
										<td> <span id="absent_teacher_f"></span> </td>						
										</tr>
										
										
										
										
										<tr >
	  									<td>Office Staff </td>
										<td><input value="" type="text" name="total_office_staff" id="total_office_staff" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_office_staff" id="present_office_staff" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>
										<td> <span id="absent_office_staff"></span> </td>						
										</tr>
										
										
										
										<tr >
	  									<td>Kitchen Staff </td>
										<td><input value="" type="text" name="total_kichen_staff" id="total_kichen_staff" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_kichen_staff" id="present_kichen_staff" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>
										<td>  <span id="absent_kichen_staff"></span> </td>						
										</tr>
										
										
										<tr >
	  									<td>Male Gurdian </td>
										<td><input value="" type="text" name="total_gurdian_m" id="total_gurdian_m" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_gurdian_m" id="present_gurdian_m" class="textboxxx  fWidth " onchange="calculate_absent()"/></td>
										<td> <span id="absent_gurdian_m"></span>  </td>						
										</tr>
										
										
										<tr >
	  									<td>Female Gurdian </td>
										<td><input value="" type="text" name="total_gurdian_f" id="total_gurdian_f" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="present_gurdian_f" id="present_gurdian_f" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>
										<td> <span id="absent_gurdian_f"></span> </td>						
										</tr>
										
										
										
										<tr >
	  									<td>Total </td>
										<td><input value="" type="text" name="total" id="total" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>						
										 
	  									<td><input value="" type="text" name="total_present" id="total_present" class="textboxxx  fWidth " onchange="calculate_absent()"/> </td>
										<td> <span id="absent_total"></span> </td>						
										</tr>
										
										
										
										<tr style="display:none;" >
	  									<td>Primery Verification </td>
										<td><input value="" type="text" name="primery_verification_user" id="primery_verification_user" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Final Verification </td>
										<td><input value="" type="text" name="final_verification_user" id="final_verification_user" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr style="display:none;" >
	  									<td>Branch </td>
										<td colspan="10"> 
										
										 
										
										
										<select name="branch_code" id="branch_code" class="textbox fWidth" ><option value="">Select Branch</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_code','branch'," branch_code!=''  $and_branch ");?>
							</select> </td>						
										</tr><tr >
	  									<td >Note </td>
										<td colspan="10"><input value="" type="text" name="note" id="note" class="textboxxx  fWidth " style="width:200px;"/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	
	
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="mess_meal_member_id" value="0" />	
	<input type="hidden"  id="WT_mess_meal_memberpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_meal_memberDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_meal_memberEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  From dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value="<?   $os->now('d-m-Y') ?>"  /> &nbsp;   To dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value="<? echo $os->now('d-m-Y') ?>"  /> &nbsp;  
	 
  <div style="display:none" id="advanceSearchDiv">
         
From dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Branch:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_code','branch' ," branch_code!=''  $and_branch");?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_meal_memberListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_meal_memberListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_meal_memberListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var f_dated_sVal= os.getVal('f_dated_s'); 
 var t_dated_sVal= os.getVal('t_dated_s'); 
 var branch_code_sVal= os.getVal('branch_code_s'); 
 var note_sVal= os.getVal('note_s'); 
formdata.append('f_dated_s',f_dated_sVal );
formdata.append('t_dated_s',t_dated_sVal );
formdata.append('branch_code_s',branch_code_sVal );
formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_mess_meal_memberpagingPageno=os.getVal('WT_mess_meal_memberpagingPageno');
	var url='wtpage='+WT_mess_meal_memberpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_mess_meal_memberListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_mess_meal_memberListDiv',url,formdata);
		
}

WT_mess_meal_memberListing();
function  searchReset() // reset Search Fields
	{
		// os.setVal('f_dated_s',''); 
 //os.setVal('t_dated_s',''); 
 os.setVal('branch_code_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_mess_meal_memberListing();	
	
	}
	
 
function WT_mess_meal_memberEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var datedVal= os.getVal('dated'); 
var total_student_mVal= os.getVal('total_student_m'); 
var present_student_mVal= os.getVal('present_student_m'); 
var total_student_fVal= os.getVal('total_student_f'); 
var present_student_fVal= os.getVal('present_student_f'); 
var total_teacher_mVal= os.getVal('total_teacher_m'); 
var present_teacher_mVal= os.getVal('present_teacher_m'); 
var total_teacher_fVal= os.getVal('total_teacher_f'); 
var present_teacher_fVal= os.getVal('present_teacher_f'); 
var total_office_staffVal= os.getVal('total_office_staff'); 
var present_office_staffVal= os.getVal('present_office_staff'); 
var total_kichen_staffVal= os.getVal('total_kichen_staff'); 
var present_kichen_staffVal= os.getVal('present_kichen_staff'); 
var total_gurdian_mVal= os.getVal('total_gurdian_m'); 
var present_gurdian_mVal= os.getVal('present_gurdian_m'); 
var total_gurdian_fVal= os.getVal('total_gurdian_f'); 
var present_gurdian_fVal= os.getVal('present_gurdian_f'); 
var totalVal= os.getVal('total'); 
var total_presentVal= os.getVal('total_present'); 
var primery_verification_userVal= os.getVal('primery_verification_user'); 
var final_verification_userVal= os.getVal('final_verification_user'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('dated',datedVal );
 formdata.append('total_student_m',total_student_mVal );
 formdata.append('present_student_m',present_student_mVal );
 formdata.append('total_student_f',total_student_fVal );
 formdata.append('present_student_f',present_student_fVal );
 formdata.append('total_teacher_m',total_teacher_mVal );
 formdata.append('present_teacher_m',present_teacher_mVal );
 formdata.append('total_teacher_f',total_teacher_fVal );
 formdata.append('present_teacher_f',present_teacher_fVal );
 formdata.append('total_office_staff',total_office_staffVal );
 formdata.append('present_office_staff',present_office_staffVal );
 formdata.append('total_kichen_staff',total_kichen_staffVal );
 formdata.append('present_kichen_staff',present_kichen_staffVal );
 formdata.append('total_gurdian_m',total_gurdian_mVal );
 formdata.append('present_gurdian_m',present_gurdian_mVal );
 formdata.append('total_gurdian_f',total_gurdian_fVal );
 formdata.append('present_gurdian_f',present_gurdian_fVal );
 formdata.append('total',totalVal );
 formdata.append('total_present',total_presentVal );
 formdata.append('primery_verification_user',primery_verification_userVal );
 formdata.append('final_verification_user',final_verification_userVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('dated','Please Add dated')==false){ return false;} 
//if(os.check.empty('branch_code','Please Add Branch')==false){ return false;} 

	 var   mess_meal_member_id=os.getVal('mess_meal_member_id');
	 formdata.append('mess_meal_member_id',mess_meal_member_id );
  	var url='<? echo $ajaxFilePath ?>?WT_mess_meal_memberEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_meal_memberReLoadList',url,formdata);

}	

function WT_mess_meal_memberReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_meal_member_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_meal_member_id>0)
	{
	  os.setVal('mess_meal_member_id',mess_meal_member_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_meal_memberListing();
}

function WT_mess_meal_memberGetById(mess_meal_member_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_meal_member_id',mess_meal_member_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_meal_memberGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_meal_memberFillData',url,formdata);
				
}

function WT_mess_meal_memberFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_meal_member_id',parseInt(objJSON.mess_meal_member_id));
	
 os.setVal('dated',objJSON.dated); 
 os.setVal('total_student_m',objJSON.total_student_m); 
 os.setVal('present_student_m',objJSON.present_student_m); 
 os.setVal('total_student_f',objJSON.total_student_f); 
 os.setVal('present_student_f',objJSON.present_student_f); 
 os.setVal('total_teacher_m',objJSON.total_teacher_m); 
 os.setVal('present_teacher_m',objJSON.present_teacher_m); 
 os.setVal('total_teacher_f',objJSON.total_teacher_f); 
 os.setVal('present_teacher_f',objJSON.present_teacher_f); 
 os.setVal('total_office_staff',objJSON.total_office_staff); 
 os.setVal('present_office_staff',objJSON.present_office_staff); 
 os.setVal('total_kichen_staff',objJSON.total_kichen_staff); 
 os.setVal('present_kichen_staff',objJSON.present_kichen_staff); 
 os.setVal('total_gurdian_m',objJSON.total_gurdian_m); 
 os.setVal('present_gurdian_m',objJSON.present_gurdian_m); 
 os.setVal('total_gurdian_f',objJSON.total_gurdian_f); 
 os.setVal('present_gurdian_f',objJSON.present_gurdian_f); 
 os.setVal('total',objJSON.total); 
 os.setVal('total_present',objJSON.total_present); 
 os.setVal('primery_verification_user',objJSON.primery_verification_user); 
 os.setVal('final_verification_user',objJSON.final_verification_user); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  calculate_absent();
}

function WT_mess_meal_memberDeleteRowById(mess_meal_member_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_meal_member_id)<1 || mess_meal_member_id==''){  
	var  mess_meal_member_id =os.getVal('mess_meal_member_id');
	}
	
	if(parseInt(mess_meal_member_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_meal_member_id',mess_meal_member_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_meal_memberDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_meal_memberDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_meal_memberDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_meal_memberListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_meal_memberpagingPageno',parseInt(pageNo));
	WT_mess_meal_memberListing();
}

	
function calculate_absent()
{
		var total_student_mVal= os.getVal('total_student_m'); 
		var present_student_mVal= os.getVal('present_student_m'); 
		
		var total_student_fVal= os.getVal('total_student_f'); 
		var present_student_fVal= os.getVal('present_student_f'); 
		
		var total_teacher_mVal= os.getVal('total_teacher_m'); 
		var present_teacher_mVal= os.getVal('present_teacher_m'); 
		
		var total_teacher_fVal= os.getVal('total_teacher_f'); 
		var present_teacher_fVal= os.getVal('present_teacher_f'); 
		
		var total_office_staffVal= os.getVal('total_office_staff'); 
		var present_office_staffVal= os.getVal('present_office_staff'); 
		
		var total_kichen_staffVal= os.getVal('total_kichen_staff'); 
		var present_kichen_staffVal= os.getVal('present_kichen_staff'); 
		
		var total_gurdian_mVal= os.getVal('total_gurdian_m'); 
		var present_gurdian_mVal= os.getVal('present_gurdian_m'); 
		
		var total_gurdian_fVal= os.getVal('total_gurdian_f'); 
		var present_gurdian_fVal= os.getVal('present_gurdian_f'); 
		
	//	var totalVal= os.getVal('total'); 
	//	var total_presentVal= os.getVal('total_present'); 
		
		
		if(int(total_student_mVal)<int(present_student_mVal))
		{
			 present_student_mVal=0;
			 os.setVal('present_student_m',present_student_mVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_student_m',int(total_student_mVal)-int(present_student_mVal));
		
		
		if(int(total_student_fVal)<int(present_student_fVal))
		{
			 present_student_fVal=0;
			 os.setVal('present_student_f',present_student_fVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_student_f',int(total_student_fVal)-int(present_student_fVal));
		
		if(int(total_teacher_mVal)<int(present_teacher_mVal))
		{
			 present_teacher_mVal=0;
			 os.setVal('present_teacher_m',present_teacher_mVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_teacher_m',int(total_teacher_mVal)-int(present_teacher_mVal));
		
		
		
		if(int(total_teacher_fVal)<int(present_teacher_fVal))
		{
			 present_teacher_fVal=0;
			 os.setVal('present_teacher_f',present_teacher_fVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_teacher_f',int(total_teacher_fVal)-int(present_teacher_fVal));
		
		
		 
		
		
       if(int(total_office_staffVal)<int(present_office_staffVal))
		{
			 present_office_staffVal=0;
			 os.setVal('present_office_staff',present_office_staffVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_office_staff',int(total_office_staffVal)-int(present_office_staffVal));
		
		
		
		 if(int(total_kichen_staffVal)<int(present_kichen_staffVal))
		{
			 present_kichen_staffVal=0;
			 os.setVal('present_kichen_staff',present_kichen_staffVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_kichen_staff',int(total_kichen_staffVal)-int(present_kichen_staffVal));
		
		
		 if(int(total_gurdian_mVal)<int(present_gurdian_mVal))
		{
			 present_gurdian_mVal=0;
			 os.setVal('present_gurdian_m',present_gurdian_mVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_gurdian_m',int(total_gurdian_mVal)-int(present_gurdian_mVal));
		
		
		if(int(total_gurdian_fVal)<int(present_gurdian_fVal))
		{
			 present_gurdian_fVal=0;
			 os.setVal('present_gurdian_f',present_gurdian_fVal);
			 alert('Please put correct value');
		}
		os.setHtml('absent_gurdian_f',int(total_gurdian_fVal)-int(present_gurdian_fVal));
		 
		
		var totalVal= os.getVal('total'); 
		var total_presentVal= os.getVal('total_present'); 
		
		var total_count=int(total_student_mVal)
		+int(total_student_fVal)
		+int(total_teacher_mVal)
		+int(total_teacher_fVal)
		+int(total_office_staffVal)
		+int(total_kichen_staffVal)
		+int(total_gurdian_mVal)
		+int(total_gurdian_fVal);
		
		var total_present_count=int(present_student_mVal)
		+int(present_student_fVal)
		+int(present_teacher_mVal)
		+int(present_teacher_fVal)
		+int(present_office_staffVal)
		+int(present_kichen_staffVal)
		+int(present_gurdian_mVal)
		+int(present_gurdian_fVal);
		 
		var absent_count=total_count-total_present_count;
		
		os.setVal('total',int(total_count));
		os.setVal('total_present',int(total_present_count));
		os.setHtml('absent_total',int(absent_count));
		
}	
	
	
	 
	 
</script>

<style>
.textboxxx{ width:40px;}

</style>
  <style>
.tooltip {
    display:inline-block;
    position:relative;
     
    text-align:left;
}

.tooltip .top {
    min-width:200px; 
    top:2px;
    left:50%;
    transform:translate(-50%, -100%);
    padding:10px 20px;
    color:#444444;
    background-color:#EEEEEE;
    font-weight:normal;
    font-size:13px;
    border-radius:8px;
    position:absolute;
    z-index:99999999;
    box-sizing:border-box;
    box-shadow:0 1px 8px rgba(0,0,0,0.5);
    display:none;
}

.tooltip:hover .top {
    display:block;
}

.tooltip .top i {
    position:absolute;
    top:100%;
    left:50%;
    margin-left:-12px;
    width:24px;
    height:12px;
    overflow:hidden;
}

.tooltip .top i::after {
    content:'';
    position:absolute;
    width:12px;
    height:12px;
    left:50%;
    transform:translate(-50%,-50%) rotate(45deg);
    background-color:#EEEEEE;
    box-shadow:0 1px 8px rgba(0,0,0,0.5);
}
</style>
 
<? include($site['root-wtos'].'bottom.php'); ?>
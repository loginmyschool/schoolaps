<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/
 


include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='Fees Report';

$ajaxFilePath= 'due_fees_report_ajax.php';

$os->loadPluginConstant($pluginName);

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

$fees_type_array=array();   
$type_q="select distinct(feesType) feesType_val from fees_student  ";
$type_q_rs= $os->mq($type_q);
while ($row = $os->mfa($type_q_rs))
{
  
  $fees_type_array[$row['feesType_val']]=$row['feesType_val'];
	 
} 
 
 
// branch access-- end
  ?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
         
    </div>

</div>

<div class="content">
    <div class="item">

        <div class=" text-m p-top-m" style="">
		
		
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="">
		<select name="branch_code_s" id="branch_code_s"
            class="select2--" style="z-index:1;background-color:#FFFFFF;">
            <option value="">All Branch</option>
            <? $os->onlyOption($branch_code_arr,'');	?>
        </select>
		
		 </div>
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="Class">
                <span class="uk-form-icon" uk-icon="icon: user; ratio:0.7"></span>
                <select name="classList" id="classList_s" class="uk-select uk-border-rounded uk-form-small p-left-xxxl">
                    <option value="">Class</option>
                    <? $os->onlyOption($os->classList,'');	?>
                </select>
            </div>
			
			 <div class="uk-inline uk-margin-small-left" uk-tooltip="">
		<select name="fees_type_s" id="fees_type_s" style="background-color:#FFFFFF;"
             >
            <option value="">All type fees</option>
            <? $os->onlyOption($fees_type_array,'');	?>
        </select>
		
		 </div>
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="" > From 
		  <select name="from_month_s" id="from_month_s" 
            class="select2--" style="width:100px;background-color:#FFFFFF;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesMonth,date('m'));	?>
        </select>
		 <select name="from_year_s" id="from_year_s"
            class="select2--" style="width:70px;background-color:#FFFFFF;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesYear,date('Y'));	?>
        </select>
		
		 </div>
		  <div class="uk-inline uk-margin-small-left" uk-tooltip=""> To 
		  <select name="to_month_s" id="to_month_s"
            class="select2--" style="width:100px;background-color:#FFFFFF;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesMonth,date('m'));	?>
        </select>
		 <select name="to_year_s" id="to_year_s"
            class="select2--" style="width:70px;background-color:#FFFFFF;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesYear,date('Y'));	?>
        </select>
		
		 </div>
		 
		  <div class="uk-inline uk-margin-small-left" uk-tooltip="">
		  Follow Up Date:
		  <input type="text" placeholder="yyyy-mm-dd"  style="width:85px;background-color:#FFFFFF;" name="follow_up_date_s" id="follow_up_date_s" value="" />
		  
		 
		
		 </div>
		 
		  
            <div class="uk-float-right uk-margin-small-right">
 
            </div>

        </div>
		<div class=" text-m p-top-m" style="">
		
		 
		 
		 

            
            <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="monthly_fees_report('');">
                 
                Search
            </button>
			<button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="monthly_fees_report('Todays Followup');">
                <!--<span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>-->
                Only Today's Followups
            </button>
			<button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="monthly_fees_report('Todays and Past Followup');">
                <!--<span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>-->
                Today's and Past Followups
            </button>
			
			<button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="location.reload();">
                
                Reset
            </button>
			 
              <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="printById('print_div_area');">
                
                Print
            </button>

            <div class="uk-float-right uk-margin-small-right">
 
            </div>

        </div>
		<div id="print_div_area">
		
		<style>
.noBorder{border:groove 2px #FFFFFF; border-radius:5px;}
.noBorder td{ height:30px;border-right:solid 1px #CACACA;border-bottom:solid 1px #CACACA; padding:1px 2px 1px 2px; font-size:11px;}

</style>
        <div class="uk-margin-small-top" id="monthly_fees_report_div_id" style="margin:20px; border:2px solid groove; "> 
		
		
		
		
		</div>
</div>
    </div>
</div>



 
<script>

    function monthly_fees_report(action) // get record by table primery id
    {
	 
        
		 if(action=='Todays Followup'  || action=='Todays and Past Followup'  )
		 { 
		// var  dateformatted  = toDayStr();
		 var today = new Date();
		 
		 var dd=today.getDate(); dd=dd.toString(); if(dd.length==1){dd='0'+dd;}

	var mm=today.getMonth()+1; mm=mm.toString(); if(mm.length==1){mm='0'+mm;}

	var yyyy=today.getFullYear();
		 
		 // alert( dateformatted );
 			 var dateformatted=  yyyy + '-'+ mm+ '-' + dd;
		   os.setVal('follow_up_date_s',dateformatted)
		 }
		
		
		
		var formdata = new FormData();
		
		var branch_code_val=os.getVal('branch_code_s');
        formdata.append('branch_code_s',branch_code_val );
		// if(os.check.empty('branch_code_s','Please select branch')==false){ return false;}
		var from_month_s=os.getVal('from_month_s');
        formdata.append('from_month_s',from_month_s );
		
		var from_year_s=os.getVal('from_year_s');
        formdata.append('from_year_s',from_year_s );
		
		var to_month_s=os.getVal('to_month_s');
        formdata.append('to_month_s',to_month_s );
		
		var to_year_s=os.getVal('to_year_s');
        formdata.append('to_year_s',to_year_s );
		
		var classList_s=os.getVal('classList_s');
        formdata.append('classList_s',classList_s );
		
		var fees_type_s=os.getVal('fees_type_s');
        formdata.append('fees_type_s',fees_type_s );
		
		var follow_up_date_s_val=os.getVal('follow_up_date_s');
        formdata.append('follow_up_date_s',follow_up_date_s_val );
		
		
		 formdata.append('action',action );
		

        formdata.append('monthly_fees_report','OK' );
        var url='<? echo $ajaxFilePath ?>?monthly_fees_report=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('monthly_fees_report_div_id',url,formdata);

    }
	
	

    function manage_fess_setting_results(data)  
    {

        


    }
	
	</script>
	
	<div id="student_followup_history_modal" class="uk-flex-top" uk-modal > 
    <div class="uk-modal-dialog uk-width-1-1">  <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
       <div class="">
    
			
            <div  id="student_followup_history_div_view" style="padding:10px;">
            
		   
		    </div>
			
		
        </div>
    </div>
</div>
	<script>
	
	function manage_followup(history_id,action) // get record by table primery id
    {
	 
	    if(document.getElementById('student_followup_history_form')){
        var formdata = new FormData(os.getObj('student_followup_history_form'));
		}else{
		 var formdata = new FormData();
		}
		
		//var history_id=os.getVal('history_id');
        formdata.append('history_id',history_id );
		
		 formdata.append('action',action );
		 
		 

        formdata.append('manage_followup','OK' );
        var url='<? echo $ajaxFilePath ?>?manage_followup=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_followup_results',url,formdata);

    }
	
	

    function manage_followup_results(data)  
    {
	
	var historyId=	getData(data,'##--historyId--##');
    var  div = 'followup_div_id_'+historyId;
	
	var  html=	getData(data,'##--followup_history_html--##');
      os.setHtml(div,html); 
	  
	  var  html_modal=	getData(data,'##--followup_history_modal_html--##');
	 // alert(html_modal);
      
	   // UIkit.modal('#student_followup_history_modal').show();
	  
 	   $("#student_followup_history_div_view").dialog({
                    title: 'Follow up',
                    height: 500,
                    width: 1200
					 
                }); 
 	    os.setHtml('student_followup_history_div_view',html_modal); 
 }
 
 
 function hide_show_follow_buttons(student_followup_id)
 {
    var update_button='followup_update_button_id_'+student_followup_id;
    var close_button='followup_close_button_id_'+student_followup_id;
	os.show(update_button);
	os.hide(close_button);
   
 
 }
 
 
 function update_close_followup(history_id,student_followup_id,action)
 {
  
	    var msg=' save remarks';
		if(action=='close_followup')
		{
		
		      msg=' Close followup';
		}
		
		 var p=confirm('Are you sure to '+msg);
		 if(p){   }
		 else{  return false;}
		 
	   
	    if(document.getElementById('student_followup_history_form')){
        var formdata = new FormData(os.getObj('student_followup_history_form'));
		}else{
		 var formdata = new FormData();
		}
		
		 
        formdata.append('history_id',history_id );		
		 formdata.append('action',action );
		 formdata.append('student_followup_id',student_followup_id );
		 

        formdata.append('update_close_followup','OK' );
        var url='<? echo $ajaxFilePath ?>?update_close_followup=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('update_close_followup_results',url,formdata);
     
 }
function update_close_followup_results(data)  
{

	var history_id=	getData(data,'##--historyId--##');
	manage_followup(history_id,'');

} 
	
</script>
<style>
 
</style>

<? include($site['root-wtos'].'bottom.php'); ?>

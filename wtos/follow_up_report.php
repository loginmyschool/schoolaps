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

$listHeader='Follow-up report';

$ajaxFilePath= 'follow_up_report_ajax.php';

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
		<form id="follow_up_search_form" >
		
		
		form data
			
			
		   	
         </form>
        </div>
	
	
		<div class=" text-m p-top-m" style="">
		
		 
		 
		 

            
            <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="follow_up_report('');">
                 
                Search
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
        <div class="uk-margin-small-top" id="followup_report_div_id" style="margin:20px; border:2px solid groove; "> 
		
		  result div
		
		
		</div>
</div>
    </div>
</div>



 
<script>

    function follow_up_report(action) // get record by table primery id
    {
	 
         
		var formdata = new FormData(os.getObj('follow_up_search_form'));	
		  
		
		 formdata.append('action',action );
		

        formdata.append('follow_up_report','OK' );
        var url='<? echo $ajaxFilePath ?>?follow_up_report=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('follow_up_report_results',url,formdata);

    }
	
function follow_up_report_results(data)  
{

	var followup_report_div_id_data=	getData(data,'##--followup_report_div_id_data--##');
os.setHtml('followup_report_div_id',followup_report_div_id_data);
	
	 var follow_up_search_form_data=	getData(data,'##--follow_up_search_form_data--##');
	 os.setHtml('follow_up_search_form',follow_up_search_form_data);

} 
	follow_up_report('');
	</script>
	
	<div id="student_followup_history_modal" class="uk-flex-top" uk-modal > 
    <div class="uk-modal-dialog uk-width-1-1">  <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
       <div class="">
    
			
            <div  id="student_followup_history_div_view" style="padding:10px;">
            
		   
		    </div>
			
		
        </div>
    </div>
</div>
	 
<style>
 
</style>

<? include($site['root-wtos'].'bottom.php'); ?>

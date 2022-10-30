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

$ajaxFilePath= 'student_fees_report_ajax.php';

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
            class="select2">
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
		<select name="fees_type_s" id="fees_type_s"
             >
            <option value="">All type fees</option>
            <? $os->onlyOption($fees_type_array,'');	?>
        </select>
		
		 </div>
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="" > From 
		  <select name="from_month_s" id="from_month_s"
            class="select2" style="width:100px;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesMonth,date('m'));	?>
        </select>
		 <select name="from_year_s" id="from_year_s"
            class="select2" style="width:70px;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesYear,date('Y'));	?>
        </select>
		
		 </div>
		  <div class="uk-inline uk-margin-small-left" uk-tooltip=""> To 
		  <select name="to_month_s" id="to_month_s"
            class="select2" style="width:100px;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesMonth,date('m'));	?>
        </select>
		 <select name="to_year_s" id="to_year_s"
            class="select2" style="width:70px;">
            <option value=""> </option>
            <? $os->onlyOption($os->feesYear,date('Y'));	?>
        </select>
		
		 </div>
		 
		 
		 
		 
		 
		 

            
            <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="monthly_fees_report('');">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
              <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="printById('print_div_area');">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Print
            </button>
			 <button style="display:none;" class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="monthly_fees_report('ok');">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Tally
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

    function monthly_fees_report(tally) // get record by table primery id
    {
	 
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
		
		
		formdata.append('tally',tally );
		

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

<? include($site['root-wtos'].'bottom.php'); ?>

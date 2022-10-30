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

$listHeader='Student Fees Payment';

$ajaxFilePath= 'historyAjax.php';
$ajaxFilePath_self= 'student_fees_payment_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 /*$_ACCESS_NAME = "Student Register";
 $br_access = $os->get_secondary_access_by_branch_and_menu($br_code,$_ACCESS_NAME);
$Fees_Config_access = in_array("Fees Config", $br_access);
					$Collect_Fees_access = in_array("Collect Fees", $br_access);
					$Edit_Student_access = in_array("Edit Student", $br_access);
					$RFID_Register_access = in_array("RFID Register", $br_access);*/



?>

<div class="title-bar border-color-grey" >
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle" style="display:none"  >
            <div class="uk-inline uk-margin-small-right">
                <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button " uk-toggle="target: #add-form-modal">
                    <span uk-icon="icon:  cloud-download; ratio:0.7" class="m-right-s"></span>
                    Add New
                </button>
            </div>
            <div class="uk-inline">
                <span class="uk-form-icon  uk-background-muted p-left-m p-right-m" style="width: auto; top: 1px; left: 1px; height: calc(100% - 2px)">SESSION</span>

            </div>
        </div>
    </div>

</div>

<div class="content">
    <div class="item">

        <div class=" text-m p-top-m" style="">

            <div class="uk-inline uk-margin-small-left" uk-tooltip="Registration no or RFID">

                Reg. No. <input type="text" name="registration_no" id="registration_no" onchange="student_fees_collect_byregno('search','');" />

            </div>


            <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="student_fees_collect_byregno('search','');">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded  uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
                <!-- Session:<select name="asession" id="asession_s__bakup" class="textbox fWidth" ><option value=""></option><? //  $os->onlyOption($os->asession,$setFeesSession);?></select>	-->
            </button>

            <div class="uk-float-right uk-margin-small-right">

            </div>

        </div>
        <div class="uk-padding-small" id="WT_feesListDiv">


                <div id="info_div" > </div>

                    <form  id="student_fees_collect_form">
                        <div  id="student_fees_collect_div">
                        </div>
                    </form>

        </div>
    </div>
</div>



<!-- This is feees collect   modal -->

<script type="text/javascript">


    function student_fees_collect_byregno(history_id,action)
    {

        var formdata = new FormData(os.getObj('student_fees_collect_form'));
        formdata.append('history_id',history_id);

        formdata.append('action',action);
        var registerNo= os.getVal('registration_no');
        formdata.append('registerNo',registerNo);


        var url='<? echo $ajaxFilePath_self; ?>?student_fees_collect_byregno=OK&';
        //alert(url);
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage">  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('student_fees_collect_byregno_result',url,formdata);
        //  UIkit.modal('#student_fees_collect_modal').show();

    }
    function student_fees_collect_byregno_result(data)
    {

        var t=data.split('##-##historyId##-##');
        var historyId= t[1];
        //alert(historyId);
        var t=data.split('##-##info##-##');
        var info= t[1];
        os.setHtml('info_div',info);
        //alert(info);
        student_fees_collect(historyId,'');
    }

    function student_fees_collect(history_id,action)
    {

        var formdata = new FormData(os.getObj('student_fees_collect_form'));
        formdata.append('history_id',history_id);

        if(action=='generate_receipt')
        {
          
		  if(os.check.empty('paid_fees_amount','Please enter paid amount')==false){ return false;}
		  
		  var p=confirm('Confirm generate receipt and bill ?');
          if(!p)
          {
            return false;
          }else{

           /* var g=confirm('You will not be able to edit bill.');
                if(!g)
                {
                return false;
                }
*/
          }

        } 

        formdata.append('action',action);




        var url='<? echo $ajaxFilePath ?>?student_fees_collect=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
       // os.setAjaxHtml('student_fees_collect_div',url,formdata);
	   os.setAjaxFunc('student_fees_collect_result',url,formdata);
        //  UIkit.modal('#student_fees_collect_modal').show();

     

 
 }
 function student_fees_collect_result(data)
 {
 
  var feeshtml=getData(data,'##-feeshtml-##');
  os.setHtml('student_fees_collect_div',feeshtml);
  
  var fees_payment_id=getData(data,'##-fees_payment_id-##');
   
 if(fees_payment_id!='')
   {
        print_receipt_fees(fees_payment_id,'ok')
   }
 }
 function searchReset()
 {
  location.reload();
 }
</script>
 <style>
 .uk-table-small{ color:#494949; font-size:14px; }
  .uk-table-small td{ padding:5px 5px;}
  .table_input_payment  td{ padding:4px 4px;}
 </style>
<!----------- -->
<?php  include($site['root-wtos'].'holidaysDataView_Helper.php'); ?>
<? include($site['root-wtos'].'bottom.php'); ?>

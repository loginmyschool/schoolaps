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

$listHeader='Fees Setting';

$ajaxFilePath= 'fees_setting_ajax.php';

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
// branch access-- end
  ?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle" style="display:none;">
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
		
		
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="Class">
		<select name="branch_code_s" id="branch_code_s"
            class="select2">
            <option value="">All Branch</option>
            <? $os->onlyOption($branch_code_arr,'');	?>
        </select>
		
		 </div>
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="Class">
		 <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        class="uk-select uk-border-rounded uk-form-small  p-right-xl text-m" >
                    <option value=""> </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select>
		
		 </div>
		 
		 

            <div class="uk-inline uk-margin-small-left" uk-tooltip="Class">
                <span class="uk-form-icon" uk-icon="icon: user; ratio:0.7"></span>
                <select name="classList" id="classList_s" class="uk-select uk-border-rounded uk-form-small p-left-xxxl">
                    <option value="">Class</option>
                    <? $os->onlyOption($os->classList,'');	?>
                </select>
            </div>
            <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="manage_fess_setting('search');">
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
        <div class="uk-margin-small-top" id="WT_feesListDiv"></div>

    </div>
</div>



<div id="add-form-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body ">
        <div class="uk-grid uk-grid-small uk-child-width-1-3 uk-grid-divider" uk-grid>

            <div>
                <h5 class="color-primary uk-margin-small">Class</h5>
                <div>
                    <? foreach($os->classList as $class_id=>$val){?>
                        <div class="m-bottom-s">
                            <label class="uk-width-expand">
                                <input class="uk-checkbox" type="checkbox" name="classList[]" value="<? echo $class_id ?>" /> <? echo $val ?>
                            </label>
                        </div>
                    <? } ?>
                </div>
            </div>

            <div>
                <h5 class="color-primary uk-margin-small">Fees Type</h5>
                <div>
                    <? foreach($os->fees_type as $val){?>
                        <div class="m-bottom-s">
                            <label class="uk-width-expand">
                                <input class="uk-checkbox" type="checkbox" name="fees_type[]" value="<? echo $val ?> " /> <? echo $val ?>
                            </label>
                        </div>
                    <? } ?>
                </div>
            </div>

            <div>
                <h5 class="color-primary uk-margin-small">Student Type</h5>
                <div>
                    <? foreach($os->student_type as $val){?>
                        <div class="m-bottom-s">
                            <label class="uk-width-expand">
                                <input class="uk-checkbox" type="checkbox" name="student_type[]" value="<? echo $val ?> " /> <? echo $val ?>
                            </label>
                        </div>
                     <? } ?>
                </div>


                <h5 class="color-primary uk-margin-small">Fees Head</h5>
                <div class="uk-margin-small">

                    <input class="uk-input uk-border-rounded uk-form-small" type="text" name="fees_head" id="fees_head" list="fees_head_list" />
                    <?
                    $query_fees_head_list=" select distinct(feesHead) from feesconfig";
                    $os->dataList($query_fees_head_list,'feesHead','fees_head_list'); ?>
                </div>

                <h5 class="color-primary uk-margin-small">Amount</h5>
                <div class="uk-margin-small">
                    <input type="text" name="amount" id="amount" class="uk-input uk-border-rounded uk-form-small"/>
                </div>


                <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button " name="button" type="button" onclick="manage_fess_setting('save')">SAVE</button>

            </div>
        </div>
    </div>
</div>
<script>

    function manage_fess_setting(button) // get record by table primery id
    {
	 
        var formdata = new FormData();
        var fees_type= getValuesFromCheckedBox('fees_type[]');
        var classList= getValuesFromCheckedBox('classList[]');
        var student_type= getValuesFromCheckedBox('student_type[]');


        formdata.append('fees_type',fees_type );
        formdata.append('classList',classList);
        formdata.append('student_type',student_type );



        formdata.append('button',button );

        var asession=os.getVal('asession_s');
        formdata.append('asession',asession );
		
		 var branch_code_val=os.getVal('branch_code_s');
        formdata.append('branch_code_s',branch_code_val );
		
		
		
		
		

        var classList_s=os.getVal('classList_s');
        formdata.append('classList_s',classList_s );


        var fees_head=os.getVal('fees_head');
        formdata.append('fees_head',fees_head );

        var amount=os.getVal('amount');
        formdata.append('amount',amount );

        formdata.append('fees_config','OK' );
        var url='<? echo $ajaxFilePath ?>?manage_fees_setting=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_fess_setting_results',url,formdata);

    }

    function manage_fess_setting_results(data)  // fill data form by JSON
    {

        var content_data=	getData(data,'##--FEES-SETTING-DATA--##');
        os.setHtml('WT_feesListDiv',content_data);

        //var objJSON = JSON.parse(data);
        // os.setVal('product_id',parseInt(objJSON.product_id));

        UIkit.modal("#add-form-modal").hide();



    }
	
	
	
	
	
	
	function add_fees_config(  form_id ,  classList_s  ,  student_type ,  feesType_val) // get record by table primery id
    {
        var formdata = new FormData(os.getObj(form_id));
        
  
        formdata.append('classList_s',classList_s );
		formdata.append('student_type',student_type );
		formdata.append('feesType_val',feesType_val );
		 var asession=os.getVal('asession_s');
		 formdata.append('asession',asession );
		 
		  var branch_code_val=os.getVal('branch_code_s');
        formdata.append('branch_code_s',branch_code_val );
		
        formdata.append('add_fees_config','OK' );
        var url='<? echo $ajaxFilePath ?>?add_fees_config=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('add_fees_config_results',url,formdata);

    }

    function add_fees_config_results(data)  // fill data form by JSON
    {

        
                manage_fess_setting('search');


    }
	
	function delete_fees_conf_data(feesconfigId_str)
	{
	   var formdata = new FormData();
        
	 var p=confirm('Delete fees config confirm?');
	 if(p==false)
	 {
	   return;
	 }	
  
        formdata.append('feesconfigId_str',feesconfigId_str );
		formdata.append('delete_fees_conf_data','OK' );
        var url='<? echo $ajaxFilePath ?>?delete_fees_conf_data=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('delete_fees_conf_data_results',url,formdata);
	}
	function delete_fees_conf_data_results(data)   
    {

        
          manage_fess_setting('search');


    }
	
	
	
</script>

<? include($site['root-wtos'].'bottom.php'); ?>

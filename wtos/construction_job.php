<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='Construction Jobs';

$ajaxFilePath= 'construction_job_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$department = "Construction";
$access_name = "Construction Job";
//get vars
$branch_code_s    = $os->get("branch_code_s");
$campus_location_s = $os->get("campus_location_s");
$from_date_s = $os->get("from_date_s") ;
$to_date_s = $os->get("to_date_s");
 
$branches = $os->get_branches_by_access_name($access_name);
//campus_buldings
$campus_locations = [];
$query = $os->mq("SELECT * FROM campus_location WHERE branch_code='$branch_code_s'");
while ($row = $os->mfa($query)){
    $campus_locations[$row["campus_location_id"]] = $row["campus_name"];
}

?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">

        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <form>
            <div class="uk-padding-small uk-padding-remove-bottom">
                <div class="uk-inline uk-margin-small-bottom" uk-tooltip="Select Branch">
                    <div class="bp3-input-group ">
                        <div class="bp3-select">
                            <select name="branch_code_s" class="select2" style="width:400px;" 
                                    onchange="get_campus_building_by_branch_code(this.value)"
                                    id="branch_code_s">
									<option value=""></option>
                                 
                                <? $os->onlyOption($branches, $branch_code_s)?>
                            </select>
							
							 
							
                        </div>
                    </div>
                </div>
                <div class="uk-inline uk-margin-small-bottom" uk-tooltip="Select Building">
                    <div class="bp3-input-group ">
                        <div class="bp3-select">
                            <select name="campus_location_s"
                                    id="campus_location_s">
                                <option value="">--</option>
                                <?
                                $os->onlyOption($campus_locations, $campus_location_s);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="uk-inline uk-margin-small-bottom" uk-tooltip="Select from date">
                    <div class="bp3-input-group ">
                        <span class="bp3-icon bp3-icon-calendar"></span>
                        <input type="text" class="bp3-input  datepicker"
                               placeholder="From"
                               value="<?=$from_date_s?>"
                               id="from_date_s"
                               name="from_date_s"/>

                    </div>
                </div>
                <div class="uk-inline uk-margin-small-bottom" uk-tooltip="Select to date">
                    <div class="bp3-input-group ">
                        <span class="bp3-icon bp3-icon-calendar"></span>
                        <input type="text" class="bp3-input  datepicker"
                               placeholder="From"
                               value="<?=$to_date_s?>"
                               id="to_date_s" name="to_date_s"/>

                    </div>
                </div>
                <div class="uk-inline uk-margin-small-bottom">
                    <button type="submit" class="bp3-button bp3-intent-primary"  >
                        <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                        Search
                    </button>

                    <button type="button" class="bp3-button bp3-intent-success" onclick="job_edit_form()" >
                        <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                        New Job
                    </button>
                </div>
            </div>
        </form>

        <div id="WT_fetch_job_list_DIV" class="uk-padding-small">&nbsp; </div>

    </div>
</div>

<!-----POPUPS----->
<div id="add_edit_form_dialog" style="display: none">

    <form action="<?=$ajaxFilePath."?WT_add_edit_job=OK";?>"
          method="post"
          class="uk-form-stacked" id="add_edit_form"
          enctype="multipart/form-data">
         
        <input class="bp3-input uk-hidden" type="number" name="job_id" value="0"/>
        <input class="bp3-input uk-hidden" type="text" name="department" value="<?=$department?>"/>

        <div class="bp3-form-group ">
            <label class="bp3-label" for="form-group-input">
                Title
                <span class="bp3-text-muted">(required)</span>
            </label>
            <div class="bp3-form-content"> 
                <div class="bp3-input-group ">
                    <input class="bp3-input" type="text" name="job_title" required>
                </div>
            </div>
        </div>
        <div class="bp3-form-group ">
            <label class="bp3-label" for="form-group-input">
                Start date
                <span class="bp3-text-muted">(required)</span>
            </label>
            <div class="bp3-form-content">
                <div class="bp3-input-group "> 
                    <input class="bp3-input datepicker" type="text" name="job_start_date" required>
                </div>
            </div>
        </div>

         
        <div class="bp3-form-group ">
            <label class="bp3-label" for="form-group-input">
                Manager
                <span class="bp3-text-muted">(required)</span>
            </label>
            <div class="bp3-form-content">
                <div class="bp3-input-group ">
                    <input class="bp3-input uk-width-1-1" type="text" name="manager_name" value="">
                </div>
            </div>
        </div>
        <div class="bp3-form-group ">
            <label class="bp3-label" for="form-group-input">
                Description
                <span class="bp3-text-muted">(required)</span>
            </label>
            <div class="bp3-form-content">
                <div class="bp3-input-group ">
                    <textarea class="bp3-input" name="job_note"></textarea>
                </div>
            </div>
        </div>
        <button class="bp3-button bp3-intent-success">Save</button> 
	   
		<input type="button" value="SAVE" onclick="save_job_data();" />
		<div id="job_edit_message" > </div>
    </form>
    

</div>


<script>
        function save_job_data() 
		{
			
						//event.preventDefault();
						let  formdata= new FormData(os.getObj("add_edit_form"));
						
						var branch_code_s=os.getVal("branch_code_s");
						if(branch_code_s==''){  alert('Please select Branch'); return false; }
												
						var campus_location_s=os.getVal("campus_location_s");
						if(campus_location_s==''){  alert('Please select Campus Location'); return false; }
						
						formdata.append('branch_code_s',branch_code_s );
						formdata.append('campus_location_s',campus_location_s );
						formdata.append('WT_add_edit_job','OK' );
						var url='<? echo $ajaxFilePath ?>?WT_add_edit_job=OK&';
						os.animateMe.div='div_busy';
						os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
						os.setAjaxFunc(function (data){
						 
						     os.setHtml('job_edit_message',data);
						}, url, formdata);
				 
                
         }
    </script>

<script>
    function popDialogWH(elementId,titles,W,H)
    {
        os.getObj(elementId).title=titles;
        $( function() {
            $( "#"+elementId ).dialog({
                width: W,
                height: H,
                modal: false});
        } );

    }
    function get_campus_building_by_branch_code(branch_code){
        let formdata = new FormData();

        formdata.append('branch_code_s',branch_code);
        formdata.append('get_campus_building_by_branch_code','OK' );
        let url='<? echo $ajaxFilePath ?>?get_campus_building_by_branch_code=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            $("#campus_location_s").html(data);
        }, url, formdata);
    }


    function WT_fetch_job_list(){
        let formdata = new FormData();

        formdata.append('branch_code_s',os.getVal("branch_code_s") );
        formdata.append('campus_location_s',os.getVal("campus_location_s") );
        formdata.append('from_date_s',os.getVal("from_date_s") );
        formdata.append('to_date_s',os.getVal("to_date_s") );
        formdata.append('WT_fetch_job_list','OK' );
        let url='<? echo $ajaxFilePath ?>?WT_fetch_job_list=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            $("#WT_fetch_job_list_DIV").html(data);
        }, url, formdata);
    }
	
	
 function job_edit_form()
 {	
	     
		    var branch_code_s=os.getVal("branch_code_s");
			if(branch_code_s==''){  alert('Please select Branch'); return false; }
			 
			 
			var campus_location_s=os.getVal("campus_location_s");
			if(campus_location_s==''){  alert('Please select Campus Location'); return false; }
			
			popDialogWH('add_edit_form_dialog', 'ADD OR EDIT JOB', 350,500); 
		     		
			
	
}

</script>

<!-- progress  image form   676764767-->
<div id="manage_progress_image_div" style="display: none"> </div>
<script>
function manage_progress_image(job_id,action)
{
        popDialogWH('manage_progress_image_div', 'Images', 350,500); 
		
		let formdata = new FormData();
		
		if(action=='save')
		{
			formdata = new FormData(os.getObj('manage_progress_image_form'));
			var imageVal= os.getObj('image').files[0];
		if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
		}
		
		

        formdata.append('job_id',job_id );
        formdata.append('action', action );
        
        formdata.append('manage_progress_image','OK' );
        let url='<? echo $ajaxFilePath ?>?manage_progress_image=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
		
		os.setHtml('manage_progress_image_div',data);
		
           //  $("#WT_fetch_job_list_DIV").html(data);
        }, url, formdata);


}




</script>

<!-- progress  image form end 676764767 -->
<!-- progress  document form   6767644767-->
<div id="manage_progress_document_div" style="display: none"> </div>
<script>
function manage_progress_document(job_id,action)
{
        popDialogWH('manage_progress_document_div', 'Docs', 350,500); 
		
		let formdata = new FormData();
		
		if(action=='save')
		{
			formdata = new FormData(os.getObj('manage_progress_document_form'));
			var imageVal= os.getObj('docs').files[0];
		if(imageVal){  formdata.append('docs',imageVal,imageVal.name );}
		}
		
		

        formdata.append('job_id',job_id );
        formdata.append('action', action );
        
        formdata.append('manage_progress_document','OK' );
        let url='<? echo $ajaxFilePath ?>?manage_progress_document=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
		
		os.setHtml('manage_progress_document_div',data);
		
           //  $("#WT_fetch_job_list_DIV").html(data);
        }, url, formdata);


}




</script>

<!-- progress  document form end 6767644767 -->
<!-- item entry section 787878078-->

<div id="manage_item_use_image_div" style="display: none"> 




</div>
<script>
var global_job_id=0;
function manage_item_use(job_id,action)
{

       global_job_id=job_id;
		var branch_code_s=os.getVal("branch_code_s");
		//if(branch_code_s==''){  alert('Please select Branch'); return false; }
		
		
		popDialogWH('manage_item_use_image_div', 'Images', 400,500); 
		
		let formdata = new FormData();
		
		if(action=='save')
		{
			formdata = new FormData(os.getObj('manage_item_use_form')); 
		 
		}
		
        formdata.append('branch_code_s',branch_code_s );
		
        formdata.append('job_id',job_id );
        formdata.append('action', action );
        
        formdata.append('manage_item_use','OK' );
        let url='<? echo $ajaxFilePath ?>?manage_item_use=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
		
		os.setHtml('manage_item_use_image_div',data);
		
		 
	  
					  $(document).ready(function () {
					  $('.selectize_item').selectize({
						  sortField: 'text'
					  });
				  });
		
          
        }, url, formdata); 

   
}

function manage_item_use_details(item_use_id)
{
			let formdata = new FormData(os.getObj('manage_item_use_details_form_'+item_use_id)); 
			formdata.append('item_use_id',item_use_id );
			formdata.append('manage_item_use_details','OK' );
			let url='<? echo $ajaxFilePath ?>?manage_item_use_details=OK&';
			os.animateMe.div='div_busy';
			os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
			
			os.setAjaxFunc(function (data)
			{
			   
			   // os.setHtml('viewdata',data);
			   manage_item_use(global_job_id,'');
			   alert(data);
			
			}, url, formdata); 

   

}


</script>
<style>
.table_123 td{ padding:2px;}
</style>

<!-- item entry section end  787878078-->

<script>
$(document).ready(function () {
					 /* $('#branch_code_s').selectize({
						  sortField: 'text'
					  });*/
				  });

WT_fetch_job_list();
</script>

<? include($site['root-wtos'].'bottom.php'); ?>

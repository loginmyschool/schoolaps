<?
/*
   # wtos version : 1.1
   # main ajax process page : campus_buildingAjax.php
   #
*/
include('wtosConfigLocal.php');
global $site, $os;
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Canteen Purchase';
$ajaxFilePath= $site["url-wtos"].'Item_to_account_head_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$department = "Canteen";
$branches = $os->get_branches_by_access_name("Canteen Purchase Entry");
?>



<div class="content without-header with-both-side-bar uk-overflow-hidden uk-height-1-1">
    <!-----------
    Main contents
    --------------->

    <div class="item with-header medium-sidebar background-color-white"  id="left_container" style="max-width: 900px">
        <div class="item-header p-m uk-box-shadow-small">

            <select name="branch_code"
                    id="branch_code_s" onchange="item_list_data();"
                     
                    class="uk-select congested-form uk-border-rounded uk-margin-small-bottom">
                <option value="" selected>--</option>
                <? $os->onlyOption($branches, $os->val($purchase,"branch_code"))?>
            </select>

             
       
      <input type="text" id="searchKey" /> <input type="button" onclick="item_list_data();"  value="Search" />

             
        </div>
        <div id="WT_fetch_purchase_list_DIV" class="item-content uk-overflow-auto">  
		 
		      <div id="item_list_div"  style="width:700px;">
			  
			  
			  
			  </div>		
		       
		
		
		
		 </div>
    </div>
     
	 
	 <div class="item with-header  background-color-white">
        <div class="item-header p-m uk-box-shadow-small">

                       
       
      <input type="text" id="account_head_searchKey"  /> <input type="button" onclick="show_account_head();"  value="Search" />

             
        </div>
        <div id="WT_fetch_purchase_list_DIV" class="item-content uk-overflow-auto">  
		 
		      <div id="account_head_list_div" style="padding:10px;">
			  
			  Please Selecet item.
			  
			  </div>		
		       
		
		
		
		 </div>
    </div>
</div>
<script>

 function item_list_data(){
        let formdata = new FormData();

		let branch_code_s= os.getVal('branch_code_s');
		formdata.append('branch_code_s',branch_code_s );
		if(branch_code_s==''){  alert('Please select Branch'); return false; }
		
		var search_key= os.getVal('searchKey');
		formdata.append('searchKey',search_key );
        
        formdata.append('item_list_data','OK' );
        let url='<? echo $ajaxFilePath ?>?item_list_data=OK&';

        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc(function (data){
		
		os.setHtml('item_list_div',data);
       }, url, formdata);
    }

var item_id_global=0;
function show_account_head(item_id)	{
        
		if(item_id>0)
		{
		   item_id_global=item_id;
        }else
		{
		   item_id=item_id_global;
		
		}
		 if(item_id=='')
		 {
		   alert('Please select Item'); return false;
		 }
		
		 let formdata = new FormData();
		
		  var branch_code_s= os.getVal('branch_code_s');
		 
		 if(branch_code_s==''){  alert('Please select Branch'); return false; }
		 formdata.append('branch_code_s',branch_code_s );
		
		var account_head_searchKey= os.getVal('account_head_searchKey');
		formdata.append('account_head_searchKey',account_head_searchKey );
		
		formdata.append('item_id',item_id );
        
        formdata.append('show_account_head','OK' );
        let url='<? echo $ajaxFilePath ?>?show_account_head=OK&';

        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc(function (data){
		
		os.setHtml('account_head_list_div',data);
       }, url, formdata);
    }
	

function set_item_to_account_head(item_id,account_head_id,branch_code)
{

        
		 
		 let formdata = new FormData();
		
		formdata.append('item_id',item_id );
		formdata.append('account_head_id',account_head_id );		
		formdata.append('branch_code',branch_code );
		
		var check_box=os.getObj('account_head_id_'+account_head_id)
		var check_box_checked='no';
		if(check_box.checked)
		{
		  check_box_checked='yes';
		}
		formdata.append('check_box_checked',check_box_checked );
        
        formdata.append('set_item_to_account_head','OK' );
        let url='<? echo $ajaxFilePath ?>?set_item_to_account_head=OK&';

        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc(function (data){
		alert(data);
		item_list_data();
		//os.setHtml('account_head_list_div',data);
       }, url, formdata);
    

}	
	
	
//item_list_data();
</script>

 
<style>
    @media(max-width: 640px) {
        #left_container, #WT_fetch_purchase_details_DIV{
            display: none;
        }
        #left_container:target, #WT_fetch_purchase_details_DIV:target {
            display: block;
        }
    }
</style>
 
<style>
    .purchase_row.active{
        background-color: rgba(0,255,0, 0.14);
    }
</style>



<? include($site['root-wtos'].'bottom.php'); ?>

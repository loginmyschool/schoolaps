<?

/*

   # wtos version : 1.1

   # main ajax process page : book_issue

   #  

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');
global $site;
?><?

$listHeader='Book issue  ';
$ajaxFilePath= 'book_issue_ajax.php';
//$pluginName='';
//$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>

<div class="title-bar">
    <h3 class="background-color-white"><?php  echo $listHeader; ?></h3>
</div>
<div class="content">
<div  class="item">
        <div class="p-m">
            <div>
              
			  
			  
 
			  <div  >
		
		
		<input type="text" id="search_book_key" onkeyup="book_search_ajax(event,'')" /> 
		 
		  <input type="hidden" value=" + " onclick="quantity_be_added_modify('+1')" /> 
		
		<input type="hidden" id="quantity_be_added" value="1" style="width:50px;" />  <input type="hidden" value=" - "  onclick="quantity_be_added_modify('-1')"/> 
		
		<div id="book_search_data_form_div">
		         <h1 style="color:#B2B2B2"> BOOK NAME  </h1>
	             <img src="<? echo $site['url-wtos'] ?>/images/dummy_book.jpg" id="image_searched_book" style="height:300px; widows:200px;"/>
				 <input type="hidden" name="searched_booked_id" id="searched_booked_id" />
		</div>
		
			<div id="book_search_data_list_div">
			    
			
			</div>
		</div>
            </div>


             
        </div>
    </div>
    <div class="item with-footer" >
        <div class="item-content p-m">
                    
					 
					
					<select id="issue_type" style="display:block" onchange="set_issue_type('')"> <option value="member"> Member Account</option> <option value="missing"> Missing Account</option> </select>
					<input type="text" id="member_table_id" value="" onkeyup="book_issue_ajax('');"/>
					<input type="hidden" id="member_table" value="" />
					<input type="hidden" id="return_to_list_book_id" value="" />
					
					<div id="book_issue_data_json" style="display:none;"> </div>
					<div id="book_issue_data_list_div">Data list
					</div>
					
					
					<div id="book_issue_data_form_div">Data form 
					</div>
		
        </div>
        <div class="item-footer">
            <div style="display: flex; justify-content: center; align-items: center; height: 100%">
                <? if($os->access('wtDelete')){ ?>
                    <button class="material-button dense error" type="button" value="Delete" onclick="WT_teacherDeleteRowById('');">Print Slip</button>
                <? } ?>
                &nbsp; <button class="material-button dense warn"  type="button" value="New" onclick="javascript:window.location='';">New</button>
                &nbsp;<? if($os->access('wtEdit')){ ?>
                    <button class="material-button dense success" type="button" value="Save" onclick="save_data();" >Save</button>
                <? } ?>
            </div>
        </div>
    </div>

    
	
	
	<div  class="item">
        <div class="p-m">
            <div id="issue_register_data_list_div">
              
            </div>

        </div>
    </div>

</div>



 

			
<script>
	 	 
function book_issue_ajax(wt_action) 
{
	var formdata = new FormData();
	    
	//var 0000000= getValuesFromCheckedBox('000000');
	//formdata.append('00000000',0000000 );	 
	
	 

	    
	 var searched_booked_id_val=os.getVal('searched_booked_id');
	 formdata.append('searched_booked_id',searched_booked_id_val );
	 var quantity_be_added_val=os.getVal('quantity_be_added');
	 formdata.append('quantity_be_added',quantity_be_added_val ); 
	 
	  var member_table_id_val=os.getVal('member_table_id');
	 formdata.append('member_table_id',member_table_id_val ); 
	   var member_table_val=os.getVal('member_table');
	 formdata.append('member_table',member_table_val ); 
	 
	 var return_to_list_book_id=os.getVal('return_to_list_book_id');
	 formdata.append('return_to_list_book_id',return_to_list_book_id ); 
	 var issue_type_val=os.getVal('issue_type');
	 formdata.append('issue_type',issue_type_val ); 
	
	
	
	formdata.append('book_issue_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?book_issue_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('book_issue_result',url,formdata);
	 			
}

function book_issue_result(data)
{
    
   var content_data=	getData(data,'##--book_issue_data_form--##');
   os.setHtml('book_issue_data_form_div',content_data);
   var content_data=	getData(data,'##--book_issue_data_list--##');
   os.setHtml('book_issue_data_list_div',content_data);
   
   
   
    var book_issue_data_json=	getData(data,'##--book_issue_data_json--##');
   os.setHtml('book_issue_data_json',book_issue_data_json);
   
   
   
   
}

function book_search_ajax(e,wt_action) 
{

      if(e.keyCode === 13){
            e.preventDefault(); // Ensure it is only this code that rusn

              book_issue_ajax('add_to_list')
			  return;
        }


	var formdata = new FormData();
	    
	//var 0000000= getValuesFromCheckedBox('000000');
	//formdata.append('00000000',0000000 );	 
	    
	var search_book_key_val=os.getVal('search_book_key');	 
	formdata.append('search_book_key',search_book_key_val ); 
	
	
	formdata.append('book_search_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?book_search_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('book_search_result',url,formdata);
	 			
}

function book_search_result(data)
{
    
   var content_data=	getData(data,'##--book_search_data_form--##');
   os.setHtml('book_search_data_form_div',content_data);
   var content_data=	getData(data,'##--book_search_data_list--##');
   os.setHtml('book_search_data_list_div',content_data);
   
}

function quantity_be_added_modify(op)
{

		var quantity_be_added_val=parseInt(os.getVal('quantity_be_added'));
		if(op=='+1')
		{
		quantity_be_added_val=quantity_be_added_val+1;
		
		}
		
		if(op=='-1')
		{
		quantity_be_added_val=quantity_be_added_val-1;
		
		}
		
		if(quantity_be_added_val<1) { quantity_be_added_val=1;}
		
		  os.setVal('quantity_be_added',quantity_be_added_val);
}


function issue_register_ajax(wt_action) 
{
	var formdata = new FormData();
	    
	//var 0000000= getValuesFromCheckedBox('000000');
	//formdata.append('00000000',0000000 );	 
	    
	//var 0000000=os.getVal('0000000');	 
	//formdata.append('0000000',0000000 ); 
	
	
	formdata.append('issue_register_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?issue_register_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('issue_register_result',url,formdata);
	 			
}

function issue_register_result(data)
{
    
  // var content_data=	getData(data,'##--issue_register_data_form--##');
 //  os.setHtml('issue_register_data_form_div',content_data);
   var content_data=	getData(data,'##--issue_register_data_list--##');
   os.setHtml('issue_register_data_list_div',content_data);
   
}

issue_register_ajax(''); 

function save_data()
{
   issue_register_ajax('');
   os.setVal('member_table_id','');
   os.setHtml('book_issue_data_list_div','');
 
}


function check_return(book_id)
{
  //alert(book_id);  
  
  var p= confirm('Are you sure');
  
  if(p)
  {
  os.setVal('return_to_list_book_id',book_id);
     book_issue_ajax('return_to_list');
  
  }
 
}

function set_issue_type(s)
{
 var issue_type_val = os.getVal('issue_type');
 os.setVal('member_table_id','');
  if(issue_type_val=='missing')
 {
  os.setVal('member_table_id','Missing');
 }

book_issue_ajax('') ;
}
 
 
//book_issue_ajax('') ;
</script>
<style>
.left_panel_div{ width:600px; float:left; margin:2px; padding:5px; border:1px thin #CCCCCC;}
.right_panel_div{ width:700px; float:left; margin:2px; padding:5px; border:1px thin #CCCCCC;}
.backgroundred{ background-color:#999999;}
</style>
<? include($site['root-wtos'].'bottom.php'); ?>
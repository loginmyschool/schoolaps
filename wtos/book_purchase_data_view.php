<?

/*

   # wtos version : 1.1

   # main ajax process page : book_purchase

   #  

*/



include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');
global $site;
?><?

$listHeader='Book Purchase entry';
$ajaxFilePath= 'book_purchase_ajax.php';
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
              <div id="book_entry_data_form_div">
		
		
		<input type="text" id="search_book_key" onkeyup="book_search_ajax(event,'')" />  <a href="javascript:void(0)" onclick="load_newform()" >Add New Book</a>
		<br />
		Qunatity to be added <input type="button" value=" + " onclick="quantity_be_added_modify('+1')" /> 
		
		<input type="text" id="quantity_be_added" value="1" style="width:50px;" />  <input type="button" value=" - "  onclick="quantity_be_added_modify('-1')"/> 
		
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

					<input type="hidden" id="book_purchase_id" value="" style="display:none;"  />
					
					<div id="book_purchase_data_json" style="display:none;"> </div>
					<div id="book_purchase_data_list_div">Data list
					</div>
					
					
					<div id="book_purchase_data_form_div">Data form 
					</div>
		
        </div>
        <div class="item-footer">
            <div style="display: flex; justify-content: center; align-items: center; height: 100%">
                <? if($os->access('wtDelete')){ ?>
                    <button class="material-button dense error" type="button" value="Delete" onclick="WT_teacherDeleteRowById('');">Delete</button>
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
            <div id="purchase_register_data_list_div">
              
            </div>

        </div>
    </div>

</div>



 

			
<script>
	 	 
function book_purchase_ajax(wt_action) 
{
	var formdata = new FormData();
	    
	//var 0000000= getValuesFromCheckedBox('000000');
	//formdata.append('00000000',0000000 );	 
	    
	 var searched_booked_id_val=os.getVal('searched_booked_id');
	 formdata.append('searched_booked_id',searched_booked_id_val );
	 var quantity_be_added_val=os.getVal('quantity_be_added');
	 formdata.append('quantity_be_added',quantity_be_added_val ); 
	 
	  var book_purchase_id_val=os.getVal('book_purchase_id');
	 formdata.append('book_purchase_id',book_purchase_id_val ); 
	   
	 
	
	formdata.append('book_purchase_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?book_purchase_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('book_purchase_result',url,formdata);
	 			
}

function book_purchase_result(data)
{
    
   var content_data=	getData(data,'##--book_purchase_data_form--##');
   os.setHtml('book_purchase_data_form_div',content_data);
   var content_data=	getData(data,'##--book_purchase_data_list--##');
   os.setHtml('book_purchase_data_list_div',content_data);
   
   var book_purchase_id_val=	getData(data,'##--book_purchase_id--##');
   os.setVal('book_purchase_id',book_purchase_id_val);
    
   
    var book_purchase_data_json=	getData(data,'##--book_purchase_data_json--##');
   os.setHtml('book_purchase_data_json',book_purchase_data_json);
   
   
   
   
}

function book_search_ajax(e,wt_action) 
{

      if(e.keyCode === 13){
            e.preventDefault(); // Ensure it is only this code that rusn

              book_purchase_ajax('add_to_list')
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


function purchase_register_ajax(wt_action) 
{
	var formdata = new FormData();
	    
	//var 0000000= getValuesFromCheckedBox('000000');
	//formdata.append('00000000',0000000 );	 
	    
	//var 0000000=os.getVal('0000000');	 
	//formdata.append('0000000',0000000 ); 
	
	
	formdata.append('purchase_register_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?purchase_register_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('purchase_register_result',url,formdata);
	 			
}

function purchase_register_result(data)
{
    
  // var content_data=	getData(data,'##--purchase_register_data_form--##');
 //  os.setHtml('purchase_register_data_form_div',content_data);
   var content_data=	getData(data,'##--purchase_register_data_list--##');
   os.setHtml('purchase_register_data_list_div',content_data);
   
}

purchase_register_ajax(''); 

function save_data()
{
   purchase_register_ajax('');
   os.setVal('book_purchase_id','');
   os.setHtml('book_purchase_data_list_div','');
 
}

function load_newform()
 {
   var URLStr='<? echo $site['url-wtos'] ;?>bookDataView.php';
   //alert( URLStr);
	popUpWindow(URLStr, 10, 10, 1200, 600);
 }



 
//book_purchase_ajax('') ;
</script>
<style>
.left_panel_div{ width:600px; float:left; margin:2px; padding:5px; border:1px thin #CCCCCC;}
.right_panel_div{ width:700px; float:left; margin:2px; padding:5px; border:1px thin #CCCCCC;}
</style>
<? include($site['root-wtos'].'bottom.php'); ?>
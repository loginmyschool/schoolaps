<?
/*
   # wtos version : 1.1
   #  

*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

$listHeader='BOOK SELF MANAGE';
$ajaxFilePath= 'book_shelf_ajax.php';
//$pluginName='';
//$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?> 

<div class="title-bar">
    <h3 class="background-color-white"><?php  echo $listHeader; ?></h3>
</div>
<div class="content">
    <div class="item with-footer" >
        <div class="item-content p-m">	
		
		<div style="width:150px;">
			building_name <input type="text" id="building_name"  /> <br />
			floor_name <input type="text" id="floor_name"  /> <br />
			room <input type="text" id="room"  /> <br />
			type <input type="text" id="type"  /> [ drawer,shelf ] <br />    
			
			place <input type="text" id="place"  /> <br />
		   
		   
		   
			  sub_place <input type="text" name="sub_place[]"  /> <br />
			  sub_place <input type="text" name="sub_place[]"  /> <br />
			  sub_place <input type="text" name="sub_place[]"  /> <br />
			  sub_place <input type="text" name="sub_place[]"  /> <br />
			  sub_place <input type="text" name="sub_place[]"  /> <br />
			  sub_place <input type="text" name="sub_place[]"  /> <br />
			  sub_place <input type="text" name="sub_place[]"  /> <br />
		</div>
		<div id="book_shelf_data_form_div"> ------------
		</div>

            <!-----------123-->
        </div>
        <div class="item-footer">
            <div style="display: flex; justify-content: center; align-items: center; height: 100%">
                <? if($os->access('wtDelete')){ ?>
                    <button class="material-button dense error" type="button" value="Delete" onclick="WT_teacherDeleteRowById('');">Delete</button>
                <? } ?>
                &nbsp; <button class="material-button dense warn"  type="button" value="New" onclick="javascript:window.location='';">New</button>
                &nbsp;<? if($os->access('wtEdit')){ ?>
                    <button class="material-button dense success" type="button" value="Save" onclick="book_shelf_ajax('save')" >Save</button>
                <? } ?>
            </div>
        </div>
    </div>

    <div  class="item">
        <div class="p-m" style="background-color:#FFFFFF">
          <!-----------123-->

			<div id="book_shelf_data_list_div">
				Data list
			</div>
			
			<div id="book_list_data_list_div">	
			 
				
				BOOK LIST
 				 
			</div>
             
        </div>
    </div>

</div>
 
<script>
	 	 
function book_shelf_ajax(wt_action) 
{
	
	
	var formdata = new FormData();
	
	
		//book_shelf_id 	building_name 	floor_name 	room 	place 	sub_place 	type drawer,shelf 	addedDate 	addedBy 	modifyDate 	modifyBy 
		
		
		 
	    
	//var 0000000= getValuesFromCheckedBox('000000');
	//formdata.append('00000000',0000000 );	 
	    
	var building_name_val=os.getVal('building_name');	 
	formdata.append('building_name',building_name_val ); 
	
	var floor_name_val=os.getVal('floor_name');	 
	formdata.append('floor_name',floor_name_val ); 
	
	var type_val=os.getVal('type');	 
	formdata.append('type',type_val ); 
	
	var room_val=os.getVal('room');	 
	formdata.append('room',room_val ); 
	
	
	var place_val=os.getVal('place');	 
	formdata.append('place',place_val ); 
	
	var sub_place_val=getValuesFromTextBoxArray('sub_place[]');	 
	formdata.append('sub_place',sub_place_val ); 
	
	
	formdata.append('book_shelf_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?book_shelf_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('book_shelf_result',url,formdata);
	 			
}

function book_shelf_result(data)
{
    
   var content_data=	getData(data,'##--book_shelf_data_form--##');
   os.setHtml('book_shelf_data_form_div',content_data);
   var content_data=	getData(data,'##--book_shelf_data_list--##');
   os.setHtml('book_shelf_data_list_div',content_data);
   
}


function book_location_assign(book_shelf_id,wt_action)
{
      
    var formdata = new FormData();

	var place_val=os.getVal('place');	 
	formdata.append('place',place_val ); 
	
	if(wt_action=='assign_book')
	{
				var book_count_str=getValuesFromTextBoxArray_noblankcheck('book_count[]');	 
				formdata.append('book_count_str',book_count_str ); 
				var book_id_list_str= getValuesFromTextBoxArray_noblankcheck('book_id[]');
				formdata.append('book_id_list_str',book_id_list_str );
				
				
	}else
	{
	popDialog('book_list_data_list_div','bOOK LIST TO ASSIGN');
	
	}		
	formdata.append('book_shelf_id',book_shelf_id );
	formdata.append('book_location_assign','OK' );
	
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?book_location_assign=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('book_location_assign_result',url,formdata);


}
function book_location_assign_result(data)
{
 
   var content_data=	getData(data,'##--book_list_data_list--##');
   os.setHtml('book_list_data_list_div',content_data);
   book_shelf_ajax('') ;
}

function getValuesFromTextBoxArray_noblankcheck(name)
    {
        var  selected_item ='';
        var x = document.getElementsByName(name);

        var i;
        for (i = 0; i < x.length; i++) {


             

                selected_item = selected_item +x[i].value +',';

             
        }

        return selected_item;
    }
book_shelf_ajax('') ;
</script>
<style>
.sub_place{  float: left; padding:10px;  border:0px solid #0066FF;   height:125px; width:502px;background:url(<? echo $site['url-wtos'] ?>images/shelves.jpg);background-size: contain; vertical-align:bottom;}
.book_png{ background:url(<? echo $site['url-wtos'] ?>images/book.png); background-size: contain;height:30px; width:115px; float:left; }
.addbook{ font-size:24px; font-weight:bold; color:#009933; cursor:pointer;}
.book_png h5{ padding:3px 0px 0px 6px ; color:#030681; font-size:14px; font-weight:bold; cursor:pointer; }
.details_book{ position:relative; display:none; background-color:#FFFF99; height:150px; width:100px;}
.book_png:hover .details_book{  display:block; }
.book_png h5:hover{ color:#FF0000;}
 
</style>
<style>
	.building_name{ background-color:#CEE3FB; color:#000099; font-size:18px; font-weight:bold;}
	.floor_name{ background-color:#CEE3FB; color:#000099; font-size:16px; font-weight:bold;}
	.room_name{ background-color:#CEE3FB; color:#000099; font-size:14px; font-weight:bold;}
	.rack_name{ padding:10px; margin:20px;color:#000099; font-size:16px; font-weight:bold; background-color:#FFFFFF;}
	.shelf_name{   color:#000099; font-size:11px; font-weight:bold;}
	.removeRow_class{ color:#FF0000; font-size:16px; font-weight:bold;}
	 
	</style>
 
<? include($site['root-wtos'].'bottom.php'); ?>
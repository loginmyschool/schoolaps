<?
/*
   # wtos version : 1.1
   # main ajax process page : bookAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='List book';
$ajaxFilePath= 'bookAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
  

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_bookDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_bookEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Code </td>
										<td><input value="" type="text" name="code" id="code" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Image </td>
										<td>
										
										<img id="imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Author </td>
										<td><input value="" type="text" name="author" id="author" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>ISBN </td>
										<td><input value="" type="text" name="ISBN" id="ISBN" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Publisher </td>
										<td><input value="" type="text" name="publisher" id="publisher" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Edition </td>
										<td><input value="" type="text" name="edition" id="edition" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Edition_date </td>
										<td><input value="" type="text" name="edition_date" id="edition_date" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Book category id </td>
										<td> <select name="book_category_id" id="book_category_id" class="textbox fWidth" ><option value="">Select Book category id</option>		  	<? 
								
										  $os->optionsHTML('','book_category_id','name','book_category');?>
							</select> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td><input value="" type="text" name="status" id="status" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="book_id" value="0" />	
	<input type="hidden"  id="WT_bookpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_bookDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_bookEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Code: <input type="text" class="wtTextClass" name="code_s" id="code_s" value="" /> &nbsp;  Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;   Author: <input type="text" class="wtTextClass" name="author_s" id="author_s" value="" /> &nbsp;  ISBN: <input type="text" class="wtTextClass" name="ISBN_s" id="ISBN_s" value="" /> &nbsp;  Publisher: <input type="text" class="wtTextClass" name="publisher_s" id="publisher_s" value="" /> &nbsp;  Edition: <input type="text" class="wtTextClass" name="edition_s" id="edition_s" value="" /> &nbsp;  Edition_date: <input type="text" class="wtTextClass" name="edition_date_s" id="edition_date_s" value="" /> &nbsp;  Book category id:
	
	
	<select name="book_category_id" id="book_category_id_s" class="textbox fWidth" ><option value="">Select Book category id</option>		  	<? 
								
										  $os->optionsHTML('','book_category_id','name','book_category');?>
							</select>
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_bookListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_bookListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_bookListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var code_sVal= os.getVal('code_s'); 
 var name_sVal= os.getVal('name_s'); 
 var author_sVal= os.getVal('author_s'); 
 var ISBN_sVal= os.getVal('ISBN_s'); 
 var publisher_sVal= os.getVal('publisher_s'); 
 var edition_sVal= os.getVal('edition_s'); 
 var edition_date_sVal= os.getVal('edition_date_s'); 
 var book_category_id_sVal= os.getVal('book_category_id_s'); 
formdata.append('code_s',code_sVal );
formdata.append('name_s',name_sVal );
formdata.append('author_s',author_sVal );
formdata.append('ISBN_s',ISBN_sVal );
formdata.append('publisher_s',publisher_sVal );
formdata.append('edition_s',edition_sVal );
formdata.append('edition_date_s',edition_date_sVal );
formdata.append('book_category_id_s',book_category_id_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_bookpagingPageno=os.getVal('WT_bookpagingPageno');
	var url='wtpage='+WT_bookpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_bookListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_bookListDiv',url,formdata);
		
}

WT_bookListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('code_s',''); 
 os.setVal('name_s',''); 
 os.setVal('author_s',''); 
 os.setVal('ISBN_s',''); 
 os.setVal('publisher_s',''); 
 os.setVal('edition_s',''); 
 os.setVal('edition_date_s',''); 
 os.setVal('book_category_id_s',''); 
	
		os.setVal('searchKey','');
		WT_bookListing();	
	
	}
	
 
function WT_bookEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var codeVal= os.getVal('code'); 
var nameVal= os.getVal('name'); 
var imageVal= os.getObj('image').files[0]; 
var authorVal= os.getVal('author'); 
var ISBNVal= os.getVal('ISBN'); 
var publisherVal= os.getVal('publisher'); 
var editionVal= os.getVal('edition'); 
var edition_dateVal= os.getVal('edition_date'); 
var book_category_idVal= os.getVal('book_category_id'); 
var statusVal= os.getVal('status'); 


 formdata.append('code',codeVal );
 formdata.append('name',nameVal );
if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
 formdata.append('author',authorVal );
 formdata.append('ISBN',ISBNVal );
 formdata.append('publisher',publisherVal );
 formdata.append('edition',editionVal );
 formdata.append('edition_date',edition_dateVal );
 formdata.append('book_category_id',book_category_idVal );
 formdata.append('status',statusVal );

	
if(os.check.empty('code','Please Add Code')==false){ return false;} 
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('author','Please Add Author')==false){ return false;} 
if(os.check.empty('ISBN','Please Add ISBN')==false){ return false;} 
if(os.check.empty('publisher','Please Add Publisher')==false){ return false;} 
if(os.check.empty('edition','Please Add Edition')==false){ return false;} 
if(os.check.empty('edition_date','Please Add Edition_date')==false){ return false;} 
if(os.check.empty('book_category_id','Please Add Book category id')==false){ return false;} 

	 var   book_id=os.getVal('book_id');
	 formdata.append('book_id',book_id );
  	var url='<? echo $ajaxFilePath ?>?WT_bookEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_bookReLoadList',url,formdata);

}	

function WT_bookReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var book_id=parseInt(d[0]);
	if(d[0]!='Error' && book_id>0)
	{
	  os.setVal('book_id',book_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_bookListing();
}

function WT_bookGetById(book_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('book_id',book_id );
	var url='<? echo $ajaxFilePath ?>?WT_bookGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_bookFillData',url,formdata);
				
}

function WT_bookFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('book_id',parseInt(objJSON.book_id));
	
 os.setVal('code',objJSON.code); 
 os.setVal('name',objJSON.name); 
 os.setImg('imagePreview',objJSON.image); 
 os.setVal('author',objJSON.author); 
 os.setVal('ISBN',objJSON.ISBN); 
 os.setVal('publisher',objJSON.publisher); 
 os.setVal('edition',objJSON.edition); 
 os.setVal('edition_date',objJSON.edition_date); 
 os.setVal('book_category_id',objJSON.book_category_id); 
 os.setVal('status',objJSON.status); 

  
}

function WT_bookDeleteRowById(book_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(book_id)<1 || book_id==''){  
	var  book_id =os.getVal('book_id');
	}
	
	if(parseInt(book_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('book_id',book_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_bookDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_bookDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_bookDeleteRowByIdResults(data)
{
	alert(data);
	WT_bookListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_bookpagingPageno',parseInt(pageNo));
	WT_bookListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>
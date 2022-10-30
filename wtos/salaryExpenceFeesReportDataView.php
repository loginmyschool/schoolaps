<?
/*
   # wtos version : 1.1
   # main ajax process page : rbpBillReportAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Report';
$ajaxFilePath= 'salaryExpencefeesReportAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
  

 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr >
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm" style="display:none">
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	
   
	Year:  <select name="yearSearch" id="yearSearch_s" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->yearSearch,'2018');	?></select>	
	 
  <div style="display:none" id="advanceSearchDiv">

  Search Key  
  <input type="text" id="searchKey" />   &nbsp;
  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_searchListing();" style="cursor:pointer;"/>

          
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbpbillListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_searchListing() // list table searched data get 
{
var formdata = new FormData();
var yearSearch_sVal= os.getVal('yearSearch_s'); 

formdata.append('yearSearch_s',yearSearch_sVal );

var url='<? echo $ajaxFilePath ?>?WT_searchListing=OK&'+url;


os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
os.setAjaxHtml('WT_rbpbillListDiv',url,formdata);
		
}

WT_searchListing();



	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>
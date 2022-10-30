<?
include('wtosConfigLocal.php');
 
include($site['root-wtos'].'top.php');
include('routin_settings/routin_config.php');

$pluginName='';
$listHeader='Subscription Structure Entry';
$ajaxFilePath= 'routin_periodAjax.php';
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
					
					<td valign="top" class="ajaxViewMainTableTDList">
						<div class="ajaxViewMainTableTDListSearch">
						
						
						 
						
						 
						
						
						
						
						
						</div>
						<div  class="ajaxViewMainTableTDListData" id="class_room_area_id">&nbsp;
						
						 
						 </div>
					&nbsp;</td>
				</tr>
			</table>			
			 

			<button uk-toggle="target: #routin-my-id" type="button">sss</button>

<!-- This is the modal -->
<div id="routin-my-id" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title"> sssss ss</h2>
		asasasas
        <button class="uk-modal-close" type="button"></button>
    </div>
</div>
			
			<!--   ggggggggggggggg  -->
			
		</td>
	</tr>
</table>

<style>
.classroom_daily{ height:50px; width:150px; border:1px solid #0099FF; float:left; margin:5px;}
</style>

 <script>
						function manage_number_of_class(day,perod)
						{
								 
								
								var formdata = new FormData();
								var fld_val_id=day+'_no_of_class_'+perod;
								var fld_val = os.getVal(fld_val_id);
								
								formdata.append('fld_val',fld_val);
								formdata.append('perod',perod);
								formdata.append('day',day);
								 
								formdata.append('manage_number_of_class','OK');
								var url='<? echo $ajaxFilePath ?>?manage_number_of_class=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('manage_number_of_class_result',url,formdata);
						
						
						}
						function manage_number_of_class_result(data)
						{
						 //alert(data);
						
						}
						function show_class_room(day,periods,no_of_class)
						{
						  var formdata = new FormData();
								 
								
								formdata.append('no_of_class',no_of_class);
								formdata.append('periods',periods);
								formdata.append('day',day);
								 
								formdata.append('show_class_room','OK');
								var url='<? echo $ajaxFilePath ?>?show_class_room=OK&';
								os.animateMe.div='div_busy';
								os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
								os.setAjaxFunc('show_class_room_results',url,formdata);
						
						
						}
						
						function show_class_room_results(data)
						{
						  os.setHtml('class_room_area_id',data);
						
						}
						</script>
<? include($site['root-wtos'].'bottom.php'); ?>
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

$listHeader='Hostel  Setting';

$ajaxFilePath= 'hostelroom_setting_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

    /*$sel="select * from hostel_room where room_name!='' ";
	$resset=$os->mq($sel);
	$cc=0;
	while($record=$os->mfa($resset))
	{
	
	  $record_val=$record['hostel_room_id'].'-'.$record['building_name'].'-'.$record['floor_name'].'-'.$record['room_name'].'-'.$record['bed_list'];
	
	    $config_array[$record['hostel_room_id']]=$record_val;
	}
 */


$config_array=array();
	$sel="select * from hostel_room where room_name!='' ";
	$resset=$os->mq($sel);
	$cc=0;
	while($record=$os->mfa($resset))
	{
	   $cc++;
	   $config_array[$record['building_name']][$record['floor_name']][$cc]=$record;
	}
?> 





  



 <table class="container"  cellpadding="0" cellspacing="0">

				<tr>

					 

			  <td  class="middle" style="padding-left:5px;">

			  

			  

			  <div class="listHeader"  > 

			  <?php  echo $listHeader; ?>  &nbsp;&nbsp;  <span style="color:#0000CC">  for Session:

	

	<select name="asession" id="asession_s" class="textbox fWidth" >
	<option value=""></option>
	<? $os->onlyOption($os->asession,$os->selectedSession());?>
	</select>	
	
	
  </span>

			  

			 

			  </div>

			  

			  <!--  ggggggggggggggg   -->

			  

			  

			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

			  

  <tr>

    <td width="380" height="470" valign="top" class="ajaxViewMainTableTDForm">

	  <table width="100%" border="0" cellspacing="2" cellpadding="2" style="margin:5px;">
  <tr>
  <td>Class</td>
   
  </tr>
  <tr>
  
  <td valign="top">
  
  
  <? //foreach($os->classList as $class_id=>$val){
	
	 ?>
	<!-- <div class="checkbox_list"> <input type="checkbox" name="classList[]" value="<? echo $class_id ?>" /> <? echo $val ?>  </div>-->
	 <? 
	
	
	//}
	 ?>	
	
	 <select name="classes" id="classes" class="textbox fWidth" onchange="">	<? 

$os->onlyOption($os->classList,'');	?></select>
	 
	
	
	
	
	
	
	</td>
	</tr>
   <tr>  
    <td valign="top" style="display:none;">
	
				A <input type="checkbox" name="section[]" value="A"  /> <br />
				B <input type="checkbox" name="section[]" value="B"   /> <br />
				C <input type="checkbox" name="section[]" value="C"   /> <br />
				D <input type="checkbox" name="section[]"  value="D"  /> <br />
	 
	
		</td>
		</tr>
   <tr> 
		<td valign="top">
	      <? 
	 foreach( $config_array as $building_name=>$floors  )
	 {
	 ?>
		
		<div class="bedlist"><div class="class_building_name">Building: <? echo $building_name ?> </div>  
		    <? 
				  foreach( $floors as  $floor_name=>$rooms ){
				  ?>
		
		<div class="floor_name_class">Floor:<? echo $floor_name ?></div>   
		
		 <div class="rooms">
				<?  
				 $cc=1;
				 foreach( $rooms as  $rec )
				 {
					 	
				?>			 
				  <div class="Room_bed">
				  <input type="checkbox" id="check_bed_list<? echo $rec['hostel_room_id'] ?>" name="room_list[]" value="<? echo $rec['hostel_room_id'] ?>" onclick="set_bed_list('check_bed_list<? echo $rec['hostel_room_id'] ?>','bed_list<? echo $rec['hostel_room_id'] ?>','<? echo $rec['bed_list'] ?>')"  /> &nbsp;<b>Room: <? echo $rec['room_name'] ?> </b>
				  
				  
				   &nbsp;<input type="text" class="bed_list_class" id="bed_list<? echo $rec['hostel_room_id'] ?>" name="bed_list[]" style="width:230px;" />   
				   
				   <div style="font-style:italic; color:#00B058; font-size:11px;" title="Available bed">Bed No  <? echo $rec['bed_list'] ?> </div>
				    </div>  	
				  
				 <!--  value as room name is not ok , two bulding may have same room 		--> 
					<? 		 
							  
				 $cc++;
				 }
				 ?> </div>
				 <?
				 
				 }
				  
				 
				 
	   ?> 
	   
	   
	   <div style="clear:both"> </div></div>  <? 
	 }
	 
	 ?>
	 
	
		</td>
  </tr>
</table>

<input name="button" type="button" onclick="manage_hostemroom_setting('save')" value="SAVE"/>
	

	</td>

    <td valign="top" class="ajaxViewMainTableTDList">

	

	<div class="ajaxViewMainTableTDListSearch">

						  

	
			

	 <span class="hideForSelectedData" style="display:none">

 



Class <select name="classList" id="classList_s" class="textbox fWidth"><option value=""></option>	<? 

$os->onlyOption($os->classList,'');	?></select>	

		
		 <input type="button" value="Search" onclick="manage_hostemroom_setting('search');" style="cursor:pointer;"/>

  

   
  

  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

 

	  

</span>



	

   

 

   

 

  

   </div>

	<div  class="ajaxViewMainTableTDListData" id="WT_feesListDiv">&nbsp; </div>

	&nbsp;</td>

  </tr>

</table>



		

			  			  

			  <!--   ggggggggggggggg  -->

			  

			  </td>

			  </tr>

</table>

			<script>
	 
	  
	   
function manage_hostemroom_setting(button) // get record by table primery id
{
	var formdata = new FormData();
	var room_list= getValuesFromCheckedBox('room_list[]'); 
	var bed_list= getValuesFromTextBoxArray('bed_list[]');
	var section= getValuesFromCheckedBox('section[]'); 
	
	var classes= os.getVal('classes');
	formdata.append('room_list',room_list);
	formdata.append('bed_list',bed_list );
	formdata.append('section',section );
	formdata.append('classes',classes );
	
	formdata.append('button',button );
	formdata.append('manage_hostemroom_setting','OK' );
	 
	
	var url='<? echo $ajaxFilePath ?>?manage_hostemroom_setting=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('manage_hostemroom_setting_results',url,formdata);
	 			
}

function manage_hostemroom_setting_results(data)  // fill data form by JSON
{
    
   var content_data=	getData(data,'##--manage_hostemroom_setting--##');
   os.setHtml('WT_feesListDiv',content_data);
   
	 
	 

  
}

	
	</script>

	 
  <style>
 .bedlist{ width:354px;}
 .bed_list_class{ width:100px;}
  
 .class_building_name{ background-color:#B0D8FF; color:#0000FF; font-size:24px; font-weight:400; padding:5px; border:1px solid #CCCCCC;}
 .floor_name_class{ background-color:#E1F0FF; color:#0093D9; font-size:18px; font-weight:400; padding:5px;border:1px solid #CCCCCC;}
 .rooms{  background-color:#F6F6F6; border:1px solid #CCCCCC;    }
 .Room_bed{ padding:5px; font-size:14px; border-bottom: 2px groove #FFFFFF;}
 .Room_bed_graph{    border:2px solid #003399; margin:2px;}
 .bed_no{ width:20px; height:35px; margin:5px;  padding:5px; float:left;}
  
 </style>
 <script>
 function set_bed_list(id,txtid,val)
 {
  os.setVal(txtid,'');
  if(os.getObj(id).checked==true)
  {
    os.setVal(txtid,val);
  
  }
 
 
 }
 manage_hostemroom_setting('');
 </script>

 

<? include($site['root-wtos'].'bottom.php'); ?>
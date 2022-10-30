<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/
session_start();
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);
$department = "Construction";
$access_name = "Construction Job";
//
$session_cookie_key = $os->getSession($department."_branch");
//
$selected_branch    = $os->getSession($department."_branch");
$global_access      = $os->get_global_access_by_name($access_name);
$secondary_access   = $os->get_secondary_access_by_branch_and_menu($selected_branch, $access_name);
/**
 * Select Box
 */
if($os->get("get_campus_building_by_branch_code")=="OK"&&$os->post("get_campus_building_by_branch_code")=="OK"){
    $branch_code_s = $os->post("branch_code_s");
    $query = $os->mq("SELECT * FROM campus_location WHERE branch_code='$branch_code_s'");
    ?>
    <option value="">--</option>
    <?
    while ($row = $os->mfa($query)){
        ?>
        <option value="<?=$row["campus_location_id"]?>"><?=$row["campus_name"]?></option>
        <?
    }

}



if($os->get("WT_fetch_job_list")=="OK" && $os->post("WT_fetch_job_list")=="OK"){
    $from_date  = $os->post("from_date_s");
    $to_date    = $os->post("to_date_s");
    $branch_code_s    = $os->post("branch_code_s");
    $campus_location_s    = $os->post("campus_location_s");
	
	

    $and_branch_code = $os->postAndQuery("branch_code_s","j.branch_code","=");
    $and_campus_location = $os->postAndQuery("campus_location_s","j.campus_location_id","=");
	 
	 $from_date_s='1970-01-01';
	 if( $from_date!='')
	 {
	  $from_date_s=$from_date;
	 }
	 
	  $to_date_s=date('Y-m-d');
	 if( $to_date!='')
	 {
	  $to_date_s=$to_date;
	 }
	 if($branch_code_s=='')
	 {
	   echo 'Select Branch ;';
	   exit;
	 }
  
  
       $job_query="SELECT *  FROM jobs j WHERE j.branch_code!='' and (j.job_start_date BETWEEN DATE('$from_date_s') AND DATE('$to_date_s'))   $and_branch_code $and_campus_location order by job_start_date desc";
    $query = $os->mq( $job_query);
	//$os->query;
    ?>
    <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
        <thead>
        <tr>
            <th class="uk-table-shrink">#</th>
			 <th>Dated</th>
            <th>Job Title</th>
             
			<th> </th>
			 
		 
			 
        </tr>
        </thead>
        <tbody>
        <?
        $c = 0;
        while($job = $os->mfa($query)) {
            $c++;
            ?>
            <tr>
			 
                <td class="uk-table-shrink"><?=$c;?></td>
				 <td> <?=$os->showDate($job["job_start_date"]);?></td>
                <td>
                    <?=$job["job_title"]?>
					<br />
					<div style="font-size:10px;">
					Manager:<?=$job["manager_name"]?>
					<br />
					Campus: <?  
	echo $os->rowByField('campus_name','campus_location','campus_location_id',$job['campus_location_id']); ?>
					<br />
				Dept:	<?=$job["department"]?>
					<br />
				Branch:	<?=$job["branch_code"]?>
					<br />
					<?=$job["job_status"]?>
                    </div>
                </td>
                
                 
				
				  <td> <a href="javascript:void(0)" onclick="manage_item_use('<?=$job["job_id"]?>','')"> Items</a> <br /><br /><br />
				  
				  <a href="javascript:void(0)" onclick="manage_progress_image('<?=$job["job_id"]?>','')"> progress </a><br />
				  <a href="javascript:void(0)" onclick="manage_progress_document('<?=$job["job_id"]?>','')"> Doc </a>
				  </td>
				  
				   
				 
				 
				 
            </tr>
         <? } ?>
        </tbody>
    </table>

    <? 

}


if($os->get("WT_add_edit_job")=="OK" && $os->post("WT_add_edit_job")=="OK")
{
   
			$job_type_id='';				 
			$branch_code  = $os->post("branch_code_s");
			$campus_location_id    = $os->post("campus_location_s");
			$job_id    = $os->post("job_id");
			
			$department    = $os->post("department");
			$job_title    = $os->post("job_title");
			$job_start_date    = $os->post("job_start_date");
			$manager_name    = $os->post("manager_name");
			$job_note    = $os->post("job_note");
			
			
			$dataToSave=array();
			$dataToSave['job_title']=addslashes($job_title); 
			$dataToSave['job_note']=addslashes($os->post('job_note')); 
			$dataToSave['manager_name']=addslashes($os->post('manager_name')); 
			
			$dataToSave['department']=$department; 
			$dataToSave['campus_location_id']=$campus_location_id; 
			$dataToSave['branch_code']=$branch_code;
			$dataToSave['job_type_id']=$job_type_id;
			$dataToSave['department']=$department;
			$dataToSave['job_start_date']=$job_start_date;
			$dataToSave['job_status']='';
			
			$qResult=$os->save('jobs',$dataToSave,'job_id',$job_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
			if($qResult)  
			{
					if($job_id>0 ){ $mgs= " Data updated Successfully";}
					if($job_id<1 ){ $mgs= " Data Added Successfully"; $job_id=  $qResult;}
					
					$mgs=$job_id."#-#".$mgs;
			}
			else
			{
			$mgs="Error#-#Problem Saving Data.";
			
			}
		  
		echo $mgs;		
	
					 
}

if($os->get("manage_progress_image")=="OK" && $os->post("manage_progress_image")=="OK")
{

    $job_id  = $os->post("job_id"); 
     $action= $os->post("action");
      
	$title  = $os->post("title");
	$dated  = $os->post("dated");
	$note  = $os->post("note");
	$branch_code  = $os->post("branch_code_s");
	
	$dataToSave=array();
	$image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				if($image!=''){
				$dataToSave['image']='wtos-images/'.$image;}	
		 	
		 	 
	if($action=='save' && $image!='' )
	{
				
				$dataToSave['job_id']=$job_id; 				
				$dataToSave['title']=$title; 
				$dataToSave['dated']=$dated;
				$dataToSave['note']=$note;
				//$dataToSave['branch_code']=$branch_code;
				
				$job_progress_id = $os->save("job_progress", $dataToSave, 'job_progress_id', $job_progress_id); 
				//echo $os->query; 
				if($job_progress_id){ echo 'Image upload success.';}
   }
   
   
  
  ?>

   <form action="#"
          method="post"
          class="uk-form-stacked" id="manage_progress_image_form"
          enctype="multipart/form-data">
		  
		  <table width="350" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td>Description</td>
    <td><input type="text" name="title" /> </td>
  </tr>
  <tr>
    <td>Image</td>
    <td><input type="file" name="image" id="image" /></td>
  </tr>
  <tr>
    <td>Dated</td>
    <td><input type="text" name="dated" value="<? echo date('Y-m-d'); ?>" /> </td>
  </tr>
  <tr style="display:none;">
    <td>Note</td>
    <td><input type="text" name="note" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" value="SAVE" onclick="manage_progress_image(<?=$job_id ?>,'save');" /></td>
  </tr>
</table>

		 
		
		 
    </form>
<div style="width:100%">
<?

  $query="select * from job_progress   where job_id='$job_id'  ";
$rsResults=$os->mq($query);
while($record=$os->mfa( $rsResults))
{
?>
<div style="width:200px; height:250px; float:left;margin:10px; box-shadow:2px 2px 2px #999999;  ">
<img src="<?php  echo $site['url'].$record['image']; ?>"  style="width:200px; height:200px;   " />
<br />
<?=$os->showDate($record['dated']); ?>
<br />
<?=$record['title'] ?> 
</div>


<? 
	 
}

?>
</div>

<?



exit();   
}   



 if($os->get("manage_item_use")=="OK" && $os->post("manage_item_use")=="OK")
{

		$job_id  = $os->post("job_id"); 
		$action= $os->post("action");
		
		$reff_no  = $os->post("reff_no");
		$dated  = $os->post("dated");
		$branch_code  = $os->post("branch_code_s");
		
		$item_use_id= $os->post("item_use_id");
		
				 
	if($action=='save' ){
				
				$dataToSave['job_id']=$job_id; 				
				$dataToSave['reff_no']=$reff_no; 
				$dataToSave['dated']=$dated;
				$dataToSave['department']=$department;
				$dataToSave['branch_code']=$branch_code;
				  
				$item_use_id = $os->save("item_uses", $dataToSave, 'item_use_id', $item_use_id); 
				 
				if($job_progress_id){ echo 'Data added success.';}
     }
      
     $branch= $os->rowByField('','branch','branch_code',$branch_code,$where='',$orderby=''); 
	 
	  $job= $os->rowByField('','jobs','job_id',$job_id,$where='',$orderby=''); 
	  
	  
	 
  ?>
   <span style="font-size:18px;">  <? echo $job['job_title']; ?>   </span>
   <br />
   <i><? echo $os->showDate($job['job_start_date']); ?>   </i>
	 <!--	Branch : <b> <? echo $branch['branch_name']; ?> </b> <br />
	 	Branch Code : <i>  <? echo $branch['branch_code']; ?>  </i>-->
		  
		  
 
	
<div id="viewdata"> </div>		 
		
		 
    
<ul uk-accordion>
 <li>
        <a class="uk-accordion-title" href="#" >  Dated    &nbsp;  &nbsp;  Reference No </a>
        <div class="uk-accordion-content">
		 <form action="#"
          method="post"
          class="uk-form-stacked" id="manage_item_use_form"
          enctype="multipart/form-data">
           <table width="350" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFD9;">
  
    <td><input type="text" name="dated" value="<? echo date('Y-m-d'); ?>" style="width:90px;border:1px solid #EAEAEA;"  /> </td>
    <td><input type="text" name="reff_no" style="width:90px;border:1px solid #EAEAEA;" /> </td>
    <td><input type="button" value="Add New Date" onclick="manage_item_use(<?=$job_id ?>,'save');"  style="cursor:pointer;" /></td>
  </tr>
   
</table>
</form>
        </div>
    </li>

<?

// get all item  uses detailes 

   $details_q="SELECT ied.*, i.item_name 
                FROM item_uses_details ied
                INNER JOIN items i ON i.item_id=ied.item_id                 
                WHERE ied.item_use_id IN ( select iu.item_use_id from item_uses  iu  where iu.job_id='$job_id' )
				ORDER BY item_uses_detail_id DESC";
 $query_rs = $os->mq($details_q);
 $item_details_data=array();
 while($record=$os->mfa($query_rs))
 {
   
   $item_details_data[$record['item_use_id']][$record['item_uses_detail_id']]=$record;
      
   
 
 }




$query="select * from item_uses   where job_id='$job_id' order by dated desc  ,item_use_id desc ";
$rsResults=$os->mq($query);
$i=0;
while($record=$os->mfa( $rsResults))
{
// _d($record);
$item_use_id=$record['item_use_id'];

$details_array=$os->val($item_details_data,$item_use_id);


////  item data 
$items_list=array();
$items_list_rs=$os->get_items('item_id,item_name',"   departments='$department'");
 while($item_row=$os->mfa($items_list_rs))
{
   $items_list[$item_row['item_id']]=$item_row['item_name'] ;
   
    
}



//_d($details_array);

$i++;
?>  
    <li <? if($i==1){ ?>class="uk-open" <? } ?> >
        <a class="uk-accordion-title" href="#" style="color:#0067CE;"> <?=$os->showDate($record['dated']); ?>  : <?=$record['reff_no'] ?> </a>
        <div class="uk-accordion-content" style="background-color:#DDEEFF; padding:2px;">
            
			<!-- listing --->
			
			<?  if(is_array($details_array)){ ?> 
			
					<table width="300" border="0" cellspacing="0" cellpadding="0">
					<tr style="color:#666666; font-weight:bold;  ">
					<td>Item</td>
					<td>Quantity</td>
					<td> </td>
					</tr>
					
					
					
					<? foreach($details_array as $row){ ?>
					
					
					<tr>
					<td><?=$row['item_name']; ?></td>
					<td><?=$row['quantity']; ?></td>
					<td><a href="javascript:void(0);" style="color:#FF0000;"  onclick="removeRowAjaxFunction('item_uses_details','item_uses_detail_id','<?=$row['item_uses_detail_id']; ?>','','','manage_item_use(\'<? echo $job_id ?>\',\'\')')" >Delete</a> </td>
					</tr>
					 
					<? }?>
					
					</table>
					
					
					<? }else{  ?>
					<div style="padding:10px;">
					  <a href="javascript:void(0);" style="color:#FF0000;"  onclick="removeRowAjaxFunction('item_uses','item_use_id','<?=$item_use_id; ?>','','','manage_item_use(\'<? echo $job_id ?>\',\'\')')" >Delete This Date </a>
					  </div> 
					<? } ?>
			
			
			<!-- listing --->
			
			
			
			
			<form action="#" method="post" class="uk-form-stacked" id="manage_item_use_details_form_<? echo $item_use_id;?>" 	enctype="multipart/form-data">
			<table width="350" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFD9; margin-top:10px;">
			<td> 
			
			<select class="selectize_item" name="item_id" id="item_id" style="width:130px; height:25px;border:1px solid #EAEAEA;" 
			  onchange="wt_ajax_chain('text*item_unit_span<? echo $item_use_id;?>*items,item_id,item_unit*item_id=item_id','','','');" >
			<option value=""> </option>
			<?  $os->onlyOption($items_list); ?>			
			</select>
			
			
			 </td>
			<td><input type="text" name="quantity" style="width:90px; height:25px;border:1px solid #EAEAEA;" placeholder='quantity' /> <input style="width:20px; border:none;" readonly="readonly" type="text" id="item_unit_span<? echo $item_use_id;?>" value=""/>   </td>
			<td><input type="button" value="Add" onclick="manage_item_use_details(<?=$item_use_id ?>);" style="cursor:pointer;" /></td>
			</tr>
			</table>
			</form>
			
			
        </div>
    </li>
  
<? 
	 
}

?>
</ul>

<?



exit();   
}   


if($os->get("manage_item_use_details")=="OK" && $os->post("manage_item_use_details")=="OK")
{ 
   
    $item_use_id=$os->post("item_use_id");
    $item_uses_detail_id=$os->post("item_uses_detail_id");
    $item_id=$os->post("item_id");
    $quantity=$os->post("quantity") ;
    $item_uses_info=$os->rowByField('','item_uses','item_use_id',$item_use_id);
	$branch_code=$item_uses_info['branch_code'];  // 

    $datatosave = array(
        "item_use_id"     =>$item_use_id,
        "item_id"           =>$item_id,
        "quantity"          =>$quantity
     );
    $item_uses_detail_id = $os->save("item_uses_details", $datatosave, 'item_uses_detail_id', $item_uses_detail_id);

   if($item_uses_detail_id)
   {
    echo 'Successfully added.';
   
   }
}   

if($os->get("manage_progress_document")=="OK" && $os->post("manage_progress_document")=="OK")
{

    $job_id  = $os->post("job_id"); 
     $action= $os->post("action");
      
	$title  = $os->post("title");
	$dated  = $os->post("dated");
	$note  = $os->post("note");
	$branch_code  = $os->post("branch_code_s");
	
	 $dataToSave=array();
	$image=$os->UploadPhoto('docs',$site['root'].'wtos-images');
				if($image!=''){
				$dataToSave['document']='wtos-images/'.$image;}	
		 	
		 	 
	if($action=='save' && $image!='' )
	{
	       
				
				$dataToSave['job_id']=$job_id; 				
				$dataToSave['title']=$title; 
				$dataToSave['dated']=$dated;
				$dataToSave['note']=$note;
				//$dataToSave['branch_code']=$branch_code;
				
				$job_document_id = $os->save("job_document", $dataToSave, 'job_document_id', $job_document_id); 
				//echo $os->query; 
				if($job_document_id){ echo 'Doc upload success.';}
   }
   
   
  
  ?>

   <form action="#"
          method="post"
          class="uk-form-stacked" id="manage_progress_document_form"
          enctype="multipart/form-data">
		  
		  <table width="350" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td>Description</td>
    <td><input type="text" name="title" id="title" list="title_data" /> 
	

<datalist id="title_data">
  <option value="Mutation">
  <option value="Conversion">
  <option value="Floor Plan">
  <option value="Plan">
  
</datalist>
	</td>
  </tr>
  <tr>
    <td>Document</td>
    <td><input type="file" name="docs" id="docs" /></td>
  </tr>
  <tr>
    <td>Dated</td>
    <td><input type="text" name="dated" value="<? echo date('Y-m-d'); ?>" /> </td>
  </tr>
  <tr style="display:none;">
    <td>Note</td>
    <td><input type="text" name="note" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" value="SAVE" onclick="manage_progress_document(<?=$job_id ?>,'save');" /></td>
  </tr>
</table>

		 
		
		 
    </form>
<div style="width:100%">
<?

  $query="select * from job_document   where job_id='$job_id'  ";
$rsResults=$os->mq($query);
while($record=$os->mfa( $rsResults))
{
?>
<div style=" margin:10px;box-shadow:2px 2px 2px #999999; padding:5px; width:100%;">
 
<?=$os->showDate($record['dated']); ?>
<br />
<a href="<?php  echo $site['url'].$record['document']; ?>" target="_blank">
<?=$record['title'] ?> 
</a>
</div>


<? 
	 
}

?>
</div>

<?



exit();   
}
<? 
/*
   # wtos version : 1.1
   # page called by ajax script in branchDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$os->showPerPage=50;
 
 

if($os->get('WT_branchListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
$andaddress=  $os->postAndQuery('address_s','address','%');
$andcontact=  $os->postAndQuery('contact_s','contact','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$andpin_code=  $os->postAndQuery('pin_code_s','pin_code','%');
$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');
$andincharge_name=  $os->postAndQuery('incharge_name_s','incharge_name','%');
$andunit_name=  $os->postAndQuery('unit_name_s','unit_name','%');
$andgroup_unit=  $os->postAndQuery('group_unit_s','group_unit','%');

    $f_estd_date_s= $os->post('f_estd_date_s'); $t_estd_date_s= $os->post('t_estd_date_s');
   $andestd_date=$os->DateQ('estd_date',$f_estd_date_s,$t_estd_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andclass_list=  $os->postAndQuery('class_list_s','class_list','%');
$andr_n=  $os->postAndQuery('r_n_s','r_n','%');
$andcampus_type=  $os->postAndQuery('campus_type_s','campus_type','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( branch_code like '%$searchKey%' Or address like '%$searchKey%' Or contact like '%$searchKey%' Or email like '%$searchKey%' Or pin_code like '%$searchKey%' Or active_status like '%$searchKey%' Or incharge_name like '%$searchKey%' Or unit_name like '%$searchKey%' Or group_unit like '%$searchKey%' Or class_list like '%$searchKey%' Or r_n like '%$searchKey%' Or campus_type like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from branch where branch_id>0   $where   $andbranch_code  $andaddress  $andcontact  $andemail  $andpin_code  $andactive_status  $andincharge_name  $andunit_name  $andgroup_unit  $andestd_date  $andclass_list  $andr_n  $andcampus_type     order by branch_id desc";
	$os->showPerPage=200;  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
  	
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						<td >Action </td>
	                            <td >#</td>
									
								

											
   
  <td ><b>Code</b></td>  
  
 
  <td style="width:300px;" ><b>Address</b></td>  
  <td ><b>In-Charge</b></td>   
  <td ><b>Logo</b></td> 
   <td> Classes </td>
  
  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_branchGetById('<? echo $record['branch_id'];?>')" >Edit</a></span>  <? } ?>  </td>
							<td><?php echo $serial; ?>     </td>
							
								
  
  <td valign="top"> <b  style="font-size:15px;"><?php echo $record['branch_code']?> </b> <br />
     <span style="color:#3366FF; font-weight:bold"> <?php echo $record['branch_name']?></span><br />
	<span style="color:#B7005B"> 
	<input class="no_border transparent_bg" value="<?php echo $record['unit_name']?>" id="quickedit_unit_name_<?php echo $record['branch_id']?>" type="text" onchange="wtosInlineEdit('quickedit_unit_name_<?php echo $record['branch_id']?>','branch','unit_name','branch_id','<?php echo $record['branch_id']?>','','','')" style="color:#B7005B" />
	
	</span> <br />
	
     <? if(isset($os->group_unit_list[$record['group_unit']])){ ?>
	<span style="color:#7400E8; font-size:10px"> <? echo  $os->group_unit_list[$record['group_unit']] ; ?> </span>
	 [<span style="color:#5300A6;font-size:11px"><b><? echo $record['group_unit']; ?></b></span>]
	 
	 <?  } ?>
	 
  </td>  
  

   
  <td valign="top" >
 
 <span class="head_g">Address: </span>  <input class="no_border transparent_bg" value="<?php echo $record['address']?>" id="quickedit_address_<?php echo $record['branch_id']?>" type="text" onchange="wtosInlineEdit('quickedit_address_<?php echo $record['branch_id']?>','branch','address','branch_id','<?php echo $record['branch_id']?>','','','')" style="width:250px;" /> <br />
 
  
<span class="head_g">PO: </span>  <input class="no_border transparent_bg" value="<?php echo $record['PO']?>" id="quickedit_PO_<?php echo $record['branch_id']?>" type="text" onchange="wtosInlineEdit('quickedit_PO_<?php echo $record['branch_id']?>','branch','PO','branch_id','<?php echo $record['branch_id']?>','','','')" /> <br />

<span class="head_g">PS: </span>  <input class="no_border  transparent_bg" value="<?php echo $record['PS']?>" id="quickedit_PS_<?php echo $record['branch_id']?>" type="text" onchange="wtosInlineEdit('quickedit_PS_<?php echo $record['branch_id']?>','branch','PS','branch_id','<?php echo $record['branch_id']?>','','','')" />  

<span class="head_g">Dist: </span> <input class="no_border  transparent_bg" value="<?php echo $record['dist']?>" id="quickedit_dist_<?php echo $record['branch_id']?>" type="text" onchange="wtosInlineEdit('quickedit_dist_<?php echo $record['branch_id']?>','branch','dist','branch_id','<?php echo $record['branch_id']?>','','','')" /> <br />

<span class="head_g">State: </span>  <input class="no_border  transparent_bg" value="<?php echo $record['state']?>" id="quickedit_state_<?php echo $record['branch_id']?>" type="text" onchange="wtosInlineEdit('quickedit_state_<?php echo $record['branch_id']?>','branch','state','branch_id','<?php echo $record['branch_id']?>','','','')" />  
  
 <span class="head_g">Pin: </span>  <?php echo $record['pin_code']?> 
  
  </td>  
  <td valign="top">
 <b> <?php echo $record['incharge_name']?> </b><br />
  <span style="color:#000066; font-size:11px;"> <?php echo $record['contact']?></span><br />
     <i style="color:#0000FF; font-size:10px;"><?php echo $record['email']?> </i>
   </td>  
  
    
    
  <td valign="top"> <?  if($record['logoimage']){?> <img src="<?php  echo $site['url'].$record['logoimage']; ?>"  height="70" width="70" /><br /> <? } ?>
     <span style="font-size:10px; color:#006600"> <?php echo $record['tagline']?></span>
	 <?php echo $record['theme_data']?>
  </td>  
   <td> <span style="cursor:pointer; color:#0066FF;" onclick="board_and_class_link('<?php echo $record['branch_code']?>','')">Classes</span>
   
   
 <!--  <? if(isset($os->activeStatus[$record['active_status']])){ echo  $os->activeStatus[$record['active_status']]; } ?>-->
   </td>
  
  
 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_branchEditAndSave')=='OK')
{
 $branch_id=$os->post('branch_id');
 
 
		 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['branch_name']=addslashes($os->post('branch_name')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['contact']=addslashes($os->post('contact')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['pin_code']=addslashes($os->post('pin_code')); 
 $dataToSave['tagline']=addslashes($os->post('tagline')); 
 $logoimage=$os->UploadPhoto('logoimage',$site['root'].'wtos-images');
				   	if($logoimage!=''){
					$dataToSave['logoimage']='wtos-images/'.$logoimage;}
 $dataToSave['theme_data']=addslashes($os->post('theme_data')); 
 $dataToSave['latitude']=addslashes($os->post('latitude')); 
 $dataToSave['lognitude']=addslashes($os->post('lognitude')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 
 $dataToSave['incharge_name']=addslashes($os->post('incharge_name')); 
 $dataToSave['unit_name']=addslashes($os->post('unit_name')); 
 $dataToSave['group_unit']=addslashes($os->post('group_unit')); 
 $dataToSave['estd_date']=$os->saveDate($os->post('estd_date')); 
 $dataToSave['class_list']=addslashes($os->post('class_list')); 
 $dataToSave['r_n']=addslashes($os->post('r_n')); 
 $dataToSave['campus_type']=addslashes($os->post('campus_type')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($branch_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('branch',$dataToSave,'branch_id',$branch_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($branch_id>0 ){ $mgs= " Data updated Successfully";}
		if($branch_id<1 ){ $mgs= " Data Added Successfully"; $branch_id=  $qResult;}
		
		  $mgs=$branch_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_branchGetById')=='OK')
{
		$branch_id=$os->post('branch_id');
		
		if($branch_id>0)	
		{
		$wheres=" where branch_id='$branch_id'";
		}
	    $dataQuery=" select * from branch  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['branch_code']=$record['branch_code'];
 $record['branch_name']=$record['branch_name'];
 $record['address']=$record['address'];
 $record['contact']=$record['contact'];
 $record['email']=$record['email'];
 $record['pin_code']=$record['pin_code'];
 $record['tagline']=$record['tagline'];
 if($record['logoimage']!=''){
						$record['logoimage']=$site['url'].$record['logoimage'];}
 $record['theme_data']=$record['theme_data'];
 $record['latitude']=$record['latitude'];
 $record['lognitude']=$record['lognitude'];
 $record['active_status']=$record['active_status'];
 $record['incharge_name']=$record['incharge_name'];
 $record['unit_name']=$record['unit_name'];
 $record['group_unit']=$record['group_unit'];
 $record['estd_date']=$os->showDate($record['estd_date']); 
 $record['class_list']=$record['class_list'];
 $record['r_n']=$record['r_n'];
 $record['campus_type']=$record['campus_type'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_branchDeleteRowById')=='OK')
{ 

$branch_id=$os->post('branch_id');
 if($branch_id>0){
 $updateQuery="delete from branch where branch_id='$branch_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}


if($os->get('board_and_class_link')=='OK' && $os->post('board_and_class_link')=='OK' )
{ 

	
	$branch_code=$os->post('branch_code');
	$wt_action=$os->post('wt_action');  
	  
	if($wt_action=='save' && $branch_code!='')
	{
				$data_class_list=$os->post('data_class_list');	
				$class_list=array();
				$class_list_str='';
				if(trim($data_class_list)!='')
				{
						$data_class_list_arr=explode(',',$data_class_list);
				  
				   
					  foreach($data_class_list_arr as $class_str)
					  {
						  $class_val=explode('=',$class_str);
						  
						   
						  
						  $board_key=$class_val[0];
						  $class_key=$class_val[1];
						  if( $board_key!=''){
							  $class_list[$board_key][]=$class_key;
						 }
					  }
				  
					
				
				}
				
				if(count($class_list)>0)
				{
				$class_list_str=json_encode($class_list);
				
				}
		$branch_id=$os->rowByField($getfld='branch_id',$tables='branch',$fld='branch_code',$fldVal=$branch_code,$where='',$orderby=''); 
		
		$dataToSave=array();					      
		$dataToSave['class_list']=$class_list_str;
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId'];		
		$qResult=$os->save('branch',$dataToSave,'branch_id',$branch_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		  
		 
	}	
	
	$query="select class_list from branch where  branch_code='$branch_code'";
	$record_rs=$os->mq($query);
	$record_br=$os->mfa($record_rs);	
	$saved_class_list=$record_br['class_list'];
	
	 $saved_class_array=json_decode($saved_class_list,true);
  
  
  
  foreach($saved_class_array  as $board=>$class)
  {
      
     foreach($accKeyArr  as $acc)
	 {
	   $access_key=$branch_code.'='.$acc;
	   $accessArr[$access_key]=$access_key;
	 
	 }
 
  
  }
	
	
	
	
	
	
	
echo '##--board_and_class_DIV_data--##';
   
//_d($os->board); 
//_d($os->classList); 
//_d($saved_class_array);
	 
	?>
	
		<? foreach($os->board_class as $board_val=>$classList){ ?>
		         
		                <br /> <br />
						 <h2> <? echo  $board_val; ?>  </h2>
						 
						 <div style="padding:10px; background-color:#FFFFC4;">
			
						<? foreach($classList as $class_id){ ?>
						
						 <input type="checkbox" name="data_class_list[]" value="<? echo  $board_val; ?>=<? echo  $class_id; ?>"  /> <? echo  $os->classList[$class_id]; ?> &nbsp;  &nbsp;
						<? } ?>
						</div>
		<? } ?>
		
		<br /> <br />
		<input type="button" onclick="board_and_class_link('<?php echo $branch_code;?>','save')" style="cursor:pointer;"  value="SAVE" />
	
	<?  
	 
    
echo '##--board_and_class_DIV_data--##';
exit();
}



 

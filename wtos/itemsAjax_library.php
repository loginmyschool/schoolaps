<?
/*
   # wtos version : 1.1
   # page called by ajax script in itemsDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$department = "Library";


?><?

if($os->get('WT_itemsListing')=='OK')

{
    $where='';
	$showPerPage= $os->post('showPerPage');


$anditem_id=  $os->postAndQuery('item_id_s','item_id','%');
$anditem_name=  $os->postAndQuery('item_name_s','item_name','%');
$andbeng_name=  $os->postAndQuery('beng_name_s','beng_name','%');
$andhindi_name=  $os->postAndQuery('hindi_name_s','hindi_name','%');
$andkeywords=  $os->postAndQuery('keywords_s','keywords','%');
$anditem_unit=  $os->postAndQuery('item_unit_s','item_unit','%');
$anditem_type=  $os->postAndQuery('item_type_s','item_type','%');
$andshow_in_daily_report=  $os->postAndQuery('show_in_daily_report_s','show_in_daily_report','%');
$anddepartments=  $os->postAndQuery('departments_s','departments','%');
$andrecoverable=  $os->postAndQuery('recoverable_s','recoverable','%');
$anditem_code=  $os->postAndQuery('item_code_s','item_code','%');
$andcategory_id=  $os->postAndQuery('category_id_s','category_id','%');
$andbarcode_applicable=  $os->postAndQuery('barcode_applicable_s','barcode_applicable','%');


$and_isbn=  $os->postAndQuery('isbn_s','isbn','%');
$and_author=  $os->postAndQuery('author_s','author','%');
$and_publisher=  $os->postAndQuery('publisher_s','publisher','%');
$and_no_of_pages=  $os->postAndQuery('no_of_pages_s','no_of_pages','%');


$user_admins=array();
$user_admin_rs=$os->get_admin('adminId,name');
while($admin_row= $os->mfa($user_admin_rs))
{
   $user_admins[$admin_row['adminId']]=$admin_row['name'];

}



	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( item_id like '%$searchKey%' Or item_name like '%$searchKey%' Or beng_name like '%$searchKey%' Or hindi_name like '%$searchKey%' Or keywords like '%$searchKey%' Or item_unit like '%$searchKey%' Or item_type like '%$searchKey%' Or show_in_daily_report like '%$searchKey%' Or departments like '%$searchKey%' Or recoverable like '%$searchKey%' Or item_code like '%$searchKey%' Or category_id like '%$searchKey%' Or barcode_applicable like '%$searchKey%' Or isbn like '%$searchKey%' Or author like '%$searchKey%' Or publisher like '%$searchKey%' Or edition like '%$searchKey%')";

	}

	$listingQuery="  select * from items where item_id>0   $where   $anditem_id  $anditem_name  $andbeng_name  $andhindi_name  $andkeywords  $anditem_unit  $anditem_type  $andshow_in_daily_report  $anddepartments  $andrecoverable  $anditem_code  $andcategory_id  $andbarcode_applicable  $and_isbn  $and_author $and_publisher $and_no_of_pages
	
	  and departments='$department'    order by item_id desc";
	$os->showPerPage=250;
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];


$data_rs=$os->mq('select * from item_category');
 while($rs=$os->mfa($data_rs))
{
 $os->category_list[$rs['item_category_id']]=$rs['category_name'];
}



?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >

	                            <td >#</td>
									<td >Action </td>



<td ><b>Item id</b></td>
  <td ><b>Name</b></td>
   <td ><b>author</b></td>
    <td ><b>publisher</b></td>
    <td ><b>Edition</b></td>



  <td ><b>Photo</b></td>

   <td ><b>Added By</b></td>


						       	</tr>



							<?php

						  	 $serial=$os->val($resource,'serial');

							while($record=$os->mfa( $rsRecords)){
							 $serial++;




							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td>
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_itemsGetById('<? echo $record['item_id'];?>')" >Edit</a></span>  <? } ?>  </td>

<td><?php echo $record['item_id']?>


</td>
  <td><b><?php echo $record['item_name']?> </b>
  <br /> <span style="font-size:11px">ISBN: <?php echo $record['isbn']?>   &nbsp; no of page: <?php echo $record['no_of_pages']?> </span>


  </td>
   <td><?php echo $record['author']?> </td>
   <td><?php echo $record['publisher']?> </td>
<td><?php echo $record['edition']?> </td>





  <td>
    <? if($record['photo']){ ?>
  <img src="<?php  echo $site['url'].$record['photo']; ?>"  height="70" width="70" />
   <? } ?>

  </td>
  <td>  <? echo  $user_admins[$record['addedBy']]; ?> </td>
  </tr>
 <?	  } ?>





		</table>



		</div>

		<br />



<?php
exit();

}






if($os->get('WT_itemsEditAndSave')=='OK')
{
 $item_id=$os->post('item_id');



 $dataToSave['item_name']=addslashes($os->post('item_name'));
 $dataToSave['beng_name']=addslashes($os->post('item_name'));
 $dataToSave['hindi_name']=addslashes($os->post('item_name'));
 $dataToSave['keywords']=addslashes($os->post('item_name'));
 $dataToSave['item_unit']='Pcs';
 $dataToSave['item_type']='Product';
 $dataToSave['stock_alert_quntity']=addslashes($os->post('stock_alert_quntity'));
 $dataToSave['show_in_daily_report']='No';
 $dataToSave['departments']=$department;
 $dataToSave['recoverable']='Yes';
 $photo=$os->UploadPhoto('photo',$site['root'].'wtos-images');
				   	if($photo!=''){
					$dataToSave['photo']='wtos-images/'.$photo;}
 $dataToSave['item_code']=addslashes($os->post('item_code'));
 $dataToSave['category_id']=addslashes($os->post('category_id'));
 $dataToSave['barcode_applicable']='Yes';

  $dataToSave['isbn']=addslashes($os->post('isbn'));
  $dataToSave['author']=addslashes($os->post('author'));
  $dataToSave['publisher']=addslashes($os->post('publisher'));
  $dataToSave['no_of_pages']=addslashes($os->post('no_of_pages'));
   $dataToSave['edition']=addslashes($os->post('edition'));


		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId'];

		if($item_id < 1){

		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}


          $qResult=$os->save('items',$dataToSave,'item_id',$item_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
		if($qResult)
				{
		if($item_id>0 ){ $mgs= " Data updated Successfully";}
		if($item_id<1 ){ $mgs= " Data Added Successfully"; $item_id=  $qResult;}

		  $mgs=$item_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";

		}
		//_d($dataToSave);
		echo $mgs;

exit();

}

if($os->get('WT_itemsGetById')=='OK')
{
		$item_id=$os->post('item_id');

		if($item_id>0)
		{
		$wheres=" where item_id='$item_id'";
		}
	    $dataQuery=" select * from items  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);


 $record['item_name']=$record['item_name'];
 $record['beng_name']=$record['beng_name'];
 $record['hindi_name']=$record['hindi_name'];
 $record['keywords']=$record['keywords'];
 $record['item_unit']=$record['item_unit'];
 $record['item_type']=$record['item_type'];
 $record['stock_alert_quntity']=$record['stock_alert_quntity'];
 $record['show_in_daily_report']=$record['show_in_daily_report'];
 $record['departments']=$record['departments'];
 $record['recoverable']=$record['recoverable'];
 if($record['photo']!=''){
						$record['photo']=$site['url'].$record['photo'];}
 $record['item_code']=$record['item_code'];
 $record['category_id']=$record['category_id'];
 $record['barcode_applicable']=$record['barcode_applicable'];



		echo  json_encode($record);

exit();

}


if($os->get('WT_itemsDeleteRowById')=='OK')
{

$item_id=$os->post('item_id');
 if($item_id>0){
 $updateQuery="delete from items where item_id='$item_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}


if($os->get('validate_item_meta')=='OK')
{
// $meta_defination_list[1]=array('ISBN','Author','Edition','Publisher');
$item_id=$os->post('item_id');
$category_id=$os->post('category_id');
$container_div=$os->post('container_div');
$save_meta=$os->post('save_meta');

$meta_defination=$meta_defination_list[$category_id];



if($save_meta=='SAVE')
{

	$dataToSave_list=$os->post();
	unset($dataToSave_list['item_id']);
	unset($dataToSave_list['category_id']);
	unset($dataToSave_list['container_div']);
	unset($dataToSave_list['save_meta']);

	 if($item_id>0)
	 {
	      $del_query="delete from item_meta where item_id='$item_id' ";
		  $os->mq($del_query);

			   foreach($dataToSave_list as $item_meta_key=>$item_meta_value)
			   {

					$dataToSave=array();
					$dataToSave['item_id']=$item_id;
					$dataToSave['item_meta_key']=$item_meta_key;
					$dataToSave['item_meta_value']=$item_meta_value;
					$qResult=$os->save('item_meta',$dataToSave,'item_meta_id','');
			   }



	 }



}


$meta_data=array();
$data_rs=$os->rowsByField('','item_meta','item_id',$item_id,$where='',$orderby='',$limit='');
while($rs=$os->mfa($data_rs))
{
 $meta_data[$rs['item_meta_key']]=$rs['item_meta_value'];
}

$p=$os->post();

//item_meta_id 	item_id 	item_meta_key 	item_meta_value
 echo '#output#';

 ?>
 <? if($category_id==1){ ?>
 <form id="meta_data_form">
 <table>
 <tr> <td style="width:90px;">Author </td> <td><input type="text" class="textboxxx  fWidth " value="<? echo $os->val($meta_data,'Author'); ?>" style="width:350px;" name="Author" /></td> </tr>
 <tr> <td>Edition </td> <td><input type="text" class="textboxxx  fWidth " value="<? echo $os->val($meta_data,'Edition'); ?>" name="Edition" /></td> </tr>
 <tr> <td>Publisher </td> <td><input type="text" class="textboxxx  fWidth " value="<? echo $os->val($meta_data,'Publisher'); ?>" name="Publisher" /></td> </tr>
 <tr> <td>ISBN </td> <td><input type="text" class="textboxxx  fWidth " value="<? echo $os->val($meta_data,'ISBN'); ?>" name="ISBN" /></td> </tr>

 <tr> <td>NO Of Pages </td> <td><input type="text" class="textboxxx  fWidth " value="<? echo $os->val($meta_data,'pages_no'); ?>" name="pages_no" /></td> </tr>

 </table>
 </form>


 <?
 }
 //_d($meta_data);


 echo '#output#';


 exit();
}



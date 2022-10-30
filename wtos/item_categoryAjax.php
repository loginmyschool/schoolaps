<?
/*
   # wtos version : 1.1
   # page called by ajax script in item_categoryDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_item_categoryListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');


$andcategory_name=  $os->postAndQuery('category_name_s','category_name','%');
$andcategory_keywords=  $os->postAndQuery('category_keywords_s','category_keywords','%');


	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( category_name like '%$searchKey%' Or category_keywords like '%$searchKey%' )";

	}

	$listingQuery="  select * from item_category where item_category_id>0   $where   $andcategory_name  $andcategory_keywords     order by item_category_id desc";

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];


?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >

	                            <td >#</td>
									<td >Action </td>



<td ><b>Name</b></td>
  <td ><b>Keywords</b></td>



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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_item_categoryGetById('<? echo $record['item_category_id'];?>')" >Edit</a></span>  <? } ?>  </td>

<td><?php echo $record['category_name']?> </td>
  <td><?php echo $record['category_keywords']?> </td>


				 </tr>
                          <?


						  } ?>





		</table>



		</div>

		<br />



<?php
exit();

}






if($os->get('WT_item_categoryEditAndSave')=='OK')
{
 $item_category_id=$os->post('item_category_id');



 $dataToSave['category_name']=addslashes($os->post('category_name'));
 $dataToSave['category_keywords']=addslashes($os->post('category_keywords'));




		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId'];

		if($item_category_id < 1){

		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}


          $qResult=$os->save('item_category',$dataToSave,'item_category_id',$item_category_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
		if($qResult)
				{
		if($item_category_id>0 ){ $mgs= " Data updated Successfully";}
		if($item_category_id<1 ){ $mgs= " Data Added Successfully"; $item_category_id=  $qResult;}

		  $mgs=$item_category_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";

		}
		//_d($dataToSave);
		echo $mgs;

exit();

}

if($os->get('WT_item_categoryGetById')=='OK')
{
		$item_category_id=$os->post('item_category_id');

		if($item_category_id>0)
		{
		$wheres=" where item_category_id='$item_category_id'";
		}
	    $dataQuery=" select * from item_category  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);


 $record['category_name']=$record['category_name'];
 $record['category_keywords']=$record['category_keywords'];



		echo  json_encode($record);

exit();

}


if($os->get('WT_item_categoryDeleteRowById')=='OK')
{

$item_category_id=$os->post('item_category_id');
 if($item_category_id>0){
 $updateQuery="delete from item_category where item_category_id='$item_category_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}


<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
if($os->get('video_listing')=='OK'){
	$where='';
	$showPerPage= $os->post('showPerPage');
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
		$where ="and (show_in_home like '%$searchKey%' Or title like '%$searchKey%' Or active_status like '%$searchKey%' Or view_order like '%$searchKey%')";
		
	}	
	$listingQuery="  select * from video where video_id>0 $where order by view_order asc, video_id desc";
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	?>
	<div class="listingRecords">
		<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
		<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
			<tr class="borderTitle" >				
				<td >#</td>
				<td >Action </td>			
				<td ><b>Title</b></td>
				<td ><b>Thumbnail</b></td> 
				<td ><b>Show In Home</b></td>  
				<td ><b>Active</b></td>  
				<td ><b>view_order</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_videoGetById('<? echo $record['video_id'];?>')" >Edit</a></span>  <? } ?>  </td>
							<td><?php echo $record['title']?> </td> 
							<td><img src="<?php  echo $record['youtubeThumbLink']; ?>"  height="70" width="70" /></td>	
							<td> <? if(isset($os->noYes[$record['show_in_home']])){ echo  $os->noYes[$record['show_in_home']]; } ?></td> 						
							<td> <? if(isset($os->activeStatus[$record['active_status']])){ echo  $os->activeStatus[$record['active_status']]; } ?></td> 
							<td><?php echo $record['view_order']?> </td> 
						</tr>
					<? } ?>
				</table> 
			</div>		
			<br />			
			<?php 
			exit();			
		}



		if($os->get('videoEditAndSave')=='OK'){
			error_reporting(0);
			$video_id=$os->post('video_id');			
			$dataToSave['title']=addslashes($os->post('title'));			
			$dataToSave['active_status']=addslashes($os->post('active_status')); 
			$dataToSave['show_in_home']=addslashes($os->post('show_in_home')); 

			$dataToSave['view_order']=addslashes($os->post('view_order')); 
			$dataToSave['youtubeLink']=addslashes($os->post('youtubeLink'));
			$videoA=explode("watch?v=",$os->post('youtubeLink'));
			$videoId=$videoA[1];
			$youtubeThumbLink="https://img.youtube.com/vi/".$videoId."/hqdefault.jpg";
			$dataToSave['youtubeThumbLink']=addslashes($youtubeThumbLink);
			$dataToSave['videoPlayLink']=addslashes($videoA[0].'embed/'.$videoA[1]);
			$dataToSave['modifyDate']=$os->now();
			$dataToSave['modifyBy']=$os->userDetails['adminId']; 
			if($video_id < 1){
				$dataToSave['addedDate']=$os->now();
				$dataToSave['addedBy']=$os->userDetails['adminId'];
			}
			$qResult=$os->save('video',$dataToSave,'video_id',$video_id);	
			if($qResult){
				if($video_id>0 ){ $mgs= " Data updated Successfully";}
				if($video_id<1 ){ $mgs= " Data Added Successfully"; $video_id=  $qResult;}          	
				$mgs=$video_id."#-#".$mgs;
			}
			else{
				$mgs="Error#-#Problem Saving Data.";          	
			}
			echo $mgs;	
			exit();

		} 

		if($os->get('WT_videoGetById')=='OK'){
			$video_id=$os->post('video_id');
			if($video_id>0){
				$wheres=" where video_id='$video_id'";
			}
			$dataQuery=" select * from video  $wheres ";
			$rsResults=$os->mq($dataQuery);
			$record=$os->mfa( $rsResults);
			echo  json_encode($record);	 
			exit();

		}


		if($os->get('WT_videoDeleteRowById')=='OK'){ 
			$video_id=$os->post('video_id');
			if($video_id>0){
				$updateQuery="delete from video where video_id='$video_id'";
				$os->mq($updateQuery);
				echo 'Record Deleted Successfully';
			}
			exit();
		}


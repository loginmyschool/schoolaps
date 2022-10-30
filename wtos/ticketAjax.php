<? 
/*
   # wtos version : 1.1
   # page called by ajax script in ticketDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 $os->ticket_status=array(''=>'','Open'=>'Open','Close'=>'Close','Reopen'=>'Reopen');
 $os->ticket_status_rely=array(''=>'','Close'=>'Close','Reopen'=>'Reopen');
 
 /*$os->ticket_status_color=array(''=>'','Open'=>'#f52003','Close'=>'#07da1a','Reopen'=>'#f3630c');
 $os->ticket_status_rely_color=array(''=>'','Close'=>'#07da1a','Reopen'=>'#f3630c');
 */

 
 
 
?><?

if($os->get('WT_ticketListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andticket_id=  $os->postAndQuery('ticket_id_s','ticket_id','%');
$andbranch_id=  $os->postAndQuery('branch_id_s','branch_id','%');
$andticketby_admin_id=  $os->postAndQuery('ticketby_admin_id_s','ticketby_admin_id','%');

    $f_ticket_date_s= $os->post('f_ticket_date_s'); $t_ticket_date_s= $os->post('t_ticket_date_s');
   $andticket_date=$os->DateQ('ticket_date',$f_ticket_date_s,$t_ticket_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andsubject=  $os->postAndQuery('subject_s','subject','%');
$andmessage=  $os->postAndQuery('message_s','message','%');
$andticket_status=  $os->postAndQuery('ticket_status_s','ticket_status','%');
$andnote=  $os->postAndQuery('note_s','note','%');



$and_admin_id ='';

if($os->userDetails['adminType']!='Super Admin')
{
 $admin_id=$os->userDetails['adminId'];
  $and_admin_id =" and ticketby_admin_id ='$admin_id' ";
 } 


	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( ticket_id like '%$searchKey%' Or branch_id like '%$searchKey%' Or ticketby_admin_id like '%$searchKey%' Or subject like '%$searchKey%' Or message like '%$searchKey%' Or ticket_status like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from ticket where ticket_id>0   $where   $andticket_id  $andbranch_id  $andticketby_admin_id  $andticket_date  $andsubject  $andmessage  $andticket_status  $andnote  $and_admin_id     order by ticket_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
	 
	 
	 
	 $branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
    $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'];
}
 
 $admin_arr=array();
$admin_arr_q="select  name , adminId from admin ";
$admin_arr_q_rs= $os->mq($admin_arr_q);
while ($admin_row = $os->mfa($admin_arr_q_rs))
{
    $admin_arr[$admin_row['adminId']]=$admin_row['name'];
}
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									
								

	 <td style="width:90px;" ><b>Dated</b></td>										
<td ><b>TICKET ID</b></td>  
   
  <td ><b>Ticket By</b></td>  
   
 
  <td ><b>Subject</b></td>  
   
  						
		<td ><b>Status</b></td>  					 
 <td >Action </td>
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								$statuscolor='color:#009900';
								if($record['ticket_status']!='Close')
								{
								$statuscolor='color:#FF0000';
								 
								}
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
	<td><?php echo $os->showDate($record['ticket_date']);?> </td>  						
    <td style="color:#2222FF; font-weight:bold; font-size:15px;"><?php echo $record['ticket_id']?> </td>  
  
  <td title=" <?php echo $branch_code_arr[$record['branch_id']];?>" style="font-size:11px;"><?php echo $admin_arr[$record['ticketby_admin_id']];?> 
      
  </td>  
   <td style=" font-size:11px;"><?php echo $record['subject']?> </td>  
   <td style=" font-weight:bold; <? echo $statuscolor ; ?>"> <? if(isset($os->ticket_status[$record['ticket_status']])){ echo  $os->ticket_status[$record['ticket_status']]; } ?></td> 
  
  
  
						<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_ticketGetById('<? echo $record['ticket_id'];?>')" >View</a></span>  <? } ?>  </td>
										
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php  
exit();
	
}
 





if($os->get('WT_ticketEditAndSave')=='OK')
{
 $ticket_id=$os->post('ticket_id');
 
  $dataToSave['subject']=addslashes($os->post('subject')); 
  $dataToSave['message']=addslashes($os->post('message')); 
		 


 $dataToSave['ticketby_admin_id']=$os->userDetails['adminId']; 
 $dataToSave['ticket_date']= date('Y-m-d H:i:s');
 $dataToSave['branch_id']=$os->userDetails['branch_code'];
 $dataToSave['ticket_status']='Open'; 
 $dataToSave['ticket_status_date']=date('Y-m-d H:i:s');
 $dataToSave['statusby_admin_id']=$os->userDetails['adminId']; 
 $dataToSave['note']='';

		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($ticket_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('ticket',$dataToSave,'ticket_id',$ticket_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		  
		  
		  
		if($qResult)  
				{
				
				
				
				
				
		if($ticket_id>0 ){ $mgs= " Data updated Successfully";}
		if($ticket_id<1 ){ $mgs= " Data Added Successfully"; $ticket_id=  $qResult;	
		
		
		}
		
		// update status
		if($ticket_id)
		{
		        $dataToSave_ticket_status_history['ticket_id']=$ticket_id ;
				$dataToSave_ticket_status_history['ticket_status']=$dataToSave['ticket_status'] ;
				$dataToSave_ticket_status_history['ticket_status_date']=date('Y-m-d H:i:s');
				$dataToSave_ticket_status_history['statusby_admin_id']=$os->userDetails['adminId']; 				
				$qResult=$os->save('ticket_status_history',$dataToSave_ticket_status_history,'ticket_status_history_id',$ticket_status_history_id); 
				
				
				
				
				
				
				$file_1=$os->UploadPhoto('file_1',$site['root'].'ticket-images');
				if($file_1!='')
				{
					$ticket_document_id=0;
					$dataToSave_doc=array();
					
					$dataToSave_doc['ticket_id']=$ticket_id ;
					$dataToSave_doc['ticket_reply_id']='' ;
					$dataToSave_doc['admin_id']=$ticket_id ;				
					$dataToSave_doc['type']='' ;
					$dataToSave_doc['title']='Doc 1' ;	
								
					$dataToSave_doc['file_link']='ticket-images/'.$file_1;				
					$ticket_document_id=$os->save('ticket_document',$dataToSave_doc,'ticket_document_id',$ticket_document_id); 
					
				}
				
				
				
				$file_2=$os->UploadPhoto('file_2',$site['root'].'ticket-images');
				if($file_2!='')
				{
					$ticket_document_id=0;
					$dataToSave_doc=array();
					
					$dataToSave_doc['ticket_id']=$ticket_id ;
					$dataToSave_doc['ticket_reply_id']='' ;
					$dataToSave_doc['admin_id']=$ticket_id ;				
					$dataToSave_doc['type']='' ;
					$dataToSave_doc['title']='Doc 2' ;	
								
					$dataToSave_doc['file_link']='ticket-images/'.$file_2;				
					$ticket_document_id=$os->save('ticket_document',$dataToSave_doc,'ticket_document_id',$ticket_document_id); 
					
				}
				
				
				
				
				
		 
		}
		
		
		  $mgs=$ticket_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();

/* $dataToSave['branch_id']=addslashes($os->post('branch_id')); 
 $dataToSave['ticketby_admin_id']=addslashes($os->post('ticketby_admin_id')); 
 $dataToSave['ticket_date']= $os->saveDate($os->post('ticket_date')); 

 $dataToSave['ticket_status']=addslashes($os->post('ticket_status')); 
 $dataToSave['ticket_status_date']=$os->saveDate($os->post('ticket_status_date')); 
 $dataToSave['statusby_admin_id']=addslashes($os->post('statusby_admin_id')); 
 $dataToSave['note']=addslashes($os->post('note'));*/ 

	
} 
 
if($os->get('WT_ticketGetById')=='OK')
{
		$ticket_id=$os->post('ticket_id');
		
		if($ticket_id>0)	
		{
		$wheres=" where ticket_id='$ticket_id'";
		}
	    $dataQuery=" select * from ticket  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['branch_id']=$record['branch_id'];
 $record['ticketby_admin_id']=$record['ticketby_admin_id'];
 $record['ticket_date']=$os->showDate($record['ticket_date']); 
 $record['subject']=$record['subject'];
 $record['message']=$record['message'];
 $record['ticket_status']=$record['ticket_status'];
 $record['ticket_status_date']=$os->showDate($record['ticket_status_date']); 
 $record['statusby_admin_id']=$record['statusby_admin_id'];
 $record['note']=$record['note'];
 
 $dataQuery="select * from ticket_reply  where ticket_id='$ticket_id' order by dated asc";
 $reply_rsResults=$os->mq($dataQuery);
 
 
$dataQuery="select * from ticket_document  where ticket_id='$ticket_id' ";
$image_rsResults=$os->mq($dataQuery);
 
 
 
 
 
  $branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
    $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'];
}
 
 $admin_arr=array();
$admin_arr_q="select  name , adminId from admin ";
$admin_arr_q_rs= $os->mq($admin_arr_q);
while ($admin_row = $os->mfa($admin_arr_q_rs))
{
    $admin_arr[$admin_row['adminId']]=$admin_row['name'];
	 
}

$mycolor_ticket='#555555';
if($record['ticketby_admin_id']!=$os->userDetails['adminId']){  $mycolor_ticket='#FB5200'; }


 
//_d($record);
?>
<div class="ajaxViewMainTableTDListSearch" > 
<div style="text-align:right; font-size:25px;" > <span style="color:#999999; font-size:16px;"> Ticket ID: </span><span style="color:#0000FF"><? echo $ticket_id ?> </span>  <span style="color:#999999;font-size:16px;">Status: </span> <span style="color:#FF9900"> <? echo  $record['ticket_status'] ?> </span> <span  class="actionLink" style="margin-top:-5px;font-size:16px;"  ><a href="javascript:void(0)"  onclick="WT_ticketGetById('<? echo $ticket_id ?>')" >Refresh</a></span></div>
</div>



<div class="ajaxViewMainTableTDListSearch"> 


<h2 style="background:#FFFFFF; padding:6px; color:#005BB7;"> <? echo  $record['subject'] ?> </h2>
<p style="background:#FFFFFF; margin-top:6px;padding:4px; font-size:14px;"> <? echo  nl2br($record['message']); ?> <br />



<?
if($image_rsResults){
?> <? 

while ($row_img = $os->mfa($image_rsResults))
{

 

	if($row_img['file_link']!='')
	{
	 ?>
	 <a target="_blank" href="<? echo $site['url'].$row_img['file_link']; ?>" > <? echo $row_img['title']; ?></a> <br />
	 <? 
	}

?><? } 

}
?>



</p>
 <div style="text-align:right; margin-top:2px;" >

<span title="   <? echo  $branch_code_arr[$record['branch_id']]; ?>" style="font-style:italic; color:<? echo $mycolor_ticket ?>;">By :  <? echo  $admin_arr[$record['ticketby_admin_id']]; ?></span>&nbsp;&nbsp; 
 
<span style="font-style:italic; color:#555555;">Dated :  <? echo  $record['ticket_date'] ?></span>  

</div>
</div>
<? 
while ($row = $os->mfa($reply_rsResults))
{
  $mycolor_reply='#555555';
if($row['replyby_admin_id']!=$os->userDetails['adminId']){$mycolor_reply='#FB5200';  }
     ?>
	 
	 <div class="ajaxViewMainTableTDListSearch" > 
	 
 <p style="background:#FFFFFF; margin-top:6px;padding:4px;font-size:14px;  "> <? echo  nl2br($row['reply_msg']); ?> </p>
 
 <div style="text-align:right; margin-top:2px;" >

<span style="font-style:italic; color:<? echo $mycolor_reply ?>;">   <? echo  $admin_arr[$row['replyby_admin_id']]; ?></span> &nbsp;&nbsp; 
<span style="font-style:italic; color:#555555;">Dated :  <? echo  $os->showDate($row['dated']) ?></span> 
</div>
</div>
	 <? 
}


if($os->userDetails['adminType']!='Super Admin')
{
    $os->ticket_status_rely=array('Reopen'=>'Reopen','Close'=>'Close');
}

?>
 
<div > 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" >Status <br />  <select name="ticket_status_reply" id="ticket_status_reply" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->ticket_status_rely);	?></select>
										    
										  </td>
    <td>Reply<br />
	<textarea name="reply_msg" id="reply_msg" style="width:400px; height:50px;"></textarea><br />
 
   <input type="button" style="cursor:pointer;" value="Save" onclick="save_reply('<? echo $ticket_id ?>')">
</td>
  </tr>
</table>

         
										  
										  




 </div>
<?
		
 
exit();
	
}
 
 
if($os->get('WT_ticketDeleteRowById')=='OK')
{ 

$ticket_id=$os->post('ticket_id');
 if($ticket_id>0){
 $updateQuery="delete from ticket where ticket_id='$ticket_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}

if($os->get('WT_save_reply')=='OK' && $os->post('WT_save_reply')=='OK')
{
  $ticket_reply_id=0;// only entry
  
  $ticket_id=$os->post('ticket_id');
  $ticket_status_reply=$os->post('ticket_status_reply');
  
  $dataToSave['ticket_id']= $ticket_id; 
  $dataToSave['replyby_admin_id']=$os->userDetails['adminId']; 
  
  
  $dataToSave['reply_msg']=addslashes($os->post('reply_msg'));  
  
  if($ticket_status_reply!='' )
  {
     if(trim($dataToSave['reply_msg'])!=''){$dataToSave['reply_msg']=$dataToSave['reply_msg'].'<br><br>';}
	 
	 $dataToSave['reply_msg'] = $dataToSave['reply_msg'] .' '.'<span style="color:#0033FF; font-style:italic"> Ticket status Change to ' . $ticket_status_reply.'</span>' ;
  }
  
  $dataToSave['dated']= date('Y-m-d H:i:s');
  
   
		
		 if(trim($dataToSave['reply_msg'])!=''){
             $qResult=$os->save('ticket_reply',$dataToSave,'ticket_reply_id',$ticket_reply_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		  }
		  
		  if($ticket_status_reply!='' )
		  {
								
				$dataToSave_ticket['ticket_status']=$ticket_status_reply ;
				$qResult=$os->save('ticket',$dataToSave_ticket,'ticket_id',$ticket_id); 
				
				 	 	 	 	 	 
					
				$dataToSave_ticket_status_history['ticket_id']=$ticket_id ;
				$dataToSave_ticket_status_history['ticket_status']=$ticket_status_reply ;
				$dataToSave_ticket_status_history['ticket_status_date']=date('Y-m-d H:i:s');
				$dataToSave_ticket_status_history['statusby_admin_id']=$os->userDetails['adminId']; 				
				$qResult=$os->save('ticket_status_history',$dataToSave_ticket_status_history,'ticket_status_history_id',$ticket_status_history_id); 
				  
		  }
		  
		  
		  
		  
		  
		if($qResult)  
				{
		if($ticket_reply_id>0 ){ $mgs= " Data updated Successfully";}
		if($ticket_reply_id<1 ){ $mgs= " Data Added Successfully"; $ticket_id=  $qResult;}
		
		  $mgs=$ticket_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		 
		echo $mgs;		
 
exit();

 

	
} 
 

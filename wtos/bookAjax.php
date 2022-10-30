<? 
/*
   # wtos version : 1.1
   # page called by ajax script in bookDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_bookListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andcode=  $os->postAndQuery('code_s','code','%');
$andname=  $os->postAndQuery('name_s','name','%');
$andauthor=  $os->postAndQuery('author_s','author','%');
$andISBN=  $os->postAndQuery('ISBN_s','ISBN','%');
$andpublisher=  $os->postAndQuery('publisher_s','publisher','%');
$andedition=  $os->postAndQuery('edition_s','edition','%');
$andedition_date=  $os->postAndQuery('edition_date_s','edition_date','%');
$andbook_category_id=  $os->postAndQuery('book_category_id_s','book_category_id','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( code like '%$searchKey%' Or name like '%$searchKey%' Or author like '%$searchKey%' Or ISBN like '%$searchKey%' Or publisher like '%$searchKey%' Or edition like '%$searchKey%' Or edition_date like '%$searchKey%' Or book_category_id like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from book where book_id>0   $where   $andcode  $andname  $andauthor  $andISBN  $andpublisher  $andedition  $andedition_date  $andbook_category_id     order by book_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Code</b></td>  
  <td ><b>Name</b></td>  
  <td ><b>Image</b></td>  
  <td ><b>Author</b></td>  
  <td ><b>ISBN</b></td>  
  <td ><b>Publisher</b></td>  
  <td ><b>Edition</b></td>  
  <td ><b>Edition_date</b></td>  
  <td ><b>Book category id</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_bookGetById('<? echo $record['book_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['code']?> </td>  
  <td><?php echo $record['name']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['author']?> </td>  
  <td><?php echo $record['ISBN']?> </td>  
  <td><?php echo $record['publisher']?> </td>  
  <td><?php echo $record['edition']?> </td>  
  <td><?php echo $record['edition_date']?> </td>  
  <td>  <? echo 
	$os->rowByField('name','book_category','book_category_id',$record['book_category_id']); ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_bookEditAndSave')=='OK')
{
 $book_id=$os->post('book_id');
 
 
		 
 $dataToSave['code']=addslashes($os->post('code')); 
 $dataToSave['name']=addslashes($os->post('name')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['author']=addslashes($os->post('author')); 
 $dataToSave['ISBN']=addslashes($os->post('ISBN')); 
 $dataToSave['publisher']=addslashes($os->post('publisher')); 
 $dataToSave['edition']=addslashes($os->post('edition')); 
 $dataToSave['edition_date']=addslashes($os->post('edition_date')); 
 $dataToSave['book_category_id']=addslashes($os->post('book_category_id')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($book_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('book',$dataToSave,'book_id',$book_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($book_id>0 ){ $mgs= " Data updated Successfully";}
		if($book_id<1 ){ $mgs= " Data Added Successfully"; $book_id=  $qResult;}
		
		  $mgs=$book_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_bookGetById')=='OK')
{
		$book_id=$os->post('book_id');
		
		if($book_id>0)	
		{
		$wheres=" where book_id='$book_id'";
		}
	    $dataQuery=" select * from book  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['code']=$record['code'];
 $record['name']=$record['name'];
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}
 $record['author']=$record['author'];
 $record['ISBN']=$record['ISBN'];
 $record['publisher']=$record['publisher'];
 $record['edition']=$record['edition'];
 $record['edition_date']=$record['edition_date'];
 $record['book_category_id']=$record['book_category_id'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_bookDeleteRowById')=='OK')
{ 

$book_id=$os->post('book_id');
 if($book_id>0){
 $updateQuery="delete from book where book_id='$book_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

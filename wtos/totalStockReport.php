<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
// config 
$DivIds['AJAXPAGE']='';
$listPAGE='totalStockReport';
$primeryTable='stock';
$primeryField='stockId';
$listHeader='Stock List';
 
$DivIds['EDITPAGE']=$site['url'].$DivIds['AJAXPAGE'].'.php?'.$os->addParams(array('hideTopLeft'),'').'editRowId=';
$listPAGEUrl=$listPAGE.'.php?'.$os->addParams(array('hideTopLeft'),'');
##  delete row

 
$andproductIdA=  $os->andField('productId','productId',$primeryTable,'=');
  $productId=$andproductIdA['value']; $andproductId=$andproductIdA['andField'];	 
$andquantityA=  $os->andField('quantity','quantity',$primeryTable,'=');
  $quantity=$andquantityA['value']; $andquantity=$andquantityA['andField'];	 
$andmakeA=  $os->andField('make','make',$primeryTable,'%');
  $make=$andmakeA['value']; $andmake=$andmakeA['andField'];	 
$andmodelA=  $os->andField('model','model',$primeryTable,'=');
  $model=$andmodelA['value']; $andmodel=$andmodelA['andField'];	
  
$typeA=  $os->andField('type','type',$primeryTable,'%');
  $type=$typeA['value']; $andProductType=$typeA['andField'];	
  
  
      
       if($_GET['sDate']=='')
       {
            $_GET['sDate']=date('d-m-Y');
       }
       if($_GET['eDate']=='')
       {
            $_GET['eDate']=date('d-m-Y');
       }
  	 $sDate= $os->setNget('sDate',$primeryTable);  // $_GET['sDate'];
     $eDate=$os->setNget('eDate',$primeryTable);
	 $sDatesDb=$os->dateC($sDate,'dmy','yyyy-mm-dd 00:00:00');
  	 $eDateDb=$os->dateC($eDate,'dmy','yyyy-mm-dd 23:59:59');
if($sDate != ""){
	$andPurchaseStartDate = ' and rbpurchaseDate < ' . ' " ' .$sDatesDb. ' " ';
	$andBilledStartDate = ' and billDate < ' . ' " ' . $sDatesDb. ' " ';
}
if($eDate != ""){
	$andPurchaseEndDate = ' and rbpurchaseDate <= ' . ' " ' . $eDateDb. ' " ';
	$andBilledendDate = ' and billDate  <= ' . ' " ' . $eDateDb. ' " ';
}
    // echo $andpurchaseDate=$os->DateQ('purchaseDate',$sDate,$eDate,$sTime='00:00:00',$eTime='00:00:00');
  // echo  $andorderDateDate=$os->DateQ('orderDate',$sDate,$eDate,$sTime='00:00:00',$eTime='00:00:00');
    //echo  $andSdate = $os->Date($sDate)
  
 // $type = varG('type');
 // $andProductType = '';
  
  if($type!=''  && $notused){
  	$productString = '';
	
  	$productStringA = $os->getMe("SELECT GROUP_CONCAT(rbproductId) as productString FROM product WHERE type='$type' ");
	if(is_array($productStringA)){$productString = $productStringA[0]['productString'];
	if($productString!=''){$andProductType = "AND rbproductId IN($productString)";}
	else{$andProductType = "AND rbproductId='$productString'";}}	
  }
 // $listingQuery=" select * from $primeryTable where $primeryField>0   $andproductId  $andquantity  $andmake  $andmodel  $andProductType  $andActive order by quantity ASC, $primeryField desc  ";
  $prodQ = "select * from rbproduct where rbproductId>0    $andmake  $andmodel  $andProductType $andproductId  $andActive order by type";
$stockSession['prodQ']=$prodQ ;
##  fetch row
//$recordsA=$os->pagingResult($listingQuery,$recordPerPage);
//$records=$recordsA['records'];
$os->setFlash($flashMsg);
//tinyMce();
//searching......
?>
	<table class="container">
				<tr>
					<td  class="leftside">
 
						<?php  include('osLinks.php'); ?>
  
					</td>
			  <td  class="middle" style="padding-left:5px;">
 
			  <div class="listHeader"> <?php  echo $listHeader; ?></div>
 
			  <!--  ggggggggggggggg   -->
 
			  <div class="headertext">Search Option   <span style="float:right">Record per page  <?php  echo $recordPerPageDDS; ?></span></div>
 
			  <div class="searchB">
<table cellpadding="0" cellspacing="0">
	<tr>
	<td class="buttonSa">
 
 Product:<select name="productId" id="productId" class="SelectBox">	
 <option value="">All</option>																					
                                        
										<?php echo $os->optionsHTMLExtraText($productId,'rbproductId','name','model','rbproduct',$where='',$orderby='name ASC',$limit='');?>
										</select>&nbsp; 
  
   Model:<input type="text" name="model" id="model" value="<?php echo $model?>" style="width:100px;" /> &nbsp;
 
  Product Type:<select id="type"  name="type" class="SelectBox">
 
			<option value="">All</option>										
 
			<?php $os->onlyOption($os->productType,$type);?>
 		</select>&nbsp;
		
		
		 From:<input type="text" name="sDate" title="Choose Purchase Date"  readonly="1" class="dtpk" id="sDate" value="<?php echo $sDate?>" style="width:80px; cursor:pointer;"/>&nbsp;
 To:<input type="text" name="eDate" title="Choose Purchase Date"  readonly="1" class="dtpk" id="eDate" value="<?php echo $eDate?>" style="width:80px; cursor:pointer;"/>&nbsp;
		
		<div style="display:none">
		 Quantity:<input type="text" name="quantity" id="quantity" value="<?php echo $quantity?>" style="width:100px;" /> &nbsp;  
   Make:<input type="text" name="make" id="make" value="<?php echo $make?>" style="width:100px;" /> &nbsp;  
		</div>
	 
	
	<a  class="searchButton" href="javascript:void(0)" onclick="javascript:searchText()">Search</a>
	&nbsp;
	<a  href="javascript:void(0)" class="searchReset" onclick="javascript:searchReset()">Reset</a>
	
	</td>
	</tr>
</table>
				</div>
				 <div class="headertext" style="margin-top:10px;">Total <? echo $os->paging->p['count']; ?>
				&nbsp;  &nbsp;  &nbsp;  <a class="tlinkCss refresh" href=""   style="text-decoration:none; color:#000000"> Refresh </a> &nbsp;  &nbsp;  &nbsp; 
					<!-- <a class="tlinkCss add" href="javascript:void(0)" onclick="os.editRecord('<? echo $DivIds['EDITPAGE']?>0') " style="text-decoration:none; color:#FF0000; background-color:#FFFF33; font-weight:bold;"> Add Record </a> -->  </div>
				 <style>.listTable td{text-align:center;}</style>
				 <table  border="0" cellspacing="0" cellpadding="0" class="listTable" >
							<tr class="borderTitle" >
                            
                            <td >#</td>
                            <td ><b>Product</b></td>  
							<td ><b>Type</b></td>  
                         <!--   <td ><b>Total Purches</b></td>  
                            <td ><b>Total Billed</b></td>  
                            <td ><b>Stock</b></td> -->
                            <td ><b>Onening Stock</b></td>
                            <td ><b>Purchase</b></td>
                            <td ><b>Total Stock</b></td>
                            <td ><b>Billed</b></td>  
                            <td ><b>Closeing Sock</b></td>  
							<?php
								
								// opening Stock 
								  $opneningPurchesesQ ="select P.rbproductId , sum(P.quantity) purchStartQunt from rbpurchasedetails P where P.rbpurchaseId IN(select Pu.rbpurchaseId from rbpurchase Pu where rbpurchaseId >0 $andPurchaseStartDate) and P.deleted!='yes' group by P.rbproductId ";
								 
								$opnStockRs = $os->mq($opneningPurchesesQ);
								$openingPurchaseRecord = array();
								
								while($row = $os->mfa($opnStockRs))
								{
									//_d($row);
									$openingPurchaseRecord [$row['rbproductId']] = $row['purchStartQunt'];
									
								}
$stockSession['openingPurchaseRecord']=$openingPurchaseRecord ;
									//_d($openingPurchaseRecord);
								  $billedStartQuntQ ="select OrdDet.rbproductId , sum(OrdDet.quantity) billedStartQunt from orderdetails OrdDet where orderId IN(select Ord.orderId from orders Ord where Ord.orderId >0 and Ord.orderType='Bill' $andBilledStartDate ) and OrdDet.deleted!='yes' group by OrdDet.productId "; //and Ord.orderType='Bill'
								$ordersRs = $os->mq($billedStartQuntQ);
								$openingBilledRecord = array();
								
								 
								while($row = $os->mfa($ordersRs))
								{
									//_d($row);
									$openingBilledRecord [$row['rbproductId']] = $row['billedStartQunt'];
									
								}
$stockSession['openingBilledRecord']=$openingBilledRecord ;
								//_d($openingBilledRecord);
								
								  $closeingPurchaseQ ="select P.productId , sum(P.quantity) closeingPurchaseQuant from purchasedetails P where purchaseId IN(select Pu.purchaseId from purchase Pu where Pu.purchaseId >0 $andPurchaseEndDate) and P.deleted!='yes' group by P.productId ";
								$opnStockRs = $os->mq($closeingPurchaseQ);
								$closeingPurchaseRecord = array();
								
								while($row = $os->mfa($opnStockRs))
								{
									//_d($row);
									$closeingPurchaseRecord [$row['rbproductId']] = $row['closeingPurchaseQuant'];
									
								}
								$stockSession['closeingPurchaseRecord']=$closeingPurchaseRecord ;
								//_d($closeingPurchaseRecord);
								 
								  $closeingBilledQ ="select ordDet.productId , sum(ordDet.quantity) closeingBilledQuant from orderdetails ordDet where orderId IN(select Ord.orderId from orders Ord where Ord.orderId >0 and Ord.orderType='Bill' $andBilledendDate ) and ordDet.deleted!='yes' group by ordDet.productId "; //and Ord.orderType='Bill'
								$ordersRs = $os->mq($closeingBilledQ);
								$closeingBilledRecord = array();
								
								while($row = $os->mfa($ordersRs))
								{
									//_d($row);
									$closeingBilledRecord [$row['rbproductId']] = $row['closeingBilledQuant'];
									
								}
								$stockSession['closeingBilledRecord']=$closeingBilledRecord ;
								//_d($closeingBilledRecord);
									
$_SESSION['stockSession']=$stockSession;
//$stockSession=$_SESSION['stockSession'];
//$closeingBilledRecord=$stockSession['closeingBilledRecord'];
								
							?>
							</tr>
							<?php
														
								if($sDate == ""){
									//$openingPurchaseRecord = array();
									//$openingBilledRecord = array();
								}
							
							
							
								$c=1;
							 $i=$os->slNo();
							
								$prodResult = $os->mq($prodQ);
								while($row = $os->mfa($prodResult))
								{
									
									$opneningPurcheses=$openingPurchaseRecord[$row['rbproductId']];
									$closeingPurchase = $closeingPurchaseRecord[$row['rbproductId']];
									$openingBilles=$openingBilledRecord[$row['rbproductId']];
									$closingbilles = $closeingBilledRecord[$row['rbproductId']];
									$openingStock = $opneningPurcheses - $openingBilles ;
									$purchase = $closeingPurchase - $opneningPurcheses ;
									$totalStock = $openingStock + $purchase ;
									$billed = $closingbilles -$openingBilles ;
									$closeingStock =  $closeingPurchase - $closingbilles  ;
									
									
								 
							 ?>
							<tr class="border" id="selected<?php echo $c;?>" onclick="trSelected('<?php echo $c;?>','<?php echo count($productresult);?>');"  onmouseover="javascript:miz.switchRow('<?php echo  $DivIds['BUTTONS']; ?>')">
								<td><?php  echo $i?></td>
                                <td style="text-align:left"><?php echo $row['name'];?> <b> <?php echo $row['model'];?> </b></td>  
								 <td><?php echo $row['type'];?> </td> 
                              	<td><?php echo $openingStock ?></td> 
                                <td><?php echo $purchase ?> </td>
                                <td><?php echo $totalStock ?> </td> 
                                <td><?php echo $billed ?> </td> 
                                <td><?php echo $closeingStock ?> </td> 
                                 
							</tr>
 
							<?php $i++; $c++;
 							
 							}?>
                            
                            <tr >
                            	<td> </td>
								<td> </td>
                                <td> </td>  
                                <td><?php echo $pQtyTotal ?> </td>  
                                <td><?php echo $oQtyTotal ?></td> 
                                <td><?php echo $totalStockTotal ?> </td>  
                                 
							</tr>
                            
                            
 
						</table>
				 
				 		<?php echo $recordsA['links'];?>			
	         
	  <br />
			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
    <script>
	 function searchText()
	 {
 var productIdV= os.getVal('productId'); 
 var quantityV= os.getVal('quantity'); 
 var makeV= os.getVal('make'); 
 var modelV= os.getVal('model');
 var type= os.getVal('type');
 var sDate= os.getVal('sDate'); 
   var eDate= os.getVal('eDate'); 
 
window.location='<?php echo $listPAGEUrl; ?>productId='+productIdV +'&quantity='+quantityV+'&sDate='+sDate+'&eDate='+eDate +'&make='+makeV +'&model='+modelV +'&type='+type+'&';
	  
	 }
	function  searchReset()
	{
			
	  window.location='<?php echo $listPAGEUrl; ?>productId=&quantity=&make=&model=&type=&sDate=&eDate=&';	
	   
	
	}
		
	
	
	</script>
	
 <script>dateCalander();</script>
    
   
	<? include('bottom.php')?>
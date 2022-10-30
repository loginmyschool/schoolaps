<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='Account Summery';

$ajaxFilePath= 'canteen_item_stock_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 

$return_acc=$os->branch_access();
$and_branch='';
 if($os->userDetails['adminType']!='Super Admin')
	{
	  $selected_branch_codes=$return_acc['branches_code_str_query'];
	  $and_branch=" and branch_code IN($selected_branch_codes)";

	 }

$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
     $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}


$selected_branch_code=$os->get('branch_code');


    $from_date_s=$os->get("from_date_s");
    $to_date_s=$os->get("to_date_s");
	
	if(!isset($_GET['from_date_s'])) 
  {
  // $from_date_s=date('Y-m-d');
  }
  if(!isset($_GET['from_date_s'])) 
  {
  // $to_date_s=date('Y-m-d');
  }
	
	
	
	

   $and_from_date_s='';
   if($from_date_s!='')
   {
     $and_from_date_s=" and ie.dated >='$from_date_s' ";
   }
   
   
   $and_to_date_s='';
   if($to_date_s!='')
   {
   
		$to_date_s_obj = new DateTime($to_date_s);
		$to_date_s_obj->add(new DateInterval('P1D'));
		$to_date_s_s=$to_date_s_obj->format('Y-m-d');
		
		$and_to_date_s=" and ie.dated < '$to_date_s_s' ";
   }
   
 
 $list_item=array();
  
  

?>




<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">

        </div>
    </div>

</div>
<div class="content">


    <div class="item">
	<form action="" method="get">
        <div class="uk-padding-small uk-padding-remove-bottom">
            <div class="uk-inline" uk-tooltip="Select Branch">
                <div class="bp3-input-group ">
                    <div class="bp3-select">
                <select name="branch_code" style="width:350px" class="select2"
                        id="branch_code_s">
                    <option value="" selected>--</option>
                    <? $os->onlyOption($branch_code_arr,$selected_branch_code)?>
                </select>
                    </div>
                </div>
            </div>
            

            <div class="uk-inline " uk-tooltip="Select from date">
                <div class="bp3-input-group ">
                    <span class="bp3-icon bp3-icon-calendar"></span>
                    <input type="text" class="bp3-input  datepicker"
                           placeholder="From"
						   name="from_date_s"
                           value="<?=$from_date_s;?>"
                           id="from_date_s"/>

                </div>
            </div>



            <div class="uk-inline " uk-tooltip="Select to date">
                <div class="bp3-input-group ">
                    <span class="bp3-icon bp3-icon-calendar"></span>
                    <input type="text" class="bp3-input  datepicker"
                           placeholder="From"
						   name="to_date_s"
                           value="<?=$to_date_s;?>"
                           id="to_date_s"/>

                </div>
            </div>

<input type="Submit" value="Search" />
            <!--<button  
                    class="bp3-button bp3-intent-primary" type="button" >
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>-->

        </div>
</form>
        <div id="WT_fetch_item_stock_list_DIV" class="uk-padding-small"> 
		
		<?  if($selected_branch_code==''){ echo ' select branch';}
		else{  
		    $grand_total=0;
		     $report=array();
		
			$query="select * from    account_head where  account_head_id>0   order by view_order "; 		 
			//$query="select * from    account_head where  account_head_id>0   $and_branch and branch_code='$selected_branch_code' order by view_order "; 
			$rsResults=$os->mq($query); 
			while($record=$os->mfa( $rsResults))
			{
				$account_head_id=$record['account_head_id'];
				
					 $query_purchased_item= " select ied.* , ie.dated, ie.reff_no  , i.item_name, i.item_unit
					from item_entry_details ied 
					INNER JOIN item_entries ie on(ie.item_entry_id=  ied.item_entry_id and branch_code='$selected_branch_code')
					INNER JOIN items i on( i.item_id=  ied.item_id)
					where 
					ied.item_id IN( select itah.item_id   from item_to_account_head itah where itah.account_head_id='$account_head_id' )
					$and_from_date_s  $and_to_date_s
				
				
				 "; 
				$query_purchased_item_rs=$os->mq($query_purchased_item);				
				// $items=$os->get_item(''," account_head_id = '$account_head_id'" );  
				// $items=  $os->rowsByField('','items','account_head_id',$account_head_id,$where='',$orderby='',$limit='');
				
				$report[$account_head_id]=$record;
				 
				 while($item_row=$os->mfa($query_purchased_item_rs))
					{
						  $report[$account_head_id]['items'][$item_row['item_entry_detail_id']]=$item_row;
						  $report[$account_head_id]['total_amount']=$report[$account_head_id]['total_amount']+ $item_row['amount'];
						  $grand_total=$grand_total+$item_row['amount'];
					}
			 }
   ?>
   	<div style="font-size:18px;"> Total Transaction = <? echo $grand_total; ?> </div>
	 <ul uk-accordion>
	 
	 <?  foreach($report as  $account_head_id=>$record_ed){ 
	 
	 if(count($record_ed['items'])>0){
	  ?>
	 
     <li <?   if(!$record_ed['parent_head_id']){ ?>  style="font-weight:bold;" <?  } else { ?> style="padding-left:30px;"     <? } ?>>
        <a class="uk-accordion-title" href="#" style="font-size:11px;"><? echo $record_ed['title']?>  : Amount <? echo $record_ed['total_amount']?>  </a>
        <div class="uk-accordion-content">
             <table   border="0" cellspacing="0" cellpadding="0"> 
<tr style="font-size:10px; color:#666666">
   <td style="width:60px;">Reff no</td>
    <td style="width:130px;">Item</td>
    <td style="width:60px;">rate </td>
    <td style="width:150px;">quantity</td>
    <td style="width:60px;">amount</td>
    <td style="width:60px;">Dated</td>
    
  </tr>
			 <?  
			 
			 
			 
			 foreach($record_ed['items'] as  $item_entry_detail_id=>$item_purchased){  ?>
			   
			  
			   
			  
  
  <tr>
   <td><? echo $item_purchased['reff_no']?></td>
    <td><? echo $item_purchased['item_name']?></td>
    <td><? echo $item_purchased['rate']?></td>
    <td><? echo $item_purchased['quantity']?> <? echo $item_purchased['item_unit']?></td>
    <td><? echo $item_purchased['amount']?></td>
    <td><? echo $os->showDate($item_purchased['dated'])?></td>
   
  </tr>


			   
			  
			   <? } ?>
			   </table>
			 
        </div>
     </li>
	 <? } 
	 
	  }
	 ?>
	 
	 
	 
    
	</ul>	 
		
		<? } ?>
		 </div>

    </div>
	
	
</div>


<script>
     $(document).ready(function () {
					 /*$('#branch_code_s').selectize({
						  sortField: 'text'
					  });*/
					  
					  
					  
				  });
 
</script>

<? include($site['root-wtos'].'bottom.php'); ?>

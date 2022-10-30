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
$department = "Library";
$access_name = "Library Item Stock";
//
$session_cookie_key = $os->getSession($department."_branch");
//
$selected_branch    = $os->getSession($department."_branch");
$global_access      = $os->get_global_access_by_name($access_name);
$secondary_access   = $os->get_secondary_access_by_branch_and_menu($selected_branch, $access_name);
function get_opening_stock($from='', $to='', $item_id=0, $branch_code=''){
    global  $os, $site,$department;
    $and_item_id = $item_id>0? "AND ied.item_id='$item_id'":"";
    //////
    $ied_ids = [];
    $ieds = [];
    $ieds_q = $os->mq("SELECT 
       ied.item_id, 
       i.item_name,
       i.item_unit,
       i.stock_alert_quntity,
       SUM(IF(ied.quantity>0,ied.quantity,0)) as opening_total_quantity, 
       SUM(IF(ied.amount>0,ied.amount,0)) as opening_total_amount, 
       
       SUM(IF(iedt.quantity>0,iedt.quantity,0)) as opening_transferred_quantity,
       SUM(IF(iedt.amount>0,iedt.amount,0)) as opening_transferred_amount,
       
       SUM(IF(it.quantity>0, it.quantity,0)) as opening_uses_quantity,
       SUM(IF(it.quantity>0 AND it.rate>0, it.quantity*it.rate,0)) as opening_uses_amount
    FROM item_entry_details ied
        INNER JOIN items i  ON ied.item_id = i.item_id
        INNER JOIN item_entries ie ON (ie.item_entry_id=ied.item_entry_id AND ie.final_verified='1')
        LEFT JOIN item_entry_details iedt ON iedt.parent=ied.item_entry_detail_id AND iedt.item_entry_id 
            IN(SELECT iet.item_entry_id FROM item_entries iet WHERE iedt.item_entry_id=iet.item_entry_id AND iet.dated < DATE('$from') )

        LEFT JOIN item_tracking it ON it.item_entry_detail_id=ied.item_entry_detail_id AND it.item_uses_detail_id
            IN(SELECT  iud.item_uses_detail_id FROM item_uses_details iud WHERE iud.item_uses_detail_id=it.item_uses_detail_id AND iud.item_use_id
                IN(SELECT iu.item_use_id FROM item_uses iu WHERE iu.item_use_id=iud.item_use_id AND iu.dated < DATE('$from'))
                )
    WHERE ie.dated < DATE('$from') $and_item_id  AND  ie.branch_code='$branch_code' and i.departments LIKE '%$department%'  GROUP BY ied.item_id;");
//echo '<pre>';
 // echo $os->query;

    while ($ied = $os->mfa($ieds_q)){
        //$ied["opening_quantity"] = ($ied["total_opening_quantity"] - $ied["transferred_opening_quantity"] - $ied["uses_opening_quantity"]);
        $ied_ids[] = $ied["item_id"];
        $ieds[$ied["item_id"]] = $ied;
    }
    /////

    return $ieds;


}
function get_range_stock($from='', $to='', $item_id=0, $branch_code=''){
    global  $os, $site,$department;
    $and_item_id = $item_id>0? "AND ied.item_id='$item_id'":"";
    //////
    $ied_ids = [];
    $ieds = [];
    $ieds_q = $os->mq("SELECT 
       ied.item_id, 
       i.item_name,
       i.item_unit,
       i.stock_alert_quntity,
       SUM(IF(ied.quantity>0,ied.quantity,0)) as range_total_quantity, 
       SUM(IF(ied.amount>0,ied.amount,0)) as range_total_amount, 
       
       SUM(IF(iedt.quantity>0,iedt.quantity,0)) as range_transferred_quantity,
       SUM(IF(iedt.amount>0,iedt.amount,0)) as range_transferred_range_amount,
       
       SUM(IF(it.quantity>0, it.quantity,0)) as range_uses_quantity,
       SUM(IF(it.quantity>0 AND it.rate>0, it.quantity*it.rate,0)) as range_uses_amount
    FROM item_entry_details ied
        INNER JOIN items i  ON ied.item_id = i.item_id
        INNER JOIN item_entries ie ON (ie.item_entry_id=ied.item_entry_id AND ie.final_verified='1')
        LEFT JOIN item_entry_details iedt ON iedt.parent=ied.item_entry_detail_id AND iedt.item_entry_id 
            IN(SELECT iet.item_entry_id FROM item_entries iet WHERE iedt.item_entry_id=iet.item_entry_id AND iet.dated >= DATE('$from') AND iet.dated <= DATE('$to') )

        LEFT JOIN item_tracking it ON it.item_entry_detail_id=ied.item_entry_detail_id AND it.item_uses_detail_id
            IN(SELECT  iud.item_uses_detail_id FROM item_uses_details iud WHERE iud.item_uses_detail_id=it.item_uses_detail_id AND iud.item_use_id
                IN(SELECT iu.item_use_id FROM item_uses iu WHERE iu.item_use_id=iud.item_use_id AND iu.dated >= DATE('$from') AND iu.dated <= DATE('$to'))
                )
    WHERE ie.dated >= DATE('$from') AND ie.dated <= DATE('$to') $and_item_id AND  ie.branch_code='$branch_code' and  i.departments LIKE '%$department%'  GROUP BY ied.item_id;");
	
	//echo '<pre>';
//echo $os->query;
    while ($ied = $os->mfa($ieds_q)){
        $ied["range_quantity"] = ($ied["range_total_quantity"] - $ied["range_transferred_quantity"] - $ied["range_uses_quantity"]);
        $ied_ids[] = $ied["item_id"];
        $ieds[$ied["item_id"]] = $ied;
    }
    /////

    return $ieds;


}

function merge_two($ones, $twos){
    $xx = [];
    foreach ($ones as $key=>$one){
        foreach ($one as $k=>$v){
            $xx[$key][$k] = $v;
        }
        if(isset($twos[$key])){
            foreach ($twos[$key] as $k=>$v){
                $xx[$key][$k] = $v;
            }
        }
    }
    foreach ($twos as $key=>$two){
        foreach ($two as $k=>$v){
            $xx[$key][$k] = $v;
        }
        if(isset($ones[$key])){
            foreach ($ones[$key] as $k=>$v){
                $xx[$key][$k] = $v;
            }
        }
    }

    return $xx;
}
/**
 * Autocomplete
 */
if($os->get("autocomplete_items")=="OK"){

    $res = ["results"=>[]];
    $keyword = $os->get("q");
    $q = $os->mq("SELECT * FROM items 
        WHERE departments LIKE '%$department%' 
          AND (item_name LIKE '%$keyword%' OR beng_name LIKE '%$keyword%' OR hindi_name LIKE '%$keyword%' OR keywords LIKE '%$keyword%') LIMIT 0,10");
    while ($row = $os->mfa($q)){
        $item = new stdClass();
        $item->id =$row["item_id"];
        $item->text =$row["item_name"];
        $item->type =$row["item_type"];
        $res["results"][] = $item;
    }
    print json_encode($res);

    exit();
}



if($os->get("WT_fetch_item_stock_list")=="OK" && $os->post("WT_fetch_item_stock_list")=="OK"){
    $from_date  = $os->post("from_date_s");
    $to_date    = $os->post("to_date_s");
	
	$to_date_obj = new DateTime($to_date);
    $to_date_obj->add(new DateInterval('P1D'));
	$to_date=$to_date_obj->format('Y-m-d');
	
    $item_id    = $os->post("item_id");
    $branch_code_s    = $os->post("branch_code_s");

    $opening = get_opening_stock($from_date, $to_date, $item_id, $branch_code_s);
    $range   = get_range_stock($from_date, $to_date, $item_id, $branch_code_s);
    ///

    $stocks = merge_two($opening, $range);
    ?>
    <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
        <thead>
        <tr>
            <th class="uk-table-shrink">#</th>
            <th>Item</th>
            <th>Opening</th>
            <th>Added</th>
            <th>Total</th>
            <th>Used</th>
            <th>Closing</th>
        </tr>
        </thead>
        <tbody>
        <?
        $c = 0;
        foreach ($stocks as $stock):
            $c++;
            $color = $stock["stock_alert_quntity"]>$stock["total_range_quantity"]?"#ff000030":"";
        ?>
        <tr style="background-color: <?=$color;?>">
            <td class="uk-table-shrink"><?=$c;?></td>
            <td>
                <?=$stock["item_name"]?>
                <?//_d($stock)?>
            </td>
            <td>
                <?=($stock["opening_total_quantity"]-$stock["opening_transferred_quantity"]-$stock["opening_uses_quantity"])." ".$stock["item_unit"]?>
            </td>
            <td>
                <?=($stock["range_total_quantity"]-$stock["range_transferred_quantity"])." ".$stock["item_unit"]?>
            </td>
            <td><?=
                (
                    ($stock["opening_total_quantity"]-$stock["opening_transferred_quantity"]-$stock["opening_uses_quantity"])+
                    ($stock["range_total_quantity"]-$stock["range_transferred_quantity"])
                )
                ." ".$stock["item_unit"]?></td>
            <td><?=$stock["range_uses_quantity"]." ".$stock["item_unit"]?></td>
            <td><?=
                (
                    ($stock["opening_total_quantity"]-$stock["opening_transferred_quantity"]-$stock["opening_uses_quantity"])+
                    ($stock["range_total_quantity"]-$stock["range_transferred_quantity"]-$stock["range_uses_quantity"])
                )." ".$stock["item_unit"]?></td>
        </tr>
        <?endforeach;?>
        </tbody>
    </table>

<?

}

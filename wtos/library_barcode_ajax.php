<?
/*
   # wtos version : 1.1
   # page called by ajax script in library_barcode.php
   #
*/
use mikehaertl\wkhtmlto\Pdf;
include('wtosConfigLocal.php');
global $os,$site;
include($site['root-wtos'].'wtosCommon.php');

$pluginName='';
$os->loadPluginConstant($pluginName);
$department = "Library";
$branches = $os->get_branches_by_access_name("Library Barcode Print");

function generate_code( $str,$length=12){
    $itr = $length-strlen($str);
    for($c=0; $c<$itr;$c++){
        $str = '0'.$str;
    }
    return $str;
}
function get_libraries_by_branch_code($branch_code_s){
    global $os;
    $sql = "SELECT * FROM library WHERE branch_code='$branch_code_s'";
    $query = $os->mq($sql);
    $locations=[];
    while($location = $os->mfa($query)){
        $locations[$location["library_id"]] = $location["name"];
    }

    return $locations;
}


if($os->get('WT_item_uniqueListing')=='OK') {
    $and_ie_branch_code_s = $os->postAndQuery("branch_code_s","ie.branch_code","=");
    $and_iu_item_unique_id_s = $os->postAndQuery("item_unique_id_s","iu.item_unique_id","=");
    $and_iu_is_ready_s = $os->postAndQuery("is_ready_s","iu.is_ready","=");
    $and_ie_reff_no_s = $os->postAndQuery("reff_no_s","ie.reff_no","=");
    $where='';
    $showPerPage= $os->post('showPerPage');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="";

    }


    $listingQuery = "SELECT 
                    i.item_name,
                    i.publisher,
                    i.edition,
                    i.edition,
                    i.isbn,
                    iu.item_unique_id,
                    iu.is_ready,
                    ie.reff_no,
                
                    CONCAT('{',GROUP_CONCAT(CONCAT('\"',ium.item_unique_meta_key,'\":\"',ium.item_unique_meta_value,'\"')),'}') as unique_meta
                    
                FROM item_unique iu
                
                INNER JOIN item_entry_details ied ON ied.item_entry_detail_id = iu.item_entry_detail_id
                INNER JOIN item_entries ie ON ie.item_entry_id=ied.item_entry_id
                INNER JOIN items i ON i.item_id= ied.item_id
                    
                LEFT JOIN item_meta im ON i.item_id= im.item_id           
                LEFT JOIN item_unique_meta ium ON ium.item_unique_id=iu.item_unique_id
                WHERE i.item_id>0 $and_ie_branch_code_s $and_iu_item_unique_id_s $and_ie_reff_no_s $and_iu_is_ready_s
                GROUP BY iu.item_unique_id";

    //print $listingQuery;

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
    $libraries = get_libraries_by_branch_code($os->post("branch_code_s"));

    ?>
    <div class="">
        <textarea id="req_params" class="uk-hidden"><?=http_build_query($_POST);?></textarea>
        <div class="pagingLinkCss p-m">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table class="bp3-html-table  bp3-html-table-striped bp3-interactive bp3-html-table-condensed" style="width: 100%">
            <thead>
            <tr >
                <th class="uk-table-shrink">#</th>
                <th>
                    <label class="bp3-control bp3-checkbox .modifier">

                        <input type="checkbox" onclick="select_all(this)">
                        <span class="bp3-control-indicator"></span>
                    </label>

                </th>
                <th>Item</th>
                <th class="">Location</th>
                <th>Used</th>
                <th>Ref. No</th>
                <th>Barcode</th>
            </tr>
            </thead>



            <?php

            $serial=$os->val($resource,'serial');


            while($record=$os->mfa($rsRecords)){
                $serial++;
                $metas = (array)@json_decode($record["meta"]);
                $unique_metas = (array)@json_decode($record["unique_meta"]);

                ?>
                <tr style="<?=$record['is_ready']=="Yes"?"background-color:#00ff0030":""?>">
                    <td><?=$serial?></td>
                    <td class="uk-table-shrink">
                        <label class="bp3-control bp3-checkbox .modifier">
                            <input type="checkbox"
                                   value="<?=$record['item_unique_id']?>"
                                   class="item_unique_checkbox"
                                   name="iu_ids[]">
                            <span class="bp3-control-indicator"></span>
                        </label>

                    </td>
                    <td>
                        <div class=" m-bottom-s" style="font-size: 15px"><?=$record['item_name']?></div>

                        <div class="text-s">Author: <i style="color: #0A246A"><?=$record["author"]?></i></div>
                        <div class="text-s">Edition: <i style="color: #0A246A"><?=$record["edition"]?></i></div>
                        <div class="text-s">Publisher: <i style="color: #0A246A"><?=$record["publisher"]?></i></div>
                        <div class="text-s">ISBN: <i style="color: #0A246A"><?=$record["isbn"]?></i></div>


                        <div class="text-s m-top-s uk-hidden">
                            <a class="uk-text-primary" tabindex="0"
                               onclick="WT_item_uniqueGetById('<? echo $record['item_unique_id'];?>')"
                               role="button">Edit</a>
                        </div>
                    </td>
                    <td class="uk-text-nowrap ">
                        <div class="text-s">
                            Library:
                            <select type="text" class="text-s"
                                    id="library_id_<?=$record['item_unique_id']?>"
                                    onchange="save_location(<?=$record['item_unique_id']?>)">
                                <option></option>
                                <?$os->onlyOption($libraries,@$unique_metas["library_id"])?>
                            </select>
                        </div>
                        <div class="text-s">
                            Rack No: <input type="number"
                                            class="text-s" id="rack_no_<?=$record['item_unique_id']?>"
                                            value="<?=@$unique_metas["rack_no"]?>"
                                            onchange="save_location(<?=$record['item_unique_id']?>)">
                        </div>
                        <div class="text-s">
                            Shelf No: <input type="text"
                                             value="<?=@$unique_metas["shelf_no"]?>"
                                             class="text-s" id="shelf_no_<?=$record['item_unique_id']?>"
                                             onchange="save_location(<?=$record['item_unique_id']?>)">
                        </div>
                    </td>
                    <td class="uk-table-shrink">

                        <select id="is_ready_<?=$record['item_unique_id']?>"
                                onchange="wtosInlineEdit('is_ready_<?=$record['item_unique_id']?>','item_unique','is_ready','item_unique_id','<?=$record['item_unique_id']?>','','','')">
                            <? $os->onlyOption($os->yesno, $record['is_ready'])?>
                        </select>
                        <div class="uk-inline uk-hidden">
                            <div class="uk-switch text-xs uk-inline">
                                <input type="checkbox"
                                       class="uk-margin-small-right uk-checkbox"
                                    <?= $record['is_ready']=='Yes'?'checked':''?>
                                       value="Yes"
                                       id="is_ready_<?=$record['item_unique_id']?>"
                                       onchange="wtosInlineEdit('is_ready_<?=$record['item_unique_id']?>','item_unique','is_ready','item_unique_id','<?=$record['item_unique_id']?>','','','')">
                                <label for="is_ready_<?=$record['item_unique_id']?>"></label>
                            </div>
                        </div>
                    </td>
                    <td class="uk-text-nowrap">
                        <?=$record["reff_no"]?>
                    </td>
                    <td class="uk-table-shrink">
                        <div class="uk-text-center" style="width: 100px">
                            <?
                            $code = generate_code($record["item_unique_id"]);
                            try {
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                ?>

                                <img class="uk-width-1-1" style="height: 25px" src="data:image/png;base64, <?=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128)) ?>">

                                <?
                            } catch (\Picqer\Barcode\Exceptions\BarcodeException $e) {
                                print($e->getMessage());
                            }
                            ?>
                            <small style="letter-spacing: 0.3rem; font-size: 9px"><?= $code?></small>
                        </div>
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

if($os->get('WT_item_uniqueEditAndSave')=='OK') {
    $item_unique_id=$os->post('item_unique_id');



    $dataToSave['is_ready']=addslashes($os->post('is_ready'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($item_unique_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('item_unique',$dataToSave,'item_unique_id',$item_unique_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($item_unique_id>0 ){ $mgs= " Data updated Successfully";}
        if($item_unique_id<1 ){ $mgs= " Data Added Successfully"; $item_unique_id=  $qResult;}

        $mgs=$item_unique_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_item_uniqueGetById')=='OK') {
    $item_unique_id=$os->post('item_unique_id');

    if($item_unique_id>0)
    {
        $wheres=" where item_unique_id='$item_unique_id'";
    }
    $dataQuery=" select * from item_unique  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['is_ready']=$record['is_ready'];



    echo  json_encode($record);

    exit();

}

if($os->get('WT_item_uniqueDeleteRowById')=='OK') {

    $item_unique_id=$os->post('item_unique_id');
    if($item_unique_id>0){
        $updateQuery="delete from item_unique where item_unique_id='$item_unique_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

if($os->get("print_barcodes")=="OK"){
    $and_ie_branch_code_s = $os->getAndQuery("branch_code_s","ie.branch_code","=");
    $and_iu_item_unique_id_s = $os->getAndQuery("item_unique_id_s","iu.item_unique_id","=");
    $and_iu_is_ready_s = $os->getAndQuery("is_ready_s","iu.is_ready","=");
    $and_ie_reff_no_s = $os->getAndQuery("reff_no_s","ie.reff_no","=");

    $and_selected_iu_item_unique_ids = $os->get("selected")!=""?"AND iu.item_unique_id IN(".$os->get("selected").")":"";

    $listingQuery = "SELECT 
                    i.item_name,
                    iu.item_unique_id,
                    iu.is_ready,
                    ie.reff_no
                FROM item_unique iu
                
                INNER JOIN item_entry_details ied ON ied.item_entry_detail_id = iu.item_entry_detail_id
                INNER JOIN item_entries ie ON ie.item_entry_id=ied.item_entry_id
                INNER JOIN items i ON i.item_id= ied.item_id
                    
                WHERE i.item_id>0 $and_ie_branch_code_s $and_iu_item_unique_id_s $and_selected_iu_item_unique_ids $and_ie_reff_no_s $and_iu_is_ready_s
                GROUP BY iu.item_unique_id";
    $query = $os->mq($listingQuery);

    $pages = [];
    $count = 0;
    $iterate = 0;
    while($record=$os->mfa($query)){
        $count++;
        $record["meta"] = (array)@json_decode($record["meta"]);
        $pages[$iterate][] = $record;
        if($count==5000){
            $iterate++;
            $count=0;
            $pages[$iterate] = [];
        }
    }

    $pdf_pages = [];
    foreach ($pages as $page=>$items){
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                html, body {
                    margin:     0;
                    padding:    0;
                }

                /* Printable area */
                #print-area {
                    position:   relative;
                    top:        0cm;
                    left:       0cm;
                }
                table td{
                    background-color: white;

                }
            </style>
        </head>
        <body>

        <div id="print-area">
            <div id="content">
                <table style="width: 100%">
                    <tr>
                        <?
                        $col_count = 0;
                        $max_col = 4;
                        foreach ($items as $record){

                            if($col_count%$max_col==0){
                                print "</tr><tr>";
                                $col_count=0;
                            }
                            ?>
                            <td style=" border: 1px dashed #cccccc00; text-align: center; padding: 25px 15px 15px; width: 25%">
                                <div class="" style="width: 100%;">

                                    <?
                                    $code = generate_code($record["item_unique_id"]);
                                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                    try {?>

                                        <img style="width: 80%; height: 45px" src="data:image/png;base64, <?=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128)) ?>">

                                        <?
                                    } catch (\Picqer\Barcode\Exceptions\BarcodeException $e) {
                                        print($e->getMessage());
                                    }
                                    ?>
                                    <div style="text-align: center; margin-top: 3px; font-size: 15px; letter-spacing: 0.40rem">
                                        <?= $code?>
                                    </div>

                                </div>
                            </td>
                            <?
                            $col_count++;
                        }
                        if($col_count<$max_col){
                            for($x=0; $x<$max_col-$col_count; $x++){
                                ?>
                                <td style=" border: 1px dashed #cccccc00; text-align: center; padding: 25px 15px 15px; width: 25%">
                                </td>
                                <?
                            }
                        }
                        ?>
                    </tr>
                </table>

            </div>
        </div>
        </body>
        </html>
        <?
        $pdf_pages[] = ob_get_contents();
        ob_end_clean();
    }


    //print $pdf_pages[0];
    //exit();
    ///////
    $file_name = strtolower($department."_barcodes");
    $path = realpath($site['root'].'cache/pdf');
    $http_pdf = $site['url'].'cache/pdf/'.$file_name.'.pdf';
    // You can pass a filename, a HTML string, an URL or an options array to the constructor


    $pdf = new Pdf(array(
        'binary' => WKHTMLTOPDF_BIN,
        'no-outline',
        'margin-top'    => 0,
        'margin-right'  => 0,
        'margin-bottom' => 0,
        'margin-left'   => 0,
        //'disable-smart-shrinking',
        'page-size' => 'A4'
    ));
    foreach ($pdf_pages as $page){
        $pdf->addPage($page);
    }

    if (!$pdf->send()) {
        $error = $pdf->getError();
        // ... handle error here
    }
    /*
    if (!$pdf->saveAs($path.'/'.$file_name.'.pdf')) {
        $error = $pdf->getError();
        // ... handle error here
        print $error;
        exit();

    }

    //header("Content-Type: application/pdf");
    */
    exit();
}

if($os->get("WT_save_location")=="OK" && $os->post("WT_save_location")=="OK"){
    $iu_id = $os->post("iu_id");
    $library_id = $os->post("library_id");
    $rack_no = $os->post("rack_no");
    $shelf_no = $os->post("shelf_no");

    $metas = [];
    $query = $os->mq("SELECT * FROM item_unique_meta WHERE item_unique_id = '$iu_id'");
    while($meta = $os->mfa($query)){
        $metas[$meta["item_unique_meta_key"]] = $meta["item_unique_meta_id"];
    }



    $res = [];


    $dataToSave = [];
    $dataToSave["item_unique_meta_key"] = "library_id";
    $dataToSave["item_unique_meta_value"] = $library_id;
    $dataToSave["item_unique_id"] = $iu_id;

    $res['a'] = $os->save("item_unique_meta", $dataToSave, "item_unique_meta_id", $os->val($metas, "library_id"));


    $dataToSave = [];
    $dataToSave["item_unique_meta_key"] = "rack_no";
    $dataToSave["item_unique_meta_value"] = $rack_no;
    $dataToSave["item_unique_id"] = $iu_id;

    $res['b'] = $os->save("item_unique_meta", $dataToSave, "item_unique_meta_id", $os->val($metas, "rack_no"));



    $dataToSave = [];
    $dataToSave["item_unique_meta_key"] = "shelf_no";
    $dataToSave["item_unique_meta_value"] = $shelf_no;
    $dataToSave["item_unique_id"] = $iu_id;

    $res['c'] = $os->save("item_unique_meta", $dataToSave, "item_unique_meta_id", $os->val($metas, "shelf_no"));


    if ($res){
        print "Successfully Updated";
    }
}

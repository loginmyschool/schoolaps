<?
/*
   # wtos version : 1.1
   # page called by ajax script in campus_buildingDataView.php
   #
*/
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$ajaxFilePath= $site["url-wtos"].'canteen_purchase_entry_ajax.php';
$department = "Canteen";
$access_name = "Canteen Purchase Entry";
//
$selected_branch = $os->getSession($department."_branch");
$global_access = $os->get_global_access_by_name($access_name);
$secondary_access = $os->get_secondary_access_by_branch_and_menu($selected_branch, $access_name);
/*
 * Auto Completes
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
        $item->unit =$row["item_unit"];
        $item->photo = $site['url'].$row["photo"];
        $res["results"][] = $item;
    }
    print json_encode($res);

    exit();
}
if($os->get("autocomplete_brands")=="OK"){

    $res = ["results"=>[]];
    $keyword = $os->get("q");
    $q = $os->mq("SELECT * FROM global_brand
        WHERE (brand_name LIKE '%$keyword%' OR search_keys LIKE '%$keyword%')");

    while ($row = $os->mfa($q)){
        $item = new stdClass();
        $item->id =$row["global_brand_id"];
        $item->text =$row["brand_name"];
        $res["results"][] = $item;
    }
    print json_encode($res);

    exit();
}
if($os->get("autocomplete_vendors")=="OK"){
    $res = ["results"=>[]];
    $keyword = $os->get("q");
    $q = $os->mq("SELECT * FROM global_vendor
        WHERE (vendor_name LIKE '%$keyword%')");

    while ($row = $os->mfa($q)){
        $item = new stdClass();
        $item->id =$row["global_vendor_id"];
        $item->text =$row["vendor_name"];
        $res["results"][] = $item;
    }
    print json_encode($res);
    exit();
}

/*
 * Lists
 */
if($os->get("WT_fetch_purchase_list")=="OK"&&$os->post("WT_fetch_purchase_list")=="OK"){

    $branch_code_s=$os->post("branch_code_s");
    $os->setSession($branch_code_s,$department."_branch");

    $date_from_s=$os->post("date_from_s");
    $date_to_s=$os->post("date_to_s");
    $ref_no_s=$os->post("ref_no_s");

    ?>

        <table class="bp3-html-table  bp3-html-table-striped bp3-interactive " style="width: 100%">
            <?
            $query = $os->mq("SELECT * FROM item_entries 
            WHERE   department='$department' 
                AND (DATE(dated) BETWEEN DATE('$date_from_s') AND DATE('$date_to_s'))
                AND reff_no LIKE '%$ref_no_s%'
                AND branch_code='$branch_code_s'
            ORDER BY dated DESC");

            while($row=$os->mfa($query)){
                $color = "bp3-intent-danger";
                $icon = "bp3-icon-history";
                $text = "Pending";
                $primary_verified = $row["primary_verified"];
                $final_verified = $row["final_verified"];
                $submitted = $row["submitted"];
                ?>
                <tr class="pointable purchase_row purchase_row_<?=$row['item_entry_id']?>">
                    <td>
                        <div onclick="WT_fetch_purchase_details('<?=$row['item_entry_id']?>')">
                            <div class="uk-text-secondary"><?= $row["reff_no"]?></div>
                            <div class="text-s">Date :
                                <i class="">
                                    <?= date("d/m/Y",strtotime($row["dated"]))?>
                                </i>
                            </div>
                        </div>
                        <div class="text-s m-top-s">
                            <?
                            $has_final_verification_access = in_array("Final Verification", ($branch_code_s == ""?$global_access:$secondary_access));
                            $has_primary_verification_access = in_array("Primary Verification", ($branch_code_s == ""?$global_access:$secondary_access));

                            $delete_access = false;
                            $edit_access=false;
                            $show_verify_btn = false;
                            $show_final_submit = false;
                            $verify_text = "Verify";

                            if($has_final_verification_access&&!$final_verified){
                                $delete_access=true;
                                $edit_access=true;
                                $show_verify_btn=true;
                            }
                            if($has_primary_verification_access && !$final_verified){
                                $delete_access=true;
                                $edit_access=true;
                            }
                            if($has_primary_verification_access && !$primary_verified && !$final_verified && !$submitted){
                                $show_verify_btn = true;
                            }
                            if(!$primary_verified&&!$final_verified){
                                $delete_access=true;
                                $edit_access=true;
                            }

                            //for super admin
                            if($os->userDetails["adminType"]=="Super Admin"){
                                $delete_access=true;
                                $edit_access=true;

                                if (!$primary_verified&&!$final_verified){
                                    $show_verify_btn = true;
                                }
                            }

                            if(!$submitted){
                                $show_verify_btn=true;
                                $verify_text = "Final Submit";
                            }




                            if($delete_access){?>
                                <a class="uk-text-danger"
                                   onclick="removeRowAjaxFunction('item_entries','item_entry_id','<?=$row['item_entry_id']?>','','','WT_fetch_purchase_list();') "
                                   tabindex="0" role="button">Delete</a>
                                \
                                <?
                            }
                            if($edit_access){?>
                                <a class="uk-text-primary" tabindex="0"
                                   onclick="WT_open_purchase_form(<?=$row['item_entry_id']?>)"
                                   role="button">Edit</a>

                            <?}?>
                            <?if($show_verify_btn){?>
                                \
                                <a class="uk-text-success" tabindex="0"
                                   onclick="WT_do_verification(<?=$row['item_entry_id']?>, '<?=$verify_text?>')"
                                   role="button"><?=$verify_text?></a>
                            <?}?>


                        </div>
                    </td>
                    <td class="uk-table-shrink uk-text-nowrap">
                        <?


                        if($primary_verified){
                            $color = "bp3-intent-warning";
                            $icon = "bp3-icon-tick-circle";
                            $text = "Primary";
                        }

                        if($final_verified){
                            $color = "bp3-intent-success";
                            $icon = "bp3-icon-endorsed";
                            $text = "Verified";
                        }
                        ?>
                        <div class="text-s"><span class="bp3-icon <?=$icon?> <?=$color?>"></span> <?=$text?></div>
                    </td>
                </tr>
            <?}?>
        </table>

    <?
}
if($os->get("WT_fetch_purchase_details")=="OK"&&$os->post("WT_fetch_purchase_details")=="OK"){
    $item_entry_id = $os->post("item_entry_id");
    $purchase = $os->mfa($os->mq("SELECT * FROM item_entries WHERE item_entry_id='$item_entry_id'"));

    $primary_verified = $purchase["primary_verified"];
    $final_verified = $purchase["final_verified"];
    ?>
    <div class="item-header p-m uk-box-shadow-small" style="border-bottom: 1px solid #e5e5e5">
        <table class="uk-table uk-table-justify congested-table uk-margin-remove">
                <tr>
                <td>
                    <a class="uk-hidden@s" uk-icon="arrow-left" onclick="toggle_details('close')"></a>
                </td>
                <td>
                    <div class="text-l">Purchase Items</div>
                    <div class="text-s uk-text-primary"><?=$purchase["reff_no"]?></div>
                </td>
                <td class="uk-text-right">
                        <div class="bp3-button-group .modifier">
                            <a class="bp3-button bp3-small bp3-icon-add" tabindex="0" role="button"
                               onclick="WT_open_purchase_details_form(<?=$item_entry_id?>)">New Item</a>
                        </div>

                </td>
                </tr>
            </table>
        <?

        ?>
    </div>
    <div class="item-content uk-overflow-auto">
        <table class="bp3-html-table  bp3-html-table-striped bp3-interactive bp3-html-table-condensed" style="width: 100%">
            <thead>
            <tr>
                <th class="uk-table-shrink">#</th>
                <th>Product</th>
                <th class="uk-visible@s">Quantity</th>
                <th class="uk-visible@s">Rate</th>
                <th>Amount</th>
            </tr>

            </thead>
            <tbody>
            <?
            $query = $os->mq("SELECT ied.*, i.item_name, gb.brand_name, gv.vendor_name
                FROM item_entry_details ied
                INNER JOIN items i ON i.item_id=ied.item_id 
                LEFT JOIN global_brand gb ON gb.global_brand_id=ied.brand_id
                LEFT JOIN global_vendor gv ON gv.global_vendor_id=ied.vendor_id
                WHERE ied.item_entry_id='$item_entry_id' ORDER BY item_entry_detail_id DESC");
            $x=0;
            $has_final_verification_access = in_array("Final Verification", ($selected_branch == ""?$global_access:$secondary_access));
            $has_primary_verification_access = in_array("Primary Verification", ($selected_branch == ""?$global_access:$secondary_access));

            ///Access checking
            $delete_access = false;
            $edit_access=false;
            $show_verify_btn = false;

            if($has_final_verification_access&&!$final_verified){
                $delete_access=true;
                $edit_access=true;
                $show_verify_btn=true;
            }
            if($has_primary_verification_access && !$final_verified){
                $delete_access=true;
                $edit_access=true;
            }
            if($has_primary_verification_access && !$primary_verified && !$final_verified){
                $show_verify_btn = true;
            }
            if (!$primary_verified&&!$final_verified){
                $delete_access=true;
                $edit_access=true;
            }
            //for super admin
            if($os->userDetails["adminType"]=="Super Admin"){
                $delete_access=true;
                $edit_access=true;

                if (!$primary_verified&&!$final_verified){
                    $show_verify_btn = true;
                }
            }

            while($record=$os->mfa($query)){
                $x++;
                ?>
                <tr>
                    <td><?=$x?></td>
                    <td>
                        <div class="text-l m-bottom-s"><?=$record['item_name']?></div>
                        <div class="text-s">Brand : <i><?=$record['brand_name']?></i></div>
                        <div class="text-s">Vendor : <i><?=$record['vendor_name']?></i></div>

                        <div class="text-s uk-hidden@s">Quantity : <i><?=rand(1,99)?>Kg</i></div>
                        <div class="text-s uk-hidden@s">Rate : <i>₹<?=rand(10,9999)?></i></div>

                        <div class="text-s m-top-s">
                            <?

                            if ($delete_access){
                            ?>
                            <a class="uk-text-danger" tabindex="0" role="button">Delete</a>
                            <?}
                            if ($edit_access){
                            ?>
                            \
                            <a class="uk-text-primary" tabindex="0"
                               onclick="WT_open_purchase_details_form(<?=$item_entry_id?>, <?=$record['item_entry_detail_id']?>)"
                               role="button">Edit</a>

                            <?}?>
                            <a class="uk-text-primary uk-hidden" tabindex="0"
                               onclick="WT_open_purchase_details_transfer_form(<?=$item_entry_id?>, <?=$record['item_entry_detail_id']?>)"
                               role="button">Transfer</a>

                            <a class="uk-text-primary uk-hidden" tabindex="0"
                               onclick="WT_open_purchase_details_transfer_form(<?=$item_entry_id?>, <?=$record['item_entry_detail_id']?>)"
                               role="button">History</a>
                        </div>
                    </td>
                    <td class="uk-visible@s"><?=$record['quantity']?>Kg</td>
                    <td class="uk-visible@s">₹<?=$record['rate']?></td>
                    <td class="uk-table-shrink uk-text-success">₹<?=$record['amount']?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <?
}

/*
 * Forms
 */
if($os->get("get_purchase_form")=="OK" && $os->post("get_purchase_form")=="OK"){
    $item_entry_id = $os->post("item_entry_id");
    $branches = $os->get_branches_by_access_name($access_name);
    $purchase = $os->mfa($os->mq("SELECT * FROM item_entries WHERE item_entry_id='$item_entry_id'"));
    ?>
    <input class="uk-hidden" name="item_entry_id" value="<?=$item_entry_id?>"/>
    <input class="uk-hidden" name="branch_code" value="<?=$os->val($purchase,"branch_code")?$os->val($purchase,"branch_code"): $selected_branch?>"/>


    <div class="bp3-form-group">
        <label class="bp3-label" for="form-group-input">
            Date
            <span class="bp3-text-muted">(required)</span>
        </label>
        <div class="bp3-form-content">
            <div class="bp3-input-group .modifier">
                <span class="bp3-icon bp3-icon-calendar"></span>
                <?
                $dated = $os->val($purchase,"dated")?$os->val($purchase,"dated"):date("Y-m-d H:i:s");
                ?>
                <input id="form-group-input" type="text"
                       class="bp3-input datetimepicker"
                       name="dated"
                       placeholder=""
                       value="<?=$dated?>"
                       dir="auto" />
            </div>
        </div>
    </div>

    <div class="bp3-form-group">
        <label class="bp3-label" for="form-group-input">
            Reference No.
        </label>
        <div class="bp3-form-content">
            <div class="bp3-input-group .modifier">
                <span class="bp3-icon bp3-icon-tag"></span>
                <input id="form-group-input" type="text"
                       class="bp3-input"
                       name="reff_no"
                       value="<?=$os->val($purchase,"reff_no")?>"
                       placeholder="" dir="auto" />
            </div>
        </div>
    </div>
    <?
}
if($os->get("get_purchase_details_form")=="OK" && $os->post("get_purchase_details_form")=="OK"){
    $item_entry_id = $os->post("item_entry_id");
    $item_entry_detail_id = $os->post("item_entry_detail_id");

    $items_q = $os->mq("SELECT ied.item_entry_detail_id, i.item_name FROM item_entry_details ied 
        INNER JOIN items i ON (i.item_id=ied.item_id AND i.item_type='Product')
        WHERE ied.item_entry_id='$item_entry_id'");

    $item_entry_detail =
        $os->mfa($os->mq("SELECT ied.*, i.item_name, i.item_type, gb.brand_name, gv.vendor_name  FROM item_entry_details ied 
        INNER JOIN items i ON (i.item_id=ied.item_id)
        LEFT JOIN global_vendor gv ON (gv.global_vendor_id=ied.vendor_id)
        LEFT JOIN global_brand gb ON (gb.global_brand_id=ied.brand_id)
        WHERE ied.item_entry_detail_id='$item_entry_detail_id'"));


    ?>
        <input type="text" class="uk-hidden" name="item_entry_id" value="<?=$item_entry_id?>">
        <input type="text" class="uk-hidden" name="item_entry_detail_id" value="<?=$item_entry_detail_id?>">
    <div class="uk-grid uk-child-width-1-3 uk-grid-small" uk-grid>
        <div class="uk-width-1-1">
            <label>Select Item</label>
            <input type="number" id="item_id" name="item_id" class="uk-hidden" value="<?=$os->val($item_entry_detail,'item_id')?>">
            <select type="text"
                    id="search_item_name" style="width: 100%">
            </select>
        </div>

        <div class="uk-width-1-2">
            <label>Brand</label>
            <input type="text" name="brand_id" class="uk-hidden" value="<?=$os->val($item_entry_detail,'brand_id')?>">
            <select id="search_brand_name">
                <option value=""></option>
            </select>

        </div>
        <div class="uk-width-1-2">
            <label>Vendor</label>
            <input type="text" name="vendor_id" class="uk-hidden" value="<?=$os->val($item_entry_detail,'vendor_id')?>">
            <select id="search_vendor_name">
                <option value=""></option>
            </select>

        </div>

        <div >
            <div class="bp3-form-group .modifier">
                <label class="bp3-label" for="form-group-input">
                    Quantity
                    <span class="bp3-text-muted">*</span>
                </label>
                <div class="bp3-form-content">
                    <div class="bp3-input-group">
                        <input id="form-group-input" type="number"
                               class="bp3-input"
                               name="quantity"
                               onkeyup="calculate_amount('WT_purchase_details_form_modal')"
                               value="<?=$os->val($item_entry_detail,'quantity')?>"
                               placeholder="" dir="auto" />
                        <span class="bp3-icon" id="item_unit"></span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bp3-form-group .modifier">
                <label class="bp3-label" for="form-group-input">
                    Rate
                    <span class="bp3-text-muted">*</span>
                </label>
                <div class="bp3-form-content">
                    <div class="bp3-input-group .modifier">
                        <span class="bp3-icon">₹</span>
                        <input id="form-group-input" type="number" :modifier class="bp3-input"
                               name="rate"
                               onkeyup="calculate_amount('WT_purchase_details_form_modal')"
                               value="<?=$os->val($item_entry_detail,'rate')?>"
                               placeholder="" dir="auto" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bp3-form-group .modifier">
                <label class="bp3-label" for="form-group-input">
                    Amount
                </label>
                <div class="bp3-form-content">
                    <div class="bp3-input-group .modifier">
                        <span class="bp3-icon">₹</span>
                        <input id="form-group-input" type="text" :modifier class="bp3-input"
                               name="amount"
                               readonly
                               value="<?=$os->val($item_entry_detail,'amount')?>"
                               placeholder="" dir="auto" />
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-width-1-1">
            <p class="p-bottom-s">Select item for</p>
            <div class="uk-height-medium uk-overflow-auto">
            <?
            $for_items = @unserialize($item_entry_detail['for_items'])?@unserialize($item_entry_detail['for_items']):[];
            while ($item = $os->mfa($items_q)){ ?>
                <label class="bp3-control bp3-checkbox">
                    <input type="checkbox" value="<?=$item["item_entry_detail_id"]?>"
                           name="for_items[]"
                            <?=in_array($item["item_entry_detail_id"], $for_items)?"checked='checked'":""?>
                            />
                    <span class="bp3-control-indicator"></span>
                    <?=$item["item_name"]?>
                </label>
            <? } ?>
            </div>
        </div>

    </div>
    <script>
        $("#insert_purchase_details_form #search_item_name").selectize({
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create: false,
            sortField: 'text',
            <?if($item_entry_detail_id){?>
            items:[<?=$item_entry_detail['item_id']?>],
            options: [
                {
                    id:<?=$item_entry_detail['item_id']?>,
                    text: '<?=$item_entry_detail['item_name']?>',
                    type: '<?=$item_entry_detail['item_type']?>',
                }
            ],
            <?}?>
            render: {
                option: function(item, escape) {
                    return `
                        <div>
                            <div class="uk-grid uk-grid-collapse">
                                <div>
                                    <img src="${escape(item.photo)}"
                                         style="height: 30px; width:30px; object-fit: cover"
                                         class="uk-border-rounded m-right-m"/>
                                </div>
                                <div class="uk-width-expand">
                                    <div class="name">${escape(item.text)}</div>
                                    <div class="text-xs uk-text-primary">${escape(item.type)}</div>
                                </div>
                            </div>
                        </div>`;
                }
            },
            onChange  : function (value){
                document.querySelector('#insert_purchase_details_form #item_id').value = value;
                window["items"].forEach(el=>{
                    if(el.id==value){
                        $("#item_unit").text(el.unit);
                    }
                })
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '<?=$ajaxFilePath?>?autocomplete_items=OK',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        page_limit: 10,
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.results);
                        window["items"] = res.results;
                    }
                });
            }
        });
        $("#insert_purchase_details_form #search_brand_name").selectize({
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create:function (input, callback){
                $.ajax({
                    url: '/remote-url/',
                    type: 'GET',
                    success: function (result) {
                        if (result) {
                            callback({ id: result.id, text: input });
                        }
                    }
                });
            },
            sortField: 'text',
            <?if($item_entry_detail_id && $os->val($item_entry_detail, 'brand_id')){?>
            items:[<?=$item_entry_detail['brand_id']?>],
            options: [
                {
                    id:<?=$item_entry_detail['brand_id']?>,
                    text: '<?=$item_entry_detail['brand_name']?>',
                }
            ],
            <?}?>
            render: {
                option: function(item, escape) {
                    return `<div>
                            <span class="name">${escape(item.text)}</span>
                        </div>`;
                }
            },
            onChange  : function (value){
                document.querySelector('#insert_purchase_details_form input[name=brand_id]').value = value;
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '<?=$ajaxFilePath?>?autocomplete_brands=OK',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        page_limit: 10,
                        apikey: 'w82gs68n8m2gur98m6du5ugc'
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.results);
                    }
                });
            }
        });
        $("#insert_purchase_details_form #search_vendor_name").selectize({
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create: true,
            sortField: 'text',
            <?if($item_entry_detail_id && $os->val($item_entry_detail, 'vendor_id')){?>
            items:[<?=$item_entry_detail['vendor_id']?>],
            options: [
                {
                    id:<?=$item_entry_detail['vendor_id']?>,
                    text: '<?=$item_entry_detail['vendor_name']?>',
                }
            ],
            <?}?>
            render: {
                option: function(item, escape) {
                    return `<div>
                            <span class="name">${escape(item.text)}</span>
                        </div>`;
                }
            },
            onChange  : function (value){
                document.querySelector('#insert_purchase_details_form input[name=vendor_id]').value = value;
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '<?=$ajaxFilePath?>?autocomplete_vendors=OK',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        page_limit: 10,
                        apikey: 'w82gs68n8m2gur98m6du5ugc'
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.results);
                    }
                });
            }
        });
    </script>

    <?


}
if($os->get("get_purchase_details_transfer_form")=="OK" && $os->post("get_purchase_details_transfer_form")=="OK"){
    $item_entry_id = $os->post("item_entry_id");
    $item_entry_detail_id = $os->post("item_entry_detail_id");
    $branches = $os->get_branches_by_access_name($access_name);

    $stock = $os->mfa($os->mq("SELECT 
        (ied.amount-SUM(IF(ied_t.amount>0, ied_t.amount, 0))) AS amount,
        (ied.quantity-SUM(IF(ied_t.quantity>0, ied_t.quantity, 0))) AS quantity,
        ied.rate
    FROM item_entry_details ied 
    LEFT JOIN item_entry_details ied_t ON ied.item_entry_detail_id= ied_t.parent
    WHERE ied.item_entry_detail_id=$item_entry_detail_id"));
    ?>

    <input type="text" class="uk-hidden" name="item_entry_id" value="<?=$item_entry_id?>">
    <input type="text" class="uk-hidden" name="item_entry_detail_id" value="<?=$item_entry_detail_id?>">

    <div>
        <div class="bp3-form-group">
            <label class="bp3-label" for="form-group-input">
                Department
                <span class="bp3-text-muted">(required)</span>
            </label>
            <div class="bp3-form-content">
                <div class="bp3-input-group">
                    <div class="bp3-select bp3-fill">
                        <select name="department">
                            <?$os->onlyOption($os->departments, $department)?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="bp3-form-group">
            <label class="bp3-label" for="form-group-input">
                Transfer to
                <span class="bp3-text-muted">(required)</span>
            </label>
            <div class="bp3-form-content">
                <div class="bp3-input-group .modifier">
                    <div class="bp3-select bp3-fill">
                        <select name="branch_code">
                            <?$os->onlyOption($branches)?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-grid uk-child-width-1-3 uk-grid-small" uk-grid>
        <div>
            <div class="bp3-form-group .modifier">
                <label class="bp3-label" for="form-group-input">
                    Quantity
                    <span class="bp3-text-muted">*</span>
                </label>
                <div class="bp3-form-content">
                    <div class="bp3-input-group .modifier">
                        <input id="form-group-input" type="number" :modifier
                               class="bp3-input"
                               name="quantity"
                               onkeyup="calculate_amount('WT_purchase_details_transfer_form_modal')"
                               max="<?=$os->val($stock,'quantity')?>"
                               dir="auto" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bp3-form-group .modifier">
                <label class="bp3-label" for="form-group-input">
                    Rate
                    <span class="bp3-text-muted">*</span>
                </label>
                <div class="bp3-form-content">
                    <div class="bp3-input-group .modifier">
                        <span class="bp3-icon">₹</span>
                        <input id="form-group-input" type="number" :modifier class="bp3-input"
                               name="rate"
                               readonly
                               onkeyup="calculate_amount('WT_purchase_details_transfer_form_modal')"
                               value="<?=$os->val($stock,'rate')?>"
                               dir="auto" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bp3-form-group .modifier">
                <label class="bp3-label" for="form-group-input">
                    Amount
                </label>
                <div class="bp3-form-content">
                    <div class="bp3-input-group .modifier">
                        <span class="bp3-icon">₹</span>
                        <input id="form-group-input" type="text" :modifier class="bp3-input"
                               name="amount"
                               value="<?=$os->val($item_entry_detail,'amount')?>"
                               dir="auto" />
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>

    </script>

    <?


}

/*
 * Form Action
 */
if($os->get("insert_edit_purchase")=="OK"){
    $item_entry_id=$os->post("item_entry_id");
    $dated=$os->post("dated");
    $reff_no=$os->post("reff_no");
    $branch_code=$os->post("branch_code");

    $res = ["error"=>true, "redirect"=> $item_entry_id<=0];

    if ($reff_no=="" && $item_entry_id<=0){
        $reff_no = ucwords(date("Y/m/d/His"));
    }
    $datatosave = array(
        "dated"           => $dated,
        "reff_no"         => $reff_no,
        "department"      => $department,
        "branch_code"      => $branch_code
    );
    $item_entry_id = $os->save("item_entries", $datatosave, 'item_entry_id', $item_entry_id);


    if($item_entry_id>0){
        $res["error"]=false;
        $res["i_id"] = $item_entry_id;
    }
    header('Content-Type: application/json');
    print json_encode($res);
}
if($os->get("insert_edit_purchase_details")=="OK"){
    $item_entry_id=$os->post("item_entry_id");
    $item_entry_detail_id=$os->post("item_entry_detail_id");
    $item_id=$os->post("item_id");
    $brand_id=$os->post("brand_id");
    $vendor_id=$os->post("vendor_id");
    $quantity=$os->post("quantity") ;
    $rate=$os->post("rate")  ;
    $amount=$os->post("amount") ;
    $for_items = @serialize($os->post("for_items"));

    $datatosave = array(

        "item_entry_id"     =>$item_entry_id,
        "item_id"           =>$item_id,
        "rate"              =>$rate,
        "quantity"          =>$quantity,
        "amount"            =>$amount,
        "brand_id"          =>$brand_id,
        "vendor_id"         =>$vendor_id,
        "for_items"         =>addslashes($for_items),
    );
    $item_entry_detail_id = $os->save("item_entry_details", $datatosave, 'item_entry_detail_id', $item_entry_detail_id);

    $res = ["error"=>true];
    if($item_entry_detail_id>0){
        $res["error"]=false;
        $res["i_id"] = $item_entry_id;
        $res["i_d_id"] = $item_entry_detail_id;
    }
    header('Content-Type: application/json');
    print json_encode($res);
}

/*
 * Delete
 */
if($os->get("WT_delete_purchase_details")=="OK" && $os->post("WT_delete_purchase")=="OK"){
    $item_entry_id = $os->post("item_entry_id");
    $item_entry_detail_ids = [];
    $items_query = $os->mfa("SELECT item_entry_detail_id FROM item_entry_details WHERE item_entry_id='$item_entry_id'");
    while($item = $os->mfa($items_query)){
        $item_entry_detail_ids[] = $item["item_entry_detail_id"];
    }
    $item_entry_detail_ids = "'".implode("', '", $item_entry_detail_ids)."'";
    _d($item_entry_detail_ids);
    exit();
}

/*
 * Verification
 */
if($os->get("WT_do_verification")=="OK" && $os->post("WT_do_verification")=="OK"){
    $item_entry_id = $os->post("item_entry_id");
    $branch_code_s=$os->post("branch_code_s");
    $verify_text=$os->post("verify_text");

    $access = $secondary_access;
    if ($branch_code_s==""){
        $access = $global_access;
    }

    if(in_array("Final Verification", $access) || $os->userDetails["adminType"]=="Super Admin"){
        $datatosave = array(
            'final_verified' => 1,
            'final_verified_date' => date("Y-m-d H:i:s"),
            'final_verified_user' => $os->userDetails["adminId"],
            'primary_verified' => 1,
            'primary_verified_date' => date("Y-m-d H:i:s"),
            'primary_verified_user' => $os->userDetails["adminId"],

        );
    } else if(in_array("Primary Verification", $access)) {
        $datatosave = array(
            'primary_verified' => 1,
            'primary_verified_date' => date("Y-m-d H:i:s"),
            'primary_verified_user' => $os->userDetails["adminId"],
        );
    }

    if($verify_text=="Final Submit") {
        $datatosave = array(
            'submitted' => 1
        );
    }


    print $os->save("item_entries", $datatosave, "item_entry_id", $item_entry_id);
}
?>

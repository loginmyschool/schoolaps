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
$access_name = "Library Book Issue Report";
$ajaxFilePath= 'library_book_issue_report_ajax.php';
//

/**
 * Autocomplete
 */
if($os->get("autocomplete_items")=="OK"){

    $res = ["results"=>[]];
    $keyword = $os->get("q");
    $q = $os->mq("SELECT i.*,
       (SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',im.item_meta_key,'\":\"',im.item_meta_value,'\"')),'}') FROM item_meta im WHERE i.item_id= im.item_id ) as meta 
       FROM items  i
        WHERE i.departments LIKE '%$department%' 
          AND (i.item_name LIKE '%$keyword%' OR i.beng_name LIKE '%$keyword%' OR i.hindi_name LIKE '%$keyword%' OR i.keywords LIKE '%$keyword%')
          AND i.category_id=(SELECT ic.item_category_id FROM item_category ic WHERE ic.category_name='Books') LIMIT 0,10");

    while ($row = $os->mfa($q)){

        $item = new stdClass();
        $item->id = $row["item_id"];
        $item->text = $row["item_name"];
        $item->type = $row["item_type"];
        $item->photo = $site["url"].$row["photo"];
        $item->meta = @json_decode($row["meta"]);
        $res["results"][] = $item;
    }
    print json_encode($res);

    exit();
}
if($os->get("WT_fetch_book_issue_report")=="OK" && $os->post("WT_fetch_book_issue_report")=="OK"){

    $branch_code_s    = $os->post("branch_code_s");
    $library_id_s    = $os->post("library_id_s");
    $item_id_s    = $os->post("book_search_s");
    $date_from_s  = $os->post("date_from_s");
    $date_to_s    = $os->post("date_to_s");
    $registerNo_s    = $os->post("registerNo_s");


    $and_i_item_id_s = $os->postAndQuery("book_search_s","i.item_id","=");

    $items = [];
    $listing_query = $os->mq("SELECT 
       i.*, 
       (SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',im.item_meta_key,'\":\"',im.item_meta_value,'\"')),'}') FROM item_meta im WHERE i.item_id= im.item_id ) as meta
        FROM items i  WHERE i.category_id=(SELECT ic.item_category_id FROM item_category ic WHERE ic.category_name='Books') $and_i_item_id_s");

    while ($item = $os->mfa($listing_query)){
        $item["total"] = 0;
        $item["issued"] = 0;
        $item["not_issued"] = 0;
        $metas = @json_decode($item["meta"]);
        foreach ($metas as $key=>$val){
            $item[$key] = $val;
        }
        unset($item["meta"]);
        $items[$item["item_id"]] = $item;
    }


    $item_ids = "'".implode("','", array_keys($items))."'";
    $books = [];
    $books_query = $os->mq("SELECT iu.*, 
       IF((SELECT lbu.library_book_issue_id FROM library_book_issue lbu WHERE lbu.is_return!='1' AND lbu.item_unique_id=iu.item_unique_id AND DATE(lbu.issue_date) BETWEEN '$date_from_s' AND '$date_to_s')>0,'Yes','No') as issued
       FROM item_unique iu 
    INNER JOIN items i ON i.item_id=iu.item_id
    INNER JOIN item_unique_meta iuml on iu.item_unique_id = iuml.item_unique_id AND iuml.item_unique_meta_key='library_id' AND iuml.item_unique_meta_value='$library_id_s' 
    WHERE  iu.item_id IN ($item_ids)");



    while($book  = $os->mfa($books_query)){
        $items[$book["item_id"]]["total"]++;
        switch ($book["issued"]){
            case "Yes":
                $items[$book["item_id"]]["issued"]++;
                break;
            case "No":
                $items[$book["item_id"]]["not_issued"]++;
                break;
        }
        $books[$book["item_unique_id"]] = $book;

    }
    usort($items, function ($a, $b){
        return $b["issued"]<=>$a["issued"];
    });

    ?>


    <form target="_blank" method="post" action="<?=$ajaxFilePath?>?print_report=OK">


        <div class="uk-hidden">
        <input name="sc_branch_code" value="<?=$branch_code_s?>">
        <input name="sc_library_id" value="<?=$library_id_s?>">
        <input name="sc_item_id" value="<?=$item_id_s?>">
        <input name="sc_date_from" value="<?=$date_from_s?>">
        <input name="sc_date_to" value="<?=$date_to_s?>">
        <textarea name="sc_items"><?= serialize($items)?></textarea>
        <textarea name="sc_books"><?= serialize($books)?></textarea>
        </div>
        <label>
            <input name="with_details" value="OK" type="checkbox"> with details
        </label>
        <button class="uk-button congested-form uk-button-primary">Print</button>
    </form>
    <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
                <thead>
                <tr>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Edition</th>
                    <th>Issued</th>
                    <th>Not Issued</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>

                <?$c=0;foreach ($items as $item_id=>$item){$c++;
                    $item_id = $item["item_id"];
                    if($item["issued"]==0){
                        continue;
                    }
                    ?>
                    <tr  style="position: relative">
                        <td>
                            <a><?=$item["item_name"]?></a>
                            <div uk-drop="mode: click">
                                <div class="uk-card uk-card-body uk-card-default uk-card-small">


                                    <img alt="<?=$item["item_name"]?>" style="height:100px; width: 80px" src="<?=$site['url']?><?=$item["photo"]?>">

                                    <h4><?=$item["item_name"]?></h4>
                                    <p class="uk-margin-small-top">
                                        Author:
                                        <i class="uk-text-primary"><?=$item["Author"]?></i>
                                    </p>
                                    <p>
                                        Edition:
                                        <i class="uk-text-primary"><?=$item["Edition"]?></i>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td><?=$item["Author"]?></td>
                        <td><?=$item["Edition"]?></td>
                        <td>
                            <a><?=$item["issued"]?></a>
                            <div uk-drop="mode: click" class="uk-width-xlarge">
                                <div class="uk-card uk-card-body uk-card-default uk-card-small">
                                    <?

                                    $last_sql = $os->mq("SELECT * FROM library_book_issue lbi 
                                        INNER JOIN item_unique iu ON iu.item_unique_id = lbi.item_unique_id AND iu.item_id='$item_id'
                                        INNER JOIN item_unique_meta iuml on iu.item_unique_id = iuml.item_unique_id AND iuml.item_unique_meta_key='library_id' AND iuml.item_unique_meta_value='$library_id_s' 
                                        
                                        INNER JOIN history h ON h.studentId=lbi.studentId AND h.branch_code=(SELECT l.branch_code FROM library l WHERE l.library_id='$library_id_s')
                                        INNER JOIN student s ON h.studentId=s.studentId
                                        WHERE lbi.is_return!='1' AND DATE(lbi.issue_date) BETWEEN '$date_from_s' AND '$date_to_s'");

                                    ?>
                                    <h5 class="uk-text-normal uk-text-bold">Book Issue Details</h5>
                                    <table class="uk-table">
                                        <thead>
                                        <tr>
                                            <th>Reg. No.</th>
                                            <th>Name</th>
                                            <th class="uk-text-center">Book ID</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                        while ($issue = $os->mfa($last_sql)){
                                        ?>
                                        <tr>
                                            <td><?=$issue["registerNo"]?></td>
                                            <td><?=$issue["name"]?></td>
                                            <td class="uk-text-center">
                                                <? $os->render_barcode($issue["item_unique_id"],"18px", "80px"); ?><br>
                                                <span style="font-size: 8px"><?=$issue["item_unique_id"]?></span>
                                            </td>
                                        </tr>
                                        <?}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td><?=$item["not_issued"]?></td>
                        <td><?=$item["total"]?></td>
                    </tr>


                <?}?>
                </tbody>
            </table>
<?

    exit();
}

if($os->get("print_report")=="OK"){
    $branch_code_s    = $os->post("sc_branch_code");
    $library_id_s    = $os->post("sc_library_id");
    $item_id_s    = $os->post("sc_item_id");
    $date_from_s  = $os->post("sc_date_from");
    $date_to_s    = $os->post("sc_date_to");
    $items = unserialize($os->post("sc_items"));
    $books = unserialize($os->post("sc_books"));

    $with_details = $os->post("with_details")=="OK";

    ?>
    <html>
    <head>
        <link rel="stylesheet" href="<?=$site["root-wtos"]?>css/paper.css">
        <style>
            th, td{
                padding: 4px 5px;
                text-align: left;
            }
        </style>
    </head>
    <body class="A5">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <div style="margin-bottom: 10px">
            <fieldset title="Search Criteria" style="font-size: 12px">
                <legend style="font-size: 14px">Search criteria</legend>

                <label>Branch : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT branch_name FROM branch WHERE branch_code='$branch_code_s'"))['branch_name']?></i></label>,
                <label>Library : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT name FROM library WHERE library_id='$library_id_s'"))['name']?></i></label>,
                <label>Book : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT item_name FROM items WHERE item_id='$item_id_s'"))['item_name']?></i></label>,
                <label>Date From : <i style="color:blue"><?= $date_from_s?></i></label>,
                <label>Date To :  <i style="color:blue"><?= $date_to_s?></i></label>,
            </fieldset>
        </div>


        <table style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr style="background-color: #f1f1f1">
                <th style="border: 1px solid #999">Book</th>
                <th style="border: 1px solid #999">Author</th>
                <th style="border: 1px solid #999">Edition</th>
                <th style="border: 1px solid #999">ISBN</th>
                <th style="border: 1px solid #999">Issued</th>
            </tr>
            </thead>
            <tbody>

            <?$c=0;foreach ($items as $item_id=>$item){$c++;
                $item_id = $item["item_id"];
                if($item["issued"]==0){
                    continue;
                }
                ?>
                <tr  style="background-color: ">
                    <td style="border: 1px solid #999">
                        <h4 style="margin: 0"><?=$item["item_name"]?></h4>
                    </td>
                    <td style="border: 1px solid #999">
                        <i class="uk-text-primary"><?=$item["Author"]?></i><br>
                    </td>
                    <td style="border: 1px solid #999">
                        <i class="uk-text-primary"><?=$item["Edition"]?></i><br>
                    </td>
                    <td style="border: 1px solid #999">
                        <i class="uk-text-primary"><?=$item["ISBN"]?></i>

                    </td>
                    <td style="border: 1px solid #999">
                        <a><?=$item["issued"]?>/<?=$item["total"]?></td>
                </tr>
                <?if($with_details){?>
                    <tr style="">
                        <td colspan="5" style="padding: 0px !important;">
                            <?
                            $last_sql = $os->mq("SELECT * FROM library_book_issue lbi 
                                        INNER JOIN item_unique iu ON iu.item_unique_id = lbi.item_unique_id AND iu.item_id='$item_id'
                                        INNER JOIN item_unique_meta iuml on iu.item_unique_id = iuml.item_unique_id AND iuml.item_unique_meta_key='library_id' AND iuml.item_unique_meta_value='$library_id_s' 
                                        
                                        INNER JOIN history h ON h.studentId=lbi.studentId AND h.branch_code=(SELECT l.branch_code FROM library l WHERE l.library_id='$library_id_s')
                                        INNER JOIN student s ON h.studentId=s.studentId
                                        WHERE lbi.is_return!='1' AND DATE(lbi.issue_date) BETWEEN '$date_from_s' AND '$date_to_s'");


                            ?>
                            <table style="width: 100%; border-collapse: collapse; font-size: 12px">
                                <tr>
                                    <th style="border: 1px solid #999999">Name</th>
                                    <th style="border: 1px solid #999999">Reg. No</th>
                                    <th style="border: 1px solid #999999">Issued On</th>
                                    <th style="border: 1px solid #999999">Book ID</th>
                                    <th style="border: 1px solid #999999; text-align: center; ">Barcode</th>
                                </tr>
                                <tbody>
                                <?
                                while ($issue = $os->mfa($last_sql)){
                                    ?>
                                    <tr>
                                        <td style="border: 1px solid #999"><?=$issue["name"]?></td>
                                        <td style="border: 1px solid #999"><?=$issue["registerNo"]?></td>
                                        <td style="border: 1px solid #999"><?=$issue["issue_date"]?></td>
                                        <td style="border: 1px solid #999"><?=$issue["item_unique_id"]?></td>
                                        <td style="border: 1px solid #999; text-align: center; width: 110px" class="uk-text-center">
                                            <? $os->render_barcode($issue["item_unique_id"],"18px", "80px"); ?><br>
                                        </td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding: 5px"></td>
                    </tr>
                <?}?>
            <?}?>
            </tbody>
        </table>



    </section>
    <script>
        window.print();
    </script>
    </body>
    </html>

<?
}

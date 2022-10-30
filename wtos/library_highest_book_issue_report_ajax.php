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
$access_name = "Library Highest Book Issue Report";
$ajaxFilePath= 'library_highest_book_issue_report_ajax.php';
//

if ($os->get("update_meta")=="OK") {
    $items_meta_query = $os->mq("SELECT * FROM item_meta");
    $metas = [];
    while ($meta = $os->mfa($items_meta_query)) {

        if ($meta["item_meta_key"] =="pages_no"){
            $key = "no_of_pages";
        } else {
            $key = strtolower($meta["item_meta_key"]);
        }
        $metas[$meta["item_id"]][$key] = $meta["item_meta_value"];

        $meta = null;
        $key = null;
    }

    foreach ($metas as $item_id=>$meta){
        $os->save("items", $meta, "item_id", $item_id)."<br>";
    }

    ///unique meta
    $unique_metas_q = $os->mq("SELECT * FROM item_unique_meta");
    $unique_metas = [];
    while ($unique_meta = $os->mfa($unique_metas_q)){
        $key = $unique_meta["item_unique_meta_key"];
        $value = $unique_meta["item_unique_meta_value"];
        $unique_metas[$unique_meta["item_unique_id"]][$key]= $value;
    }
    foreach ($unique_metas as $item_unique_id=>$unique_meta){
        $os->save("item_unique", $unique_meta, "item_unique_id", $item_unique_id)."<br>";
    }
}


if($os->get("WT_fetch_book_issue_report")=="OK" && $os->post("WT_fetch_book_issue_report")=="OK"){

    $branch_code_s    = $os->post("branch_code_s");
    $library_id_s    = $os->post("library_id_s");
    $date_from_s  = $os->post("date_from_s");
    $date_to_s    = $os->post("date_to_s");



    $items = [];
    $listing_query = $os->mq("SELECT 
       i.item_id, i.item_name, i.author, i.edition, i.publisher, count(*) as issued
    FROM library_book_issue lbi  
        INNER JOIN item_unique iu ON lbi.item_unique_id=iu.item_unique_id AND iu.library_id='$library_id_s'
        INNER  JOIN items i ON i.item_id=iu.item_id  
    WHERE DATE(lbi.issue_date) BETWEEN '$date_from_s' AND '$date_to_s'
    GROUP BY i.item_id ORDER BY count(*) DESC");


    $items =[];
    while ($book = $os->mfa($listing_query)){
        $items[$book["item_id"]] = $book;
    }


    ?>
        <form id="print_form" method="post" action="<?= $ajaxFilePath?>?print_result=OK" target="_blank" style="display: none">
            <input name="sc_branch_code" value="<?=$branch_code_s?>">
            <input name="sc_library_id" value="<?=$library_id_s?>">
            <input name="sc_date_from" value="<?=$date_from_s?>">
            <input name="sc_date_to" value="<?=$date_to_s?>">
            <textarea name="items"><?=serialize($items)?></textarea>
        </form>
    <div class="p-m">
        <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
            <thead>
            <tr>
                <th>Book</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Publisher</th>
                <th>Issued</th>
            </tr>
            </thead>
            <tbody>

            <?
            $c=0;
            foreach ($items as $item_id=>$item){
                $c++;
                $item_id = $item["item_id"];
                ?>
                <tr  style="position: relative">
                    <td><?=$item["item_name"]?></td>
                    <td><?=$item["author"]?></td>
                    <td><?=$item["edition"]?></td>
                    <td><?=$item["publisher"]?></td>
                    <td><?=$item["issued"]?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <?

    exit();
}


if($os->get("print_result")=="OK"){
    $branch_code_s    = $os->post("sc_branch_code");
    $library_id_s    = $os->post("sc_library_id");
    $date_from_s  = $os->post("sc_date_from");
    $date_to_s    = $os->post("sc_date_to");
    $items   = @unserialize($os->post("items"));
    ?>
    <html>
    <head>
        <link rel="stylesheet" href="<?=$site["root-wtos"]?>css/paper.css">
        <style>
            :root{
                font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
            }
            table{
                border-collapse: collapse;
                width: 100%;
            }
            th{
                background-color: #f1f1f1;
            }
            th, td{
                padding: 3px 4px;
                text-align: left;
                border: 1px solid #666;
                font-size: 14px;
            }
        </style>
    </head>
    <body class="A5">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <div style="margin-bottom: 10px">
            <fieldset title="Search Criteria" style="font-size: 13px">
                <legend style="font-size: 14px">Search criteria</legend>

                <label>Branch : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT branch_name FROM branch WHERE branch_code='$branch_code_s'"))['branch_name']?></i></label>,
                <label>Library : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT name FROM library WHERE library_id='$library_id_s'"))['name']?></i></label>,
                <label>Date From : <i style="color:blue"><?= $date_from_s?></i></label>,
                <label>Date To :  <i style="color:blue"><?= $date_to_s?></i></label>,
            </fieldset>
        </div>
        <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
            <thead>
            <tr>
                <th>Book</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Publisher</th>
                <th>Issued</th>
            </tr>
            </thead>
            <tbody>

            <?
            $c=0;
            foreach ($items as $item_id=>$item){
                $c++;
                $item_id = $item["item_id"];
                ?>
                <tr  style="position: relative">
                    <td><?=$item["item_name"]?></td>
                    <td><?=$item["author"]?></td>
                    <td><?=$item["edition"]?></td>
                    <td><?=$item["publisher"]?></td>
                    <td><?=$item["issued"]?></td>
                </tr>
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

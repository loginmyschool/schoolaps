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
$ajaxFilePath= 'library_student_issue_report_ajax.php';
//
$access_name = "Library Student Issued Report";
$branch_codes = $os->get_branches_by_access_name($access_name);


if($os->get("WT_fetch_book_issue_report")=="OK" && $os->post("WT_fetch_book_issue_report")=="OK"){

    $branch_code_s    = $os->post("branch_code_s");
    $library_id_s    = $os->post("library_id_s");
    $asession_s  = $os->post("asession_s");
    $class_s    = $os->post("class_s");



    $items = [];
    $listing_query = $os->mq("SELECT 
       h.historyId,s.name, s.registerNo, h.branch_code,  count(*) as issued
    FROM library_book_issue lbi  
        INNER JOIN student s on lbi.studentId = s.studentId
        INNER JOIN history h ON s.studentId = h.studentId AND h.asession='$asession_s' AND h.class='$class_s' 
        INNER JOIN item_unique iu ON lbi.item_unique_id=iu.item_unique_id
    GROUP BY h.historyId ORDER BY count(*) DESC");
    $items =[];
    while ($book = $os->mfa($listing_query)){
        $items[$book["historyId"]] = $book;
    }


    ?>
        <form id="print_form" method="post" action="<?= $ajaxFilePath?>?print_result=OK" target="_blank" style="display: none">
            <input name="sc_branch_code" value="<?=$branch_code_s?>">
            <input name="sc_library_id" value="<?=$library_id_s?>">
            <input name="sc_asession" value="<?=$asession_s?>">
            <input name="sc_class" value="<?=$class_s?>">
            <textarea name="items"><?=serialize($items)?></textarea>
        </form>
    <div class="p-m">
        <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
            <thead>
            <tr>
                <th class="uk-table-shrink uk-text-nowrap">Reg. no</th>
                <th>Name</th>
                <th>Branch</th>
                <th class="uk-table-shrink uk-text-nowrap">Issued</th>
            </tr>
            </thead>
            <tbody>

            <?
            $c=0;
            foreach ($items as $item_id=>$item){
                $c++;
                ?>
                <tr >
                    <td><?=$item["registerNo"]?></td>
                    <td><?=$item["name"]?></td>
                    <td><?=@$branch_codes[$item["branch_code"]]?></td>
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
    $asession_s  = $os->post("sc_asession");
    $class_s    = $os->post("sc_class");
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

                <label class="uk-hidden">Branch : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT branch_name FROM branch WHERE branch_code='$branch_code_s'"))['branch_name']?></i></label>,
                <label class="uk-hidden">Library : <i style="color:blue"><?=@$os->mfa(@$os->mq("SELECT name FROM library WHERE library_id='$library_id_s'"))['name']?></i></label>,
                <label>Session : <i style="color:blue"><?= $asession_s?></i></label>,
                <label>Class :  <i style="color:blue"><?= $class_s?></i></label>,
            </fieldset>
        </div>
        <table class="bp3-html-table  bp3-html-table-striped uk-width-1-1" style="background-color: white">
            <thead>
            <tr>
                <th class="uk-table-shrink uk-text-nowrap">Reg. no</th>
                <th>Name</th>
                <th class="uk-table-shrink uk-text-nowrap">Issued</th>
            </tr>
            </thead>
            <tbody>

            <?
            $c=0;
            foreach ($items as $item_id=>$item){
                $c++;
                ?>
                <tr >
                    <td><?=$item["registerNo"]?></td>
                    <td><?=$item["name"]?></td>
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

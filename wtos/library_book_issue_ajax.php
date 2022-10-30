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
$branches = $os->get_branches_by_access_name("Library Book Issue");

function generate_code( $str,$length=12){
    $itr = $length-strlen($str);
    for($c=0; $c<$itr;$c++){
        $str = '0'.$str;
    }
    return $str;
}
?><?

if($os->get('WT_find_book')=='OK'&&$os->post('WT_find_book')=='OK')

{
    $and_ie_branch_code_s = $os->postAndQuery("branch_code_s","ie.branch_code","=");
    $library_id_s = $os->post("library_id_s");
    $keyword_s = $os->post("book_s");





    $query = $os->mq("SELECT iu.*, i.*
    FROM item_unique iu
        INNER JOIN item_entry_details ied on iu.item_entry_detail_id = ied.item_entry_detail_id
        INNER JOIN items i on ied.item_id = i.item_id AND i.category_id=(SELECT ic.item_category_id FROM item_category ic WHERE ic.category_name='Books')
        INNER JOIN item_entries ie on ied.item_entry_id = ie.item_entry_id  $and_ie_branch_code_s
        INNER JOIN item_unique_meta iumc ON iumc.item_unique_id = iu.item_unique_id AND iumc.item_unique_meta_key='library_id' AND iumc.item_unique_meta_value='$library_id_s'
    LEFT JOIN item_meta im ON i.item_id= im.item_id          
    LEFT JOIN item_unique_meta ium ON ium.item_unique_id=iu.item_unique_id 

    WHERE iu.is_ready='Yes' AND (im.item_meta_value LIKE  '%$keyword_s%' OR ium.item_unique_meta_value LIKE  '%$keyword_s%' OR i.item_name LIKE '%$keyword_s%' OR iu.item_unique_id='".(int)$keyword_s."') 
    GROUP BY iu.item_unique_id LIMIT 50");

    $books = [];
    $ids=[];
    $item_ids = [];
    while($book = $os->mfa($query)) {
        $books[$book["item_unique_id"]] = $book;
        $ids[]=$book["item_unique_id"];
        $item_ids[]=$book["item_id"];
    }
    $ids = "'".implode("','", $ids)."'";
    //Unique Meta
    $unique_meta_query = $os->mq("SELECT * FROM item_unique_meta WHERE item_unique_id IN($ids)");
    while ($unique_meta = $os->mfa($unique_meta_query)){
        $books[$unique_meta['item_unique_id']][$unique_meta['item_unique_meta_key']]= $unique_meta['item_unique_meta_value'];
    }
    //If issued

    $issued_query = $os->mq("SELECT * FROM library_book_issue lbi WHERE lbi.item_unique_id IN($ids) AND lbi.is_return!='1'");
    while($issued_book = $os->mfa($issued_query)){
        $books[$issued_book['item_unique_id']]["is_return"] = $issued_book;
    }

    //Item meta
    $item_metas= [];
    $item_ids = "'".implode("','", $item_ids)."'";
    $meta_query = $os->mq("SELECT * FROM item_meta WHERE item_id IN($item_ids)");
    while ($meta = $os->mfa($meta_query)){
        $item_metas[$meta['item_id']][$meta['item_meta_key']]= $meta['item_meta_value'];
    }










    ?>
    <table class="uk-table uk-table-divider uk-table-hover">
        <?foreach($books as $book){
            ?>
            <tr>
                <td width="100px">
                    <img style="height:100px; width: 80px" src="<?=$site["url"].$book["photo"]?>"/>
                </td>
                <td>
                    <h4><?=$book["item_name"]?></h4>
                    <p class="uk-margin-small-top">
                        Author:
                        <i class="uk-text-primary">
                            <?=$book["author"]?>
                        </i>
                    </p>
                    <p>
                        Edition:
                        <i class="uk-text-primary">
                            <?=$book["edition"]?>
                        </i>
                    </p>
                    <p>Rack No.: <i class="uk-text-primary"><?=$book["rack_no"]?></i></p>
                    <p>Shelf No.: <i class="uk-text-primary"><?=$book["shelf_no"]?></i></p>
                </td>
            </tr>
        <?}?>
    </table>



    <?php
    exit();

}

if($os->get('WT_fetch_history')=='OK'&&$os->post('WT_fetch_history')=='OK')

{
    $register_no = $os->post("register_no");
    $branch_code = $os->post("branch_code");
   /* $student = $os->mfa($os->mq("SELECT s.*,h.asession, h.class, h.branch_code FROM student s INNER JOIN history h on s.studentId = h.studentId AND h.asession=s.current_asession AND h.branch_code='$branch_code' WHERE s.registerNo='$register_no'"));
	*/
	 $student = $os->mfa($os->mq("SELECT s.*,h.asession, h.class, h.branch_code FROM student s INNER JOIN history h on s.studentId = h.studentId and h.branch_code='$branch_code' WHERE s.registerNo='$register_no'"));
	

    if(!$student){
        print "No student found";
        exit();
    }

    $sid = $student["studentId"];

    $books = array(
        "returned"=>array(),
        "issued"=>array()
    );
    $item_ids = [];
    $books_query = $os->mq("SELECT
       lbi.*,
       i.item_id, i.item_name, i.photo,
       (SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',im.item_meta_key,'\":\"',im.item_meta_value,'\"')),'}') FROM item_meta im WHERE i.item_id= im.item_id ) as meta,       
       (SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',ium.item_unique_meta_key,'\":\"',ium.item_unique_meta_value,'\"')),'}') FROM item_unique_meta ium WHERE ium.item_unique_id=iu.item_unique_id)as unique_meta
                    
       
       FROM library_book_issue lbi 

    INNER JOIN item_unique iu on lbi.item_unique_id = iu.item_unique_id
    INNER JOIN items i on iu.item_id = i.item_id
    WHERE lbi.studentId='$sid'");

    while($book =$os->mfa($books_query)){
        if ($book["is_return"]=="1"){
            $books["returned"][$book["library_book_issue_id"]] = $book;
        } else {
            $books["issued"][$book["library_book_issue_id"]] = $book;
        }

    }
    ?>
        <div class="p-m uk-background-primary uk-light">
            <h5><?=$student["name"]?></h5>
            <p class="uk-text-small"><?=$student["asession"]?>-<?=$os->classList[$student["class"]]?> <font color="red">[<?=$branches[$student["branch_code"]]?>]</font></p>
        </div>
    <div class="uk-grid uk-child-width-expand uk-grid-collapse" uk-grid>
        <div class="">
            <div class=" uk-background-muted" style="border-right: 1px solid #e5e5e5;">
                <h5 class="p-m">Issued Book</h5>
                <div class="uk-overflow-auto" style="height: calc(100vh - 275px); border-top:1px solid  #e5e5e5">

                    <table class="uk-table uk-table-small uk-table-divider uk-table-hover">
                        <?foreach($books["issued"] as $book){
                            $book["meta"] = (array)@json_decode($book["meta"]);
                            $book["unique_meta"] = (array)@json_decode($book["unique_meta"]);

                            ?>
                            <tr>
                                <td width="85px">
                                    <img style="height:85px; width: 75px"
                                         src="<?=$site["url"].$book["photo"]?>"/></td>
                                <td>
                                    <h5><?=$book["item_name"]?></h5>
                                    <p class="uk-text-small"><?=$book["meta"]["Author"]?></p>
                                    <p class="uk-text-small">Issue date: <i class="uk-text-success"><?=$book["issue_date"]?></i></p>
                                    <div class="uk-text-small">
                                        <a onclick="returnBook(<?=$book["library_book_issue_id"]?>)">Return</a>
                                        /
                                        <a class="uk-text-danger"
                                           onclick="removeRowAjaxFunction('library_book_issue','library_book_issue_id','<?=$book["library_book_issue_id"]?>','','','fetch_history()')">Remove</a>
                                    </div>
                                </td>
                            </tr>
                        <?}?>
                    </table>
                </div>
                <input class="uk-input uk-form-small"
                       type="number"
                       placeholder="place scan book barcode here "
                       id="issue_book_id"
                       onchange="issueBook(this.value, <?=$sid?>)">
            </div>
        </div>
        <div class="">
            <div class=" uk-background-muted">
                <h5 class="p-m">Returned Book</h5>
                <div class="uk-height-large uk-overflow-auto" style="height: calc(100vh - 245px); border-top:1px solid  #e5e5e5">
                    <table class="uk-table uk-table-small uk-table-divider uk-table-hover">
                        <?foreach($books["returned"] as $book){
                            $book["meta"] = (array)@json_decode($book["meta"]);
                            $book["unique_meta"] = (array)@json_decode($book["unique_meta"]);

                            ?>
                            <tr>
                                <td width="85px">
                                    <img style="height:85px; width: 75px"
                                         src="<?=$site["url"].$book["photo"]?>"/></td>
                                <td>
                                    <h5><?=$book["item_name"]?></h5>
                                    <p class="uk-text-small"><?=$book["meta"]["Author"]?></p>
                                    <p class="uk-text-small">Issue date: <i class="uk-text-success"><?=$book["issue_date"]?></i></p>
                                    <p class="uk-text-small">Return date: <i class="uk-text-success"><?=$book["return_date"]?></i></p>

                                </td>
                            </tr>
                        <?}?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    exit();

}

if($os->get('WT_book_issue')=='OK'&&$os->post('WT_book_issue')=='OK')

{
    $sid_s = $os->post("studentId_s");
    $iu_id = (int)$os->post("iu_id");

    $checkbookexist = $os->mfa($os->mq("SELECT * FROM item_unique  WHERE item_unique_id='$iu_id' AND is_ready='Yes'"));
    if (!$checkbookexist){
        print "No book found!";
        exit();
    }

    $already_book = $os->mfa($os->mq("SELECT * FROM library_book_issue WHERE is_return!='1' AND item_unique_id='$iu_id'"));
    if($already_book){
        print "Item Already in issued!";
        exit();
    }

    $already_item = $os->mfa($os->mq("SELECT GROUP_CONCAT(iu.item_id) ids FROM library_book_issue lbu
        INNER JOIN item_unique iu ON iu.item_unique_id=lbu.item_unique_id
        WHERE lbu.studentId='$sid_s' AND lbu.is_return!='1'"));


    $already_item = explode(",", $already_item['ids']);


    if(in_array($checkbookexist["item_id"], $already_item)){
        print "Same Book is already issued";
        exit();
    }




    $datatosave = array();
    $datatosave["issue_date"]      = $os->now();
    $datatosave["item_unique_id"]  = $iu_id;
    $datatosave["is_return"]       = 0;
    $datatosave["return_date"]     = "";
    $datatosave["studentId"]       = $sid_s;
    $datatosave["note"]            = "";
    $datatosave["addedDate"]       = $os->now();
    $datatosave["addedBy"]         = $os->userDetails['adminId'];
    $datatosave["modifyBy"]        = "0";
    $datatosave["modifyDate"]      = $os->now();


    $last_id = $os->save("library_book_issue", $datatosave);

    print "Successfully book issued";
    exit();

}

if($os->get('WT_return_book')=='OK'&&$os->post('WT_return_book')=='OK')

{
    $lbu_id = $os->post("lbu_id");
    $note = $os->post("note");



    $datatosave = array();
    $datatosave["is_return"]       = 1;
    $datatosave["return_date"]     = $os->now();;
    $datatosave["note"]            = $note;
    $datatosave["modifyBy"]        = $os->userDetails['adminId'];
    $datatosave["modifyDate"]      = $os->now();


    $last_id = $os->save("library_book_issue", $datatosave, "library_book_issue_id", $lbu_id);

    print "Successfully book issued";
    exit();

}

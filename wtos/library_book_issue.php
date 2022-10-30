<?
/*
   # wtos version : 1.1
   # main ajax process page : library_barcode_ajax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Library Barcode';
$ajaxFilePath= 'library_book_issue_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$department = "Library";
$branches = $os->get_branches_by_access_name("Library Book Issue");


?>
<div class="content without-header with-both-side-bar uk-overflow-hidden uk-height-1-1">
    <div class="item with-header  background-color-white"  style="max-width: 400px">
        <div class="item-header p-m uk-box-shadow-small">
            <h4>Book Finder</h4>
            <div class="uk-grid uk-grid-small uk-child-width-expand uk-margin-small-top" uk-grid>

                <div>
                    <select type="text" class="uk-select  congested-form select2" id="branch_code_s"
                            onchange="wt_ajax_chain('html*library_id_s*library,library_id,name*branch_code=branch_code_s','','','');">
                        <option></option>
                        <?= $os->onlyOption($branches)?>
                    </select>
                </div>
                <div>
                    <select type="text" class="uk-select  congested-form" id="library_id_s">
                    </select>
                </div>
                <div class="uk-width-1-1">
                    <input type="text" class="uk-input  uk-form-small text-l" id="book_s"
                           placeholder="Type book name or isbn author or anything..."
                           onchange="WT_findBook()"
                           onfocusin="this.value=''">

                </div>
            </div>
        </div>
        <div class="item-content uk-overflow-auto" id="WT_find_books_DIV">

        </div>
    </div>

    <div class="item with-header  background-color-white">

        <div class="item-header p-m uk-box-shadow-small">
            <input class="uk-input uk-form-small text-l"
                   placeholder="please enter student Registration no or scan barcode"
                   id="register_no_s"
                   onchange="fetch_history()"
                   onfocusin="//this.value=''">

        </div>
        <div class="item-content uk-overflow-auto" id="WT_fetch_history_DIV">

        </div>
    </div>


</div>



    <script>
        function WT_findBook(){
            let fd = new FormData();

            if($("#branch_code_s").val() ===""){alert("Please select branch");return false}
            if($("#library_id_s").val() ===""){alert("Please select library");return false}

            fd.append("WT_find_book","OK");
            fd.append("branch_code_s", $("#branch_code_s").val());
            fd.append("library_id_s", $("#library_id_s").val());
            fd.append("book_s", $("#book_s").val());
            let url="<?=$ajaxFilePath?>?WT_find_book=OK";
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc((data)=>{
                $("#WT_find_books_DIV").html(data);
            },url,fd);
        }

        function fetch_history(){
            let fd = new FormData();

            if($("#register_no_s").val() ===""){
                alert("Please select branch");
                return false
            }

            fd.append("WT_fetch_history","OK");
            fd.append("branch_code", $("#branch_code_s").val());
            fd.append("register_no", $("#register_no_s").val());
            let url="<?=$ajaxFilePath?>?WT_fetch_history=OK";
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc((data)=>{
                $("#WT_fetch_history_DIV").html(data);
                $("#issue_book_id").focus();
            },url,fd);
        }


        function issueBook(item_unique_id, studentId){

            let fd = new FormData();

            fd.append("WT_book_issue","OK");
            fd.append("studentId_s", studentId);
            fd.append("iu_id", parseInt(item_unique_id));
            let url="<?=$ajaxFilePath?>?WT_book_issue=OK";
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc((data)=>{
                alert(data);
                fetch_history();
            },url,fd);
        }

        function returnBook(library_book_issue_id){
            let note = prompt("Any Note?");

            if (!note){
                return;
            }
            let fd = new FormData();

            fd.append("WT_return_book","OK");
            fd.append("lbu_id", library_book_issue_id);
            fd.append("note", note);
            let url="<?=$ajaxFilePath?>?WT_return_book=OK";
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc((data)=>{
                alert(data);
                fetch_history();
            },url,fd);

        }



    </script>




<? include($site['root-wtos'].'bottom.php'); ?>

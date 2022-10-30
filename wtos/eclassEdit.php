<?php
/*
   # wtos version : 1.1
   # List Page : eclassList.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?php

$editPage='eclassEdit.php';
$listPage='eclassList.php';
$primeryTable='eclass';
$primeryField='eclass_id';
$pageHeader='Add new eclass';


$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());
$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId)
{
    $pageHeader='Edit  eclass';
}


##  update row
if($os->post('operation'))
{

    if($os->post('operation')=='updateField')
    {
        $rowId=$os->post('rowId');

        #---- edit section ----#

        $dataToSave['adminId']=addslashes($os->post('adminId'));
        $dataToSave['class']=addslashes($os->post('class'));
        $dataToSave['subject_id']=addslashes($os->post('subject_id'));
        $dataToSave['chapter']=addslashes($os->post('chapter'));
        $dataToSave['topic']=addslashes($os->post('topic'));
        $dataToSave['title']=addslashes($os->post('title'));
        $dataToSave['search_keys']=addslashes($os->post('search_keys'));
        $dataToSave['description']=addslashes($os->post('description'));
        $dataToSave['dated']=$os->saveDate($os->post('dated'));
        $dataToSave['meeting_password']=addslashes($os->post('meeting_password'));
        $dataToSave['meeting_link']=addslashes($os->post('meeting_link'));
        $dataToSave['active_status']=addslashes($os->post('active_status'));
        $dataToSave['video_link']=addslashes($os->post('video_link'));
        $dataToSave['for_non_subscriber']=$os->post('for_non_subscriber')>0?1:0;


        if($rowId < 1){
            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];
        }




        $editRowId = $os->saveTable($primeryTable,$dataToSave,$primeryField,$rowId);
        $os->mq("DELETE FROM eclass_access WHERE eclass_id='$editRowId'");
        $ds = $os->post("access");
        foreach ($ds as $d){
            $d["eclass_id"] = $editRowId;
            $os->save("eclass_access", $d);
        }

        //files
        $os->mq("DELETE FROM eclass_doc WHERE eclass_id='$editRowId'");
        $docs = $os->post("doc");
        foreach ($docs as $doc){
            unset($doc["file_type"]);
            unset($doc["file_type"]);
            $doc["eclass_id"] = $editRowId;
            $os->save("eclass_doc", $doc);
        }



        $flashMsg=($rowId)?'Record Updated Successfully':'Record Added Successfully';

        $os->flashMessage($primeryTable,$flashMsg);

        $os->redirect($os->post('redirectLink'));
        #---- edit section end ----#

    }


}


$pageData='';
if($editRowId)
{

    $os->data=$os->rowByField('',$primeryTable,$primeryField,$editRowId);

}
$os->showFlash($os->flashMessage($primeryTable));
?>


<?php
include "tinyMCE.php";
$subjects = $os->db->query("SELECT * FROM subject")->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
    let subjects = JSON.parse('<?= json_encode($subjects)?>');
    let class_subjects = subjects.reduce(function (lump={}, ob){
        lump[ob.classId] = lump[ob.classId]?lump[ob.classId]:[];
        lump[ob.classId].push(ob);
        return lump;
    },{});
</script>

<div class="p-m">

    <form action="<?php echo $editPageLink ?>" method="post" enctype="multipart/form-data" id="submitFormDataId">



        <div class="uk-card uk-card-default uk-card-small uk-margin-small">
            <div class="uk-card-header">
                <h3>Class Details</h3>
            </div>
            <div class="uk-card-body">


                <div class="uk-grid-small" uk-grid>

                    <div class="uk-width-1-3@m">
                        <label>Teacher </label>
                        <div> <select name="adminId" id="adminId" class="uk-select" >
                                <option value="">Select Teacher</option>
                                <?php $os->optionsHTML($os->getVal('adminId'),'adminId','name','admin');?>
                            </select> </div>
                    </div>
                    <div class="uk-width-1-3@m">
                        <label>Class </label>
                        <div><select id="class" name="class" class="uk-select"
						  onchange="wt_ajax_chain('html*subject_id*subject,subjectId,subjectName*classId=class','','','reset_s_c_t_chain(\'ct\')');" >
                                <option></option>
                                <?php $os->onlyOption($os->classList, $os->getVal('class'))?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-1-3@m">
                        <label>Subject </label>
                        <div>

                            <select name="subject_id" id="subject_id" class="uk-select"
							 onchange="wt_ajax_chain('html*chapter*question_chapter,question_chapter_id,title*subject_id=subject_id','','','reset_s_c_t_chain(\'t\')');">
                                <option value="">Select Subject</option>
                                <?
                                $sub = array_filter($subjects, function ($ob) use ($os){
                                    if($os->getVal('class')==$ob["classId"]){
                                        return true;
                                    } else return false;
                                });

                                foreach ($sub as $s){
                                    ?>
                                    <option value="<?= $s["subjectId"]?>" <?=$s["subjectId"]==$os->getVal('subject_id')?"selected":""?>><?= $s["subjectName"]?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div>
                        <label>Active Status </label>
                        <div>
                            <select name="active_status" id="active_status" class="uk-select" >
                                <option value="">Select Active Status</option>
                                <?php $os->onlyOption($os->activeStatus,$os->getVal('active_status'));?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-expand@m uk-hidden">
                        <label>Chapter </label>
                        <div>

                            <select name="chapter" id="chapter" class="uk-select"
							 onchange="wt_ajax_chain('html*topic*question_topic,question_topic_id,title*question_chapter_id=chapter','','','');">

							<option value="">Select Chapter</option> </select>	 </div>
                    </div>
                    <div class="uk-width-expand@m uk-hidden">
                        <label>Topic </label>
                        <div>

                            <select name="topic" id="topic" class="uk-select" ><option value="">Select Topic</option>  </select>	 </div>
                    </div>
                    <div class="uk-width-auto@m">
                        <div>Dated </div>
                        <div><input value="<?php  echo $os->showDate( $os->getVal('dated'));?>" type="text" name="dated" id="dated" class="wtDateClass uk-input"/></div>
                    </div>

                    <div class="uk-width-1-1">
                        <input value="1" <?= $os->getVal('for_non_subscriber')>0?"checked":""?> type="checkbox" name="for_non_subscriber" id="for_non_subscriber" class="uk-checkbox"/>
                        <label for="for_non_subscriber"> Set as Free Class (Show for all subscriber and nonsubscriber)</label>
                    </div>

                    <div class="uk-width-1-1">
                        <label>Title </label>
                        <div><input  value="<?php echo $os->getVal('title') ?>" type="text" name="title" id="title" class="uk-input"/> </div>
                    </div>

                    <div class="uk-width-1-1">
                        <label>Video Link </label>
                        <div class="uk-inline uk-width-1-1">
                            <input  value="<?php echo $os->getVal('video_link') ?>" type="text" name="video_link" id="video_link" class="uk-input"/>
                            <a class="uk-form-icon uk-form-icon-flip" target="_blank" href="https://cdn.globalclasstech.com/" uk-icon="icon:cloud-upload"></a>
                        </div>
                        <div id="video_upload_modal" uk-modal>
                            <div class="uk-modal-dialog">
                                <div class="uk-card uk-card-small uk-card-default">
                                    <div class="uk-card-header uk-margin-remove">
                                        <h5>File Upload</h5>
                                    </div>
                                    <div class=" uk-margin-remove">
                                        <progress  class="uk-progress" id="video_progressbar" value="0"></progress>

                                        <div class="uk-padding-small">

                                            <input id="input_video" name="file" type="file" accept="video/mp4,video/x-m4v,video/*">

                                            <button onclick="upload_video()" name="upload_file" value="OK" class="uk-button uk-button-primary uk-margin-small uk-border-rounded congested-form">Save</button>
                                        </div>
                                    </div>

                                </div>
                            </div>



                        </div>
                        <script>
                            function upload_video(){
                                var file = document.querySelector("#input_video").files[0];
                                var fd = new FormData();
                                fd.append("file", file);
                                fd.append("upload_file", "OK");
                                var url='wtosAjax.php?upload_file=OK&';

                                $.ajax({
                                    xhr: function() {
                                        let xhr = new window.XMLHttpRequest();
                                        let progressbar = document.querySelector("#video_progressbar");

                                        xhr.upload.addEventListener("progress", function(evt) {
                                            if (evt.lengthComputable) {
                                                progressbar.max = evt.total;
                                                progressbar.value = evt.loaded;
                                            }
                                        }, false);

                                        return xhr;
                                    },
                                    url: url,
                                    type: "POST",
                                    data: fd,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                    success: function(result) {
                                        $("#video_link").val(result);
                                        UIkit.modal("#video_upload_modal").hide();
                                    }
                                });
                            }

                        </script>
                    </div>
                    <div class="uk-width-1-1 uk-hidden
">
                        <div>Keywords </div>
                        <div><textarea class="uk-textarea uk-form-small" name="search_keys" id="search_keys" ><?php echo $os->getVal('search_keys') ?></textarea></div>
                    </div>
                    <div class="uk-width-1-1">
                        <label>Description </label>
                        <div><textarea class="tmce" name="description" id="description" ><?php echo $os->getVal('description') ?></textarea></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="uk-card uk-card-default uk-card-small uk-margin-small">
            <div class="uk-card-header">
                <h3>Access</h3>
            </div>
            <div>
                <?php
                $accesses = $os->mq("SELECT * FROM eclass_access WHERE eclass_id='$editRowId'");
                ?>
                <table class="uk-table uk-table-small uk-table-striped">
                    <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th class="uk-hidden">Gender</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                    </thead>
                    <tbody id="access_div">
                    <?php
                    $count=0;
                    $branches = $os->get_branches();
                    while ($access = $os->mfa($accesses)){?>
                        <tr id="access_row_<?=$count?>">
                            <td><input class="uk-hidden" value="<?= $access["branch_code"]?>" name="access[<?=$count?>][branch_code]"><?= @$branches[$access["branch_code"]]["branch_name"]?></td>
                            <td><input class="uk-hidden" value="<?= $access["class"]?>" name="access[<?=$count?>][class]"><?= @$os->classList[$access["class"]]?></td>
                            <td><input class="uk-hidden" value="<?= $access["session"]?>" name="access[<?=$count?>][session]"><?= $access["session"]?></td>
                            <td class="uk-hidden"><input class="uk-hidden" value="<?= $access["gender"]?>" name="access[<?=$count?>][gender]"><?= $access["gender"]?></td>
                            <td><a class="uk-text-danger" onclick="document.querySelector('#access_row_<?=$count?>').remove()">X</a></td>
                        </tr>
                        <?php $count++;}?>

                    </tbody>
                    <tfoot>
                    <script>
                        var last_count = <?=$count?>;
                        function add_access_row(){
                            const branch_code = document.querySelector("#access_branch");
                            const classs = document.querySelector("#access_class");
                            const session = document.querySelector("#access_session");
                            const gender = document.querySelector("#access_gender");

                            let container = document.querySelector("#access_div");

                            let access_row = `<tr id="access_row_${last_count}">
                                <td><input class="uk-hidden" value="${branch_code.value}" name="access[${last_count}][branch_code]">${branch_code.options[branch_code.selectedIndex].text}</td>
                                <td><input class="uk-hidden" value="${classs.value}" name="access[${last_count}][class]">${classs.options[classs.selectedIndex].text}</td>
                                <td><input class="uk-hidden" value="${session.value}" name="access[${last_count}][session]">${session.value}</td>
                                <td class="uk-hidden"><input value="${gender.value}" name="access[${last_count}][gender]">${gender.options[gender.selectedIndex].text}</td>
                                <td><a class="uk-text-danger" onclick="document.querySelector('#access_row_${last_count}').remove()">X</a></td>
                            </tr>`;
                            container.innerHTML+=access_row;

                            branch_code.value="";
                            classs.value="";
                            session.value="";
                            gender.value="";
                            last_count++;
                        }
                    </script>
                    <tr>
                        <td>
                            <select id="access_branch" class="uk-select select2">
                                <option></option>
                                <?php $os->onlyOption($os->get_branches_by_access_name("E-Class")); ?>
                            </select>
                        </td>
                        <td>
                            <select id="access_class" name="" class="uk-select">
                                <option></option>
                                <?php $os->onlyOption($os->classList); ?>
                            </select>
                        </td>
                        <td>
                            <select id="access_session" name="" class="uk-select">
                                <?php $os->onlyOption($os->asession); ?>
                            </select>
                        </td>
                        <td class="uk-hidden">
                            <select id="access_gender" name="" class="uk-select">
                                <option></option>
                                <?php $os->onlyOption($os->gender); ?>
                            </select>
                        </td>
                        <td><a onclick="add_access_row()">Add</a></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="uk-card uk-card-default uk-card-small uk-margin-small">
            <div class="uk-card-header">
                <h3>Files</h3>
            </div>
            <div>

                <table class="uk-table uk-table-small uk-table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>File</th>
                        <th class="uk-hidden">Type</th>
                        <th class="uk-hidden">File Type</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="docs">
                    <?php
                    $eclass_docs = $os->mq("SELECT * FROM eclass_doc WHERE eclass_id='$editRowId'");
                    $last_doc_count = 0;
                    while ($eclass_doc = $os->mfa($eclass_docs)){?>
                        <tr id="doc_row_<?=$last_doc_count;?>">
                            <td><input type="hidden" name="doc[<?=$last_doc_count?>][title]" value="<?= $eclass_doc["title"];?>"/><?= $eclass_doc["title"];?></td>
                            <td><input type="hidden" name="doc[<?=$last_doc_count?>][file]"  value="<?= $eclass_doc["file"];?>"/><?= $eclass_doc["file"];?></td>
                            <td class="uk-hidden"><input type="hidden" name="doc[<?=$last_doc_count?>][type]"  value="<?= $eclass_doc["type"];?>"/><?= $os->eclass_material_type[$eclass_doc["type"]];?></td>
                            <td class="uk-hidden"><input type="hidden" name="doc[<?=$last_doc_count?>][file_type]"  value="<?= $eclass_doc["file_type"];?>"/><?= $eclass_doc["file_type"];?></td>
                            <td class="uk-table-shrink"><a  onclick="document.querySelector('#doc_row_<?=$last_doc_count;?>').remove()">x</a></td>
                        </tr>
                        <?php
                        $last_doc_count++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <input type="text" id="doc_title" class="uk-input">

                        </td>
                        <td>
                            <input type="text" id="doc_file" class="uk-input"  style="max-width: calc(100% - 60px)">
                            <a class="uk-button congested-form uk-button-default" uk-toggle="#file_upload_modal"><span class="" uk-icon="file-text"></span></a>
                            <div id="file_upload_modal" uk-modal>
                                <div class="uk-modal-dialog">
                                    <div class="uk-card uk-card-small uk-card-default">
                                        <div class="uk-card-header">
                                            <h5>File Upload</h5>
                                        </div>
                                        <div class="uk-card-body">

                                                <input id="input_file" name="file" class="uk-input uk-form-small uk-margin-small" type="file">
                                                <button onclick="upload_file()" name="upload_file" value="OK" class="uk-button uk-button-small uk-button-primary uk-margin-small">Save</button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="uk-hidden">
                            <select type="text" id="doc_type" class="uk-select">
                                <?php $os->onlyOption($os->eclass_material_type)?>
                            </select>
                        </td>
                        <td class="uk-hidden">
                            <input type="text" id="doc_file_type" class="uk-input">
                        </td>
                        <td><a onclick="add_doc()">Add</a></td>
                    </tr>
                    </tfoot>
                </table>

                <script>
                    let last_doc_count = <?= $last_doc_count?>;
                    const eclass_material_type = <?= json_encode($os->eclass_material_type)?>;

                    function add_doc(){
                        const title = $("#doc_title").val();
                        const file = $("#doc_file").val();
                        const type = $("#doc_type").val();
                        const file_type = $("#doc_file_type").val();


                        const el = `
                        <tr id="doc_row_${last_doc_count}">
                            <td><input type="hidden" name="doc[${last_doc_count}][title]" value="${title}"/>${title}</td>
                            <td><input type="hidden" name="doc[${last_doc_count}][file]"  value="${file}"/>${file}</td>
                            <td class="uk-hidden"><input type="hidden" name="doc[${last_doc_count}][type]"  value="${type}"/>${eclass_material_type[type]}</td>
                            <td class="uk-hidden"><input type="hidden" name="doc[${last_doc_count}][file_type]"  value="${file_type}"/>${file_type}</td>
                            <td class="uk-table-shrink"><a  onclick="document.querySelector('#doc_row_${last_doc_count}').remove()">x</a></td>
                        </tr>
                        `;
                        document.querySelector("#docs").innerHTML+=el;

                        $("#doc_title").val("");
                        $("#doc_file").val("");
                        $("#doc_type").val("");
                        $("#doc_file_type").val("");
                        last_doc_count++;
                    }



                    function upload_file(id){
                        var file = document.querySelector("#input_file").files[0];
                        var fd = new FormData();
                        fd.append("file", file);
                        fd.append("upload_file", "OK");
                        var url='wtosAjax.php?upload_file=OK&';
                        os.animateMe.div='div_busy';
                        os.animateMe.html='Please Wait..';
                        os.setAjaxFunc((filename)=>{
                            $("#doc_file").val(filename);
                            UIkit.modal("#file_upload_modal").hide();
                        },url,fd);
                    }



                </script>

            </div>
        </div>


        <?php if($os->access('wtEdit')){ ?> 	<input type="button" class="submit" value="Save" onclick="submitFormData()" />     <?php } ?>
        <input type="button" class="submit"  value="Back to List" onclick="javascript:window.location='<?php echo $listPageLink ?>';" />
        <input type="hidden" name="redirectLink"  value="<?php echo $os->server('HTTP_REFERER'); ?>" />
        <input type="hidden" name="rowId" value="<?php   echo  $os->getVal($primeryField) ;?>" />
        <input type="hidden" name="operation" value="updateField" />
    </form>
</div>
<script>
    function submitFormData()
    {
        if(os.check.empty('adminId','Please Add Teacher')==false){ return false;}
        if(os.check.empty('class','Please Add Class')==false){ return false;}
        if(os.check.empty('subject_id','Please Add Subject')==false){ return false;}
        //if(os.check.empty('chapter','Please Add Chapter')==false){ return false;}
        //if(os.check.empty('topic','Please Add Topic')==false){ return false;}
        if(os.check.empty('title','Please Add Title')==false){ return false;}
        //if(os.check.empty('description','Please Add Description')==false){ return false;}
        if(os.check.empty('dated','Please Add Dated')==false){ return false;}
        //if(os.check.empty('active_status','Please Add Active Status')==false){ return false;}


        os.submitForm('submitFormDataId');

    }
	function reset_s_c_t_chain(chain)
	{
	  os.setHtml('topic','');
	  if(chain=='ct')
	  {
	  	os.setHtml('chapter','') ;
	  }




	}
</script>

<?php include($site['root-wtos'].'bottom.php'); ?>

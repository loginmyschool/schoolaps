<?
/*
   # wtos version : 1.1
   # Edit page: eclassEdit.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><?

$editPage='eclassEdit.php';
$listPage='eclassList.php';
$primeryField='eclass_id';
$pageHeader='List eclass';
$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());


##  delete row
if($os->get('operation')=='deleteRow')
{
    if($os->deleteRow('eclass',$primeryField,$os->get('delId')))
    {
        $flashMsg='Data Deleted Successfully';

        $os->flashMessage('eclass',$flashMsg);
        $os->redirect($site['url-wtos'].$listPage);

    }
}


##  fetch row

/* searching */
$andtopic = "";
$andclassA=  $os->andField('class_s','class','e.eclass','%');
$class_s=$andclassA['value']; $andclass=$andclassA['andField'];
$andsubject_idA=  $os->andField('subject_id_s','subject_id','e.eclass','=');
$subject_id_s=$andsubject_idA['value']; $andsubject_id=$andsubject_idA['andField'];
$andchapterA=  $os->andField('chapter_s','chapter','e.eclass','=');
$chapter_s=$andchapterA['value']; $andchapter=$andchapterA['andField'];

$f_dated_s= $os->setNget('f_dated_s'); $t_dated_s= $os->setNget('t_dated_s');
$anddated=$os->DateQ('e.dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');

$searchKey=$os->setNget('searchKey','eclass');
$whereFullQuery='';
if($searchKey!=''){
    $whereFullQuery ="and ( e.class like '%$searchKey%')";

}

$listingQuery=" select e.* from eclass e 
 LEFT JOIN eclass_access ea ON ea.eclass_id = e.eclass_id
 where e.eclass_id>0   $whereFullQuery    $andclass  $andsubject_id  $andchapter  $andtopic  $anddated   order by  $primeryField desc  ";
##  fetch row

$resource=$os->pagingQuery($listingQuery,$os->showPerPage);
$records=$resource['resource'];


$os->showFlash($os->flashMessage('eclass'));
?>
<div class="title-bar p-m">
    <h4><?php  echo $pageHeader; ?> </h4>
</div>
<div class="p-m">
    <div class="search"  >

        <td class="buttonSa">




            Search Key
            <input type="text" id="searchKey"  value="<? echo $searchKey ?>" />


            Class:
            <select type="text" class="wtTextClass" name="class_s" id="class_s"
                    onchange="wt_ajax_chain('html*subject_id_s*subject,subjectId,subjectId*classId=class_s','','callback_subject_list','');" >
                <option></option>
                <? $os->onlyOption($os->classList, $class_s)?>
            </select>&nbsp;

            Subject:
            <select name="subject_id" id="subject_id_s" class="textbox fWidth" ><option value="">Select Subject</option>
                <? $os->onlyOption($os->yesNo,$subject_id_s);	?>
            </select>


            <div style="display:none" id="advanceSearchDiv">



                Chapter:

                <select name="chapter" id="chapter_s" class="textbox fWidth" ><option value="">Select Chapter</option>	<?
                    $os->onlyOption($os->yesNo,$chapter_s);	?></select>
                From Dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value="<? echo $f_dated_s?>"  /> &nbsp;   To Dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value="<? echo $t_dated_s?>"  /> &nbsp;

            </div>

            <button class="uk-button uk-button-primary congested-form" href="javascript:void(0)" onclick="javascript:searchText()">Search</button>
            <button class="uk-button uk-button-primary congested-form" href="javascript:void(0)" onclick="javascript:searchReset()">Reset</button>
            <button class="uk-button uk-button-primary congested-form" href="">Refresh</button>
            <button class="uk-button uk-button-primary congested-form" href="javascript:void(0)" style="text-decoration:none;" onclick="os.editRecord('<? echo $editPageLink?>0') ">Add New Record</button>

    </div>





    <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <?php  echo $resource['links'];?>		</div>

    <table class="uk-table  uk-card uk-card-default uk-table-striped" >
        <thead>
        <tr>
            <th>#</th>
            <th>Action </th>
            <th>Teacher</th>
            <th>Class</th>
            <th>Subject</th>
            <th class="uk-hidden">Chapter</th>
            <th class="uk-hidden">Topic</th>
            <th>Title</th>
            <th class="uk-hidden">Keywords</th>
            <th class="uk-hidden">Description</th>
            <th>Dated</th>
            <th>Active Status</th>


        </tr>
        </thead>
        <tbody>

        <?php
        $serial=$os->val($resource,'serial');
        $subjects = $os->getSubjectList();
        while(  $record=$os->mfa($records )){
            $serial++;
            $rowId=$record[$primeryField];



            ?>
            <tr>
                <td><?php echo $serial?>      </td>

                <td class="uk-text-nowrap">
                    <? if($os->access('wtEdit')){ ?> <a href="javascript:void(0)" onclick="os.editRecord('<?   echo $editPageLink ?><?php echo $rowId  ?>')">Edit</a><? } ?>
                    <? if($os->access('wtDelete')){ ?> 	<a href="javascript:void(0)" onclick="os.deleteRecord('<?php echo  $rowId ?>') ">Delete</a><? } ?>
                </td>

                <td><? echo $os->rowByField('name','admin','adminId',$record['adminId']); ?></td>
                <td><?php echo $os->classList[$record['class']]?> </td>
                <td><? echo $os->val($subjects,$record['subject_id']); ?> </td>
                <td class="uk-hidden"><? echo $os->val($os->yesNo,$record['chapter']); ?> </td>
                <td class="uk-hidden"><? echo $os->val($os->yesNo,$record['topic']); ?> </td>
                <td><?php echo $record['title']?> </td>
                <td class="uk-hidden"><?php echo $record['search_keys']?> </td>
                <td class="uk-hidden"><?php echo $record['description']?> </td>
                <td class="uk-text-nowrap"><?php echo $os->showDate($record['dated']);?> </td>
                <td><? echo $os->val($os->activeStatus,$record['active_status']); ?> </td>



            </tr>



            <?php
        }
        ?>
        </tbody>


    </table>


</div>




<script>

    function searchText()
    {


        var class_sVal= os.getVal('class_s');
        var subject_id_sVal= os.getVal('subject_id_s');
        var chapter_sVal= os.getVal('chapter_s');
        var topic_sVal= os.getVal('topic_s');
        var f_dated_sVal= os.getVal('f_dated_s');
        var t_dated_sVal= os.getVal('t_dated_s');
        var searchKeyVal= os.getVal('searchKey');
        window.location='<?php echo $listPageLink; ?>class_s='+class_sVal +'&subject_id_s='+subject_id_sVal +'&chapter_s='+chapter_sVal +'&topic_s='+topic_sVal +'&f_dated_s='+f_dated_sVal +'&t_dated_s='+t_dated_sVal +'&searchKey='+searchKeyVal +'&';

    }
    function  searchReset()
    {

        window.location='<?php echo $listPageLink; ?>class_s=&subject_id_s=&chapter_s=&topic_s=&f_dated_s=&t_dated_s=&searchKey=&';


    }

    // dateCalander();

</script>


<? include($site['root-wtos'].'bottom.php'); ?>

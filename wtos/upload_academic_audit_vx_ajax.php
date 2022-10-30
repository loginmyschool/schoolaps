<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?>
<?
if($os->get('upload_doc')=='OK'&&$os->post('upload_doc')=='OKS'){
    $image=$os->UploadPhoto('image',$site['root'].'upload_document');
    $doc_title=$os->post('doc_title');
    $location=$os->post('location');
    $img_upload_div_name=$os->post('img_upload_div_name');
    $file_size = $_FILES['image']['size'];
    $file_type = $_FILES['image']['type'];
    echo $os->post('img_fld_name').'##'.$os->post('image_title_fld_name').'##'.$os->post('upload_btn_name').'##'.$os->post('img_upload_div_name').'##';
    if($image!=''){
        $img_link='upload_document/'.$image;}
        $rand_no=rand(1,10000);
        ?>
        <tr id="con_<?echo $rand_no;?>">
            <td style="width:50px; padding: 3px 0">
                <?if(explode("/",$file_type)[0]=="image"){?>
                    <img src="<?echo $site['url'].$img_link?>" style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #e5e5e5">
                    <?} else { ?>
                        <div class="uk-flex uk-flex-middle uk-flex-center" style="height: 35px; width: 35px; font-size: 11px; color: var(--color-primary-dark); background-color: #fafafa; border: 1px solid #e5e5e5">
                            <?= strtoupper(explode("/",$file_type)[1]);?>
                        </div>
                        <?}?>

                    </td>
                    <td style="line-height: 1" valign="middle">
                        <?echo $doc_title?><br>
                        <div >
                            <small class="color-acent" style="font-size: 11px"><?= round($file_size/1024)."KB"?></small>
                            &bull;
                            <small class="color-acent" style="font-size: 11px"><?= strtoupper(explode("/",$file_type)[1])?></small>
                        </div>
                        <input type="hidden"  name="doc[<?echo $rand_no?>][location]" class="uk-input uk-form-small" value="<?php echo $location?>" />
                        <input type="hidden"  name="doc[<?echo $rand_no?>][doc_name]" class="uk-input uk-form-small" value="<?echo $doc_title?>" />
                        <input type="hidden" name="doc[<?echo $rand_no?>][file_link]" value="<?echo $img_link?>" />
                    </td>
                    <td style="width: 30px; text-align: right">
                        <a style="color: red" href="javascript:void(0)"
                        onclick="if(confirm('Are you sure?')){$('#con_<?echo $rand_no;?>').remove();}" uk-icon="close"></a>
                    </td>
                </tr>
                <?exit;
            }
            if($os->get('delete_doc')=='OK'){
                $academic_audit_doc_id=$os->post('academic_audit_doc_id');
                if($academic_audit_doc_id>0){
                    $updateQuery="delete from academic_audit_doc where academic_audit_doc_id='$academic_audit_doc_id'";
                   $os->mq($updateQuery);
                   echo 'Record Deleted Successfully';
               }
               exit();
           }
       ?>
<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$monthly_academic_audit_vx_id = $os->get('id');
$monthly_academic_audit_vx_mq = $os->mq("SELECT * FROM monthly_academic_audit_vx where  monthly_academic_audit_vx_id='$monthly_academic_audit_vx_id'");
$data=$os->mfa($monthly_academic_audit_vx_mq);
$non_scolastic_data=json_decode($data['non_scolastic_data'], TRUE);
$reading_skill_test=json_decode($data['reading_skill_test'], TRUE);
$motivational_programme=json_decode($data['motivational_programme'], TRUE);
$parent_teacher_meeting=json_decode($data['parent_teacher_meeting'], TRUE);
$meeting_with_student=json_decode($data['meeting_with_student'], TRUE);
$no_of_foundation_class_for_viii=json_decode($data['no_of_foundation_class_for_viii'], TRUE);
$no_of_foundation_class_for_ix=json_decode($data['no_of_foundation_class_for_ix'], TRUE);
?>
<? include('wtosHeader.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Icard </title>
    <link rel="stylesheet" href="<? echo $site['themePath']?>css/uikit.css" />
    <script src="<? echo $site['themePath']?>js/uikit.js"></script>
    <script src="<? echo $site['themePath']?>js/uikit-icons.js"></script>
    <style type="text/css">
        .uk-table{width: 80%;<? echo $os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?>}
    </style>
</head>

<body>
    <div style="width:100%; padding:15px;text-align:center;" id="printBtn">
        <input type="button" onclick="printPage()" value="Print" />
    </div>
    
    <? 
    $listingQuery="  select * from school_setting where school_setting_id>0   $where      order by school_setting_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
    $record=$os->mfa( $rsRecords);
    ?>
    <? ob_start();?> 
    <div class="head">
        <div style=" height:100px; width:100px; margin:auto">   <img src="<?php  echo $site['url'].$record['logoimage']; ?>"  style="height: 100px; width: 100px" /> </div>

        <div style="font-size:20px; font-weight:bold; text-align:center;">
            Monthly Academic Audit (MAA)
        </div>
        
        <div style="font-size:14px; font-weight:200; text-align:center;">
         <? echo $os->rowByField('branch_name','branch','branch_code',$data['branch_code']); ?> (V to X)
     </div>

     <div style="font-size:17px; font-weight:200; text-align:center; margin:auto; width:120px; border:1px solid #333333; border-radius:5px; margin-top:10px;">
         <?php echo $os->rentMonth[$data['month']] ;?>  <?php echo $data['year'] ;?>
     </div>


     <div style=" border-bottom:1px solid #000000; margin:10px 0px;">

     </div>
 </div>

 <? $head=ob_get_clean();?>
 <? function footer_text($page=1){ 
    global $data,$os;
    ?>
    <div style=" border-bottom:1px solid #000000; margin:10px 0px;">

    </div>
    <div style="font-size:10px"> Entry By : <? echo $os->rowByField('name','admin','adminId',$data['entry_by_admin_id']); ?>  
    <?php  echo $os->showDate( $data['entry_date']);?> &nbsp; Page No : <? echo $page ?> &nbsp; Print Date <? echo date('Y-m-d'); ?>
</div> <div style="break-after:page"></div>
<?  } ?>


<div style="background-color:#FFFFFF; font-size:12px; text-align:center;">
  <?  echo $head;?>

  <div class="head_style" > Non-Scholastic Data (class wise):</div>
  <table class="uk-table uk-table-small listTable uk-table-small">
    <tr class="borderTitle">
        <td>Class</td>
        <td>Once</td>
        <td>Twice</td>
        <td>Not done</td>
        <td style="width: 200px;">Date</td>
    </tr>
    <tr>
        <td>V</td>
        <td><?php echo isset($non_scolastic_data['v_once'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['v_twice'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['v_not_done'])?"&checkmark;":""?></td>
        <td><?php  echo $os->showDate( $non_scolastic_data['v_dated']);?></td>
    </tr>
    <tr>
        <td>VI</td>
        <td><?php echo isset($non_scolastic_data['vi_once'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['vi_twice'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['vi_not_done'])?"&checkmark;":""?></td>
        <td><?php  echo $os->showDate( $non_scolastic_data['vi_dated']);?></td>
    </tr>
    <tr>
        <td>VII</td>
        <td><?php echo isset($non_scolastic_data['vii_once'])?"&checkmark;":""?></td>
        <td> <?php echo isset($non_scolastic_data['vii_twice'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['vii_not_done'])?"&checkmark;":""?></td>
        <td><?php  echo $os->showDate( $non_scolastic_data['vii_dated']);?></td>
    </tr>
    <tr>
        <td>VIII</td>
        <td><?php echo isset($non_scolastic_data['viii_once'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['viii_twice'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['viii_not_done'])?"&checkmark;":""?></td>
        <td><?php  echo $os->showDate( $non_scolastic_data['viii_dated']);?></td>
    </tr>
    <tr>
        <td>IX</td>
        <td><?php echo isset($non_scolastic_data['ix_once'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['ix_twice'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['ix_not_done'])?"&checkmark;":""?></td>
        <td><?php  echo $os->showDate( $non_scolastic_data['ix_dated']);?></td>
    </tr>
    <tr>
        <td>X</td>
        <td><?php echo isset($non_scolastic_data['x_once'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['x_twice'])?"&checkmark;":""?></td>
        <td><?php echo isset($non_scolastic_data['x_not_done'])?"&checkmark;":""?></td>
        <td><?php  echo $os->showDate( $non_scolastic_data['x_dated']);?></td>
    </tr>
</table>

<div class="head_style" > How Many Times Reading Skill Testing was Done? </div>
<table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td>Class</td>
        <td>1st Lang</td>
        <td>2nd Lang</td>
        <td>3rd Lang</td>
        <td>Arabic</td>
    </tr>
    <tr>
        <td>V</td>
        <td><?php echo isset($reading_skill_test['v_1st_lang'])?$reading_skill_test['v_1st_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['v_2nd_lang'])?$reading_skill_test['v_2nd_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['v_3rd_lang'])?$reading_skill_test['v_3rd_lang']:'' ?></td>
        <td><?php  echo isset($reading_skill_test['v_arabic'])?$reading_skill_test['v_arabic']:''?></td>
    </tr>
    <tr>
        <td>VI</td>
        <td><?php echo isset($reading_skill_test['vi_1st_lang'])?$reading_skill_test['vi_1st_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['vi_2nd_lang'])?$reading_skill_test['vi_2nd_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['vi_3rd_lang'])?$reading_skill_test['vi_3rd_lang']:'' ?></td>
        <td><?php  echo isset($reading_skill_test['vi_arabic'])?$reading_skill_test['vi_arabic']:''?></td>
    </tr>
    <tr>
        <td>VII</td>
        <td><?php echo isset($reading_skill_test['vii_1st_lang'])?$reading_skill_test['vii_1st_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['vii_2nd_lang'])?$reading_skill_test['vii_2nd_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['vii_3rd_lang'])?$reading_skill_test['vii_3rd_lang']:'' ?></td>
        <td><?php  echo isset($reading_skill_test['vii_arabic'])?$reading_skill_test['vii_arabic']:''?></td>
    </tr>
    <tr>
        <td>VIII</td>
        <td><?php echo isset($reading_skill_test['viii_1st_lang'])?$reading_skill_test['viii_1st_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['viii_2nd_lang'])?$reading_skill_test['viii_2nd_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['viii_3rd_lang'])?$reading_skill_test['viii_3rd_lang']:'' ?></td>
        <td><?php  echo isset($reading_skill_test['viii_arabic'])?$reading_skill_test['viii_arabic']:''?></td>
    </tr>
    <tr>
        <td>IX</td>
        <td><?php echo isset($reading_skill_test['ix_1st_lang'])?$reading_skill_test['ix_1st_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['ix_2nd_lang'])?$reading_skill_test['ix_2nd_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['ix_3rd_lang'])?$reading_skill_test['ix_3rd_lang']:'' ?></td>
        <td><?php  echo isset($reading_skill_test['ix_arabic'])?$reading_skill_test['ix_arabic']:''?></td>
    </tr>
    <tr>
        <td>X</td>
        <td><?php echo isset($reading_skill_test['x_1st_lang'])?$reading_skill_test['x_1st_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['x_2nd_lang'])?$reading_skill_test['x_2nd_lang']:'' ?></td>
        <td><?php echo isset($reading_skill_test['x_3rd_lang'])?$reading_skill_test['x_3rd_lang']:'' ?></td>
        <td><?php  echo isset($reading_skill_test['x_arabic'])?$reading_skill_test['x_arabic']:''?></td>
    </tr>
</table>
<!-- aa -->

<div class="head_style" >Number of Foundation classes for VIII</div>
<table class="uk-table uk-table-small listTable">
 <tr class="borderTitle">
    <td>Phy</td>
    <td>Chem</td>
    <td>Math</td>
    <td>Bio</td>
    <td>Total</td>
</tr>
<tr>
    <td><?php echo isset($no_of_foundation_class_for_viii['phy'])?$no_of_foundation_class_for_viii['phy']:'' ?></td>
    <td><?php echo isset($no_of_foundation_class_for_viii['chem'])?$no_of_foundation_class_for_viii['chem']:'' ?></td>
    <td><?php echo isset($no_of_foundation_class_for_viii['math'])?$no_of_foundation_class_for_viii['math']:'' ?></td>
    <td><?php echo isset($no_of_foundation_class_for_viii['bio'])?$no_of_foundation_class_for_viii['bio']:'' ?></td>
    <td><?php echo isset($no_of_foundation_class_for_viii['total'])?$no_of_foundation_class_for_viii['total']:'' ?></td>     
</tr>
</table>

<div class="head_style" >Number of Foundation Classes for IX</div>
<table class="uk-table uk-table-small listTable tickmark">
    <tr class="borderTitle">
        <td>Phy</td>
        <td>Chem</td>
        <td>Math</td>
        <td>Bio</td>
        <td>SST</td>
        <td>Total</td>
    </tr>
    <tr>
        <td><?php echo isset($no_of_foundation_class_for_ix['phy'])?$no_of_foundation_class_for_ix['phy']:'' ?></td>
        <td><?php echo isset($no_of_foundation_class_for_ix['chem'])?$no_of_foundation_class_for_ix['chem']:'' ?></td>
        <td><?php echo isset($no_of_foundation_class_for_ix['math'])?$no_of_foundation_class_for_ix['math']:'' ?></td>
        <td><?php echo isset($no_of_foundation_class_for_ix['bio'])?$no_of_foundation_class_for_ix['bio']:'' ?></td>
        <td><?php echo isset($no_of_foundation_class_for_ix['sst'])?$no_of_foundation_class_for_ix['sst']:'' ?></td>
        <td><?php echo isset($no_of_foundation_class_for_ix['total'])?$no_of_foundation_class_for_ix['total']:'' ?></td>     
    </tr>
</table>
<!-- aa -->
<? echo footer_text($page=1); ?>
<?  echo $head;?>
<div class="head_style" > Name of the  Co-curricular Activities Observed in this Month :   </div>
<div style="border:1px solid #666666; height:40px; width:600px; margin:auto; padding:10px;" >
  <?php echo isset($data['co_curricular_activity'])?$data['co_curricular_activity']:'' ?></div>
  <div class="head_style" > Name of the  Cultural Programs Observed in this Month :  </div>
  <div style="border:1px solid #666666; height:40px; width:600px; margin:auto; padding:10px;" >
      <?php echo isset($data['cultural_programme'])?$data['cultural_programme']:'' ?></div>
      <div class="head_style" > Number of Motivational Programs and Counseling Done :  </div>
      <table class="uk-table uk-table-small listTable">
        <tr class="borderTitle">
            <td>Class</td>
            <td>Motivational program</td>
            <td>Counceling</td>
        </tr>
        <tr>
            <td>V</td>
            <td><?php echo isset($motivational_programme['v_motivational_programme'])?$motivational_programme['v_motivational_programme']:'' ?></td>
            <td><?php echo isset($motivational_programme['v_counceling'])?$motivational_programme['v_counceling']:'' ?></td>
        </tr>
        <tr>
            <td>VI</td>
            <td><?php echo isset($motivational_programme['vi_motivational_programme'])?$motivational_programme['vi_motivational_programme']:'' ?></td>
            <td><?php echo isset($motivational_programme['vi_counceling'])?$motivational_programme['vi_counceling']:'' ?></td>                
        </tr>
        <tr>
            <td>VII</td>
            <td><?php echo isset($motivational_programme['vii_motivational_programme'])?$motivational_programme['vii_motivational_programme']:'' ?></td>
            <td><?php echo isset($motivational_programme['vii_counceling'])?$motivational_programme['vii_counceling']:'' ?></td>              
        </tr>
        <tr>
            <td>VIII</td>
            <td><?php echo isset($motivational_programme['viii_motivational_programme'])?$motivational_programme['viii_motivational_programme']:'' ?></td>
            <td><?php echo isset($motivational_programme['viii_counceling'])?$motivational_programme['viii_counceling']:'' ?></td>
        </tr>
        <tr>
            <td>IX</td>
            <td><?php echo isset($motivational_programme['ix_motivational_programme'])?$motivational_programme['ix_motivational_programme']:'' ?></td>
            <td><?php echo isset($motivational_programme['ix_counceling'])?$motivational_programme['ix_counceling']:'' ?></td>
        </tr>
        <tr>
            <td>X</td>
            <td><?php echo isset($motivational_programme['x_motivational_programme'])?$motivational_programme['x_motivational_programme']:'' ?></td>
            <td><?php echo isset($motivational_programme['x_counceling'])?$motivational_programme['x_counceling']:'' ?></td>              
        </tr>
    </table>
    
    
    <div class="head_style" > Wall Magazine/ Magazine was Published :     </div>
    <div style="border:1px solid #666666; height:20px; width:600px; margin:auto; padding:10px;" > <?php echo isset($data['magazine_was_published'])?$data['magazine_was_published']:'' ?> </div>
    <? echo footer_text($page=2); ?>
    <?  echo $head;?>	
    <div class="head_style" > Parent- Teacher Meetings (class wise) ;</div>
    <table class="uk-table uk-table-small listTable">
        <tr class="borderTitle">
            <td>Class</td>
            <td>Online</td>
            <td>Offline</td>
        </tr>
        <tr>
            <td>V</td>
            <td>
                <?php echo isset($parent_teacher_meeting['v_online'])?$parent_teacher_meeting['v_online']:'' ?>                                    
            </td>
            <td>
                <?php echo isset($parent_teacher_meeting['v_offline'])?$parent_teacher_meeting['v_offline']:'' ?>                                    
            </td>

        </tr>
        <tr>
            <td>VI</td>
            <td><?php echo isset($parent_teacher_meeting['vi_online'])?$parent_teacher_meeting['vi_online']:'' ?></td>
            <td><?php echo isset($parent_teacher_meeting['vi_offline'])?$parent_teacher_meeting['vi_offline']:'' ?></td>              
        </tr>
        <tr>
            <td>VII</td>
            <td><?php echo isset($parent_teacher_meeting['vii_online'])?$parent_teacher_meeting['vii_online']:'' ?></td>
            <td><?php echo isset($parent_teacher_meeting['vii_offline'])?$parent_teacher_meeting['vii_offline']:'' ?></td>                
        </tr>
        <tr>
            <td>VIII</td>
            <td><?php echo isset($parent_teacher_meeting['viii_online'])?$parent_teacher_meeting['viii_online']:'' ?></td>
            <td><?php echo isset($parent_teacher_meeting['viii_offline'])?$parent_teacher_meeting['viii_offline']:'' ?></td>

        </tr>
        <tr>
            <td>IX</td>
            <td><?php echo isset($parent_teacher_meeting['ix_online'])?$parent_teacher_meeting['ix_online']:'' ?></td>
            <td><?php echo isset($parent_teacher_meeting['ix_offline'])?$parent_teacher_meeting['ix_offline']:'' ?></td>
        </tr>
        <tr>
            <td>X</td>
            <td><?php echo isset($parent_teacher_meeting['x_online'])?$parent_teacher_meeting['x_online']:'' ?></td>
            <td><?php echo isset($parent_teacher_meeting['x_offline'])?$parent_teacher_meeting['x_offline']:'' ?></td>                
        </tr>
    </table>
    
    
    
    <div class="head_style" > Meeting With Students (class wise) </div>
    <table class="uk-table uk-table-small listTable">
        <tr class="borderTitle">
            <td>Class</td>
            <td>Online</td>
            <td>Offline</td>
        </tr>
        <tr>
            <td>V</td>
            <td><?php echo isset($meeting_with_student['v_online'])?$meeting_with_student['v_online']:'' ?></td>
            <td><?php echo isset($meeting_with_student['v_offline'])?$meeting_with_student['v_offline']:'' ?></td>
        </tr>
        <tr>
            <td>VI</td>
            <td><?php echo isset($meeting_with_student['vi_online'])?$meeting_with_student['vi_online']:'' ?></td>
            <td><?php echo isset($meeting_with_student['vi_offline'])?$meeting_with_student['vi_offline']:'' ?></td>              
        </tr>
        <tr>
            <td>VII</td>
            <td><?php echo isset($meeting_with_student['vii_online'])?$meeting_with_student['vii_online']:'' ?></td>
            <td><?php echo isset($meeting_with_student['vii_offline'])?$meeting_with_student['vii_offline']:'' ?></td>                
        </tr>
        <tr>
            <td>VIII</td>
            <td><?php echo isset($meeting_with_student['viii_online'])?$meeting_with_student['viii_online']:'' ?></td>
            <td><?php echo isset($meeting_with_student['viii_offline'])?$meeting_with_student['viii_offline']:'' ?></td>

        </tr>
        <tr>
            <td>IX</td>
            <td><?php echo isset($meeting_with_student['ix_online'])?$meeting_with_student['ix_online']:'' ?></td>
            <td><?php echo isset($meeting_with_student['ix_offline'])?$meeting_with_student['ix_offline']:'' ?></td>
        </tr>
        <tr>
            <td>X</td>
            <td><?php echo isset($meeting_with_student['x_online'])?$meeting_with_student['x_online']:'' ?></td>
            <td><?php echo isset($meeting_with_student['x_offline'])?$meeting_with_student['x_offline']:'' ?></td>                
        </tr>
    </table> 
    
    
    <? echo footer_text($page=3); ?>
</div>

<style>
    .head_style{ text-align:center; font-size:16px; font-weight:bold; border:1px solid #999999; padding:5px 5px; width:400px; margin:auto; margin-top:20px; border-bottom:none;}
    .listTable{ margin:auto;}
    .listTable td{ text-align:center;}
</style>


<script>
    function printPage(){
        document.getElementById("printBtn").style.display="none";
        window.print();
        document.getElementById("printBtn").style.display="block";
    }

</script>

</body>
</html>

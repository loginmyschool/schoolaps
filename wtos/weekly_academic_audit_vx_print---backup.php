<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$weekly_academic_audit_vx_id = $os->get('id');
$weekly_academic_audit_vx_mq = $os->mq("SELECT * FROM weekly_academic_audit_vx where  weekly_academic_audit_vx_id='$weekly_academic_audit_vx_id'");
$data=$os->mfa($weekly_academic_audit_vx_mq);
$number_of_lesson_plan=json_decode($data['number_of_lesson_plan'], TRUE);
$number_of_class_test=json_decode($data['number_of_class_test'], TRUE);
$no_of_classes_observed=json_decode($data['no_of_classes_observed'], TRUE);
$manipulatives=json_decode($data['manipulatives'], TRUE);
$departmental_meeting=json_decode($data['departmental_meeting'], TRUE);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? include('wtosHeader.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> </title>
   <!-- <link rel="stylesheet" href="<? echo $site['themePath']?>css/uikit.css" />
    <script src="<? echo $site['themePath']?>js/uikit.js"></script>
    <script src="<? echo $site['themePath']?>js/uikit-icons.js"></script>-->
    <style type="text/css">
        .uk-table{width: 80%;}
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
Weekly Academic Audit (WAA)
</div>
<div style="font-size:16px; font-weight:200; text-align:center;">
Al-Ameen Centre for Educational Research & Training                                   (AACERT)
</div>
<div style="font-size:14px; font-weight:200; text-align:center;">
 <? echo $os->rowByField('branch_name','branch','branch_code',$data['branch_code']); ?>
</div>

<div style="font-size:17px; font-weight:200; text-align:center; margin:auto; width:230px; border:1px solid #333333; border-radius:5px; margin-top:10px;">
 Week <?php echo $data['week_no'] ?> <?php echo $os->rentMonth[$data['month']] ;?>  <?php echo $data['year'] ;?>
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

    <div class="head_style" >Number of Lesson plan checked </div>
	<table class="uk-table uk-table-small listTable">
                    <tr class="borderTitle">
                        <td rowspan="2">Class</td>
                        <td colspan="4">Language</td>
                        <td rowspan="2">EVS</td>
                        <td colspan="3">SSC/SC</td>
                        <td rowspan="2">Math</td>
                        <td colspan="4">SST</td>
                        <td rowspan="2">Total</td>
                    </tr>
                    <tr>
                        <td>1st</td>
                        <td>2nd</td>
                        <td>3rd</td>
                        <td>Arabic</td>
                        <td>Phy</td>
                        <td>Chem</td>
                        <td>Bio</td>
                        <td>Hist</td>
                        <td>Geo</td>
                        <td>Civics</td>
                        <td>ECO</td>
                    </tr>
                    <tr>
                        <td>V</td>
                        <td><?php echo isset($number_of_lesson_plan['v_1st'])?$number_of_lesson_plan['v_1st']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_2nd'])?$number_of_lesson_plan['v_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_3rd'])?$number_of_lesson_plan['v_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_arabic'])?$number_of_lesson_plan['v_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_evs'])?$number_of_lesson_plan['v_evs']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_phy'])?$number_of_lesson_plan['v_phy']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_chem'])?$number_of_lesson_plan['v_chem']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_bio'])?$number_of_lesson_plan['v_bio']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_math'])?$number_of_lesson_plan['v_math']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_hist'])?$number_of_lesson_plan['v_hist']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_geo'])?$number_of_lesson_plan['v_geo']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_civics'])?$number_of_lesson_plan['v_civics']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_eco'])?$number_of_lesson_plan['v_eco']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['v_total'])?$number_of_lesson_plan['v_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>VI</td>
                        <td><?php echo isset($number_of_lesson_plan['vi_1st'])?$number_of_lesson_plan['vi_1st']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_2nd'])?$number_of_lesson_plan['vi_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_3rd'])?$number_of_lesson_plan['vi_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_arabic'])?$number_of_lesson_plan['vi_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_evs'])?$number_of_lesson_plan['vi_evs']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_phy'])?$number_of_lesson_plan['vi_phy']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_chem'])?$number_of_lesson_plan['vi_chem']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_bio'])?$number_of_lesson_plan['vi_bio']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_math'])?$number_of_lesson_plan['vi_math']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_hist'])?$number_of_lesson_plan['vi_hist']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_geo'])?$number_of_lesson_plan['vi_geo']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_civics'])?$number_of_lesson_plan['vi_civics']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_eco'])?$number_of_lesson_plan['vi_eco']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vi_total'])?$number_of_lesson_plan['vi_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>VII</td>
                        <td><?php echo isset($number_of_lesson_plan['vii_1st'])?$number_of_lesson_plan['vii_1st']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_2nd'])?$number_of_lesson_plan['vii_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_3rd'])?$number_of_lesson_plan['vii_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_arabic'])?$number_of_lesson_plan['vii_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_evs'])?$number_of_lesson_plan['vii_evs']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_phy'])?$number_of_lesson_plan['vii_phy']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_chem'])?$number_of_lesson_plan['vii_chem']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_bio'])?$number_of_lesson_plan['vii_bio']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_math'])?$number_of_lesson_plan['vii_math']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_hist'])?$number_of_lesson_plan['vii_hist']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_geo'])?$number_of_lesson_plan['vii_geo']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_civics'])?$number_of_lesson_plan['vii_civics']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_eco'])?$number_of_lesson_plan['vii_eco']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['vii_total'])?$number_of_lesson_plan['vii_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>VIII</td>
                        <td><?php echo isset($number_of_lesson_plan['viii_1st'])?$number_of_lesson_plan['viii_1st']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_2nd'])?$number_of_lesson_plan['viii_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_3rd'])?$number_of_lesson_plan['viii_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_arabic'])?$number_of_lesson_plan['viii_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_evs'])?$number_of_lesson_plan['viii_evs']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_phy'])?$number_of_lesson_plan['viii_phy']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_chem'])?$number_of_lesson_plan['viii_chem']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_bio'])?$number_of_lesson_plan['viii_bio']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_math'])?$number_of_lesson_plan['viii_math']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_hist'])?$number_of_lesson_plan['viii_hist']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_geo'])?$number_of_lesson_plan['viii_geo']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_civics'])?$number_of_lesson_plan['viii_civics']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_eco'])?$number_of_lesson_plan['viii_eco']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['viii_total'])?$number_of_lesson_plan['viii_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>IX</td>
                        <td><?php echo isset($number_of_lesson_plan['ix_1st'])?$number_of_lesson_plan['ix_1st']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_2nd'])?$number_of_lesson_plan['ix_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_3rd'])?$number_of_lesson_plan['ix_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_arabic'])?$number_of_lesson_plan['ix_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_evs'])?$number_of_lesson_plan['ix_evs']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_phy'])?$number_of_lesson_plan['ix_phy']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_chem'])?$number_of_lesson_plan['ix_chem']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_bio'])?$number_of_lesson_plan['ix_bio']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_math'])?$number_of_lesson_plan['ix_math']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_hist'])?$number_of_lesson_plan['ix_hist']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_geo'])?$number_of_lesson_plan['ix_geo']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_civics'])?$number_of_lesson_plan['ix_civics']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_eco'])?$number_of_lesson_plan['ix_eco']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['ix_total'])?$number_of_lesson_plan['ix_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>X</td>
                        <td><?php echo isset($number_of_lesson_plan['x_1st'])?$number_of_lesson_plan['x_1st']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_2nd'])?$number_of_lesson_plan['x_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_3rd'])?$number_of_lesson_plan['x_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_arabic'])?$number_of_lesson_plan['x_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_evs'])?$number_of_lesson_plan['x_evs']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_phy'])?$number_of_lesson_plan['x_phy']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_chem'])?$number_of_lesson_plan['x_chem']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_bio'])?$number_of_lesson_plan['x_bio']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_math'])?$number_of_lesson_plan['x_math']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_hist'])?$number_of_lesson_plan['x_hist']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_geo'])?$number_of_lesson_plan['x_geo']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_civics'])?$number_of_lesson_plan['x_civics']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_eco'])?$number_of_lesson_plan['x_eco']:'' ?></td>
                        <td><?php echo isset($number_of_lesson_plan['x_total'])?$number_of_lesson_plan['x_total']:'' ?></td>    
                    </tr>
                </table>
	
	
	<div class="head_style" >Number of Class Tests  </div>
	<table class="uk-table uk-table-small listTable">
                    <tr class="borderTitle">
                        <td rowspan="2">Class</td>
                        <td colspan="4">Language</td>
                        <td rowspan="2">EVS</td>
                        <td colspan="3">SSC/SC</td>
                        <td rowspan="2">Math</td>
                        <td colspan="4">SST</td>
                        <td rowspan="2">Total</td>
                    </tr>
                    <tr>
                        <td>1st</td>
                        <td>2nd</td>
                        <td>3rd</td>
                        <td>Arabic</td>
                        <td>Phy</td>
                        <td>Chem</td>
                        <td>Bio</td>
                        <td>Hist</td>
                        <td>Geo</td>
                        <td>Civics</td>
                        <td>ECO</td>
                    </tr>
                    <tr>
                        <td>V</td>
                        <td><?php echo isset($number_of_class_test['v_1st'])?$number_of_class_test['v_1st']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_2nd'])?$number_of_class_test['v_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_3rd'])?$number_of_class_test['v_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_arabic'])?$number_of_class_test['v_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_evs'])?$number_of_class_test['v_evs']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_phy'])?$number_of_class_test['v_phy']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_chem'])?$number_of_class_test['v_chem']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_bio'])?$number_of_class_test['v_bio']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_math'])?$number_of_class_test['v_math']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_hist'])?$number_of_class_test['v_hist']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_geo'])?$number_of_class_test['v_geo']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_civics'])?$number_of_class_test['v_civics']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_eco'])?$number_of_class_test['v_eco']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['v_total'])?$number_of_class_test['v_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>VI</td>
                        <td><?php echo isset($number_of_class_test['vi_1st'])?$number_of_class_test['vi_1st']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_2nd'])?$number_of_class_test['vi_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_3rd'])?$number_of_class_test['vi_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_arabic'])?$number_of_class_test['vi_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_evs'])?$number_of_class_test['vi_evs']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_phy'])?$number_of_class_test['vi_phy']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_chem'])?$number_of_class_test['vi_chem']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_bio'])?$number_of_class_test['vi_bio']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_math'])?$number_of_class_test['vi_math']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_hist'])?$number_of_class_test['vi_hist']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_geo'])?$number_of_class_test['vi_geo']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_civics'])?$number_of_class_test['vi_civics']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_eco'])?$number_of_class_test['vi_eco']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vi_total'])?$number_of_class_test['vi_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>VII</td>
                        <td><?php echo isset($number_of_class_test['vii_1st'])?$number_of_class_test['vii_1st']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_2nd'])?$number_of_class_test['vii_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_3rd'])?$number_of_class_test['vii_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_arabic'])?$number_of_class_test['vii_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_evs'])?$number_of_class_test['vii_evs']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_phy'])?$number_of_class_test['vii_phy']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_chem'])?$number_of_class_test['vii_chem']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_bio'])?$number_of_class_test['vii_bio']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_math'])?$number_of_class_test['vii_math']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_hist'])?$number_of_class_test['vii_hist']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_geo'])?$number_of_class_test['vii_geo']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_civics'])?$number_of_class_test['vii_civics']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_eco'])?$number_of_class_test['vii_eco']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['vii_total'])?$number_of_class_test['vii_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>VIII</td>
                        <td><?php echo isset($number_of_class_test['viii_1st'])?$number_of_class_test['viii_1st']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_2nd'])?$number_of_class_test['viii_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_3rd'])?$number_of_class_test['viii_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_arabic'])?$number_of_class_test['viii_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_evs'])?$number_of_class_test['viii_evs']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_phy'])?$number_of_class_test['viii_phy']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_chem'])?$number_of_class_test['viii_chem']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_bio'])?$number_of_class_test['viii_bio']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_math'])?$number_of_class_test['viii_math']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_hist'])?$number_of_class_test['viii_hist']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_geo'])?$number_of_class_test['viii_geo']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_civics'])?$number_of_class_test['viii_civics']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_eco'])?$number_of_class_test['viii_eco']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['viii_total'])?$number_of_class_test['viii_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>IX</td>
                        <td><?php echo isset($number_of_class_test['ix_1st'])?$number_of_class_test['ix_1st']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_2nd'])?$number_of_class_test['ix_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_3rd'])?$number_of_class_test['ix_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_arabic'])?$number_of_class_test['ix_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_evs'])?$number_of_class_test['ix_evs']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_phy'])?$number_of_class_test['ix_phy']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_chem'])?$number_of_class_test['ix_chem']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_bio'])?$number_of_class_test['ix_bio']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_math'])?$number_of_class_test['ix_math']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_hist'])?$number_of_class_test['ix_hist']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_geo'])?$number_of_class_test['ix_geo']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_civics'])?$number_of_class_test['ix_civics']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_eco'])?$number_of_class_test['ix_eco']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['ix_total'])?$number_of_class_test['ix_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>X</td>
                        <td><?php echo isset($number_of_class_test['x_1st'])?$number_of_class_test['x_1st']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_2nd'])?$number_of_class_test['x_2nd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_3rd'])?$number_of_class_test['x_3rd']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_arabic'])?$number_of_class_test['x_arabic']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_evs'])?$number_of_class_test['x_evs']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_phy'])?$number_of_class_test['x_phy']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_chem'])?$number_of_class_test['x_chem']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_bio'])?$number_of_class_test['x_bio']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_math'])?$number_of_class_test['x_math']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_hist'])?$number_of_class_test['x_hist']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_geo'])?$number_of_class_test['x_geo']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_civics'])?$number_of_class_test['x_civics']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_eco'])?$number_of_class_test['x_eco']:'' ?></td>
                        <td><?php echo isset($number_of_class_test['x_total'])?$number_of_class_test['x_total']:'' ?></td>  
                    </tr>
                </table>
				
		 <? echo footer_text($page=1); ?>		 
	
	<?  echo $head;?>
	<div class="head_style" >Number of Classes observed by the head of the institution </div>
	<table class="uk-table uk-table-small listTable">
                    <tr class="borderTitle">
                        <td rowspan="2">Class</td>
                        <td colspan="4">Language</td>
                        <td rowspan="2">EVS</td>
                        <td colspan="3">SSC/SC</td>
                        <td rowspan="2">Math</td>
                        <td colspan="4">SST</td>
                        <td rowspan="2">Total</td>
                    </tr>
                    <tr>
                        <td>1st</td>
                        <td>2nd</td>
                        <td>3rd</td>
                        <td>Arabic</td>
                        <td>Phy</td>
                        <td>Chem</td>
                        <td>Bio</td>
                        <td>Hist</td>
                        <td>Geo</td>
                        <td>Civics</td>
                        <td>ECO</td>
                    </tr>
                    <tr>
                        <td>V</td>
                        <td><?php echo isset($no_of_classes_observed['v_1st'])?$no_of_classes_observed['v_1st']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_2nd'])?$no_of_classes_observed['v_2nd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_3rd'])?$no_of_classes_observed['v_3rd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_arabic'])?$no_of_classes_observed['v_arabic']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_evs'])?$no_of_classes_observed['v_evs']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_phy'])?$no_of_classes_observed['v_phy']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_chem'])?$no_of_classes_observed['v_chem']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_bio'])?$no_of_classes_observed['v_bio']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_math'])?$no_of_classes_observed['v_math']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_hist'])?$no_of_classes_observed['v_hist']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_geo'])?$no_of_classes_observed['v_geo']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_civics'])?$no_of_classes_observed['v_civics']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_eco'])?$no_of_classes_observed['v_eco']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['v_total'])?$no_of_classes_observed['v_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>VI</td>
                        <td><?php echo isset($no_of_classes_observed['vi_1st'])?$no_of_classes_observed['vi_1st']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_2nd'])?$no_of_classes_observed['vi_2nd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_3rd'])?$no_of_classes_observed['vi_3rd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_arabic'])?$no_of_classes_observed['vi_arabic']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_evs'])?$no_of_classes_observed['vi_evs']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_phy'])?$no_of_classes_observed['vi_phy']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_chem'])?$no_of_classes_observed['vi_chem']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_bio'])?$no_of_classes_observed['vi_bio']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_math'])?$no_of_classes_observed['vi_math']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_hist'])?$no_of_classes_observed['vi_hist']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_geo'])?$no_of_classes_observed['vi_geo']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_civics'])?$no_of_classes_observed['vi_civics']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_eco'])?$no_of_classes_observed['vi_eco']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vi_total'])?$no_of_classes_observed['vi_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>VII</td>
                        <td><?php echo isset($no_of_classes_observed['vii_1st'])?$no_of_classes_observed['vii_1st']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_2nd'])?$no_of_classes_observed['vii_2nd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_3rd'])?$no_of_classes_observed['vii_3rd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_arabic'])?$no_of_classes_observed['vii_arabic']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_evs'])?$no_of_classes_observed['vii_evs']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_phy'])?$no_of_classes_observed['vii_phy']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_chem'])?$no_of_classes_observed['vii_chem']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_bio'])?$no_of_classes_observed['vii_bio']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_math'])?$no_of_classes_observed['vii_math']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_hist'])?$no_of_classes_observed['vii_hist']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_geo'])?$no_of_classes_observed['vii_geo']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_civics'])?$no_of_classes_observed['vii_civics']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_eco'])?$no_of_classes_observed['vii_eco']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['vii_total'])?$no_of_classes_observed['vii_total']:'' ?></td>  
                    </tr>
                    <tr>
                        <td>VIII</td>
                        <td><?php echo isset($no_of_classes_observed['viii_1st'])?$no_of_classes_observed['viii_1st']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_2nd'])?$no_of_classes_observed['viii_2nd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_3rd'])?$no_of_classes_observed['viii_3rd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_arabic'])?$no_of_classes_observed['viii_arabic']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_evs'])?$no_of_classes_observed['viii_evs']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_phy'])?$no_of_classes_observed['viii_phy']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_chem'])?$no_of_classes_observed['viii_chem']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_bio'])?$no_of_classes_observed['viii_bio']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_math'])?$no_of_classes_observed['viii_math']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_hist'])?$no_of_classes_observed['viii_hist']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_geo'])?$no_of_classes_observed['viii_geo']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_civics'])?$no_of_classes_observed['viii_civics']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_eco'])?$no_of_classes_observed['viii_eco']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['viii_total'])?$no_of_classes_observed['viii_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>IX</td>
                        <td><?php echo isset($no_of_classes_observed['ix_1st'])?$no_of_classes_observed['ix_1st']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_2nd'])?$no_of_classes_observed['ix_2nd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_3rd'])?$no_of_classes_observed['ix_3rd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_arabic'])?$no_of_classes_observed['ix_arabic']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_evs'])?$no_of_classes_observed['ix_evs']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_phy'])?$no_of_classes_observed['ix_phy']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_chem'])?$no_of_classes_observed['ix_chem']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_bio'])?$no_of_classes_observed['ix_bio']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_math'])?$no_of_classes_observed['ix_math']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_hist'])?$no_of_classes_observed['ix_hist']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_geo'])?$no_of_classes_observed['ix_geo']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_civics'])?$no_of_classes_observed['ix_civics']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_eco'])?$no_of_classes_observed['ix_eco']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['ix_total'])?$no_of_classes_observed['ix_total']:'' ?></td>    
                    </tr>
                    <tr>
                        <td>X</td>
                        <td><?php echo isset($no_of_classes_observed['x_1st'])?$no_of_classes_observed['x_1st']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_2nd'])?$no_of_classes_observed['x_2nd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_3rd'])?$no_of_classes_observed['x_3rd']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_arabic'])?$no_of_classes_observed['x_arabic']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_evs'])?$no_of_classes_observed['x_evs']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_phy'])?$no_of_classes_observed['x_phy']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_chem'])?$no_of_classes_observed['x_chem']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_bio'])?$no_of_classes_observed['x_bio']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_math'])?$no_of_classes_observed['x_math']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_hist'])?$no_of_classes_observed['x_hist']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_geo'])?$no_of_classes_observed['x_geo']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_civics'])?$no_of_classes_observed['x_civics']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_eco'])?$no_of_classes_observed['x_eco']:'' ?></td>
                        <td><?php echo isset($no_of_classes_observed['x_total'])?$no_of_classes_observed['x_total']:'' ?></td>  
                    </tr>
                </table>
	
	<div class="head_style" >Which manipulative were seen to be used in the class? </div>
	<table class="uk-table uk-table-small listTable">
                    <tr class="borderTitle">
                        <td class=""><div class="rotate" >Class</div></td>
                        <td class=""><div class="rotate" >Rhymes</div></td>
                        <td class=""><div class="rotate" >Chart</div></td>
                        <td class=""><div class="rotate" >Model</div></td>
                        <td class=""><div class="rotate" >Extra study matrial</div></td>
                        <td class=""><div class="rotate" >Debate and extempore </div></td>
                        <td class=""><div class="rotate" >Story telling</div></td>
                        <td class=""><div class="rotate" >Theater as pedagogy</div></td>
                        <td class=""><div class="rotate" >Sc. Exp</div></td>
                        <td class=""><div class="rotate" >Sc. Chart</div></td>
                        <td class=""><div class="rotate" >Work sheet</div></td>
                        <td class=""><div class="rotate" >Puzzle and tan grams</div></td>
                        <td class=""><div class="rotate" >Mental math</div></td>
                        <td class=""><div class="rotate" >Map/Globe</div></td>
                        <td class=""><div class="rotate" >Field work</div></td>
                        <td class=""><div class="rotate" >Smart class</div></td>
                        <td class=""><div class="rotate" >Group work</div></td>
                        <td class=""><div class="rotate" >Project</div></td>
                    </tr>

                    <tr>
                        <td>V</td>
                        <td><?php echo isset($manipulatives['v_rhymes'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_model'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_extra_study_matrial'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_debate_and_extempore'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_story_telling'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_theater_as_pedagogy'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_sc_exp'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_sc_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_work_sheet'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_puzzle_and_tan_grams'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_mental_math'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_map_globe'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_field_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_smart_class'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_group_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['v_project'])?"Yes":""?></td>
                    </tr>
                    <tr>
                        <td>VI</td>
                        <td><?php echo isset($manipulatives['vi_rhymes'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_model'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_extra_study_matrial'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_debate_and_extempore'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_story_telling'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_theater_as_pedagogy'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_sc_exp'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_sc_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_work_sheet'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_puzzle_and_tan_grams'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_mental_math'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_map_globe'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_field_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_smart_class'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_group_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vi_project'])?"Yes":""?></td>
                    </tr>
                    <tr>
                        <td>VII</td>
                        <td><?php echo isset($manipulatives['vii_rhymes'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_model'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_extra_study_matrial'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_debate_and_extempore'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_story_telling'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_theater_as_pedagogy'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_sc_exp'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_sc_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_work_sheet'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_puzzle_and_tan_grams'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_mental_math'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_map_globe'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_field_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_smart_class'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_group_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['vii_project'])?"Yes":""?></td>
                    </tr>
                    <tr>
                        <td>VIII</td>
                        <td><?php echo isset($manipulatives['viii_rhymes'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_model'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_extra_study_matrial'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_debate_and_extempore'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_story_telling'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_theater_as_pedagogy'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_sc_exp'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_sc_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_work_sheet'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_puzzle_and_tan_grams'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_mental_math'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_map_globe'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_field_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_smart_class'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_group_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['viii_project'])?"Yes":""?></td>
                    </tr>

                    <tr>
                        <td>IX</td>
                        <td><?php echo isset($manipulatives['ix_rhymes'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_model'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_extra_study_matrial'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_debate_and_extempore'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_story_telling'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_theater_as_pedagogy'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_sc_exp'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_sc_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_work_sheet'])?"Yes":""?></td>
                        <td> <?php echo isset($manipulatives['ix_puzzle_and_tan_grams'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_mental_math'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_map_globe'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_field_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_smart_class'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_group_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['ix_project'])?"Yes":""?></td>
                    </tr>
                    <tr>
                        <td>X</td>
                        <td><?php echo isset($manipulatives['x_rhymes'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_model'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_extra_study_matrial'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_debate_and_extempore'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_story_telling'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_theater_as_pedagogy'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_sc_exp'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_sc_chart'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_work_sheet'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_puzzle_and_tan_grams'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_mental_math'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_map_globe'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_field_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_smart_class'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_group_work'])?"Yes":""?></td>
                        <td><?php echo isset($manipulatives['x_project'])?"Yes":""?></td>
                    </tr>
                </table>
	&checkmark;
	  <? echo footer_text($page=3); ?>
	  
	  <?  echo $head;?>
	
    <table width="30%" border="0" class="uk-table  uk-table-small listTable" style="margin:auto;" cellpadding="0" cellspacing="0">
       
        <tr >
            <td>Assesment report updated </td>
            <td><?php echo $os->assesment_report_updated[$data['assesment_report_updated']]?></td>                      
        </tr>
        <tr >
            <td>Daily talim </td>
            <td><?php echo $data['daily_talim']?></td>                      
        </tr>
        <tr >
            <td>Daily quran larning </td>
            <td><?php echo $data['daily_quran_larning'];?></td>                       
        </tr>
        <tr >
            <td>Departmental meeting </td>
            <td><?php echo isset($departmental_meeting['beng'])?"Beng ,":""?><?php echo isset($departmental_meeting['eng'])?"Eng ,":""?>
                        <?php echo isset($departmental_meeting['math'])?"Math ,":""?><?php echo isset($departmental_meeting['science'])?"Science ,":""?><?php echo isset($departmental_meeting['sst'])?"SST ,":""?>
                        <?php echo isset($departmental_meeting['arabic'])?"Arabic":""?>
            </td>                       
        </tr>
        <tr >
            <td>All teacher meeting </td>
            <td><?php echo $data['all_teacher_meeting']?></td>                      
        </tr>
        <tr >
            <td>Daily abascus class </td>
            <td><?php echo $data['daily_abascus_class']?></td>                      
        </tr>
         
         
    </table>
	<? echo footer_text($page=3); ?>	
	
	
</div>	
    <script>
        function printPage(){
            document.getElementById("printBtn").style.display="none";
            window.print();
            document.getElementById("printBtn").style.display="block";
        }

    </script>
<style>
.head_style{ text-align:center; font-size:16px; font-weight:bold; border:1px solid #999999; padding:5px 5px; width:300px; margin:auto; margin-top:20px; border-bottom:none;}
.listTable{ margin:auto;}
.listTable td{ text-align:center;}
.rotate { 
writing-mode: vertical-rl;
transform: rotate(180deg);
  
 
 
 /* transform: rotate(-90deg); 
  -webkit-transform: rotate(-90deg); 
  -moz-transform: rotate(-90deg); 
  -ms-transform: rotate(-90deg); 
  -o-transform: rotate(-90deg); 
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);*/

}
</style>
</body>
</html>

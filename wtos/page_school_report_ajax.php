<?
if (session_id() === "") { session_start(); }
include('wtosConfigLocal.php');
error_reporting($site['environment']);
include($site['root-wtos'].'wtos.php');




function calculate_score($asession)
{

    global $os;
    $ovarallscore=0;
    $ovarallcount=0;
    $keys=array();

/// --- results  ----//
    $query="select AVG(percentage) avg_rs  from resultsdetails  where asession='$asession'";
    $rsResults=$os->mq($query);
    $record=$os->mfa( $rsResults);





    $score=ceil($record['avg_rs']);
    $noscore=100-$score;
    $title='Student performance';

    $color='red';
    if($score>69){$color='orange'; }
    if($score>79){$color='green' ;}
    $key=str_replace(' ','',$title);
    $keys[$key]=trim($key);
    $over_all_score[$key]['score']=$score;
    $over_all_score[$key]['noscore']=$noscore;
    $over_all_score[$key]['graph_div_id']='graph_div_id_'.str_replace(' ','',$title);
    $over_all_score[$key]['color']=$color;
    $over_all_score[$key]['title']=$title;
    $over_all_score[$key]['data_array']='[["", ""],["'.$title.'",'.$score.'], ["",'.$noscore.']]';
    $over_all_score[$key]['options_json']='{"pieHole": "0.5", "pieSliceTextStyle":{"color": ""},"slices": {"0": {"color": "'.$color.'"}, "1": {"color": "#CCCCCC"}},"legend": "none"}';
    $ovarallscore=$score+$ovarallscore;
    $ovarallcount=$ovarallcount+1;

/// --- results  ----//

 // review rating 

    $score=$os->score_fees_collect($asession);
    $noscore=100-$score;
    $title='Fees Collection';

    $color='red';
    if($score>69){$color='orange'; }
    if($score>79){$color='green' ;}
    $key=str_replace(' ','',$title);
    $keys[$key]=trim($key);
    $over_all_score[$key]['score']=$score;
    $over_all_score[$key]['noscore']=$noscore;
    $over_all_score[$key]['graph_div_id']='graph_div_id_'.str_replace(' ','',$title);
    $over_all_score[$key]['color']=$color;
    $over_all_score[$key]['title']=$title;
    $over_all_score[$key]['data_array']='[["", ""],["'.$title.'",'.$score.'], ["",'.$noscore.']]';
    $over_all_score[$key]['options_json']='{"pieHole": "0.5", "pieSliceTextStyle":{"color": ""},"slices": {"0": {"color": "'.$color.'"}, "1": {"color": "#CCCCCC"}},"legend": "none"}';
    $ovarallscore=$score+$ovarallscore;
    $ovarallcount=$ovarallcount+1;
	
	
	
	
	

/// --- fees  ----//

       $review_sub_query="select r_s.title , AVG(r_d.review_marks)  review_marks_avg ,count(*) cc from review_details  r_d,review_subject r_s 
	    where   r_d.review_subject_id>0 and  r_d.review_marks>0 and r_d.user_table_id>0 and r_d.review_subject_id=r_s.review_subject_id  
    group by  r_d.review_subject_id  order by r_s.view_order asc";
   
    
 
    $review_sub_mq=$os->mq($review_sub_query);
    while($row2=$os->mfa($review_sub_mq))
	{ 
		$cc=$row2['cc'];
		$review_subject_id=$row2['review_subject_id'];
		$title=$row2['title'];
	    $review_marks_avg=(int)ceil($row2['review_marks_avg']);
    
		
		
		$score=$review_marks_avg;
		$noscore=100-$score;
		$title=$title;
	
		$color='red';
		if($score>69){$color='orange'; }
		if($score>79){$color='green' ;}
		$key=str_replace(' ','',$title);
		$keys[$key]=trim($key);
		$over_all_score[$key]['score']=$score;
		$over_all_score[$key]['noscore']=$noscore;
		$over_all_score[$key]['graph_div_id']='graph_div_id_'.str_replace(' ','',$title);
		$over_all_score[$key]['color']=$color;
		$over_all_score[$key]['title']=$title." ($cc)";
		$over_all_score[$key]['data_array']='[["", ""],["'.$title.'",'.$score.'], ["",'.$noscore.']]';
		$over_all_score[$key]['options_json']='{"pieHole": "0.5", "pieSliceTextStyle":{"color": ""},"slices": {"0": {"color": "'.$color.'"}, "1": {"color": "#CCCCCC"}},"legend": "none"}';
		$ovarallscore=$score+$ovarallscore;
		$ovarallcount=$ovarallcount+1;
	
	
	
	}





    /*$score=80;
    $noscore=100-$score;
    $title='Curriculum Activities';

    $color='red';
    if($score>69){$color='orange'; }
    if($score>79){$color='green' ;}
    $key=str_replace(' ','',$title);
    $keys[$key]=trim($key);
    $over_all_score[$key]['score']=$score;
    $over_all_score[$key]['noscore']=$noscore;
    $over_all_score[$key]['graph_div_id']='graph_div_id_'.str_replace(' ','',$title);
    $over_all_score[$key]['color']=$color;
    $over_all_score[$key]['title']=$title;
    $over_all_score[$key]['data_array']='[["", ""],["'.$title.'",'.$score.'], ["",'.$noscore.']]';
    $over_all_score[$key]['options_json']='{"pieHole": "0.5", "pieSliceTextStyle":{"color": ""},"slices": {"0": {"color": "'.$color.'"}, "1": {"color": "#CCCCCC"}},"legend": "none"}';
    $ovarallscore=$score+$ovarallscore;
    $ovarallcount=$ovarallcount+1;*/

/// --- Food Review ----//

 



// over all---


    $score=ceil($ovarallscore/$ovarallcount);
    $noscore=100-$score;
    $title='Overall';

    $color='red';
    if($score>69){$color='orange'; }
    if($score>79){$color='green' ;}
    $key=str_replace(' ','',$title);
    $keys[$key]=trim($key);
    $over_all_score[$key]['score']=$score;
    $over_all_score[$key]['noscore']=$noscore;
    $over_all_score[$key]['graph_div_id']='graph_div_id_'.str_replace(' ','',$title);
    $over_all_score[$key]['color']=$color;
    $over_all_score[$key]['title']=$title;
    $over_all_score[$key]['data_array']='[["", ""],["'.$title.'",'.$score.'], ["",'.$noscore.']]';
    $over_all_score[$key]['options_json']='{"pieHole": "0.5", "pieSliceTextStyle":{"color": ""},"slices": {"0": {"color": "'.$color.'"}, "1": {"color": "#CCCCCC"}},"legend": "none"}';
    $ovarallscore=$score+$ovarallscore;
    $ovarallcount=$ovarallcount+1;


    $res['over_all_score']=$over_all_score;
    $res['keys']=$keys;

    return $res;
}


if($os->get('view_report')=='OK' && $os->post('view_report')=='OK' && $os->post('report_name')=='student_count')
{

    $asession_s =$os->post('asession_s');

    if($asession_s=='')
    {
        $asession_s=date('Y');
    }

    $current_month=date('m');

    $school= $os->school_setting();

    $over_all_score_data= calculate_score($asession_s);
    $over_all_score= $over_all_score_data['over_all_score'];
    $keys= $over_all_score_data['keys'];
    ?>
    ##--score-keys--##<? echo implode('==',$keys); ?>##--score-keys--##

    ##--report-data--##
    <h2 class="uk-hidden"><? echo $school['school_name']?></h2>

    <ul uk-accordion="" class="uk-margin">
        <li class="border-xxs uk-text-muted uk-open uk-border-rounded uk-overflow-hidden">
            <a class="uk-accordion-title  uk-padding-small uk-background-secondary uk-light" href="#">Over all  Score</a>
            <div class="uk-accordion-content">
                <div class="uk-grid uk-grid-divider uk-grid-collapse uk-child-width-1-3@s uk-child-width-1-4@m " uk-grid>

                    <? foreach($over_all_score as $data){ ?>
                        <div class="uk-text-center " >
                            <div>
                                <div class="uk-position-relative" style=" border-color:<? echo $data['color'] ?>"  >
                                    <div id="<? echo $data['graph_div_id'] ?>" class="uk-margin-auto uk-width-1-1"> </div>
                                    <div class="uk-position-absolute uk-position-center uk-text-large uk-text-bold"   style="color:<? echo $data['color'] ?>;"  > <? echo $data['score'] ?></div>

                                </div>
                                <div class="center_title"   ><? echo $data['title'] ?></div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </li>
        <li class="border-xxs uk-text-muted uk-border-rounded uk-overflow-hidden">
            <?
            $query="select count(*) cc, class, (class*1) as classes,section  from history  where asession='$asession_s' group by  class,section order by classes asc ";
            $rsResults=$os->mq($query);
            $data=array();
            while($record=$os->mfa( $rsResults))
            {
                $data[$record['class']][$record['section']]=$record['cc'];

                if(!isset($data[$record['class']]['total'])){$data[$record['class']]['total']=0;}
                $data[$record['class']]['total'] =$data[$record['class']]['total']+$record['cc'];


            }

            ?>


            <a class="uk-accordion-title  uk-padding-small uk-background-secondary uk-light" href="#">Total Student <? echo  $asession_s ?></a>
            <div class="uk-accordion-content">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <tr>
                            <td>Class</td>
                            <td> A</td>
                            <td> B</td>
                            <td>C</td>
                            <td>Total</td>
                        </tr>
                        <?
                        $total=0;
                        foreach($data as $class_id=>$val){
                            $classtotal =$os->val($val,'total');
                            $total=$total+$classtotal;
                            ?>

                            <tr>
                                <td><? echo  $os->classList[$class_id] ?></td>
                                <td><? echo $os->val($val,'A');?> </td>
                                <td><? echo $os->val($val,'B');?> </td>
                                <td><? echo $os->val($val,'C');?> </td>
                                <td><? echo  $classtotal;?> </td>
                            </tr>




                        <? } ?>

                        <tr>
                            <td colspan="4">Total</td>

                            <td><? echo  $total;?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </li>
        <li class="border-xxs uk-text-muted uk-border-rounded uk-overflow-hidden">


            <?

            $total_fees=  $os->total_fees($asession_s);
            $total_paid=  $os->total_fees_paid($asession_s);
            $total_discount=  $os->total_discount($asession_s);


            ?>
            <a class="uk-accordion-title  uk-padding-small uk-background-secondary uk-light" href="#">Fees   <? echo  $asession_s ?> </a>
            <div class="uk-accordion-content">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <tr>
                            <td><b>Month</b></td>
                            <td><b> Fees</b></td>
                            <td><b> Paid</b></td>
                            <td><b>Due</b></td>
                            <td><b>Disc.</b></td>

                        </tr>
                        <?
                        $fees_amount_total=0;
                        $paid_amount_total=0;
                        $discount_amount_total=0;
                        $due_amount_total=0;


                        $fees_amount_total_till_now=0;
                        $paid_amount_total_till_now=0;
                        $discount_amount_total_till_now=0;
                        $due_amount_total_till_now=0;

                        $total=0;
                        foreach($os->feesMonth as  $month=>$month_name){


                            $till_now=false;
                            $ym_c=(int)date('Ym');
                            $ym=$asession_s.str_pad($month, 2, "0", STR_PAD_LEFT);
                            $ym=(int)$ym;
                            if($ym<=$ym_c)
                            {
                                $till_now=true;

                            }




                            $fees_amount=$os->val($total_fees,$month);
                            $paid_amount=$os->val($total_paid,$month);
                            $due_amount=$fees_amount-$paid_amount;
                            $discount_amount=$os->val($total_discount,$month);


                            $fees_amount_total=$fees_amount_total+$fees_amount;
                            $paid_amount_total=$paid_amount_total+$paid_amount;
                            $discount_amount_total=$discount_amount_total+$discount_amount;
                            $due_amount_total=$due_amount_total+$due_amount;


                            if($till_now){


                                $fees_amount_total_till_now=$fees_amount_total_till_now+$fees_amount;
                                $paid_amount_total_till_now=$paid_amount_total_till_now+$paid_amount;
                                $discount_amount_total_till_now=$discount_amount_total_till_now+$discount_amount;
                                $due_amount_total_till_now=$due_amount_total_till_now+$due_amount;
                            }




                            $fees_amount= $os->showAmount($fees_amount);
                            $paid_amount= $os->showAmount($paid_amount);
                            $due_amount= $os->showAmount($due_amount);
                            $discount_amount= $os->showAmount($discount_amount);


                            ?>

                            <tr style="color:#B6B6B6">
                                <td <? if($till_now){ ?>style="color:#000000;" <? } ?>><? echo  $month_name ?>   </td>
                                <td <? if($till_now){ ?>style="color:#000000;" <? } ?>><? echo $fees_amount;?> </td>
                                <td  <? if($till_now){ ?>style="color:#009900;" <? } ?> ><? echo $paid_amount;?> </td>
                                <td  <? if($till_now){ ?> style="color:#FF0000;" <? } ?> ><? echo $due_amount;?> </td>
                                <td  <? if($till_now){ ?> style="color:#006CD9;" <? } ?>><? echo $discount_amount;?> </td>

                            </tr>


                        <? }


                        $fees_amount_total= $os->showAmount($fees_amount_total);
                        $paid_amount_total= $os->showAmount($paid_amount_total);
                        $due_amount_total= $os->showAmount($due_amount_total);
                        $discount_amount_total= $os->showAmount($discount_amount_total);



                        $fees_amount_total_till_now= $os->showAmount($fees_amount_total_till_now);
                        $paid_amount_total_till_now= $os->showAmount($paid_amount_total_till_now);
                        $discount_amount_total_till_now= $os->showAmount($discount_amount_total_till_now);
                        $due_amount_total_till_now= $os->showAmount($due_amount_total_till_now);



                        ?>
                        <tr>
                            <td>Up to date </td>
                            <td ><b><? echo $fees_amount_total_till_now;?></b> </td>
                            <td   style="color:#009900;"  ><b><? echo $paid_amount_total_till_now;?></b>  </td>
                            <td   style="color:#FF0000;"  ><b><? echo $due_amount_total_till_now;?></b>  </td>
                            <td   style="color:#006CD9;"  ><b><? echo $discount_amount_total_till_now;?></b>  </td>

                        </tr>
                        <tr style="color:#999999">
                            <td>Total all </td>
                            <td ><b><? echo $fees_amount_total;?></b> </td>
                            <td  ><b><? echo $paid_amount_total;?></b>  </td>
                            <td  ><b><? echo $due_amount_total;?></b>  </td>
                            <td  ><b><? echo $discount_amount_total;?></b>  </td>

                        </tr>

                    </table>
                </div>
            </div>
        </li>
        <li class="border-xxs uk-text-muted uk-border-rounded uk-overflow-hidden">

            <?

          //  $total_fees=  $os->total_fees_monthwise($asession_s,$current_month);
$exp_data=array(); 
    
     $qexp=" SELECT MONTH(el.dated) m, SUM(eld.total_incl_tax) t_incl_tax, SUM(eld.total_incl_tax) t_incl_tax, YEAR(dated) AS y FROM expense_list el 
LEFT JOIN expense_list_details eld
ON (el.expense_list_id=eld.expense_list_id)
GROUP BY YEAR(el.dated) , MONTH(el.dated)  order by m asc";

  
$rsResults=$os->mq($qexp);
while($record=$os->mfa( $rsResults))
{  
  $exp_data[$record['y']][$record['m']] = $record;
}
$exp_data=$os->val($exp_data,$asession_s);
 
 
   
   
    

            ?>
            <a class="uk-accordion-title  uk-padding-small uk-background-secondary uk-light" href="#">Expense   <? echo  $asession_s ?> </a>
            <div class="uk-accordion-content">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <tr>
                            <td><b>Month</b></td>
                            <td><b>Amount</b></td>

                        </tr>
                        <?
                        $month_amount_total=0;


                        $total=0;
                        foreach($os->feesMonth as  $month=>$month_name){



                            $month_amount=$os->val($exp_data,$month,'t_incl_tax');
$month_amount_total=(int)$month_amount+$month_amount_total;

                            ?>

                            <tr>
                                <td><? echo  $month_name ?>   </td>
                                <td ><? echo $month_amount;?> </td>

                            </tr>


                        <? }


                        $month_amount_total= $os->showAmount($month_amount_total);


                        ?>

                        <tr>
                            <td>Total </td>
                            <td ><b><? echo $month_amount_total;?></b> </td>


                        </tr>

                    </table>
                </div>
            </div>
        </li>
        <li class="border-xxs uk-text-muted uk-border-rounded uk-overflow-hidden">

            <?

            $result=  $os->student_avarage_percentage($asession_s);


            ?>
            <a class="uk-accordion-title  uk-padding-small uk-background-secondary uk-light" href="#">Student Performance   <? echo  $asession_s ?> </a>
            <div class="uk-accordion-content">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <thead>
                        <tr style="font-size:10px">
                            <th>Class</th>
                            <th nowrap="nowrap"> < 60%</th>
                            <th nowrap="nowrap"> 60% - 69%</th>
                            <th nowrap="nowrap">70% - 79%</th>
                            <th nowrap="nowrap">80% - 89%</th>
                            <th nowrap="nowrap">>= 90%</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $totals['0_59']=0;
                        $totals['60_69']=0;
                        $totals['70_79']=0;
                        $totals['80_89']=0;
                        $totals['90_100']=0;
                        foreach($os->classList as $class_id=>$class_name)
                        {




                            $result_0_59=$os->val($result,$class_id,'0_59');
                            $result_60_69=$os->val($result,$class_id,'60_69');
                            $result_70_79=$os->val($result,$class_id,'70_79');
                            $result_80_89=$os->val($result,$class_id,'80_89');
                            $result_90_100=$os->val($result,$class_id,'90_100');

                            $totals['0_59']=$totals['0_59']+$result_0_59;
                            $totals['60_69']=$totals['60_69']+$result_60_69;
                            $totals['70_79']=$totals['70_79']+$result_70_79;
                            $totals['80_89']=$totals['80_89']+$result_80_89;
                            $totals['90_100']=$totals['90_100']+$result_90_100;

                            ?>

                            <tr>
                                <td><? echo  $class_name ?></td>
                                <td class="res_60"><? echo $result_0_59;?> </td>
                                <td class="res_60"><? echo $result_60_69;?> </td>
                                <td class="res_70"><? echo $result_70_79;?> </td>
                                <td class="res_80"><? echo $result_80_89;?> </td>
                                <td class="res_80"><? echo $result_90_100;?> </td>
                            </tr>




                        <? } ?>
                        <tr>
                            <td>Total</td>
                            <td class="res_60"><? echo $totals['0_59'];?> </td>
                            <td class="res_60"><? echo $totals['60_69'];?> </td>
                            <td class="res_70"><? echo $totals['70_79'];?> </td>
                            <td class="res_80"><? echo $totals['80_89'];?> </td>
                            <td class="res_80"><? echo $totals['90_100'];?> </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </li>
    </ul>

    ##--report-data--##
    <? foreach($over_all_score as $id_key=>$data){ ?>
    ##--<? echo $id_key; ?>-data_array--##<? echo $data['data_array']; ?>##--<? echo $id_key; ?>-data_array--##
    ##--<? echo $id_key; ?>-options_json--##<? echo $data['options_json']; ?>##--<? echo $id_key; ?>-options_json--##
    ##--<? echo $id_key; ?>-graph_div_id--##<? echo $data['graph_div_id']; ?>##--<? echo $id_key; ?>-graph_div_id--##

<? } ?>


    <?



} ?>

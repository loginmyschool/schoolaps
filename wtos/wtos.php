<?php
 //require_once($site['root'].'database_selection.php');
 include($site['library']."wtosLibrary.php");
 include($site['global-property']."wtosGlobalFunction.php");
class wtos extends librarySettings  /// property only for backoffice
{







		// local settings
		var $showPerPage=20;   #overwritten
		var $dateFormat='Y-m-d';  #overwritten
		var $dateFormatJs='yy-mm-dd'; #overwritten
		var $dateFormatDB='Y-m-d h:i:s'; #overwritten
		var $wtAccess=array('wtAdd'=>true,'wtEdit'=>true,'wtDelete'=>true,'wtView'=>true); #overwritten

		var $noOfAttendenceDate=4;

		// system default settings


		var  $adminTitle='Aurangabad Public School';
		var  $adminDescription='wtos  administration system';
		var  $adminKeywords='wtos  administration system ';


		var $boxContainer=array (  'None' => 'None', 'Div' => 'Div',  'Span' => 'Span');
		var $boxYesNo= array ('Yes' => 'Yes', 'No' => 'No' );
		var $boxActive=array ('Active' => 'Active','Inactive' => 'Inactive');
		var $boxActiveColor=array ('Active' => '9FFFB8','Inactive' => 'FF8080');

		//var $adminType=  array ('Admin' => 'Admin','Super Admin' => 'Super Admin','Principle' => 'Principle', 'Head Master' => 'Head Master','Asistant Teacher' => 'Asistant Teacher', 'Operator' => 'Operator');

		var $adminType=  array ('Super Admin' => 'Super Admin',
		'Global Admin' => 'Global Admin',
		'Branch Admin' => 'Branch Admin',
		'Hostel Super' => 'Hostel Super',
		'Canteen Manager' => 'Canteen Manager',
		'Assistant Canteen Manager' => 'Assistant Canteen Manager',
		'Teacher-In-Charge' => 'Teacher-In-Charge',
		'Branch-In-Charge' => 'Branch-In-Charge',
		'Principal' => 'Principal',
		'Assistant Teacher' => 'Assistant Teacher',
		'Guest Teacher' => 'Guest Teacher',
		'Office Incharge' => 'Office Incharge',
		'Accountant' => 'Accountant',
		'Construction Head' => 'Construction Head',
		'Electrical Head' => 'Electrical Head',
		'Driver' => 'Driver',
		'Librarian' => 'Librarian',
		'Operator' => 'Operator',
		'Sweeper' => 'Sweeper',
		'Cleaner' => 'Cleaner',
		'Moulana' => 'Moulana',
		'Medical Assistant' => 'Medical Assistant',
		'Floor In-Charge' => 'Floor In-Charge',
		'Other Employee' => 'Other Employee'


		);


		var $adminActive= array ('Active' => 'Active','Inactive' => 'Inactive');
		var $contactUsStatus= array ( 'New' => 'New',  'Viewed' => 'Viewed' );
		var $galleryCatagoryActive= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
		var $photoGalleryStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );

		var $noticeboardStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
		var $noticeboardStatuseColor=array ('Active' => '9FFFB8','Inactive' => 'FF8080');
		var $activeStatuseColor=array ('active' => '9FFFB8','inactive' => 'FF8080');
		var $yesnoColor=array ('Yes' => '9FFFB8','No' => 'FF8080');


		var $pageContentStatusColor=array ('1' => '9FFFB8','0' => 'FF8080');
		var $pageContentStatus=array ('1' => 'Active','0' => 'Inactive');

		var $staffStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );

		//var $adminAccess=array();

		 // var $adminAccess=array('View Dashboard'=>'View Dashboard','View Session'=>'View Session','View All Student'=>'View All Student','View Student Register'=>'View Student Register','View Staff'=>'View Staff','View Fees'=>'View Fees','Add Fees'=>'Add Fees','Edit Fees'=>'Edit Fees','Delete Fees'=>'Delete Fees','View Salary'=>'View Salary','Add Salary'=>'Add Salary','Edit Salary'=>'Edit Salary','Delete Salary'=>'Delete Salary','View Expense'=>'View Expense','Add Expense'=>'Add Expense','Edit Expense'=>'Edit Expense','Delete Expense'=>'Delete Expense','View Fees Expense Salary Report'=>'View Fees Expense Salary Report','View Credit Debit Report'=>'View Credit Debit Report','View Collected By Report'=>'View Collected By Report');  // add more here




		   var $adminAccess=array(
				'Home'=>'Home',
				'Users'=>'Users',
				'Admin'=>'Admin',
				'Staffs'=>'Staffs',
				'Website'=>'Website',
				'Settings'=>'Settings',
				'Session'=>'Session',
				'Subject settings'=>'Subject settings',
				'Vehicle setting'=>'Vehicle setting',
				'Fees settings'=>'Fees settings',
				'Global setting'=>'Global setting',
				'Certificate Format'=>'Certificate Format',
				'Hostel Room'=>'Hostel Room',
				'Hostel Setting'=>'Hostel Setting',
				'Global Templats'=>'Global Templats',
				'Exam Settings'=>'Exam Settings',
				'Quention Paper'=>'Quention Paper',
				'Result Entry Access'=>'Result Entry Access',
				'Result Entry'=>'Result Entry',
				'School setting'=>'School setting',
				'E-Class'=>'E-Class',
				'Misc'=>'Misc',
				'Account Head'=>'Account Head',
				'Expense'=>'Expense',
				'Budget'=>'Budget',
				'Expense Payment'=>'Expense Payment',
				'Review Subject'=>'Review Subject',
				'Review Details'=>'Review Details',
				'Salary'=>'Salary',
				'Student Register'=>'Student Register',
				'Admission'=>'Admission',
				'Admission Process'=>'Admission Process',
				'Readmission Process'=>'Readmission Process',
				'Application Forms'=>'Application Forms',
				'Library'=>'Library',
				'Books List'=>'Books List',
				'Purchase Entry'=>'Purchase Entry',
				'Book Shelf'=>'Book Shelf',
				'Book Issue'=>'Book Issue',
				'Attendance'=>'Attendance',
				'Student Attendence'=>'Student Attendence',
				'Staff Attendence'=>'Staff Attendence',
				'Backup'=>'Backup',
				'Report'=>'Report',
				'Admission report'=>'Admission report',
				'Student Result Reoprt'=>'Student Result Reoprt',
				'Statistics'=>'Statistics',
				'Manage Land'=>'Manage Land'



		   );  // add more here






		  var $feesStatusColor=array ('Paid' => '9FFFB8','Unpaid' => 'FF8080');

		  var $kanyashree= array ('Yes' => 'Yes', 'No' => 'No' );

		  var $yuvashree= array ('Yes' => 'Yes', 'No' => 'No' );
		  var $historyStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
		  var $student_status_active= array ( 'Y' => 'Active', 'N' => 'Inactive'  );

	  var $feesPayment= array ( 'Monthly' => 'Monthly', 'Quarterly' => 'Quarterly', 'Yearly' => 'Yearly'  );


	  var $memberType=array('super_admin' => 'super_admin','operator' => 'operator','teacher' => 'teacher','student' => 'student','gurdian' => 'gurdian');

	   var $discountType= array ( 'RS' => 'RS', '%' => '%'  );
       var $verification_access_Y_N= array ('Yes' => 'Yes', 'No' => 'No' );
	   
	   var $primery_verification_status= array ('Verified' => 'Verified', '' => 'Pending', 'Cancelled' => 'Cancelled');
	   var $final_verification_status= array ('Verified' => 'Verified', '' => 'Pending', 'Cancelled' => 'Cancelled');

function branch_access()
{

  $return=array();
  $access=$this->userDetails['access'];
  $branches_code_str_query="'NO BRANCH ACCESS'";
  if(trim($access)=='')
  {

     $branches_code_str_query="'NO BRANCH ACCESS'";
	 $branches=array();

  }
  else{

    $access_array=json_decode($access,true);
	$branches=array_keys($access_array);

	$branches=array_combine($branches,$branches);

	$branches_code_str_query="'".implode("','",$branches)."'";

  }
   $branches_code_IN='';
   if($branches_code_str_query!='')
   {
      $branches_code_IN= " IN ($branches_code_str_query)  ";
   }
    $return['branches_code_str_query']=$branches_code_str_query;
	$return['branches_code_IN']=$branches_code_IN;


	$return['branches_code']=$branches;
	$return['access_array']=$access_array;


	 return $return;

 }


 function check_page_access_not_in_use($access_key='',$branch='')
 {
	global $os;
	$access_key=trim($access_key);
	$branch=trim($branch);

	$return_access=false;
	$access=$this->userDetails['access'];
	//if($branch==''){$branch='ALL';}

	$branch_allow='NO';
	//$page_allow='NO';
	$access_key_allow='NO';



	if(trim($access)=='' && $access_key=='' )
	{
		$branch_allow='NO';
		//$page_allow='NO';
		$access_key_allow='NO';
	}
	else
	{
			$access_array=json_decode($access,true);
			$branches=array_keys($access_array);
			if(in_array($branch,$branches))
			{
			   	$branch_allow='YES';
				$branch_access_array=$access_array[$branch];
				 if(in_array($access_key,$branch_access_array))
			     {
				   $access_key_allow='YES';
				 }

				// _d($os->currentPage);

			}

	}

	if($branch_allow=='YES' && $access_key_allow=='YES')
	{
	  $return_access=true;
	}

	return $return_access;

 }
 function check_page_access($access_key='',$branch='')
 {
	global $os;
	$access_key=trim($access_key);
	$branch=trim($branch);

	$return_access=false;
	$access=$this->userDetails['access'];
	if($branch=='ALL'){$branch='';}

	$branch_allow='NO';
	//$page_allow='NO';
	$access_key_allow='NO';



	if(trim($access)=='' && $access_key=='' )
	{
		$branch_allow='NO';
		//$page_allow='NO';
		$access_key_allow='NO';
	}
	else
	{
			$access_array=json_decode($access,true);
			$branches=array_keys($access_array);
			if(in_array($branch,$branches))
			{
			   	$branch_allow='YES';
				$branch_access_array=$access_array[$branch];
				 if(in_array($access_key,$branch_access_array))
			     {
				   $access_key_allow='YES';
				 }

				// _d($os->currentPage);

			}

	}

	if($branch_allow=='YES' && $access_key_allow=='YES')
	{
	  $return_access=true;
	}

	return $return_access;

 }

 function checkAccess($accKey='')
 {
   // return true;
   $selected_branch_code=$this->getSession($key1='selected_branch_code');
 //  echo $selected_branch_code; exit();
  // return  $this->check_page_access($accKey,$branch='ALL');
   return  $this->check_page_access($accKey,$branch=$selected_branch_code);

 }


function checkAccess_old($accKey=''){

		if($accKey!=''){
			$accArr = array();

			if($this->userDetails['access']!=''){
				$accArr = explode(',',$this->userDetails['access']);
			}
			if(is_array($accArr) && in_array($accKey,$accArr)){
				return true;
			}
		}
		else{
			return false;
		}
	}




  function no_to_words($no) {

      $words = array('0'=> '' ,'1'=> 'One' ,'2'=> 'Two' ,'3' => 'Three','4' => 'Four','5' => 'Five','6' => 'Six','7' => 'Seven','8' => 'Eight','9' => 'Nine','10' => 'Ten','11' => 'Eleven','12' => 'Twelve','13' => 'Thirteen','14' => 'Fouteen','15' => 'Fifteen','16' => 'Sixteen','17' => 'Seventeen','18' => 'Eighteen','19' => 'Nineteen','20' => 'Twenty','30' => 'Thirty','40' => 'Fourty','50' => 'Fifty','60' => 'Sixty','70' => 'Seventy','80' => 'Eighty','90' => 'Ninty','100' => 'Hundred','1000' => 'Thousand','100000' => 'Lakh','10000000' => 'Crore');



      if($no == 0)



      return ' ';



      else {



      $novalue='';



      $highno=$no;



      $remainno=0;



      $value=100;



      $value1=1000;



      while($no>=100) {



      if(($value <= $no) &&($no < $value1)) {



      $novalue=$words["$value"];



      $highno = (int)($no/$value);



      $remainno = $no % $value;



      break;



      }



      $value= $value1;



      $value1 = $value * 100;



      }



      if(array_key_exists("$highno",$words))



      return $words["$highno"]." ".$novalue." ".$this->no_to_words($remainno);



      else {



      $unit=$highno%10;



      $ten =(int)($highno/10)*10;



      return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->no_to_words($remainno);



      }



      }







	}


function datesB2nDateRange($from,$to,$interval,$format)
	{
	        //$from_Y date('', strtotime($from));
	        $dateRangeArray=array();
			$begin = new DateTime( $from );
			$end = new DateTime( $to );
			$interval = new DateInterval($interval);
			$end->add( $interval );
			$daterange = new DatePeriod($begin, $interval ,$end);

			foreach($daterange as $date)
			{
				$dateRangeArray[] = $date->format($format);
			}
			return $dateRangeArray;
	}






function isweekend($date){

    $date = strtotime($date);
    $date = date("l", $date);
    $date = strtolower($date);

    if($date == "saturday" || $date == "sunday") {
        return "true";
    } else {
        return "false";
    }
}



function isHoliday($date){

	$holidayQuery="select * from holidays where holidaysId>0";
    $holidayMq=$this->mq($holidayQuery);
    while($holidayData=$this->mfa($holidayMq))
    {
		$holidayDate[]=$this->showDate($holidayData['dated']);
    }

    if (in_array($date, $holidayDate))
	{
        return "true";
    }
	else {
        return "false";
    }
}

	function editDate($value,$table,$editFld,$idFld,$idVal , $inputNameID='editText',$extraParams='class="editText" ',$ajaxPage='',$ajaxMethod='POST',$phpFunc='',$javascriptFunc='',$advanceOption='TYPE=DATE')
	{

	// $advanceOption added for future use

		global $site;
		if($ajaxPage==''){$ajaxPage='wtos/wtosSystemAjax.php';}
		$ajaxPage=$site['url'].$ajaxPage;
		if(is_array($advanceOption)) {$advanceOption=implode('--',$advanceOption);}
		if($ajaxMethod==''){$ajaxMethod='GET';}

		 $vars=	"'$table','$editFld','$idFld','$idVal','$ajaxPage','$ajaxMethod','$phpFunc','$javascriptFunc','$advanceOption'";

		?>
		<input name="<? echo $inputNameID; ?>" id="<? echo $inputNameID; ?>" type="text"  onchange="os.wtosEditField(this,<? echo $vars?>)" value="<? echo $value ?>"  <? echo $extraParams; ?> >

		<?
	}
	function calTotalAmtAndColAmt($year)
	{
	$paidAmtQuery="SELECT SUM(paid_amount) as paidAmt,SUM(payble) as paybleAmt,class from fees  where feesId>0 and year='$year' group by class";
    $paiAmtMq=$this->mq($paidAmtQuery);
	while($amt=$this->mfa($paiAmtMq))
	{
		$paidAndtoatlAmtArray['paid_amount']=$amt['paidAmt'];
		$paidAndtoatlAmtArray['payble']=$amt['paybleAmt'];
		$classAmtArray[$amt['class']]=$paidAndtoatlAmtArray;
	}
	//_d($classAmtArray);

	return $classAmtArray;
	}


function setAsession()
{
 $makeSessionQuery="SELECT * from accademicsession  where accademicsessionId>0 and status='active'";
$makeSessionMq=$this->mq($makeSessionQuery);
while($data=$this->mfa($makeSessionMq))
{
$this->asession[$data['idKey']]=$data['title'];
}
}






function deleteRemainMonthlyFeesForInactive($historyId,$studentId,$inactiveDate='')
{
	if($inactiveDate!='')
	{

	$inactiveDateA=explode('-',$inactiveDate);
	$inactiveDateM=$inactiveDateA[1];
	$inactiveDateY=$inactiveDateA[2];
	$feesQ="select * from fees where feesId>0 and historyId='$historyId' and studentId='$studentId' and month='$inactiveDateM' and year='$inactiveDateY'";
	$feesMq=$this->mq($feesQ);
	while($feesD=$this->mfa($feesMq))
	{
	$feesId=$feesD['feesId'];
	$this->mq("delete from  fees  where feesId>0 and historyId='$historyId' and studentId='$studentId' and feesId>'$feesId'");
	}
	}
}




    function replace_template_value($template_keys,$str='')
    {
        if($str!='' && is_array($template_keys))
        {
            foreach($template_keys as  $key=>$value)
            {
                $str= str_replace($key,$value,$str);
            }
        }

        return $str;
    }

function get_template_keys()
{
        $template_keys=array();
        $template_keys['...NAME...']='';
		 $template_keys['...SON-DOT...']='son';
		$template_keys['...FATHERNAME...']='';
		$template_keys['...IS-WAS...']='is';
		$template_keys['...HE-SHE...']='He';
		$template_keys['...YEAR...']='';
		$template_keys['...CLASS...']='';
		$template_keys['...DOB...']='';
		$template_keys['...ADMISSION_NO...']='';
		$template_keys['...STUDENT_ID...']='';
		$template_keys['...HIS-HER...']='his';
		$template_keys['...INPUT_1...']='<input type="text" class="silent_input_big" id="text_line_1_helper" value=""  onchange="setDataToFields(\'text_line_1\')"  />';
		$template_keys['...INPUT_2...']='<input type="text"class="silent_input_big" id="text_line_2_helper" value=""  onchange="setDataToFields(\'text_line_2\')"  />';
		$template_keys['...INPUT_3...']='<input type="text"class="silent_input_big" id="text_line_3_helper" value=""  onchange="setDataToFields(\'text_line_3\')"  />';
		$template_keys['...INPUT_4...']='<input type="text"class="silent_input_big" id="text_line_4_helper" value=""  onchange="setDataToFields(\'text_line_4\')"  />';
		$template_keys['...INPUT_5...']='<input type="text"class="silent_input_big" id="text_line_5_helper" value=""  onchange="setDataToFields(\'text_line_5\')"  />';
		$template_keys['...INPUT_6...']='<input type="text"class="silent_input_big" id="text_line_6_helper" value=""  onchange="setDataToFields(\'text_line_6\')"  />';


	   /*$template_keys=array();
        $template_keys['[#-NAME-#]']='MIzanur RAhaman';
		$template_keys['[#-SON/DOT-#]']='son';
		$template_keys['[#-FATHERNAME-#]']='Abdul Gofur';
		$template_keys['[#-IS/WAS-#]']='MIzanur RAhaman';
		$template_keys['[#-NAME-#]']='MIzanur RAhaman';
		$template_keys['[#-YEAR-#]']='2018';
		$template_keys['[#-CLASS-#]']='VII';
		$template_keys['[#-DOB-#]']='12/12/2019';
		$template_keys['[#-ADMISSION_NO-#]']='12/12/2019';
		$template_keys['[#-STUDENT_ID-#]']='12/12/2019';
		$template_keys['[#-HIS/HER-#]']=' ';
		$template_keys['[#-INPUT_1-#]']='<input type="text" id="text_line_1_helper" value="" />';
		$template_keys['[#-INPUT_2-#]']='<input type="text" id="text_line_2_helper" value="" />';
		$template_keys['[#-INPUT_3-#]']='<input type="text" id="text_line_3_helper" value="" />';
		$template_keys['[#-INPUT_4-#]']='<input type="text" id="text_line_4_helper" value="" />';
		$template_keys['[#-INPUT_5-#]']='<input type="text" id="text_line_5_helper" value="" />';
		$template_keys['[#-INPUT_6-#]']='<input type="text" id="text_line_6_helper" value="" />';*/

return $template_keys;

}

function dataList($query,$field,$datalistId)
{
   // echo $query;
    echo '<datalist id="'.$datalistId.'">';
	$qrs=$this->mq($query);
	while($qdata=$this->mfa($qrs))
	{
	  //  _d( $qdata);
      echo' <option value="'.$qdata[$field].'">';

	}
	 echo '</datalist>';

}

function selectedSession()
{
 return date('Y');
}

function getSubjectList($asession='',$classId='')
{
       $and_asession='';
	   if($asession!=''){
	   $and_asession=" and  asession='$asession' ";

	   }


	   $and_classId='';
	   if($classId!='')
	   {
	    $and_classId=" and  classId='$classId' ";

	   }

	    $dataQuery=" select * from subject where subjectId>0 $and_asession  $and_classId  ";
		$rsResults=$this->mq($dataQuery);

		$subjectArr=array();
		while($record=$this->mfa( $rsResults))
		{
		 $subjectArr[$record['subjectId']]=$record['subjectName'];
		}
		return $subjectArr;
}

function isValidStudent($studentId,$asession,$class ,$roll_no )
{
               $studentId=0;
               $alreadyEntryquery="select studentId from history where class!=''  and  asession='$asession'   and class='$class'
				      and  roll_no='$roll_no' and   studentId='$studentId'  limit 1";

	            	$alreadyEntryquery_rs=$this->mq($alreadyEntryquery);
					$alreadyEntryquery=$this->mfa($alreadyEntryquery_rs);
					if(isset($alreadyEntryquery['studentId']))
					{

					 $studentId=$alreadyEntryquery['studentId'];
					}

return  $studentId;
}


function  create_record_for_all_student($examTitle,$asession,$classes,$subject_id,$subjectName,$examId,$examdetailsId)
{

     if($examTitle!='' && $asession!='' && $classes!='' &&  $subject_id!='' && $subjectName!='')
	 {


                $alreadyEntryquery="select rs.studentId from resultsdetails  rs where rs.class!=''  and  rs.asession='$asession'   and rs.class='$classes'
				      and  rs.examTitle='$examTitle' and   rs.subjectId='$subject_id' ";

				   $selectEntryquery="select h.studentId,h.historyId,h.roll_no,h.section from history h where h.class!=''  and  h.asession='$asession'  and h.class='$classes'
				    and h.studentId NOT IN($alreadyEntryquery) ";
	            	$selectEntryquery_rs=$this->mq($selectEntryquery);
					while($restStudent=$this->mfa($selectEntryquery_rs) )
					{

					  $dataToSave=array();
				$dataToSave['examTitle']=$examTitle;
				$dataToSave['asession']=$asession;
				$dataToSave['class']=$classes;
				$dataToSave['subjectId']=$subject_id;
				 $dataToSave['subjectName']=$subjectName; // name please
				  $dataToSave['examId']=$examId;
				  $dataToSave['examdetailsId']=$examdetailsId;


				$dataToSave['section']=$restStudent['section'];
				$dataToSave['roll_no']=$restStudent['roll_no'];
				$dataToSave['studentId']=$restStudent['studentId'];
				$dataToSave['historyId']=$restStudent['historyId'];

				$dataToSave['writtenMarks']='';
				$dataToSave['viva']='';
				$dataToSave['practical']='';
				$dataToSave['totalMarks']='';
				$dataToSave['grade']='';
				$dataToSave['addedDate']=$this->now();
				$dataToSave['addedBy']='';
				$dataToSave['modifyBy']='';
				$dataToSave['modifyDate']=$this->now();
				$resultsdetailsId=0;
                $qResult=$this->save('resultsdetails',$dataToSave,'resultsdetailsId',$resultsdetailsId);

					  $qResult->query;
					}
			}

}
    function feesBoxDesign($feesType_val,$feesHead_arr)
    {


        ?>

        <div  class="background-color-white material-card-layout">

            <div class="material-card-layout-header p-m">
                <h3 class="p-m"><? echo $feesType_val ?></h3>
                <ul class="actions">
                    <li class="p-m" onclick="collapse_expand(this, '#<? echo str_replace(" ","", $feesType_val) ?>_panel')">
                        <a><i class="mi">keyboard_arrow_up</i></a>
                    </li>

                </ul>
            </div>
            <div id="<? echo str_replace(" ","", $feesType_val) ?>_panel" class="material-card-layout-content for-table">
                <table>
                    <?
                    $total=0;
                    $k=0;
                    foreach($feesHead_arr as $head=>$amount){ $k++;?>

                        <tr> <td width="10" ><? echo $k;?>  </td> <td align="left" style="width:70px;"> <? echo $head ?> </td> <td align="right">  <? echo $amount ?>  </td> </tr>

                        <? $total=$total+$amount; } ?>

                    <tr> <td >  </td><td   align="left"> Total</td> <td   align="right"> <? echo $total; ?> </td>  </tr>
                </table>
            </div>
        </div>
        <?
    }

    function feesBoxDesignForAdmission($feesType_val,$feesHead_arr){
        ?>
        <table style="border-collapse: collapse; min-width: 100%">
            <?
            $total=0;
            $k=0;
            foreach($feesHead_arr as $head=>$amount){ $k++;?>

                <tr class="border-none border-bottom-xxs border-color-light-grey">
                    <td class="p-s"><? echo $k;?>  </td>
                    <td class="p-s"> <? echo $head ?> </td>
                    <td class="p-s right color-flat-green">  <? echo $amount ?></td>
                </tr>

                <? $total=$total+$amount; } ?>

            <tr>
                <td class="p-s">  </td>
                <td class="p-s left font-weight-xxl"> Total</td>
                <td  class="p-s right color-flat-green"> <? echo $total; ?> </td>
            </tr>
        </table>
        <?
    }

function isRecordExist($query,$returnField)
{
    $returnId='';
	$qq_rs=$this->mq($query);
	if($qq_rs)
	{
	   $qq=$this->mfa($qq_rs);

	   if(isset($qq[$returnField]))
	   {
	      $returnId=$qq[$returnField];
	   }

	 }

  return  $returnId;

}

function getArrayFromResource($dbResource)
{
$data=array();
 $k=0;
  while($rec=$this->mfa($dbResource))
  {
    $data[$k]=$rec;
	$k++;
  }
  return $data;

}

function student_barcode_href($studentId)
{
  global $site;
  $image_barcode=$site['url'].'barCode/'.$studentId.'-ean13.jpg';

  return $image_barcode;

}

function callback_subject_list(&$arr,&$val)
{
		 if(is_array($arr))
		 {

			$subject_id_str=implode(',',$arr);
			$arr=array();
						 	$resultQ="select * from  subject where subjectId IN( $subject_id_str )";
						$resultQ_rs = $this->mq($resultQ);
						while ($row = $this->mfa($resultQ_rs))
						{
						  $arr[$row['subjectId'] ]=$row['subjectName'].'-'.$row['subjectId'].'';

						}

		 }



}


function callback_subject_list_with_examdetails_id(&$arr,&$val)
{
		 if(is_array($arr))
		 {

			$subject_id_str=implode(',',$arr);
			//$arr=array();
			$subject_array=array();
						$resultQ="select * from  subject where subjectId IN( $subject_id_str )";
						$resultQ_rs = $this->mq($resultQ);
						while ($row = $this->mfa($resultQ_rs))
						{
						    $subject_array[$row['subjectId']]=$row['subjectName'].'  [S:'.$row['subjectId'];
						  
						}
			
			foreach($arr as $examdetailsId=>$subjectId)
			{
			  $arr[$examdetailsId]=$subject_array[$subjectId].'-ED:'.$examdetailsId.']';
			
			}			

		 }



}



}
$os=new wtos;

$os->loadWtosService($site['loginKey-wtos']);
 $os->mq('SET sql_mode = ""');
$os->setAsession();

?>

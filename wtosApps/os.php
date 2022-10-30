<?php
$autoloader_path = realpath($site['root'].'/vendor/autoload.php');
//composer
include($autoloader_path);
//require_once($site['root'].'database_selection.php');
include($site['library'].'wtosLibrary.php');
include($site['global-property'].'wtosGlobalFunction.php');




class wtos extends librarySettings

{

	// local settings

	var $dateFormat='d-m-Y';  #overwritten

	var $dateFormatJs='dd-mm-yy'; #overwritten

	//var $dateFormatDB='Y-m-d H:i:s'; #overwritten

	var $wtAccess=array('wtAdd'=>true,'wtEdit'=>true,'wtDelete'=>true,'wtView'=>true); #overwritten





	function selectedTab($seoid)

	{



		return ;

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

	function getCurrentSubscriptionStructures($isFeatured, $classId=null){
		$andIsFeatured = $isFeatured?" AND ss.is_featured='$isFeatured'":'';
		$andClassId = $classId?" AND ss.classId='$classId'":'';
		$query = $this->mq("SELECT  ss.*
			FROM subscription_structure ss
			    INNER JOIN global_session_setting gss on ss.asession = gss.asession AND NOW() BETWEEN gss.session_start_date AND gss.session_end_date 
			WHERE ss.subscription_structure_id>0 AND ss.active_status='active' $andIsFeatured $andClassId
			ORDER BY ss.classId");

		return $query->fetchAll();

	}


	function getStudentCurrentSubscriptions(): array
	{
		$res = $this->mq("SELECT h.asession, h.class, 
       			IF(s.student_type!='nonresidential', 1, IF(s2.subscription_id>0, 1, 0)) as is_subscribed, 
       			IF(s.student_type!='nonresidential', 1, IF(s2.online_class>0, 1, 0)) as has_eclass_access , 
       			IF(s.student_type!='nonresidential', 1, IF(s2.online_exam>0, 1, 0)) as has_exam_access FROM history h
    			INNER JOIN student s on h.studentId = s.studentId
    			INNER JOIN global_session_setting gss ON  h.asession=gss.asession AND NOW() BETWEEN gss.session_start_date AND gss.session_end_date
    			LEFT JOIN subscription s2 on h.historyId = s2.historyId AND s2.payment_status='Paid' 
				WHERE s.studentId='{$this->loggedUser()['studentId']}'
				GROUP BY h.historyId");
		return $this->mfa($res);
	}



}

$os=new wtos;

$os->loadWtosService($site['loginKey']);

//$os->mq('SET sql_mode = ""');



?>

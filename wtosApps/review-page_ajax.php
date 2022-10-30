<?php
include('../wtosConfig.php');
include('os.php'); 
$os->userDetails =$os->session($os->loginKey,'logedUser');
if($os->get('WT_review_listEditAndSave')=='OK'){

		$review_subject_id=$os->post('review_subject_id');
		$update_field=$os->post('update_field');
		$parent_id=$os->post('parent_id');
		$dataToSave[$update_field]=$os->post('fieldValue');
		
		
		$dataToSave['review_subject_id']=$review_subject_id;
		$dataToSave['parent_id']=$parent_id;
		$dataToSave['dated']=$os->now();
		$dataToSave['user_table_id']=$os->userDetails['studentId'];;
		$dataToSave['user_table']='student';
      
	  
	    
	    $date_to_compare=date('Y-m-d');
		$where_clause =" and  review_subject_id='$review_subject_id' and dated like '$date_to_compare%'";
		$review_details_id=$os->rowByField('review_details_id',$tables='review_details',$fld='parent_id',$parent_id,$where=$where_clause,$orderby=''); 
		
	 
	    
	    $qResult=$os->save('review_details',$dataToSave,'review_details_id',$review_details_id);
        
        
        if($qResult)
		{
            $mgs="Thank You.";  
        }
        else{
            $mgs="Error#-#Problem Saving Data.";
        }
        echo $mgs;      
        exit(); 
} 


if($os->get('WT_review_detailsListing')=='OK'){ // not necessery


       /* $anduser_table_id=  $os->postAndQuery('user_table_id','user_table_id','=');
        $f_startDate_s= $os->showDate($os->now()); $t_startDate_s= $os->showDate($os->now());
        $anddated=$os->DateQ('dated',$f_startDate_s,$t_startDate_s,$sTime='00:00:00',$eTime='23:59:59');
        $dataQuery="  select * from review_details where review_details_id>0  $anduser_table_id $anddated";
        $rsResults=$os->mq($dataQuery);
        while($row=$os->mfa( $rsResults)){
            $record[$row["review_details_id"]][$row["parent_id"].'-'.$row["review_subject_id"].'-'.'review_details_id']=$row["review_details_id"];
        $record[$row["review_details_id"]][$row["parent_id"].'-'.$row["review_subject_id"].'-'.'review_marks']=$row["review_marks"];
        $record[$row["review_details_id"]][$row["parent_id"].'-'.$row["review_subject_id"].'-'.'review_note']=$row["review_note"];
        }
        echo  json_encode($record);  
         exit();*/
}

?>


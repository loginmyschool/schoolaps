<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
$os->showPerPage=5000;
if($os->get('WT_resultsdetailsListing')=='OK'&&$os->post('resultDetailsListingVal')=='OKS'){
    $where='';
    $showPerPage        = $os->post('showPerPage');
    //result_details
    $and_examId     = $os->postAndQuery('examId_s','qa.examId','=');
    $and_class_rd       = $os->postAndQuery('class_s','qa.class','=');
    $and_asession_rd    = $os->postAndQuery('asession','qa.asession','=');
    $and_subject_rd     = $os->postAndQuery('subject_s','qa.subjectId','=');
$act=$os->post('act');
    //student details
	
    $and_branch_s       = $os->postAndQuery('branch_s','st.branch','=');

    //class id
    $and_class_h        = $os->postAndQuery('class_s','h.class','=');
	$examId=$os->post('examId_s');
	$subjectId=$os->post('subject_s');  
	$examdetailsId=$os->rowByField($getfld='examdetailsId','examdetails',$fld='examId',$fldVal=$examId,$where=" and subjectId='$subjectId'  ",$orderby='');
    
    // Delete duplicate row 
	    
	   if($examId >0 && $examdetailsId>0  && $act=='delete_duplicates'){
	     $os->mq("SET SESSION group_concat_max_len = 1000000");	  
		 $Q1=" SELECT MAX(b.questionanswaredId)FROM questionanswared as b where b.examId = '$examId'  and   b.examdetailsId = '$examdetailsId'  GROUP BY b.studentId,b.questionId ";
		 $q22= " select group_concat( q.questionanswaredId )  vv from  questionanswared q where  q.questionanswaredId NOT IN ($Q1) and  q.examId = '$examId'  and   q.examdetailsId = '$examdetailsId'  ";		  
		$rd= $os->mq($q22);
		 
			 while( $p= $os->mfa($rd))
			 {
			  
			  
			    $ids=$p['vv']; 
			   if($ids!=''){
						   $del_q=" DELETE from questionanswared where questionanswaredId IN ($ids)";
						   $os->mq($del_q);  
						   echo ' Deleted Duplicate Data'; 		
			   }	 
			  $i++;
			 }		
		 
		 }
		 
		 // Delete duplicate row       
	
	 $listingQuery=" select  *  from  questionanswared qab where qab.examdetailsId>0  and  qab.examId = '$examId'  and   qab.examdetailsId = '$examdetailsId' order by qab.studentId";                    
   $os->showPerPage=200;
   $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>	 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="listingRecords">
                    <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
                    <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
                        <tr class="borderTitle" >
                            <td>#</td>
                            
                            <td><b>examdetailsId</b></td>
							<td><b>questionId</b></td>
                            <td><b>studentId</b></td>
                            <td><b>answerSelected</b></td>
                            <td><b>addedDate</b></td>
							 
                            
                        </tr>
                        <?php
                        $serial=$os->val($resource,'serial');
                        while($record=$os->mfa( $rsRecords))
						{
                            $serial++;
                            



                            ?>
                            <tr class="trListing">
                                <td><?php echo $serial; ?></td>
								 <td><?php echo $record['examdetailsId']?> </td>
                                <td><? echo $record['questionId']; ?> </td>
                               
                                <td><? echo $record['studentId']; ?></td>
                                
                                <td><? echo $record['answerSelected'];?></td>
                                <td>  <? echo $record['addedDate']; ?></td>
								  
                               
                            </tr>
                        <? } ?>

                    </table>
                </div> </td>
            <td valign="top">
                
            </td>
        </tr>
    </table>


    <?php exit();
	
	 }  
	
	  
     

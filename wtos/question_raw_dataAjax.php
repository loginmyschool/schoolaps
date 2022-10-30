<?
/*
   # wtos version : 1.1
   # page called by ajax script in question_raw_dataDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
 
$pluginName='';
// $os->loadPluginConstant($pluginName);
function innerHTML(\DOMElement $element)
{
    $doc = $element->ownerDocument;

    $html = '';

    foreach ($element->childNodes as $node) {
        $html .= $doc->saveHTML($node);
    }

    return $html;
}

function get_question($question_str)
{
 //echo $question_str;
	$doc = new \DOMDocument();
	@$doc->loadHTML($question_str);
	$xpath = new \DOMXpath($doc);
	$articles = $xpath->query('//div[@class="question mb-3"]');
	
	//_d($articles); exit();
	 
	foreach($articles as $container) 
	{ 
	  
	  return innerHTML($container);
    }
  
}

function get_answers($question_str)// 
{
	$doc = new \DOMDocument();
	@$doc->loadHTML($question_str);
	$xpath = new \DOMXpath($doc);
	$articles = $xpath->query('//label[@class="custom-control-label choicetext"]');
	 $ans=array();
	 $k=1;
	foreach($articles as $container) 
	{ 
	  
	  $ans[$k]= innerHTML($container);
	  $k++;
    }
   return $ans;
}

?><?

if($os->get('WT_question_raw_dataListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andsubject=  $os->postAndQuery('subject_s','subject','%');
    $andchapter=  $os->postAndQuery('chapter_s','chapter','%');
    $andtopic=  $os->postAndQuery('topic_s','topic','%');
    $andquestion_data=  $os->postAndQuery('question_data_s','question_data','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( subject like '%$searchKey%' Or chapter like '%$searchKey%' Or topic like '%$searchKey%' Or question_data like '%$searchKey%' )";

    }

    $listingQuery="  select question_raw_data_id, subject,chapter,topic from question_raw_data where question_raw_data_id>0   $where   $andsubject  $andchapter  $andtopic  $andquestion_data     order by question_raw_data_id desc";
	
	
	$os->showPerPage= 1000;
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
	
	
	////  total question count 
	    $q_count=array();
		$total_q=" select question_raw_data_id , count(*) q_count  from question_bank where question_raw_data_id>0 group by question_raw_data_id ";
		$rsResults=$os->mq($total_q);
		while($record=$os->mfa( $rsResults))
		{
			$q_count[$record['question_raw_data_id']]=$record['q_count'];
		}
	
         $q_count_total=array();
		$alltotal_q=" select count(*) q_count_total  from question_bank where question_raw_data_id>0 ";
		$rsResults=$os->mq($alltotal_q);
		$all_q_count=$os->mfa( $rsResults);
		$all_q_count=$os->val($all_q_count,'q_count_total');
		 
		 
    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?> </b> Records &nbsp;&nbsp; <? echo $resource['links']; ?>  &nbsp;&nbsp;
		 Total Question : <b><? echo $all_q_count ?> </b> </div>

        <table class="noBorder"  >
            <tr class="borderTitle" >

                <td >#</td>
                <td >Action </td>
				<td > Question </td>
                <td ><b>Subject</b></td>
                <td ><b>Chapter</b></td>
                <td ><b>Topic</b></td>
            </tr>



            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;




                ?>
                <tr class="trListing">
                    <td><?php echo $serial; ?>     </td>
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_question_raw_dataGetById('<? echo $record['question_raw_data_id'];?>')" >Edit</a></span>  <? } ?>   <input type="button" value="Import" onclick="import_question('<? echo $record['question_raw_data_id'];?>');" />  </td>
                     <td>
					 
					 <span id="import_question_rsult_div_<? echo $record['question_raw_data_id'];?>"><?php echo $os->val($q_count,$record['question_raw_data_id']);?>  </span>
					  </td>
                    <td><?php echo $record['subject']?> </td>
                    <td><?php echo $record['chapter']?> </td>
                    <td><?php echo $record['topic']?> </td>


                </tr>
                <?


            } ?>





        </table>



    </div>

    <br />



    <?php
    exit();

}






if($os->get('WT_question_raw_dataEditAndSave')=='OK')
{
    $question_raw_data_id=$os->post('question_raw_data_id');



    $dataToSave['subject']=addslashes($os->post('subject'));
    $dataToSave['chapter']=addslashes($os->post('chapter'));
    $dataToSave['topic']=addslashes($os->post('topic'));
    $dataToSave['question_data']=addslashes($os->post('question_data'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($question_raw_data_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('question_raw_data',$dataToSave,'question_raw_data_id',$question_raw_data_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($question_raw_data_id>0 ){ $mgs= " Data updated Successfully";}
        if($question_raw_data_id<1 ){ $mgs= " Data Added Successfully"; $question_raw_data_id=  $qResult;}

        $mgs=$question_raw_data_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_question_raw_dataGetById')=='OK')
{
    $question_raw_data_id=$os->post('question_raw_data_id');

    if($question_raw_data_id>0)
    {
        $wheres=" where question_raw_data_id='$question_raw_data_id'";
    }
    $dataQuery=" select * from question_raw_data  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['subject']=$record['subject'];
    $record['chapter']=$record['chapter'];
    $record['topic']=$record['topic'];
    $record['question_data']=$record['question_data'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_question_raw_dataDeleteRowById')=='OK')
{

    $question_raw_data_id=$os->post('question_raw_data_id');
    if($question_raw_data_id>0){
        $updateQuery="delete from question_raw_data where question_raw_data_id='$question_raw_data_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

if($os->get('import_question')=='OK' &&  $os->post('import_question')=='OK')
{
     $classId=17;
     $question_raw_data_id =$os->post('question_raw_data_id');
	 
	 if($question_raw_data_id<1)
	 {
	   echo 'No record to import.'; exit ;
	 }
	   
	   // $os->mq('TRUNCATE TABLE question_bank'); 1226
	   
	    $del_query="delete from question_bank where  question_raw_data_id='$question_raw_data_id' ";
		$os->mq( $del_query);
	   
	  
        $inserted_row=0;
        $updateQuery="select * from question_raw_data where question_raw_data_id > 0 and question_raw_data_id='$question_raw_data_id' ";
        $data_rs=$os->mq($updateQuery);
		 while($data_row=$os->mfa($data_rs))
		{
			
			$raw_subject=trim($data_row['subject']);
			$raw_chapter=trim($data_row['chapter']);
			$raw_topic=trim($data_row['topic']);
			
			$subjectId='';
			if(in_array( $raw_subject , array('BIOLOGY','Biology','biology') ))
			{$subjectId='220';}
			if(in_array( $raw_subject , array('CHEMISTRY','Chemistry','chemistry') ))
			{$subjectId='219';}
			if(in_array( $raw_subject , array('PHYSICS','Physics','physics') ))
			{$subjectId='218';}
			
			
			
			  $duplicate_chapter="select * from question_chapter where class_id!=''  and class_id='$classId'  and  subject_code='$raw_subject' and title='$raw_chapter' ";
			$question_chapter_id=$os->isRecordExist($duplicate_chapter,'question_chapter_id');
			if($question_chapter_id<1) // if  not exist add new one
			{
				$dataToSave=array();		
				$dataToSave['class_id']=$classId;
				$dataToSave['title']=$raw_chapter;
				$dataToSave['subject_code']=$raw_subject;
				$dataToSave['addedDate']=$os->now();
				$dataToSave['addedBy']=$os->userDetails['adminId'];
				 
				$question_chapter_id=$qResult=$os->save('question_chapter',$dataToSave,'question_chapter_id','');
				 
			
			} 
			
			if($question_chapter_id>0)
			{
			
			   	$duplicate_topic="select * from question_topic where    question_chapter_id='$question_chapter_id' and title='$raw_topic' ";
				$question_topic_id=$os->isRecordExist($duplicate_topic,'question_topic_id');
				if($question_topic_id<1) // if  not exist add new one
				{
					$dataToSave=array();		
					$dataToSave['question_chapter_id']=$question_chapter_id;
					$dataToSave['title']=$raw_topic;					 
					$dataToSave['addedDate']=$os->now();
					$dataToSave['addedBy']=$os->userDetails['adminId'];
					$dataToSave['active_status']='Active';
					$question_topic_id=$qResult=$os->save('question_topic',$dataToSave,'question_topic_id','');
					 
				
				} 
			
			
			
			} 
			 
			 
			
			$data_a_s=explode('</pdg-question>',$data_row['question_data']);

 		    foreach($data_a_s  as $data_a) 
			{
			  
			 $level=2; 
			  
			 $q_str= strstr($data_a,'<pdg-question ');
			 $question= get_question($q_str);
			 $ans= get_answers($q_str);
				 
			 
			
			$question_base='Informative';	
			$dataToSave=array();		
			$dataToSave['subjectId']=$subjectId;
			$dataToSave['classId']=$classId;
			$dataToSave['questionText']=$question;       
			$dataToSave['answerText1']=addslashes($ans[1]);
			$dataToSave['answerText2']=addslashes($ans[2]);     
			$dataToSave['answerText3']=addslashes($ans[3]);
			$dataToSave['answerText4']=addslashes($ans[4]);
			$dataToSave['correctAnswer']='';  ###############################
			$dataToSave['marks']='1' ;   ###############################
			$dataToSave['negetive_marks']='0.5' ;   ###############################
			$dataToSave['viewOrder']='' ;   ###############################
			$dataToSave['type']='MCQ';
			$dataToSave['question_chapter_id']=$question_chapter_id;
			$dataToSave['question_topic_id']=$question_topic_id;
			$dataToSave['level']=$level;
			$dataToSave['question_base']=$question_base;
			$dataToSave['addedDate']=$os->now();
			$dataToSave['addedBy']=$os->userDetails['adminId'];
			$dataToSave['question_raw_data_id']=$question_raw_data_id;
			
			if(trim($question)!='' && $question_chapter_id !='' && $question_topic_id !=''  ){
			$qResult=$os->save('question_bank',$dataToSave,'questionId','');///    allowed char '\*#@/"~$^.,()|+_-=:��
			 $inserted_row++; 
            }
				 
				 
				  
			}

			 
			 
			
			
		   
		
		}
		
		echo  $inserted_row;
        
    exit(); 
}




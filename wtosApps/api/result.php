<?php
header('Content-Type: application/json');
include('../../wtosConfig.php'); // load configuration
include('../os.php'); // load wtos Library
global $site, $os;
/****
 * Functions
 */
function get_grade_settings($session_classes){
    global $os;
    $keys = [];
    foreach ($session_classes as $session => $classes){
        foreach ($classes as $class){
            $keys[] = $os->get_board_by_class($class)."_".$session;
        }
    }
    $keys = "'".implode("','",$keys)."'";
    $grades_q = $os->mq("SELECT 
            from_percent as min, 
            to_percent as max,
            grade, asession, board
        FROM grade_setting  WHERE CONCAT(board,'_',asession) IN($keys)");
    $grades=[];
    while ($grade = $os->mfa($grades_q)){
        $grades[$grade["asession"]][$grade["board"]][] = $grade;
    }
    return $grades;

}
function get_electives(){
    global $os;
    $sId = $os->loggedUser()["studentId"];
    $query = $os->mq("SELECT class, elective_subject_ids FROM history WHERE studentId='$sId'");
    $subjects = [];
    while ($sub = $os->mfa($query)){
        $subjects[$sub["class"]] = explode(",", $sub["elective_subject_ids"]);
    }
    return $subjects;
}
function get_all_subjects($session_classes = []){
    global $os;
    $keys = [];
    foreach ($session_classes as $session => $classes){
        foreach ($classes as $class){
            $keys[] = $session."_".$class;
        }
    }
    $keys = "'".implode("','",$keys)."'";
    $subs = $os->mq("SELECT sub.* FROM subject sub WHERE CONCAT(sub.asession,'_',sub.classId) IN($keys)");

    $subjects = [];
    $electives = get_electives();
    while ($sub = $os->mfa($subs)){
        $elective = isset($electives[$sub['classId']])?$electives[$sub['classId']]:[];
        if($sub['Elective']==1){
            if(in_array($sub['subjectId'],$elective)){
                $subjects[$sub['classId']][] = $sub['subjectId'];
            }
        } else {
            $subjects[$sub['classId']][] = $sub['subjectId'];
        }
    }
    return $subjects;
}

function get_exam_rank($student_id, $examIds=[], $branch = ''){
    global $os;
    if(is_array($examIds)){
        $examIds = implode(",", $examIds);
    }
    $subjects=[];
    $examQuery = $os->mq("SELECT 
                ed.*,
                su.Elective as elective
            FROM examdetails ed 
            INNER JOIN subject su ON(su.subjectId= ed.subjectId)
            WHERE ed.examId IN($examIds)");

    while($exam = $os->mfa($examQuery)){
        $subjects[$exam['examId']][$exam['subjectId']] = $exam;
    }
    //result details
    $resultsQ = $os->mq("SELECT 
                rd.historyId,
                h.studentId,
                rd.examId,
                rd.subjectId,
                h.asession,
                rd.writtenMarks ,
                rd.viva ,
                h.elective_subject_ids,
                s.name,
                s.branch

            FROM resultsdetails rd 
            INNER JOIN history h on rd.historyId = h.historyId
            INNER JOIN student s ON(h.studentId=s.studentId)
            WHERE rd.examId IN($examIds) AND rd.historyId>0");

    $h_subjects = [];
    $results = [];
    while ($rd = $os->mfa($resultsQ)){


        //get subjects
        if(!isset($h_subjects[$rd['examId']][$rd['historyId']])){
            $els_subjects = explode(",",$rd['elective_subject_ids']);
            $h_subjects[$rd['examId']][$rd['historyId']] =
                $os->get_subjects_with_elective($subjects[$rd['examId']], $els_subjects);
            foreach ($subjects[$rd['examId']] as $sub){
                if(in_array($sub['subjectId'], $h_subjects[$rd['examId']][$rd['historyId']])){
                    //totalmarks
                    if(isset($results[$rd['examId']][$rd['historyId']]['total'])){
                        $results[$rd['examId']][$rd['historyId']]['total'] += ($sub['written']+$sub['viva']);
                    } else{
                        $results[$rd['examId']][$rd['historyId']]['total'] = ($sub['written']+$sub['viva']);
                    }
                }
            }
        }


        $results[$rd['examId']][$rd['historyId']]['studentId'] =  $rd['studentId'];
        $results[$rd['examId']][$rd['historyId']]['name'] = $rd['name'];
        $results[$rd['examId']][$rd['historyId']]['branch'] =  $rd['branch'];

        if(in_array($rd['subjectId'], $h_subjects[$rd['examId']][$rd['historyId']])) {

            //overall
            if (isset($results[$rd['examId']][$rd['historyId']]['obtain'])) {
                $results[$rd['examId']][$rd['historyId']]['obtain'] += ($rd['writtenMarks'] + $rd['viva']);
            } else {
                $results[$rd['examId']][$rd['historyId']]['obtain'] = ($rd['writtenMarks'] + $rd['viva']);
            }

            $results[$rd['examId']][$rd['historyId']]['percentage'] =
                ($results[$rd['examId']][$rd['historyId']]['obtain'] / $results[$rd['examId']][$rd['historyId']]['total']) * 100;


        }
    }
    ///
    $counter = [];
    $b_counter=[];
    $rank = [];
    $branch_rank = [];
    $branch_results = [];
    foreach ($results as $eid=>$rrr){
        usort($results[$eid], function ($item1, $item2) {
            return $item2['name'] <=> $item1['name'];
        });
        usort($results[$eid], function ($item1, $item2) {
            return $item2['percentage'] <=> $item1['percentage'];
        });
        //
        foreach ($results[$eid] as $row){

            $counter[$eid] = !isset($counter[$eid])?1:$counter[$eid]+1;
            $b_counter[$eid][$row['branch']] = !isset($b_counter[$eid][$row['branch']])?1:$b_counter[$eid][$row['branch']]+1;
            if($row['studentId']==$student_id){
                $rank[$eid] = $counter[$eid];
                $branch_rank[$eid]= $b_counter[$eid][$row['branch']];
            }

            $branch_results[$eid][$row['branch']][] = $row;
        }
    }

    //history

    $res = [];
    $res['ranks']['overall'] = $rank;
    $res['ranks']['branch']  = $branch_rank;
    $res['details']['overall'] = $results;
    $res['details']['branch']  = $branch_results;


    return $res;
}
function get_exam_max($examIds=[], $branch=''){
    global $os;
    if(is_array($examIds)){
        $examIds = implode(",", $examIds);
    }
    $query = $os->mq("SELECT
          
            rd.examId,
            ed.subjectId,
            MAX(IF(rd.writtenMarks>0,rd.writtenMarks,0)+IF(rd.viva>0,rd.viva,0)) as highest
            FROM resultsdetails rd 
            INNER JOIN examdetails ed ON ed.examdetailsId=rd.examdetailsId
            WHERE rd.examId IN($examIds)
            GROUP BY rd.examId, ed.subjectId");
    $result = [];
    while ($res = $os->mfa($query)){
        $result[$res['examId']][$res['subjectId']] = $res['highest'];
    }
    return $result;
}
/*****
 * Result listing
 */
if($os->get("listing")=="OK"){

    $studentId=$os->post("studentId");
    /*****
     * results details
     */
    $exams = [];
    $exam_ids  = [];
    $session_classes = [];
    $rds_query = $os->mq("SELECT 
            e.examTitle,e.class, e.asession, e.examId      
        FROM resultsdetails rd 
        INNER JOIN history h ON (h.historyId=rd.historyId AND h.studentId='$studentId')
        INNER JOIN exam e ON (rd.examId=e.examId AND e.publish_result='Yes')
        ORDER BY rd.examdetailsId DESC
        ");
    while($rd = $os->mfa($rds_query)){
        $exams[$rd['asession']][$rd['class']][] = $rd;
    }
    print json_encode($exams);
}

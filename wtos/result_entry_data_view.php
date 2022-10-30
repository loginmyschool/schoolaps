<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/


include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');



$pluginName='';
$listHeader='Result Entry ';
$ajaxFilePath= 'result_entry_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

///
/// ACCESS SETTINGS
$logged_teacherId = $os->loggedUser()['adminId'];
$exam_accesses = [];
$class_access = [];

$access_query  = $os->mq("SELECT 
       ra.examdetailsId, 
       e.examTitle,
       ed.examId, 
       sub.subjectName,
       ra.for_class as class, 
       ra.asession, 
       ra.section, 
       ra.gender  
    FROM resultentry_access ra
        INNER JOIN examdetails ed ON ed.examdetailsId = ra.examdetailsId
        INNER JOIN exam e ON e.examId=ed.examId
        INNER JOIN subject sub ON ed.subjectId=sub.subjectId 
    WHERE ra.teacherId='$logged_teacherId' GROUP BY ra.resultentry_access_id");

$search_details = [];
while($exam_access = $os->mfa($access_query)){
    $search_details[] = $exam_access;
}

///
///
$branchCode = $os->getSession($key1='selected_branch_code');
?>
<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>

    </div>

</div>
<div class="content">
    <div class="item p-m">

        <div>

            <div id="search_div" class="uk-grid uk-grid-small" uk-grid>


            </div>

            <script type="text/babel" >
                const search_details = JSON.parse('<?= json_encode($search_details)?>');
                const class_list = JSON.parse('<?= json_encode($os->classList)?>') ;

                const SearchWidget = () =>{
                    const [selected_session, setSelectedSession] = React.useState("");
                    const [selected_class, setSelectedClass] = React.useState("");
                    const [selected_exam, setSelectedExam] = React.useState("");
                    const [selected_examdetails, setSelectedExamDetails] = React.useState("");
                    const [selected_section, setSelectedSection] = React.useState("");
                    const [selected_gender, setSelectedGender] = React.useState("");

                    return(
                        <>
                            <div>
                                <select  className="uk-select uk-border-rounded congested-form"
                                         name="asession_s" id="asession_s"
                                         value={selected_session}
                                         onChange={(e)=>{
                                             setSelectedSession(e.target.value);
                                         }}>
                                    <option value="">--SELECT SESSION--</option>
                                    {

                                        [...new Set(search_details.map(ob=>ob.asession))].sort().map((session)=>{
                                            return (
                                                <option key={session} value={session}>{session}</option>
                                            )
                                        })
                                    }

                                </select>
                            </div>

                            <div>
                                <select  className="uk-select uk-border-rounded congested-form"
                                         name="class_s"
                                         id="class_s"
                                         value={selected_class}
                                         onChange={(e)=>{
                                            setSelectedClass(e.target.value);
                                         }}>
                                    <option value="">--SELECT CLASS--</option>

                                    {

                                        [...new Set(search_details.filter(ob=>ob.asession===selected_session).map(ob=>ob.class))].sort().map(cls=>
                                            <option key={cls} value={cls}>{class_list[cls]}</option>
                                        )
                                    }
                                </select>
                            </div>

                            <div>
                                <select className="uk-select uk-border-rounded congested-form"
                                        name="exam_s"
                                        id="exam_s"
                                        onChange={(e)=>{
                                            setSelectedExam(e.target.value);
                                        }}>
                                    <option value="">--SELECT EXAM--</option>
                                    {

                                        [...new Set(search_details.filter(ob=>ob.asession===selected_session && ob.class===selected_class).map(ob=>ob.examId))].sort().map((examId)=>{
                                            let exam = search_details.find(ob=>ob.examId===examId);
                                            return (
                                                <option key={examId} value={examId}>{exam.examTitle}</option>
                                            )
                                        })
                                    }
                                </select>
                            </div>

                            <div>
                                <select className="uk-select uk-border-rounded congested-form"
                                        name="subject_s" id="subject_s"
                                        value={selected_examdetails}
                                        onChange={(e)=>{
                                            setSelectedExamDetails(e.target.value)
                                        }}>
                                    <option value="">--SELECT SUBJECT--</option>
                                    {

                                        [...new Set(search_details.filter(ob=>ob.examId === selected_exam).map(ob=>ob.examdetailsId))].sort().map((edId)=>{
                                            let exam_details = search_details.find(ob=>ob.examdetailsId===edId);
                                            return (
                                                <option key={edId} value={edId}>{exam_details.subjectName}</option>
                                            )
                                        })

                                    }
                                </select>
                            </div>

                            <div>
                                <select className="uk-select uk-border-rounded congested-form"
                                        name="subject_s" id="section_s"
                                        style={{width:60}}
                                        value={selected_section}
                                        onChange={(e)=>{
                                            setSelectedSection(e.target.value);
                                        }}>
                                    <option value="">--SELECT SECTION--</option>
                                    {
                                        [...new Set(search_details.filter(ob=>ob.examdetailsId === selected_examdetails).map(ob=>ob.section))].sort().map((section)=>{
                                            return (
                                                <option key={section} value={section}>{section}</option>
                                            )
                                        })
                                    }
                                </select>
                            </div>

                            <div>
                                <select className="uk-select uk-border-rounded congested-form "
                                        style={{width:100}}
                                        name="gender_s" id="gender_s" >
                                    <option value="">--SELECT GENDER--</option>
                                    {
                                        [...new Set(search_details.filter(ob=>ob.examdetailsId === selected_examdetails).map(ob=>ob.gender))].sort().map((gender)=>{
                                            return (
                                                <option key={gender} value={gender}>{gender}</option>
                                            )
                                        })
                                    }
                                </select>
                            </div>

                            <div>
                                <select className="uk-select uk-border-rounded congested-form"
                                        name="order_by_s" id="order_by_s">

                                    <option value="h.roll_no ASC">Roll No ASC</option>
                                    <option value="h.roll_no DESC">Roll No DESC</option>

                                    <option value="h.registrationNo ASC">Registration No ASC</option>
                                    <option value="h.registrationNo DESC">Registration No DESC</option>

                                    <option value="s.name ASC">Name ASC</option>
                                    <option value="s.name DESC">Name DESC</option>

                                </select>
                            </div>

                            <div>
                                <button type="button"
                                        value="Search"
                                        onClick={()=>{
                                            WT_result_entry_listing();
                                        }}
                                        className="uk-button congested-form uk-secondary-button uk-border-rounded">Search</button>
                            </div>
                        </>
                    )
                }

                const domContainer = document.querySelector('#search_div');
                ReactDOM.render(React.createElement(SearchWidget), domContainer);
            </script>
            <table class="display-none">
                <tr>
                    <td>Roll</td>
                    <td>Written</td>
                    <td>Oral</td>
                    <td>Practical</td>
                    <td>Total</td>
                    <td>Grade</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="roll_no" id="roll_no" value="" class="avglengthtext" onchange="student_by_roll('')" />
                    </td>
                    <td><input type="text" name="writtenMarks" id="writtenMarks" value=""  class="avglengthtext"/></td>
                    <td><input type="text" name="viva" id="viva" value="" class="avglengthtext" /></td>
                    <td><input type="text" name="practical" id="practical" value="" class="avglengthtext" /></td>
                    <td><input type="text" name="totalMarks" id="totalMarks" value="" class="avglengthtext" /></td>
                    <td><input type="text" name="grade" id="grade" value="" class="avglengthtext" /> </td>
                </tr>
                <tr><td><input type="button" onclick="prevStudent();" value="<<"   ></td>
                    <td colspan="4">
                        <input type="text" name="studentId" id="studentId" value="" style="border:0px; background:none; font-size:16px; color:#0000CC;"/>
                        <input type="text" value="" name="studentName" id="studentName" style="border:0px; background:none; font-size:16px; color:#0000CC;"/>
                    </td>
                    <td><input type="button" onclick="nextStudent();" value=">>"  > </td>
                </tr>
                <tr>
                    <td colspan="6" align="center"><input name="button" type="button" onclick="manage_exam_setting('save')" value="SAVE"/> </td>
                </tr>
            </table>
        </div>


        <div id="WT_result_entry_div" class="uk-margin-small"></div>

    </div>
</div>


<script>
    function WT_result_entry_listing() // list table searched data get
    {
        var formdata = new FormData();
        var asession_s= os.getVal('asession_s');
        var class_s= os.getVal('class_s');
        var exam_s= os.getVal('exam_s');
        var examdetails_s= os.getVal('subject_s');
        var section_s= os.getVal('section_s');
        var gender_s= os.getVal('gender_s');
        var order_by_s= os.getVal('order_by_s');


        if(class_s===''){ alert('Please Select Class '); return false;}
        if(exam_s===''){ alert('Please Select Exam '); return false;}
        if(examdetails_s===''){ alert('Please Select Subject '); return false;}


        formdata.append('asession_s',asession_s);
        formdata.append('class_s',class_s);
        formdata.append('exam_s',exam_s);
        formdata.append('examdetails_s',examdetails_s);
        formdata.append('section_s',section_s);
        formdata.append('gender_s',gender_s);
        formdata.append('order_by_s',order_by_s);
        formdata.append('WT_result_entry_listing','OK');

        let url='<? echo $ajaxFilePath ?>?WT_result_entry_listing=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_result_entry_div',url,formdata);
    }
    //resultDetailsListing();
    function  search_reset() // reset Search Fields
    {
        location.reload();
        resultDetailsListing();
        setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');
    }
    //option fetch functions
    function get_exam_by_class(){
        let url='<? echo $ajaxFilePath ?>?get_exam_by_class=OK&';
        let formdata = new FormData();
        let class_s = os.getVal('class_s');
        let asession_s = os.getVal('asession_s');
        formdata.append('class_s',class_s);
        formdata.append('asession_s',asession_s);
        formdata.append('get_exam_by_class','OK' );


        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('exam_s',url,formdata);
    }
    function get_subjects_by_exam(){
        let url='<? echo $ajaxFilePath ?>?get_subjects_by_exam=OK&';
        let formdata = new FormData();
        let exam_s = os.getVal('exam_s');
        formdata.append('exam_s',exam_s);
        formdata.append('get_subjects_by_exam','OK' );


        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('subject_s',url,formdata);
    }
    //
    window.selected_viva_field = null;
    function edit_viva_mark(examdetailsId, historyId){
        var formdata = new FormData();

        formdata.append('examdetailsId',examdetailsId);
        formdata.append('historyId',historyId);
        formdata.append('edit_viva_details','OK' );


        var url='<? echo $ajaxFilePath ?>?edit_viva_details=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait while loading...';
        os.setAjaxFunc('edit_viva_mark_res',url,formdata);
    }
    function edit_viva_mark_res(data){
        UIkit.modal.dialog(data);
        $('#sub_exam_viva_marks_form').submit(e=>{
            e.preventDefault();
            console.log(e);
            let OK = true;
            console.log(this);
            document.querySelectorAll("#sub_exam_viva_marks_form input[type=number]").forEach(e=>{
                console.log("value", e.value);
                console.log("max", e.getAttribute("max"));
                if(e.value>parseInt(e.getAttribute('max'))){
                    OK = false;
                }
            })
            if(OK){
                save_viva_marks();
            }
        })
    }
    function save_viva_marks(){
        let url='<? echo $ajaxFilePath ?>?save_exam_marks_details=OK&';
        $.ajax({
            type : 'POST',
            url : url,
            data : $('#sub_exam_viva_marks_form').serialize()+"&save_exam_marks_details=OK",
        });
    }
    //
    function calculate_marks(child, parent, trigger_parent=true){

        let parent_input = document.querySelector(parent);
        let child_inputs = document.querySelectorAll(child);
        let total_marks = 0;
        child_inputs.forEach(child=>{
            let v = parseInt(child.value)?parseInt(child.value):0;
            //child.value = parseInt(child.value)?parseInt(child.value):0;
            total_marks+=parseInt(v);
        });

        parent_input.value = total_marks;
        ////////////////////////////////
        if(trigger_parent) {
            $(parent_input).trigger("change");
        }
    }
    //
    function save_marks(c_el, type){
        let _el = $(c_el);
        let _tr = _el.closest('tr');
        let _rdid = _tr.attr('rdid');
        let _edid = _tr.attr('edid');
        let _sid = _tr.attr('sid');
        let _hid = _tr.attr('hid');
        let _type = type;
        let _marks = _el.val();

        if(parseInt(_marks)>parseInt(_el.attr('max'))){
            alert('Please enter below or equals to '+_el.attr('max'));
            return;
        }

        let _fd = new FormData();
        _fd.append('rdid',_rdid);
        _fd.append('edid',_edid);
        _fd.append('sid',_sid);
        _fd.append('hid',_hid);
        _fd.append('type',_type);
        _fd.append('marks',_marks);
        _fd.append('save_marks','OK');

        let _url='<? echo $ajaxFilePath ?>?save_marks=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait while loading...';
        os.setAjaxFunc('console.log',_url,_fd);
    }
</script>
<? include($site['root-wtos'].'bottom.php'); ?>

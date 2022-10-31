<?
include('wtosConfigLocal.php');
include($site['root-wtos'] . 'wtosCommon.php');
$pluginName = '';
$sessions = $os->mq("SELECT * FROM accademicsession")->fetchAll(\PDO::FETCH_ASSOC);

if ($os->get("fetch_students") == "OK" && $os->post("fetch_students")) {
    $admission_exam_id = $os->post("admission_exam_id");
    $admission_exam_detail_id = $os->post("admission_exam_detail_id");

    $admission_exam = $os->mfa($os->mq("SELECT * FROM admission_exam WHERE admission_exam_id='" . $admission_exam_id . "'"));
    $admission_exam_detail = $os->mfa($os->mq("SELECT * FROM admission_exam_detail WHERE admission_exam_detail_id='" . $admission_exam_detail_id . "'"));

    $students = $os->mq("SELECT ff.name, ff.formfillup_id, aerd.marks_obtain  FROM formfillup ff " .
        "LEFT JOIN admission_exam_result aer ON  aer.formfillup_id = ff.formfillup_id " .
        "LEFT JOIN admission_exam_result_detail aerd ON  aerd.admission_exam_result_id=aer.admission_exam_result_id " .
        "WHERE ff.academic_year=' " . $admission_exam["session"] . "' AND ff.class_id='" . $admission_exam["class"] . "'");
?>

    <table class="uk-table uk-table-divider congested-table uk-table-striped">
        <tr>
            <td>Name</td>
            <td width="1%">Marks</td>
        </tr>
        <?php
        while ($student = $os->mfa($students)) {
        ?>
            <tr>
                <td>
                    <?= $student["name"] ?>
                </td>
                <td>
                    <input class="congested-form" type="number" max="<?= $admission_exam_detail["marks"]?>" onchange="saveMarks(event, <?= $student["formfillup_id"] ?>, event.target.value)" value="<?= $student["marks_obtain"] ?>" />
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

<?php
    exit();
}

if ($os->get("save_marks") == "OK" && $os->post("save_marks")) {
    $admission_exam_id = $os->post("admission_exam_id");
    $admission_exam_detail_id = $os->post("admission_exam_detail_id");
    $formfillup_id = $os->post("formfillup_id");
    $marks_obtain = $os->post("marks_obtain");


    $admission_exam_result_detail = $os->mfa($os->mq("SELECT * FROM admission_exam_result_detail WHERE admission_exam_detail_id='" . $admission_exam_detail_id . "' AND formfillup_id='" . $formfillup_id . "'"));
    if (!$admission_exam_result_detail) {
        $dataToSave = [
            "admission_exam_detail_id" => $admission_exam_detail_id,
            "formfillup_id" => $formfillup_id,
            "marks_obtain" => $marks_obtain
        ];
        $os->save("admission_exam_result_detail", $dataToSave);
    } else {
        $dataToSave =
            "marks_obtain=" . "'" . $marks_obtain . "'";
        $os->mq("UPDATE admission_exam_result_detail SET $dataToSave WHERE admission_exam_detail_id='" . $admission_exam_detail_id . "' AND formfillup_id='" . $formfillup_id . "'");
    }

    $admission_exam_result = $os->mfa($os->mq("SELECT * FROM admission_exam_result aes WHERE aes.formfillup_id='$formfillup_id'"));
    $admission_exam_result_details = $os->mfa($os->mq("SELECT SUM(aesd.marks_obtain) as total_marks_obtain  FROM admission_exam_result_detail aesd  WHERE aesd.formfillup_id='$formfillup_id' GROUP BY(aesd.formfillup_id) "));

    if (!$admission_exam_result) {
        $dataToSave = [
            "admission_exam_id" => $admission_exam_id,
            "formfillup_id" => $formfillup_id,
            "total_marks_obtain" => $admission_exam_result_details["total_marks_obtain"]
        ];
        $admission_exam_result_id = $os->save("admission_exam_result", $dataToSave);
    } else {
        $admission_exam_result_id = $admission_exam_result["admission_exam_result_id"];
        $dataToSave =
            "total_marks_obtain=" . "'" . $admission_exam_result_details["total_marks_obtain"] . "'";
        $os->mq("UPDATE admission_exam_result SET $dataToSave WHERE formfillup_id='" . $formfillup_id . "'");
    }
    $os->mq("UPDATE admission_exam_result_detail SET admission_exam_result_Id='$admission_exam_result_id' WHERE formfillup_id='" . $formfillup_id . "'");
}
?>
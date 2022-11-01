<?php
include "_partials/wt_header.php";
include "_partials/wt_precontent.php";
global $os, $site, $session_selected, $bridge, $pageVar;
?>

<? include "_partials/wt_postcontent.php"; ?>
<?

?>
<div class="uk-container uk-margin uk-container-small">
    <form method="post" class="uk-grid-small" uk-grid>
    <div>
            <input class="uk-input uk-form-small" placeholder="Form Number" name="form_no" value="<?= $os->post('form_no'); ?>" />
        </div>
        <div>
            <input class="uk-input uk-form-small" placeholder="Father Mobile" name="father_mobile" value="<?= $os->post('father_mobile'); ?>" />
        </div>
        <div>
            <input class="uk-input uk-form-small" type="date" placeholder="Date of birth" name="dob" value="<?= $os->post("dob") ?>" />
        </div>
        <div>
            <button class="uk-button uk-button-small uk-button-primary" type="submit">Search</button>
        </div>
    </form>
    <div style="min-height: 200px" class="uk-margin">
        <? if ($os->post("form_no") != "") {
            $form_no = $os->post("form_no");
            $father_mobile = $os->post("father_mobile");
            $dob = $os->post("dob");
            $sql = <<<EOT
                SELECT * FROM admission_exam_result aed
                INNER JOIN admission_exam ae ON ae.admission_exam_id=aed.admission_exam_id
                INNER JOIN formfillup ff ON ff.formfillup_id= aed.formfillup_id AND (ff.form_no='$form_no' OR ff.father_mobile='$father_mobile') AND DATE(ff.dob)='$dob'
                EOT;
            $exam_result = $os->mfa($os->mq($sql));
            if ($exam_result) {
                $exam_result_details = $os->mq("SELECT * FROM admission_exam_result_detail aerd INNER JOIN admission_exam_detail aed ON aed.admission_exam_detail_id=aerd.admission_exam_detail_id WHERE aerd.admission_exam_result_id='" . $exam_result["admission_exam_result_id"] . "'");


        ?>
                <table class="uk-width-1-1 uk-margin uk-table-striped">
                    <tr>
                        <th>Description</th>
                        <td> <?= $exam_result["description"]; ?></td>
                    </tr>
                    <tr>
                        <th>Session</th>
                        <td> <?= $exam_result["session"]; ?></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <td> <?= $os->classList[$exam_result["class"]]; ?></td>
                    </tr>

                    <tr>
                        <th>Total Marks</th>
                        <td> <?= $exam_result["total_marks"]; ?></td>
                    </tr>
                    <tr>
                        <th>Total Obtain</th>
                        <td> <?= $exam_result["total_marks_obtain"]; ?></td>
                    </tr>
                    <tr>
                        <th>FM</th>
                        <td> <?= $exam_result["total_marks"]; ?></td>
                    </tr>

                    <tr>
                        <th>Position</th>
                        <td> <?= $exam_result["position"]; ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?
                            if ($exam_result["total_marks_obtain"] >= $exam_result["cutoff_marks"] && $exam_result["position"] <= $exam_result["available_slots"]) {
                                echo "Passed";
                            } else {
                                echo "Failed";
                            }
                            ?>
                        </td>
                    </tr>
                </table>

                <table class="uk-width-1-1 uk-margin uk-table-striped">
                    <tr>
                        <th>Subject</th>
                        <th>Obtain</th>
                        <th>FM</th>
                    </tr>
                    <? while ($exam_result_detail = $os->mfa($exam_result_details)) { ?>
                        <tr>
                            <td><?= $exam_result_detail["subject_name"] ?></td>
                            <td width="1%"><?= $exam_result_detail["marks_obtain"] ?></td>
                            <td width="1%"><?= $exam_result_detail["marks"] ?></td>
                        </tr>
                    <? } ?>
                </table>


            <?
            } else {
            ?>
                <p>Form not found.</p>
            <?
            }
        } else { ?>
            <p>Please enter details above.</p>

        <? } ?>
    </div>
</div>

<style>
    table {
        border-collapse: 'collapse';
    }

    table td,
    table th {
        border: 1px solid #e5e5e5;
        padding: 4px 5px;
    }
</style>
<? include "_partials/wt_footer.php"; ?>
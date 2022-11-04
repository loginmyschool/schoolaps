<?
include('wtosConfigLocal.php');
include($site['root-wtos'] . 'wtosCommon.php');
$pluginName = '';
$sessions = $os->mq("SELECT * FROM accademicsession")->fetchAll(\PDO::FETCH_ASSOC);

if ($os->get('wt_admission_exams_list') == 'OK' && $os->post("wt_admission_exams_list") === "OK") {
    $exams_sql = "SELECT * FROM admission_exam";
    $exams_result = $os->mq($exams_sql);
?>

    <table class="uk-table uk-table-small uk-table-divider">

        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Session</th>
                <th>Class</th>
                <th>Total Marks</th>
                <th>Cutoff Marks</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($exam = $os->mfa($exams_result)) { ?>
                <tr>
                    <td>
                        <a onclick="openForm('<?= $exam["admission_exam_id"] ?>')"><?= $exam["admission_exam_id"] ?></a>
                    </td>
                    <td><?= $exam["description"] ?></td>
                    <td><?= $exam["session"] ?></td>
                    <td><?= $os->classList[$exam["class"]] ?></td>
                    <td><?= $exam["total_marks"] ?></td>
                    <td><?= $exam["cutoff_marks"] ?></td>
                    <td><?= $exam["status"] ?></td>
                    <td><a onclick="generateRank('<?= $exam["admission_exam_id"] ?>')">Generate Ranks</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php
    exit();
}
?>

<?php
if ($os->get('wt_admission_exams_form') == 'OK' && $os->post("wt_admission_exams_form") === "OK") {
    $admission_exam_id = $os->post("admission_exam_id") ?? 0;
    $admission_exam = $os->mfa($os->mq("SELECT * FROM admission_exam WHERE admission_exam_id='$admission_exam_id'"));
    $admission_exam_details = $os->mq("SELECT * FROM admission_exam_detail WHERE admission_exam_id='$admission_exam_id' ORDER BY priority")->fetchAll(\PDO::FETCH_ASSOC);
?>
    <form onsubmit="event.preventDefault(); saveExam(event)">
        <input type="hidden" name="admission_exam_id" value="<?= $admission_exam_id ?>" />
        <div class="uk-margin-small">
            <label class="uk-form-label">Description</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea uk-form-small" required name="description" placeholder="Some text..."><?= $os->val($admission_exam, "description") ?></textarea>
            </div>
        </div>

        <div class="uk-grid uk-child-width-1-2" uk-grid>
            <div>
                <div>
                    <label class="uk-form-label">Session</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="session" required>
                            <option></option>
                            <?php foreach ($sessions as $session) { ?>
                                <option <?= $os->val($admission_exam, "session") == $session["idKey"] ? "selected" : "" ?>><?= $session["idKey"] ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <div>
                    <label class="uk-form-label">Class</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="class" required>
                            <option></option>
                            <?php foreach ($os->classList as $class => $className) { ?>
                                <option value="<?= $class; ?>" <?= $os->val($admission_exam, "class") == $class ? "selected" : "" ?>><?= $className ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="uk-width-1-3">
                <div>
                    <label class="uk-form-label">Total Marks</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="number" required name="total_marks" value="<?= $os->val($admission_exam, "total_marks") ?>" />
                    </div>
                </div>
            </div>

            <div class="uk-width-1-3">
                <div>
                    <label class="uk-form-label">Cutoff Marks</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="number" required name="cutoff_marks" value="<?= $os->val($admission_exam, "cutoff_marks") ?>" />
                    </div>
                </div>
            </div>

            <div class="uk-width-1-3">
                <div>
                    <label class="uk-form-label">Available Slots</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="number" required name="available_slots" value="<?= $os->val($admission_exam, "available_slots") ?>" />
                    </div>
                </div>
            </div>

            <div class="uk-width-1-3">
                <div>
                    <label class="uk-form-label">Status</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="status">
                            <option></option>
                            <option <?= $os->val($admission_exam, "status") == "ACTIVE" ? "selected" : "" ?>>ACTIVE</option>
                            <option <?= $os->val($admission_exam, "status") == "PUBLISHED" ? "selected" : "" ?>>PUBLISHED</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <label>Subjects</label>
            <table class="uk-table uk-table-small congested-table">
                <tr>
                    <td class="uk-padding-remove-left">Name</td>
                    <td class="uk-padding-remove-left">Priority</td>
                    <td class="uk-padding-remove-right">Marks</td>
                </tr>

                <?php for ($x = 0; $x < 15; $x++) {
                    $admission_exam_detail = $os->val($admission_exam_details, $x) ?? null;
                ?>
                    <tr>
                        <td class="uk-padding-remove-left">
                            <input class="uk-input uk-form-small" type="hidden" name="subjects[<?= $x ?>][admission_exam_detail_id]" value="<?= $os->val($admission_exam_detail, "admission_exam_detail_id") ?>" />
                            <input class="uk-input uk-form-small" type="text" name="subjects[<?= $x ?>][subject_name]" value="<?= $os->val($admission_exam_detail, "subject_name") ?>" />
                        </td>
                        <td class="uk-padding-remove-right" width="1%">
                            <input class="uk-input uk-form-small" type="number" name="subjects[<?= $x ?>][priority]" style="width: 100px" value="<?= $os->val($admission_exam_detail, "priority") ?>" />
                        </td>
                        <td class="uk-padding-remove-right" width="1%">
                            <input class="uk-input uk-form-small" type="number" name="subjects[<?= $x ?>][marks]" style="width: 100px" value="<?= $os->val($admission_exam_detail, "marks") ?>" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <button class="uk-button uk-button-small uk-button-primary" type="submit">Save</button>

    </form>
<?php
    exit();
}
?>

<?php
if ($os->get('wt_admission_exams_save') == 'OK' && $os->post("wt_admission_exams_save") === "OK") {

    $admission_exam_id = $os->post("admission_exam_id");
    $description = $os->post("description");
    $session = $os->post("session");
    $class = $os->post("class");
    $total_marks = $os->post("total_marks");
    $cutoff_marks = $os->post("cutoff_marks");
    $dataToSave = [
        //"admission_exam_id" => $os->post("admission_exam_id"),
        "description" => $os->post("description"),
        "session" => $os->post("session"),
        "class" => $os->post("class"),
        "total_marks" => $os->post("total_marks"),
        "cutoff_marks" => $os->post("cutoff_marks"),
        "available_slots" => $os->post("available_slots"),
        "status" => $os->post("status")
    ];

    $admission_exam_id = $os->save("admission_exam", $dataToSave, "admission_exam_id", $admission_exam_id);
    $subjects = $os->post("subjects");
    foreach ($subjects as $subject) {
        $admission_exam_detail_id = $os->val($subject, "admission_exam_detail_id");
        $subject_name = $os->val($subject, "subject_name");
        $marks = $os->val($subject, "marks");
        $priority = $os->val($subject, "priority");

        if ($subject_name == "" || $marks == "") {
            continue;
        }

        $dataToSave = [
            "subject_name" => $subject_name,
            "marks" => $marks,
            "admission_exam_id" => $admission_exam_id,
            "priority" => $priority,
        ];
        $admission_exam_detail_id = $os->save("admission_exam_detail", $dataToSave, "admission_exam_detail_id", $admission_exam_detail_id);
    }

    print "OK";
}

if ($os->get("generate_rank") == "OK" && $os->post("generate_rank") == "OK") {
    $admission_exam_id = $os->post("admission_exam_id");
    $admission_exam = $os->mfa($os->mq("SELECT * FROM admission_exam WHERE admission_exam_id='$admission_exam_id'"));
    $admission_exam_details = $os->mq("SELECT * FROM admission_exam_detail WHERE admission_exam_id='$admission_exam_id' ORDER BY priority")->fetchAll(\PDO::FETCH_ASSOC);
    $admission_exam_detail_ids = implode("','", array_map(function ($admission_exam_detail) {
        return $admission_exam_detail["admission_exam_detail_id"];
    }, $admission_exam_details));
    $sql = <<<EOT
        SELECT ff.name, ff.formfillup_id,aerd.admission_exam_result_id,  GROUP_CONCAT(JSON_OBJECT(
            'priority', aed.priority,
            'subject', aed.subject_name,
            'obtain_marks', aerd.marks_obtain
        )) as details, SUM(aerd.marks_obtain) as total_marks_obtain FROM admission_exam_result_detail aerd   
        INNER JOIN formfillup ff ON ff.formfillup_id=aerd.formfillup_id 
        INNER JOIN admission_exam_detail aed ON aerd.admission_exam_detail_id = aed.admission_exam_detail_id 
        WHERE aed.admission_exam_detail_id IN('$admission_exam_detail_ids')
        GROUP BY ff.formfillup_id 
        ORDER BY total_marks_obtain DESC 
EOT;
    $results = $os->mq($sql)->fetchAll(\PDO::FETCH_ASSOC);
    $results = array_map(function ($result) {
        $details = json_decode("[" . $result["details"] . "]");
        usort($details, function ($a, $b) {
            return $a->priority - $b->priority;
        });
        $result["details"] = $details;
        return $result;
    }, $results);

    usort($results, function ($ar, $br) {
        if ($ar["total_marks_obtain"] == $br["total_marks_obtain"]) {
            $ac = 0;
            $bc = 0;
            foreach ($ar["details"] as $i => $ard) {
                $brd = $ar["details"][$i];
                if ($ard->obtain_marks > $brd->obtain_marks) {
                    $ac++;
                } else {
                    $bc++;
                }
            }
            return $ac - $bc;
        }
        $ar["total_marks_obtain"] - $br["total_marks_obtain"];
    });
    foreach ($results as $index => $result) {

        try {
            $dataToSave = [
                "position" => $index + 1
            ];
            $os->save("admission_exam_result", $dataToSave, "admission_exam_result_id", $result["admission_exam_result_id"]);
        } catch (Exception $err) {
            print $os->query;
        }

        if ($admission_exam["cutoff_marks"] > $result["total_marks_obtain"] || $admission_exam["available_slots"] < $index + 1) {
            continue;
        }
        //save to forms
        try {
            $dataToSave = [
                "form_status" => "passed",
                "form_status_dated" => $os->now(),
                "form_status_by"=> $os->loggedUser()["adminId"]
            ];
            $os->save("formfillup", $dataToSave, "formfillup_id", $result["formfillup_id"]);
        } catch (Exception $err) {
            print $os->query;
        }
    }
?>
    <table class="table">
        <? foreach ($results as $index => $result) { ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $result["name"] ?></td>
                <td><?= $result["total_marks_obtain"] ?></td>
                <td>
                    <table>
                        <? foreach ($result["details"] as $detail) { ?>
                            <tr>
                                <td style="font-size: 10px; padding-right: 10px"><?= $detail->subject ?></td>
                                <td style="font-size: 10px;"><?= $detail->obtain_marks ?></td>
                            </tr>
                        <? } ?>
                    </table>
                </td>

            </tr>
        <?
        }
        ?>
    </table>
<?
}
?>
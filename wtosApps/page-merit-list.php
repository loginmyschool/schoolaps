<?php
include "_partials/wt_header.php";
include "_partials/wt_precontent.php";
global $os, $site, $session_selected, $bridge, $pageVar;
?>
<div style="height: 200px;"></div>
<? include "_partials/wt_postcontent.php"; ?>
<?

$sql = <<<EOT
SELECT ff.name, ff.formfillup_id,  GROUP_CONCAT(JSON_OBJECT(
    'priority', aed.priority,
    'subject', aed.subject_name,
    'obtain_marks', aerd.marks_obtain
  )) as details, SUM(aerd.marks_obtain) as total_marks_obtain FROM admission_exam_result_detail aerd   
INNER JOIN formfillup ff ON ff.formfillup_id=aerd.formfillup_id 
INNER JOIN admission_exam_detail aed ON aerd.admission_exam_detail_id = aed.admission_exam_detail_id 
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
?>
<div class="uk-container">
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
</div>
<style>
    .table {
        width: 100%;
        border-collapse: collapse
    }
</style>
<script>
</script>
<? include "_partials/wt_footer.php"; ?>
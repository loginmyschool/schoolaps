<?php
header("Content-Type: text/plain");
$HOST = "al-ameen.in";
$USER = "alameen_multi";
$PASS = "@#Alameen123@#";
$DB = "dbsystem";
function create_connection($HOST, $USER, $PASS, $DB)
{
// Create connection
    $conn = new mysqli($HOST, $USER, $PASS, $DB);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function make_entities($arr): string
{
    $entities = array_map(function ($key,$val){
        return "$key='$val'";
    }, array_keys($arr), array_values($arr));

    return implode(",", $entities);
}
$conn = create_connection($HOST, $USER, $PASS, $DB);
$students = $conn->query("SELECT * FROM student LIMIT 0, 500")->fetch_all(MYSQLI_ASSOC);
$student_ids = array_map(function ($student){return $student["studentId"];},$students);
$student_ids_str = implode(",", $student_ids);

$histories = $conn->query("SELECT * FROM history WHERE studentId IN({$student_ids_str})")->fetch_all(MYSQLI_ASSOC);

$students = array_map(function ($student) use ($histories){
    $history = array_filter($histories, function ($history) use($student){
        return $history["studentId"] === $student["studentId"];
    });
    $student["histories"] = $history;
    return $student;
},$students);
$conn->close();
//second phase
$HOST = "loginmyschool.com";
$USER = "login_global";
$PASS = "qwerty12345";
$DB = "loginmyschool_db";

$conn = create_connection($HOST, $USER, $PASS, $DB);
try {
    $conn->begin_transaction();
    foreach ($students as $student){
        $histories = $student["histories"];
        unset($student["studentId"]);
        unset($student["histories"]);
        $student["otpPass"] = rand(111111,999999);

        $entities = make_entities($student);
        $conn->query("INSERT INTO student SET $entities");
        $studentId = $conn->insert_id;
        foreach ($histories as $history){
            $history["studentId"] = $studentId;
            unset($history["historyId"]);
            $entities = make_entities($history);
            $conn->query("INSERT INTO history SET $entities");
        }
    }
    print  "Successfully inserted";
    $conn->rollback();
} catch (Throwable $exception){
    $conn->rollback();
    throw $exception;
}
?>

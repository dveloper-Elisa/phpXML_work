<?php
include_once 'connection.php';
include_once 'student.php';

$database = new Conection();
$db = $database->getConnection();

$student = new Student($db);

$students_per_page = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $students_per_page;

$stmt = $student->read($offset, $students_per_page);
$num = $stmt->rowCount();

if($num > 0) {
    $students_arr = array();
    $students_arr["records"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $student_item = array(
            "id" => $id,
            "name" => $name,
            "email" => $email
        );
        array_push($students_arr["records"], $student_item);
    }
    $total_students = $student->count();
    $students_arr["total_pages"] = ceil($total_students / $students_per_page);
    echo json_encode($students_arr);
} else {
    echo json_encode(
        array("message" => "No students found.")
    );
}
?>

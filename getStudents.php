<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'connection.php';
include_once 'student.php';

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die(json_encode(["error" => "Database connection failed."]));
}

$student = new Student($db);

$students_per_page = 2;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $students_per_page;

try {
    $stmt = $student->read($offset, $students_per_page);
    $num = $stmt->rowCount();

    if ($num > 0) {
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

        header('Content-Type: application/json');
        echo json_encode($students_arr);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "No students found."));
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>

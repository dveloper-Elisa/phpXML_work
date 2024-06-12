<?php
include_once 'connection.php';
include_once 'student.php';

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

$students_per_page = 100;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $students_per_page;

$stmt = $student->read($offset, $students_per_page);
$num = $stmt->rowCount();

header("Content-Type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<students>";
echo "Here is the example of the data displayed using XML";
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<student>";
        echo "<id>{$id}</id>";
        echo "<name>{$name}</name>";
        echo "<email>{$email}</email>";
        echo "</student>";
    }
}
echo "</students>";
?>

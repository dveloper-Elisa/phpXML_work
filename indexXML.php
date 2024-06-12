<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



include_once 'connection.php';
include_once 'student.php';

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

$students_per_page = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $students_per_page;

// Fetch students for the current page
$stmt = $student->read($offset, $students_per_page);
$num = $stmt->rowCount();
$students = [];
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $students[] = $row;
    }
}

// Get total number of students for pagination
$total_students = $student->count();
$total_pages = ceil($total_students / $students_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 5px 0;
        }
        .pagination button {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <h1>Student List</h1>
    <div id="studentList">
        <ul>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <li><?php echo htmlspecialchars($student['name']); ?> - <?php echo htmlspecialchars($student['email']); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No students found.</li>
            <?php endif; ?>
        </ul>
    </div>
    <div id="pagination">
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <button onclick="window.location.href='indexXML.php?page=<?php echo $i; ?>'"><?php echo $i; ?></button>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>

<?php
include_once 'connection.php';
include_once 'student.php';

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

$students_per_page = 3;
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
        .container{
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 10rem;
            align-items: center;
        }
        .group{
            font-weight: 900;
            font-family: Courier, monospace;
        }
        .navigation{
            display: flex;
            flex-direction: row;
            gap: 5rem;
        }
        .navigation a{
            text-decoration: none;
            color: black;
            cursor: pointer;
            border: 2px solid black;
            border-radius: 5px;
            padding: 0.5rem 1rem 0.5rem 1rem;
        }
        .navigation a:hover{
            background-color: black;
            color: white;
            border: 2px yellow solid;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="group"><h1> GROUP 7 PHP WORK </h1></div>

    <div class="navigation">
        <a href="getStudentsXML.php">Data in XML</a>
        <a href="getStudents.php">Data in JSON</a>
    </div>
</div>


    <h1>Student List with Pagginations</h1>
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
                <button onclick="window.location.href='index.php?page=<?php echo $i; ?>'"><?php echo $i; ?></button>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>

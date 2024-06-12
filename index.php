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
    <link rel="stylesheet" href="style.css">
    <title>display data</title>
   
</head>
<body>
<div class="container">

    <div class="group"><h1> GROUP 7 PHP WORK </h1></div>

    <div class="navigation">
        <a href="getStudentsXML.php">Data in XML</a>
        <a href="getStudents.php">Data in JSON</a>
    </div>
</div>


<div class="bodyme">

<div class="subbody">
    <div style="padding: 2rem;">
        <h3><u>Group 7 members</u></h3>
        <ol>
            <li>Kwizera Elisa</li>
            <li>Uwumukiza Fideline</li>
            <li>Numugisha Emelyne</li>
            <li>Hakuzimana Jean dedie</li>
        </ol>
    </div>
    <div class="subme">
        <h3>Data displayed with Pagginations</h3>
        <div id="studentList">
        <ul>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <li><?php echo htmlspecialchars($student['name']); ?> ===> <?php echo htmlspecialchars($student['email']); ?></li>
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
    </div>
    </div>
</div>
</body>
</html>

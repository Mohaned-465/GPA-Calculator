<?php
$result = "";
$table = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $courses = $_POST['course'] ?? [];
    $credits = $_POST['credits'] ?? [];
    $grades = $_POST['grade'] ?? [];

    $totalPoints = 0;
    $totalCredits = 0;

    $table .= "<table border='1'>";
    $table .= "<tr><th>Course</th><th>Credits</th><th>Grade</th><th>Points</th></tr>";

    for ($i = 0; $i < count($courses); $i++) {

        $c = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $g = floatval($grades[$i]);

        if ($cr <= 0) continue;

        $pts = $cr * $g;

        $totalPoints += $pts;
        $totalCredits += $cr;

        $table .= "<tr>
                    <td>$c</td>
                    <td>$cr</td>
                    <td>$g</td>
                    <td>$pts</td>
                   </tr>";
    }

    $table .= "</table>";

    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;

        if ($gpa >= 3.7) $msg = "Distinction";
        elseif ($gpa >= 3.0) $msg = "Merit";
        elseif ($gpa >= 2.0) $msg = "Pass";
        else $msg = "Fail";

        $result = "GPA: " . number_format($gpa, 2) . " ($msg)";
    } else {
        $result = "No valid data";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>GPA Calculator</title>
<script src="script.js"></script>
</head>

<body>

<h1>GPA Calculator</h1>

<?php if ($result != ""): ?>
    <?php echo $table; ?>
    <h2><?php echo $result; ?></h2>
<?php endif; ?>

<form method="post" onsubmit="return validateForm()">

<div id="courses">
<div class="course-row">
<input type="text" name="course[]" placeholder="Course" required>
<input type="number" name="credits[]" min="1" required>
<select name="grade[]">
<option value="4.0">A</option>
<option value="3.0">B</option>
<option value="2.0">C</option>
<option value="1.0">D</option>
<option value="0.0">F</option>
</select>
</div>
</div>

<button type="button" onclick="addCourse()">+ Add</button>
<br><br>
<input type="submit" value="Calculate">

</form>

</body>
</html>

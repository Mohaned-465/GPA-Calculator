<?php
header("Content-Type: application/json");

$courses = $_POST['course'] ?? [];
$credits = $_POST['credits'] ?? [];
$grades = $_POST['grade'] ?? [];

$totalPoints = 0;
$totalCredits = 0;

$table = "<table class='table table-bordered'>";
$table .= "<tr><th>Course</th><th>Credits</th><th>Grade</th><th>Points</th></tr>";

for ($i=0; $i<count($courses); $i++) {

    $c = htmlspecialchars($courses[$i]);
    $cr = floatval($credits[$i]);
    $g = floatval($grades[$i]);

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

    echo json_encode([
        "gpa" => $gpa,
        "message" => "GPA: ".number_format($gpa,2)." ($msg)",
        "table" => $table
    ]);
}
?>

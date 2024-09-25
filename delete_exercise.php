<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect exercise ID from the form
    $exercise_id = $_POST['Exercise_ID'];

    // SQL query to delete the exercise
    $sql = "DELETE FROM `exercise information` WHERE Exercise_ID = '$exercise_id'";

    if ($connection->query($sql) === TRUE) {
        echo "Exercise deleted successfully!";
    } else {
        echo "Error deleting exercise: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to delete exercise -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Exercise</title>
</head>
<body>
    <h2>Delete Exercise</h2>
    <form method="post" action="">
        <label for="Exercise_ID">Exercise ID:</label>
        <input type="number" name="Exercise_ID" id="Exercise_ID" required><br><br>

        <input type="submit" value="Delete Exercise">
    </form>
</body>
</html>

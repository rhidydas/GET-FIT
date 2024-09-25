<?php
// Start the session
session_start();

// Include the database connection file
include 'DBconnect.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the exercise ID from session or any other relevant source
$exercise_id = $_SESSION['exercise_id']; // Adjust this to correctly fetch the Exercise_ID as per your application logic

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form input values
    $calories_burned = $_POST['calories_burned'];
    $total_reps = $_POST['total_reps'];
    $distance = $_POST['distance'];
    $exer_duration = $_POST['exer_duration'];

    // Validate that all fields are filled
    if (!empty($calories_burned) && !empty($total_reps) && !empty($distance) && !empty($exer_duration)) {
        // Prepare the SQL query to update the progress metrics using Exercise_ID
        $updateQuery = "UPDATE `exercise information` SET `Calories_Burned` = ?, `Total_Reps` = ?, `Distance` = ?, `Exer_Duration` = ? WHERE `Exercise_ID` = ?";
        $stmt = $connection->prepare($updateQuery);
        if ($stmt) {
            // Bind the parameters to the SQL query
            $stmt->bind_param("iiisi", $calories_burned, $total_reps, $distance, $exer_duration, $exercise_id);
            // Execute the query
            if ($stmt->execute()) {
                echo "Progress updated successfully.";
            } else {
                echo "Error updating progress: " . $stmt->error;
            }
            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing query: " . $connection->error;
        }
    } else {
        echo "Please fill out all fields in the form.";
    }
}

// Close the connection
$connection->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Progress</title>
</head>
<body>

<h2>Update Your Progress Metrics</h2>
<form action="update_exercise.php" method="post">
    <label for="calories_burned">Calories Burned:</label>
    <input type="number" id="calories_burned" name="calories_burned" required><br>

    <label for="total_reps">Total Reps:</label>
    <input type="number" id="total_reps" name="total_reps" required><br>

    <label for="distance">Distance (m):</label>
    <input type="number" id="distance" name="distance" required><br>

    <label for="exercise_duration">Exercise Duration (min):</label>
    <input type="number" id="exercise_duration" name="exercise_duration" required><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>

<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect trainer data from the form
    $name = $_POST['name'];
    $workout_plan = $_POST['workout_plan'];

    // Automatically insert feedback for the trainer to get Feedback_ID
    $sql_feedback = "INSERT INTO `feedback information` (Rating, Comment, Date) 
                     VALUES (5, 'Default feedback for trainer.', CURDATE())"; // Adjust default values as needed

    if ($connection->query($sql_feedback) === TRUE) {
        // Get the new Feedback_ID
        $feedback_id = $connection->insert_id;

        // Insert the trainer with the generated Feedback_ID
        $sql_trainer = "INSERT INTO `trainer information` (Name, Workout_Plan, Feedback_ID) 
                        VALUES ('$name', '$workout_plan', '$feedback_id')";

        if ($connection->query($sql_trainer) === TRUE) {
            echo "Trainer and related feedback added successfully!";
        } else {
            echo "Error adding trainer: " . $connection->error;
        }
    } else {
        echo "Error inserting feedback: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to insert trainer -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Trainer</title>
</head>
<body>
    <h2>Insert New Trainer</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="workout_plan">Workout Plan:</label>
        <input type="text" name="workout_plan" id="workout_plan" required><br><br>

        <input type="submit" value="Add Trainer">
    </form>
</body>
</html>

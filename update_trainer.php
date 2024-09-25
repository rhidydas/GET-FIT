<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect trainer data from the form
    $trainer_id = $_POST['Trainer_ID'];
    $name = $_POST['name'];
    $workout_plan = $_POST['workout_plan'];

    // SQL query to update the trainer
    $sql = "UPDATE `trainer information` 
            SET Name = '$name', Workout_Plan = '$workout_plan' 
            WHERE Trainer_ID = '$trainer_id'";

    if ($connection->query($sql) === TRUE) {
        echo "Trainer updated successfully!";
    } else {
        echo "Error updating trainer: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to update trainer -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Trainer</title>
</head>
<body>
    <h2>Update Trainer</h2>
    <form method="post" action="">
        <label for="Trainer_ID">Trainer ID:</label>
        <input type="number" name="Trainer_ID" id="Trainer_ID" required><br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="workout_plan">Workout Plan:</label>
        <input type="text" name="workout_plan" id="workout_plan" required><br><br>

        <input type="submit" value="Update Trainer">
    </form>
</body>
</html>

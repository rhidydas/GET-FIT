<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect trainer ID from the form
    $trainer_id = $_POST['Trainer_ID'];

    // SQL query to delete the trainer
    $sql = "DELETE FROM `trainer information` WHERE Trainer_ID = '$trainer_id'";

    if ($connection->query($sql) === TRUE) {
        echo "Trainer deleted successfully!";
    } else {
        echo "Error deleting trainer: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to delete trainer -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Trainer</title>
</head>
<body>
    <h2>Delete Trainer</h2>
    <form method="post" action="">
        <label for="Trainer_ID">Trainer ID:</label>
        <input type="number" name="Trainer_ID" id="Trainer_ID" required><br><br>

        <input type="submit" value="Delete Trainer">
    </form>
</body>
</html>

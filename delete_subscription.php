<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect subscription ID from the form
    $sub_id = $_POST['Sub_ID'];

    // SQL query to delete the subscription
    $sql = "DELETE FROM `subscription information` WHERE Sub_ID = '$sub_id'";

    if ($connection->query($sql) === TRUE) {
        echo "Subscription deleted successfully!";
    } else {
        echo "Error deleting subscription: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to delete subscription -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Subscription</title>
</head>
<body>
    <h2>Delete Subscription</h2>
    <form method="post" action="">
        <label for="Sub_ID">Subscription ID:</label>
        <input type="number" name="Sub_ID" id="Sub_ID" required><br><br>

        <input type="submit" value="Delete Subscription">
    </form>
</body>
</html>

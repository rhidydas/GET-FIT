<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect subscription data from the form
    $sub_id = $_POST['Sub_ID'];
    $start_date = $_POST['Start_Date'];
    $end_date = $_POST['End_Date'];
    $payment_status = $_POST['Payment_Status'];

    // SQL query to update the subscription
    $sql = "UPDATE `subscription information` 
            SET Start_Date = '$start_date', End_Date = '$end_date', Payment_Status = '$payment_status' 
            WHERE Sub_ID = '$sub_id'";

    if ($connection->query($sql) === TRUE) {
        echo "Subscription updated successfully!";
    } else {
        echo "Error updating subscription: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to update subscription -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Subscription</title>
</head>
<body>
    <h2>Update Subscription</h2>
    <form method="post" action="">
        <label for="Sub_ID">Subscription ID:</label>
        <input type="number" name="Sub_ID" id="Sub_ID" required><br><br>

        <label for="Start_Date">Start Date:</label>
        <input type="date" name="Start_Date" id="Start_Date" required><br><br>

        <label for="End_Date">End Date:</label>
        <input type="date" name="End_Date" id="End_Date" required><br><br>

        <label for="Payment_Status">Payment Status:</label>
        <input type="text" name="Payment_Status" id="Payment_Status" required><br><br>

        <input type="submit" value="Update Subscription">
    </form>
</body>
</html>

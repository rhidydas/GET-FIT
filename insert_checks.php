<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect checks data from the form
    $customer_id = $_POST['customer_id'];
    $progression_id = $_POST['progression_id'];

    // SQL query to insert new check
    $sql = "INSERT INTO `checks` (Customer_ID, Progression_ID) 
            VALUES ('$customer_id', '$progression_id')";

    if ($connection->query($sql) === TRUE) {
        echo "Check added successfully!";
    } else {
        echo "Error adding check: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to insert check -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Check</title>
</head>
<body>
    <h2>Insert New Check</h2>
    <form method="post" action="">
        <label for="customer_id">Customer ID:</label>
        <input type="number" name="customer_id" id="customer_id" required><br><br>

        <label for="progression_id">Progression ID:</label>
        <input type="number" name="progression_id" id="progression_id" required><br><br>

        <input type="submit" value="Add Check">
    </form>
</body>
</html>

<?php
// Include the database connection
include 'DBconnect.php';

// Check if the delete request is made
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // SQL query to delete the customer and associated data
    $sql_delete = "DELETE FROM `customer information` WHERE ID='$customer_id'";

    // Execute the query
    if ($connection->query($sql_delete) === TRUE) {
        echo "Customer deleted successfully!";
    } else {
        echo "Error deleting customer: " . $connection->error;
    }

    // Close the connection
    $connection->close();
} else {
    echo "No customer selected for deletion.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Customer</title>
</head>
<body>
    <h2>Delete Customer</h2>
    <p>The customer has been deleted if selected.</p>
    <a href="view_customers.php">Back to Customer List</a>
</body>
</html>

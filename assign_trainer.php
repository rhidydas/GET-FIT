<?php
// Include the database connection file
include_once 'DBconnect.php';

// Fetch trainers for customers to select
$trainersQuery = "SELECT `Name` FROM `trainer information`";
$trainersResult = $connection->query($trainersQuery);

// Fetch customer ID from URL or form submission (ensure this is securely passed, e.g., through GET/POST)
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && $customer_id) {
    $trainerName = $_POST['trainer_name']; // Directly get the trainer's name from the form

    // Assign the trainer's name to the customer in the customer information table
    $assignQuery = "UPDATE `customer information` 
                    SET `Trainer Name` = '$trainerName' 
                    WHERE `Customer ID` = '$customer_id'";

    if ($connection->query($assignQuery) === TRUE) {
        echo "Trainer assigned successfully!";
        
        // Redirect to the dashboard after successful assignment
        header("Location: dashboard.php");
        exit(); // Ensure the script stops executing after the redirect
    } else {
        echo "Error assigning trainer: " . $connection->error;
    }
} else {
    echo "Customer ID is missing or form not submitted correctly.";
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Trainer</title>
</head>
<body>
    <h2>Assign Trainer to Customer</h2>
    <form method="post" action="">
        <label for="trainer_name">Select Trainer:</label>
        <select name="trainer_name" id="trainer_name" required>
            <option value="">Select Trainer</option>
            <?php while ($trainer = $trainersResult->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($trainer['Name']); ?>"><?= htmlspecialchars($trainer['Name']); ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Assign Trainer">
    </form>
</body>
</html>

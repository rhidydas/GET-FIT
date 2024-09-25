<?php
// Include the database connection
include_once 'DBconnect.php';

// Function to insert progress automatically (e.g., triggered after workout completion)
function insertProgress($customer_id, $progress_metrics) {
    global $connection;

    // Assume progress metrics are calculated after a workout and passed to this function
    $sql = "INSERT INTO `progress information` (Customer_ID, Progress_Metrics, Date, T_ID)
            VALUES ('$customer_id', '$progress_metrics', CURDATE(), NULL)"; // NULL for Trainer_ID if not required
    
    if ($connection->query($sql) === TRUE) {
        echo "Progress updated successfully!";
    } else {
        echo "Error updating progress: " . $connection->error;
    }
}

// Example of triggering progress insertion (this would be integrated into your workout completion logic)
$customer_id = 1; // Example customer ID, replace with actual logic to fetch customer
$progress_metrics = "Workout completed: 30 mins, 200 reps"; // Example metrics
insertProgress($customer_id, $progress_metrics);

// Close the connection
$connection->close();
?>

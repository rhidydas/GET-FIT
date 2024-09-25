<?php
// Include the database connection file
include_once 'DBconnect.php';

// SQL query to select all trainers
$sql = "SELECT * FROM `trainer information`";
$result = $connection->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . $connection->error);
}

// Check if any trainers were found
if ($result->num_rows > 0) {
    echo "<h2>Trainer List</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Trainer ID</th>
            <th>Name</th>
            <th>Workout Plan</th>
          </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Trainer_ID'] . "</td>
                <td>" . $row['Name'] . "</td>
                <td>" . $row['Workout_Plan'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No trainers found.";
}

// Close the connection
$connection->close();
?>

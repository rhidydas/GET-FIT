<?php
// Include the database connection file
include_once 'DBconnect.php';

// SQL query to select all subscriptions
$sql = "SELECT * FROM `subscription information`";
$result = $connection->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . $connection->error);
}

// Check if any subscriptions were found
if ($result->num_rows > 0) {
    echo "<h2>Subscription List</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Subscription ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Payment Status</th>
          </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Sub_ID'] . "</td>
                <td>" . $row['Start_Date'] . "</td>
                <td>" . $row['End_Date'] . "</td>
                <td>" . $row['Payment_Status'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No subscriptions found.";
}

// Close the connection
$connection->close();
?>

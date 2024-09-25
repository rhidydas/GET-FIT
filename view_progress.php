<?php
// Include the database connection
include_once 'DBconnect.php';

// SQL query to select all progress entries
$sql = "SELECT pi.Progression_ID, pi.Customer_ID, c.Name AS Customer_Name, pi.Progress_Metrics, pi.Date 
        FROM `progress information` pi
        LEFT JOIN `customer information` c ON pi.Customer_ID = c.ID";
$result = $connection->query($sql);

// Display progress entries if any exist
if ($result->num_rows > 0) {
    echo "<h2>Progress List</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Progression ID</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Progress Metrics</th>
            <th>Date</th>
          </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Progression_ID'] . "</td>
                <td>" . $row['Customer_ID'] . "</td>
                <td>" . $row['Customer_Name'] . "</td>
                <td>" . $row['Progress_Metrics'] . "</td>
                <td>" . $row['Date'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No progress records found.";
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Progress</title>
</head>
<body>
    <h2>View Progress</h2>
</body>
</html>

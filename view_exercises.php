<?php
// Include the database connection file
include_once 'DBconnect.php';

// SQL query to select all exercises
$sql = "SELECT * FROM `exercise information`";
$result = $connection->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . $connection->error);
}

// Check if any exercises were found
if ($result->num_rows > 0) {
    echo "<h2>Exercise List</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Exercise ID</th>
            <th>Footsteps</th>
            <th>Total Reps</th>
            <th>Calories Burned</th>
            <th>Distance</th>
            <th>Exercise Duration</th>
          </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Exercise_ID'] . "</td>
                <td>" . $row['Footsteps'] . "</td>
                <td>" . $row['Total_Reps'] . "</td>
                <td>" . $row['Calories_Burned'] . "</td>
                <td>" . $row['Distance'] . "</td>
                <td>" . $row['Exer_Duration'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No exercises found.";
}

// Close the connection
$connection->close();
?>

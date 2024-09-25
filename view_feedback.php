<?php
// Include the database connection
include_once 'DBconnect.php';

// SQL query to select all feedback entries without joining Customer ID since it's not present in feedback information
$sql = "SELECT fi.Feedback_ID, fi.Rating, fi.Comment, fi.Date 
        FROM `feedback information` fi";
$result = $connection->query($sql);

// Display feedback entries if any exist
if ($result && $result->num_rows > 0) {
    echo "<h2>Feedback List</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Feedback ID</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
          </tr>";
    
    // Fetch and display each row of data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Feedback_ID'] . "</td>
                <td>" . $row['Rating'] . "</td>
                <td>" . $row['Comment'] . "</td>
                <td>" . $row['Date'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No feedback found.";
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback</title>
</head>
<body>
    <h2>View Feedback</h2>
</body>
</html>

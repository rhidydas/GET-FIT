<?php
// Include database connection
include 'DBconnect.php';

// Fetch all customers
$sql = "SELECT * FROM `customer information`";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Customer List</h2>";
    echo "<table border='1'>
            <tr>
                <th>Customer_ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Height</th>
                <th>Weight</th>
                <th>BMI</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Sub_ID</th>
                <th>Exercise_ID</th>
                <th>Feedback_ID</th>
            </tr>";
    
    // Display each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Customer ID'] . "</td>
                <td>" . $row['Name'] . "</td>
                <td>" . $row['Age'] . "</td>
                <td>" . $row['Height'] . "</td>
                <td>" . $row['Weight'] . "</td>
                <td>" . $row['BMI'] . "</td>
                <td>" . $row['Gender'] . "</td>
                <td>" . $row['Email'] . "</td>
                <td>" . $row['Sub_ID'] . "</td>
                <td>" . $row['Exercise_ID'] . "</td>
                <td>" . $row['Feedback_ID'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No customers found.";
}

// Close the database connection
$connection->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Customers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        td a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
</body>
</html>

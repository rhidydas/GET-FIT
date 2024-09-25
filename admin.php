<?php
// Start session if needed
session_start();

// Include the database connection file
include_once 'DBconnect.php';

// SQL query to fetch customer, associated trainer, and subscription details
$query = "
    SELECT 
        ci.`Customer ID`, 
        ci.`Name` AS CustomerName, 
        ci.`Age`, 
        ci.`Height`, 
        ci.`Weight`, 
        ci.`BMI`, 
        ci.`Gender`, 
        ci.`Email`, 
        ci.`Trainer Name`, 
        ti.`Workout_Plan`, 
        ti.`Feedback_ID` AS TrainerFeedbackID,
        si.`Sub_ID`,
        si.`Payment_Status`
    FROM 
        `customer information` ci
    JOIN 
        `trainer information` ti 
    ON 
        ci.`Trainer Name` = ti.`Name`
    JOIN
        `subscription information` si
    ON 
        ci.`Sub_ID` = si.`Sub_ID`
";

// Execute the query
$result = $connection->query($query);

// Check if the query was successful
if ($result === FALSE) {
    echo "Error: " . $connection->error;
    exit;
}

// Check if the form is submitted to update payment status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_payment'])) {
    $sub_id = $_POST['sub_id'];
    $new_status = $_POST['payment_status']; // Get the new status from the dropdown

    // Update the payment status in the database
    $updateQuery = "UPDATE `subscription information` SET `Payment_Status` = '$new_status' WHERE `Sub_ID` = '$sub_id'";
    if ($connection->query($updateQuery) === TRUE) {
        echo "<script>alert('Payment status updated successfully.'); window.location.href='admin.php';</script>";
    } else {
        echo "Error updating payment status: " . $connection->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        select {
            padding: 5px;
        }
    </style>
</head>
<body>
<h1>Admin Dashboard</h1>

<table>
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Age</th>
            <th>Height (cm)</th>
            <th>Weight (kg)</th>
            <th>BMI</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Trainer Name</th>
            <th>Workout Plan</th>
            <th>Trainer Feedback ID</th>
            <th>Payment Status</th>
            <th>Update Payment</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Customer ID']) ?></td>
                    <td><?= htmlspecialchars($row['CustomerName']) ?></td>
                    <td><?= htmlspecialchars($row['Age']) ?></td>
                    <td><?= htmlspecialchars($row['Height']) ?></td>
                    <td><?= htmlspecialchars($row['Weight']) ?></td>
                    <td><?= htmlspecialchars($row['BMI']) ?></td>
                    <td><?= htmlspecialchars($row['Gender']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= htmlspecialchars($row['Trainer Name']) ?></td>
                    <td><?= htmlspecialchars($row['Workout_Plan']) ?></td>
                    <td><?= htmlspecialchars($row['TrainerFeedbackID']) ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="sub_id" value="<?= $row['Sub_ID'] ?>">
                            <select name="payment_status">
                                <option value="Pending" <?= $row['Payment_Status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Verified" <?= $row['Payment_Status'] === 'Verified' ? 'selected' : '' ?>>Verified</option>
                            </select>
                    </td>
                    <td>
                            <button type="submit" name="update_payment" class="btn">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="13">No data found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php
// Close the database connection
$connection->close();
?>

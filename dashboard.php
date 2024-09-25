<?php
// Start the session to check if the user is logged in
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the exercise_id is set in the session
if (!isset($_SESSION['exercise_id'])) {
    // Handle the case where exercise_id is not set
    $_SESSION['exercise_id'] = null; // Set to null or handle it as per your application needs
}

// Include the database connection file
include 'DBconnect.php';

// Get the logged-in customer's ID from the session
$customer_id = $_SESSION['customer_id'];
$exercise_id = $_SESSION['exercise_id'];

// Fetch user info from the customer information table
$customerQuery = "SELECT * FROM `customer information` WHERE `Customer ID` = '$customer_id'";
$customerResult = $connection->query($customerQuery);
$customer = $customerResult->fetch_assoc();

// Fetch trainer info based on the selected trainer
$trainerName = $customer['Trainer Name']; // Assuming trainer name is stored directly in customer info
$trainerQuery = "SELECT * FROM `trainer information` WHERE `Name` = '$trainerName'";
$trainerResult = $connection->query($trainerQuery);
$trainer = $trainerResult->fetch_assoc();

// Fetch progress metrics for the customer
$progressQuery = "SELECT * FROM `progress information` WHERE `Customer_ID` = '$customer_id'";
$progressResult = $connection->query($progressQuery);

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .section { margin-bottom: 20px; }
        .section h2 { border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        .button-container { margin-top: 20px; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($customer['Name']); ?>!</h1>

<div class="section">
    <h2>Your Information</h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['Email']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($customer['Age']); ?></p>
    <p><strong>Height:</strong> <?php echo htmlspecialchars($customer['Height']); ?> cm</p>
    <p><strong>Weight:</strong> <?php echo htmlspecialchars($customer['Weight']); ?> kg</p>
    <p><strong>BMI:</strong> <?php echo htmlspecialchars($customer['BMI']); ?></p>
</div>

<?php if ($trainer): ?>
    <div class="section">
        <h2>Your Trainer: <?php echo htmlspecialchars($trainer['Name']); ?></h2>
        <p><strong>Workout Plan:</strong> <?php echo htmlspecialchars($trainer['Workout_Plan']); ?></p>
    </div>
<?php endif; ?>

<div class="section">
    <h2>Your Progress Metrics</h2>
    <?php if ($progressResult && $progressResult->num_rows > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Calories Burned</th>
                <th>Total Reps</th>
                <th>Distance (m)</th>
                <th>Exercise Duration (min)</th>
            </tr>
            <?php while ($progress = $progressResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($progress['Date']); ?></td>
                    <td><?php echo htmlspecialchars($progress['Calories_Burned']); ?></td>
                    <td><?php echo htmlspecialchars($progress['Total_Reps']); ?></td>
                    <td><?php echo htmlspecialchars($progress['Distance']); ?></td>
                    <td><?php echo htmlspecialchars($progress['Exer_Duration']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No progress metrics found.</p>
    <?php endif; ?>
    <!-- Update Progress Button -->
    <div class="button-container">
        <a href="update_exercise.php"><button>Update Your Progress</button></a>
    </div>
</div>

<!-- Feedback Button Section -->
<div class="section">
    <h2>Trainer Feedback</h2>
    <p>We value your feedback. Please let us know about your experience with your trainer.</p>
    <form action="insert_feedback.php" method="post">
        <button type="submit" class="btn btn-primary">Give Feedback on Trainer</button>
    </form>
</div>

<!-- Insert Exercise Button -->
<div class="button-container">
    <a href="insert_exercise.php"><button>Insert Exercise</button></a>
</div>

</body>
</html>

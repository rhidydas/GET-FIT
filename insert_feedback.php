<?php
// Start session to ensure user data is maintained
session_start();

// Include the database connection file
include 'DBconnect.php'; // Ensure DBconnect.php correctly establishes the connection

// Check if the user is logged in; otherwise, redirect to login page
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in customer's ID from the session
$customer_id = $_SESSION['customer_id'];

// Fetch trainer information that the customer can provide feedback on
$trainerQuery = "SELECT * FROM `trainer information` WHERE `Trainer_ID` IN (SELECT `Trainer_ID` FROM `customer information` WHERE `Customer ID` = '$customer_id')";
$trainerResult = $connection->query($trainerQuery);

// Handle the form submission for feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all expected form data is set
    if (isset($_POST['rating'], $_POST['comment'])) {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        // Modify the SQL query to insert only relevant fields into feedback information table
        $sql = "INSERT INTO `feedback information` (`Rating`, `Comment`, `Date`) VALUES (?, ?, NOW())";
        $stmt = $connection->prepare($sql);

        // Check if the statement was prepared successfully
        if ($stmt) {
            $stmt->bind_param('is', $rating, $comment);

            if ($stmt->execute()) {
                echo "<p style='color: green;'>Feedback submitted successfully! Redirecting to Dashboard...</p>";
                header('refresh:3;url=dashboard.php'); // Redirect back to the dashboard after 3 seconds
            } else {
                echo "<p style='color: red;'>Error executing query: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color: red;'>Error preparing query: " . $connection->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill out all fields in the form.</p>";
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Feedback</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f9; }
        .feedback-container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .feedback-container h2 { margin-bottom: 20px; color: #333; }
        .feedback-container label { display: block; margin-bottom: 8px; }
        .feedback-container input, .feedback-container textarea, .feedback-container select { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .feedback-container button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .feedback-container button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="feedback-container">
    <h2>Provide Feedback on Your Trainer</h2>
    <form action="insert_feedback.php" method="post">
        <label for="trainer_id">Select Trainer:</label>
        <select name="trainer_id" id="trainer_id" required>
            <?php while ($trainer = $trainerResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($trainer['Trainer_ID']); ?>">
                    <?php echo htmlspecialchars($trainer['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="4" required></textarea>

        <button type="submit">Submit Feedback</button>
    </form>
</div>

</body>
</html>

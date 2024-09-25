<?php
// Include the database connection file
include_once 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect feedback data from the form
    $feedback_id = $_POST['Feedback_ID'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // SQL query to update the feedback
    $sql = "UPDATE `feedback information` 
            SET Rating = '$rating', Comment = '$comment', Date = CURDATE() 
            WHERE Feedback_ID = '$feedback_id'";

    if ($connection->query($sql) === TRUE) {
        echo "Feedback updated successfully!";
    } else {
        echo "Error updating feedback: " . $connection->error;
    }
}

// Close the connection
$connection->close();
?>

<!-- HTML form to update feedback -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Feedback</title>
</head>
<body>
    <h2>Update Feedback</h2>
    <form method="post" action="">
        <label for="Feedback_ID">Feedback ID:</label>
        <input type="number" name="Feedback_ID" id="Feedback_ID" required><br><br>

        <label for="rating">Rating:</label>
        <input type="number" name="rating" id="rating" min="1" max="5" required><br><br>

        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" required></textarea><br><br>

        <input type="submit" value="Update Feedback">
    </form>
</body>
</html>

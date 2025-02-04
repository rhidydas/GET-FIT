<?php
// Include the database connection once
include 'DBconnect.php';

// Function to insert subscription information and return its ID
function insertSubscription() {
    global $connection; // Use the global connection

    // Insert into the correct columns: Start_Date, End_Date, Payment_Status
    $sql_subscription = "INSERT INTO `subscription information` (`Start_Date`, `End_Date`, `Payment_Status`) 
                         VALUES (CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'Pending')";

    if ($connection->query($sql_subscription) === TRUE) {
        return $connection->insert_id; // Return the ID of the inserted subscription
    } else {
        echo "Error inserting subscription: " . $connection->error;
        return false;
    }
}

// Function to insert exercise information and return its ID
function insertExercise() {
    global $connection; // Use the global connection
    $sql_exercise = "INSERT INTO `exercise information` (Exercise_Name, Footsteps, Total_Reps, Calories_Burned, Distance, Exer_Duration) 
                     VALUES ('Push-ups', 0, 20, 100, 0, '10:00')";
    if ($connection->query($sql_exercise) === TRUE) {
        return $connection->insert_id; // Return the ID of the inserted exercise
    } else {
        echo "Error inserting exercise: " . $connection->error;
        return false;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect customer data from the form
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bmi = $_POST['bmi'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Collect the password from the form

    // Insert subscription and exercise information to get their IDs
    $subscription_id = insertSubscription();
    $exercise_id = insertExercise();

    // Auto-create feedback (e.g., default feedback, if necessary) to get Feedback_ID
    $sql_feedback = "INSERT INTO `feedback information` (Rating, Comment, Date) 
                     VALUES (5, 'Auto-feedback entry.', CURDATE())"; // Adjust default values as needed

    if ($connection->query($sql_feedback) === TRUE) {
        // Get the new Feedback_ID
        $feedback_id = $connection->insert_id;

        // Check if all related data inserts were successful before inserting the customer
        if ($subscription_id && $exercise_id) {
            // Insert customer information into the database with placeholder IDs
            $sql_customer = "INSERT INTO `customer information` (Name, Age, Height, Weight, BMI, Gender, Email, Password, Sub_ID, Exercise_ID, Feedback_ID) 
                             VALUES ('$name', '$age', '$height', '$weight', '$bmi', '$gender', '$email', '$password', '$subscription_id', '$exercise_id', '$feedback_id')";

            if ($connection->query($sql_customer) === TRUE) {
                // Get the new Customer ID
                $customer_id = $connection->insert_id;

                // Redirect the customer to assign_trainer.php after registration
                echo "<script>
                        alert('Customer registered successfully! Now please select a trainer.');
                        window.location.href = 'assign_trainer.php?customer_id=$customer_id';
                      </script>";
            } else {
                echo "Error inserting customer: " . $connection->error;
            }
        } else {
            echo "Error inserting related data.";
        }
    } else {
        echo "Error inserting feedback: " . $connection->error;
    }
}

// Close the connection at the very end, after all operations
$connection->close();
?>

<!-- HTML form to collect customer data -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert New Customer</title>
</head>
<body>
    <h2>Insert New Customer</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required><br><br>

        <label for="height">Height (cm):</label>
        <input type="number" name="height" id="height" required><br><br>

        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" id="weight" required><br><br>

        <label for="bmi">BMI:</label>
        <input type="number" step="0.1" name="bmi" id="bmi" required><br><br>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" id="gender" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

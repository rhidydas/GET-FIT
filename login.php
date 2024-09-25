<?php
// Start the session
session_start();

// Include the database connection file
include 'DBconnect.php';

// Initialize variables
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get inputs from the login form
    $email = $_POST['email']; // Get the email from login input
    $password = $_POST['password']; // Get the password from login input

    // Validate credentials (Example: Replace this with your actual verification logic)
    $loginQuery = "SELECT * FROM `customer information` WHERE `Email` = '$email' AND `Password` = '$password'";
    $loginResult = $connection->query($loginQuery);

    if ($loginResult && $loginResult->num_rows == 1) {
        // Fetch customer details
        $customer = $loginResult->fetch_assoc();

        // Set session variables after successful login
        $_SESSION['customer_id'] = $customer['Customer ID']; // Set customer ID in session
        $_SESSION['customer_name'] = $customer['Name']; // Optional: Set customer name in session if needed

        // Fetch exercise information related to the customer
        $exerciseQuery = "SELECT `Exercise_ID` FROM `exercise information` WHERE `Customer_ID` = '{$customer['Customer ID']}'";
        $exerciseResult = $connection->query($exerciseQuery);

        if ($exerciseResult && $exerciseResult->num_rows > 0) {
            $exercise = $exerciseResult->fetch_assoc();
            // Set the Exercise_ID in the session
            $_SESSION['exercise_id'] = $exercise['Exercise_ID'];
        } else {
            // Set to null if not found or the query fails
            $_SESSION['exercise_id'] = null;
        }

        // Redirect to dashboard after setting Exercise_ID
        header("Location: dashboard.php");
        exit();
    } else {
        // Set an error message if login fails
        $error_message = "Invalid Email or Password.";
    }
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

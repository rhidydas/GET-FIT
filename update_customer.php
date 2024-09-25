<?php
// Include the database connection
include 'DBconnect.php';

// Check if the form is submitted to update the customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Collect updated customer data from the form
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bmi = $_POST['bmi'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];

    // Update customer information in the database
    $sql_update = "UPDATE `customer information` 
                   SET Name='$name', Age='$age', Height='$height', Weight='$weight', 
                       BMI='$bmi', Gender='$gender', Email='$email' 
                   WHERE ID='$customer_id'";

    if ($connection->query($sql_update) === TRUE) {
        echo "Customer updated successfully!";
    } else {
        echo "Error updating customer: " . $connection->error;
    }

    // Close the connection
    $connection->close();
}

// Fetch the customer data to populate the update form
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    $sql = "SELECT * FROM `customer information` WHERE ID='$customer_id'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Customer not found.";
        exit;
    }
} else {
    echo "No customer selected for update.";
    exit;
}
?>

<!-- HTML form to update customer data -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Customer</title>
</head>
<body>
    <h2>Update Customer Information</h2>
    <form method="post" action="">
        <input type="hidden" name="customer_id" value="<?php echo $row['ID']; ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $row['Name']; ?>" required><br><br>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" value="<?php echo $row['Age']; ?>" required><br><br>

        <label for="height">Height (cm):</label>
        <input type="number" name="height" id="height" value="<?php echo $row['Height']; ?>" required><br><br>

        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" id="weight" value="<?php echo $row['Weight']; ?>" required><br><br>

        <label for="bmi">BMI:</label>
        <input type="number" step="0.1" name="bmi" id="bmi" value="<?php echo $row['BMI']; ?>" required><br><br>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" id="gender" value="<?php echo $row['Gender']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $row['Email']; ?>" required><br><br>

        <input type="submit" name="update" value="Update Customer">
    </form>
</body>
</html>

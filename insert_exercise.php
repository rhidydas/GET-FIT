<?php
// Start session
session_start();

// Include the database connection file
include 'DBconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected exercise details from the form submission
    $selected_exercise = $_POST['exercise']; // Exercise name selected by the customer

    // Define available exercises with their details
    $exercises = [
        'Push-ups' => ['footsteps' => 0, 'total_reps' => 20, 'calories_burned' => 100, 'distance' => 0, 'exer_duration' => '10:00'],
        'Jogging' => ['footsteps' => 5000, 'total_reps' => 0, 'calories_burned' => 300, 'distance' => 5, 'exer_duration' => '30:00'],
        'Jumping Jacks' => ['footsteps' => 0, 'total_reps' => 50, 'calories_burned' => 150, 'distance' => 0, 'exer_duration' => '5:00'],
    ];

    // Check if the selected exercise exists in the defined list
    if (array_key_exists($selected_exercise, $exercises)) {
        $exercise = $exercises[$selected_exercise];
        // Insert the selected exercise details into the database
        $query = "INSERT INTO `exercise information` (`Exercise_Name`, `Footsteps`, `Total_Reps`, `Calories_Burned`, `Distance`, `Exer_Duration`) 
                  VALUES ('$selected_exercise', '{$exercise['footsteps']}', '{$exercise['total_reps']}', '{$exercise['calories_burned']}', '{$exercise['distance']}', '{$exercise['exer_duration']}')";
        if ($connection->query($query) === TRUE) {
            // Redirect to dashboard after successful insertion
            header("Location: dashboard.php");
            exit(); // Stop further script execution after the redirect
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }
    } else {
        echo "Invalid exercise selection.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Exercise</title>
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
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Select and Insert Exercise</h2>
    <form method="POST" action="">
        <label for="exercise">Choose Exercise:</label>
        <select name="exercise" id="exercise" required>
            <option value="">Select an Exercise</option>
            <option value="Push-ups">Push-ups</option>
            <option value="Jogging">Jogging</option>
            <option value="Jumping Jacks">Jumping Jacks</option>
        </select>
        <button type="submit" class="btn">Insert Exercise</button>
    </form>
</div>

</body>
</html>

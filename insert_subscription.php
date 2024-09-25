<?php
include 'DBconnect.php';

function insertSubscription() {
    global $connection;

    $sql = "INSERT INTO `subscription information` (Start_Date, End_Date, Payment_Status) 
            VALUES (CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'Pending')";

    if ($connection->query($sql) === TRUE) {
        return $connection->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return null;
    }
}
?>

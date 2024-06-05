<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM residents WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Resident deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<?php
include 'db_connect.php';

$sql = "SELECT * FROM residents";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Flat Number</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Date of Joining</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['flat_number']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['email']}</td>
                <td>{$row['date_of_joining']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

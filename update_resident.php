<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM residents WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Update Resident</title>
        </head>
        <body>
        <h2>Update Resident</h2>
        <form action="add_resident.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>
            Flat Number: <input type="text" name="flat_number" value="<?php echo $row['flat_number']; ?>" required><br><br>
            Contact Number: <input type="text" name="contact_number" value="<?php echo $row['contact_number']; ?>"><br><br>
            Email: <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
            Date of Joining: <input type="date" name="date_of_joining" value="<?php echo $row['date_of_joining']; ?>"><br><br>
            <input type="submit" name="update" value="Update Resident">
        </form>
        </body>
        </html>
        <?php
    } else {
        echo "No resident found with ID $id";
    }
    $conn->close();
}
?>

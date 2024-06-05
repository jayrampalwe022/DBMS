<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $flat_number = $_POST['flat_number'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $date_of_joining = $_POST['date_of_joining'];

        $errors = [];

        // Validate name (letters and spaces only)
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors[] = "Name should contain only letters and spaces.";
        }

        // Validate flat number (one letter followed by numbers)
        if (!preg_match("/^[A-Za-z]\d+$/", $flat_number)) {
            $errors[] = "Flat number should contain one letter followed by numbers.";
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Validate date (today or future)
        $today = date("Y-m-d");
        if ($date_of_joining < $today) {
            $errors[] = "Date of joining cannot be in the past.";
        }

        if (empty($errors)) {
            $sql = "INSERT INTO residents (name, flat_number, contact_number, email, date_of_joining)
                    VALUES ('$name', '$flat_number', '$contact_number', '$email', '$date_of_joining')";

            if ($conn->query($sql) === TRUE) {
                echo "New resident added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $flat_number = $_POST['flat_number'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $date_of_joining = $_POST['date_of_joining'];

        // Similar validation as above
        $errors = [];

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors[] = "Name should contain only letters and spaces.";
        }

        if (!preg_match("/^[A-Za-z]\d+$/", $flat_number)) {
            $errors[] = "Flat number should contain one letter followed by numbers.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        $today = date("Y-m-d");
        if ($date_of_joining < $today) {
            $errors[] = "Date of joining cannot be in the past.";
        }

        if (empty($errors)) {
            $sql = "UPDATE residents SET name='$name', flat_number='$flat_number', contact_number='$contact_number', email='$email', date_of_joining='$date_of_joining' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                echo "Resident updated successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Society Flat Management System</title>
    <script>
        function validateForm() {
            const name = document.forms["residentForm"]["name"].value;
            const flatNumber = document.forms["residentForm"]["flat_number"].value;
            const contactNumber = document.forms["residentForm"]["contact_number"].value;
            const email = document.forms["residentForm"]["email"].value;
            const dateOfJoining = document.forms["residentForm"]["date_of_joining"].value;

            // Name should contain only letters
            if (!/^[a-zA-Z\s]+$/.test(name)) {
                alert("Name should contain only letters and spaces.");
                return false;
            }

            // Flat number should contain one letter followed by numbers
            if (!/^[A-Za-z]\d+$/.test(flatNumber)) {
                alert("Flat number should contain one letter followed by numbers.");
                return false;
            }

            // Email format validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                alert("Invalid email format.");
                return false;
            }

            // Date should be today or future
            const today = new Date().toISOString().split('T')[0];
            if (dateOfJoining < today) {
                alert("Date of joining cannot be in the past.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<h2>Add New Resident</h2>
<form name="residentForm" action="add_resident.php" method="post" onsubmit="return validateForm()">
    Name: <input type="text" name="name" required><br><br>
    Flat Number: <input type="text" name="flat_number" required><br><br>
    Contact Number: <input type="text" name="contact_number"><br><br>
    Email: <input type="email" name="email"><br><br>
    Date of Joining: <input type="date" name="date_of_joining"><br><br>
    <input type="submit" name="add" value="Add Resident">
</form>

<h2>View Residents</h2>
<a href="view_residents.php">Click here to view all residents</a>

</body>
</html>

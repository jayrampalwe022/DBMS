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
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Flat Number</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Date of Joining</th>
        <th>Actions</th>
    </tr>
    <?php
    include 'db_connect.php';

    $sql = "SELECT * FROM residents";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['flat_number'] . "</td>";
            echo "<td>" . $row['contact_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['date_of_joining'] . "</td>";
            echo "<td>";
            echo "<form action='update_resident.php' method='post' style='display:inline;'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<input type='submit' value='Update'>";
            echo "</form>";
            echo "<form action='delete_resident.php' method='post' style='display:inline;'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<input type='submit' value='Delete' onclick='return confirm(\"Are you sure you want to delete this resident?\");'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No residents found.</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>

<?php
require_once('db_connect.php');
$sql = "SELECT users_id, first_name, last_name, role_id, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Role ID</th><th>Email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["users_id"]). "</td>";
        echo "<td>" . htmlspecialchars($row["first_name"]). "</td>";
        echo "<td>" . htmlspecialchars($row["last_name"]). "</td>";
        echo "<td>" . htmlspecialchars($row["role_id"]). "</td>";
        echo "<td>" . htmlspecialchars($row["email"]). "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
<?php

// SQL query to fetch recent books
$sql = "SELECT * FROM book ";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);
?>
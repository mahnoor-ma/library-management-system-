<?php
session_start();
require_once('db_connect.php'); 

// ----------------------------------------------------
// 1. AUTHENTICATION & POST VALIDATION
// ----------------------------------------------------

// Check 1: Is the Admin logged in?
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in as Admin to issue a book.'); document.location='login.php';</script>";
    exit();
}

// Ensure request arrives via form submission POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['issue_book_submit'])) {
    header("Location: issue_book.php");
    exit();
}

$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
$student_user_id = isset($_POST['users_id']) ? intval($_POST['users_id']) : 0;
$admin_user_id = intval($_SESSION['id']); 

// Check 2: Are the IDs valid?
if ($book_id <= 0) {
    echo "<script>alert('Error: Invalid Book ID submitted.'); document.location='issue_book.php';</script>";
    exit();
}

if ($student_user_id <= 0) {
    echo "<script>alert('Error: Invalid Student/User ID submitted.'); document.location='issue_book.php';</script>";
    exit();
}

// Set up transaction parameters matching database formats
$issue_date = date('Y-m-d');
$due_date = date('Y-m-for', strtotime('+14 days')); 
$issue_status = 'Issued'; // Matches database 'Issued' text syntax

// ----------------------------------------------------
// 2. EXECUTE DATABASE TRANSACTION
// ----------------------------------------------------
mysqli_begin_transaction($conn); 

try {
    // A. Verify that the book exists and check its availability status
    $sql_check_book = "SELECT current_status FROM book WHERE book_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check_book);
    mysqli_stmt_bind_param($stmt_check, "i", $book_id);
    mysqli_stmt_execute($stmt_check);
    $res_check = mysqli_stmt_get_result($stmt_check);
    
    if ($book_row = mysqli_fetch_assoc($res_check)) {
        if (strtolower($book_row['current_status']) !== 'available') {
            throw new Exception("This book is currently marked as '" . $book_row['current_status'] . "' and cannot be loaned out.");
        }
    } else {
        throw new Exception("The Book ID does not exist in the system.");
    }
    mysqli_stmt_close($stmt_check);

    // B. FIXED: Changed column 'status' to 'issue_status' to match your database schema snapshot
    $sql_issue = "INSERT INTO book_issue (book_id, users_id, issue_date, due_date, issue_status) VALUES (?, ?, ?, ?, ?)";
    $stmt_issue = mysqli_prepare($conn, $sql_issue);
    
    if (!$stmt_issue) {
        throw new Exception("Prepare statement failed: " . mysqli_error($conn));
    }
    
    // Bind types correction string -> book_id (i), users_id (i), issue_date (s), due_date (s), issue_status (s)
    mysqli_stmt_bind_param($stmt_issue, "iisss", $book_id, $student_user_id, $issue_date, $due_date, $issue_status);
    mysqli_stmt_execute($stmt_issue);
    mysqli_stmt_close($stmt_issue);

    // C. UPDATE the book's status to 'On Loan'
    $new_book_status = 'On Loan';
    $sql_update_book = "UPDATE book SET current_status = ? WHERE book_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update_book);
    mysqli_stmt_bind_param($stmt_update, "si", $new_book_status, $book_id);
    mysqli_stmt_execute($stmt_update);
    mysqli_stmt_close($stmt_update);

    // D. Commit all changes to the database
    mysqli_commit($conn);
    
    echo "<script>alert('Book successfully issued! Status updated to On Loan.'); document.location='issue_book.php';</script>";

} catch (Exception $e) {
    // If any steps throw exceptions, cancel everything safely
    mysqli_rollback($conn);
    echo "<script>alert('Error issuing book: " . addslashes($e->getMessage()) . "'); document.location='issue_book.php';</script>";
}
?>
<?php
require_once('db_connect.php');

// Get the book ID from the URL
$bookId = isset($_GET['id']) ? $_GET['id'] : 0;

// Prepare the SQL statement
$sql = "SELECT * FROM book WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Book data found
?>

<?php include_once('./template/header.php'); ?>

<style>
    .book-details-container {
        padding: 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        background-color: #e8f5e9; /* Light green background */
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        font-family: 'Arial', sans-serif;
        color: #333; /* Dark text color */
    }

    .book-details-container .col-md-6 {
        flex: 1 1 50%;
        padding: 20px;
        box-sizing: border-box;
    }

    .book-details-container img.img-fluid {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto 20px;
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .book-details-container img.img-fluid:hover {
        transform: scale(1.03);
    }

    .book-details-container h3 {
        font-size: 2.8em;
        margin-bottom: 20px;
        color: #2e7d32; /* Darker green title color */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        font-weight: 700;
        letter-spacing: -1px;
    }

    .book-details-container p {
        font-size: 1.2em;
        line-height: 1.8;
        color: #555;
        margin-bottom: 15px;
    }

    .book-details-container p strong {
        font-weight: 600;
        color: #2e7d32; /* Darker green for strong elements */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .book-details-container {
            padding: 20px;
        }

        .book-details-container .col-md-6 {
            flex: 1 1 100%;
        }

        .book-details-container {
            flex-direction: column;
            align-items: center;
        }

        .book-details-container h3 {
            font-size: 2.2em;
        }
    }
</style>

<div class="book-details-container">
    <div class="col-md-6">
        <img src="<?php echo $row['book_cover_img']; ?>" class="img-fluid" alt="<?php echo $row['book_name']; ?>">
    </div>
    <div class="col-md-6">
        <h3><?php echo $row['book_name']; ?></h3>
        <p><strong>book_author:</strong> <?php echo $row['book_author']; ?></p>
        <p><strong>ISBN:</strong> <?php echo $row['isbn_no']; ?></p>
        <p><strong>book_Edition:</strong> <?php echo $row['book_edition']; ?></p>
        <p><strong>Shelf_no:</strong> <?php echo $row['shelf_no']; ?></p>
    </div>
</div>

</body>
</html>

<?php
} else {
    // Book not found
    echo "Book not found.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
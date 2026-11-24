<?php
include_once('template/header.php');
require_once('db_connect.php');

session_start();
?>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    img.book-pic {
        max-width: 100px; /* Adjust as needed */
        height: auto;
        display: block;
        margin: 0 auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

</style>

<h2>Books Data</h2>

<table>
    <thead>
        <tr>
            <th>book_id</th>
            <th>book_name</th>
            <th>book_author</th>
            <th>isbn_no</th>
            <th>book_edition</th>
            <th>Shelf_no</th>
           <th> current_status</th>
            <th>book_cover_img</th>
        </tr>
    </thead>
    <tbody>
      <?php
$sql = "SELECT * FROM book";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { // PHP loop starts and defines $row
?>
<tr>
    <td><?php echo $row['book_id']; ?></td>
    <td><?php echo $row['book_name']; ?></td>
    <td><?php echo $row['book_author']; ?></td>
    <td><?php echo $row['isbn_no']; ?></td>
    <td><?php echo $row['book_edition']; ?></td>
    <td><?php echo $row['shelf_no']; ?></td>
    <td><?php echo $row['current_status']; ?></td>
    <td><img class="book-pic" src="<?php echo $row['book_cover_img']; ?>" /></td>
    
    <td>
        <?php
        // $row is available here!
        if ($row['current_status'] == 'Available') {
        ?>
            <a href="issue_book.php?bookid=<?php echo htmlentities($row['book_id']); ?>" 
               class="btn btn-primary btn-sm">
                Issue Book
            </a>
        <?php
        } else {
            // Display status if not available
            echo "<span class='text-danger'>" . htmlentities($row['current_status']) . "</span>";
        }
        ?>
    </td>
    </tr>
<?php
    } // PHP loop ends
    mysqli_free_result($result);
} else {
    // If no results found
    echo "<tr><td colspan='9' style='text-align: center;'>No Results</td></tr>";
}
?>
        
    </tbody>
</table>
<?php include_once('template/footer.php') ?>
<?php
session_start();
require_once('db_connect.php');
include_once('template/header.php');

// Check if the user is logged in and has the required role for adding books
if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 3)) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert-data'])) {
        $book_id = $_POST['book_id'];
        $book_name = $_POST['book_name'];
        $book_author = $_POST['book_author'];
        $isbn_no = $_POST['isbn_no'];
        $book_edition = $_POST['book_edition'];
        $Shelf_no = $_POST['Shelf_no'];

        $book_pic_name = $_FILES['book_pic']['name'];
        $temp_name = $_FILES['book_pic']['tmp_name'];

        $upload_folder = "./assets/img/" . $book_pic_name;

        if (move_uploaded_file($temp_name, $upload_folder)) {

            $sql = "INSERT INTO book (book_id, book_name, book_author, isbn_no, book_edition, Shelf_no, book_cover_img) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt === false) {
                die("Error preparing statement: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "issiiis", $book_id, $book_name, $book_author, $isbn_no, $book_edition, $Shelf_no, $upload_folder);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success mt-3'>New book added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Error executing statement: " . mysqli_stmt_error($stmt) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger mt-3'>Error uploading file.</div>";
        }
    }
    ?>
    <link rel="stylesheet" type="text/css" href="./template/inserte.css">

    <h2 class="section-title">Add New Book</h2>
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="book_id">Book ID:</label>
                <input type="number" name="book_id" id="book_id" required class="form-control">
            </div>
            <div class="form-group">
                <label for="book_name">Book Name:</label>
                <input type="text" name="book_name" id="book_name" required class="form-control">
            </div>
            <div class="form-group">
                <label for="book_author">Book Author:</label>
                <input type="text" name="book_author" id="book_author" required class="form-control">
            </div>
            <div class="form-group">
                <label for="isbn_no">ISBN:</label>
                <input type="number" name="isbn_no" id="isbn_no" required class="form-control">
            </div>
            <div class="form-group">
                <label for="book_edition">Book Edition:</label>
                <input type="number" name="book_edition" id="book_edition" required class="form-control">
            </div>
            <div class="form-group">
                <label for="Shelf_no">Shelf No:</label>
                <input type="number" name="Shelf_no" id="Shelf_no" required class="form-control">
            </div>
            <div class="form-group">
                <label for="current_status">Status:</label>
                <select name="current_status" id="current_status" required class="form-control select-control">
                    <option value="Available">Available</option>
                    <option value="On Loan">On Loan</option>
                    <option value="Lost">Lost</option>
                    <option value="Damaged">Damaged</option>
                </select>
            </div>
            <div class="form-group margin-bottom-large">
                <label for="cover">Book Cover Image:</label>
                <input type="file" name="book_pic" id="cover" required class="form-control">
            </div>
            <button type="submit" name="insert-data" class="btn-submit">Add Book</button>
        </form>
    </div>

    <?php
} elseif (isset($_SESSION['role_id'])) {
    echo "<div class='alert alert-danger mt-3'>You do not have permission to add books.</div>";
} else {
    echo "<div class='alert alert-danger mt-3'>Please log in to add books.</div>";
}
?>

<?php
// Check if the user is logged in and has the required role for CRUD operations
if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {

    include_once('req/read.php');
    $users = read($conn);
    ?>
    <link rel="stylesheet" type="text/css" href="./template/style.css">
    
    <div class="data-container">
        <h2 class="section-title text-left">Data Access</h2>
        <a href="create.php" class="link">Create</a>
        
        <?php if (isset($_GET['success'])) { ?>
            <p class="success">
                <?=htmlspecialchars($_GET['success'])?>
            </p>
        <?php } ?>

        <?php if ($users != 0) { ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>users_ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>role_id</th>
                        <th>Action</th>
                    </tr>   
                </thead>
                <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?=htmlspecialchars($user['users_id'])?></td>
                        <td><?=htmlspecialchars($user['first_name'])?></td>
                        <td><?=htmlspecialchars($user['last_name'])?></td>
                        <td><?=htmlspecialchars($user['email'])?></td>
                        <td><?=htmlspecialchars($user['role_id'])?></td>
                        <td>
                            <a href="update.php?users_id=<?=$user['users_id']?>" class="btn btn-update">Update</a>
                            <a href="req/delete.php?users_id=<?=$user['users_id']?>" class="btn btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php } ?> 
                </tbody>
            </table>
        <?php } ?>
    </div>
<?php } else { ?>
    <p class="error">You are not auther.</p>
<?php } ?>
       
<?php include_once('template/footer.php') ?>
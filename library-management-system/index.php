<?php
include_once('template/header.php');
require_once('db_connect.php');
require_once('./controllers/fetch-books.php');
?>

<style>
    /* Section 1 Styling */
    .section1 {
        position: relative;
        width: 100%;
        height: 600px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
    }

    .section1 img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(60%);
    }

    /* Containers within Section 1 */
    .containers {
        position: relative;
        z-index: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .containers h2 {
        font-size: 3em;
        font-weight: 700;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    }

    .containers .action-button-container {
        margin-top: auto;
        margin-bottom: 50px;
    }

    .containers .action-button-container a {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 15px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .containers .action-button-container a:hover {
        background-color: #0056b3;
    }

    /* Book List Styling */
    .book-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
    }

    /* Book Item Styling */
    .book-item {
        width: 300px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .book-item img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .book-item .book-title {
        font-size: 1.2em;
        margin-bottom: 5px;
    }

    .book-item .book-author,
    .book-item .book-edition {
        font-size: 0.9em;
        margin-bottom: 5px;
    }

    .book-item .view-book-btn {
        padding: 8px 15px;
        font-size: 0.9em;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .book-item {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .book-item {
            width: 100%;
        }
    }
</style>

<section class="section1">
    <img src="assets/img/hero-bg.jpg" alt="Hero Background">
    <div class="containers">
        <h2>Learning Today,<br>Leading Tomorrow</h2>
        <div class="action-button-container">
            <a href="login.php">Get Started</a>
        </div>
    </div>
</section>

<div class="book-list">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="book-item">
            <img src="<?php echo $row['book_cover_img']; ?>" alt="<?php echo $row['book_name']; ?>">
            <h5 class="book-title"><?php echo $row['book_name']; ?></h5>
            <p class="book-author">Author: <?php echo $row['book_author']; ?></p>
            <p class="book-edition">Edition: <?php echo $row['book_edition']; ?></p>
            <a href="book-details.php?id=<?php echo $row['book_id']; ?>" class="btn btn-primary view-book-btn">View Book</a>
        </div>
    <?php endwhile; ?>
</div>

<?php
include_once('template/footer.php');
?>

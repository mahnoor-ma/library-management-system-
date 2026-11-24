<?php
/* Start the session */
session_start();
// check if session not exist
if (!isset($_SESSION['id'])) {
    // redirect to login 
    header("location: login.php");
    exit(); // Always use exit() after header() to stop script execution
}

// Retrieve user info from session for display (assuming these are set during login/registration)
$user_first_name = $_SESSION['first_name'] ?? 'Admin'; 
$user_email = $_SESSION['email'] ?? 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f5f9, #e1e8f0);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        #main {
            width: 90%;
            max-width: 900px; /* Increased max width */
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        #header.dashboard {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #header.dashboard h1 {
            margin: 0;
            font-size: 2em;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info span {
            margin-right: 15px;
            font-weight: 500;
            /* Added text-shadow for better contrast against gradient */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); 
        }

        .user-info a {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .user-info a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        #content {
            padding: 30px;
        }

        #content h2 {
            margin-bottom: 25px;
            color: #4a5568;
            font-weight: 600;
            border-bottom: 2px solid #e1e8f0;
            padding-bottom: 10px;
        }

        .nav-list {
            padding: 0;
            display: flex; /* Display links in a row */
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .nav-item {
            list-style: none;
            /* Removed margin-bottom */
        }

        .nav-link {
            text-decoration: none;
            color: #3182ce;
            padding: 12px 25px;
            border-radius: 8px;
            background: #e6f0ff;
            transition: background 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            display: inline-block;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .nav-link:hover, .nav-item.active .nav-link {
            background: #b8d2f0;
            color: #2c5282;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div id="main">
        <div id="header" class="dashboard">
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                <!-- Dynamic greeting using the logged-in user's name -->
                <span>Hello, <?php echo htmlspecialchars($user_first_name); ?></span>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div id="content">
            <h2>Quick Actions & Navigation</h2>

            <ul class="nav-list">
                <li class="nav-item">
                    <!-- Link to the file that shows the list of books to be issued -->
                    <a class="nav-link" href="manage_issue_book.php">Manage Books & Issue</a>
                </li>
                <li class="nav-item">
                    <!-- Link to a page for returning books (assuming you have one) -->
                    <a class="nav-link" href=" issue-list.php">Return Books</a>
                </li>
                <li class="nav-item">
                    <!-- Link to a page for adding new books (assuming you have one) -->
                    <a class="nav-link" href="inserte-records.php">Add New Book</a>
                </li>
                <li class="nav-item">
                    <!-- Link to manage all users (important for an admin) -->
                    <a class="nav-link" href="inserte-records.php">Manage Users</a>
                </li>
                <li class="nav-item">
                    <!-- Link to the main public index/home page -->
                    <a class="nav-link" href="index.php">View Public Site</a>
                </li>
            </ul>

            <!-- You can add dynamic statistics (Total Books, Issued Count, etc.) here later -->
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e1e8f0;">
                <p><strong>Logged in as:</strong> <?php echo htmlspecialchars($user_email); ?></p>
                <p style="color: #6a11cb;">This is the central control panel for the Library Management System.</p>
            </div>

        </div>
    </div>
</body>

</html>
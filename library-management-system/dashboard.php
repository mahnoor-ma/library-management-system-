

<?php
/* Start the session */
session_start();
// check if session not exist
if (!isset($_SESSION['id'])) {
  // redirect to login 
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
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
            width: 80%;
            max-width: 800px;
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
        }

        .nav-item {
            list-style: none;
            margin-bottom: 15px;
        }

        .nav-link {
            text-decoration: none;
            color: #3182ce;
            padding: 10px 20px;
            border-radius: 8px;
            background: #e6f0ff;
            transition: background 0.3s ease, color 0.3s ease;
            display: inline-block;
        }

        .nav-link:hover, .nav-item.active .nav-link {
            background: #b8d2f0;
            color: #2c5282;
        }
    </style>
</head>

<body>
    <div id="main">
        <div id="header" class="dashboard">
            <h1>Dashboard</h1>
            <div class="user-info">
                <span>Hello</span>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div id="content">
            <h2>Welcome to Dashboard</h2>

            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>

        </div>
    </div>
</body>

</html>
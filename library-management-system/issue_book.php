 <?php
session_start();

// Check if admin is logged in (using 'id' as per your early authentication layout)
if (!isset($_SESSION['id'])) {
    header("location: login.php");
    exit();
}

$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans">

    <div class="card bg-white p-8 rounded-xl w-full max-w-md border border-gray-200">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Issue a Book</h1>
        <p class="text-center text-gray-500 mb-6">Process a book checkout transaction.</p>

        <?php if ($message): ?>
            <div class="p-4 mb-6 rounded-lg <?php echo $message['type'] === 'success' ? 'bg-green-100 text-green-700 border border-green-400' : 'bg-red-100 text-red-700 border border-red-400'; ?>" role="alert">
                <p class="font-semibold"><?php echo ucfirst($message['type']); ?>:</p>
                <p><?php echo htmlspecialchars($message['text']); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="manage_issue_book.php" class="space-y-6">
            
            <div>
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Book ID:</label>
                <input 
                    type="number" 
                    id="book_id" 
                    name="book_id" 
                    required 
                    min="1"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                    placeholder="e.g., 101"
                >
            </div>

            <div>
                <label for="users_id" class="block text-sm font-medium text-gray-700 mb-1">Student / User ID:</label>
                <input 
                    type="number" 
                    id="users_id" 
                    name="users_id" 
                    required 
                    min="1"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                    placeholder="e.g., 5001"
                >
            </div>

            <button 
                type="submit" 
                name="issue_book_submit"
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out transform hover:scale-[1.01]"
            >
                Confirm Issue Transaction
            </button>

            <div class="text-center pt-2">
                <a href="Admin-dashboard.php" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    &larr; Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</body>
</html>
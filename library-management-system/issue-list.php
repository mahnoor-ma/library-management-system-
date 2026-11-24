<?php
/* Start the session and include DB connection */
session_start();
// Include your database connection file, which uses the variable $conn
require_once('db_connect.php'); 

// Check if admin is logged in
if (!isset($_SESSION['id'])) {
    header("location: login.php");
    exit();
}

// ----------------------------------------------------
// 1. FETCH CURRENTLY ISSUED BOOK RECORDS
// ----------------------------------------------------
$sql = "SELECT 
            bi.issue_id, 
            bi.book_id,
            b.book_name, 
            u.users_id AS user_id_display, 
            bi.issue_date, 
            bi.due_date,
            bi.issue_status
        FROM 
            book_issue bi
        JOIN 
            book b ON bi.book_id = b.book_id
        JOIN 
            users u ON bi.users_id = u.users_id 
        WHERE 
            bi.issue_status IN ('issued', 'overdue')
        ORDER BY 
            bi.issue_date DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching issued books: " . mysqli_error($conn));
}

$issued_records = [];
while ($row = mysqli_fetch_assoc($result)) {
    $issued_records[] = $row;
}
mysqli_free_result($result);

// Function to calculate if the book is overdue
function isOverdue($due_date) {
    $due = strtotime($due_date);
    $now = strtotime(date('Y-m-d'));
    return $now > $due;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books & Return Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f5f9, #e1e8f0);
            margin: 0;
            padding: 0;
            color: #333;
            min-height: 100vh;
        }
        
        #container {
            width: 95%;
            max-width: 1200px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #4a5568;
            border-bottom: 2px solid #e1e8f0;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .action-link {
            text-decoration: none;
            background: #6a11cb;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
            display: inline-block;
            margin-bottom: 20px;
            margin-right: 10px;
        }

        .action-link:hover {
            background: #500cb4;
        }

        /* Table Styling */
        .issued-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .issued-table th, .issued-table td {
            padding: 15px 10px;
            text-align: left;
            border-bottom: 1px solid #e1e8f0;
        }

        .issued-table th {
            background-color: #f8f9fa;
            color: #2d3748;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        
        .issued-table tr:nth-child(even) {
            background-color: #fefefe;
        }

        .issued-table tr {
            transition: all 0.4s ease; /* Smooth transition when fading out */
        }

        .issued-table tr:hover {
            background-color: #edf2f7;
        }

        /* Status Colors */
        .status-due {
            color: #2563eb;
            font-weight: 600;
        }

        .status-overdue {
            color: #dc2626;
            font-weight: 700;
        }

        /* Return Button Styling */
        .return-btn {
            background: #10b981;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9em;
            transition: background 0.3s ease;
        }

        .return-btn:hover {
            background: #059669;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .modal-buttons button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        #confirm-yes {
            background: #10b981;
            color: white;
        }
        #confirm-no {
            background: #f0f0f0;
            color: #333;
        }
    </style>
</head>

<body>
    <div id="container">
        <h1>Issued Books Pending Return</h1>

        <a href="Admin-dashboard.php" class="action-link">← Back to Dashboard</a>
        <a href="show-records.php" class="action-link" style="background: #3b82f6;">View All Books (Issue)</a>

        <table class="issued-table">
            <thead>
                <tr>
                    <th>Issue ID</th>
                    <th>Book Title</th>
                    <th>Book ID</th>
                    <th>Issued To (User ID)</th> 
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="issued-books-tbody">
                <?php if (count($issued_records) > 0): ?>
                    <?php foreach ($issued_records as $record): ?>
                        <?php $is_overdue = isOverdue($record['due_date']); ?>
                        <tr id="row-<?php echo $record['issue_id']; ?>">
                            <td><?php echo htmlspecialchars($record['issue_id']); ?></td>
                            <td><?php echo htmlspecialchars($record['book_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['book_id']); ?></td> 
                            <td><?php echo htmlspecialchars($record['user_id_display']); ?></td>
                            <td><?php echo htmlspecialchars($record['issue_date']); ?></td>
                            <td>
                                <span class="<?php echo $is_overdue ? 'status-overdue' : 'status-due'; ?>">
                                    <?php echo htmlspecialchars($record['due_date']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="<?php echo $is_overdue ? 'status-overdue' : 'status-due'; ?>">
                                    <?php echo $is_overdue ? 'OVERDUE' : htmlspecialchars($record['issue_status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="#" 
                                    data-issueid="<?php echo $record['issue_id']; ?>"
                                    data-bookid="<?php echo $record['book_id']; ?>"
                                    data-booktitle="<?php echo htmlspecialchars($record['book_name']); ?>"
                                    class="return-btn js-return-book">
                                    Return Book
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="no-records-row">
                        <td colspan="8" style="text-align: center; padding: 20px;">No books are currently issued.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="modal-overlay" id="confirm-modal">
        <div class="modal-content">
            <p id="modal-message">Confirm book return?</p>
            <div class="modal-buttons">
                <button id="confirm-yes">Yes, Return</button>
                <button id="confirm-no">No, Cancel</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('confirm-modal');
            const modalMessage = document.getElementById('modal-message');
            const confirmYes = document.getElementById('confirm-yes');
            const confirmNo = document.getElementById('confirm-no');
            
            let targetUrl = '';
            let targetIssueId = '';

            // Catch row button execution click behaviors
            document.querySelectorAll('.js-return-book').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    targetIssueId = this.getAttribute('data-issueid');
                    const bookId = this.getAttribute('data-bookid');
                    const bookTitle = this.getAttribute('data-booktitle');

                    modalMessage.textContent = 'Confirm book return for: ' + bookTitle + '?';
                    targetUrl = 'manage_issue_book.php?issueid=' + targetIssueId + '&bookid=' + bookId;

                    modal.style.display = 'flex';
                });
            });

            // AJAX handling routine triggered when confirmed
            confirmYes.addEventListener('click', function() {
                modal.style.display = 'none';

                if (targetUrl && targetIssueId) {
                    // Send async background processing verification update request to backend handler
                    fetch(targetUrl)
                        .then(response => {
                            // Find target element container instance directly on page structure map
                            const targetRow = document.getElementById('row-' + targetIssueId);
                            if (targetRow) {
                                // Apply stylistic graphical visibility fade sequence configurations
                                targetRow.style.opacity = '0';
                                targetRow.style.transform = 'scale(0.95)';
                                
                                setTimeout(() => {
                                    targetRow.remove(); // Safely eliminate data row visually from frontend DOM
                                    
                                    // Check if the table is now empty to display fallback placeholder text
                                    const tbody = document.getElementById('issued-books-tbody');
                                    if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                        tbody.innerHTML = `
                                            <tr id="no-records-row">
                                                <td colspan="8" style="text-align: center; padding: 20px;">No books are currently issued.</td>
                                            </tr>`;
                                    }
                                }, 400);
                            }
                        })
                        .catch(error => {
                            console.error('Error executing network action processing safely:', error);
                            alert('Communication problem updating server entries. Please refresh and try again.');
                        });
                }
            });

            confirmNo.addEventListener('click', function() {
                modal.style.display = 'none';
                targetUrl = '';
                targetIssueId = '';
            });

            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    targetUrl = '';
                    targetIssueId = '';
                }
            });
        });
    </script>
</body>
</html>
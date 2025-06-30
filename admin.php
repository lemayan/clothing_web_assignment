<?php
include 'config.php';

$customer_count = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
$message_count = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];

$customers = $conn->query("SELECT * FROM customers ORDER BY created_at DESC LIMIT 10");

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 10");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Lemayan Fashion House</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-panel {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: #2d5a27;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #f4a261;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .data-table th {
            background: #2d5a27;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .data-table tr:hover {
            background: #f5f5f5;
        }
        .section {
            margin: 30px 0;
        }
        .section h2 {
            color: #2d5a27;
            border-bottom: 2px solid #f4a261;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/kenyan-logo.jpg" alt="Lemayan Fashion House Logo" class="logo">
        <h1>Admin Panel - Lemayan Fashion House</h1>
        <nav>
            <a href="index.html">Back to Website</a>
        </nav>
    </header>

    <div class="admin-panel">
        <h1>Dashboard</h1>
        
        <div class="stats">
            <div class="stat-box">
                <div class="stat-number"><?php echo $customer_count; ?></div>
                <div>Registered Customers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?php echo $message_count; ?></div>
                <div>Contact Messages</div>
            </div>
        </div>

        <div class="section">
            <h2>Recent Customer Registrations</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Interests</th>
                        <th>Registration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($customers->num_rows > 0): ?>
                        <?php while ($customer = $customers->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                                <td><?php echo htmlspecialchars($customer['city']); ?></td>
                                <td><?php echo htmlspecialchars($customer['interests']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($customer['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No customers registered yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Recent Contact Messages</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($messages->num_rows > 0): ?>
                        <?php while ($message = $messages->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['phone']); ?></td>
                                <td><?php echo htmlspecialchars(substr($message['message'], 0, 100)) . (strlen($message['message']) > 100 ? '...' : ''); ?></td>
                                <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No messages received yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Lemayan Fashion House. All rights reserved.</p>
    </footer>
</body>
</html>

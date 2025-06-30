<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));
    
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $sql = "INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $phone, $message);
        
        if ($stmt->execute()) {
            $success = "Thank you for your message! We will get back to you soon.";
        } else {
            $error = "Sorry, there was an error sending your message. Please try again.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Lemayan Fashion House</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/kenyan-logo.jpg" alt="Lemayan Fashion House Logo" class="logo">
        <h1>Lemayan Fashion House</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="about.html">About Us</a>
            <a href="products.html">Products</a>
            <a href="gallery.html">Gallery</a>
            <a href="contact.php" class="active">Contact Us</a>
            <a href="register.php">Register</a>
        </nav>
    </header>

    <main>
        <h2>Contact Us</h2>
        <p>We would love to hear from you! Send us a message and we will reply quickly.</p>
        
        <?php if (isset($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="contact-info">
            <h3>Contact Information</h3>
            <p><strong>Location:</strong> Lemayan, Nairobi, Kenya</p>
            <p><strong>Phone:</strong> +254 700 123 456</p>
            <p><strong>Email:</strong> info@lemayan.co.ke</p>
            <p><strong>Opening Hours:</strong></p>
            <ul>
                <li>Monday - Friday: 8:00 AM - 6:00 PM</li>
                <li>Saturday: 9:00 AM - 5:00 PM</li>
                <li>Sunday: Closed</li>
            </ul>
        </div>
        
        <div class="contact-form">
            <h3>Send Message</h3>
            <form method="POST" action="contact.php">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone">
                
                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                
                <button type="submit">Send Message</button>
            </form>
        </div>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                
                <label for="message">Your Message: *</label>
                <textarea id="message" name="message" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                
                <button type="submit">Send Message</button>
            </form>
        </div>
        
        <div class="location">
            <h3>Our Location</h3>
            <p>You can find our shop at the main market in Lemayan, near the bus station. If you come by car, there is parking space in front of the shop.</p>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Lemayan Fashion House. All rights reserved.</p>
    </footer>
</body>
</html>

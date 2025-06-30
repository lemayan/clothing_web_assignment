<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = intval($_POST['age']);
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $city = mysqli_real_escape_string($conn, trim($_POST['city']));
    $county = mysqli_real_escape_string($conn, trim($_POST['county']));
    $postal_code = mysqli_real_escape_string($conn, trim($_POST['postal_code']));
    
    $interests = isset($_POST['interests']) ? implode(', ', $_POST['interests']) : '';
    
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $sms_updates = isset($_POST['sms_updates']) ? 1 : 0;
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($address) || empty($city)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif ($age < 1 || $age > 120) {
        $error = "Please enter a valid age.";
    } else {
        $check_sql = "SELECT email FROM customers WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "This email address is already registered.";
        } else {
            $sql = "INSERT INTO customers (first_name, last_name, email, phone, gender, age, address, city, county, postal_code, interests, newsletter, sms_updates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssisssssii", $first_name, $last_name, $email, $phone, $gender, $age, $address, $city, $county, $postal_code, $interests, $newsletter, $sms_updates);
            
            if ($stmt->execute()) {
                $success = "Registration successful! Welcome to Lemayan Fashion House family.";
                // Clear form data
                $_POST = array();
            } else {
                $error = "Sorry, there was an error with your registration. Please try again.";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration - Lemayan Fashion House</title>
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
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row > div {
            flex: 1;
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
            <a href="contact.php">Contact Us</a>
            <a href="register.php" class="active">Register</a>
        </nav>
    </header>

    <main>
        <h2>Customer Registration</h2>
        <p>Join our family and get special offers and updates about new collections!</p>
        
        <?php if (isset($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="benefits">
            <h3>Why Register With Us?</h3>
            <ul>
                <li>Get 10% discount on your first purchase</li>
                <li>Receive news about new arrivals</li>
                <li>Special offers only for registered customers</li>
                <li>Free delivery for orders above 2000 KES</li>
                <li>Birthday discounts and special gifts</li>
            </ul>
        </div>

        <div class="register-form">
            <h3>Registration Form</h3>
            <form method="POST" action="register.php">
                <div class="form-row">
                    <div>
                        <label for="first_name">First Name: *</label>
                        <input type="text" id="first_name" name="first_name" required value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                    </div>
                    <div>
                        <label for="last_name">Last Name: *</label>
                        <input type="text" id="last_name" name="last_name" required value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                    </div>
                </div>

                <label for="email">Email Address: *</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

                <label for="phone">Phone Number: *</label>
                <input type="tel" id="phone" name="phone" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">

                <div class="form-row">
                    <div>
                        <label for="gender">Gender: *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="age">Age: *</label>
                        <input type="number" id="age" name="age" min="1" max="120" required value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>">
                    </div>
                </div>

                <label for="address">Address: *</label>
                <textarea id="address" name="address" rows="3" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>

                <div class="form-row">
                    <div>
                        <label for="city">City: *</label>
                        <input type="text" id="city" name="city" required value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                    </div>
                    <div>
                        <label for="county">County:</label>
                        <input type="text" id="county" name="county" value="<?php echo isset($_POST['county']) ? htmlspecialchars($_POST['county']) : ''; ?>">
                    </div>
                </div>

                <label for="postal_code">Postal Code:</label>
                <input type="text" id="postal_code" name="postal_code" value="<?php echo isset($_POST['postal_code']) ? htmlspecialchars($_POST['postal_code']) : ''; ?>">

                <label>What are you interested in? (Select all that apply)</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="mens_wear" name="interests[]" value="Men's Wear" <?php echo (isset($_POST['interests']) && in_array('Men\'s Wear', $_POST['interests'])) ? 'checked' : ''; ?>>
                    <label for="mens_wear">Men's Wear</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="womens_wear" name="interests[]" value="Women's Wear" <?php echo (isset($_POST['interests']) && in_array('Women\'s Wear', $_POST['interests'])) ? 'checked' : ''; ?>>
                    <label for="womens_wear">Women's Wear</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="childrens_wear" name="interests[]" value="Children's Wear" <?php echo (isset($_POST['interests']) && in_array('Children\'s Wear', $_POST['interests'])) ? 'checked' : ''; ?>>
                    <label for="childrens_wear">Children's Wear</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="traditional_wear" name="interests[]" value="Traditional Wear" <?php echo (isset($_POST['interests']) && in_array('Traditional Wear', $_POST['interests'])) ? 'checked' : ''; ?>>
                    <label for="traditional_wear">Traditional Wear</label>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="newsletter" name="newsletter" value="1" <?php echo (isset($_POST['newsletter']) && $_POST['newsletter'] == '1') ? 'checked' : ''; ?>>
                    <label for="newsletter">Subscribe to our newsletter</label>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="sms_updates" name="sms_updates" value="1" <?php echo (isset($_POST['sms_updates']) && $_POST['sms_updates'] == '1') ? 'checked' : ''; ?>>
                    <label for="sms_updates">Receive SMS updates about new products</label>
                </div>

                <button type="submit">Register Now</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Lemayan Fashion House. All rights reserved.</p>
    </footer>
</body>
</html>

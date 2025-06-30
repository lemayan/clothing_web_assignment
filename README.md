# Lemayan Fashion House Website

A simple fashion website for Kenyan clothing brand.

## Setup Instructions

1. Install XAMPP
2. Copy all files to htdocs folder
3. Start Apache and MySQL in XAMPP
4. Open browser and go to: http://localhost/ASSIGNMENT1/setup_database.php
5. Click link to go to website

## Files

- index.html - Home page
- about.html - About us page  
- products.html - Products page
- gallery.html - Gallery page
- contact.php - Contact form with database
- register.php - Customer registration with database
- admin.php - View customer data and messages
- config.php - Database connection
- setup_database.php - Creates database tables
- style.css - Website styling
- script.js - Website functions
- images/ - All website images

## Admin Panel

Go to: http://localhost/ASSIGNMENT1/admin.php
View all customer registrations and contact messages.

## Database

Database name: lemayan_fashion
Tables: customers, contact_messages

Created: June 2025

- **Frontend**: Responsive HTML/CSS/JavaScript website
- **Backend**: PHP with MySQL database integration
- **Forms**: Contact form and customer registration with database storage
- **Admin Panel**: View registered customers and contact messages

## Pages

1. **index.html** - Home page
2. **about.html** - About us page
3. **products.html** - Products catalog
4. **gallery.html** - Photo gallery
5. **contact.php** - Contact form with PHP backend
6. **register.php** - Customer registration with PHP backend
7. **admin.php** - Admin panel to view data

## XAMPP Setup Instructions

### 1. Install XAMPP
- Download and install XAMPP from https://www.apachefriends.org/
- Start Apache and MySQL services from XAMPP Control Panel

### 2. Setup Database
1. Copy all project files to `C:\xampp\htdocs\lemayan_fashion\`
2. Open browser and go to: `http://localhost/lemayan_fashion/setup_database.php`
3. This will create the database and tables automatically

### 3. Access the Website
- **Main Website**: `http://localhost/lemayan_fashion/index.html`
- **Contact Form**: `http://localhost/lemayan_fashion/contact.php`
- **Registration**: `http://localhost/lemayan_fashion/register.php`
- **Admin Panel**: `http://localhost/lemayan_fashion/admin.php`

## Database Structure

### Customers Table
- id (Primary Key)
- first_name, last_name
- email (Unique)
- phone, gender, age
- address, city, county, postal_code
- interests (comma-separated)
- newsletter, sms_updates (boolean)
- created_at (timestamp)

### Contact Messages Table
- id (Primary Key)
- name, email, phone
- message
- created_at (timestamp)

## File Structure

```
lemayan_fashion/
├── index.html
├── about.html
├── products.html
├── gallery.html
├── contact.php
├── register.php
├── admin.php
├── config.php (database connection)
├── setup_database.php (database setup)
├── style.css
├── script.js
└── images/
    └── (all product and branding images)
```

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Server**: Apache (via XAMPP)

## Features

### Contact Form
- Stores customer messages in database
- Email validation
- Success/error messages
- Form data retention on errors

### Customer Registration
- Complete customer information collection
- Email uniqueness validation
- Interest categories selection
- Newsletter and SMS preferences
- Registration confirmation

### Admin Panel
- View customer statistics
- Recent customer registrations
- Recent contact messages
- Responsive dashboard

## Security Features

- SQL injection prevention using prepared statements
- Input sanitization
- Email validation
- XSS protection with htmlspecialchars()

## Future Enhancements

- User authentication system
- Email notifications
- Order management
- Payment integration
- Product management admin panel
- Customer login portal

---

**Created by**: Lemayan Fashion House Development Team  
**Date**: June 2025  
**Version**: 2.0 (PHP Backend Integration)

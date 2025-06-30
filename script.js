document.addEventListener('DOMContentLoaded', function() {
    setupProductFilters();
    setupContactForm();
    setupRegistrationForm();
});

function showAll() {
    var sections = document.querySelectorAll('.products-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = 'block';
    }
    updateActiveButton('all');
}

function showCategory(category) {
    var sections = document.querySelectorAll('.products-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = 'none';
    }
    
    var targetSection = document.getElementById(category);
    if (targetSection) {
        targetSection.style.display = 'block';
    }
    
    updateActiveButton(category);
}

function updateActiveButton(activeCategory) {
    var buttons = document.querySelectorAll('.filter-btn');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('active');
    }
    
    if (activeCategory === 'all') {
        var allButton = document.querySelector('.filter-btn[onclick="showAll()"]');
        if (allButton) allButton.classList.add('active');
    } else {
        var categoryButton = document.querySelector('.filter-btn[onclick="showCategory(\'' + activeCategory + '\')"]');
        if (categoryButton) categoryButton.classList.add('active');
    }
}

function setupProductFilters() {
    showAll();
}

function setupContactForm() {
    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var message = document.getElementById('message').value;
            
            if (name === '' || email === '' || message === '') {
                alert('Please fill in all fields!');
                return;
            }
            
            alert('Thank you ' + name + '! Your message has been sent. We will reply to ' + email + ' soon.');
            
            contactForm.reset();
        });
    }
}

function setupRegistrationForm() {
    var regForm = document.getElementById('registrationForm');
    if (regForm) {
        regForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            var fullName = document.getElementById('fullName').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var location = document.getElementById('location').value;
            var age = document.getElementById('age').value;
            var gender = document.getElementById('gender').value;
            
            if (fullName === '' || email === '' || phone === '' || location === '' || age === '' || gender === '') {
                alert('Please fill in all required fields!');
                return;
            }
            
            if (!email.includes('@') || !email.includes('.')) {
                alert('Please enter a valid email address!');
                return;
            }
            
            if (age < 18 || age > 100) {
                alert('Age must be between 18 and 100!');
                return;
            }
            
            saveCustomer(fullName, email, phone, location, age, gender);
            
            showRegistrationSuccess();
            
            regForm.reset();
        });
    }
}

function saveCustomer(name, email, phone, location, age, gender) {
    var customers = localStorage.getItem('customers');
    if (customers) {
        customers = JSON.parse(customers);
    } else {
        customers = [];
    }
    
    var newCustomer = {
        name: name,
        email: email,
        phone: phone,
        location: location,
        age: age,
        gender: gender,
        date: new Date().toLocaleDateString()
    };
    
    customers.push(newCustomer);
    
    localStorage.setItem('customers', JSON.stringify(customers));
    
    console.log('Customer saved:', newCustomer);
}

function showRegistrationSuccess() {
    var messageDiv = document.getElementById('registrationMessage');
    if (messageDiv) {
        messageDiv.innerHTML = '<p style="color: green; padding: 15px; background: #e8f5e8; border-radius: 5px; margin-top: 20px;">✓ Registration successful! Thank you for joining Lemayan Fashion House. We will contact you soon with special offers!</p>';
        messageDiv.style.display = 'block';
        
        setTimeout(function() {
            messageDiv.style.display = 'none';
        }, 5000);
    }
}

function openImage(imageSrc) {
    window.open(imageSrc, '_blank');
}

function getAllCustomers() {
    var customers = localStorage.getItem('customers');
    if (customers) {
        return JSON.parse(customers);
    }
    return [];
}

function showCustomerStats() {
    var customers = getAllCustomers();
    console.log('Total registered customers: ' + customers.length);
    if (customers.length > 0) {
        console.log('Latest customer:', customers[customers.length - 1]);
    }
}

function clearAllCustomers() {
    localStorage.removeItem('customers');
    console.log('All customer data cleared!');
}

document.addEventListener('click', function(e) {
    if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
        e.preventDefault();
        var targetId = e.target.getAttribute('href').substring(1);
        var targetElement = document.getElementById(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

function toggleMenu() {
    var menu = document.querySelector('.menu');
    if (menu) {
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }
}

setTimeout(function() {
    var customers = getAllCustomers();
    if (customers.length > 0) {
        console.log('Welcome to Lemayan Fashion House!');
        console.log('We have ' + customers.length + ' registered customers.');
        console.log('Type showCustomerStats() in console to see details.');
    }
}, 1000);

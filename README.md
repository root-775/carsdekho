# CarsDekho Clone (PHP + MySQL + Bootstrap)

A responsive **CarsDekho-style homepage** built using **PHP, MySQL, and Bootstrap 5**, with a **simple Admin Panel** to manage header content, banners, and car listings (Most Searched & Latest).

---

## ✨ Features

### Frontend (User Side)

* Responsive Bootstrap 5 layout
* Header with logo & contact details
* Banner/hero slider
* Most Searched Cars section
* Latest Cars section
* Footer with contact & newsletter
* Mobile-friendly design

### Admin Panel

* Secure admin login
* Manage Header (site name, logo, contact info)
* Manage Banners (Add / Update / Delete)
* Manage Banner
* Manage Cars

  * Upload car images
  * Mark cars as **Most Searched** or **Latest**
* Image upload with validation

---

## 🛠 Tech Stack

* **Frontend:** HTML5, CSS3, Bootstrap 5
* **Backend:** PHP (Core PHP)
* **Database:** MySQL
* **Server:** Apache ( WAMP )

---

## 🗄 Database Tables

* `admins`
* `site_settings`
* `banners`
* `cars`
* `footer_settings`

> Database schema is provided in **database.sql**

---

## 🚀 Installation & Setup

### 1️⃣ Clone or Download

```
git clone https://github.com/root-775/carsdekho.git
```

OR extract the ZIP into your server directory.

---

### 2️⃣ Setup Database

1. Open **phpMyAdmin**
2. Create a database (e.g. `carsdekho_db`)
3. Import `database.sql`

---

### 3️⃣ Configure Database Connection

Edit `includes/db.php`

```php
$host = "localhost";
$db   = "carsdekho_db";
$user = "root";
$pass = "";
```

---

### 4️⃣ Run the Project

* Start Apache & MySQL
* Open browser and visit:

```
http://localhost/carsdekho/
```

---

## 🔐 Admin Login

```
URL: http://localhost/carsdekho/admin/login.php
Username: admin
Password: admin123
```

> (Change credentials after first login)

---

## 📸 Image Upload Rules

* Allowed formats: JPG, PNG, JPEG, WEBP
* Max size: 2MB
* Images stored in `/uploads/`

---

## 📱 Responsive Design

* Desktop: 4 cards per row
* Tablet: 2 cards per row
* Mobile: 1 card per row
* Uses Bootstrap grid system

---

## 🔒 Security Notes

* Passwords stored using `password_hash()`
* Admin pages protected by session
* Prepared statements to prevent SQL Injection
* File upload validation

---

## 🧩 Future Enhancements

* Car details page
* Search & filter
* User login & wishlist
* API integration

---

## 📄 License

This project is for **educational purposes only**.

---

## 🙌 Author

Developed by **Amit Kumar Gupta**
For learning PHP, MySQL & Bootstrap full-stack development.

---

⭐ If you like this project, give it a star!

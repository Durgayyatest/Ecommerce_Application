# Ecommerce App

## Overview
This is a simple PHP-based ecommerce web application that allows users to browse products, add them to a cart, and place orders. It also includes an admin panel for managing products.

---

## Features

### User Features
- **User Registration & Login**: Users can register and log in securely. Passwords are hashed for security.
- **User Dashboard**: After login, users access a dashboard with navigation to products, cart, and order history.
- **Browse Products**: Users can view all available products with images, descriptions, and prices.
- **Add to Cart**: Users can add products to their cart and adjust quantities.
- **View Cart**: Users can view, update, and remove items from their cart.
- **Place Order**: Users can place orders for items in their cart. Orders are saved in the database.
- **Order Confirmation**: After placing an order, users see a confirmation with the total amount.
- **Logout**: Users can securely log out, ending their session.

### Admin Features
- **Admin Registration & Login**: Admins can register and log in securely.
- **Admin Dashboard**: Admins access a dashboard to manage products.
- **Add Product**: Admins can add new products with name, price, description, and image upload.
- **Manage Products**: Admins can view all products and delete them if needed. Deleting a product also removes its image from the server.
- **Logout**: Admins can securely log out, ending their session.

---

## File Structure
- `index.php` - Main landing page showing products and navigation.
- `admin/` - Admin panel files (login, register, dashboard, add/manage products, logout).
- `pages/` - User-facing pages (login, register, dashboard, view products, cart, place order, logout).
- `includes/db.php` - Database connection file (PDO, MySQL).
- `CSS/style.css` - Main stylesheet.

---

## Database
- The app uses a MySQL database named `ecommerce`.
- Connection details are in `includes/db.php` (default: user `root`, no password).
- Main tables expected: `users`, `admins`, `products`, `orders`.

---

## How to Run
1. Place the project in your web server directory (e.g., `htdocs` for XAMPP).
2. Import the required database schema (not included here; create tables for users, admins, products, orders).
3. Update database credentials in `includes/db.php` if needed.
4. Access the app via your browser (e.g., `http://localhost/ecommerce_app/`).

---

## Notes
- Product images are stored in `admin/uploads/`.
- Sessions are used for authentication and cart management.
- For development, error reporting is enabled in some files.

---

## Author
- [Vijay Durgayya] 

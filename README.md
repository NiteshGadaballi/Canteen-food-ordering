# 🍔 Food Ordering System - Cart and Order Management

This project implements a **Cart** and **Order Management** system for an online food ordering website. The system allows users to add food items to their cart, view cart details, and place an order. Key features include:

## 📦 Cart Management:
- Users can view the list of products added to their cart, including product name, quantity, price, and total amount.
- Users can **remove items** from the cart by clicking the **"Remove"** button, which updates the cart in the database.

## 🛒 Order Placement:
- After reviewing the cart, users can place an order by clicking the **"Place Order"** button. This action creates a new order in the `orders` table and stores the details of each cart item in the `order_details` table.
- The total amount for the order is calculated based on the items in the cart.
- After the order is placed, the cart is **cleared**, and the user is redirected to the **payment page** to complete the transaction.

## 🔒 Database Interaction:
- The project uses **MySQL** to store product, cart, order, and order details data.
- **Prepared statements** are used to ensure secure interaction with the database, protecting against SQL injection.

## 📁 Files Involved:
- **cart.php** – Displays the cart and manages the removal of items and order placement.
- **payment.php** – Redirects to the payment page after order placement.
- **db.php** – Establishes a connection to the MySQL database.

---

### 🚀 Features to Implement:
- **User Authentication**: Allow users to log in and register.
- **Product Listing**: Display products for users to add to their cart.
- **Order History**: Allow users to view their past orders.

---

### 💻 Technologies Used:
- **PHP** – Server-side scripting language.
- **MySQL** – Database for storing products, orders, and cart data.
- **HTML/CSS** – Front-end for displaying the cart and order details.

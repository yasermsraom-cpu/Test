==========================================
SAMAK - Fish Marketplace
Diploma Graduation Project
==========================================

LANGUAGES USED
- HTML5
- CSS3
- JavaScript
- PHP (server-side)
- MySQL (database)

==========================================
INSTALLATION (XAMPP / WAMP)
==========================================

1) Copy the whole "samak" folder into your XAMPP "htdocs" directory:
      C:\xampp\htdocs\samak

2) Start Apache and MySQL from XAMPP control panel.

3) Open phpMyAdmin in your browser:
      http://localhost/phpmyadmin

4) Click "Import" tab and choose the file:
      samak/database.sql
   This creates the database "samak_db" with all tables and sample fish.

5) (Optional) Put fish images inside the folder:
      samak/assets/images/fish/
   These names match the sample data:
      kingfish.png, tuna.png, sardine.png,
      hamour.png, seabream.png, mackerel.png,
      salmon.png, default.png

   You can also upload new images directly from the
   admin panel (Add Product > Choose File).

6) Open the website in browser:
      http://localhost/samak/

7) Open the admin panel:
      http://localhost/samak/admin/login.php
      Default username: admin
      Default password: admin123

==========================================
FOLDER STRUCTURE
==========================================
samak/
  index.php             - Home page
  browse.php            - Browse fish (search + filter)
  product.php           - Product details + Add to cart
  cart.php              - Shopping cart
  checkout.php          - Place order
  orders.php            - Order history (customer)
  order_details.php     - Single order view
  profile.php           - Edit profile
  login.php             - Customer login
  register.php          - Customer / Fisherman sign up
  logout.php
  add_to_cart.php       - POST handler

  admin/
    login.php           - Admin login
    logout.php
    index.php           - Admin dashboard
    products.php        - Manage products
    add_product.php     - Add product (with image upload)
    edit_product.php    - Edit product
    orders.php          - Manage orders + change status
    users.php           - Manage users

  includes/
    db.php              - DB connection (edit if needed)
    header.php          - Site header
    footer.php          - Site footer

  assets/
    css/style.css       - Main stylesheet
    js/main.js          - Search, filter, image preview
    images/fish/        - Fish photos (place yours here)

  uploads/              - New product images go here

  database.sql          - Run once in phpMyAdmin

==========================================
FUNCTIONAL FEATURES (matches PDF)
==========================================
[x] User registration & login (Customer / Fisherman)
[x] Browse fish list
[x] Search fish by name
[x] Filter by category (Premium / Local)
[x] Sort by price (Low to High / High to Low)
[x] View product details
[x] Add to cart
[x] Update / remove items in cart
[x] Place order with delivery type
[x] View order history
[x] Cancel pending order
[x] Order status: Pending / Out for delivery / Delivered / Cancelled

ADMIN
[x] Admin login
[x] Dashboard with stats (products, orders, users, revenue)
[x] Add product WITH IMAGE UPLOAD (the feature you asked for)
[x] Edit product + replace image
[x] Delete product
[x] Toggle "in service" / "out of service"
[x] Manage all orders (change status)
[x] Manage users

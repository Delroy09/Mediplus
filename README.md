# Medi+ Patient Management System

## Project Overview
**Medi+** is a DBMS Mini Project designed to manage hospital patient admissions, doctor assignments, and account requests.

**Type:** Organization Information System
**Roles:** Admin, Doctor, Patient

##  How to Run Locally (After Cloning)

If you have cloned this repository to a new machine, follow these steps to get it running:

### 1. Install Dependencies
Open a terminal in the project folder and run:
`ash
composer install
npm install
` 

### 2. Environment Setup
Create your environment file and generate the application key:
`ash
cp .env.example .env
php artisan key:generate
` 

### 3. Database Configuration
1. Open XAMPP/MySQL and create a new empty database named mediplus.
2. Open the .env file and verify these settings match your database:
`ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mediplus
DB_USERNAME=root
DB_PASSWORD=
` 

### 4. Run Migrations
Create the database tables:
`ash
php artisan migrate
` 

### 5. Start the Server
`ash
php artisan serve
` 
Access the application at: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

##  Project Structure
- esources/views/layouts/master.blade.php: Main UI Theme (Bootstrap CDN).
- outes/web.php: Application Routing.
- pp/Http/Controllers/ContactController.php: Handles Account Requests.

##  Notes for Grading
- **Frontend:** bootstrap 5 is used via CDN (Internet connection required).
- **Accounts:** New users must request an account via the Contact page.

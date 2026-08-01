# Assignment Management System (AMS)

A web-based **Assignment Management System (AMS)** developed to help students efficiently organize and manage their academic assignments. The system provides a centralized platform for students to create, track, edit and monitor assignments while offering features such as subject management, deadline reminders, calendar visualization and user account management. Built using **Laravel**, **PHP**, **MySQL**, **HTML**, **CSS (Tailwind CSS)** and **JavaScript**, the application aims to improve students' organization and time management.
> **Disclaimer:** This project was developed and tested using **Laragon** as the local development environment. As a result, the application is configured to run using Laragon's **`.test`** virtual host (e.g., `http://assignment-management-system.test`). If you are using a different local server environment (such as XAMPP or WAMP), you may need to adjust the virtual host configuration or access the application through the default Laravel development server (e.g., `http://127.0.0.1:8000`).

---

## Prerequisites

Before setting up the project, ensure that the following software is installed on your machine:

- **PHP 8.3.28 or higher**
- **Composer 2.9.2 or higher**
- **Node.js & npm**
- **MySQL**
- **Laragon** (recommended for local development)

---

## Installation

### 1. Install PHP Dependencies

Ensure that **Composer 2.9.2 or higher** and **PHP 8.3.28 or higher** are already installed.

```bash
composer install --ignore-platform-reqs
```

This command installs all required PHP dependencies defined in the `composer.json` file.

---

### 2. Install JavaScript Dependencies

```bash
npm install
```

This installs all JavaScript packages required by the project.

---

### 3. Create the Environment File

Copy the example environment configuration file.

```bash
cp .env.example .env
```

---

### 4. Generate the Application Key

Generate the Laravel application key and automatically update the `.env` file.

```bash
php artisan key:generate
```

---

### 5. Configure Database

Update the following values in the `.env` file according to your MySQL configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ams_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 6. Run Database Migrations

Create all required database tables.

```bash
php artisan migrate
```

---

### 7. Start the Development Server

Run the frontend development server.

```bash
npm run dev
```

Then, start the Laravel application.

```bash
php artisan serve
```

Open your browser and visit:

```
http://127.0.0.1:8000
```

---

## Features

- User Registration & Login
- Subject Management
- Assignment Management (CRUD)
- Assignment Deadline Tracking
- Calendar View
- Deadline Notifications
- Profile Management
- Password Management
- Responsive User Interface

---

## Technologies Used

### Frontend
- HTML
- Tailwind CSS
- JavaScript

### Backend
- PHP
- Laravel Framework

### Database
- MySQL

### Development Tools
- Visual Studio Code
- Laragon
- HeidiSQL

---

## License

This project was developed for educational purposes as part of a university software development project.

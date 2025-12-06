# My Blog App (Task 4)

## Features
- User registration and login
- Role-based access (admin vs user)
- Add, edit, delete posts (admin only)
- View posts (all users)
- Search and pagination
- Responsive Bootstrap UI
- Secure logout

## Setup
1. Import `blog.sql` into phpMyAdmin.
2. Update `config.php` with your database name.
3. Default admin account:
   - Username: admin
   - Password: admin123
   - Role: admin

## Demo
- Login as admin → add/edit/delete posts.
- Login as user → view posts only.
- Guests → can register or view posts.

## Tech
- PHP 8
- MySQL
- Bootstrap 5
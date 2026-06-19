# BIT3208 Week 7 - Medical Store Authentication System

## Project Description
A secure PHP and MySQL authentication system for the Medical Store
Management System. Includes user registration, login, session 
management, protected dashboard and logout.

## Student Details
- Course: BIT3208 - Advanced Web Design and Development
- Week: 7 — User Authentication and Session Management
- Project: Medical Store Management System

## Features
- Staff Registration with password hashing
- Secure Login with password verification
- Session based access control
- Protected Dashboard (redirects to login if not logged in)
- Role based users (Admin, Pharmacist, Cashier)
- Secure Logout

## Files
- php_files/ — All PHP files
- database_scripts/ — SQL file for users table
- screenshots/ — Screenshots of the working system

## How to Run
1. Install XAMPP and start Apache and MySQL
2. Open phpMyAdmin and import database_scripts/users_table.sql
3. Copy php_files/ to C:/xampp/htdocs/BIT3208-MediStore/week7/
4. Open browser and go to:
   http://localhost/BIT3208-MediStore/week7/register.php

## How Authentication Works
1. User fills registration form
2. Password is hashed using password_hash() before saving
3. User logs in with email and password
4. System verifies password using password_verify()
5. Session is created on successful login
6. Dashboard is protected — redirects to login if no session
7. Logout destroys the session

## Technologies Used
- PHP
- MySQL
- HTML & CSS
- XAMPP
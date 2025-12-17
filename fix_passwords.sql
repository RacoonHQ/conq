-- Fix existing plain text passwords to Bcrypt hashes
-- Run this in phpMyAdmin or your database client

-- Update demo user password if it exists as plain text
UPDATE users 
SET password = '$2y$12$H.hyY7QBLExlGgxPQvUboetTWXktC69nkcLh.ON/yuHlNggeZV3Va' 
WHERE email = 'demo@example.com' AND password = 'password123';

-- You can also verify the update was successful
SELECT email, password FROM users WHERE email = 'demo@example.com';

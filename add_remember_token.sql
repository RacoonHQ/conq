-- Add remember_token column to users table
ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) DEFAULT NULL AFTER password;

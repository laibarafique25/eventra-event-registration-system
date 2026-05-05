-- Admin table for the Admin Panel
-- Run this once on your existing `codealpha_events` database.

USE codealpha_events;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add image_url column to events if it does not yet exist
-- (safe to ignore the error if it already exists)
ALTER TABLE events ADD COLUMN image_url VARCHAR(500) NULL;

-- Default admin account
-- Email:    admin@codealpha.com
-- Password: admin123
INSERT INTO admins (name, email, password) VALUES
('Super Admin', 'admin@codealpha.com', '$2y$10$e0NRl5b6Q8xkE8l1vQ9G1uG7oYv3o6oQp4F8d.X1Qm3rA5dB0x6Iu');
-- Hash above is for "admin123". If login fails, run admin_seed.php once.

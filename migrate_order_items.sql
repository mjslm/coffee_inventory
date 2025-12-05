-- Migration: add unit_price to order_items and populate it
-- IMPORTANT: BACKUP your database before running these statements.

-- Add column if it doesn't already exist
ALTER TABLE `order_items` ADD COLUMN IF NOT EXISTS `unit_price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' AFTER `quantity`;

-- Populate existing rows with current product price (so historical orders have a price snapshot)
UPDATE `order_items` oi
JOIN `products` p ON oi.product_id = p.product_id
SET oi.unit_price = p.price
WHERE oi.unit_price = 0.00;

-- Done.

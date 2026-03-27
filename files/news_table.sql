-- =============================================
-- Daily News Feature - SQL Table
-- Run this in phpMyAdmin or MySQL CLI
-- =============================================

CREATE TABLE IF NOT EXISTS `news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `category` ENUM('General','Crime Alert','Missing Person','Notice','Update') DEFAULT 'General',
  `posted_by` INT(11) NOT NULL,          -- user id of admin or police
  `posted_by_role` ENUM('admin','police') NOT NULL,
  `posted_by_name` VARCHAR(100) NOT NULL,
  `station_id` INT(11) DEFAULT NULL,     -- NULL = visible to all
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Index for faster queries
CREATE INDEX idx_news_active ON news(is_active);
CREATE INDEX idx_news_created ON news(created_at DESC);

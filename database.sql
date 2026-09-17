CREATE DATABASE IF NOT EXISTS rd10_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rd10_crm;

CREATE TABLE IF NOT EXISTS users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 role ENUM('admin','user') NOT NULL DEFAULT 'user',
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at DATETIME NULL,
 updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS materials (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 code VARCHAR(100) NOT NULL,
 description VARCHAR(255) NOT NULL,
 vendor_name VARCHAR(190) NULL,
 unit VARCHAR(40) NOT NULL DEFAULT 'pcs',
 monthly_capacity DECIMAL(18,5) NOT NULL DEFAULT 0,
 production_plan DECIMAL(18,5) NOT NULL DEFAULT 0,
 type ENUM('finished_good','packaging','raw_material') NOT NULL DEFAULT 'raw_material',
 created_at DATETIME NULL,
 updated_at DATETIME NULL,
 UNIQUE KEY uq_material_code (code)
);

CREATE TABLE IF NOT EXISTS monthly_stock (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 material_id INT UNSIGNED NOT NULL,
 month_key CHAR(7) NOT NULL,
 opening_stock DECIMAL(18,5) NOT NULL DEFAULT 0,
 physical_stock_month_end DECIMAL(18,5) NULL,
 good_stock_physical DECIMAL(18,5) NULL,
 rejected_stock_physical DECIMAL(18,5) NULL,
 notes TEXT NULL,
 created_by INT UNSIGNED NULL,
 updated_by INT UNSIGNED NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL,
 UNIQUE KEY uq_material_month (material_id,month_key),
 FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE,
 FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
 FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS daily_entries (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 material_id INT UNSIGNED NOT NULL,
 entry_date DATE NOT NULL,
 month_key CHAR(7) NOT NULL,
 receipt_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 receipt_challan_no VARCHAR(120) NULL,
 issued_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 in_process_rejection_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 in_process_rejection_reason VARCHAR(500) NULL,
 other_rejection_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 other_rejection_comment VARCHAR(500) NULL,
 transfer_out_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 transfer_challan_no VARCHAR(120) NULL,
 production_output_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 production_deviation_reason VARCHAR(500) NULL,
 samples_qty DECIMAL(18,5) NOT NULL DEFAULT 0,
 extra_data JSON NULL,
 created_by INT UNSIGNED NOT NULL,
 updated_by INT UNSIGNED NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL,
 UNIQUE KEY uq_material_date (material_id,entry_date),
 INDEX idx_daily_month(material_id,month_key),
 FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE,
 FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
 FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS weekly_notes (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 material_id INT UNSIGNED NOT NULL,
 week_key CHAR(8) NOT NULL,
 category ENUM('rejection','production_deviation') NOT NULL,
 reason_text TEXT NOT NULL,
 created_by INT UNSIGNED NULL,
 created_at DATETIME NULL,
 FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE,
 FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS activity_logs (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NULL,
 action VARCHAR(80) NOT NULL,
 entity_type VARCHAR(80) NOT NULL,
 entity_id BIGINT UNSIGNED NULL,
 details TEXT NULL,
 created_at DATETIME NULL,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS quantity_transactions (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 product_material_id INT UNSIGNED NULL,
 user_id INT UNSIGNED NULL,
 type ENUM('receipt','issue','transfer','adjustment') NOT NULL,
 quantity DECIMAL(18,5) NOT NULL,
 reference_no VARCHAR(120) NULL,
 note VARCHAR(500) NULL,
 created_at DATETIME NULL,
 FOREIGN KEY (product_material_id) REFERENCES materials(id) ON DELETE SET NULL,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT IGNORE INTO materials(code,description,unit,type) VALUES
('4521546','WAX CRAYON 1000-RD-10','pcs','finished_good'),
('I4521000','LABEL','pcs','packaging'),
('K4521002','TOP SLEEVE FOR WAX CRAYON 1000-10 PACK','pcs','packaging'),
('P4521003','Sleeve WAX CRAYON 1000-10 PACK','pcs','packaging'),
('N4521002','CB FOR WAX CRAYON 1000 – 10 PACK','pcs','packaging'),
('T4521003','PAPER TRAY FOR WAX CRAYON 1000-10 PACK','pcs','packaging'),
('Z4521003','WHITE BACK DUPLEX BOARD 320GSM ROLL FORM','pcs','packaging'),
('STICKS','STICKS','pcs','raw_material'),
('45210161','Wax Crayon RD — Black','pcs','raw_material'),
('45210261','Wax Crayon RD — Brown','pcs','raw_material'),
('45210361','Wax Crayon RD — Brinjal Purple','pcs','raw_material'),
('45210461','Wax Crayon RD — Dp. Red','pcs','raw_material'),
('45210561','Wax Crayon RD — Flesh Tint','pcs','raw_material'),
('45210661','Wax Crayon RD — Lt. Blue','pcs','raw_material'),
('45210761','Wax Crayon RD — Lt. Green','pcs','raw_material'),
('45210861','Wax Crayon RD — Orange','pcs','raw_material'),
('45210961','Wax Crayon RD — Pink','pcs','raw_material'),
('45214861','Wax Crayon RD — Yellow','pcs','raw_material');

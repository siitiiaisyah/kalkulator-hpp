-- Schema Kalkulator HPP UMKM Kuliner
-- Sesuai SDD PPSI Bab 4 (Desain Basis Data)

CREATE DATABASE IF NOT EXISTS `kalkulator_hpp` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `kalkulator_hpp`;

-- 1. Tabel tarif_listrik
CREATE TABLE IF NOT EXISTS `tarif_listrik` (
  `id_tarif` INT(11) NOT NULL AUTO_INCREMENT,
  `golongan_daya` VARCHAR(50) NOT NULL,
  `tarif_per_kwh` DECIMAL(10,2) NOT NULL,
  `status_aktif` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_tarif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed data tarif_listrik PLN Rumah Tangga
INSERT INTO `tarif_listrik` (`golongan_daya`, `tarif_per_kwh`, `status_aktif`) VALUES
('R-1 (Subsidi) 450 VA', 415.00, 1),
('R-1 (Subsidi) 900 VA', 605.00, 1),
('R-1 (Non-Subsidi) 900 VA', 1352.00, 1),
('R-1 (Non-Subsidi) 1.300–2.200 VA', 1444.70, 1),
('R-2 3.500–5.500 VA', 1699.53, 1),
('R-3 >= 6.600 VA', 1699.53, 1)
ON DUPLICATE KEY UPDATE `tarif_per_kwh` = VALUES(`tarif_per_kwh`);

-- 2. Tabel master_bahan
CREATE TABLE IF NOT EXISTS `master_bahan` (
  `id_master_bahan` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_bahan` VARCHAR(50) NOT NULL,
  `satuan` VARCHAR(30) NOT NULL,
  `harga_beli_terakhir` DECIMAL(12,2) NOT NULL,
  `isi_kemasan_terakhir` DECIMAL(12,2) NOT NULL,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_master_bahan`),
  UNIQUE KEY `idx_nama_bahan` (`nama_bahan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed data master_bahan dari studi kasus Ibu Napsiah & dokumen SDD
INSERT INTO `master_bahan` (`nama_bahan`, `satuan`, `harga_beli_terakhir`, `isi_kemasan_terakhir`) VALUES
('Tepung Terigu', 'gr', 14000.00, 1000.00),
('Margarin', 'gr', 20000.00, 200.00),
('Gula Halus', 'gr', 18000.00, 500.00),
('Cokelat Bubuk', 'gr', 25000.00, 100.00),
('Telur', 'pcs', 25000.00, 16.00),
('Tepung Maizena', 'gr', 12000.00, 250.00),
('Vanili', 'pcs', 5000.00, 10.00),
('Chocochips', 'gr', 20000.00, 250.00),
('Baking Powder', 'gr', 8000.00, 45.00),
('Kulit Risol', 'pcs', 20000.00, 50.00),
('Mayones', 'gr', 25000.00, 500.00),
('Keju Cheddar', 'gr', 22000.00, 165.00),
('Selai Nanas', 'gr', 30000.00, 500.00),
('Susu Bubuk', 'gr', 15000.00, 200.00)
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- 3. Tabel perhitungan
CREATE TABLE IF NOT EXISTS `perhitungan` (
  `id_perhitungan` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` VARCHAR(100) NOT NULL,
  `lama_gas_jam` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `harga_tabung_gas` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `isi_tabung_kg` DECIMAL(6,2) NOT NULL DEFAULT 3.00,
  `konsumsi_gas_kg_jam` DECIMAL(4,2) NOT NULL DEFAULT 0.20,
  `id_tarif` INT(11) DEFAULT NULL,
  `tarif_listrik` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `jumlah_produk` INT(11) NOT NULL DEFAULT 1,
  `persen_untung` DECIMAL(5,2) NOT NULL DEFAULT 50.00,
  `harga_jual_simulasi` DECIMAL(12,2) DEFAULT NULL,
  `total_biaya_bahan` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `biaya_operasional_lain` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `biaya_gas` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `biaya_listrik` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `biaya_tenaga_kerja` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `total_biaya_produksi` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `hpp_per_produk` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `harga_jual_saran` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `laba_per_produk` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `laba_per_resep` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `laba_riil_per_produk` DECIMAL(14,2) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_perhitungan`),
  KEY `fk_perhitungan_tarif` (`id_tarif`),
  CONSTRAINT `fk_perhitungan_tarif` FOREIGN KEY (`id_tarif`) REFERENCES `tarif_listrik` (`id_tarif`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel bahan_baku
CREATE TABLE IF NOT EXISTS `bahan_baku` (
  `id_bahan` INT(11) NOT NULL AUTO_INCREMENT,
  `id_perhitungan` INT(11) NOT NULL,
  `id_master_bahan` INT(11) DEFAULT NULL,
  `nama_bahan` VARCHAR(50) NOT NULL,
  `satuan` VARCHAR(30) NOT NULL,
  `harga_beli` DECIMAL(12,2) NOT NULL,
  `isi_kemasan` DECIMAL(12,2) NOT NULL,
  `jumlah_terpakai` DECIMAL(12,2) NOT NULL,
  `biaya` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`id_bahan`),
  KEY `fk_bahan_perhitungan` (`id_perhitungan`),
  KEY `fk_bahan_master` (`id_master_bahan`),
  CONSTRAINT `fk_bahan_perhitungan` FOREIGN KEY (`id_perhitungan`) REFERENCES `perhitungan` (`id_perhitungan`) ON DELETE CASCADE,
  CONSTRAINT `fk_bahan_master` FOREIGN KEY (`id_master_bahan`) REFERENCES `master_bahan` (`id_master_bahan`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel perangkat_listrik
CREATE TABLE IF NOT EXISTS `perangkat_listrik` (
  `id_perangkat` INT(11) NOT NULL AUTO_INCREMENT,
  `id_perhitungan` INT(11) NOT NULL,
  `nama_perangkat` VARCHAR(50) NOT NULL,
  `daya_watt` DECIMAL(8,2) NOT NULL,
  `jam_pakai` DECIMAL(6,2) NOT NULL,
  `kwh` DECIMAL(10,3) NOT NULL,
  `biaya` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`id_perangkat`),
  KEY `fk_listrik_perhitungan` (`id_perhitungan`),
  CONSTRAINT `fk_listrik_perhitungan` FOREIGN KEY (`id_perhitungan`) REFERENCES `perhitungan` (`id_perhitungan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel tenaga_kerja
CREATE TABLE IF NOT EXISTS `tenaga_kerja` (
  `id_tenaga` INT(11) NOT NULL AUTO_INCREMENT,
  `id_perhitungan` INT(11) NOT NULL,
  `nama_pekerja` VARCHAR(50) NOT NULL,
  `gaji_per_jam` DECIMAL(12,2) NOT NULL,
  `jam_kerja` DECIMAL(6,2) NOT NULL,
  `biaya` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`id_tenaga`),
  KEY `fk_tenaga_perhitungan` (`id_perhitungan`),
  CONSTRAINT `fk_tenaga_perhitungan` FOREIGN KEY (`id_perhitungan`) REFERENCES `perhitungan` (`id_perhitungan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabel biaya_operasional
CREATE TABLE IF NOT EXISTS `biaya_operasional` (
  `id_operasional` INT(11) NOT NULL AUTO_INCREMENT,
  `id_perhitungan` INT(11) NOT NULL,
  `jenis_biaya` VARCHAR(50) NOT NULL,
  `harga` DECIMAL(12,2) NOT NULL,
  `kapasitas` DECIMAL(12,2) NOT NULL,
  `total_pakai` DECIMAL(12,2) NOT NULL,
  `biaya` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`id_operasional`),
  KEY `fk_op_perhitungan` (`id_perhitungan`),
  CONSTRAINT `fk_op_perhitungan` FOREIGN KEY (`id_perhitungan`) REFERENCES `perhitungan` (`id_perhitungan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

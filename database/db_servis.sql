/*
 Navicat Premium Data Transfer

 Source Server         : root
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : db_servis

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 19/07/2026 20:43:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for abouts
-- ----------------------------
DROP TABLE IF EXISTS `abouts`;
CREATE TABLE `abouts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `badge_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sekilas tentang',
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ServisMotor',
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bengkel Motor Profesional & Online',
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `highlights` json NULL,
  `tombol_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Daftar Servis Online',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of abouts
-- ----------------------------

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for fitur_layanans
-- ----------------------------
DROP TABLE IF EXISTS `fitur_layanans`;
CREATE TABLE `fitur_layanans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fitur_layanans
-- ----------------------------

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of galleries
-- ----------------------------
INSERT INTO `galleries` VALUES (1, 'sepeda motor', 'galleries/vRDpXHxHofEiSyrc804HIPdkXHGkYw6Ti7v6FmNi.png', 1, 1, '2026-07-05 15:44:18', '2026-07-05 15:44:18');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for kategori_barangs
-- ----------------------------
DROP TABLE IF EXISTS `kategori_barangs`;
CREATE TABLE `kategori_barangs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori_barangs
-- ----------------------------
INSERT INTO `kategori_barangs` VALUES (1, 'Oli & Pelumas', 'Oli mesin, oli gardan, pelumas', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (2, 'Filter', 'Filter udara, filter oli, filter bensin', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (3, 'Busi & Pengapian', 'Busi, koil, kabel busi', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (4, 'Rem', 'Kampas rem, minyak rem, cakram', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (5, 'Ban & Roda', 'Ban dalam, ban luar, pentil', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (6, 'Rantai & Gir', 'Rantai, gir depan, gir belakang', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (7, 'Lampu & Kelistrikan', 'Bohlam, aki, kabel, saklar', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (8, 'Velg & Spoke', 'Velg, jari-jari, as roda', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (9, 'Aksesoris', 'Spion, handle, bodi', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (10, 'Lainnya', 'Sparepart lain-lain', '2026-06-15 02:05:12', '2026-06-15 02:05:12');
INSERT INTO `kategori_barangs` VALUES (11, 'Oli & Pelumas', 'Oli mesin, oli gardan, pelumas', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (12, 'Filter', 'Filter udara, filter oli, filter bensin', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (13, 'Busi & Pengapian', 'Busi, koil, kabel busi', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (14, 'Rem', 'Kampas rem, minyak rem, cakram', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (15, 'Ban & Roda', 'Ban dalam, ban luar, pentil', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (16, 'Rantai & Gir', 'Rantai, gir depan, gir belakang', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (17, 'Lampu & Kelistrikan', 'Bohlam, aki, kabel, saklar', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (18, 'Velg & Spoke', 'Velg, jari-jari, as roda', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (19, 'Aksesoris', 'Spion, handle, bodi', '2026-06-15 02:16:17', '2026-06-15 02:16:17');
INSERT INTO `kategori_barangs` VALUES (20, 'Lainnya', 'Sparepart lain-lain', '2026-06-15 02:16:17', '2026-06-15 02:16:17');

-- ----------------------------
-- Table structure for kendaraans
-- ----------------------------
DROP TABLE IF EXISTS `kendaraans`;
CREATE TABLE `kendaraans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `no_polisi` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merek` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NULL DEFAULT NULL,
  `warna` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kendaraans_pelanggan_id_foreign`(`pelanggan_id` ASC) USING BTREE,
  CONSTRAINT `kendaraans_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kendaraans
-- ----------------------------
INSERT INTO `kendaraans` VALUES (1, 2, 'K 8765 PC', 'Honda', 'Bebek', 2020, 'putih', '2026-06-03 12:00:12', '2026-06-03 12:00:12');
INSERT INTO `kendaraans` VALUES (2, 3, 'BC76876K', 'HOnda', 'Vario', 2015, 'Putih', '2026-07-04 15:51:40', '2026-07-04 15:51:40');
INSERT INTO `kendaraans` VALUES (3, 3, 'BC76876K', 'HOnda', 'Vario', 2015, 'Putih', '2026-07-04 15:51:44', '2026-07-04 15:51:44');
INSERT INTO `kendaraans` VALUES (4, 3, 'BC76876K', 'HOnda', 'Vario', 2015, 'Putih', '2026-07-04 15:52:03', '2026-07-04 15:52:03');
INSERT INTO `kendaraans` VALUES (5, 4, 'KB 0765 K', 'Honda', 'Vrio 110', 2013, 'Putih', '2026-07-04 15:58:41', '2026-07-04 15:58:41');
INSERT INTO `kendaraans` VALUES (6, 5, 'B 0987 BC', 'Yamaha', 'Nmax', 2020, 'Hitam', '2026-07-04 17:05:37', '2026-07-04 17:05:37');
INSERT INTO `kendaraans` VALUES (7, 6, 'B 9876 KB', 'HOnda', 'Vario 125', 2020, 'HItam', '2026-07-04 17:07:24', '2026-07-04 17:07:24');

-- ----------------------------
-- Table structure for kontaks
-- ----------------------------
DROP TABLE IF EXISTS `kontaks`;
CREATE TABLE `kontaks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'teks',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kontaks_key_unique`(`key` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kontaks
-- ----------------------------
INSERT INTO `kontaks` VALUES (1, 'no_telepon', 'No. Telepon', '0812-3456-7890', 'telepon', 'bi-telephone', 1, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (2, 'email', 'Email', 'bengkelmotor@email.com', 'email', 'bi-envelope', 2, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (3, 'alamat', 'Alamat', 'Jl. Merdeka No. 123, Jakarta', 'alamat', 'bi-geo-alt', 3, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (4, 'no_wa', 'No. WhatsApp', '0812-3456-7890', 'telepon', 'bi-whatsapp', 4, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (5, 'facebook', 'Facebook', '#', 'sosmed', 'bi-facebook', 5, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (6, 'twitter', 'Twitter / X', '#', 'sosmed', 'bi-twitter-x', 6, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (7, 'youtube', 'YouTube', '#', 'sosmed', 'bi-youtube', 7, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (8, 'instagram', 'Instagram', '#', 'sosmed', 'bi-instagram', 8, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');
INSERT INTO `kontaks` VALUES (9, 'deskripsi_footer', 'Deskripsi Footer', 'Bengkel motor profesional melayani jasa perbaikan dan perawatan segala jenis dan tipe motor. Menerima jasa service online maupun datang langsung.', 'teks', NULL, 0, 1, '2026-07-05 15:36:46', '2026-07-05 15:36:46');

-- ----------------------------
-- Table structure for master_servis
-- ----------------------------
DROP TABLE IF EXISTS `master_servis`;
CREATE TABLE `master_servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `biaya` decimal(12, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_servis
-- ----------------------------
INSERT INTO `master_servis` VALUES (1, 'Servis Total', 'Servis kendaraan secara total dan ganti oli', 2000000.00, '2026-05-21 16:35:28', '2026-05-21 16:56:57');
INSERT INTO `master_servis` VALUES (2, 'Ganti Oli', 'Ganti oli mesin', 50000.00, '2026-05-21 16:35:28', '2026-05-21 16:35:28');
INSERT INTO `master_servis` VALUES (3, 'Servis Ringan', 'Servis ringan, setel rantai, bersihkan karburator', 75000.00, '2026-05-21 16:35:28', '2026-05-21 16:35:28');
INSERT INTO `master_servis` VALUES (4, 'Servis Besar', 'Servis besar, ganti oli, busi, filter udara, setel klep', 300000.00, '2026-05-21 16:35:28', '2026-05-21 16:35:28');
INSERT INTO `master_servis` VALUES (10, 'Servis Total', 'Servis kendaraan secara total dan ganti oli', 200000.00, '2026-05-22 13:56:55', '2026-05-22 13:56:55');
INSERT INTO `master_servis` VALUES (11, 'Ganti Oli', 'Ganti oli mesin', 50000.00, '2026-05-22 13:56:55', '2026-05-22 13:56:55');
INSERT INTO `master_servis` VALUES (12, 'Servis Ringan', 'Servis ringan, setel rantai, bersihkan karburator', 75000.00, '2026-05-22 13:56:55', '2026-05-22 13:56:55');
INSERT INTO `master_servis` VALUES (13, 'Servis Besar', 'Servis besar, ganti oli, busi, filter udara, setel klep', 300000.00, '2026-05-22 13:56:55', '2026-05-22 13:56:55');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2026_05_19_155613_create_pelanggans_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_05_19_155615_create_kendaraans_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_05_19_155617_create_servis_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_05_19_162116_add_role_to_users_table', 2);
INSERT INTO `migrations` VALUES (8, '2026_05_21_000001_create_master_servis_table', 3);
INSERT INTO `migrations` VALUES (9, '2026_05_22_000001_add_is_active_to_users_table', 4);
INSERT INTO `migrations` VALUES (10, '2026_05_22_000002_create_kategori_barangs_table', 4);
INSERT INTO `migrations` VALUES (11, '2026_05_22_000003_create_spareparts_table', 4);
INSERT INTO `migrations` VALUES (12, '2026_05_22_000004_add_void_to_servis_table', 4);
INSERT INTO `migrations` VALUES (13, '2026_05_22_000005_add_no_wa_to_pelanggans_table', 5);
INSERT INTO `migrations` VALUES (14, '2026_05_22_000006_add_kasir_fields_to_servis_table', 5);
INSERT INTO `migrations` VALUES (15, '2026_05_22_000007_create_servis_sparepart_table', 6);
INSERT INTO `migrations` VALUES (16, '2026_06_15_031946_add_master_servis_id_to_servis_table', 7);
INSERT INTO `migrations` VALUES (17, '2026_07_05_000001_create_fitur_layanans_table', 8);
INSERT INTO `migrations` VALUES (18, '2026_07_05_000002_create_abouts_table', 8);
INSERT INTO `migrations` VALUES (19, '2026_07_05_000003_create_galleries_table', 8);
INSERT INTO `migrations` VALUES (20, '2026_07_05_000004_create_kontaks_table', 8);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pelanggans
-- ----------------------------
DROP TABLE IF EXISTS `pelanggans`;
CREATE TABLE `pelanggans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `no_telp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_wa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggans
-- ----------------------------
INSERT INTO `pelanggans` VALUES (2, 'joko kumala', 'kudus', '085768768', '086576576575765', 'joko@bengkel.com', '2026-06-03 11:59:09', '2026-06-03 11:59:34');
INSERT INTO `pelanggans` VALUES (3, 'wawan', '', '0876776677', '0876776677', NULL, '2026-07-04 15:51:39', '2026-07-04 15:51:39');
INSERT INTO `pelanggans` VALUES (4, 'wawan', '', '0865435435', '0865435435', NULL, '2026-07-04 15:58:41', '2026-07-04 15:58:41');
INSERT INTO `pelanggans` VALUES (5, 'jgkjgkjg', '', '097867576768', '097867576768', NULL, '2026-07-04 17:05:37', '2026-07-04 17:05:37');
INSERT INTO `pelanggans` VALUES (6, 'jhkjh', '', '098657876567', '098657876567', NULL, '2026-07-04 17:07:24', '2026-07-04 17:07:24');

-- ----------------------------
-- Table structure for servis
-- ----------------------------
DROP TABLE IF EXISTS `servis`;
CREATE TABLE `servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `no_antrian` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kendaraan_id` bigint UNSIGNED NOT NULL,
  `tipe_barang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_selesai` date NULL DEFAULT NULL,
  `keluhan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelengkapan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `biaya` decimal(12, 2) NOT NULL,
  `tipe_diskon` enum('nominal','persen') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `diskon` decimal(12, 2) NOT NULL,
  `total_bayar` decimal(12, 2) NOT NULL,
  `metode_pembayaran` enum('tunai','transfer','qris') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tgl_pembayaran` timestamp NULL DEFAULT NULL,
  `status` enum('pending','proses','selesai','diambil') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_void` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voided_by` bigint UNSIGNED NULL DEFAULT NULL,
  `voided_at` timestamp NULL DEFAULT NULL,
  `alasan_void` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `master_servis_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `servis_no_antrian_unique`(`no_antrian` ASC) USING BTREE,
  INDEX `servis_kendaraan_id_foreign`(`kendaraan_id` ASC) USING BTREE,
  INDEX `servis_voided_by_foreign`(`voided_by` ASC) USING BTREE,
  INDEX `servis_master_servis_id_foreign`(`master_servis_id` ASC) USING BTREE,
  CONSTRAINT `servis_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraans` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `servis_master_servis_id_foreign` FOREIGN KEY (`master_servis_id`) REFERENCES `master_servis` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `servis_voided_by_foreign` FOREIGN KEY (`voided_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of servis
-- ----------------------------
INSERT INTO `servis` VALUES (3, 'SRV-20260603-001', 1, 'motor', '2026-06-03', NULL, 'kendaraan over power', NULL, 'Servis besar, ganti oli, busi, filter udara, setel klep', 30000000.00, NULL, 0.00, 30000000.00, NULL, NULL, 'proses', 0, '2026-06-03 12:18:21', '2026-06-15 02:08:36', NULL, NULL, NULL, NULL);
INSERT INTO `servis` VALUES (4, 'SRV-20260615-001', 1, 'motor', '2026-06-15', NULL, 'Motor Brebet', '-', 'Ganti oli mesin', 5000000.00, NULL, 0.00, 5120000.00, NULL, NULL, 'pending', 0, '2026-06-15 02:07:09', '2026-06-15 02:07:09', NULL, NULL, NULL, NULL);
INSERT INTO `servis` VALUES (5, 'SRV-20260704-001', 2, NULL, '2026-07-04', NULL, 'motor brebet', NULL, NULL, 75000.00, NULL, 0.00, 75000.00, NULL, NULL, 'pending', 0, '2026-07-04 15:51:40', '2026-07-04 15:51:40', NULL, NULL, NULL, 3);
INSERT INTO `servis` VALUES (6, 'SRV-20260704-002', 3, NULL, '2026-07-04', NULL, 'motor brebet', NULL, NULL, 75000.00, NULL, 0.00, 75000.00, NULL, NULL, 'pending', 0, '2026-07-04 15:51:44', '2026-07-04 15:51:44', NULL, NULL, NULL, 3);
INSERT INTO `servis` VALUES (7, 'SRV-20260704-003', 4, NULL, '2026-07-04', NULL, 'motor brebet', NULL, NULL, 75000.00, NULL, 0.00, 75000.00, NULL, NULL, 'pending', 0, '2026-07-04 15:52:03', '2026-07-04 15:52:03', NULL, NULL, NULL, 3);
INSERT INTO `servis` VALUES (8, 'SRV-20260704-004', 5, NULL, '2026-07-04', NULL, 'montor brebet', NULL, NULL, 75000.00, NULL, 0.00, 75000.00, NULL, NULL, 'pending', 0, '2026-07-04 15:58:41', '2026-07-04 15:58:41', NULL, NULL, NULL, 3);
INSERT INTO `servis` VALUES (9, 'SRV-20260704-005', 6, NULL, '2026-07-04', NULL, 'Oli', NULL, NULL, 75000.00, NULL, 0.00, 75000.00, NULL, NULL, 'pending', 0, '2026-07-04 17:05:37', '2026-07-04 17:05:37', NULL, NULL, NULL, 3);
INSERT INTO `servis` VALUES (10, 'SRV-20260704-006', 7, NULL, '2026-07-04', NULL, 'mesin brebet', NULL, NULL, 75000.00, NULL, 0.00, 75000.00, NULL, NULL, 'pending', 0, '2026-07-04 17:07:24', '2026-07-04 17:07:24', NULL, NULL, NULL, 3);

-- ----------------------------
-- Table structure for servis_sparepart
-- ----------------------------
DROP TABLE IF EXISTS `servis_sparepart`;
CREATE TABLE `servis_sparepart`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `servis_id` bigint UNSIGNED NOT NULL,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `harga_jual` decimal(12, 2) NOT NULL,
  `subtotal` decimal(12, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `servis_id`(`servis_id` ASC) USING BTREE,
  INDEX `sparepart_id`(`sparepart_id` ASC) USING BTREE,
  CONSTRAINT `servis_sparepart_ibfk_1` FOREIGN KEY (`servis_id`) REFERENCES `servis` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `servis_sparepart_ibfk_2` FOREIGN KEY (`sparepart_id`) REFERENCES `spareparts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of servis_sparepart
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('86henPRKwerlfCtjMHaJB6YSXisUMIuM6xfrFWRa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.127.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVJ5UEFuaXhlVHU1eUpycFkzUmw1d0RsTTFYUzZYdlFZRzJQYmRIMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783267050);
INSERT INTO `sessions` VALUES ('Ka0JFwmUpzIjzfuwEfNi93mmavbWHLvi1ue1OXLy', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVnlmTnB5enlxMUhZenVENTJvWHFsS1V2Qk5NRjduQ29kWDNvV3pqUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXJ2aXMvY2VrIjtzOjU6InJvdXRlIjtzOjE5OiJjdXN0b21lci5jZWstc3RhdHVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1783267051);

-- ----------------------------
-- Table structure for spareparts
-- ----------------------------
DROP TABLE IF EXISTS `spareparts`;
CREATE TABLE `spareparts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `kode_sparepart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sparepart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `stok` int NOT NULL DEFAULT 0,
  `stok_minimum` int NOT NULL DEFAULT 5,
  `harga_beli` decimal(12, 2) NOT NULL,
  `harga_jual` decimal(12, 2) NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `spareparts_kode_sparepart_unique`(`kode_sparepart` ASC) USING BTREE,
  INDEX `spareparts_kategori_id_foreign`(`kategori_id` ASC) USING BTREE,
  CONSTRAINT `spareparts_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_barangs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of spareparts
-- ----------------------------
INSERT INTO `spareparts` VALUES (1, 1, 'OLI-MPN-1L', 'Oli Mesin MPN 1L', 'Botol', 25, 5, 35000.00, 45000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (2, 1, 'OLI-MPN-800ML', 'Oli Mesin MPN 800ml', 'Botol', 30, 5, 28000.00, 37000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (3, 1, 'OLI-FDR-1L', 'Oli Mesin FDR 1L', 'Botol', 20, 5, 40000.00, 52000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (4, 1, 'OLI-ENI-1L', 'Oli Mesin ENI 1L', 'Botol', 15, 5, 45000.00, 58000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (5, 1, 'OLI-GAR', 'Oli Gardan 120ml', 'Botol', 12, 3, 15000.00, 22000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (6, 2, 'FLT-UDG', 'Filter Udara Universal', 'Pcs', 10, 3, 15000.00, 25000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (7, 2, 'FLT-OLI', 'Filter Oli', 'Pcs', 8, 3, 12000.00, 20000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (8, 2, 'FLT-BNS', 'Filter Bensin', 'Pcs', 15, 5, 5000.00, 10000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (9, 3, 'BUS-NGK', 'Busi NGK Standar', 'Pcs', 30, 10, 12000.00, 20000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (10, 3, 'BUS-NGK-IR', 'Busi NGK Iridium', 'Pcs', 10, 3, 45000.00, 65000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (11, 3, 'KBL-BSI', 'Kabel Busi Standar', 'Set', 5, 2, 25000.00, 40000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (12, 3, 'KPL-BSI', 'Koil Pengapian Universal', 'Pcs', 4, 2, 55000.00, 80000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (13, 4, 'KMP-RM-DPN', 'Kampas Rem Depan', 'Set', 15, 5, 18000.00, 30000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (14, 4, 'KMP-RM-BLK', 'Kampas Rem Belakang', 'Set', 15, 5, 15000.00, 25000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (15, 4, 'MNYK-RM', 'Minyak Rem DOT 3', 'Botol', 8, 3, 12000.00, 20000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (16, 4, 'SLNG-RM', 'Seal Rem Tromol', 'Pcs', 6, 2, 8000.00, 15000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (17, 5, 'BAN-DLM-80', 'Ban Dalam 80/90', 'Pcs', 10, 3, 25000.00, 40000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (18, 5, 'BAN-DLM-90', 'Ban Dalam 90/90', 'Pcs', 10, 3, 28000.00, 43000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (19, 5, 'PTL-BAN', 'Pentil Ban', 'Pcs', 20, 5, 3000.00, 7000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (20, 5, 'BAN-LUAR-80', 'Ban Luar 80/90-17', 'Pcs', 3, 2, 180000.00, 250000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (21, 6, 'RTAI-428', 'Rantai 428 Standar', 'Set', 8, 3, 35000.00, 55000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (22, 6, 'RTAI-428-O', 'Rantai 428 O-Ring', 'Set', 5, 2, 65000.00, 95000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (23, 6, 'GIR-DPN', 'Gir Depan Standar', 'Pcs', 8, 3, 20000.00, 35000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (24, 6, 'GIR-BLK', 'Gir Belakang Standar', 'Pcs', 8, 3, 30000.00, 50000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (25, 7, 'LMP-DPN', 'Bohlam Lampu Depan 12V', 'Pcs', 15, 5, 8000.00, 15000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (26, 7, 'LMP-SEN', 'Bohlam Lampu Sein', 'Pcs', 20, 5, 4000.00, 8000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (27, 7, 'AKI-GS', 'Aki GS 12V 5Ah', 'Pcs', 4, 2, 85000.00, 120000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:07:09');
INSERT INTO `spareparts` VALUES (28, 7, 'AKI-YU', 'Aki Yuasa 12V 7Ah', 'Pcs', 4, 2, 95000.00, 135000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (29, 7, 'SKL-BK', 'Saklar Lampu Universal', 'Pcs', 6, 2, 10000.00, 18000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (30, 8, 'JR-JRJ', 'Jari-Jari Velg 18in', 'Set', 10, 5, 15000.00, 25000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (31, 8, 'AS-RODA', 'As Roda Belakang', 'Pcs', 3, 1, 45000.00, 70000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (32, 9, 'SPN-KNM', 'Spion Kanan Universal', 'Pcs', 8, 3, 12000.00, 22000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (33, 9, 'SPN-KRM', 'Spion Kiri Universal', 'Pcs', 8, 3, 12000.00, 22000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (34, 9, 'GAG-EOS', 'Handle Gas EOS', 'Pcs', 5, 2, 15000.00, 28000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (35, 9, 'STANG', 'Stang Setang Universal', 'Pcs', 3, 1, 35000.00, 55000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (36, 10, 'KLEP-BENSIN', 'Kran Bensin Universal', 'Pcs', 6, 2, 12000.00, 20000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (37, 10, 'SKRUP', 'Sekrup Mur Baut Set', 'Paket', 10, 3, 8000.00, 15000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');
INSERT INTO `spareparts` VALUES (38, 10, 'KABEL-VAR', 'Kabel Serbaguna 1m', 'Meter', 15, 5, 5000.00, 10000.00, NULL, '2026-06-15 02:05:16', '2026-06-15 02:05:16');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'admin@example.com', NULL, '$2y$12$slVnn5q0driGG7PLvJ1OmOxJ.Bf8eflAk4ffm/mYxN6AgkRQSkqxe', NULL, '2026-05-19 16:18:33', '2026-05-19 16:21:36', 'admin', 1);
INSERT INTO `users` VALUES (2, 'Admin', 'admin@bengkel.com', NULL, '$2y$12$.xmhjxOj4fiuZ8c9PX3LxOSAW3gh1ia0EXhkfKVDOcEjd4HAigGCC', NULL, '2026-05-22 13:56:54', '2026-05-22 13:56:54', 'admin', 1);
INSERT INTO `users` VALUES (3, 'Kasir', 'kasir@bengkel.com', NULL, '$2y$12$mwLFJUByUWsv0RdjUFrch.q8zQbIB8GNKt9Im8ilo8ZSIMTrZiJB6', NULL, '2026-05-22 13:56:55', '2026-05-22 13:56:55', 'kasir', 1);

SET FOREIGN_KEY_CHECKS = 1;

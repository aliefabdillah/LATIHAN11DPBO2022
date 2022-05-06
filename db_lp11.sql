/*
 Navicat Premium Data Transfer

 Source Server         : MyConnection
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : db_lp11

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 06/05/2022 12:53:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for author
-- ----------------------------
DROP TABLE IF EXISTS `author`;
CREATE TABLE `author`  (
  `id_author` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_author`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of author
-- ----------------------------
INSERT INTO `author` VALUES (1, 'Richard Adkins', 'Senior');
INSERT INTO `author` VALUES (2, 'Pein Akatsuki', 'Senior');
INSERT INTO `author` VALUES (4, 'Ken Northwood', 'Pendatang Baru');
INSERT INTO `author` VALUES (5, 'ad', 'Pendatang Baru');

-- ----------------------------
-- Table structure for buku
-- ----------------------------
DROP TABLE IF EXISTS `buku`;
CREATE TABLE `buku`  (
  `id_buku` int NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `penerbit` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_author` int NOT NULL,
  PRIMARY KEY (`id_buku`) USING BTREE,
  INDEX `id_author`(`id_author`) USING BTREE,
  CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of buku
-- ----------------------------
INSERT INTO `buku` VALUES (1, 'Alan Wade', 'Premium #', 'Cerita dibalik cerita', 'Best Seller', 2);
INSERT INTO `buku` VALUES (2, 'Awan', 'Akamedia', 'buku tentang cerita awan, hujan, langit', 'Best Seller', 1);
INSERT INTO `buku` VALUES (4, 'Puisi Patrick Star', 'Patrick', 'mawar itu biru, violet itu merah', '-', 2);

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `nim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jurusan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`nim`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('2003623', 'Adam Levine', 'Ilmu Komputer');
INSERT INTO `member` VALUES ('2222221', 'Rojali Ihcsan', 'Biologi');

-- ----------------------------
-- Table structure for peminjaman
-- ----------------------------
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman`  (
  `id_peminjaman` int NOT NULL AUTO_INCREMENT,
  `nim` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_buku` int NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_peminjaman`) USING BTREE,
  INDEX `nim`(`nim`, `id_buku`) USING BTREE,
  INDEX `id_buku`(`id_buku`) USING BTREE,
  INDEX `nim_2`(`nim`) USING BTREE,
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `member` (`nim`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of peminjaman
-- ----------------------------
INSERT INTO `peminjaman` VALUES (7, '2222221', 4, 'Sudah Dikembalikan');
INSERT INTO `peminjaman` VALUES (9, '2003623', 4, 'Dalam Peminjaman');
INSERT INTO `peminjaman` VALUES (10, '2003623', 1, 'Dalam Peminjaman');

SET FOREIGN_KEY_CHECKS = 1;

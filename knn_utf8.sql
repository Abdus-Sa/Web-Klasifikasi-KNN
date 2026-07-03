-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: knn
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dataset`
--

DROP TABLE IF EXISTS `dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `jalur_pendaftaran` varchar(50) DEFAULT NULL,
  `gelombang` varchar(20) DEFAULT NULL,
  `sistem_kuliah` varchar(50) DEFAULT NULL,
  `l_p` varchar(20) DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `nilai_lulusan` float DEFAULT NULL,
  `tahun_lulus` int(4) DEFAULT NULL,
  `jenjang_pendidikan` varchar(50) DEFAULT NULL,
  `jenis_institusi` varchar(50) DEFAULT NULL,
  `jurusan_sekolah` varchar(50) DEFAULT NULL,
  `propinsi_institusi` varchar(100) DEFAULT NULL,
  `prodi_yg_diterima` varchar(100) DEFAULT NULL,
  `klasifikasi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset`
--

LOCK TABLES `dataset` WRITE;
/*!40000 ALTER TABLE `dataset` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hasil_hitung`
--

DROP TABLE IF EXISTS `hasil_hitung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hasil_hitung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `jalur_pendaftaran` varchar(50) DEFAULT NULL,
  `gelombang` varchar(20) DEFAULT NULL,
  `sistem_kuliah` varchar(50) DEFAULT NULL,
  `l_p` varchar(20) DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `nilai_lulusan` float DEFAULT NULL,
  `tahun_lulus` int(4) DEFAULT NULL,
  `jenjang_pendidikan` varchar(50) DEFAULT NULL,
  `jenis_institusi` varchar(50) DEFAULT NULL,
  `jurusan_sekolah` varchar(50) DEFAULT NULL,
  `propinsi_institusi` varchar(100) DEFAULT NULL,
  `prodi_yg_diterima` varchar(100) DEFAULT NULL,
  `jarak_hasil` float DEFAULT NULL,
  `nilai_k` int(11) DEFAULT NULL,
  `klasifikasi` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hasil_hitung`
--

LOCK TABLES `hasil_hitung` WRITE;
/*!40000 ALTER TABLE `hasil_hitung` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil_hitung` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knn_akurasi_k`
--

DROP TABLE IF EXISTS `knn_akurasi_k`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knn_akurasi_k` (
  `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT,
  `nilai_k` int(11) NOT NULL,
  `nilai_akurasi` decimal(5,2) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `tanggal_proses` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_evaluasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knn_akurasi_k`
--

LOCK TABLES `knn_akurasi_k` WRITE;
/*!40000 ALTER TABLE `knn_akurasi_k` DISABLE KEYS */;
/*!40000 ALTER TABLE `knn_akurasi_k` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knn_confusion_matrix`
--

DROP TABLE IF EXISTS `knn_confusion_matrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knn_confusion_matrix` (
  `id_matrix` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_asli` varchar(50) NOT NULL,
  `kelas_prediksi` varchar(50) NOT NULL,
  `jumlah_data` int(11) NOT NULL,
  `tanggal_proses` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_matrix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knn_confusion_matrix`
--

LOCK TABLES `knn_confusion_matrix` WRITE;
/*!40000 ALTER TABLE `knn_confusion_matrix` DISABLE KEYS */;
/*!40000 ALTER TABLE `knn_confusion_matrix` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-14 22:11:33

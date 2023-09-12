-- MySQL dump 10.13  Distrib 8.0.33, for macos11.7 (x86_64)
--
-- Host: localhost    Database: user_management_system
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `password` char(60) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `privilege` varchar(100) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'boss','bossemail@gmail.com','$2y$10$JKea8IDpQJ8Rce3FrULeCef5v/KbDqIdzZYdL8oeg/dN2OfAhM/Bu','add_user, list_user, edit_user, delete_user'),(2,'add_user','add_user@gmail.com','$2y$10$xJUulTL/XfyQbsVMhcbWMuvibGxqeTzO7LMgV1P6rTPD2ZmM3vj56','add_user, list_user, edit_user'),(3,'list_user','list_user@gmail.com','$2y$10$i7FRZs9i2iDxyAlkgzvfXeox/c4VSLnAm9mx0SFxhGl1.xTPSV7oe','list_user, edit_user'),(4,'john','john@gmail.com','$2y$10$oHC2a7Ej8IlB.dXmGitZ9eNnKM5smkxgfx.46PkOQR7KBhbHhqFIy','list_user, edit_user, delete_user'),(5,'rob','rob@gmail,com','$2y$10$c.G1Xd7Rtzzg.cN.7RalUeNGkoYXfRC3OWhsu.GAsnWj0mK5PrsSK','add_user, list_user, delete_user'),(6,'tom','tom@gmail.com','$2y$10$0lanhMSBQDmh25pr5qTBA.EKOM96Mb6/TjzH1i/hmFPT3hMz1MYG2','list_user, delete_user'),(7,'matt','matt@gmail.com','$2y$10$jxtvd9Vhuek0Ho4mxBB.k.MQSmLioIg.UECX4xBVQ57qbR0V1Xmky','list_user'),(8,'tony','tony@gmail.com','$2y$10$BZu2O3dG4fCtC/LhdfHFje760h7ZEU3aFcBziJ65AZC/hrD7W13Oi','add_user');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `phone_no` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John','Doe','johndoe@gmail.com','2023-07-28 01:22:18','2023-07-29 12:38:24','0123456789','$2y$10$LwldZdGCObWrDhvSODgjluof12/aKcBLxfxjamo4vdaZfAO.X0yOK'),(2,'Rohan','Wari','rohan_wari@gmail.com','2023-07-28 18:56:44','2023-07-28 18:56:44','0000000000','$2y$10$XlcX.J9Bi56D9tDMm4nCAu1x9o4lPjnxPaWWG9cpcSKIU9s83ggRm'),(3,'Prateek','Bose','p.bose@gmail.com','2023-07-28 19:07:57','2023-07-28 19:07:57','1231231231','$2y$10$PLX5c0N49n7oMIKVCxSip.i6ELVvQHK2d5KWXjO4QEKA8mbxqFAQO'),(4,'Pulik','Reddy','reddy_pulkit@gmail.com','2023-07-28 19:14:20','2023-07-28 19:14:20','0909090909','$2y$10$Xz7K4Ok9ZeHZKzBIYTjqNueMerzF6KI3isKOnH/x6.BDXMP9SZxxy'),(5,'Rahul','verma','rahulv@gmail.com','2023-07-28 19:16:50','2023-07-28 19:16:50','0987890987','$2y$10$gep1P2rhjhUWf0heU4hLAeWseHz4npPp9HNH8TSL2FPUxxaiu8Z7G'),(6,'Rohit','Roenlk','test@example.com','2023-07-29 13:11:07','2023-07-29 13:11:07','0123456789','$2y$10$Elc7qKSi.xHekxh1YbSb6O1yo/pZxd3tYDrHbc5Ri21.4m5U0oZhq'),(7,'Abhishek','Kumar','abhikumar@example.com','2023-07-29 19:50:21','2023-07-29 19:50:21','8978905678','$2y$10$f42bGj/n5nTuQU62pp5N3.VbgN6cRMeV21OANmHd94jgr7s4c0A7m'),(8,'Ankur','Pandit','ankur_pandit@gmail.com','2023-07-30 00:11:33','2023-07-30 00:11:33','0987654329','$2y$10$3kjfFtVcyzebdCsSyRJzZOc/6Ekh5TB487nwyvJnj1rz237v.xE8K'),(9,'Yxcliid','Yetlwl','erlDD0Xb@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','0589842112','$2y$10$irQUh7FSBHgX1ITLQMrHqOkvETp3wq9FK.Y2JitSHdVtNndZCKXXC'),(10,'Xywtmzm','Gjdakm','0SGLqPTK@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','4024689898','$2y$10$kMaxQO9kK/QUfk9PitDOAuBwL9vbekVKqC6T421oyFbD/CBb1lOdO'),(11,'Sugxmqm','Ridgdt','uOhq6llx@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','9189395131','$2y$10$6A6DtL.ot.nNdhv.V7rg2.zOBBT30XWjpw9pY.GIyl.uKa0lba0Wy'),(12,'Jhtyqqq','Qohbik','TqmzmyBt@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','0875339643','$2y$10$CnLBcxMh/cWsRpu6o4U15.dLphw5TLdw.ZRInc1OLCrc6gjsY5jWi'),(13,'Qpdzcmv','Zzkesn','J8puVbzH@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','6150467761','$2y$10$JWKteginQfeXBmAU0kedquSv2.x9ZG.pG/GvsSQ0Aoz3vFyjxioye'),(14,'Ywadshf','Rmeduw','u2KoUPvp@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','5390282977','$2y$10$R2Oog/wtYgqRFt1FvwEJvOAsVUjSOY332K2uD8EM0vIlP9QMKAiJS'),(15,'Smbncuy','Wedehu','KCA8Gm2e@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','9000831393','$2y$10$S176Rb0zkK7onjPueNm8NuM1GwKEv5sLF8eijGTf.xha0fEewAOvC'),(16,'Ufjmizf','Czhges','SNqNw1LY@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','2183308918','$2y$10$hfvJ8y54ORbvRsm4G1aFj.0zOhBipSwgB2lOvuDYuB.U3eybm1mC.'),(17,'Nafzkzc','Gxyouo','v8DzaMtK@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','3763228434','$2y$10$wt/W5qlnD1peYqZ0Z/EKReUtVCqhtdc.nw375ZvvPRBfz1YqQ7jze'),(18,'Xrokzul','Mdbktg','a6zilTTP@gmail.com','2023-07-30 00:13:30','2023-07-30 00:13:30','1575169613','$2y$10$MUc8nfqOyqgeMFT9klboLuj5OWxHYN2nK1EK6UdEJ/SujH9V7uXNq'),(19,'Bbfoofl','Fdvlca','rZMOJyYM@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','5181422051','$2y$10$k9/uQFZkCeqaW7tFt5LQAe6.mINu/Vm1pqAkyI8NGoEFOKoW1BrZ2'),(20,'Gkcdylv','Qksctb','mgCRYFp8@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','9705315321','$2y$10$7cu.sTQ1VVSNuTKiWuz2Hepj/XEF5AsUAMczvSvEEr0.u10fKYomi'),(21,'Texvwki','Eoadhx','FlxVoC8h@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','0746745380','$2y$10$o./HJvEIY3J7DIXKTs8v/O1mmbOVS9J4T9hAebt.pEWcfoCUhisgK'),(22,'Wexaubt','Enzeya','vJeubARB@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','7299364428','$2y$10$ze0iSRtvnbUmR1Lb6NSEgOlzU1.DbRdl7AKW7CEyMvqq5Nlk5prXu'),(23,'Ykkagjf','Ogpxri','RYNB1gqA@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','6795579098','$2y$10$JW3kZRbYS/sFITBKXL/KMuZf5JY5gummtSb6vCY3MzBxJX.lQfvpa'),(24,'Gcddbxl','Cwmxxs','aqlpvCnG@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','8807109645','$2y$10$/smiVs.jmqNt1A0xXJObEuEIgltCjHKKssOcTVpCGYbovQ3bmU.Qq'),(25,'Pjfftew','Njyewx','X1xFLeAT@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','2595643831','$2y$10$4r.Ov/Vm4WNVuSgm4rta7.6fMpY81A3wah8fWL3LVMy.o/2EzqdWi'),(26,'Xmkrinh','Faiejo','8HZyQ1Ra@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','4673542066','$2y$10$v5NcXB2Vj6kIK4x0c1hCvOUiQoTMX342i6aEMmW.cDI8oPMkF9D5C'),(27,'Blcntbh','Mlbsaf','aE8ANlhR@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','7387327453','$2y$10$1mW4gzGQbEPX1Ksn5dWZR.7lAzyNz8w06Armc8VZWFz0qVSrOPE.a'),(28,'Nvimuih','Udjwsz','Am5IUHvt@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','0438161475','$2y$10$CVy4LozF5Od1AD1R05fgbOevBzXFCPpR9NKqg7GTl8uvRFx2SkH5u'),(29,'Clflzfh','Odbcht','U7Cq8de2@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','5572090602','$2y$10$HW/JYVlFOw7Q9HO6sg22au3QaXa8Ef1DvOevsUKtdYHrJwmypSPay'),(30,'Ngmxhsy','Shyamc','ETnyrQ9Y@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','4770380353','$2y$10$rHMA8It3kmveEPvsEVXTY.TwucxKpNATi4gV35ZsYGLTrhK1h8dyi'),(31,'Udkhmhm','Aujujb','Ed88HJbq@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','4562839015','$2y$10$cjoZfF/5FIzVLRRGAVjmgeId0kMs9.us1p2n2Z7KtmqtzJeQhFegy'),(32,'Tiutkuc','Jfvrip','pEXU1hax@gmail.com','2023-07-30 00:13:31','2023-07-30 00:13:31','4144200009','$2y$10$pjEPIaWCMMXMDlSxQyDwZeHaG0xEi1U9/lOyFE1fXj2TgOQK24vxG'),(33,'Rnpuhld','Mznsqy','Z7ohF7sT@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','3896665594','$2y$10$hfGNif7n2GB25sj51LfyV.gfHQbEyrgbFKN6bH35oVAZ3DiVQJXv.'),(34,'Umteqst','Npnhgx','oWJwgALs@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','4840795458','$2y$10$1ZY0l6Hf7xAeLnP98mU8wecyv6zZyRBGA2zlUAMQ0QsDGfui7lrme'),(35,'Ceymhiv','Aqkilj','rVwC6YiE@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','9941064065','$2y$10$VTcDl1s8DdZhLf7/4qOdAO13j/vE0qGdXs9yEv.9x/5ndw2WHewqq'),(36,'Jmqnkoc','Ihpwcv','1twBkF9F@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','3244574041','$2y$10$UYl.6qM8DB.DFeGDKW4I1.RhUOKhOGw6GaDmpx3feIoTAS7L.n4NW'),(37,'Zxumttn','Jhtzcr','yTgcxbnH@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','6319461973','$2y$10$RsT7BYThFoTVob.kckFyF.S6/fcWue2W0XBqV7.AZJ5GAM.AX6AfC'),(38,'Truhkvf','Ghjjwd','0ddZmqaX@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','4582505076','$2y$10$wTe1c9yQ3UZB1sNOCqQyBOShGuGfydYQaHMzwuLMCFfnIzRNyT/YG'),(39,'Yzzpbgj','Gvrrql','dp0FO5WW@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','7079380578','$2y$10$Z1Y9gTQ37E7qSYBxrIaE4uoRFyvedv1zsiy6ZxWwk9mgiGR0AQFOm'),(40,'Pkmbmfl','Aqouow','PnacSqHt@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','6415886868','$2y$10$/U.5YNQxvXzY3S0PHyrkPe3nCKOW9g5Sx7wRum8YQ3CjTJStp6Kgq'),(41,'Jlwsqxn','Evaadt','UXgQFk36@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','5197867526','$2y$10$bruAECJo8LHsNy95qVuXiu0P6DQDaVvC2bTzrkjLZ1xF0nEZ7SS02'),(42,'Dlahpth','Xunflh','CaZlX0Bw@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','4213723688','$2y$10$4Y.0sHnEjp3vTWneNL.wVeMMvBrQ1MwUUQgFkh81N0hDnz2U7j0sG'),(43,'Aphivxp','Cbebqb','IRJRYdDY@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','1459234578','$2y$10$zhKJX03gIVdXkIJGjOVo8uvOr94Emr19NJ31cY9A0PlBloE5aOzSK'),(44,'Dooaujv','Bbhwjo','8NylBkfB@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','7195196510','$2y$10$HNVWjoPls3mt3zGi4EGmDOK0BOOlvCPxkI83YyYN7UewMqF8afAPG'),(45,'Rcaqdth','Mmrelp','hM02Xf4r@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','5012709243','$2y$10$/l9KU44wp9c.ZHPULQSg4.bGQXHywjRErYGV2COWC5.F2E1MiUuCC'),(46,'Vpmqdpm','Qvgoau','IUSWrYyy@gmail.com','2023-07-30 00:13:32','2023-07-30 00:13:32','0496754917','$2y$10$OZAI3m6qC6qT5f9NJYH/VOovObr/MfVSqQlEIzJSch/ZhwWg4QstG'),(47,'Tkdyjtb','Mzvkgg','Darc7ykO@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','2543080156','$2y$10$RKbUqJXpX2V9FkAQ40SXVeAxa.NjGD4sQJ7bdzFwn0sqCL4MzN1Tq'),(48,'Dmrvdym','Aputgx','qkHI7PZF@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','4256481948','$2y$10$nEKfU5aXgMdpYbuMJnXxT.VLtpxSF7Bul5X.MLR8l8PdE.ccjUmqG'),(49,'Awccgsj','Jvqobz','6KuGwjZX@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','2280571067','$2y$10$2Kuf.5iGrjuNVq8oQylpCuTvRjXK9c6NAKnsqNo1OR4yKgFuTYQP6'),(50,'Afbazxz','Avheuk','EJdwU4Lc@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','8892959579','$2y$10$JFRU9X7ZkDxAlZ.KhObrPOGsuTg9qioHeMbEnJT8rOQY1O8FlY/DC'),(51,'Vqqebyl','Ojbsss','t1fwA9pl@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','4871688185','$2y$10$Ve1u7bTgAcU88lT/B5TmlexT0cdQgT3RMOhXdSgGFJnFI6WlKCehe'),(52,'Vhhjrua','Iadecl','W5QIAxcJ@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','5842256034','$2y$10$s9jj.L0PWC3q7q2VGiPX4edq7rtVfGru0SkvOkY62uu2p85Q1TUQe'),(53,'Fvgpyvg','Eshmrn','HVpTNlDR@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','8126947242','$2y$10$WIyzY8Fo2C.RY66abKEfnO5f639brvsqxaeVmk5P.WTxZxb5fufGC'),(54,'Kxtxzjs','Eqvmcr','hkwXC5Np@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','3254369515','$2y$10$uKM7b1TynDAL/xj3S/u8G.umDUnhe6LW8b3SdU.GH6C1NQQcq9xqO'),(55,'Kbktchj','Mnpvzk','XCRANu7S@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','2998542585','$2y$10$Z/kxuXRo6AuPNUo4PH5pcuzfIffDOKlc3fU8W7U2nZ1At09VonMs.'),(56,'Knrxcka','Ytaqfs','NFvppail@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','7872001567','$2y$10$xEZ/eYC/KRI1FIBTcsgkh.cIfhsXRWEzxK/sfOyjgmYdUC92NpEqK'),(57,'Kzrkffr','Xwhlqb','T7LaKo1h@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','8192700115','$2y$10$t6F4ZtaNf3WXxQhSVUz9VueqIv8qLfbhYb2BhqSNs4hrbzimBi0/y'),(58,'Xzikpob','Msqbnz','PFQpdn8i@gmail.com','2023-07-30 00:13:33','2023-07-30 00:13:33','9952616491','$2y$10$sjC.tyJZ1ik.dcw5rKBHvONphAH3UIUvZKLYws6yRvWK68QtiA4GO'),(59,'Ankit','Pandey','ankit_rcokt@gmail.com','2023-07-30 00:17:42','2023-07-30 00:17:42','0987653329','$2y$10$6dHEwDI9wK9190./9Rh88exSqSN4PPf1Cj/T.aGTuNYthgJ0VNUaq'),(60,'Wohop','Roper','wohoroper@gmail.com','2023-07-31 20:57:39','2023-07-31 20:57:39','0987890999','$2y$10$1ARpSN1I30xH5Ojw5ECTT.MLSLM12Fbo9nhA.Mw17RHcvHD/l30uu'),(61,'Jnkga','Rqrwsaf','jsfnka@gmail.com','2023-07-31 21:00:35','2023-07-31 21:00:35','0987800999','$2y$10$kXiPajKksWgaRH7g4fiZXOnCoAZOu8W0XsmlNJSv6xcpRnK3e9EQy'),(62,'Pofnajf','Wnanfla','agkjnw3@gmail.com','2023-07-31 21:01:08','2023-07-31 21:01:08','0987803299','$2y$10$jFPkdvKHFh5C8OQ0erCbbOzaupDODoGd9JmOJ2v/TAGHaO/m8CQi2'),(64,'Kabir','Solak','ksabff@gmail.com','2023-07-31 21:08:02','2023-07-31 21:08:02','1231233450','$2y$10$4hwqEagTi5QMxr3gubc8u.Pr92LMjo895t4Rcf/109P9gau.ZKIaC'),(65,'Kabir','Solak','ksabff@gmail.com','2023-07-31 21:10:40','2023-07-31 21:10:40','1231233450','$2y$10$2PWZvgvLiw.S79ZpiVGL0.cH81PJ/.kNWxebZXdokWhROoyuMdKDm');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-07 20:05:57

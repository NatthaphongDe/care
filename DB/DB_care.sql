-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 10.8.98.111    Database: caredb
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Backlist_Complnt`
--

DROP TABLE IF EXISTS `Backlist_Complnt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Backlist_Complnt` (
  `backlist_id` int NOT NULL AUTO_INCREMENT,
  `complnt_trade_number` varchar(50) NOT NULL,
  `complnt_name` varchar(100) NOT NULL,
  `backlistTmp_create_datetime` datetime NOT NULL,
  `backlistTmp_createBy_id` int NOT NULL,
  PRIMARY KEY (`backlist_id`),
  KEY `backlistTmp_createBy_id` (`backlistTmp_createBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Banner`
--

DROP TABLE IF EXISTS `Banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Banner` (
  `banner_id` int NOT NULL AUTO_INCREMENT,
  `banner_img_name` varchar(100) NOT NULL,
  `banner_img_name_en` varchar(100) NOT NULL,
  `banner_img_path` varchar(225) NOT NULL,
  `banner_img_path_en` varchar(255) NOT NULL,
  `banner_status` int NOT NULL COMMENT '	0=normal, 1=delete',
  `banner_enable` int NOT NULL COMMENT '	0=disable, 1=enable',
  `banner_up_dow` int NOT NULL,
  `banner_createBy_id` int NOT NULL,
  `banner_create_datetime` datetime NOT NULL,
  `banner_updateBy_id` int NOT NULL,
  `banner_update_datetime` datetime NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case`
--

DROP TABLE IF EXISTS `Case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case` (
  `case_id` int NOT NULL AUTO_INCREMENT,
  `compType_id` int DEFAULT NULL,
  `compTypeSub1_id` int DEFAULT NULL,
  `compTypeSub2_id` int DEFAULT NULL,
  `compType_other` varchar(255) NOT NULL,
  `case_status` int NOT NULL COMMENT '0=Waiting, 1=New, 2=Pending, 3=Close',
  `case_assign_status` int NOT NULL COMMENT '0=not assign, 1=assign',
  `caseCh_id` int NOT NULL,
  `case_priority` int NOT NULL COMMENT 'เชื่อมกับ ตาราง Case_Priority   1=ปกติ, 2=ด่วนมาก, 3=ด่วนที่สุด',
  `case_compType_duration` int NOT NULL COMMENT 'ระยะเวลาดำเนินงาน',
  `case_open_date` date DEFAULT NULL,
  `case_receivedoc_date` date DEFAULT NULL,
  `case_receivedoc_real_datetime` datetime DEFAULT NULL,
  `case_receivedoc_number` varchar(45) NOT NULL,
  `case_receivedoc_file_path` varchar(255) DEFAULT NULL,
  `case_receivedoc_file_oldname` varchar(100) DEFAULT NULL,
  `case_receivedoc_file_name` varchar(255) DEFAULT NULL,
  `case_receivedoc_file_ext` varchar(45) DEFAULT NULL,
  `case_close_datetime` datetime DEFAULT NULL,
  `case_close_createBy_id` int DEFAULT NULL,
  `caseClose_id` int DEFAULT NULL,
  `case_close_resultProcess` text,
  `case_disKPI_status` int NOT NULL COMMENT '0=normal,1=dis-KPI',
  `case_disKPI_datetime` datetime DEFAULT NULL,
  `case_disKPI_createBy_id` int DEFAULT NULL,
  `caseDtl_title` varchar(255) NOT NULL,
  `prodType_id` int NOT NULL,
  `prodType_id_old` int NOT NULL,
  `office_id` int NOT NULL,
  `prodType_other` varchar(255) NOT NULL COMMENT 'สินค้าอื่นๆ',
  `incType_id` int NOT NULL,
  `incType_other` varchar(255) NOT NULL,
  `caseDtl_derivation` text NOT NULL,
  `caseDtl_damage_val` double NOT NULL,
  `curren_id` int NOT NULL,
  `caseDtl_complnt_need` text NOT NULL,
  `applntOrg_trade_number` varchar(50) NOT NULL,
  `applntOrg_name` varchar(255) NOT NULL,
  `applnt_ident` varchar(50) NOT NULL,
  `applnt_firstname` varchar(255) NOT NULL,
  `applnt_lastname` varchar(255) NOT NULL,
  `applnt_type` int NOT NULL COMMENT '0=ไม่เลือก, 1=เป็นตวแทนบริษัท, 2=เป็นตัวแทนองค์กร',
  `applnt_ident_valid` int NOT NULL COMMENT '0=ยังไม่ตรวจสอบ, 1=ตรง, 2=ไม่ตรง',
  `applnt_status` int NOT NULL COMMENT '0=มีข้อมูล, 1=ไม่มีข้อมูล',
  `complntOrg_trade_number` varchar(50) NOT NULL,
  `complntOrg_name` varchar(255) NOT NULL,
  `complnt_ident` varchar(50) NOT NULL,
  `complnt_firstname` varchar(255) NOT NULL,
  `complnt_lastname` varchar(255) NOT NULL,
  `complnt_type` int NOT NULL COMMENT '0=ไม่เลือก, 1=เป็นตวแทนบริษัท, 2=เป็นตัวแทนองค์กร	',
  `complnt_ident_valid` int NOT NULL COMMENT '0=ยังไม่ตรวจสอบ, 1=ตรง, 2=ไม่ตรง	',
  `complnt_status` int NOT NULL COMMENT '0=มีข้อมูล, 1=ไม่มีข้อมูล',
  `applnt_trade_number` varchar(50) NOT NULL,
  `applnt_name` varchar(255) NOT NULL,
  `complnt_trade_number` varchar(50) NOT NULL,
  `complnt_name` varchar(255) NOT NULL,
  `complnt_contact_name` varchar(255) DEFAULT NULL,
  `complnt_contact_email` varchar(255) DEFAULT NULL,
  `complnt_contact_tel` varchar(100) DEFAULT NULL,
  `applnt_country_id` int NOT NULL,
  `complnt_country_id` int NOT NULL,
  `applntOrg_country_id` int NOT NULL,
  `applnt_backlist` int NOT NULL COMMENT '0=uncheck, 1=normal, 2=backlist	',
  `complnt_backlist` int NOT NULL COMMENT '0=uncheck, 1=normal, 2=backlist',
  `applnt_valid_dbd` int NOT NULL COMMENT '0=ยังไม่ตรวจสอบ, 1=ตรง, 2=ไม่ตรง',
  `applnt_valid_ditp` int NOT NULL COMMENT '0=ยังไม่ตรวจสอบ, 1=ตรง, 2=ไม่ตรง',
  `applnt_valid_ditp_org` varchar(255) NOT NULL,
  `complnt_valid_dbd` int NOT NULL COMMENT '0=ยังไม่ตรวจสอบ, 1=ตรง, 2=ไม่ตรง',
  `complnt_valid_ditp` int NOT NULL COMMENT '0=ยังไม่ตรวจสอบ, 1=ตรง, 2=ไม่ตรง	',
  `complnt_valid_ditp_org` varchar(255) NOT NULL,
  `case_step_detail` int NOT NULL COMMENT '0=no, 1=yes',
  `case_create_datetime` datetime NOT NULL,
  `case_createBy_id` int NOT NULL,
  `isStaff` int NOT NULL DEFAULT '9' COMMENT '0=public, 1=staff, 9=web	',
  `case_createBy_staff_id` varchar(255) NOT NULL,
  `case_update_datetime` datetime DEFAULT NULL,
  `case_updateBy_id` int DEFAULT NULL,
  `case_lastSave_datetime` datetime DEFAULT NULL,
  `case_lastSave_id` int DEFAULT NULL,
  `case_notice_applnt_datetime` datetime DEFAULT NULL,
  `case_notice_applnt_createBy_id` int DEFAULT NULL,
  `case_setsubject_datetime` datetime DEFAULT NULL,
  `case_setsubject_createBy_id` int DEFAULT NULL,
  `case_opened_datetime` datetime DEFAULT NULL,
  `case_opened_createBy_id` int DEFAULT NULL,
  `case_opened_note` text NOT NULL,
  `case_knowledge_type` int NOT NULL COMMENT '0=ไม่ใช่,1=ใช่',
  `case_step_noti` int NOT NULL COMMENT 'อยู่ step ที่เท่าไหร่',
  `check_transfer` int NOT NULL,
  `reliable` int DEFAULT NULL COMMENT '1:น่าเชื่อถือ 2:ไม่น่าเชื่อถือ',
  `reliable_sub` int DEFAULT NULL COMMENT '1:Watchlist 2:Blacklist',
  `request_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `reference_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`case_id`),
  KEY `case_createBy_id` (`case_createBy_id`),
  KEY `compType_id` (`compType_id`),
  KEY `compTypeSub1_id` (`compTypeSub1_id`),
  KEY `compTypeSub2_id` (`compTypeSub2_id`),
  KEY `caseClose_id` (`caseClose_id`),
  KEY `case_updateBy_id` (`case_updateBy_id`),
  KEY `prodType_id` (`prodType_id`),
  KEY `curren_id` (`curren_id`),
  KEY `caseCh_id` (`caseCh_id`),
  KEY `case_notice_applnt_id` (`case_notice_applnt_createBy_id`),
  KEY `case_setsubject_id` (`case_setsubject_createBy_id`),
  KEY `case_opened_id` (`case_opened_createBy_id`),
  KEY `case_close_id` (`case_close_createBy_id`),
  KEY `case_disKPI_create_id` (`case_disKPI_createBy_id`),
  KEY `complnt_country_id` (`complnt_country_id`),
  KEY `applnt_country_id` (`applnt_country_id`),
  KEY `case_priority` (`case_priority`),
  KEY `incorrectType_id` (`incType_id`),
  KEY `applntOrg_country_id` (`applntOrg_country_id`),
  CONSTRAINT `Case_ibfk_1` FOREIGN KEY (`case_priority`) REFERENCES `Case_Priority` (`casePrt_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2204 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Assign`
--

DROP TABLE IF EXISTS `Case_Assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Assign` (
  `caseAsign_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `caseAsign_status` int DEFAULT NULL COMMENT '0=normal, 1=delete',
  `emp_id` int NOT NULL,
  `caseAsign_disKPI` int NOT NULL COMMENT '1=dis-KPI',
  `caseAsign_create_datetime` datetime NOT NULL,
  `caseAsign_createBy_id` int NOT NULL,
  `caseAsign_update_datetime` datetime DEFAULT NULL,
  `caseAsign_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`caseAsign_id`),
  KEY `case_id` (`case_id`),
  KEY `caseAsign_crateBy_id` (`caseAsign_createBy_id`),
  KEY `emp_id` (`emp_id`),
  CONSTRAINT `Case_Assign_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `Case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1695 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Attachfile`
--

DROP TABLE IF EXISTS `Case_Attachfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Attachfile` (
  `caseAttach_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `caseAttach_title` varchar(100) DEFAULT NULL,
  `caseAttach_file_path` varchar(255) DEFAULT NULL,
  `caseAttach_file_oldname` varchar(100) NOT NULL,
  `caseAttach_file_name` varchar(100) DEFAULT NULL,
  `caseAttach_file_ext` varchar(20) DEFAULT NULL,
  `caseAttach_status` int DEFAULT NULL,
  `caseAttach_create_datetime` datetime NOT NULL,
  `caseAttach_createBy_id` int NOT NULL,
  `caseAttach_create_type` int NOT NULL COMMENT '1=WebApp, 2=Backoffice',
  PRIMARY KEY (`caseAttach_id`),
  KEY `case_id` (`case_id`),
  KEY `caseAttach_createBy_id` (`caseAttach_createBy_id`),
  CONSTRAINT `Case_Attachfile_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `Case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2853 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Channel`
--

DROP TABLE IF EXISTS `Case_Channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Channel` (
  `caseCh_id` int NOT NULL AUTO_INCREMENT,
  `caseCh_level` int NOT NULL,
  `caseCh_ref_id` int NOT NULL,
  `caseCh_name` varchar(255) NOT NULL,
  `caseCh_type` int NOT NULL COMMENT '1="From Mobile App", 2="From Web"',
  `caseCh_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `caseCh_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `caseCh_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `caseCh_create_datetime` datetime NOT NULL,
  `caseCh_createBy_id` int NOT NULL,
  `caseCh_update_datetime` datetime NOT NULL,
  `caseCh_updateBy_id` int NOT NULL,
  PRIMARY KEY (`caseCh_id`),
  KEY `caseCh_updateBy_id` (`caseCh_updateBy_id`),
  KEY `caseCh_createBy_id` (`caseCh_createBy_id`),
  KEY `caseCh_ref_id` (`caseCh_ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Close`
--

DROP TABLE IF EXISTS `Case_Close`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Close` (
  `caseClose_id` int NOT NULL AUTO_INCREMENT,
  `caseClose_title` varchar(100) DEFAULT NULL,
  `caseClose_lv` int NOT NULL,
  `caseClose_master_id` int NOT NULL,
  `caseClose_hasSub` int NOT NULL COMMENT '0=ไม่มีข้อย่อย, 1=มีข้อย่อย',
  `caseClose_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `caseClose_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ',
  `caseClose_create_datetime` datetime NOT NULL,
  `caseClose_createBy_id` int NOT NULL,
  `caseClose_update_datetime` datetime NOT NULL,
  `caseClose_updateBy_id` int NOT NULL,
  PRIMARY KEY (`caseClose_id`),
  KEY `caseClose_master_id` (`caseClose_master_id`),
  KEY `caseClose_by_id` (`caseClose_createBy_id`),
  KEY `caseClose_updateBy_id` (`caseClose_updateBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Knowledge`
--

DROP TABLE IF EXISTS `Case_Knowledge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Knowledge` (
  `caseKnlg_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `compType_id` int DEFAULT NULL,
  `incType_id` int NOT NULL,
  `caseKnlg_status` int NOT NULL COMMENT '0=Waiting, 1=Published, 2=Hide, 3=Delete',
  `caseKnlg_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `caseDtl_title` varchar(255) NOT NULL,
  `prodType_id` int NOT NULL,
  `caseDtl_derivation` text NOT NULL,
  `caseDtl_damage_val` double NOT NULL,
  `curren_id` int NOT NULL,
  `caseDtl_complnt_need` text NOT NULL,
  `applnt_name` varchar(100) NOT NULL,
  `complnt_name` varchar(100) NOT NULL,
  `caseClose_id` int NOT NULL,
  `case_close_resultProcess` text NOT NULL,
  `case_create_datetime` datetime NOT NULL,
  `case_createBy_id` int NOT NULL,
  `case_update_datetime` datetime DEFAULT NULL,
  `case_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`caseKnlg_id`),
  KEY `case_createBy_id` (`case_createBy_id`),
  KEY `compType_id` (`compType_id`),
  KEY `case_updateBy_id` (`case_updateBy_id`),
  KEY `curren_id` (`curren_id`),
  KEY `case_ref_id` (`case_id`),
  KEY `caseClose_id` (`caseClose_id`),
  KEY `compType_id_2` (`compType_id`),
  KEY `incType_id` (`incType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Priority`
--

DROP TABLE IF EXISTS `Case_Priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Priority` (
  `casePrt_id` int NOT NULL AUTO_INCREMENT,
  `casePrt_name` varchar(100) NOT NULL,
  `casePrt_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `casePrt_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `casePrt_img_name` varchar(30) NOT NULL,
  `casePrt_img_path` varchar(250) NOT NULL,
  `casePrt_color` varchar(10) NOT NULL,
  `casePrt_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `casePrt_create_datetime` datetime NOT NULL,
  `casePrt_createBy_id` int NOT NULL,
  `casePrt_update_datetime` datetime DEFAULT NULL,
  `casePrt_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`casePrt_id`),
  KEY `casePrt_createBy_id` (`casePrt_createBy_id`),
  KEY `casePrt_updateBy_id` (`casePrt_updateBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Case_Ref`
--

DROP TABLE IF EXISTS `Case_Ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Case_Ref` (
  `caseRef_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `case_ref_id` int NOT NULL,
  PRIMARY KEY (`caseRef_id`),
  KEY `case_id` (`case_id`),
  KEY `case_ref_id` (`case_ref_id`),
  CONSTRAINT `Case_Ref_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `Case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Complaint_Type`
--

DROP TABLE IF EXISTS `Complaint_Type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Complaint_Type` (
  `compType_id` int NOT NULL AUTO_INCREMENT,
  `compType_name` varchar(255) DEFAULT NULL,
  `compType_name_en` varchar(255) NOT NULL,
  `compType_other_flag` int NOT NULL COMMENT '0=no, 1=yes',
  `compType_order_sort` int NOT NULL,
  `compType_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `compType_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `compType_duration` int NOT NULL,
  `form_id` int NOT NULL,
  `compType_create_datetime` datetime NOT NULL,
  `compType_createBy_id` int NOT NULL,
  `compType_update_datetime` datetime DEFAULT NULL,
  `compType_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`compType_id`),
  KEY `compType_createBy_id` (`compType_createBy_id`),
  KEY `compType_updateBy_id` (`compType_updateBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Complaint_Type_Sub1`
--

DROP TABLE IF EXISTS `Complaint_Type_Sub1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Complaint_Type_Sub1` (
  `compTypeSub1_id` int NOT NULL AUTO_INCREMENT,
  `compType_id` int NOT NULL,
  `compTypeSub1_name` varchar(100) DEFAULT NULL,
  `compTypeSub1_name_en` varchar(255) NOT NULL,
  `compTypeSub1_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `form_id` int NOT NULL,
  `compTypeSub1_create_datetime` datetime NOT NULL,
  `compTypeSub1_createBy_id` int NOT NULL,
  `compTypeSub1_update_datetime` datetime DEFAULT NULL,
  `compTypeSub1_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`compTypeSub1_id`),
  KEY `compType_id` (`compType_id`),
  CONSTRAINT `Complaint_Type_Sub1_ibfk_1` FOREIGN KEY (`compType_id`) REFERENCES `Complaint_Type` (`compType_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Complaint_Type_Sub2`
--

DROP TABLE IF EXISTS `Complaint_Type_Sub2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Complaint_Type_Sub2` (
  `compTypeSub2_id` int NOT NULL AUTO_INCREMENT,
  `compTypeSub1_id` int NOT NULL,
  `compTypeSub2_name` varchar(100) DEFAULT NULL,
  `compTypeSub2_name_en` varchar(255) NOT NULL,
  `compTypeSub2_status` int NOT NULL,
  `form_id` int NOT NULL,
  `compTypeSub2_create_datetime` datetime NOT NULL,
  `compTypeSub2_createBy_id` int NOT NULL,
  `compTypeSub2_update_datetime` datetime DEFAULT NULL,
  `compTypeSub2_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`compTypeSub2_id`),
  KEY `compTypeSub1_id` (`compTypeSub1_id`),
  CONSTRAINT `Complaint_Type_Sub2_ibfk_1` FOREIGN KEY (`compTypeSub1_id`) REFERENCES `Complaint_Type_Sub1` (`compTypeSub1_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Complaint_procedure`
--

DROP TABLE IF EXISTS `Complaint_procedure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Complaint_procedure` (
  `cpp_id` int NOT NULL AUTO_INCREMENT,
  `cpp_detail` text NOT NULL,
  `cpp_detail_en` text NOT NULL,
  `cpp_img_name` varchar(255) NOT NULL,
  `cpp_img_path` varchar(100) NOT NULL,
  `cpp_up_dow` int NOT NULL,
  `cpp_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `cpp_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `cpp_create_datetime` datetime NOT NULL,
  `cpp_createBy_id` int NOT NULL,
  `cpp_update_datetime` datetime NOT NULL,
  `cpp_updateBy_id` int NOT NULL,
  PRIMARY KEY (`cpp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Contact_thai`
--

DROP TABLE IF EXISTS `Contact_thai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Contact_thai` (
  `ct_id` int NOT NULL AUTO_INCREMENT,
  `ct_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `ct_type` int NOT NULL COMMENT '1 = ประเทศ 2 = ต่างประเทศ',
  `ct_department` int NOT NULL COMMENT '1=บุคคลธรรมดา,2=หน่วยงานภาครัฐ,3=หน่วยงานภาคเอกฃน	',
  `ct_comp_type` int NOT NULL COMMENT '1=ผู้ร้องเรียน 2=ผู้ถูกร้องเรียน',
  `ct_card` varchar(20) NOT NULL,
  `ct_firstname` varchar(100) NOT NULL,
  `ct_lastname` varchar(100) NOT NULL,
  `ct_birthday` date NOT NULL,
  `ct_sex` int NOT NULL COMMENT '0=ไม่ระบุ ,1 = ชาย , 2 = หญิง',
  `ct_career` varchar(100) NOT NULL,
  `ct_homephone` varchar(15) NOT NULL,
  `ct_cellphone` varchar(15) NOT NULL,
  `ct_email` varchar(100) NOT NULL,
  `ct_address` varchar(225) NOT NULL,
  `prov_id` int NOT NULL,
  `ct_postcode` int NOT NULL,
  `Country_id` int NOT NULL,
  `ct_import` int NOT NULL COMMENT '0=เพิ่มปกติ 1=import',
  `ct_create_datetime` datetime NOT NULL,
  `ct_createBy_id` int NOT NULL,
  `ct_update_datetime` datetime NOT NULL,
  `ct_updateBy_id` int NOT NULL,
  `ct_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `ct_business_type` int NOT NULL COMMENT '0=อื่นๆ , 1=นำเข้า ,2=ส่งออก',
  `ct_numbertrade` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`ct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=551 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Continents`
--

DROP TABLE IF EXISTS `Continents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Continents` (
  `code` varchar(4) NOT NULL COMMENT 'Continent code',
  `name` varchar(255) DEFAULT NULL,
  `name_th` varchar(255) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Corporate`
--

DROP TABLE IF EXISTS `Corporate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Corporate` (
  `cpr_id` int NOT NULL AUTO_INCREMENT,
  `cpr_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `cpr_type` int NOT NULL COMMENT '1=ในประเทศ 2=ต่างประทศ',
  `cpr_comp_type` int NOT NULL COMMENT '	1=ผู้ร้องเรียน 2=ผู้ถูกร้องเรียน',
  `cpr_numbertrade` varchar(50) NOT NULL,
  `cpr_companyname` varchar(100) NOT NULL,
  `cpr_type_import_export` int NOT NULL COMMENT '0=ไม่ระบุ, 1=นำเข้า, 2=ส่งออก',
  `cpr_branch` varchar(100) NOT NULL,
  `cpr_telephone` varchar(15) NOT NULL DEFAULT '',
  `cpr_fax` varchar(20) NOT NULL,
  `cpr_email` varchar(100) NOT NULL,
  `cpr_address` varchar(250) NOT NULL,
  `prov_id` int NOT NULL,
  `cpr_zipcode` varchar(5) NOT NULL,
  `cpr_department` int NOT NULL COMMENT '0=ไม่ระบุ, 1=เป็นสมาชิกกรม 2 = ไม่เป็น',
  `cpr_contactfname` varchar(100) NOT NULL,
  `cpr_contactlname` varchar(100) NOT NULL,
  `Country_id` int NOT NULL,
  `cpr_contact_person` varchar(50) NOT NULL COMMENT 'ชื่อที่ติดต่อ',
  `cpr_import` int NOT NULL COMMENT '0=เพิ่มปกติ 1=import',
  `cpr_create_datetime` datetime NOT NULL,
  `cpr_createBy_id` int NOT NULL,
  `cpr_update_datetime` datetime NOT NULL,
  `cpr_updateBy_id` int NOT NULL,
  `cpr_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `cpr_web` varchar(255) DEFAULT NULL,
  `cpr_reliable` int NOT NULL COMMENT '0:ไม่มีสถานะ 1:watch list 2:black list	',
  PRIMARY KEY (`cpr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2230 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Country`
--

DROP TABLE IF EXISTS `Country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Country` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `continent_code` varchar(4) NOT NULL,
  `name_th` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL COMMENT 'Name of the country in English',
  `country_code_name` varchar(50) NOT NULL,
  `img_name` varchar(30) NOT NULL,
  `img_path` varchar(250) NOT NULL,
  `country_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `country_status` int NOT NULL COMMENT '0=normal, 1=delete	',
  `flag_32` varchar(255) DEFAULT NULL,
  `flag_128` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=434 COMMENT='Hold the list of countries. Each country is a row';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Currency`
--

DROP TABLE IF EXISTS `Currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Currency` (
  `curren_id` int NOT NULL AUTO_INCREMENT,
  `curren_name` varchar(45) DEFAULT NULL,
  `curren_rate` float DEFAULT NULL,
  PRIMARY KEY (`curren_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Department` (
  `dept_id` int NOT NULL AUTO_INCREMENT,
  `office_id` int NOT NULL,
  `caseCh_id` int NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `dept_affiliation` varchar(250) NOT NULL,
  `dept_director` text NOT NULL,
  `dept_tel` varchar(250) NOT NULL,
  `dept_fax` varchar(250) NOT NULL,
  `dept_address` text NOT NULL,
  `dept_email` varchar(250) NOT NULL,
  `dept_assistant` varchar(250) NOT NULL,
  `dept_message_noti` text NOT NULL,
  `dept_message_noti_en` text NOT NULL,
  `dept_type` int NOT NULL,
  `country_id` int NOT NULL,
  `dept_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `dept_status` int NOT NULL COMMENT '0=normal, 1=del',
  `dept_enable` int NOT NULL COMMENT '1=enable, 2=disable',
  `dept_create_datetime` datetime NOT NULL,
  `dept_createBy_id` int NOT NULL,
  `dept_update_datetime` datetime NOT NULL,
  `dept_updateBy_id` int NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Department_Type`
--

DROP TABLE IF EXISTS `Department_Type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Department_Type` (
  `deptType_id` int NOT NULL AUTO_INCREMENT,
  `deptType_name` varchar(225) NOT NULL,
  `deptType_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `deptType_has_nation` int NOT NULL COMMENT '0=ไม่มีทวีปประเทศ, 1=มีทวีปประเทศ',
  PRIMARY KEY (`deptType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Device_regis`
--

DROP TABLE IF EXISTS `Device_regis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Device_regis` (
  `device_regis_id` int NOT NULL AUTO_INCREMENT,
  `device_uuid` varchar(255) NOT NULL,
  `device_uuid_logout` text NOT NULL COMMENT 'token เก่าสำหรับคนที่ logout',
  `member_id` int NOT NULL,
  `device_platform` int NOT NULL COMMENT '1=android,2=ios',
  `device_registerDt` datetime NOT NULL,
  `device_visitedDt` datetime NOT NULL,
  `device_login_status` int NOT NULL COMMENT '0=ไม่ใช้งาน,1=ใช้งาน',
  PRIMARY KEY (`device_regis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Employee`
--

DROP TABLE IF EXISTS `Employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Employee` (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `emp_real_id` int(6) unsigned zerofill NOT NULL,
  `emp_firstname` varchar(100) NOT NULL,
  `emp_lastname` varchar(100) NOT NULL,
  `emp_email` varchar(100) NOT NULL,
  `emp_tel` varchar(45) NOT NULL,
  `emp_status` int DEFAULT NULL COMMENT '0=normal, 1=Delete',
  `office_id` int NOT NULL,
  `dept_id` int NOT NULL,
  `login_ldap` int NOT NULL COMMENT '1=login ldap ,0= login ปกติ',
  `username` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `empGroup_id` int NOT NULL,
  `emp_img_path` varchar(255) DEFAULT NULL,
  `emp_img_path_s` varchar(255) NOT NULL,
  `emp_img_name` varchar(100) DEFAULT NULL,
  `emp_img_ext` varchar(20) DEFAULT NULL,
  `emp_create_datetime` datetime NOT NULL,
  `emp_update_datetime` datetime DEFAULT NULL,
  `emp_last_login_datetime` datetime NOT NULL,
  `emp_available_dashboard` int NOT NULL COMMENT '1=available, 2=not available',
  `emp_enable_sys_login` int NOT NULL COMMENT '0=ไม่, 1=ใช่',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Employee_Group`
--

DROP TABLE IF EXISTS `Employee_Group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Employee_Group` (
  `empGroup_id` int NOT NULL AUTO_INCREMENT,
  `empGroup_name` varchar(100) NOT NULL,
  `empGroup_status` int NOT NULL COMMENT '0=normal, 1=del',
  `empGroup_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `empGroup_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `empGroup_level` int NOT NULL COMMENT '0=พนักงงาน, 1=superadmin, 2=ผู้จัดการ',
  `empGroup_create_datetime` datetime NOT NULL,
  `empGroup_createBy_id` int NOT NULL,
  `empGroup_update_datetime` datetime DEFAULT NULL,
  `empGroup_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`empGroup_id`),
  KEY `empGroup_updateBy_id` (`empGroup_updateBy_id`),
  KEY `empGroup_createBy_id` (`empGroup_createBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Employee_Group_Permission`
--

DROP TABLE IF EXISTS `Employee_Group_Permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Employee_Group_Permission` (
  `group_permission` int NOT NULL AUTO_INCREMENT,
  `empGroup_id` int NOT NULL,
  `page_id` int NOT NULL,
  `permission_create_date` datetime NOT NULL,
  PRIMARY KEY (`group_permission`),
  KEY `page_id` (`page_id`),
  KEY `empGroup_id` (`empGroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1985 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_App_Answers`
--

DROP TABLE IF EXISTS `Feedback_App_Answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_App_Answers` (
  `feedback_a_id` int NOT NULL AUTO_INCREMENT,
  `feedback_list_id` int NOT NULL,
  `feedback_q_id` int NOT NULL,
  `feedback_a_result` varchar(255) NOT NULL,
  PRIMARY KEY (`feedback_a_id`),
  KEY `feedback_q_id` (`feedback_q_id`),
  KEY `feedback_list_id` (`feedback_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_App_Choice`
--

DROP TABLE IF EXISTS `Feedback_App_Choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_App_Choice` (
  `feedback_c_id` int NOT NULL AUTO_INCREMENT,
  `feedback_q_id` int NOT NULL,
  `feedback_c_text` varchar(255) NOT NULL,
  `feedback_c_text_en` varchar(255) NOT NULL,
  `feedback_c_other_flag` int NOT NULL COMMENT '0=ไม่ต้องระบุ, 1=โปรดระบุ',
  PRIMARY KEY (`feedback_c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_App_List`
--

DROP TABLE IF EXISTS `Feedback_App_List`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_App_List` (
  `feedback_list_id` int NOT NULL AUTO_INCREMENT,
  `feedback_list_datetime` datetime NOT NULL,
  `feedback_list_by` int NOT NULL,
  PRIMARY KEY (`feedback_list_id`),
  KEY `feedback_list_by` (`feedback_list_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_App_Question`
--

DROP TABLE IF EXISTS `Feedback_App_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_App_Question` (
  `feedback_q_id` int NOT NULL AUTO_INCREMENT,
  `feedback_q_title` varchar(255) NOT NULL,
  `feedback_q_title_en` varchar(255) NOT NULL,
  `feedback_q_type` int NOT NULL COMMENT '1=textbox, 2=radio, 3=textarea',
  `feedback_q_chk` int NOT NULL COMMENT '1=*,0!=*	',
  PRIMARY KEY (`feedback_q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Backend_Answers`
--

DROP TABLE IF EXISTS `Feedback_Backend_Answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Backend_Answers` (
  `feedback_a_id` int NOT NULL AUTO_INCREMENT,
  `feedback_list_id` int NOT NULL,
  `feedback_q_id` int NOT NULL,
  `feedback_a_result` varchar(255) NOT NULL,
  PRIMARY KEY (`feedback_a_id`),
  KEY `feedback_q_id` (`feedback_q_id`),
  KEY `feedback_list_id` (`feedback_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Backend_List`
--

DROP TABLE IF EXISTS `Feedback_Backend_List`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Backend_List` (
  `feedback_list_id` int NOT NULL AUTO_INCREMENT,
  `feedback_list_datetime` datetime NOT NULL,
  `feedback_list_by` int NOT NULL,
  PRIMARY KEY (`feedback_list_id`),
  KEY `feedback_list_by` (`feedback_list_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Backend_Question`
--

DROP TABLE IF EXISTS `Feedback_Backend_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Backend_Question` (
  `feedback_q_id` int NOT NULL AUTO_INCREMENT,
  `feedback_q_title` varchar(255) NOT NULL,
  `feedback_q_type` int NOT NULL COMMENT '1=textbox, 2=radio, 3=textarea',
  `feedback_q_chk` int NOT NULL COMMENT '1 = * ,0 !=*',
  PRIMARY KEY (`feedback_q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Frontend_Answers`
--

DROP TABLE IF EXISTS `Feedback_Frontend_Answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Frontend_Answers` (
  `feedback_a_id` int NOT NULL AUTO_INCREMENT,
  `feedback_list_id` int NOT NULL,
  `feedback_q_id` int NOT NULL,
  `feedback_a_result` varchar(255) NOT NULL,
  PRIMARY KEY (`feedback_a_id`),
  KEY `feedback_q_id` (`feedback_q_id`),
  KEY `feedback_list_id` (`feedback_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28860 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Frontend_Choice`
--

DROP TABLE IF EXISTS `Feedback_Frontend_Choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Frontend_Choice` (
  `feedback_c_id` int NOT NULL,
  `feedback_q_id` int NOT NULL,
  `feedback_c_text` varchar(255) NOT NULL,
  `feedback_c_text_en` varchar(255) NOT NULL,
  `feedback_c_other_flag` int NOT NULL COMMENT '0=ไม่ต้องระบุ, 1=โปรดระบุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Frontend_List`
--

DROP TABLE IF EXISTS `Feedback_Frontend_List`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Frontend_List` (
  `feedback_list_id` int NOT NULL AUTO_INCREMENT,
  `feedback_list_datetime` datetime NOT NULL,
  `feedback_list_by` int NOT NULL,
  PRIMARY KEY (`feedback_list_id`),
  KEY `feedback_list_by` (`feedback_list_by`)
) ENGINE=InnoDB AUTO_INCREMENT=27339 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feedback_Frontend_Question`
--

DROP TABLE IF EXISTS `Feedback_Frontend_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Feedback_Frontend_Question` (
  `feedback_q_id` int NOT NULL,
  `feedback_q_title` varchar(255) NOT NULL,
  `feedback_q_title_en` varchar(255) NOT NULL,
  `feedback_q_type` int NOT NULL COMMENT '1=textbox, 2=radio, 3=textarea',
  `feedback_q_chk` int NOT NULL COMMENT '1=*,0!=*'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Field_Form_Of_Comp`
--

DROP TABLE IF EXISTS `Field_Form_Of_Comp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Field_Form_Of_Comp` (
  `field_id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_name_en` varchar(100) NOT NULL,
  `frmset_id` int NOT NULL,
  `frmset_type` int NOT NULL,
  PRIMARY KEY (`field_id`),
  KEY `form_id` (`form_id`),
  KEY `fieldset_id` (`frmset_id`),
  CONSTRAINT `Field_Form_Of_Comp_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `Form_Of_Comp` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Field_Set`
--

DROP TABLE IF EXISTS `Field_Set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Field_Set` (
  `fieldset_id` int NOT NULL AUTO_INCREMENT,
  `frmset_id` int NOT NULL,
  `fieldset_name` varchar(100) NOT NULL,
  `fieldset_description_en` varchar(100) NOT NULL,
  `fieldset_description` varchar(100) NOT NULL,
  `fieldset_require` int NOT NULL,
  `fieldset_type` int NOT NULL COMMENT '1=text, 2=number, 3=currency, 4=Select Box , 5=pettrenID_1, 6=pettrenID_2, 7=checkbox, 8=radiobox, 9=uploadfile, 10=date, 11=email',
  PRIMARY KEY (`fieldset_id`),
  KEY `frmset_id` (`frmset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Field_Values`
--

DROP TABLE IF EXISTS `Field_Values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Field_Values` (
  `fieldVal_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `fieldset_id` int NOT NULL,
  `fieldset_value` text NOT NULL,
  PRIMARY KEY (`fieldVal_id`),
  KEY `case_id` (`case_id`),
  KEY `fieldset_id` (`fieldset_id`),
  CONSTRAINT `Field_Values_ibfk_1` FOREIGN KEY (`fieldset_id`) REFERENCES `Field_Set` (`fieldset_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Field_Values_ibfk_2` FOREIGN KEY (`case_id`) REFERENCES `Case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90792 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Form_Link_Complaint_Type`
--

DROP TABLE IF EXISTS `Form_Link_Complaint_Type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Form_Link_Complaint_Type` (
  `frmCompType_id` int NOT NULL AUTO_INCREMENT,
  `compType_id` int NOT NULL,
  `compTypeSub1_id` int NOT NULL,
  `compTypeSub2_id` int NOT NULL,
  `frmset_id` int NOT NULL,
  `frmset_name` varchar(100) NOT NULL,
  `frmset_name_en` varchar(255) NOT NULL,
  `form_id` int DEFAULT NULL,
  `field_id` int DEFAULT NULL,
  PRIMARY KEY (`frmCompType_id`),
  KEY `compType_id` (`compType_id`),
  KEY `frmset_id` (`frmset_id`),
  KEY `compTypeSub1_id` (`compTypeSub1_id`),
  KEY `compTypeSub2_id` (`compTypeSub2_id`),
  KEY `form_id` (`form_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Form_Link_Complaint_Type1`
--

DROP TABLE IF EXISTS `Form_Link_Complaint_Type1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Form_Link_Complaint_Type1` (
  `frmCompType_id` int NOT NULL AUTO_INCREMENT,
  `compType_id` int NOT NULL,
  `compTypeSub1_id` int NOT NULL,
  `compTypeSub2_id` int NOT NULL,
  `frmset_id` int NOT NULL,
  `frmset_name` varchar(100) NOT NULL,
  `frmset_name_en` varchar(255) NOT NULL,
  `form_id` int DEFAULT NULL,
  `field_id` int DEFAULT NULL,
  PRIMARY KEY (`frmCompType_id`),
  KEY `compType_id` (`compType_id`),
  KEY `frmset_id` (`frmset_id`),
  KEY `compTypeSub1_id` (`compTypeSub1_id`),
  KEY `compTypeSub2_id` (`compTypeSub2_id`),
  KEY `form_id` (`form_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Form_Of_Comp`
--

DROP TABLE IF EXISTS `Form_Of_Comp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Form_Of_Comp` (
  `form_id` int NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) NOT NULL,
  `form_start_date` date NOT NULL,
  `form_end_date` date NOT NULL,
  `form_status` int NOT NULL,
  `form_create_datetime` datetime NOT NULL,
  `form_createBy_id` int NOT NULL,
  `form_edit_datetime` datetime NOT NULL,
  `form_updateBy_id` int NOT NULL,
  PRIMARY KEY (`form_id`),
  KEY `form_updateBy_id` (`form_updateBy_id`),
  KEY `form_createBy_id` (`form_createBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Form_Set`
--

DROP TABLE IF EXISTS `Form_Set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Form_Set` (
  `frmset_id` int NOT NULL AUTO_INCREMENT,
  `frmset_name` varchar(100) NOT NULL,
  `frmset_section` int NOT NULL COMMENT '1=ข้อพิพาทระหว่างประเทศ , 2=นิติการ',
  `frmset_type` int NOT NULL COMMENT '1=ผู้ร้องเรียน, 2=ผู้ถูกร้องเรียน, 3=รายละเอียดเรื่องร้องเรียน',
  `frmset_create_datetime` datetime NOT NULL,
  `frmset_createBy_id` int NOT NULL,
  `frmset_update_datetime` datetime DEFAULT NULL,
  `frmset_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`frmset_id`),
  KEY `frmset_createBy_id` (`frmset_createBy_id`),
  KEY `frmset_updateBy_id` (`frmset_updateBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Incorrect_Type`
--

DROP TABLE IF EXISTS `Incorrect_Type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Incorrect_Type` (
  `incType_id` int NOT NULL AUTO_INCREMENT,
  `incType_name` varchar(255) NOT NULL,
  `incType_name_en` text NOT NULL,
  `incType_status` int NOT NULL COMMENT '0=normal, 1=del',
  `incType_other_flag` int NOT NULL COMMENT '0=no, 1=yes',
  `incType_enable` int NOT NULL COMMENT '1=enable, 2=disable',
  `incType_create_datetime` datetime NOT NULL,
  `incType_createBy_id` int NOT NULL,
  `incType_update_datetime` datetime DEFAULT NULL,
  `incType_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`incType_id`),
  KEY `incType_createBy_id` (`incType_createBy_id`),
  KEY `incType_updateBy_id` (`incType_updateBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Log_Case`
--

DROP TABLE IF EXISTS `Log_Case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Log_Case` (
  `logCase_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `process_id` int DEFAULT NULL,
  `emp_id` int NOT NULL,
  `logCase_type` int(2) unsigned zerofill NOT NULL COMMENT '00=สร้างเรื่องร้องเรียน, 01=แก้ไขเรื่องร้องเรียน , 02=รับเรื่องร้องเรียน , 10=Assign, 11=Re-Assign, 20=สร้างกระบวนการ, 21=ปิดกระบวนการ, 30=ยุติข้อร้องเรียน',
  `logCase_text` text NOT NULL,
  `logCase_datetime` datetime NOT NULL,
  PRIMARY KEY (`logCase_id`),
  KEY `case_id` (`case_id`),
  KEY `emp_id` (`emp_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `Log_Case_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `Case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11091 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Log_Login_Employee`
--

DROP TABLE IF EXISTS `Log_Login_Employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Log_Login_Employee` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `log_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `log_status` int NOT NULL COMMENT '1=pass, 2=invalid',
  `log_datetime` datetime NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_id` (`log_id`),
  KEY `log_username` (`log_username`),
  KEY `log_status` (`log_status`),
  KEY `log_datetime` (`log_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=25560 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Log_Login_Member`
--

DROP TABLE IF EXISTS `Log_Login_Member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Log_Login_Member` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `member_id` varchar(20) NOT NULL,
  `ssoid` varchar(20) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `date_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4676 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Log_Notification`
--

DROP TABLE IF EXISTS `Log_Notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Log_Notification` (
  `noti_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `emp_id` int NOT NULL,
  `noti_type` int NOT NULL COMMENT '0=สร้างเรื่องร้องเรียน, 1=Assign, 2=Forword, 3=create process, 4=ปิดกระบวนการ, 5=ยุติข้อร้องเรียน',
  `noti_datetime` datetime NOT NULL,
  `noti_read` int NOT NULL COMMENT '0=ยังไม่อ่าน 1=อ่านแล้ว',
  `noti_status` int NOT NULL COMMENT '0=ใช่งาน,1=ลบ',
  PRIMARY KEY (`noti_id`),
  KEY `emp_id` (`emp_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Log_sms`
--

DROP TABLE IF EXISTS `Log_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Log_sms` (
  `log_sms_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `mobile_number` varchar(10) NOT NULL,
  `message` varchar(255) NOT NULL,
  `response_status` int(2) unsigned zerofill NOT NULL,
  `response_tranid` varchar(100) NOT NULL,
  `response_detail` varchar(255) NOT NULL,
  `send_datetime` datetime NOT NULL,
  PRIMARY KEY (`log_sms_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2585 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Mail_Attachfile`
--

DROP TABLE IF EXISTS `Mail_Attachfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Mail_Attachfile` (
  `mailAttach_id` int NOT NULL AUTO_INCREMENT,
  `procPropEmail_id` int NOT NULL,
  `mailAttach_file_path` varchar(255) NOT NULL,
  `mailAttach_file_oldname` varchar(255) NOT NULL,
  `mailAttach_file_name` varchar(255) NOT NULL,
  `mailAttach_file_ext` varchar(20) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `mailAttach_status` int NOT NULL,
  `mailAttach_create_datetime` datetime NOT NULL,
  `mailAttach_createBy_id` int NOT NULL,
  PRIMARY KEY (`mailAttach_id`),
  KEY `mailAttach_createBy_id` (`mailAttach_createBy_id`),
  KEY `procPropApp_id` (`procPropEmail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Member`
--

DROP TABLE IF EXISTS `Member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Member` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `member_fname` varchar(100) NOT NULL,
  `member_lname` varchar(100) NOT NULL,
  `member_cid` varchar(15) NOT NULL,
  `member_occupation` varchar(100) NOT NULL,
  `member_position` varchar(100) NOT NULL,
  `member_address` varchar(255) NOT NULL,
  `prov_id` int NOT NULL,
  `prov_name_inter` varchar(150) NOT NULL COMMENT 'ชื่อจังหวัด/เขต ต่างประเทศ',
  `member_postcode` varchar(10) NOT NULL,
  `country_id` int NOT NULL,
  `member_phone` varchar(20) NOT NULL,
  `member_cellphone` varchar(20) NOT NULL,
  `member_fax` varchar(20) NOT NULL,
  `member_sex` tinyint(1) NOT NULL COMMENT '1=ชาย,2=หญิง',
  `member_img` varchar(100) NOT NULL,
  `member_email` varchar(100) NOT NULL,
  `member_password` varchar(255) NOT NULL,
  `member_api_key` varchar(255) NOT NULL,
  `member_onetime` varchar(100) NOT NULL,
  `member_facebook_id` varchar(30) NOT NULL,
  `member_facebook_name` varchar(150) NOT NULL,
  `member_facebook_type` int NOT NULL COMMENT '0=ไม่ได้ล็อกอินfaceook , 1=ล็อกอินด้วยfacebook',
  `member_type` tinyint(1) NOT NULL COMMENT '0=คนทั่วไป,1=ตัวแทนบริษัท',
  `member_lang` tinyint(1) NOT NULL COMMENT '1=th,2=en',
  `member_noti` tinyint(1) NOT NULL COMMENT '1=เปิด noti,2=ปิด noti',
  `member_condition` tinyint(1) NOT NULL COMMENT '1=ยังไม่ยอมรับ,2=ยอมรับเงื่อนไข',
  `member_creDate` datetime NOT NULL,
  `member_status` tinyint(1) NOT NULL COMMENT '0=no active,1=active',
  `member_business` int NOT NULL COMMENT '0= ไม่ระบุ , 1=นำเข้า ,2=ส่งออก',
  `member_tokin` varchar(255) NOT NULL COMMENT 'เช็คสำหรับรีเซ็ทรหัสผ่าน',
  `member_reset_pass` int NOT NULL COMMENT '0=แก้ไขรหัสแล้ว , 1=ยังไม่่แก้ไข',
  `member_status_confirm` int NOT NULL COMMENT '0=not confirm, 1=confirm',
  `member_token_confirm` varchar(255) NOT NULL,
  `member_date_confirm` datetime NOT NULL,
  `ssoid` varchar(255) DEFAULT NULL,
  `member_fname_en` varchar(100) NOT NULL,
  `member_lname_en` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_en` varchar(50) NOT NULL,
  `status_update_sso` int NOT NULL,
  `tel_code` varchar(20) DEFAULT NULL,
  `tel_country_code` varchar(20) DEFAULT NULL,
  `tel_icon_country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16078 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Member_backup2`
--

DROP TABLE IF EXISTS `Member_backup2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Member_backup2` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `member_fname_en` varchar(100) NOT NULL,
  `member_lname_en` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_en` varchar(50) NOT NULL,
  `member_fname` varchar(100) NOT NULL,
  `member_lname` varchar(100) NOT NULL,
  `member_cid` varchar(15) NOT NULL,
  `member_occupation` varchar(100) NOT NULL,
  `member_position` varchar(100) NOT NULL,
  `member_address` varchar(255) NOT NULL,
  `prov_id` int NOT NULL,
  `prov_name_inter` varchar(150) NOT NULL COMMENT 'ชื่อจังหวัด/เขต ต่างประเทศ',
  `member_postcode` varchar(10) NOT NULL,
  `country_id` int NOT NULL,
  `member_phone` varchar(20) NOT NULL,
  `member_cellphone` varchar(20) NOT NULL,
  `member_fax` varchar(20) NOT NULL,
  `member_sex` tinyint(1) NOT NULL COMMENT '1=ชาย,2=หญิง',
  `member_img` varchar(100) NOT NULL,
  `member_email` varchar(100) NOT NULL,
  `member_password` varchar(255) NOT NULL,
  `member_api_key` varchar(255) NOT NULL,
  `member_onetime` varchar(100) NOT NULL,
  `member_facebook_id` varchar(30) NOT NULL,
  `member_facebook_name` varchar(150) NOT NULL,
  `member_facebook_type` int NOT NULL COMMENT '0=ไม่ได้ล็อกอินfaceook , 1=ล็อกอินด้วยfacebook',
  `member_type` tinyint(1) NOT NULL COMMENT '0=คนทั่วไป,1=ตัวแทนบริษัท',
  `member_lang` tinyint(1) NOT NULL COMMENT '1=th,2=en',
  `member_noti` tinyint(1) NOT NULL COMMENT '1=เปิด noti,2=ปิด noti',
  `member_condition` tinyint(1) NOT NULL COMMENT '1=ยังไม่ยอมรับ,2=ยอมรับเงื่อนไข',
  `member_creDate` datetime NOT NULL,
  `member_status` tinyint(1) NOT NULL COMMENT '0=no active,1=active',
  `member_business` int NOT NULL COMMENT '0= ไม่ระบุ , 1=นำเข้า ,2=ส่งออก',
  `member_tokin` varchar(255) NOT NULL COMMENT 'เช็คสำหรับรีเซ็ทรหัสผ่าน',
  `member_reset_pass` int NOT NULL COMMENT '0=แก้ไขรหัสแล้ว , 1=ยังไม่่แก้ไข',
  `member_status_confirm` int NOT NULL COMMENT '0=not confirm, 1=confirm',
  `member_token_confirm` varchar(255) NOT NULL,
  `member_date_confirm` datetime NOT NULL,
  `ssoid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Member_comp`
--

DROP TABLE IF EXISTS `Member_comp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Member_comp` (
  `member_comp_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `member_comp_name` varchar(100) NOT NULL,
  `member_comp_branch` varchar(100) NOT NULL,
  `member_comp_taxid` varchar(20) NOT NULL,
  `member_comp_address` varchar(255) NOT NULL,
  `prov_id` int NOT NULL,
  `prov_name_inter` varchar(150) NOT NULL COMMENT 'ชื่อจังหวัด/เขต ต่างประเทศ',
  `member_comp_postcode` varchar(10) NOT NULL,
  `country_id` int NOT NULL,
  `member_comp_phone` varchar(20) NOT NULL,
  `member_comp_fax` varchar(20) NOT NULL,
  `member_comp_img` varchar(100) NOT NULL,
  `member_comp_type` tinyint(1) NOT NULL COMMENT '1=เป็น 2=ไม่เป็น',
  `prov_name` varchar(100) NOT NULL,
  `prov_name_en` varchar(100) NOT NULL,
  `member_comp_name_en` varchar(255) NOT NULL,
  PRIMARY KEY (`member_comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4625 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Member_comp_backup2`
--

DROP TABLE IF EXISTS `Member_comp_backup2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Member_comp_backup2` (
  `member_comp_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `member_comp_name` varchar(100) NOT NULL,
  `member_comp_branch` varchar(100) NOT NULL,
  `member_comp_taxid` varchar(20) NOT NULL,
  `member_comp_address` varchar(255) NOT NULL,
  `prov_id` int NOT NULL,
  `prov_name_inter` varchar(150) NOT NULL COMMENT 'ชื่อจังหวัด/เขต ต่างประเทศ',
  `member_comp_postcode` varchar(10) NOT NULL,
  `country_id` int NOT NULL,
  `member_comp_phone` varchar(20) NOT NULL,
  `member_comp_fax` varchar(20) NOT NULL,
  `member_comp_img` varchar(100) NOT NULL,
  `member_comp_type` tinyint(1) NOT NULL COMMENT '1=เป็น 2=ไม่เป็น',
  `prov_name` varchar(100) NOT NULL,
  `prov_name_en` varchar(100) NOT NULL,
  `member_comp_name_en` varchar(255) NOT NULL,
  PRIMARY KEY (`member_comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Message_Box`
--

DROP TABLE IF EXISTS `Message_Box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Message_Box` (
  `msgBox_id` int NOT NULL AUTO_INCREMENT,
  `msgBoxRef_id` int NOT NULL COMMENT 'if==0->not reply, if!=0->Reply',
  `msgBox_type` int NOT NULL COMMENT '1=Subject ,2=Reply',
  `case_id` int NOT NULL,
  `sender_id` int NOT NULL COMMENT 'ผู้ส่ง',
  `sender_type` int NOT NULL COMMENT '0=system, 1=member, 2=employee',
  `msgBox_message` text NOT NULL,
  `msgBox_message_en` text NOT NULL,
  `msgBox_datetime` datetime DEFAULT NULL,
  `msgBox_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `msgBox_noti_status` int NOT NULL COMMENT '0=not open, 1=open',
  `msgBox_noti_datetime` datetime NOT NULL,
  `msgBox_read_status` int NOT NULL COMMENT '0=not read, 1=read',
  `msgBox_read_datetime` datetime NOT NULL,
  PRIMARY KEY (`msgBox_id`),
  KEY `case_id` (`case_id`),
  KEY `sender_id` (`sender_id`),
  KEY `msgBoxRef_id` (`msgBoxRef_id`)
) ENGINE=InnoDB AUTO_INCREMENT=823 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Message_Box_Attachfile`
--

DROP TABLE IF EXISTS `Message_Box_Attachfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Message_Box_Attachfile` (
  `msgBoxAttach_id` int NOT NULL AUTO_INCREMENT,
  `msgBox_id` int NOT NULL,
  `msgBoxAttach_title` varchar(100) DEFAULT NULL,
  `msgBoxAttach_file_path` varchar(255) DEFAULT NULL,
  `msgBoxAttach_file_oldname` varchar(100) NOT NULL,
  `msgBoxAttach_file_name` varchar(100) DEFAULT NULL,
  `msgBoxAttach_file_ext` varchar(20) DEFAULT NULL,
  `msgBoxAttach_status` int DEFAULT NULL,
  `msgBoxAttach_create_datetime` datetime NOT NULL,
  `msgBoxAttach_createBy_id` int NOT NULL,
  PRIMARY KEY (`msgBoxAttach_id`),
  KEY `msgBox_id` (`msgBox_id`),
  KEY `msgBoxAttach_createBy_id` (`msgBoxAttach_createBy_id`),
  CONSTRAINT `Message_Box_Attachfile_ibfk_1` FOREIGN KEY (`msgBox_id`) REFERENCES `Message_Box` (`msgBox_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Message_Box_Log`
--

DROP TABLE IF EXISTS `Message_Box_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Message_Box_Log` (
  `msgBoxLog_id` int NOT NULL AUTO_INCREMENT,
  `msgBox_id` int NOT NULL,
  `recipient_id` int NOT NULL COMMENT 'ผู้รับ',
  `recipient_type` int NOT NULL COMMENT '1=member, 2=employee',
  `msgBoxLog_datetime` datetime NOT NULL,
  `msgBox_noti_status` int NOT NULL,
  `msgBox_noti_datetime` datetime DEFAULT NULL,
  `msgBox_read_status` int NOT NULL,
  `msgBox_read_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`msgBoxLog_id`),
  KEY `msgBox_id` (`msgBox_id`),
  KEY `recipient_id` (`recipient_id`),
  CONSTRAINT `Message_Box_Log_ibfk_1` FOREIGN KEY (`msgBox_id`) REFERENCES `Message_Box` (`msgBox_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=404 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Message_Noti_App`
--

DROP TABLE IF EXISTS `Message_Noti_App`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Message_Noti_App` (
  `msgNotiApp_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `member_id` int NOT NULL,
  `msgNotiApp_step` int NOT NULL COMMENT '1=25%, 2=50%, 3=75%, 4=100%	',
  `msgNotiApp_message` text NOT NULL,
  `msgNotiApp_message_en` text NOT NULL,
  `msgNotiApp_datetime` datetime DEFAULT NULL,
  `msgNoti_status` int NOT NULL COMMENT '	0=normal, 1=delete',
  `msgNotiApp_noti_status` int NOT NULL COMMENT '0=not open, 1=open',
  `msgNotiApp_noti_datetime` datetime DEFAULT NULL,
  `msgNotiApp_read_status` int NOT NULL COMMENT '0=not read, 1=read',
  `msgNotiApp_read_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`msgNotiApp_id`),
  KEY `process_id` (`case_id`),
  KEY `member_id` (`member_id`),
  KEY `process_type_id` (`msgNotiApp_step`)
) ENGINE=InnoDB AUTO_INCREMENT=2965 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Message_Noti_Employee`
--

DROP TABLE IF EXISTS `Message_Noti_Employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Message_Noti_Employee` (
  `msgNotiEmp_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `emp_id` int NOT NULL,
  `msgNotiEmp_message` text NOT NULL,
  `msgNotiEmp_datetime` datetime DEFAULT NULL,
  `msgNotiEmp_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `msgNotiEmp_noti_status` int NOT NULL COMMENT '0=not open, 1=open',
  `msgNotiEmp_noti_datetime` datetime DEFAULT NULL,
  `msgNotiEmp_read_status` int NOT NULL COMMENT '0=not read, 1=read',
  `msgNotiEmp_read_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`msgNotiEmp_id`),
  KEY `case_id` (`case_id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55066 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Page`
--

DROP TABLE IF EXISTS `Page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Page` (
  `page_id` int NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) NOT NULL,
  `page_permission` int NOT NULL COMMENT '1=Read, 2 = Write, 3=Enable',
  `page_title` int NOT NULL,
  `page_param_read` text NOT NULL,
  `page_param_write` varchar(255) NOT NULL,
  `page_param_enable` varchar(255) NOT NULL,
  `page_setting` int NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Process`
--

DROP TABLE IF EXISTS `Process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Process` (
  `process_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `process_type_id` int NOT NULL,
  `dept_id` int DEFAULT NULL,
  `process_status` int NOT NULL COMMENT '0=บันทึก , 1=ปิดกระบวนการ',
  `process_to1` varchar(100) DEFAULT NULL,
  `process_title1` varchar(100) DEFAULT NULL,
  `process_to2` varchar(100) DEFAULT NULL,
  `process_title2` varchar(100) DEFAULT NULL,
  `process_annotation` varchar(255) NOT NULL,
  `process_type_duration` int NOT NULL,
  `process_save_datetime` datetime NOT NULL,
  `process_complete_datetime` datetime DEFAULT NULL,
  `process_over_datetime` int DEFAULT NULL,
  `procPropApp_status` int NOT NULL COMMENT 'สถานะแจ้งผ่านApp  0=Uncheck, 1=Check	',
  `procPropTel1_status` int NOT NULL COMMENT 'สถานะโทรขาเข้า 0=Uncheck, 1=Check',
  `procPropFax1_status` int NOT NULL COMMENT 'สถานะแฟกซ์ขาเข้า 0=Uncheck, 1=Check',
  `procPropEmail1_status` int NOT NULL COMMENT 'สถานะอีเมล์ขาเข้า 0=Uncheck, 1=Check',
  `procPropMail1_status` int DEFAULT NULL COMMENT 'สถานะจดหมายขาเข้า 0=Uncheck, 1=Check',
  `procPropOffcLetter1_status` int NOT NULL COMMENT 'สถานะหนังสือราชการขาเข้า 0=Uncheck, 1=Check	',
  `procPropTel2_status` int NOT NULL COMMENT 'สถานะโทรขาออก 0=Uncheck, 1=Check',
  `procPropFax2_status` int NOT NULL COMMENT 'สถานะแฟกซ์ขาออก 0=Uncheck, 1=Check',
  `procPropEmail2_status` int NOT NULL COMMENT 'สถานะอีเมล์ขาออก 0=Uncheck, 1=Check',
  `procPropMail2_status` int NOT NULL COMMENT 'สถานะจดหมายขาออก 0=Uncheck, 1=Check',
  `procPropOffcLetter2_status` int NOT NULL COMMENT 'สถานะหนังสือราชการขาออก 0=Uncheck, 1=Check	',
  `process_note` text NOT NULL,
  `process_over_note` text,
  `process_over_note_create_datetime` datetime DEFAULT NULL,
  `process_create_datetime` datetime NOT NULL,
  `process_createBy_id` int NOT NULL,
  `process_update_datetime` datetime DEFAULT NULL,
  `process_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`process_id`),
  KEY `case_id` (`case_id`),
  KEY `process_type_id` (`process_type_id`),
  KEY `process_createBy_id` (`process_createBy_id`),
  KEY `process_updateBy_id` (`process_updateBy_id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `Process_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `Case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2308 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Process_Type`
--

DROP TABLE IF EXISTS `Process_Type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Process_Type` (
  `process_type_id` int NOT NULL AUTO_INCREMENT,
  `process_type_name` varchar(255) DEFAULT NULL,
  `process_type_step` int NOT NULL,
  `process_type_duration` int NOT NULL,
  `process_type_enable` int NOT NULL COMMENT '	0=disable, 1=enable',
  `process_type_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `process_type_section` int NOT NULL COMMENT '1=สสบ. , 2=นิติการ	',
  `process_typ_contact` int NOT NULL COMMENT '0 = ไม่มีหน่วยงาน 1 = มีหน่วยงานติดต่อ',
  `dept_type` int NOT NULL,
  `process_fix_status` int NOT NULL COMMENT '0=ลบหรือแก้ไขได้ม, 1=ลบหรือแก้ไขไม่ได้',
  `process_type_message_noti` varchar(255) NOT NULL,
  `process_type_message_in` text NOT NULL,
  `process_type_message_out` text NOT NULL,
  `process_type_message_noti_en` text NOT NULL,
  `process_type_message_in_en` text NOT NULL,
  `process_type_message_out_en` text NOT NULL,
  `process_type_create_datetime` datetime NOT NULL,
  `process_type_createBy_id` int NOT NULL,
  `process_type_update_datetime` datetime DEFAULT NULL,
  `process_type_updateBy_id` int DEFAULT NULL,
  PRIMARY KEY (`process_type_id`),
  KEY `process_type_createBy_id` (`process_type_createBy_id`),
  KEY `process_type_updateBy_id` (`process_type_updateBy_id`),
  KEY `dept_type` (`dept_type`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Product_Type`
--

DROP TABLE IF EXISTS `Product_Type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Product_Type` (
  `prodType_id` int NOT NULL AUTO_INCREMENT,
  `prodType_name` varchar(255) DEFAULT NULL,
  `prodType_name_en` varchar(255) NOT NULL,
  `prodType_level` int NOT NULL,
  `prodType_other_flag` int NOT NULL COMMENT '0=no, 1=yes',
  `office_id` int NOT NULL,
  `prodType_ref_id` int NOT NULL,
  `prodType_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `prodType_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `prodType_create_datetime` datetime NOT NULL,
  `prodType_createBy_id` int NOT NULL,
  `prodType_update_datetime` datetime NOT NULL,
  `prodType_updateBy_idateBy_id` int NOT NULL,
  PRIMARY KEY (`prodType_id`),
  KEY `prodType_updateBy_idateBy_id` (`prodType_updateBy_idateBy_id`),
  KEY `prodType_createBy_id` (`prodType_createBy_id`),
  KEY `prodType_ref_id` (`prodType_ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Product_Type_Old`
--

DROP TABLE IF EXISTS `Product_Type_Old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Product_Type_Old` (
  `prodType_id` int NOT NULL AUTO_INCREMENT,
  `prodType_name` varchar(255) DEFAULT NULL,
  `prodType_name_en` varchar(255) NOT NULL,
  `prodType_level` int NOT NULL,
  `prodType_other_flag` int NOT NULL COMMENT '0=no, 1=yes',
  `office_id` int NOT NULL,
  `prodType_ref_id` int NOT NULL,
  `prodType_status` int NOT NULL COMMENT '0=normal, 1=delete',
  `prodType_enable` int NOT NULL COMMENT '0=disable, 1=enable',
  `prodType_create_datetime` datetime NOT NULL,
  `prodType_createBy_id` int NOT NULL,
  `prodType_update_datetime` datetime NOT NULL,
  `prodType_updateBy_idateBy_id` int NOT NULL,
  PRIMARY KEY (`prodType_id`),
  KEY `prodType_updateBy_idateBy_id` (`prodType_updateBy_idateBy_id`),
  KEY `prodType_createBy_id` (`prodType_createBy_id`),
  KEY `prodType_ref_id` (`prodType_ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1294 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Province`
--

DROP TABLE IF EXISTS `Province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Province` (
  `prov_id` int NOT NULL AUTO_INCREMENT,
  `prov_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prov_name_eng` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`prov_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PublicHoliday`
--

DROP TABLE IF EXISTS `PublicHoliday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PublicHoliday` (
  `holiday_id` int NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(250) NOT NULL,
  `holiday_date_start` date NOT NULL,
  `holiday_date_end` date NOT NULL,
  `holiday_year` year NOT NULL,
  `holiday_date_amount` int NOT NULL,
  `holiday_status` int NOT NULL COMMENT '0=normal, 1=del',
  `holiday_create_datetime` datetime NOT NULL,
  `holiday_createBy_id` int NOT NULL,
  `holiday_update_datetime` datetime NOT NULL,
  `holiday_updateBy_id` int NOT NULL,
  PRIMARY KEY (`holiday_id`),
  KEY `holiday_createBy_id` (`holiday_createBy_id`),
  KEY `holiday_updateBy_id` (`holiday_updateBy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Setting_Info`
--

DROP TABLE IF EXISTS `Setting_Info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Setting_Info` (
  `settingInfo_id` int NOT NULL AUTO_INCREMENT,
  `normal_period` int NOT NULL COMMENT 'ข้อมูลข่าวสารของข้าราชการ-> กำหนดระยะเวลา',
  `normal_alert_period` int NOT NULL COMMENT 'ข้อมูลข่าวสารของข้าราชการ-> แจ้งเตือนล่วงหน้าก่อนถึงเวลา',
  `overdueMain_alert_period` int NOT NULL COMMENT 'Overdue กระบวนการหลัก-> กำหนดระยะเวลาแจ้งเตือนล่วงหน้าก่อนถึงเวลา',
  `overdueMain_alert_img_path` varchar(100) NOT NULL COMMENT 'Overdue กระบวนการหลัก->path ไฟล์สัญลักษณ์',
  `overdueMain_alert_img_name` varchar(100) NOT NULL COMMENT 'Overdue กระบวนการหลัก->ชื่อ ไฟล์ สัญลักษณ์',
  `overdueMain_alert_img_ext` varchar(20) NOT NULL COMMENT 'Overdue กระบวนการหลัก->นามสกุล ไฟล์ สัญลักษณ์',
  `overdueSub_alert_period` int NOT NULL COMMENT 'Overdue กระบวนการย่อย-> กำหนดระยะเวลาแจ้งเตือนล่วงหน้าก่อนถึงเวลา',
  `overdueSub_alert_img_path` varchar(100) NOT NULL COMMENT 'Overdue กระบวนการย่อย-->path ไฟล์สัญลักษณ์',
  `overdueSub_alert_img_name` varchar(100) NOT NULL COMMENT 'Overdue กระบวนการย่อย->ชื่อ ไฟล์ สัญลักษณ์',
  `overdueSub_alert_img_ext` varchar(20) NOT NULL COMMENT 'Overdue กระบวนการย่อย->นามสกุล ไฟล์ สัญลักษณ์',
  `recivedCase_from_app` int NOT NULL COMMENT '0=ปิด, 1=เปิด',
  `recivedMsg_from_app` int NOT NULL COMMENT '0=ปิด, 1=เปิด',
  `assign_status` int NOT NULL COMMENT '0=ปิด, 1=เปิด',
  `noti_status` int NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->การแจ้งเตือน->0=ปิด, 1=เปิด',
  `noti_process25` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->25%',
  `noti_process50` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->50%',
  `noti_process75` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->75%',
  `noti_process100` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->100%',
  `noti_process25_en` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->25%',
  `noti_process50_en` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->50%',
  `noti_process75_en` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->75%',
  `noti_process100_en` text NOT NULL COMMENT 'การดำเนินงานแต่ละกระบวนการ->100%',
  `notiMsg_status` int NOT NULL COMMENT 'การแจ้งเตือนอื่นๆ->0=ปิด, 1=เปิด',
  `bl_setting` int NOT NULL,
  `hd_setting` int NOT NULL,
  PRIMARY KEY (`settingInfo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `User_WebService`
--

DROP TABLE IF EXISTS `User_WebService`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User_WebService` (
  `userws_id` int NOT NULL AUTO_INCREMENT,
  `userws_username` varchar(100) NOT NULL,
  `userws_password` varchar(255) NOT NULL,
  `userws_status_lock` int NOT NULL COMMENT '0=normal, 1=lock',
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`userws_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `case_transfer_log`
--

DROP TABLE IF EXISTS `case_transfer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `case_transfer_log` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `transfer_detail` varchar(255) NOT NULL,
  `transfer_caseID` int NOT NULL,
  `transfer_date` datetime NOT NULL,
  `transfer_officeID_for` int NOT NULL,
  `transfer_officeID_to` int NOT NULL,
  `transfer_empID` int NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `case_view`
--

DROP TABLE IF EXISTS `case_view`;
/*!50001 DROP VIEW IF EXISTS `case_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `case_view` AS SELECT 
 1 AS `case_id`,
 1 AS `case_opened_datetime`,
 1 AS `case_close_datetime`,
 1 AS `caseCh_name`,
 1 AS `compType_name`,
 1 AS `compTypeSub1_name`,
 1 AS `applicant_name`,
 1 AS `complnt_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `count_checkcorporation_clicked`
--

DROP TABLE IF EXISTS `count_checkcorporation_clicked`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `count_checkcorporation_clicked` (
  `count_id` int NOT NULL AUTO_INCREMENT,
  `clickByID` int NOT NULL DEFAULT '0',
  `clickDownload` int NOT NULL,
  `clickDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`count_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7294 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ditp_apps_lognoti`
--

DROP TABLE IF EXISTS `ditp_apps_lognoti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ditp_apps_lognoti` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `case_id` int NOT NULL,
  `multicast_id` varchar(50) NOT NULL,
  `log_status` int NOT NULL,
  `log_txt` varchar(100) NOT NULL,
  `log_msg` text NOT NULL,
  `log_date` datetime NOT NULL,
  KEY `log_id` (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_api`
--

DROP TABLE IF EXISTS `log_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_api` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `method` varchar(10) NOT NULL,
  `url` text NOT NULL,
  `referer` text,
  `user_agent` text,
  `host` varchar(255) DEFAULT NULL,
  `request_data` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip_address` (`ip_address`),
  KEY `idx_method` (`method`)
) ENGINE=InnoDB AUTO_INCREMENT=329712 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_bizprotal`
--

DROP TABLE IF EXISTS `log_bizprotal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_bizprotal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `output` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `case_id` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `type` int DEFAULT NULL,
  `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_email`
--

DROP TABLE IF EXISTS `log_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_email` (
  `id` int NOT NULL AUTO_INCREMENT,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL COMMENT '1 = สำเร็จ , 2 = ไม่สำเร็จ',
  `type` int NOT NULL COMMENT '1=หน้าบ้าน, 2=หลังบ้าน',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10280 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `office_type`
--

DROP TABLE IF EXISTS `office_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `office_type` (
  `office_id` int NOT NULL AUTO_INCREMENT,
  `dept_id` int NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `office_name_short` varchar(255) NOT NULL,
  `office_status` int NOT NULL COMMENT '1=on,2=off',
  PRIMARY KEY (`office_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procPropApp`
--

DROP TABLE IF EXISTS `procPropApp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procPropApp` (
  `procPropApp_id` int NOT NULL AUTO_INCREMENT,
  `process_id` int NOT NULL,
  `procPropApp_member_id` int NOT NULL,
  `procPropApp_message` text NOT NULL,
  `procPropApp_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`procPropApp_id`),
  KEY `process_id` (`process_id`),
  KEY `member_id` (`procPropApp_member_id`),
  CONSTRAINT `procPropApp_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `Process` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=642 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procPropEmail`
--

DROP TABLE IF EXISTS `procPropEmail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procPropEmail` (
  `procPropEmail_id` int NOT NULL AUTO_INCREMENT,
  `process_id` int NOT NULL,
  `procPropEmail_type` int NOT NULL COMMENT '1=ขาเข้า, 2=ขาออก	',
  `procPropEmail_address` varchar(100) DEFAULT NULL,
  `procPropEmail_subject` varchar(100) NOT NULL,
  `procPropEmail_message` text NOT NULL,
  `procPropEmail_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`procPropEmail_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `procPropEmail_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `Process` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procPropFax`
--

DROP TABLE IF EXISTS `procPropFax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procPropFax` (
  `procPropFax_id` int NOT NULL AUTO_INCREMENT,
  `process_id` int NOT NULL,
  `procPropFax_type` int NOT NULL COMMENT '1=ขาเข้า, 2=ขาออก	',
  `procPropFax_number` varchar(100) DEFAULT NULL,
  `procPropFax_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`procPropFax_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `procPropFax_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `Process` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procPropMail`
--

DROP TABLE IF EXISTS `procPropMail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procPropMail` (
  `procPropMail_id` int NOT NULL AUTO_INCREMENT,
  `process_id` int NOT NULL,
  `procPropMail_number` varchar(20) NOT NULL,
  `procPropMail_tracking` varchar(20) NOT NULL,
  `procPropMail_type` varchar(45) DEFAULT NULL COMMENT '1=ขาเข้า, 2=ขาออก',
  `procPropMail_datetime` datetime DEFAULT NULL,
  `procPropMail_tracking_datetime` datetime NOT NULL,
  `procPropMail_file_path` varchar(255) DEFAULT NULL,
  `procPropMail_file_oldname` varchar(100) DEFAULT NULL,
  `procPropMail_file_name` varchar(100) DEFAULT NULL,
  `procPropMail_file_ext` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`procPropMail_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `procPropMail_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `Process` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=990 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procPropOffcLetter`
--

DROP TABLE IF EXISTS `procPropOffcLetter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procPropOffcLetter` (
  `procPropOffcLetter_id` int NOT NULL AUTO_INCREMENT,
  `process_id` int NOT NULL,
  `procPropOffcLetter_type` int NOT NULL COMMENT '1=ขาเข้า, 2=ขาออก	',
  `procPropOffcLetter_number` varchar(100) DEFAULT NULL,
  `procPropOffcLetter_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`procPropOffcLetter_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `procPropOffcLetter_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `Process` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procPropTel`
--

DROP TABLE IF EXISTS `procPropTel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procPropTel` (
  `procPropTel_id` int NOT NULL AUTO_INCREMENT,
  `process_id` int NOT NULL,
  `procPropTel_type` int NOT NULL COMMENT '1=ขาเข้า, 2=ขาออก	',
  `procPropTel_number` varchar(100) DEFAULT NULL,
  `procPropTel_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`procPropTel_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `procPropTel_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `Process` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `version_app`
--

DROP TABLE IF EXISTS `version_app`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `version_app` (
  `version_id` int NOT NULL AUTO_INCREMENT,
  `version_bundle` varchar(100) NOT NULL,
  `version_number` int NOT NULL,
  `version_type` int NOT NULL COMMENT '1=android,2=ios',
  PRIMARY KEY (`version_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `case_view`
--

/*!50001 DROP VIEW IF EXISTS `case_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `case_view` AS select `c`.`case_id` AS `case_id`,`c`.`case_opened_datetime` AS `case_opened_datetime`,`c`.`case_close_datetime` AS `case_close_datetime`,`ch`.`caseCh_name` AS `caseCh_name`,`ct`.`compType_name` AS `compType_name`,`ct1`.`compTypeSub1_name` AS `compTypeSub1_name`,(case when (`c`.`applnt_type` = 1) then `c`.`applntOrg_name` when (`c`.`applnt_type` = 2) then 'บุคคลธรรมดา' else 'ไม่ระบุ' end) AS `applicant_name`,`c`.`complnt_name` AS `complnt_name` from ((((((`Case` `c` left join `Complaint_Type` `ct` on((`c`.`compType_id` = `ct`.`compType_id`))) left join `Complaint_Type_Sub1` `ct1` on((`c`.`compTypeSub1_id` = `ct1`.`compTypeSub1_id`))) left join `Complaint_Type_Sub2` `ct2` on((`c`.`compTypeSub2_id` = `ct2`.`compTypeSub2_id`))) left join `Product_Type` `pt` on((`c`.`prodType_id` = `pt`.`prodType_id`))) left join `Case_Channel` `ch` on((`c`.`caseCh_id` = `ch`.`caseCh_id`))) left join `Incorrect_Type` `it` on((`c`.`incType_id` = `it`.`incType_id`))) order by `c`.`case_id` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-19 11:09:58

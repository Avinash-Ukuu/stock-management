/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - stock_managements
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`stock_managements` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `stock_managements`;

/*Table structure for table `activity_log` */

DROP TABLE IF EXISTS `activity_log`;

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `subject_type` int(11) DEFAULT NULL,
  `causer_id` int(11) DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `properties` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `activity_log` */

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'furnicher','2025-11-01 10:49:13','2025-11-01 05:19:13'),
(2,'computer','2025-11-03 04:29:18','2025-11-03 04:29:18');

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `departments` */

insert  into `departments`(`id`,`name`,`head_id`,`created_at`,`updated_at`) values 
(1,'CS and IT',2,'2025-11-05 11:51:16',NULL),
(2,'Commerce',NULL,'2025-11-05 11:50:24',NULL),
(3,'Arts',NULL,'2025-11-05 11:50:27',NULL),
(4,'Media and Mass',NULL,'2025-11-05 11:50:49',NULL);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1);

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `modules` */

insert  into `modules`(`id`,`name`,`created_at`,`updated_at`) values 
(2,'stock','2025-11-01 03:58:32','2025-11-01 03:58:32');

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `read_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `notifications` */

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`id`,`role_id`,`permission_id`) values 
(1,2,1);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`description`,`module_id`,`created_at`,`updated_at`) values 
(1,'view',NULL,2,'2025-11-01 03:59:38','2025-11-01 03:59:38'),
(2,'create',NULL,2,'2025-11-01 03:59:51','2025-11-01 03:59:51'),
(3,'update',NULL,2,'2025-11-01 04:00:00','2025-11-01 04:00:00');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `role_user` */

insert  into `role_user`(`id`,`user_id`,`role_id`) values 
(1,1,1),
(2,2,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`description`,`created_at`,`updated_at`) values 
(1,'admin',NULL,'2025-10-31 15:16:47',NULL),
(2,'stock management','Management stock data','2025-11-01 04:01:31','2025-11-01 04:01:31');

/*Table structure for table `stock_items` */

DROP TABLE IF EXISTS `stock_items`;

CREATE TABLE `stock_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) DEFAULT NULL,
  `unique_code` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `assigned_department` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stock_items` */

insert  into `stock_items`(`id`,`stock_id`,`unique_code`,`qr_code`,`condition`,`assigned_department`,`created_at`,`updated_at`) values 
(1,5,'HP-COMPUTERS-001',NULL,'new',NULL,'2025-11-05 11:22:41','2025-11-04 04:32:58'),
(2,5,'HP-COMPUTERS-002',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(3,5,'HP-COMPUTERS-003',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(4,5,'HP-COMPUTERS-004',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(5,5,'HP-COMPUTERS-005',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(6,5,'HP-COMPUTERS-006',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(7,5,'HP-COMPUTERS-007',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(8,5,'HP-COMPUTERS-008',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(9,5,'HP-COMPUTERS-009',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(10,5,'HP-COMPUTERS-010',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(11,5,'HP-COMPUTERS-011',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(12,5,'HP-COMPUTERS-012',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(13,5,'HP-COMPUTERS-013',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(14,5,'HP-COMPUTERS-014',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(15,5,'HP-COMPUTERS-015',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(16,5,'HP-COMPUTERS-016',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(17,5,'HP-COMPUTERS-017',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(18,5,'HP-COMPUTERS-018',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(19,5,'HP-COMPUTERS-019',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(20,5,'HP-COMPUTERS-020',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(21,5,'HP-COMPUTERS-021',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(22,5,'HP-COMPUTERS-022',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(23,5,'HP-COMPUTERS-023',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(24,5,'HP-COMPUTERS-024',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(25,5,'HP-COMPUTERS-025',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(26,5,'HP-COMPUTERS-026',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(27,5,'HP-COMPUTERS-027',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(28,5,'HP-COMPUTERS-028',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(29,5,'HP-COMPUTERS-029',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(30,5,'HP-COMPUTERS-030',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(31,5,'HP-COMPUTERS-031',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(32,5,'HP-COMPUTERS-032',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(33,5,'HP-COMPUTERS-033',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(34,5,'HP-COMPUTERS-034',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(35,5,'HP-COMPUTERS-035',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(36,5,'HP-COMPUTERS-036',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(37,5,'HP-COMPUTERS-037',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(38,5,'HP-COMPUTERS-038',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(39,5,'HP-COMPUTERS-039',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(40,5,'HP-COMPUTERS-040',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(41,5,'HP-COMPUTERS-041',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(42,5,'HP-COMPUTERS-042',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(43,5,'HP-COMPUTERS-043',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(44,5,'HP-COMPUTERS-044',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(45,5,'HP-COMPUTERS-045',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(46,5,'HP-COMPUTERS-046',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(47,5,'HP-COMPUTERS-047',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(48,5,'HP-COMPUTERS-048',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(49,5,'HP-COMPUTERS-049',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(50,5,'HP-COMPUTERS-050',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(51,5,'HP-COMPUTERS-051',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(52,5,'HP-COMPUTERS-052',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(53,5,'HP-COMPUTERS-053',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(54,5,'HP-COMPUTERS-054',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(55,5,'HP-COMPUTERS-055',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(56,5,'HP-COMPUTERS-056',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(57,5,'HP-COMPUTERS-057',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(58,5,'HP-COMPUTERS-058',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(59,5,'HP-COMPUTERS-059',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(60,5,'HP-COMPUTERS-060',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(61,5,'HP-COMPUTERS-061',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(62,5,'HP-COMPUTERS-062',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(63,5,'HP-COMPUTERS-063',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(64,5,'HP-COMPUTERS-064',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(65,5,'HP-COMPUTERS-065',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(66,5,'HP-COMPUTERS-066',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(67,5,'HP-COMPUTERS-067',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(68,5,'HP-COMPUTERS-068',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(69,5,'HP-COMPUTERS-069',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(70,5,'HP-COMPUTERS-070',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(71,5,'HP-COMPUTERS-071',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(72,5,'HP-COMPUTERS-072',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(73,5,'HP-COMPUTERS-073',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(74,5,'HP-COMPUTERS-074',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(75,5,'HP-COMPUTERS-075',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(76,5,'HP-COMPUTERS-076',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(77,5,'HP-COMPUTERS-077',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(78,5,'HP-COMPUTERS-078',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(79,5,'HP-COMPUTERS-079',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(80,5,'HP-COMPUTERS-080',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(81,5,'HP-COMPUTERS-081',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(82,5,'HP-COMPUTERS-082',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(83,5,'HP-COMPUTERS-083',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(84,5,'HP-COMPUTERS-084',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(85,5,'HP-COMPUTERS-085',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(86,5,'HP-COMPUTERS-086',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(87,5,'HP-COMPUTERS-087',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(88,5,'HP-COMPUTERS-088',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(89,5,'HP-COMPUTERS-089',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(90,5,'HP-COMPUTERS-090',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(91,5,'HP-COMPUTERS-091',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(92,5,'HP-COMPUTERS-092',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(93,5,'HP-COMPUTERS-093',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(94,5,'HP-COMPUTERS-094',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(95,5,'HP-COMPUTERS-095',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(96,5,'HP-COMPUTERS-096',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(97,5,'HP-COMPUTERS-097',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(98,5,'HP-COMPUTERS-098',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(99,5,'HP-COMPUTERS-099',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58'),
(100,5,'HP-COMPUTERS-100',NULL,'new',NULL,'2025-11-04 04:32:58','2025-11-04 04:32:58');

/*Table structure for table `stock_logs` */

DROP TABLE IF EXISTS `stock_logs`;

CREATE TABLE `stock_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stock_logs` */

/*Table structure for table `stock_usages` */

DROP TABLE IF EXISTS `stock_usages`;

CREATE TABLE `stock_usages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `condition_on_return` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stock_usages` */

/*Table structure for table `stocks` */

DROP TABLE IF EXISTS `stocks`;

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `available_quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `qr_required` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stocks` */

insert  into `stocks`(`id`,`category_id`,`name`,`description`,`vendor`,`purchase_date`,`total_quantity`,`available_quantity`,`unit_price`,`condition`,`qr_required`,`image`,`status`,`created_by`,`created_at`,`updated_at`) values 
(1,1,'Chairs','Wooden Chair','Guru Nanak Furniture Industries','2025-11-03',50,50,100.00,'new',0,'stock_1762145538.jpg',NULL,1,'2025-11-03 04:52:18','2025-11-03 04:52:18'),
(5,2,'HP Computers','HP computer i5','Kalyan Computers','2025-11-03',100,100,20000.00,'new',1,'stock_1762230778.png',NULL,1,'2025-11-04 04:32:58','2025-11-04 04:32:58');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`profile_pic`,`created_at`,`updated_at`) values 
(1,'admin','admin@gmail.com',NULL,'$2y$12$clTgYxI09W58exjULsn.7uJl9FZz.Tx2b/GgjDMsHD.uLuKmRa9u.',NULL,NULL,'2025-10-31 07:58:38','2025-10-31 07:58:38'),
(2,'avinash','avinash@gmail.com',NULL,'$2y$12$zz9reVXACmzNyMbu91VeZugKkgvJ3iWA/EUf6HIyqQEiLdVytHxqi',NULL,'user_1761969749.png','2025-11-01 04:02:13','2025-11-01 04:02:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

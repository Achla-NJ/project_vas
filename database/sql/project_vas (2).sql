-- Adminer 4.8.1 MySQL 5.7.33 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation` enum('create','update','delete') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` int(10) unsigned DEFAULT NULL,
  `updation` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `activities` (`id`, `user_id`, `role_id`, `model`, `operation`, `model_id`, `updation`, `created_at`, `updated_at`) VALUES
(4,	1,	1,	'App\\Models\\Company',	'create',	14,	NULL,	'2023-12-08 05:17:18',	'2023-12-08 05:17:18'),
(5,	1,	1,	'App\\Models\\Company',	'delete',	14,	NULL,	'2023-12-11 01:03:48',	'2023-12-11 01:03:48'),
(6,	1,	1,	'App\\Models\\Company',	'create',	15,	NULL,	'2023-12-11 01:15:54',	'2023-12-11 01:15:54'),
(7,	1,	1,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-11 01:16:33',	'2023-12-11 01:16:33'),
(8,	1,	1,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-11 02:56:54',	'2023-12-11 02:56:54'),
(9,	1,	1,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-11 02:57:10',	'2023-12-11 02:57:10'),
(10,	1,	1,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-11 02:58:13',	'2023-12-11 02:58:13'),
(11,	1,	1,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-12 00:16:24',	'2023-12-12 00:16:24'),
(12,	1,	1,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-12 00:25:34',	'2023-12-12 00:25:34'),
(13,	14,	2,	'App\\Models\\Company',	'update',	15,	NULL,	'2023-12-12 02:15:08',	'2023-12-12 02:15:08'),
(14,	1,	1,	'App\\Models\\Company',	'create',	16,	NULL,	'2023-12-12 06:50:22',	'2023-12-12 06:50:22'),
(15,	1,	2,	'App\\Models\\Company',	'create',	17,	NULL,	'2023-12-12 06:57:31',	'2023-12-12 06:57:31'),
(16,	1,	3,	'App\\Models\\Company',	'update',	16,	NULL,	'2023-12-12 07:15:43',	'2023-12-12 07:15:43'),
(17,	16,	3,	'App\\Models\\Company',	'create',	18,	NULL,	'2023-12-12 07:21:57',	'2023-12-12 07:21:57'),
(19,	1,	2,	'App\\Models\\User',	'update',	16,	NULL,	'2023-12-13 01:16:59',	'2023-12-13 01:16:59');

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trade_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firm_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registered_address` text COLLATE utf8mb4_unicode_ci,
  `gstin_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_card_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_card_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `local_address` text COLLATE utf8mb4_unicode_ci,
  `authorized_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_aadhar` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_pan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_type` enum('b2b','b2c') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aggregator_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number_verified_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `companies_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `companies` (`id`, `company_name`, `trade_name`, `firm_type`, `registered_address`, `gstin_no`, `business_website`, `director_name`, `aadhar_card_no`, `pan_card_no`, `mobile_no`, `email_address`, `local_address`, `authorized_person_name`, `contact_no`, `authorized_person_aadhar`, `authorized_person_pan`, `sales_type`, `aggregator_name`, `employee_name`, `phone_number_verified_at`, `email_verified_at`, `user_id`, `role_id`, `due_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15,	'Gentry and Richardson Inc',	'Zahir Contreras',	'one_person_company',	'Reprehenderit ut fug',	'Quia eum rerum volup',	'https://www.pefytigesexid.tv',	'Daria Powers',	'Ex quae animi ipsam',	'Ut et aperiam culpa',	'7985985985',	'3njls36icx@pirolsnet.com',	'Cupidatat expedita q',	'May Conway',	'7985985985',	'Soluta perferendis e',	'Ut dolore sequi do u',	'b2b',	'k,',	'dsf',	NULL,	NULL,	14,	2,	'2023-12-15',	'2023-12-11 01:15:54',	'2023-12-12 02:15:08',	NULL),
(16,	'Obrien Coleman LLC',	'Colton King',	'private_limited',	'Est voluptatum assum',	'Qui velit delectus',	'https://www.xulanoxeqet.ws',	'Avye Chapman',	'Ea id ipsam quia pro',	'Elit adipisicing ve',	'7985985985',	'hexysisu@mailinator.com',	'Excepturi blanditiis',	'Maxwell Clay',	'+1 (709) 886-1511',	'Sed quisquam deserun',	'Ut earum sit consequ',	'b2c',	'Karleigh Britt',	'dsf',	NULL,	NULL,	1,	3,	'2023-12-06',	'2023-12-12 06:50:22',	'2023-12-12 07:15:43',	NULL),
(17,	'Byers and Schwartz Inc',	'Zelenia Rich',	'sole_proprietorship',	'Labore ut dolor eius',	'Iste aliquam illo be',	'https://www.xehosijorimof.tv',	'Melodie Baldwin',	'Ratione cillum dolor',	'Excepteur sint aute',	'+1 (441) 573-4029',	'niqe@mailinator.com',	'Autem qui in delectu',	'Damon Scott',	'+1 (797) 929-8413',	'Accusamus ipsum quis',	'Molestiae ut volupta',	'b2b',	'Veronica Jackson',	NULL,	NULL,	NULL,	1,	2,	'1978-11-13',	'2023-12-12 06:57:31',	'2023-12-12 06:57:31',	NULL),
(18,	'Garza Vinson Traders',	'Kermit Workman',	'sole_proprietorship',	'Iusto nulla maxime q',	'Laudantium harum ma',	'https://www.zequtibi.org',	'Autumn Herrera',	'Quam at qui vel quas',	'Cum irure ipsam sequ',	'+1 (313) 928-2157',	'gunyga@mailinator.com',	'Dolor labore id omni',	'Hope Harrell',	'+1 (414) 606-3987',	'Dolor elit eos tota',	'Accusantium sunt dic',	'b2c',	NULL,	'Pamela Schultz',	NULL,	NULL,	16,	3,	'2020-01-29',	'2023-12-12 07:21:57',	'2023-12-12 07:21:57',	NULL);

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2022_12_14_093010_create_permission_tables',	1),
(6,	'2022_12_16_094307_create_projects_table',	1),
(7,	'2022_12_16_095015_create_project_users_table',	1),
(8,	'2022_12_17_082731_create_tasks_table',	2),
(9,	'2022_12_17_091601_create_task_users_table',	3),
(10,	'2022_12_17_104916_create_departments_table',	4),
(11,	'2022_12_17_114613_create_task_statuses_table',	5),
(12,	'2022_12_17_121737_create_department_task_statuses_table',	6),
(13,	'2022_12_19_075039_create_activities_table',	7);

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1,	'App\\Models\\User',	1),
(2,	'App\\Models\\User',	1),
(3,	'App\\Models\\User',	1),
(3,	'App\\Models\\User',	5),
(3,	'App\\Models\\User',	6),
(3,	'App\\Models\\User',	7),
(2,	'App\\Models\\User',	8),
(3,	'App\\Models\\User',	8),
(3,	'App\\Models\\User',	12),
(2,	'App\\Models\\User',	13),
(3,	'App\\Models\\User',	13),
(2,	'App\\Models\\User',	14),
(2,	'App\\Models\\User',	15),
(3,	'App\\Models\\User',	15),
(2,	'App\\Models\\User',	16),
(3,	'App\\Models\\User',	17);

DROP TABLE IF EXISTS `otp_verifications`;
CREATE TABLE `otp_verifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_code` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` enum('email','phone','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` enum('login','reset_password','forgot_password','register','withdraw','user_verification','email_verification','phone_verification') COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1,	'user_access',	'web',	NULL,	NULL),
(2,	'user_create',	'web',	'2022-12-17 00:56:21',	'2022-12-17 00:56:21'),
(3,	'user_update',	'web',	'2022-12-17 00:56:31',	'2022-12-17 00:56:31'),
(4,	'user_delete',	'web',	'2022-12-17 00:56:41',	'2022-12-17 00:56:41'),
(5,	'user_show',	'web',	NULL,	NULL),
(6,	'role_access',	'web',	NULL,	NULL),
(7,	'role_create',	'web',	NULL,	NULL),
(8,	'role_update',	'web',	NULL,	NULL),
(9,	'role_delete',	'web',	NULL,	NULL),
(10,	'role_show',	'web',	NULL,	NULL),
(33,	'permission_access',	'web',	NULL,	NULL),
(34,	'permission_create',	'web',	NULL,	NULL),
(35,	'permission_update',	'web',	NULL,	NULL),
(36,	'permission_show',	'web',	NULL,	NULL),
(37,	'permission_delete',	'web',	NULL,	NULL),
(38,	'company_access',	'web',	NULL,	NULL),
(39,	'company_create',	'web',	NULL,	'2023-12-12 06:44:41'),
(40,	'company_update',	'web',	NULL,	NULL),
(41,	'company_show',	'web',	NULL,	NULL),
(42,	'company_delete',	'web',	NULL,	NULL),
(43,	'dashboard',	'web',	'2023-12-11 01:45:07',	'2023-12-11 01:45:07'),
(44,	'history',	'web',	'2023-12-12 00:13:57',	'2023-12-12 00:13:57'),
(45,	'profile',	'web',	'2023-12-12 01:11:19',	'2023-12-12 01:11:19');

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `slug`, `guard_name`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin',	'web',	'2022-12-16 04:25:13',	'2022-12-16 04:25:13'),
(2,	'Business to Business',	'b2b',	'web',	'2022-12-16 04:25:13',	'2023-12-07 06:42:13'),
(3,	'Business to Customer',	'b2c',	'web',	'2022-12-16 04:25:13',	'2023-12-07 06:42:20');

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1,	1),
(2,	1),
(3,	1),
(4,	1),
(5,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(33,	1),
(34,	1),
(35,	1),
(36,	1),
(37,	1),
(38,	1),
(39,	1),
(40,	1),
(41,	1),
(42,	1),
(43,	1),
(44,	1),
(45,	1),
(38,	2),
(39,	2),
(40,	2),
(41,	2),
(42,	2),
(43,	2),
(44,	2),
(45,	2),
(38,	3),
(39,	3),
(40,	3),
(41,	3),
(42,	3),
(43,	3),
(44,	3),
(45,	3);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `save_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `username`, `email`, `mobile`, `email_verified_at`, `file`, `password`, `save_password`, `remember_token`, `gender`, `added_by`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Admin',	'admin1',	'admin@gmail.com',	'89562300',	'2022-12-16 04:25:13',	'uploads/profile/lHmimV7nSIV7CsB9iawJMptuesZMFYTtw36pVMiK.png',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	NULL,	'',	'male',	NULL,	NULL,	'2022-12-16 04:25:13',	'2023-12-13 00:11:54',	NULL),
(14,	'achla',	'',	'achla@njgraphica.com',	'9876543210',	NULL,	NULL,	'$2y$10$U4UbOGK1JT7wCqIf7ME3LeIOAuPOqBe3zk56dlAYs4FFrKXVI2.R2',	'njpassword',	'',	'female',	NULL,	NULL,	'2023-12-11 01:20:29',	'2023-12-12 05:32:16',	NULL),
(15,	'Leila Mason',	NULL,	'myqadiwe@mailinator.com',	'95',	NULL,	NULL,	'$2y$10$H1TXYH9LnK6XQp7yNaH17u7.624PoEsnevluGIpGUW7gPdoSNgfBC',	'njpassword',	NULL,	'female',	NULL,	NULL,	'2023-12-12 05:21:14',	'2023-12-12 07:21:02',	'2023-12-12 07:21:02'),
(16,	'harpreet',	NULL,	'harpreet@njgraphica.com',	'7894561230',	NULL,	NULL,	'$2y$10$pCBUlw5XI/dodGqS1s.9RuFr6cGtlqc5L4Y4FzQwR/aY8EbFLdSpm',	'njpassword',	NULL,	'male',	NULL,	NULL,	'2023-12-12 07:21:19',	'2023-12-12 07:21:19',	NULL),
(17,	'Ali Mclean',	NULL,	'gawexaz@mailinator.com',	'37',	NULL,	NULL,	'$2y$10$8Gqc2kp7HUNHtvrWu.c7g.GgsXEVbb3HvBVNOD/4FTkvRxxPJFMde',	'Fugiat obcaecati ex ',	NULL,	'female',	NULL,	NULL,	'2023-12-12 23:41:50',	'2023-12-12 23:41:50',	NULL);

-- 2023-12-13 07:04:33

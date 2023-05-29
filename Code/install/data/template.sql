-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 27, 2021 at 09:18 AM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u101243235_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slug` text NOT NULL,
  `theme_name` varchar(256) NOT NULL DEFAULT 'theme_one',
  `card_bg_type` varchar(256) NOT NULL DEFAULT 'Color',
  `card_bg` text NOT NULL,
  `profile` text NOT NULL,
  `title` text NOT NULL,
  `sub_title` text NOT NULL,
  `description` text NOT NULL,
  `banner` text NOT NULL,
  `social_options` text NOT NULL,
  `hide_branding` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `saas_id` int(11) DEFAULT NULL,
  `google_analytics` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `slug`, `theme_name`, `card_bg_type`, `card_bg`, `profile`, `title`, `sub_title`, `description`, `banner`, `social_options`, `hide_branding`, `views`, `created`, `saas_id`, `google_analytics`) VALUES
(1, 1, 'demo', 'theme_four', 'Image', '1627534897-waptechy-card-background.jpg', '1627534264-waptechy-card-profile.jpg', 'WAPTechy', 'CEO and Founder', 'We are WAPTechy Advanced Full Stack Developers.', '1627535026-waptechy-card-banner.jpg', '{\"optional\":{\"icon\":[\"fab fa-facebook m-0\"],\"text\":[\"Facebook\"],\"url\":[\"https:\\/\\/www.facebook.com\\/\"]},\"mandatory\":{\"mobile\":\"+918888888888\",\"email\":\"waptechy@gmail.com\",\"website\":\"https:\\/\\/waptechy.com\",\"address\":\"Silicon Valley, California, USA\",\"address_url\":\"https:\\/\\/goo.gl\\/maps\\/fey6iWQbYP6ozcHc7\"}}', 0, 1, '2021-07-14 07:36:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `date_formats`
--

CREATE TABLE `date_formats` (
  `id` int(11) NOT NULL,
  `format` text NOT NULL,
  `js_format` text NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `date_formats`
--

INSERT INTO `date_formats` (`id`, `format`, `js_format`, `description`, `created`) VALUES
(1, 'd-m-Y', 'DD-MM-YYYY', 'd-m-Y (18-05-2020)', '2020-05-18 01:50:13'),
(2, 'm-d-Y', 'MM-DD-YYYY', 'm-d-Y (05-18-2020)', '2020-05-18 01:50:13'),
(3, 'Y-m-d', 'YYYY-MM-DD', 'Y-m-d (2020-05-18)', '2020-05-18 01:50:13'),
(4, 'd.m.Y', 'DD.MM.YYYY', 'd.m.Y (18.05.2020)', '2020-05-18 01:50:13'),
(5, 'm.d.Y', 'MM.DD.YYYY', 'm.d.Y (05.18.2020)', '2020-05-18 01:50:13'),
(6, 'Y.m.d', 'YYYY.MM.DD', 'Y.m.d (2020.05.18)', '2020-05-18 01:50:13'),
(7, 'd/m/Y', 'DD/MM/YYYY', 'd/m/Y (18/05/2020)', '2020-05-18 01:50:13'),
(8, 'm/d/Y', 'MM/DD/YYYY', 'm/d/Y (05/18/2020)', '2020-05-18 01:50:13'),
(9, 'Y/m/d', 'YYYY/MM/DD', 'Y/m/d (2020/05/18)', '2020-05-18 01:50:13'),
(10, 'd-M-Y', 'DD-MMM-YYYY', 'd-M-Y (18-May-2020)', '2020-05-18 01:50:13'),
(11, 'd/M/Y', 'DD/MMM/YYYY', 'd/M/Y (18/May/2020)', '2020-05-18 01:50:13'),
(12, 'd.M.Y', 'DD.MMM.YYYY', 'd.M.Y (18.May.2020)', '2020-05-18 01:50:13'),
(13, 'd-M-Y', 'DD-MMM-YYYY', 'd-M-Y (18-May-2020)', '2020-05-18 01:50:13'),
(14, 'd M Y', 'DD MMM YYYY', 'd M Y (18 May 2020)', '2020-05-18 01:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `variables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `message`, `variables`) VALUES
(1, 'new_user_registration', 'Welcome', '<p>Welcome to the {COMPANY_NAME}, This is an automatically generated email to inform you. Below are the credentials for your work dashboard.</p>\r\n<p>Login credentials</p>\r\n<p>Email: {LOGIN_EMAIL}</p>\r\n<p>Password: {LOGIN_PASSWORD}</p>\r\n<p><a href=\"{DASHBOARD_URL}\">Login Now</a></p>', '{COMPANY_NAME}, {DASHBOARD_URL}, {LOGO_URL}, {LOGIN_EMAIL}, {LOGIN_PASSWORD}'),
(2, 'forgot_password', 'Reset password', '<p>Hello,</p>\r\n<p>A password reset request has been created for your account.</p>\r\n<p>Please click on the following link to reset your password: {RESET_PASSWORD_LINK}</p>', '{COMPANY_NAME}, {DASHBOARD_URL}, {LOGO_URL}, {RESET_PASSWORD_LINK}'),
(3, 'email_verification', 'Confirm your email address', '<p>Welcome to the {COMPANY_NAME},</p>\r\n<p>Please confirm your email to activate your account.</p>\r\n<p>Please click on the following link to confirm your email address: {EMAIL_CONFIRMATION_LINK}</p>', '{COMPANY_NAME}, {DASHBOARD_URL}, {LOGO_URL}, {EMAIL_CONFIRMATION_LINK}');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `icon` text NOT NULL,
  `order_by_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `content_type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(3, 'saas_admin', 'SaaS Admin');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` text NOT NULL,
  `short_code` varchar(256) NOT NULL DEFAULT 'en',
  `active` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `short_code`, `active`, `created`) VALUES
(1, 'english', 'en', 0, '2021-01-16 16:34:50'),
(2, 'hindi', 'en', 0, '2021-01-16 16:34:50'),
(3, 'italian', 'en', 0, '2021-01-16 16:34:50'),
(4, 'spanish', 'en', 0, '2021-01-16 16:34:50'),
(5, 'french', 'en', 0, '2021-01-16 16:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` text NOT NULL,
  `type` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offline_requests`
--

CREATE TABLE `offline_requests` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `created`) VALUES
(1, 'About Us', '<h1>About Us</h1>', '2021-02-05 07:25:18'),
(2, 'Privacy Policy', '<h1>Privacy Policy</h1>', '2021-02-05 07:31:52'),
(3, 'Terms and Conditions', '<h1>Terms and Conditions</h1>', '2021-02-05 07:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` int(11) NOT NULL,
  `billing_type` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modules` text NOT NULL,
  `cards` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `title`, `price`, `billing_type`, `status`, `created`, `modules`, `cards`) VALUES
(1, 'Trial Plan', 0, 'seven_days_trial_plan', 1, '2020-10-13 11:58:55', '{\"select_all\":1,\"multiple_themes\":1,\"custom_fields\":1,\"products_services\":1,\"portfolio\":1,\"testimonials\":1,\"qr_code\":1,\"hide_branding\":1,\"gallery\":1,\"enquiry_form\":1}', -1);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `saas_id`, `user_id`, `card_id`, `title`, `description`, `image`, `url`, `created`) VALUES
(1, 1, 1, 1, 'Project Management Systems', 'Professional Project Management Systems and CRM applications.', '1627536436-Inline-Preview-Image.jpg', 'https://codecanyon.net/user/wap_techy/portfolio', '2021-09-27 09:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `url` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `saas_id`, `user_id`, `card_id`, `title`, `price`, `description`, `image`, `url`, `created`) VALUES
(1, 1, 1, 1, 'TimWork and TimWork SaaS', '14-21 USD', 'TimWork is a perfect, robust, lightweight, superfast web application to fulfill all your CRM, Project Management, and Team Collaboration needs.', '1627537889-Inline-Preview-Image.jpg', 'https://codecanyon.net/user/wap_techy/portfolio', '2021-07-29 10:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `value` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `value`, `created`) VALUES
(1, 'general', '{\"company_name\":\"vCard\",\"footer_text\":\"Powered by WAPTechy\",\"currency_code\":\"USD\",\"currency_symbol\":\"$\",\"google_analytics\":\"\",\"mysql_timezone\":\"-05:00\",\"php_timezone\":\"America\\/New_York\",\"date_format\":\"d-M-Y\",\"time_format\":\"h:i A\",\"date_format_js\":\"DD-MMM-YYYY\",\"time_format_js\":\"hh:mm A\",\"alert_days\":\"3\",\"full_logo\":\"logo.png\",\"half_logo\":\"logo-half.png\",\"favicon\":\"favicon.png\",\"default_language\":\"english\",\"email_activation\":\"0\",\"non_saas_version\":\"0\",\"theme_color\":\"#e52165\"}', '2020-05-18 06:15:11'),
(2, 'email', '{\"smtp_host\":\"\",\"smtp_port\":\"\",\"smtp_username\":\"\",\"smtp_password\":\"\",\"smtp_encryption\":\"tls\"}', '2020-05-18 06:15:11'),
(3, 'permissions', '{\"project_view\":1,\"project_create\":1,\"project_edit\":1,\"project_delete\":0,\"task_view\":1,\"task_create\":1,\"task_edit\":1,\"task_delete\":0,\"user_view\":1,\"setting_view\":1,\"setting_update\":0,\"todo_view\":1,\"notes_view\":1,\"chat_view\":1}', '2020-05-18 06:15:11'),
(4, 'system_version', '1.4', '2020-05-18 06:15:11'),
(5, 'payment', '{\"paypal_client_id\":\"\"}', '2020-10-21 12:04:24'),
(6, 'frontend', '{\"landing_page\":0,\"home\":0,\"features\":0,\"subscription_plans\":0,\"contact\":0,\"about\":0,\"privacy\":0,\"terms\":0}', '2021-02-20 06:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `saas_id`, `user_id`, `card_id`, `title`, `description`, `image`, `rating`, `created`) VALUES
(1, 1, 1, 1, 'Ironman', 'Fantastic, I\'m totally blown away by TimWork.', '1627536923-tony.jpg', '5', '2021-09-27 09:15:53'),
(2, 1, 1, 1, 'Black Widow', 'This is unbelievable. After using TimWork my business skyrocketed!', '1627536910-natasha.jpg', '5', '2021-09-27 09:15:53'),
(3, 1, 1, 1, 'Captain America', 'TimWork is the best tool to make up projects quickly.', '1627537722-Chris-Evans-title-character-Joe-Johnston-Captain.jpg', '4', '2021-09-27 09:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `time_formats`
--

CREATE TABLE `time_formats` (
  `id` int(11) NOT NULL,
  `format` text NOT NULL,
  `js_format` text NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `time_formats`
--

INSERT INTO `time_formats` (`id`, `format`, `js_format`, `description`, `created`) VALUES
(1, 'h:i A', 'hh:mm A', '12 Hour', '2020-05-18 01:33:44'),
(4, 'H:i', 'H:mm', '24 Hour', '2020-05-18 01:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `saas_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `saas_id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `profile`) VALUES
(1, 1, '127.0.0.1', '%ADMINEMAIL%', '%ADMINPASSWORD%', '%ADMINEMAIL%', NULL, '', NULL, NULL, NULL, '82079582d541042de5ec6e91f4355ace199214ae', '$2y$10$rlCas8mE9pS0CFVjrkMNNusGdINeCVXkXPnSRutRG70GTQRCa1gq6', 1268889823, 1627533409, 1, 'SaaS', 'Admin', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users_plans`
--

CREATE TABLE `users_plans` (
  `id` int(11) NOT NULL,
  `saas_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `expired` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date_formats`
--
ALTER TABLE `date_formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_requests`
--
ALTER TABLE `offline_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_formats`
--
ALTER TABLE `time_formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `users_plans`
--
ALTER TABLE `users_plans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `date_formats`
--
ALTER TABLE `date_formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_requests`
--
ALTER TABLE `offline_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_formats`
--
ALTER TABLE `time_formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_plans`
--
ALTER TABLE `users_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

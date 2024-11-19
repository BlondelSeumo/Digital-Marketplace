-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2024 at 03:32 PM
-- Server version: 9.0.1
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `code`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Internal 2:External',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 : Unread 1: Read',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint UNSIGNED NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `alias`, `position`, `size`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'head_code', 'Head Code', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-09-27 18:21:42'),
(2, 'home_page_top', 'Home Page (Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-05-08 15:17:59'),
(3, 'home_page_center', 'Home Page (Center)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(4, 'home_page_bottom', 'Home Page (Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(5, 'item_page_top', 'Item Page (Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(6, 'item_page_sidebar', 'Item Page (Sidebar)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-09-27 18:31:03'),
(7, 'item_page_description_top', 'Item Page (Description Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-09-27 18:32:51'),
(8, 'item_page_description_bottom', 'Item Page (Description Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-09-27 18:32:56'),
(9, 'item_page_bottom', 'Item Page (Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(10, 'category_page_top', 'Category Page (Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(11, 'category_page_bottom', 'Category Page (Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(12, 'search_page_top', 'Search Page (Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(13, 'search_page_bottom', 'Search Page (Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(14, 'blog_page_top', 'Blog Page (Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(15, 'blog_page_bottom', 'Blog Page (Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(16, 'blog_article_page_top', 'Blog Article Page (Top)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(17, 'blog_article_page_bottom', 'Blog Article Page (Bottom)', NULL, NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `blog_articles`
--

CREATE TABLE `blog_articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `blog_article_id` bigint UNSIGNED NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `captcha_providers`
--

CREATE TABLE `captcha_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Disabled 1:Enabled',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:No 1:Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `captcha_providers`
--

INSERT INTO `captcha_providers` (`id`, `name`, `alias`, `logo`, `settings`, `instructions`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Google reCAPTCHA', 'google_recaptcha', 'images/captcha-providers/google-recaptcha.png', '{\"site_key\":null,\"secret_key\":null}', NULL, 0, 1, '2024-06-29 19:15:34', '2024-11-17 09:12:22'),
(2, 'hCaptcha', 'hcaptcha', 'images/captcha-providers/hcaptcha.png', '{\"site_key\":null,\"secret_key\":null}', NULL, 0, 0, '2024-06-29 19:15:34', '2024-06-29 17:01:25'),
(3, 'Cloudflare Turnstile', 'cloudflare_turnstile', 'images/captcha-providers/cloudflare-turnstile.png', '{\"site_key\":null,\"secret_key\":null}', NULL, 0, 0, '2024-06-29 19:15:34', '2024-07-02 19:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `license_type` tinyint NOT NULL DEFAULT '1' COMMENT '1:Regular 2:Extended',
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `support_period_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:File With Preview Image  2:File With Video Preview  3:File With Audio Preview',
  `views` bigint NOT NULL DEFAULT '0',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `title`, `description`, `file_type`, `views`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'Themes', 'themes', NULL, NULL, 1, 12, 1, '2024-05-26 08:12:08', '2024-11-17 07:43:17'),
(2, 'Code', 'code', NULL, NULL, 1, 11, 2, '2024-05-26 08:12:15', '2024-11-17 07:43:18'),
(4, 'Graphics', 'graphics', NULL, NULL, 1, 6, 6, '2024-05-26 08:12:32', '2024-11-17 07:43:18'),
(5, 'Mobile', 'mobile', NULL, NULL, 1, 6, 7, '2024-05-26 08:12:39', '2024-11-17 07:43:18'),
(6, 'Video', 'video', NULL, NULL, 2, 7, 3, '2024-09-20 23:52:51', '2024-11-17 07:43:17'),
(7, 'Audio', 'audio', NULL, NULL, 3, 6, 4, '2024-09-20 23:52:59', '2024-11-17 07:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `category_options`
--

CREATE TABLE `category_options` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `type` tinyint NOT NULL COMMENT '1:Single Select 2:Multiple Select',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_options`
--

INSERT INTO `category_options` (`id`, `category_id`, `type`, `name`, `options`, `is_required`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'High Resolution', '[\"Yes\",\"No\"]', 1, 1, '2024-06-05 17:58:08', '2024-06-05 18:01:20'),
(2, 1, 2, 'Compatible Browsers', '[\"Firefox\",\"Chrome\",\"Safari\",\"Opera\",\"Edge\"]', 1, 2, '2024-06-05 17:58:49', '2024-06-05 18:01:20'),
(3, 1, 2, 'Files Included', '[\"HTML Files\",\"JavaScript\",\"CSS\",\"XML\",\"LESS\",\"Sass\",\"PSD\",\"PHP\",\"SQL\"]', 1, 3, '2024-06-05 18:00:17', '2024-06-05 18:01:21'),
(4, 1, 2, 'Frameworks', '[\"React\",\"Vue\",\"Angular\",\"Next JS\"]', 0, 4, '2024-06-05 18:00:17', '2024-06-05 18:01:21'),
(5, 2, 1, 'High Resolution', '[\"Yes\",\"No\"]', 1, 5, '2024-06-05 17:58:08', '2024-06-05 18:01:20'),
(6, 2, 2, 'Compatible Browsers', '[\"Firefox\",\"Chrome\",\"Safari\",\"Opera\",\"Edge\"]', 1, 6, '2024-06-05 17:58:49', '2024-06-05 18:01:20'),
(7, 2, 2, 'Files Included', '[\"HTML Files\",\"JavaScript\",\"CSS\",\"XML\",\"LESS\",\"Sass\",\"PSD\",\"PHP\",\"SQL\"]', 1, 6, '2024-06-05 18:00:17', '2024-06-05 18:01:21'),
(8, 2, 2, 'Frameworks', '[\"React\",\"Vue\",\"Angular\",\"Next JS\",\"Laravel\",\"Codeigniter\",\"Cake PHP\",\"Yii\"]', 0, 8, '2024-06-05 18:00:17', '2024-06-05 18:03:21'),
(11, 4, 1, 'High Resolution', '[\"Yes\",\"No\"]', 1, 11, '2024-06-05 17:58:08', '2024-06-05 18:01:20'),
(12, 4, 2, 'Files Included', '[\"PSD Files\", \"PNG File\", \"JPEG Files\"]', 0, 12, '2024-06-05 18:00:17', '2024-06-05 18:01:21'),
(13, 5, 1, 'High Resolution', '[\"Yes\",\"No\"]', 1, 13, '2024-06-05 17:58:08', '2024-06-05 18:01:20'),
(14, 6, 1, 'High Resolution', '[\"Yes\",\"No\"]', 1, 13, '2024-06-05 17:58:08', '2024-06-05 18:01:20'),
(15, 7, 1, 'High Resolution', '[\"Yes\",\"No\"]', 1, 13, '2024-06-05 17:58:08', '2024-06-05 18:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Disabled 1:Enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `name`, `alias`, `logo`, `settings`, `instructions`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Google Analytics 4', 'google_analytics', 'images/extensions/google-analytics.png', '{\"measurement_id\":null}', '<ul class=\"mb-0\"> \n<li>Enter google analytics 4 measurement ID, like <strong>G-12345ABC</strong></li> \n</ul>', 0, '2022-02-23 19:40:12', '2023-08-02 15:31:49'),
(3, 'Tawk.to', 'tawk_to', 'images/extensions/tawk-to.png', '{\"api_key\":null}', '<ul class=\"mb-0\"> \r\n<li>https://tawk.to/chat/<strong>API-KEY</strong></li> \r\n</ul>', 0, '2022-02-23 19:40:12', '2023-08-02 15:33:08'),
(4, 'Imgur', 'imgur', 'images/extensions/imgur.png', '{\"client_id\":null}', '<ul class=\"mb-0\"> \r\n<li class=\"mb-2\">Imgur API used to upload images from editors all over the website, this is required for the upload function to work.</li>\r\n<li>Get your client id from:\r\n<a href=\"https://api.imgur.com/oauth2/addclient\" traget=\"_blank\">https://api.imgur.com/oauth2/addclient</a>\r\n</li> \r\n</ul>', 0, '2022-02-23 19:40:12', '2024-11-17 09:12:42'),
(5, 'Trustip', 'trustip', 'images/extensions/trustip.png', '{\"api_key\":null}', '<ul class=\"mb-0\"> \r\n<li class=\"mb-2\">Trustip is used to block people who uses VPN, Proxy, etc from registering or purchasing from the marketplace.</li>\r\n<li>Get your api key from:\r\n<a href=\"https://trustip.io\" traget=\"_blank\">https://trustip.io</a>\r\n</li> \r\n</ul>', 0, '2022-02-23 19:40:12', '2024-06-14 13:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `body`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'What is Lorem Ipsum?', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, '2022-07-16 23:58:31', '2024-03-05 20:42:43'),
(2, 'Why do we use it?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 2, '2022-07-16 23:58:58', '2024-03-05 20:40:41'),
(3, 'Where does it come from?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\r\n\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 3, '2022-07-16 23:59:17', '2024-03-05 20:40:45'),
(4, 'Where can I get some?', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 4, '2022-07-16 23:59:33', '2024-03-05 20:40:48'),
(5, 'Essential Lorem Ipsum a placeholder odyssey?', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 5, '2022-07-16 23:58:31', '2024-03-05 20:43:05'),
(6, 'The Lorem Ipsum Chronicles?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 6, '2022-07-16 23:58:58', '2024-03-05 20:42:06'),
(7, 'Lorem Ipsum Unmasked?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 7, '2022-07-16 23:59:17', '2024-03-05 20:42:31'),
(8, 'Mastering the Art of Lorem Ipsum?', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 8, '2022-07-16 23:59:33', '2024-03-05 20:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Internal 2:External',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `order` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id`, `name`, `link`, `link_type`, `parent_id`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Company', '/page-example', 1, NULL, 1, '2023-02-05 14:20:43', '2024-05-03 20:06:33'),
(2, 'About Us', '/page-example', 1, 1, 1, '2023-02-05 14:21:04', '2024-05-03 20:10:00'),
(3, 'Careers', '/page-example', 1, 1, 2, '2023-02-05 14:21:21', '2023-02-05 14:32:58'),
(4, 'Legal', '/page-example', 1, NULL, 2, '2023-02-05 14:21:53', '2023-02-05 14:33:43'),
(5, 'Privacy policy', '/privacy-policy', 1, 4, 1, '2023-02-05 14:22:03', '2023-02-10 17:47:39'),
(6, 'Terms of use', '/terms-of-use', 1, 4, 2, '2023-02-05 14:22:16', '2023-02-10 17:47:48'),
(7, 'Copyright Policy', '/page-example', 1, 4, 4, '2023-02-05 14:22:27', '2023-02-05 14:34:26'),
(8, 'Contact Us', '/contact-us', 1, 1, 3, '2023-02-05 14:22:53', '2024-05-26 18:12:11'),
(10, 'Press Room', '/page-example', 1, 1, 4, '2023-02-05 14:33:25', '2023-02-05 14:33:33'),
(11, 'Cookies Policy', '/page-example', 1, 4, 3, '2023-02-05 14:34:06', '2023-02-05 14:34:11'),
(12, 'Support', '/page-example', 1, NULL, 3, '2023-02-05 14:34:49', '2023-02-05 14:35:22'),
(13, 'Help Center', '/page-example', 1, 12, 1, '2023-02-05 14:35:02', '2023-02-05 14:35:22'),
(14, 'Customer Service', '/page-example', 1, 12, 2, '2023-02-05 14:35:12', '2023-02-05 14:35:22'),
(15, 'Frequently Asked Questions', '/page-example', 1, 12, 3, '2023-02-05 14:35:28', '2023-02-05 14:35:33'),
(16, 'Report a Problem', '/page-example', 1, 12, 4, '2023-02-05 14:35:49', '2023-02-05 14:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `home_categories`
--

CREATE TABLE `home_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_categories`
--

INSERT INTO `home_categories` (`id`, `name`, `icon`, `link`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'WordPress Themes', 'images/home-categories/Kdy6u0iUSYTIluO_1731856111.jpg', '/categories/themes/wordpress', 1, '2024-03-06 09:34:53', '2024-11-17 09:08:31'),
(2, 'PHP Scripts', 'images/home-categories/AoZTowjKlgBGYnb_1731856116.jpg', '/categories/code/php-scripts', 2, '2024-03-06 09:35:24', '2024-11-17 09:08:36'),
(3, 'HTML5 Themes', 'images/home-categories/cB5YhZWi6VFFKOf_1731856126.jpg', '/categories/themes/html-css', 3, '2024-03-06 09:36:11', '2024-11-17 09:08:46'),
(4, 'CSS Themes', 'images/home-categories/XGHUiFt1abZtsPz_1731856121.jpg', '/categories/themes/html-css', 4, '2024-03-06 09:36:40', '2024-11-17 09:08:41'),
(5, 'Android Apps', 'images/home-categories/aV0t6fwwPMU1nnm_1731856141.jpg', '/categories/mobile/android', 7, '2024-03-06 09:37:31', '2024-11-17 09:09:01'),
(6, 'IOS Apps', 'images/home-categories/9TobGYiPXKFhefI_1731856146.jpg', '/categories/mobile/ios', 8, '2024-03-06 09:37:41', '2024-11-17 09:09:06'),
(8, 'Video Graphics', 'images/home-categories/1MA9fKAETro4snW_1731856131.jpg', '/categories/video', 5, '2024-09-23 00:31:12', '2024-11-17 09:08:51'),
(9, 'Sound Effects', 'images/home-categories/bP30Pyv7DXLmYy3_1731856137.jpg', '/categories/audio/sound-effects', 6, '2024-09-23 00:33:20', '2024-11-17 09:08:57');

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `items_number` int DEFAULT NULL,
  `cache_expiry_time` int UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_id` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `name`, `alias`, `description`, `items_number`, `cache_expiry_time`, `status`, `sort_id`) VALUES
(1, NULL, 'categories', NULL, NULL, 10, 1, 1),
(2, 'Trending Items', 'trending_items', NULL, 4, 1440, 1, 2),
(3, 'Best Selling Items', 'best_selling_items', NULL, 4, 1440, 1, 3),
(4, 'Sale Items', 'sale_items', NULL, 4, 1440, 1, 4),
(5, 'Free Items', 'free_items', NULL, 4, 1440, 1, 5),
(6, 'Our Latest Items', 'latest_items', 'Explore our latest digital offerings, including PHP scripts, templates, and plugins. Stay updated with our newest arrivals, designed to enhance your web projects with cutting-edge functionality and innovation.', 8, 60, 1, 7),
(7, 'FAQ\'s', 'faqs', 'Got questions? We\'ve got answers. Delve into our Frequently Asked Questions (FAQs) section to find comprehensive information about our items, services, and more.', NULL, 30, 1, 9),
(8, 'Testimonials', 'testimonials', 'Discover what our valued clients are saying about their experiences with us.', NULL, 1440, 1, 10),
(9, 'Latest Blog Posts', 'blog_articles', 'Stay informed and inspired with our latest blog posts. Dive into a treasure trove of articles covering a diverse range of topics, from expert insights to practical tips.', 6, 1440, 1, 11),
(12, 'Featured Items', 'featured_items', 'Each week, our team carefully selects the finest new themes, scripts, and plugins from our extensive library.', 4, 1440, 1, 8),
(13, 'Premium Items', 'premium_items', NULL, 4, 1440, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `sub_category_id` bigint UNSIGNED DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `demo_type` enum('embed','direct') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `demo_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_type` enum('image','video','audio') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `preview_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_audio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_file_source` enum('upload','external') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upload',
  `screenshots` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `regular_price` double DEFAULT NULL,
  `extended_price` double DEFAULT NULL,
  `is_supported` tinyint(1) NOT NULL DEFAULT '0',
  `support_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `purchase_method` tinyint DEFAULT '1',
  `purchase_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_sales` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_sales_amount` double DEFAULT '0',
  `total_reviews` bigint UNSIGNED NOT NULL DEFAULT '0',
  `avg_reviews` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_comments` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_views` bigint UNSIGNED NOT NULL DEFAULT '0',
  `current_month_views` bigint UNSIGNED NOT NULL DEFAULT '0',
  `free_downloads` bigint UNSIGNED NOT NULL DEFAULT '0',
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `is_trending` tinyint(1) NOT NULL DEFAULT '0',
  `is_best_selling` tinyint(1) NOT NULL DEFAULT '0',
  `is_on_discount` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_update_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_change_logs`
--

CREATE TABLE `item_change_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_comments`
--

CREATE TABLE `item_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_comment_replies`
--

CREATE TABLE `item_comment_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `item_comment_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_comment_reports`
--

CREATE TABLE `item_comment_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_comment_reply_id` bigint UNSIGNED NOT NULL,
  `reason` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_discounts`
--

CREATE TABLE `item_discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `regular_percentage` int UNSIGNED NOT NULL,
  `regular_price` double NOT NULL,
  `extended_percentage` int UNSIGNED DEFAULT NULL,
  `extended_price` double DEFAULT NULL,
  `starting_at` date NOT NULL,
  `ending_at` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_reviews`
--

CREATE TABLE `item_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `stars` int NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_review_replies`
--

CREATE TABLE `item_review_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `item_review_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_views`
--

CREATE TABLE `item_views` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referrer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_verifications`
--

CREATE TABLE `kyc_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `document_type` enum('national_id','passport') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `documents` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Pending 2:Approved 3:Rejected',
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortcodes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `alias`, `name`, `subject`, `body`, `shortcodes`, `status`) VALUES
(1, 'password_reset', 'Reset Password', 'Reset Your Account Password', '<h2><strong>Hello!</strong></h2><p>You are receiving this email because we received a password reset request for your account, please click on the link below to reset your password.</p><p><a href=\"{{link}}\">{{link}}</a></p><p>This password reset link will expire in <strong>{{expiry_time}}</strong> minutes. If you did not request a password reset, no further action is required.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"link\",\"expiry_time\",\"website_name\"]', 1),
(2, 'email_verification', 'Email Verification', 'Verify Email Address', '<h2>Hello!</h2><p>Please click on the link below to verify your email address.</p><p><a href=\"{{link}}\">{{link}}</a></p><p>If you did not create an account, no further action is required.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"link\",\"website_name\"]', 1),
(3, 'kyc_verification_approved', 'KYC Verification Approved', 'Your KYC verification has been approved', '<h2>Hi, {{username}}</h2><p>We are pleased to inform you that your Know Your Customer (KYC) verification process has been successfully completed and approved. Your account is now fully verified and ready for use.</p><p>This verification process ensures the security and integrity of our platform, and we appreciate your cooperation throughout this process. With your KYC verification approved, you now have access to all features and functionalities of our platform without any restrictions.</p><p>Should you have any questions or require further assistance, please do not hesitate to contact our customer support team. We are here to help you with any queries you may have.</p><p>Thank you for choosing our platform. We look forward to serving you and providing you with an excellent user experience.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"website_name\"]', 1),
(4, 'kyc_verification_rejected', 'KYC Verification Rejected', 'Your KYC verification has been rejected', '<h2>Hi, {{username}}</h2><p>We regret to inform you that your recent Know Your Customer (KYC) verification submission has been rejected. After a thorough review, we have determined that we are unable to approve your KYC verification at this time.</p><p>The reason for the rejection is as follows:&nbsp;<br>“ {{rejection_reason}} ”</p><p>We understand that this may be disappointing, and we apologize for any inconvenience this may cause. Please review the reason provided above to understand why your submission was not successful.</p><p>To address this issue and proceed with the verification process, we kindly request that you review the provided reason and take the necessary steps to rectify any discrepancies or issues. Once you have addressed the concerns, you may resubmit your KYC verification documents for further review.</p><p>If you have any questions or require assistance in understanding the rejection reason or the steps to take for resubmission, please don\'t hesitate to reach out to our customer support team. We are here to assist you throughout this process.</p><p>Thank you for your understanding and cooperation.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"rejection_reason\",\"website_name\"]', 1),
(5, 'new_ticket', 'New Ticket', 'New Ticket [#{{ticket_id}}]', '<h2>Hi <strong>{{username}},</strong></h2><p>We trust this message finds you well. We want to inform you that a new support ticket has been created.</p><p>Here are the details of the ticket:</p><p><strong>Ticket ID:</strong> #{{ticket_id}}</p><p><strong>Category: </strong>{{category}}</p><p><strong>Date Created:</strong> {{date}}</p><p><strong>Brief Description of the Issue:</strong> {{subject}}<strong>.</strong></p><p>You can view the entire conversation and reply by following this link:<a href=\"{{link}}\"> {{link}}</a></p><p>We understand the importance of your concern and assure you that it\'s receiving our immediate attention. Our dedicated team will be reviewing your request and will provide updates, solutions, or further assistance as needed.</p><p>Should you have any additional information to share or any questions, feel free to log in to our support portal and contribute to the ongoing conversation about your ticket.</p><p>Thank you for giving us the opportunity to assist you.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"ticket_id\",\"subject\",\"category\",\"link\",\"date\",\"website_name\"]', 1),
(6, 'new_ticket_reply', 'New Ticket Reply', 'New reply on your ticket [#{{ticket_id}}]', '<h2>Hi <strong>{{username}},</strong></h2><p>We hope this message finds you well. We wanted to inform you that a new reply has been added to your support ticket #<strong>{{ticket_id}}</strong>. Our team has been working diligently to assist you.</p><p><strong>Reply Message:</strong></p><p>{{reply_message}}</p><p><strong>Reply date: </strong>{{date}}</p><p>You can view the entire conversation and reply by following this link:<a href=\"{{link}}\"> {{link}}</a></p><p>Thank you for your patience and cooperation as we work to resolve your issue.</p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"ticket_id\",\"reply_message\",\"link\",\"date\",\"website_name\"]', 1),
(7, 'buyer_item_update', 'Buyer Item Update', 'New Update ({{item_name}})', '<h2>Hi, {{username}}!</h2><p>We have released a new update for <strong>{{item_name}}, </strong>here is the details:</p><p><a href=\"{{item_link}}\"><strong>{{item_name}}</strong></a></p><p><a href=\"{{item_link}}\">{{item_preview_image}}</a></p><p><strong>View Item:</strong> <a href=\"{{item_link}}\">{{item_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"item_name\",\"item_preview_image\",\"item_link\",\"website_name\"]', 1),
(8, 'subscriber_new_item', 'Subscriber New Item', 'New item has been published', '<h2>Hello!</h2><p>We want to let you know that we have published a new item, here are the details:</p><p><a href=\"{{item_link}}\"><strong>{{item_name}}</strong></a></p><p><a href=\"{{item_link}}\">{{item_preview_image}}</a></p><p><strong>View Item:</strong> <a href=\"{{item_link}}\">{{item_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"item_name\",\"item_preview_image\",\"item_link\",\"website_name\"]', 1),
(9, 'payment_confirmation', 'Payment Confirmation', 'Payment Confirmation [#{{transaction_id}}]', '<h2>Hi, {{username}}</h2><p>We hope this email finds you well. We are reaching out to confirm the successful payment for your recent transaction.</p><p><strong><u>Here are the details of your transaction:</u></strong></p><p><strong>Transaction ID:</strong> #{{transaction_id}}</p><p><strong>Payment Method:</strong> {{payment_method}}</p><p><strong>SubTotal:</strong> {{transaction_subtotal}}</p><p><strong>Fees:</strong> {{transaction_fees}}</p><p><strong>Total :</strong> {{transaction_total}}</p><p><strong>Date: </strong>{{transaction_date}}</p><p>Your payment has been processed successfully, and your transaction is now complete. You can view the transaction and print your invoice by clicking on the link below</p><p><a href=\"{{transaction_view_link}}\">{{transaction_view_link}}</a></p><p>If you have any questions or require further assistance, please don\'t hesitate to contact us. We are here to help.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"transaction_id\",\"transaction_subtotal\",\"payment_method\",\"transaction_fees\",\"transaction_total\",\"transaction_date\",\"transaction_view_link\",\"website_name\"]', 1),
(10, 'purchase_confirmation', 'Purchase Confirmation', 'Your Purchase Confirmation ({{item_name}})', '<h2>Hi, {{username}}</h2><p>We are thrilled to inform you that your recent purchase has been successfully processed. Your satisfaction is our priority, and we are grateful for your trust in {{website_name}}.</p><p><strong><u>Here are the details of your purchase:</u></strong></p><p><a href=\"{{item_link}}\">{{item_preview_image}}</a></p><p><strong>Item Name: </strong><a href=\"{{item_link}}\">{{item_name}}</a></p><p><strong>Purchase Code: </strong>{{purchase_code}}</p><p><strong>Download Link: </strong><a href=\"{{download_link}}\">{{download_link}}</a></p><p>If you have any questions or require further assistance, please don\'t hesitate to contact us. We are here to help.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"item_name\",\"item_preview_image\",\"item_link\",\"purchase_code\",\"download_link\",\"website_name\"]', 1),
(11, 'transaction_cancelled', 'Transaction Cancelled', 'Your transaction has been canceled [#{{transaction_id}}]', '<h2>Hi, {{username}}</h2><p>We hope this email finds you well. We are reaching out because your recent transaction has been canceled for the following reason:</p><p>--</p><p><i>{{cancellation_reason}}</i></p><p><i>--</i></p><p><strong><u>Here are the details of your transaction:</u></strong></p><p><strong>Transaction ID:</strong> #{{transaction_id}}</p><p><strong>Payment Method:</strong> {{payment_method}}</p><p><strong>SubTotal:</strong> {{transaction_subtotal}}</p><p><strong>Fees:</strong> {{transaction_fees}}</p><p><strong>Total:</strong> {{transaction_total}}</p><p><strong>Date: </strong>{{transaction_date}}</p><p><strong>View Link:</strong> <a href=\"{{transaction_view_link}}\">{{transaction_view_link}}</a></p><p>If you have any questions or require further assistance, please don\'t hesitate to contact us. We are here to help.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"transaction_id\",\"transaction_subtotal\",\"payment_method\",\"transaction_fees\",\"transaction_total\",\"transaction_date\",\"transaction_view_link\",\"cancellation_reason\",\"website_name\"]', 1),
(12, 'item_comment_reply', 'Item Comment Reply', 'New reply to your comment on item \"{{item_name}}\"', '<h2>Hi, {{username}}</h2><p>You have a new reply to your comment on “<a href=\"{{item_link}}\">{{item_name}}</a>”</p><p>--</p><p><i>{{comment_reply}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can reply by following this link</span><strong>:</strong> <a href=\"{{comment_link}}\">{{comment_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"comment_reply\",\"item_name\",\"item_link\",\"comment_link\",\"website_name\"]', 1),
(13, 'refund_request_new_reply', 'Refund Request New Reply', 'New reply on your refund request for \"{{refund_item_name}}\"', '<h2>Hi, {{username}}</h2><p>You have a new reply on your refund request for “<strong>{{refund_item_name}}</strong>”&nbsp;</p><p>--</p><p><i>{{refund_reply}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can view and reply by following this link</span><strong>:</strong> <a href=\"{{refund_link}}\">{{refund_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"refund_id\",\"refund_item_name\",\"refund_reply\",\"refund_link\",\"website_name\"]', 1),
(14, 'refund_request_accepted', 'Refund Request Accepted', 'Your refund request for \"{{refund_item_name}}\" has been accepted', '<h2>Hi, {{username}}</h2><p>Your refund request for “<strong>{{refund_item_name}}</strong>” has been accepted and the full amount of <strong>{{refund_amount}}</strong> has been refunded to your {{website_name}} account.</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can view the refund request by following this link</span><strong>:</strong> <a href=\"{{refund_link}}\">{{refund_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"refund_id\",\"refund_item_name\",\"refund_amount\",\"refund_link\",\"website_name\"]', 1),
(15, 'refund_request_declined', 'Refund Request Declined', 'Your refund request for \"{{refund_item_name}}\" has been declined', '<h2>Hi, {{username}}</h2><p>Your refund request for “<strong>{{refund_item_name}}</strong>” has been declined</p><p>--</p><p><i>{{refund_decline_reason}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can view the refund request by following this link</span><strong>:</strong> <a href=\"{{refund_link}}\">{{refund_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"refund_id\",\"refund_item_name\",\"refund_decline_reason\",\"refund_link\",\"website_name\"]', 1),
(16, 'subscription_about_to_expire', 'Subscription About To Expire', 'Your subscription is about to expire', '<h2>Hi {{username}},</h2><p>We hope you\'re enjoying your experience on {{website_name}}. We wanted to remind you that your subscription is set to expire on <strong>{{expiry_date}}</strong>.</p><p>Don\'t miss out on continued access to our extensive library of assets and exclusive resources. To renew or upgrade your subscription, simply click the link below:</p><p><a href=\"{{renewing_link}}\">{{renewing_link}}</a></p><p>We look forward to continuing to support you with the best resources and tools.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"expiry_date\",\"renewing_link\",\"website_name\"]', 1),
(17, 'subscription_expired', 'Subscription Expired', 'Your subscription has been expired', '<h2>Hi {{username}},</h2><p>We wanted to inform you that your subscription expired on <strong>{{expiry_date}}</strong>. Unfortunately, you no longer have access to our exclusive library of assets.</p><p>But don\'t worry—you can easily renew or upgrade your subscription to regain access to all the resources you love! Just click the link below to renew:</p><p><a href=\"{{renewing_link}}\">{{renewing_link}}</a></p><p>We hope to see you back soon!</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"expiry_date\",\"renewing_link\",\"website_name\"]', 1),
(18, 'admin_kyc_pending', 'Admin KYC Pending', 'KYC Verification Request [#{{kyc_verification_id}}]', '<h2>Hello!</h2><p>You have a new KYC Verification Request submitted by <strong>{{username}} </strong>and the ID is #<strong>{{kyc_verification_id}}</strong></p><p><a href=\"{{review_link}}\">{{review_link}}</a></p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"kyc_verification_id\",\"review_link\",\"website_name\"]', 1),
(19, 'admin_transaction_pending', 'Admin Transaction Pending', 'New Pending Transaction [#{{transaction_id}}]', '<h2>Hello!</h2><p>You have a new pending transaction made by <strong>{{username}}</strong>.&nbsp;</p><p><strong><u>Here are the details:</u></strong></p><p><strong>Transaction ID:</strong> #{{transaction_id}}</p><p><strong>Payment Method:</strong> {{payment_method}}</p><p><strong>SubTotal:</strong> {{transaction_subtotal}}</p><p><strong>Fees:</strong> {{transaction_fees}}</p><p><strong>Total:</strong> {{transaction_total}}</p><p><strong>Date: </strong>{{transaction_date}}</p><p><strong>Review Link: </strong><a href=\"{{review_link}}\">{{review_link}}</a></p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"transaction_id\",\"transaction_subtotal\",\"transaction_fees\",\"transaction_total\",\"payment_method\",\"transaction_date\",\"review_link\",\"website_name\"]', 1),
(20, 'admin_new_ticket', 'Admin New Ticket', 'New Ticket [#{{ticket_id}}]', '<h2>Hello!</h2><p>A new ticket has been created by <strong>{{username}}</strong>. Here are the details:</p><p><strong>Ticket ID:</strong> #{{ticket_id}}</p><p><strong>Category: </strong>{{category}}</p><p><strong>Date Created:</strong> {{date}}</p><p><strong>Brief Description of the Issue:</strong> {{subject}}<strong>.</strong></p><p>You can view the entire conversation and reply by following this link:<a href=\"{{link}}\"> {{link}}</a></p><p>The department agents and the admins have been informed, action will be taken and assistance will be provided.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"username\",\"ticket_id\",\"subject\",\"category\",\"link\",\"date\",\"website_name\"]', 1),
(21, 'admin_new_ticket_reply', 'Admin New Ticket Reply', 'New Ticket Reply [#{{ticket_id}}]', '<h2>Hello!</h2><p>A new reply by<strong> {{username}}</strong> has been added to the ticket #<strong>{{ticket_id}}</strong>.</p><p><strong>Reply message:</strong></p><p>{{reply_message}}</p><p><strong>Reply date: </strong>{{date}}</p><p>You can view the entire conversation and reply by following this link:<a href=\"{{link}}\"> {{link}}</a></p><p>The department agents and the admins have been informed, action will be taken and assistance will be provided</p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"ticket_id\",\"reply_message\",\"link\",\"date\",\"website_name\"]', 1),
(22, 'admin_item_comment', 'Admin Item Comment ', 'New comment on your item \"{{item_name}}\" from {{username}}', '<h2>Hello!</h2><p>You have a new comment on your item “<a href=\"{{item_link}}\">{{item_name}}</a>” from {{username}}</p><p>--</p><p><i>{{comment}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can reply by following this link</span><strong>:</strong> <a href=\"{{comment_link}}\">{{comment_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"comment\",\"item_name\",\"item_link\",\"comment_link\",\"website_name\"]', 1),
(23, 'admin_item_comment_reply', 'Admin Item Comment Reply', 'New comment reply on your item \"{{item_name}}\" from {{username}}', '<h2>Hello!</h2><p>You have a new comment reply on your item “<a href=\"{{item_link}}\">{{item_name}}</a>” from {{username}}</p><p>--</p><p><i>{{comment_reply}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can reply by following this link</span><strong>:</strong> <a href=\"{{comment_link}}\">{{comment_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"comment_reply\",\"item_name\",\"item_link\",\"comment_link\",\"website_name\"]', 1),
(24, 'admin_item_review', 'Admin Item Review ', 'New review on your item \"{{item_name}}\" from {{username}}', '<h2>Hello!</h2><p>You have a new review on your item “<a href=\"{{item_link}}\">{{item_name}}</a>” from {{username}}</p><p><strong>Stars:</strong> {{stars}}</p><p>--</p><p><i>{{review}}</i></p><p>--</p><p>Review link: <a href=\"{{review_link}}\">{{review_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"stars\",\"review\",\"item_name\",\"item_link\",\"review_link\",\"website_name\"]', 1),
(25, 'admin_refund_request', 'Admin Refund Request', 'Refund Request for \"{{refund_item_name}}\" from {{username}}', '<h2>Hello!</h2><p>You have a new refund request for “<strong>{{refund_item_name}}</strong>” from <strong>{{username}}</strong></p><p>--</p><p><i>{{refund_reason}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can view and take action by following this link</span><strong>:</strong> <a href=\"{{refund_link}}\">{{refund_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"refund_id\",\"refund_item_name\",\"refund_reason\",\"refund_link\",\"website_name\"]', 1),
(26, 'admin_refund_request_reply', 'Admin Refund Request Reply', 'New Reply On Refund request [#{{refund_id}}]', '<h2>Hello!</h2><p>You have a new reply on refund request for “<strong>{{refund_item_name}}</strong>” from <strong>{{username}}&nbsp;</strong></p><p>--</p><p><i>{{refund_reply}}</i></p><p>--</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(34,34,34);\">You can view and take action by following this link</span><strong>:</strong> <a href=\"{{refund_link}}\">{{refund_link}}</a></p><p>Regards,&nbsp;<br><strong>{{website_name}}</strong></p>', '[\"username\",\"refund_id\",\"refund_item_name\",\"refund_reply\",\"refund_link\",\"website_name\"]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_100000_create_password_resets_table', 5),
(11, '2021_10_04_213420_create_pages_table', 11),
(15, '2021_10_07_221832_create_settings_table', 15),
(17, '2022_02_23_213634_create_extensions_table', 17),
(18, '2022_04_03_220038_create_mail_templates_table', 18),
(19, '2023_07_30_152852_create_oauth_providers_table', 19),
(20, '2023_09_17_154715_create_payment_gateways_table', 20),
(21, '2023_09_26_125948_create_themes_table', 21),
(22, '2023_10_01_131610_create_addons_table', 22),
(45, '2019_12_14_000001_create_personal_access_tokens_table', 45),
(47, '2021_10_06_201713_create_blog_categories_table', 46),
(48, '2021_10_06_201752_create_blog_articles_table', 46),
(55, '2021_10_28_191044_create_storage_providers_table', 49),
(57, '2023_11_22_173153_create_faqs_table', 51),
(58, '2023_11_22_182033_create_testimonials_table', 52),
(64, '2023_12_15_151129_create_home_categories_table', 54),
(95, '2024_03_13_165718_create_home_sections_table', 60),
(126, '2024_04_16_191052_create_ads_table', 68),
(148, '2024_05_03_174916_create_jobs_table', 77),
(149, '2024_05_03_183505_create_failed_jobs_table', 78),
(160, '2024_05_15_205642_create_translates_table', 84),
(172, '2024_06_29_151017_create_captcha_providers_table', 88),
(174, '2024_07_09_110258_create_support_periods_table', 89),
(184, '2024_09_03_111407_create_plans_table', 94),
(190, '2014_10_12_000000_create_users_table', 95),
(191, '2014_10_12_300000_create_user_login_logs_table', 95),
(192, '2021_10_06_202153_create_blog_comments_table', 95),
(193, '2023_12_10_172652_create_navbar_links_table', 95),
(194, '2023_12_10_172728_create_footer_links_table', 95),
(195, '2023_12_13_172603_create_categories_table', 95),
(196, '2023_12_13_173552_create_sub_categories_table', 95),
(197, '2023_12_21_135143_create_category_options_table', 95),
(199, '2024_01_03_003738_create_items_table', 96),
(200, '2024_03_09_193935_create_item_discounts_table', 96),
(201, '2024_03_19_171106_create_cart_items_table', 96),
(202, '2024_03_21_025080_create_sales_table', 97),
(203, '2024_03_21_025090_create_purchases_table', 97),
(204, '2024_03_21_025100_create_transactions_table', 97),
(205, '2024_03_21_050420_create_transaction_items_table', 97),
(210, '2024_04_04_223335_create_item_views_table', 97),
(211, '2024_04_20_185430_create_statements_table', 97),
(212, '2024_04_23_173759_create_favorites_table', 97),
(215, '2024_05_04_210907_create_ticket_categories_table', 97),
(216, '2024_05_06_170025_create_tickets_table', 97),
(219, '2024_05_30_163150_create_taxes_table', 97),
(220, '2024_06_21_191033_create_item_change_logs_table', 97),
(221, '2024_07_10_105956_create_support_earnings_table', 97),
(223, '2024_09_09_152943_create_subscriptions_table', 97),
(224, '2024_09_12_002743_create_premium_earnings_table', 97),
(225, '2024_02_24_162334_create_kyc_verifications_table', 98),
(226, '2023_12_29_155557_create_uploaded_files_table', 99),
(227, '2024_09_23_213245_create_newsletter_subscribers_table', 100),
(228, '2024_04_01_235823_create_item_reviews_table', 101),
(230, '2024_04_04_223313_create_item_comments_table', 101),
(231, '2024_04_04_223335_create_item_comment_replies_table', 101),
(232, '2024_04_24_192449_create_refunds_table', 101),
(233, '2024_04_24_192550_create_refund_replies_table', 101),
(234, '2024_05_07_171258_create_ticket_replies_table', 101),
(235, '2024_05_07_171419_create_ticket_reply_attachments_table', 101),
(236, '2024_08_24_114518_create_item_comment_reports_table', 101),
(237, '2014_10_11_1000000_create_admin_notifications_table', 102),
(238, '2024_04_01_235824_create_item_review_replies_table', 103),
(239, '2024_10_24_205653_create_help_categories_table', 104),
(240, '2024_10_24_205705_create_help_articles_table', 104);

-- --------------------------------------------------------

--
-- Table structure for table `navbar_links`
--

CREATE TABLE `navbar_links` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_type` tinyint NOT NULL DEFAULT '1',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `order` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navbar_links`
--

INSERT INTO `navbar_links` (`id`, `name`, `link`, `link_type`, `parent_id`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', 1, NULL, 1, '2024-05-25 18:29:21', '2024-05-25 18:29:21'),
(2, 'WordPress', '/categories/themes/wordpress', 1, 17, 1, '2024-05-25 18:30:14', '2024-05-26 08:35:13'),
(5, 'Code', '/categories/code', 1, NULL, 3, '2024-05-25 18:31:00', '2024-09-27 18:08:16'),
(8, 'Help & Support', '/categories/code/help-support', 1, 5, 3, '2024-05-25 18:32:55', '2024-09-27 18:09:54'),
(9, 'Add-ons', '/categories/code/add-ons', 1, 5, 1, '2024-05-25 18:33:17', '2024-09-27 18:09:54'),
(11, 'Graphics', '/categories/graphics', 1, NULL, 6, '2024-05-25 18:37:06', '2024-09-27 18:08:34'),
(12, 'Icons', '/categories/graphics/icons', 1, 11, 1, '2024-05-25 18:37:15', '2024-05-26 08:38:39'),
(13, 'PSD Files', '/categories/graphics/psd-files', 1, 11, 2, '2024-05-25 18:37:28', '2024-05-26 08:38:48'),
(14, 'Mobile', '/categories/mobile', 1, NULL, 7, '2024-05-25 18:37:47', '2024-09-27 18:08:34'),
(15, 'IOS', '/categories/mobile/ios', 1, 14, 1, '2024-05-25 18:37:56', '2024-05-26 08:39:08'),
(16, 'Android', '/categories/mobile/android', 1, 14, 2, '2024-05-25 18:38:09', '2024-05-26 08:39:20'),
(17, 'Themes', '/categories/themes', 1, NULL, 2, '2024-05-25 18:38:45', '2024-05-26 08:35:02'),
(18, 'HTML & CSS', '/categories/themes/html-css', 1, 17, 2, '2024-05-25 18:39:04', '2024-05-26 08:35:22'),
(19, 'Bootstrap', '/categories/themes/bootstrap', 1, 17, 3, '2024-05-25 18:39:35', '2024-05-26 08:35:31'),
(23, 'Video', '/categories/video', 1, NULL, 4, '2024-09-20 23:57:58', '2024-09-21 00:00:03'),
(24, 'Illustrations', '/categories/video/illustrations', 1, 23, 1, '2024-09-20 23:58:29', '2024-09-20 23:58:55'),
(25, 'Effects', '/categories/video/effects', 1, 23, 2, '2024-09-20 23:58:52', '2024-09-20 23:58:57'),
(26, 'Audio', '/categories/audio', 1, NULL, 5, '2024-09-20 23:59:14', '2024-09-21 00:00:07'),
(27, 'Music', '/categories/audio/music', 1, 26, 1, '2024-09-20 23:59:40', '2024-09-20 23:59:58'),
(28, 'Sound Effects', '/categories/audio/sound-effects', 1, 26, 2, '2024-09-20 23:59:55', '2024-09-20 23:59:59'),
(29, 'PHP Scripts', '/categories/code/php-scripts', 1, 5, 2, '2024-09-27 18:08:30', '2024-09-27 18:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin@vironeer.com', '2024-11-17 09:28:02', '2024-11-17 09:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_providers`
--

CREATE TABLE `oauth_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_providers`
--

INSERT INTO `oauth_providers` (`id`, `name`, `alias`, `logo`, `credentials`, `instructions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'facebook', 'images/oauth/facebook.png', '{\"client_id\":null,\"client_secret\":null}', '<ul class=\"mb-0\"><li><strong>Redirect URL :</strong> [URL]/oauth/facebook/callback</li> \n</ul>', 0, '2022-02-23 18:40:12', '2024-11-17 09:11:45'),
(2, 'Google', 'google', 'images/oauth/google.png', '{\"client_id\":null,\"client_secret\":null}', '<ul class=\"mb-0\">  <li><strong>Redirect URL :</strong> [URL]/oauth/google/callback</li>  </ul>', 0, '2022-02-23 18:40:12', '2024-11-17 09:11:52'),
(3, 'Microsoft', 'microsoft', 'images/oauth/microsoft.png', '{\"client_id\":null,\"client_secret\":null}', '<ul class=\"mb-0\">  <li><strong>Redirect URL :</strong> [URL]/oauth/microsoft/callback</li>  </ul>', 0, '2022-02-23 18:40:12', '2024-11-17 09:11:57'),
(4, 'Vkontakte', 'vkontakte', 'images/oauth/vkontakte.png', '{\"client_id\":null,\"client_secret\":null}', '<ul class=\"mb-0\">  <li><strong>Redirect URL :</strong> [URL]/oauth/vkontakte/callback</li>  </ul>', 0, '2022-02-23 18:40:12', '2024-11-17 09:12:02'),
(5, 'Envato', 'envato', 'images/oauth/envato.png', '{\"client_id\":null,\"client_secret\":null}', '<ul class=\"mb-0\">  <li><strong>Redirect URL :</strong> [URL]/oauth/envato/callback</li>  </ul>', 0, '2022-02-23 18:40:12', '2024-11-17 09:12:08'),
(6, 'Github', 'github', 'images/oauth/github.png', '{\"client_id\":null,\"client_secret\":null}', '<ul class=\"mb-0\">  <li><strong>Redirect URL :</strong> [URL]/oauth/github/callback</li>  </ul>', 0, '2022-02-23 18:40:12', '2024-11-17 09:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `body`, `short_description`, `views`, `created_at`, `updated_at`) VALUES
(2, 'Privacy policy', 'privacy-policy', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 65, '2024-03-05 20:19:14', '2024-11-17 07:43:19'),
(3, 'Terms of use', 'terms-of-use', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 59, '2024-03-05 20:19:38', '2024-11-17 07:43:19'),
(4, 'Refund policy', 'refund-policy', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 68, '2024-03-05 20:19:58', '2024-09-11 01:15:23'),
(5, 'Page Example', 'page-example', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 29, '2024-03-05 20:20:33', '2024-11-17 07:43:19'),
(6, 'Licenses Terms', 'licenses-terms', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 20, '2024-03-17 22:45:16', '2024-11-17 09:01:34'),
(9, 'Free Items Policy', 'free-items-policy', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 7, '2024-06-01 13:39:34', '2024-11-17 07:43:22'),
(10, 'Premium Terms', 'premium-terms', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 8, '2024-09-11 00:15:04', '2024-11-17 07:43:21'),
(12, 'GDPR Policy', 'gdpr-policy', '<p><strong>What is Lorem Ipsum?</strong></p><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><strong>Where does it come from?</strong></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><strong>Why do we use it?</strong></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><strong>Where can I get some?</strong></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 3, '2024-11-15 13:31:38', '2024-11-17 07:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `sort_id` bigint NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees` int NOT NULL DEFAULT '0',
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_manual` tinyint(1) NOT NULL DEFAULT '0',
  `instructions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mode` enum('sandbox','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `sort_id`, `name`, `alias`, `logo`, `fees`, `credentials`, `parameters`, `is_manual`, `instructions`, `mode`, `status`) VALUES
(1, 1, 'Wallet', 'wallet', 'images/payment-gateways/wallet.png', 0, NULL, NULL, 1, NULL, NULL, 1),
(2, 2, 'Paypal', 'paypal', 'images/payment-gateways/paypal.png', 0, '{\"client_id\":null,\"client_secret\":null,\"webhook_id\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"payment.capture.completed\"},\r\n{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/paypal\" }]', 0, NULL, 'sandbox', 0),
(3, 3, 'Stripe', 'stripe', 'images/payment-gateways/stripe.png', 0, '{\"publishable_key\":null,\"secret_key\":null,\"webhook_secret\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"checkout.session.completed\"},\n{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/stripe\" }]', 0, NULL, NULL, 0),
(4, 5, 'Razorpay', 'razorpay', 'images/payment-gateways/razorpay.png', 0, '{\"key_id\":null,\"key_secret\":null,\"webhook_secret\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"payment.captured\"},{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/razorpay\"}]', 0, NULL, NULL, 0),
(5, 4, 'Paystack', 'paystack', 'images/payment-gateways/paystack.png', 0, '{\"public_key\":null,\"secret_key\":null}', '[{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/paystack\" }]', 0, NULL, NULL, 0),
(6, 6, 'Mollie', 'mollie', 'images/payment-gateways/mollie.png', 0, '{\"api_key\":null}', NULL, 0, NULL, NULL, 0),
(7, 7, 'Coinbase', 'coinbase', 'images/payment-gateways/coinbase.png', 0, '{\"api_key\":null,\"webhook_shared_secret\":null}', '[{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/coinbase\" }]', 0, NULL, NULL, 0),
(8, 8, 'Coingate', 'coingate', 'images/payment-gateways/coingate.png', 0, '{\"auth_token\":null}', NULL, 0, NULL, NULL, 0),
(9, 9, 'Flutterwave', 'flutterwave', 'images/payment-gateways/flutterwave.png', 0, '{\"public_key\":null,\"secret_key\":null,\"secret_hash\":null}', '[{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/flutterwave\" }]', 0, NULL, NULL, 0),
(10, 13, 'Bank Wire', 'bankwire', 'images/payment-gateways/bankwire.png', 0, NULL, NULL, 1, NULL, NULL, 0),
(11, 10, 'Midtrans', 'midtrans', 'images/payment-gateways/midtrans.png', 0, '{\"server_key\":null}', '[{\"type\": \"route\", \"label\": \"Finish URL\", \"content\": \"payments/ipn/midtrans\"},\n{\"type\": \"route\", \"label\": \"Unfinish URL\", \"content\": \"payments/ipn/midtrans\"},\n{\"type\": \"route\", \"label\": \"Error Payment URL\", \"content\":\"payments/ipn/midtrans\"}]', 0, NULL, 'sandbox', 0),
(12, 11, 'Xendit', 'xendit', 'images/payment-gateways/xendit.png', 0, '{\"api_secret_key\":null,\"webhook_verification_token\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"invoices.paid\"},\r\n{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/xendit\" }]', 0, NULL, NULL, 0),
(13, 12, 'Iyzico', 'iyzico', 'images/payment-gateways/iyzipay.png', 0, '{\"api_key\":null,\"secret_key\":null}', '[{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/iyzipay\" }]', 0, NULL, 'sandbox', 0);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` enum('week','month','year','lifetime') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double DEFAULT NULL,
  `author_earning_percentage` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `downloads` bigint UNSIGNED DEFAULT NULL,
  `custom_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `premium_earnings`
--

CREATE TABLE `premium_earnings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `tax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` double NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sale_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `license_type` tinyint NOT NULL COMMENT '1:Regular 2:Extended',
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `support_expiry_at` datetime DEFAULT NULL,
  `is_downloaded` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Active 2:Refunded 3:Cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `purchase_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Pending 2:Accepted 3:Declined',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_replies`
--

CREATE TABLE `refund_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `refund_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `license_type` tinyint NOT NULL COMMENT '1:Regular 2:Extended',
  `price` double NOT NULL,
  `tax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` double NOT NULL,
  `country` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Active 2:Refunded 3:Cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'general', '{\"site_name\":\"Codebob\",\"site_url\":\"http:\\/\\/codebob.viro.com\",\"date_format\":\"10\",\"timezone\":\"America\\/New_York\",\"contact_email\":null}'),
(2, 'smtp', '{\"status\":0,\"mailer\":\"smtp\",\"host\":null,\"port\":null,\"username\":null,\"password\":null,\"encryption\":\"ssl\",\"from_email\":null,\"from_name\":null}'),
(3, 'actions', '{\"registration\":1,\"email_verification\":0,\"gdpr_cookie\":1,\"force_ssl\":0,\"blog\":1,\"tickets\":1,\"refunds\":1,\"contact_page\":0}'),
(4, 'currency', '{\"code\":\"USD\",\"symbol\":\"$\",\"position\":\"1\"}'),
(5, 'deposit', '{\"status\":1,\"minimum\":\"10\",\"maximum\":\"1000\"}'),
(6, 'seo', '{\"title\":\"Single-Vendor Digital Marketplace\",\"description\":\"WordPress Templates, Plugins, PHP Scripts, and Graphics Digital Marketplace\",\"keywords\":\"JavaScript, PHP Scripts, CSS, HTML5, Site Templates, WordPress Themes, Plugins, Mobile Apps, Graphics, Prints, Brochures, Flyers, Resumes,\"}'),
(7, 'system_admin', '{\"colors\":{\"primary_color\":\"#1363DF\",\"secondary_color\":\"#1d2734\",\"background_color\":\"#f9fafb\",\"sidebar_background_color\":\"#1d2734\",\"navbar_background_color\":\"#ffffff\"}}'),
(9, 'kyc', '{\"status\":1,\"selfie_verification\":1,\"required\":0,\"id_front_image\":\"images\\/kyc\\/F6uxReOavrBbRnr_1708719956.svg\",\"id_back_image\":\"images\\/kyc\\/lDNgqlaFCClbRaA_1708720002.svg\",\"passport_image\":\"images\\/kyc\\/QLEDc8sXn6h2e7E_1708729601.svg\",\"selfie_image\":\"images\\/kyc\\/5CwgvmI9gcd067i_1708720379.svg\"}'),
(10, 'item', '{\"buy_now_button\":1,\"item_total_sales\":1,\"free_item_total_downloads\":1,\"reviews_status\":1,\"comments_status\":1,\"support_status\":1,\"changelogs_status\":1,\"free_items_require_login\":1,\"trending_number\":\"20\",\"best_selling_number\":\"20\",\"convert_images_webp\":\"1\",\"file_duration\":\"24\"}'),
(13, 'language', '{\"code\":\"en\",\"direction\":\"ltr\"}'),
(14, 'links', '{\"terms_of_use_link\":\"\\/terms-of-use\",\"licenses_terms_link\":\"\\/licenses-terms\",\"free_items_policy_link\":\"\\/free-items-policy\",\"gdpr_cookie_policy_link\":\"\\/gdpr-policy\"}'),
(15, 'announcement', '{\"body\":\"Unlocking Joy: 50% Off On WordPress Themes\",\"button_title\":\"Get It Now >>\",\"button_link\":\"\\/\",\"background_color\":\"#65c22b\",\"button_background_color\":\"#ffffff\",\"button_text_color\":\"#65c22b\",\"status\":1}'),
(17, 'cronjob', '{\"key\":\"\",\"last_execution\":\"\"}'),
(18, 'ticket', '{\"file_types\":\"jpeg,jpg,png,pdf\",\"max_files\":\"5\",\"max_file_size\":\"10\"}'),
(19, 'maintenance', '{\"status\":0,\"title\":\"Under Maintenance\",\"body\":\"Our site is currently undergoing scheduled maintenance to enhance your browsing experience. We apologize for any inconvenience and appreciate your patience. Please check back soon!\",\"password\":\"$2y$10$eB9Pu5bQiDFSI86Mbm.\\/LeYK09kk8NwE3k\\/.BHJtp3pxHHOKwkL\\/6\",\"image\":\"images\\/maintenance\\/rrKIohOTdb7fyo5_1727390834.jpg\"}'),
(21, 'social_links', '{\"facebook\":\"\\/\",\"x\":\"\\/\",\"youtube\":\"\\/\",\"linkedin\":\"\\/\",\"instagram\":\"\\/\",\"pinterest\":\"\\/\"}'),
(24, 'premium', '{\"status\":1,\"terms_link\":\"\\/premium-terms\"}'),
(25, 'newsletter', '{\"status\":1,\"popup_status\":0,\"footer_status\":1,\"register_new_users\":1,\"popup_image\":\"images\\/newsletter\\/lezCcElE6YTIcaZ_1727215505.jpg\",\"popup_reminder_time\":\"24\"}'),
(26, 'api', '{\"status\":0,\"key\":null}');

-- --------------------------------------------------------

--
-- Table structure for table `statements`
--

CREATE TABLE `statements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `type` tinyint NOT NULL COMMENT '1:credit 2:debit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storage_providers`
--

CREATE TABLE `storage_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `processor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `storage_providers`
--

INSERT INTO `storage_providers` (`id`, `name`, `alias`, `processor`, `credentials`, `created_at`, `updated_at`) VALUES
(1, 'Local', 'local', 'App\\Http\\Controllers\\Storage\\LocalController', NULL, '2024-03-06 00:23:02', '2024-03-06 00:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `total_downloads` bigint UNSIGNED NOT NULL DEFAULT '0',
  `expiry_at` datetime DEFAULT NULL,
  `last_notification_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `title`, `description`, `category_id`, `views`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'WordPress', 'wordpress', NULL, NULL, 1, 12, 1, '2024-05-26 08:12:57', '2024-11-17 07:43:17'),
(2, 'HTML & CSS', 'html-css', NULL, NULL, 1, 9, 2, '2024-05-26 08:13:06', '2024-11-17 07:43:17'),
(3, 'Bootstrap', 'bootstrap', NULL, NULL, 1, 6, 3, '2024-05-26 08:13:13', '2024-11-17 07:43:17'),
(4, 'Add-ons', 'add-ons', NULL, NULL, 2, 8, 4, '2024-05-26 08:13:27', '2024-11-17 07:43:17'),
(7, 'Help & Support', 'help-support', NULL, NULL, 2, 6, 6, '2024-05-26 08:13:55', '2024-11-17 07:43:17'),
(10, 'Icons', 'icons', NULL, NULL, 4, 6, 7, '2024-05-26 08:14:33', '2024-11-17 07:43:17'),
(11, 'PSD Files', 'psd-files', NULL, NULL, 4, 5, 8, '2024-05-26 08:14:40', '2024-11-17 07:43:17'),
(12, 'IOS', 'ios', NULL, NULL, 5, 8, 9, '2024-05-26 08:14:50', '2024-11-17 09:01:03'),
(13, 'Android', 'android', NULL, NULL, 5, 7, 10, '2024-05-26 08:14:57', '2024-11-17 07:43:17'),
(14, 'Effects', 'effects', NULL, NULL, 6, 5, 12, '2024-09-20 23:55:26', '2024-11-17 07:43:17'),
(15, 'Illustrations', 'illustrations', NULL, NULL, 6, 6, 11, '2024-09-20 23:55:37', '2024-11-17 07:43:17'),
(16, 'Music', 'music', NULL, NULL, 7, 7, 13, '2024-09-20 23:55:54', '2024-11-17 07:43:17'),
(17, 'Sound Effects', 'sound-effects', NULL, NULL, 7, 7, 14, '2024-09-20 23:56:03', '2024-11-17 07:43:17'),
(18, 'PHP Scripts', 'php-scripts', NULL, NULL, 2, 7, 5, '2024-09-27 18:07:32', '2024-11-17 07:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `support_earnings`
--

CREATE TABLE `support_earnings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` bigint UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `tax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` double NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Active 2:Refunded 3:Cancelled',
  `support_expiry_at` datetime NOT NULL,
  `purchase_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_periods`
--

CREATE TABLE `support_periods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` bigint UNSIGNED NOT NULL,
  `percentage` int UNSIGNED NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_periods`
--

INSERT INTO `support_periods` (`id`, `name`, `title`, `days`, `percentage`, `is_default`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, '6 months', '6 months of support', 182, 0, 1, 0, '2024-07-09 13:46:39', '2024-07-09 17:43:11'),
(2, '12 months', '12 months of support', 365, 24, 0, 0, '2024-07-09 13:47:00', '2024-10-30 18:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` int UNSIGNED NOT NULL,
  `countries` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stars` int UNSIGNED NOT NULL DEFAULT '5',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `avatar`, `title`, `body`, `stars`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'John Carter', 'images/sections/testimonials/K7u0gne5rQ7HhA1_1731856080.jpg', 'Web Developer', 'Digibob is a goldmine for web developers like me. The platform\'s extensive collection of PHP scripts and HTML templates has been a lifesaver, saving me time and effort. The quality and variety are unmatched, making Digibob my top choice for digital assets.', 5, 0, '2024-03-05 18:35:15', '2024-11-17 09:08:00'),
(2, 'Emma Carter', 'images/sections/testimonials/RZvN3bUFsQxgwsE_1731856085.jpg', 'Graphic Designer', 'Digibob is a dream come true. The marketplace offers an incredible selection of high-quality graphics from talented designers around the world. The platform is user-friendly and makes finding and purchasing the perfect design quick and easy. It\'s my go-to place for all my graphic needs in the creative industry.', 5, 0, '2024-03-05 18:36:15', '2024-11-17 09:08:05'),
(3, 'Amanda Evans', 'images/sections/testimonials/EGLlIhxV7l47Elr_1731856091.jpg', 'Startup Founder', 'Digibob played a pivotal role in our startup journey. We found crucial PHP scripts on the marketplace, significantly speeding up our development process. The reliability and efficiency of Digibob have been instrumental in our successful launch.', 5, 0, '2024-03-05 18:36:43', '2024-11-17 09:08:11'),
(4, 'Carlos Martinez', 'images/sections/testimonials/UwjJjk5e6zp2eM3_1731856096.jpg', 'E-commerce Entrepreneur', 'Digibob is a hidden gem for e-commerce businesses. The platform\'s rich variety of graphics and templates allowed me to enhance my online store\'s visual appeal. Digibob is now my first choice for sourcing digital assets for my business.', 5, 0, '2024-03-05 18:37:15', '2024-11-17 09:08:16'),
(5, 'Linda Thompson', 'images/sections/testimonials/cDaBMh99jGHvHui_1731856101.jpg', 'Marketing Manager', 'Digibob has become an indispensable tool for our marketing team. The marketplace\'s extensive range of templates and scripts empowered us to elevate our online marketing strategies. Digibob is a must-have resource for any marketing professional navigating the digital landscape.', 5, 0, '2024-03-05 18:37:54', '2024-11-17 09:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `alias`, `version`, `preview_image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'basic', '1.0', 'themes/basic/images/preview.jpg', 'Basic theme offers a sleek and modern design, prioritizing user-friendly navigation and aesthetics. ', '2023-09-29 22:14:13', '2023-09-29 22:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ticket_category_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Opened 2:Closed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_categories`
--

INSERT INTO `ticket_categories` (`id`, `name`, `status`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'Purchases', 1, 0, '2024-05-26 12:45:53', '2024-05-26 12:45:53'),
(2, 'Payments', 1, 0, '2024-05-26 12:46:02', '2024-05-26 12:46:02'),
(3, 'Transactions', 1, 0, '2024-05-26 12:46:08', '2024-05-26 12:46:08'),
(4, 'Refunds', 1, 0, '2024-05-26 12:46:13', '2024-05-26 12:46:13'),
(5, 'Other', 1, 0, '2024-05-26 12:46:20', '2024-05-26 12:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_reply_attachments`
--

CREATE TABLE `ticket_reply_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_reply_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `fees` double DEFAULT '0',
  `tax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` double NOT NULL,
  `payment_gateway_id` bigint UNSIGNED DEFAULT NULL,
  `payment_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('purchase','support_purchase','support_extend','deposit','subscription') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `support` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `purchase_id` bigint UNSIGNED DEFAULT NULL,
  `plan_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:Unpaid 1:Pending 2:Paid 3:Cancelled',
  `cancellation_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `license_type` tinyint NOT NULL DEFAULT '1' COMMENT '1:Regular 2:Extended',
  `price` double NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `total` double(8,2) NOT NULL,
  `support` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translates`
--

CREATE TABLE `translates` (
  `id` bigint UNSIGNED NOT NULL,
  `key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translates`
--

INSERT INTO `translates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'The :attribute field must be accepted.', 'The :attribute field must be accepted.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(2, 'The :attribute field must be accepted when :other is :value.', 'The :attribute field must be accepted when :other is :value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(3, 'The :attribute field must be a valid URL.', 'The :attribute field must be a valid URL.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(4, 'The :attribute field must be a date after :date.', 'The :attribute field must be a date after :date.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(5, 'The :attribute field must be a date after or equal to :date.', 'The :attribute field must be a date after or equal to :date.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(6, 'The :attribute field must only contain letters.', 'The :attribute field must only contain letters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(7, 'The :attribute field must only contain letters, numbers, dashes, and underscores.', 'The :attribute field must only contain letters, numbers, dashes, and underscores.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(8, 'The :attribute field must only contain letters and numbers.', 'The :attribute field must only contain letters and numbers.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(9, 'The :attribute field must be an array.', 'The :attribute field must be an array.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(10, 'The :attribute field must only contain single-byte alphanumeric characters and symbols.', 'The :attribute field must only contain single-byte alphanumeric characters and symbols.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(11, 'The :attribute field must be a date before :date.', 'The :attribute field must be a date before :date.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(12, 'The :attribute field must be a date before or equal to :date.', 'The :attribute field must be a date before or equal to :date.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(13, 'The :attribute field must have between :min and :max items.', 'The :attribute field must have between :min and :max items.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(14, 'The :attribute field must be between :min and :max kilobytes.', 'The :attribute field must be between :min and :max kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(15, 'The :attribute field must be between :min and :max.', 'The :attribute field must be between :min and :max.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(16, 'The :attribute field must be between :min and :max characters.', 'The :attribute field must be between :min and :max characters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(17, 'The :attribute field must be true or false.', 'The :attribute field must be true or false.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(18, 'The :attribute field contains an unauthorized value.', 'The :attribute field contains an unauthorized value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(19, 'The :attribute field confirmation does not match.', 'The :attribute field confirmation does not match.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(20, 'The password is incorrect.', 'The password is incorrect.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(21, 'The :attribute field must be a valid date.', 'The :attribute field must be a valid date.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(22, 'The :attribute field must be a date equal to :date.', 'The :attribute field must be a date equal to :date.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(23, 'The :attribute field must match the format :format.', 'The :attribute field must match the format :format.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(24, 'The :attribute field must have :decimal decimal places.', 'The :attribute field must have :decimal decimal places.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(25, 'The :attribute field must be declined.', 'The :attribute field must be declined.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(26, 'The :attribute field must be declined when :other is :value.', 'The :attribute field must be declined when :other is :value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(27, 'The :attribute field and :other must be different.', 'The :attribute field and :other must be different.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(28, 'The :attribute field must be :digits digits.', 'The :attribute field must be :digits digits.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(29, 'The :attribute field must be between :min and :max digits.', 'The :attribute field must be between :min and :max digits.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(30, 'The :attribute field has invalid image dimensions.', 'The :attribute field has invalid image dimensions.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(31, 'The :attribute field has a duplicate value.', 'The :attribute field has a duplicate value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(32, 'The :attribute field must not end with one of the following: :values.', 'The :attribute field must not end with one of the following: :values.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(33, 'The :attribute field must not start with one of the following: :values.', 'The :attribute field must not start with one of the following: :values.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(34, 'The :attribute field must be a valid email address.', 'The :attribute field must be a valid email address.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(35, 'The :attribute field must be a valid username.', 'The :attribute field must be a valid username.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(36, 'The :attribute field must end with one of the following: :values.', 'The :attribute field must end with one of the following: :values.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(37, 'The selected :attribute is invalid.', 'The selected :attribute is invalid.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(38, 'The :attribute field must be a file.', 'The :attribute field must be a file.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(39, 'The :attribute field must have a value.', 'The :attribute field must have a value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(40, 'The :attribute field must have more than :value items.', 'The :attribute field must have more than :value items.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(41, 'The :attribute field must be greater than :value kilobytes.', 'The :attribute field must be greater than :value kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(42, 'The :attribute field must be greater than :value.', 'The :attribute field must be greater than :value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(43, 'The :attribute field must be greater than :value characters.', 'The :attribute field must be greater than :value characters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(44, 'The :attribute field must have :value items or more.', 'The :attribute field must have :value items or more.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(45, 'The :attribute field must be greater than or equal to :value kilobytes.', 'The :attribute field must be greater than or equal to :value kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(46, 'The :attribute field must be greater than or equal to :value.', 'The :attribute field must be greater than or equal to :value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(47, 'The :attribute field must be greater than or equal to :value characters.', 'The :attribute field must be greater than or equal to :value characters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(48, 'The :attribute field must be an image.', 'The :attribute field must be an image.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(49, 'The :attribute field must exist in :other.', 'The :attribute field must exist in :other.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(50, 'The :attribute field must be an integer.', 'The :attribute field must be an integer.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(51, 'The :attribute field must be a valid IP address.', 'The :attribute field must be a valid IP address.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(52, 'The :attribute field must be a valid IPv4 address.', 'The :attribute field must be a valid IPv4 address.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(53, 'The :attribute field must be a valid IPv6 address.', 'The :attribute field must be a valid IPv6 address.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(54, 'The :attribute field must be a valid JSON string.', 'The :attribute field must be a valid JSON string.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(55, 'The :attribute field must be lowercase.', 'The :attribute field must be lowercase.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(56, 'The :attribute field must have less than :value items.', 'The :attribute field must have less than :value items.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(57, 'The :attribute field must be less than :value kilobytes.', 'The :attribute field must be less than :value kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(58, 'The :attribute field must be less than :value.', 'The :attribute field must be less than :value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(59, 'The :attribute field must be less than :value characters.', 'The :attribute field must be less than :value characters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(60, 'The :attribute field must not have more than :value items.', 'The :attribute field must not have more than :value items.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(61, 'The :attribute field must be less than or equal to :value kilobytes.', 'The :attribute field must be less than or equal to :value kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(62, 'The :attribute field must be less than or equal to :value.', 'The :attribute field must be less than or equal to :value.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(63, 'The :attribute field must be less than or equal to :value characters.', 'The :attribute field must be less than or equal to :value characters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(64, 'The :attribute field must be a valid MAC address.', 'The :attribute field must be a valid MAC address.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(65, 'The :attribute field must not have more than :max items.', 'The :attribute field must not have more than :max items.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(66, 'The :attribute field must not be greater than :max kilobytes.', 'The :attribute field must not be greater than :max kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(67, 'The :attribute field must not be greater than :max.', 'The :attribute field must not be greater than :max.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(68, 'The :attribute field must not be greater than :max characters.', 'The :attribute field must not be greater than :max characters.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(69, 'The :attribute field must not have more than :max digits.', 'The :attribute field must not have more than :max digits.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(70, 'The :attribute field must be a file of type: :values.', 'The :attribute field must be a file of type: :values.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(71, 'The :attribute field must have at least :min items.', 'The :attribute field must have at least :min items.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(72, 'The :attribute field must be at least :min kilobytes.', 'The :attribute field must be at least :min kilobytes.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(73, 'The :attribute field must be at least :min.', 'The :attribute field must be at least :min.', '2024-05-15 19:57:40', '2024-05-15 19:57:40'),
(74, 'The :attribute field must be at least :min characters.', 'The :attribute field must be at least :min characters.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(75, 'The :attribute field must have at least :min digits.', 'The :attribute field must have at least :min digits.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(76, 'The :attribute field must be missing.', 'The :attribute field must be missing.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(77, 'The :attribute field must be missing when :other is :value.', 'The :attribute field must be missing when :other is :value.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(78, 'The :attribute field must be missing unless :other is :value.', 'The :attribute field must be missing unless :other is :value.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(79, 'The :attribute field must be missing when :values is present.', 'The :attribute field must be missing when :values is present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(80, 'The :attribute field must be missing when :values are present.', 'The :attribute field must be missing when :values are present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(81, 'The :attribute field must be a multiple of :value.', 'The :attribute field must be a multiple of :value.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(82, 'The :attribute field format is invalid.', 'The :attribute field format is invalid.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(83, 'The :attribute field must be a number.', 'The :attribute field must be a number.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(84, 'The :attribute field must contain at least one letter.', 'The :attribute field must contain at least one letter.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(85, 'The :attribute field must contain at least one uppercase and one lowercase letter.', 'The :attribute field must contain at least one uppercase and one lowercase letter.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(86, 'The :attribute field must contain at least one number.', 'The :attribute field must contain at least one number.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(87, 'The :attribute field must contain at least one symbol.', 'The :attribute field must contain at least one symbol.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(88, 'The given :attribute has appeared in a data leak. Please choose a different :attribute.', 'The given :attribute has appeared in a data leak. Please choose a different :attribute.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(89, 'The :attribute field must be present.', 'The :attribute field must be present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(90, 'The :attribute field is prohibited.', 'The :attribute field is prohibited.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(91, 'The :attribute field is prohibited when :other is :value.', 'The :attribute field is prohibited when :other is :value.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(92, 'The :attribute field is prohibited unless :other is in :values.', 'The :attribute field is prohibited unless :other is in :values.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(93, 'The :attribute field prohibits :other from being present.', 'The :attribute field prohibits :other from being present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(94, 'The :attribute field is required.', 'The :attribute field is required.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(95, 'The :attribute field must contain entries for: :values.', 'The :attribute field must contain entries for: :values.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(96, 'The :attribute field is required when :other is :value.', 'The :attribute field is required when :other is :value.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(97, 'The :attribute field is required when :other is accepted.', 'The :attribute field is required when :other is accepted.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(98, 'The :attribute field is required unless :other is in :values.', 'The :attribute field is required unless :other is in :values.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(99, 'The :attribute field is required when :values is present.', 'The :attribute field is required when :values is present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(100, 'The :attribute field is required when :values are present.', 'The :attribute field is required when :values are present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(101, 'The :attribute field is required when :values is not present.', 'The :attribute field is required when :values is not present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(102, 'The :attribute field is required when none of :values are present.', 'The :attribute field is required when none of :values are present.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(103, 'The :attribute field must match :other.', 'The :attribute field must match :other.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(104, 'The :attribute field must contain :size items.', 'The :attribute field must contain :size items.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(105, 'The :attribute field must be :size kilobytes.', 'The :attribute field must be :size kilobytes.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(106, 'The :attribute field must be :size.', 'The :attribute field must be :size.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(107, 'The :attribute field must be :size characters.', 'The :attribute field must be :size characters.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(108, 'The :attribute field must start with one of the following: :values.', 'The :attribute field must start with one of the following: :values.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(109, 'The :attribute field must be a string.', 'The :attribute field must be a string.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(110, 'The :attribute field must be a valid timezone.', 'The :attribute field must be a valid timezone.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(111, 'The :attribute has already been taken.', 'The :attribute has already been taken.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(112, 'The :attribute failed to upload.', 'The :attribute failed to upload.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(113, 'The :attribute field must be uppercase.', 'The :attribute field must be uppercase.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(114, 'The :attribute field must be a valid ULID.', 'The :attribute field must be a valid ULID.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(115, 'The :attribute field must be a valid UUID.', 'The :attribute field must be a valid UUID.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(116, 'captcha', 'captcha', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(117, 'terms of service', 'terms of service', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(118, 'Phone number must be a valid 10-digit phone number.', 'Phone number must be a valid 10-digit phone number.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(119, 'The :attribute contains blocked patterns.', 'The :attribute contains blocked patterns.', '2024-05-15 19:57:41', '2024-05-15 19:57:41'),
(120, 'These credentials do not match our records.', 'These credentials do not match our records.', '2024-05-15 19:58:09', '2024-05-16 09:16:16'),
(121, 'The provided password is incorrect.', 'The provided password is incorrect.', '2024-05-15 19:58:09', '2024-05-15 19:58:09'),
(122, 'Too many login attempts. Please try again in :seconds seconds.', 'Too many login attempts. Please try again in :seconds seconds.', '2024-05-15 19:58:09', '2024-05-15 19:58:09'),
(123, 'Your password has been reset!', 'Your password has been reset!', '2024-05-15 19:58:20', '2024-05-15 19:58:20'),
(124, 'We have emailed your password reset link!', 'We have emailed your password reset link!', '2024-05-15 19:58:20', '2024-05-15 19:58:20'),
(125, 'Please wait before retrying.', 'Please wait before retrying.', '2024-05-15 19:58:20', '2024-05-15 19:58:20'),
(126, 'This password reset token is invalid.', 'This password reset token is invalid.', '2024-05-15 19:58:20', '2024-05-15 19:58:20'),
(127, 'We can\'t find a user with that email address.', 'We can\'t find a user with that email address.', '2024-05-15 19:58:20', '2024-05-15 19:58:20'),
(128, 'Previous', 'Previous', '2024-05-15 19:58:30', '2024-05-15 19:58:30'),
(129, 'Next', 'Next', '2024-05-15 19:58:30', '2024-05-15 19:58:30'),
(130, 'Afghanistan', 'Afghanistan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(131, 'Albania', 'Albania', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(132, 'Algeria', 'Algeria', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(133, 'American Samoa', 'American Samoa', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(134, 'Andorra', 'Andorra', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(135, 'Angola', 'Angola', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(136, 'Anguilla', 'Anguilla', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(137, 'Antarctica', 'Antarctica', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(138, 'Antigua and Barbuda', 'Antigua and Barbuda', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(139, 'Argentina', 'Argentina', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(140, 'Armenia', 'Armenia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(141, 'Aruba', 'Aruba', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(142, 'Australia', 'Australia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(143, 'Austria', 'Austria', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(144, 'Azerbaijan', 'Azerbaijan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(145, 'Bahamas', 'Bahamas', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(146, 'Bahrain', 'Bahrain', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(147, 'Bangladesh', 'Bangladesh', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(148, 'Barbados', 'Barbados', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(149, 'Belarus', 'Belarus', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(150, 'Belgium', 'Belgium', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(151, 'Belize', 'Belize', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(152, 'Benin', 'Benin', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(153, 'Bermuda', 'Bermuda', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(154, 'Bhutan', 'Bhutan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(155, 'Bolivia', 'Bolivia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(156, 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(157, 'Botswana', 'Botswana', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(158, 'Bouvet Island', 'Bouvet Island', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(159, 'Brazil', 'Brazil', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(160, 'British Antarctic Territory', 'British Antarctic Territory', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(161, 'British Indian Ocean Territory', 'British Indian Ocean Territory', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(162, 'British Virgin Islands', 'British Virgin Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(163, 'Brunei', 'Brunei', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(164, 'Bulgaria', 'Bulgaria', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(165, 'Burkina Faso', 'Burkina Faso', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(166, 'Burundi', 'Burundi', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(167, 'Cambodia', 'Cambodia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(168, 'Cameroon', 'Cameroon', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(169, 'Canada', 'Canada', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(170, 'Canton and Enderbury Islands', 'Canton and Enderbury Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(171, 'Cape Verde', 'Cape Verde', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(172, 'Cayman Islands', 'Cayman Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(173, 'Central African Republic', 'Central African Republic', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(174, 'Chad', 'Chad', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(175, 'Chile', 'Chile', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(176, 'China', 'China', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(177, 'Christmas Island', 'Christmas Island', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(178, 'Cocos [Keeling] Islands', 'Cocos [Keeling] Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(179, 'Colombia', 'Colombia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(180, 'Comoros', 'Comoros', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(181, 'Congo - Brazzaville', 'Congo - Brazzaville', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(182, 'Congo - Kinshasa', 'Congo - Kinshasa', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(183, 'Cook Islands', 'Cook Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(184, 'Costa Rica', 'Costa Rica', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(185, 'Croatia', 'Croatia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(186, 'Cuba', 'Cuba', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(187, 'Cyprus', 'Cyprus', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(188, 'Czech Republic', 'Czech Republic', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(189, 'Côte d’Ivoire', 'Côte d’Ivoire', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(190, 'Denmark', 'Denmark', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(191, 'Djibouti', 'Djibouti', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(192, 'Dominica', 'Dominica', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(193, 'Dominican Republic', 'Dominican Republic', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(194, 'Dronning Maud Land', 'Dronning Maud Land', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(195, 'East Germany', 'East Germany', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(196, 'Ecuador', 'Ecuador', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(197, 'Egypt', 'Egypt', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(198, 'El Salvador', 'El Salvador', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(199, 'Equatorial Guinea', 'Equatorial Guinea', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(200, 'Eritrea', 'Eritrea', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(201, 'Estonia', 'Estonia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(202, 'Ethiopia', 'Ethiopia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(203, 'Falkland Islands', 'Falkland Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(204, 'Faroe Islands', 'Faroe Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(205, 'Fiji', 'Fiji', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(206, 'Finland', 'Finland', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(207, 'France', 'France', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(208, 'French Guiana', 'French Guiana', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(209, 'French Polynesia', 'French Polynesia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(210, 'French Southern Territories', 'French Southern Territories', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(211, 'French Southern and Antarctic Territories', 'French Southern and Antarctic Territories', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(212, 'Gabon', 'Gabon', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(213, 'Gambia', 'Gambia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(214, 'Georgia', 'Georgia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(215, 'Germany', 'Germany', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(216, 'Ghana', 'Ghana', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(217, 'Gibraltar', 'Gibraltar', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(218, 'Greece', 'Greece', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(219, 'Greenland', 'Greenland', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(220, 'Grenada', 'Grenada', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(221, 'Guadeloupe', 'Guadeloupe', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(222, 'Guam', 'Guam', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(223, 'Guatemala', 'Guatemala', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(224, 'Guernsey', 'Guernsey', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(225, 'Guinea', 'Guinea', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(226, 'Guinea-Bissau', 'Guinea-Bissau', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(227, 'Guyana', 'Guyana', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(228, 'Haiti', 'Haiti', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(229, 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(230, 'Honduras', 'Honduras', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(231, 'Hong Kong SAR China', 'Hong Kong SAR China', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(232, 'Hungary', 'Hungary', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(233, 'Iceland', 'Iceland', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(234, 'India', 'India', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(235, 'Indonesia', 'Indonesia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(236, 'Iran', 'Iran', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(237, 'Iraq', 'Iraq', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(238, 'Ireland', 'Ireland', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(239, 'Isle of Man', 'Isle of Man', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(240, 'Israel', 'Israel', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(241, 'Italy', 'Italy', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(242, 'Jamaica', 'Jamaica', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(243, 'Japan', 'Japan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(244, 'Jersey', 'Jersey', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(245, 'Johnston Island', 'Johnston Island', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(246, 'Jordan', 'Jordan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(247, 'Kazakhstan', 'Kazakhstan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(248, 'Kenya', 'Kenya', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(249, 'Kiribati', 'Kiribati', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(250, 'Kuwait', 'Kuwait', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(251, 'Kyrgyzstan', 'Kyrgyzstan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(252, 'Laos', 'Laos', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(253, 'Latvia', 'Latvia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(254, 'Lebanon', 'Lebanon', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(255, 'Lesotho', 'Lesotho', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(256, 'Liberia', 'Liberia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(257, 'Libya', 'Libya', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(258, 'Liechtenstein', 'Liechtenstein', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(259, 'Lithuania', 'Lithuania', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(260, 'Luxembourg', 'Luxembourg', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(261, 'Macau SAR China', 'Macau SAR China', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(262, 'Macedonia', 'Macedonia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(263, 'Madagascar', 'Madagascar', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(264, 'Malawi', 'Malawi', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(265, 'Malaysia', 'Malaysia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(266, 'Maldives', 'Maldives', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(267, 'Mali', 'Mali', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(268, 'Malta', 'Malta', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(269, 'Marshall Islands', 'Marshall Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(270, 'Martinique', 'Martinique', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(271, 'Mauritania', 'Mauritania', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(272, 'Mauritius', 'Mauritius', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(273, 'Mayotte', 'Mayotte', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(274, 'Metropolitan France', 'Metropolitan France', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(275, 'Mexico', 'Mexico', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(276, 'Micronesia', 'Micronesia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(277, 'Midway Islands', 'Midway Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(278, 'Moldova', 'Moldova', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(279, 'Monaco', 'Monaco', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(280, 'Mongolia', 'Mongolia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(281, 'Montenegro', 'Montenegro', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(282, 'Montserrat', 'Montserrat', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(283, 'Morocco', 'Morocco', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(284, 'Mozambique', 'Mozambique', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(285, 'Myanmar [Burma]', 'Myanmar [Burma]', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(286, 'Namibia', 'Namibia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(287, 'Nauru', 'Nauru', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(288, 'Nepal', 'Nepal', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(289, 'Netherlands', 'Netherlands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(290, 'Netherlands Antilles', 'Netherlands Antilles', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(291, 'Neutral Zone', 'Neutral Zone', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(292, 'New Caledonia', 'New Caledonia', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(293, 'New Zealand', 'New Zealand', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(294, 'Nicaragua', 'Nicaragua', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(295, 'Niger', 'Niger', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(296, 'Nigeria', 'Nigeria', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(297, 'Niue', 'Niue', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(298, 'Norfolk Island', 'Norfolk Island', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(299, 'North Korea', 'North Korea', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(300, 'North Vietnam', 'North Vietnam', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(301, 'Northern Mariana Islands', 'Northern Mariana Islands', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(302, 'Norway', 'Norway', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(303, 'Oman', 'Oman', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(304, 'Pacific Islands Trust Territory', 'Pacific Islands Trust Territory', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(305, 'Pakistan', 'Pakistan', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(306, 'Palau', 'Palau', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(307, 'Palestinian Territories', 'Palestinian Territories', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(308, 'Panama', 'Panama', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(309, 'Panama Canal Zone', 'Panama Canal Zone', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(310, 'Papua New Guinea', 'Papua New Guinea', '2024-05-15 21:16:32', '2024-05-15 21:16:32'),
(311, 'Paraguay', 'Paraguay', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(312, 'People\'s Democratic Republic of Yemen', 'People\'s Democratic Republic of Yemen', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(313, 'Peru', 'Peru', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(314, 'Philippines', 'Philippines', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(315, 'Pitcairn Islands', 'Pitcairn Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(316, 'Poland', 'Poland', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(317, 'Portugal', 'Portugal', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(318, 'Puerto Rico', 'Puerto Rico', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(319, 'Qatar', 'Qatar', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(320, 'Romania', 'Romania', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(321, 'Russia', 'Russia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(322, 'Rwanda', 'Rwanda', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(323, 'Réunion', 'Réunion', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(324, 'Saint Barthélemy', 'Saint Barthélemy', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(325, 'Saint Helena', 'Saint Helena', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(326, 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(327, 'Saint Lucia', 'Saint Lucia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(328, 'Saint Martin', 'Saint Martin', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(329, 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(330, 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(331, 'Samoa', 'Samoa', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(332, 'San Marino', 'San Marino', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(333, 'Saudi Arabia', 'Saudi Arabia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(334, 'Senegal', 'Senegal', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(335, 'Serbia', 'Serbia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(336, 'Serbia and Montenegro', 'Serbia and Montenegro', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(337, 'Seychelles', 'Seychelles', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(338, 'Sierra Leone', 'Sierra Leone', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(339, 'Singapore', 'Singapore', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(340, 'Slovakia', 'Slovakia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(341, 'Slovenia', 'Slovenia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(342, 'Solomon Islands', 'Solomon Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(343, 'Somalia', 'Somalia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(344, 'South Africa', 'South Africa', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(345, 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(346, 'South Korea', 'South Korea', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(347, 'Spain', 'Spain', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(348, 'Sri Lanka', 'Sri Lanka', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(349, 'Sudan', 'Sudan', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(350, 'Suriname', 'Suriname', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(351, 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(352, 'Swaziland', 'Swaziland', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(353, 'Sweden', 'Sweden', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(354, 'Switzerland', 'Switzerland', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(355, 'Syria', 'Syria', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(356, 'São Tomé and Príncipe', 'São Tomé and Príncipe', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(357, 'Taiwan', 'Taiwan', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(358, 'Tajikistan', 'Tajikistan', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(359, 'Tanzania', 'Tanzania', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(360, 'Thailand', 'Thailand', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(361, 'Timor-Leste', 'Timor-Leste', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(362, 'Togo', 'Togo', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(363, 'Tokelau', 'Tokelau', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(364, 'Tonga', 'Tonga', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(365, 'Trinidad and Tobago', 'Trinidad and Tobago', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(366, 'Tunisia', 'Tunisia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(367, 'Turkey', 'Turkey', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(368, 'Turkmenistan', 'Turkmenistan', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(369, 'Turks and Caicos Islands', 'Turks and Caicos Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(370, 'Tuvalu', 'Tuvalu', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(371, 'U.S. Minor Outlying Islands', 'U.S. Minor Outlying Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(372, 'U.S. Miscellaneous Pacific Islands', 'U.S. Miscellaneous Pacific Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(373, 'U.S. Virgin Islands', 'U.S. Virgin Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(374, 'Uganda', 'Uganda', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(375, 'Ukraine', 'Ukraine', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(376, 'Union of Soviet Socialist Republics', 'Union of Soviet Socialist Republics', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(377, 'United Arab Emirates', 'United Arab Emirates', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(378, 'United Kingdom', 'United Kingdom', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(379, 'United States', 'United States', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(380, 'Unknown or Invalid Region', 'Unknown or Invalid Region', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(381, 'Uruguay', 'Uruguay', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(382, 'Uzbekistan', 'Uzbekistan', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(383, 'Vanuatu', 'Vanuatu', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(384, 'Vatican City', 'Vatican City', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(385, 'Venezuela', 'Venezuela', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(386, 'Vietnam', 'Vietnam', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(387, 'Wake Island', 'Wake Island', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(388, 'Wallis and Futuna', 'Wallis and Futuna', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(389, 'Western Sahara', 'Western Sahara', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(390, 'Yemen', 'Yemen', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(391, 'Zambia', 'Zambia', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(392, 'Zimbabwe', 'Zimbabwe', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(393, 'Åland Islands', 'Åland Islands', '2024-05-15 21:16:33', '2024-05-15 21:16:33'),
(394, 'Afar', 'Afar', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(395, 'Abkhazian', 'Abkhazian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(396, 'Avestan', 'Avestan', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(397, 'Afrikaans', 'Afrikaans', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(398, 'Akan', 'Akan', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(399, 'Amharic', 'Amharic', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(400, 'Aragonese', 'Aragonese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(401, 'Arabic', 'Arabic', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(402, 'Assamese', 'Assamese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(403, 'Avaric', 'Avaric', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(404, 'Aymara', 'Aymara', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(405, 'Azerbaijani', 'Azerbaijani', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(406, 'Bashkir', 'Bashkir', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(407, 'Belarusian', 'Belarusian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(408, 'Bulgarian', 'Bulgarian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(409, 'Bihari languages', 'Bihari languages', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(410, 'Bislama', 'Bislama', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(411, 'Bambara', 'Bambara', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(412, 'Bengali', 'Bengali', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(413, 'Tibetan', 'Tibetan', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(414, 'Breton', 'Breton', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(415, 'Bosnian', 'Bosnian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(416, 'Catalan, Valencian', 'Catalan, Valencian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(417, 'Chechen', 'Chechen', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(418, 'Chamorro', 'Chamorro', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(419, 'Corsican', 'Corsican', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(420, 'Cree', 'Cree', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(421, 'Czech', 'Czech', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(422, 'Church Slavonic, Old Bulgarian, Old Church Slavonic', 'Church Slavonic, Old Bulgarian, Old Church Slavonic', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(423, 'Chuvash', 'Chuvash', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(424, 'Welsh', 'Welsh', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(425, 'Danish', 'Danish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(426, 'German', 'German', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(427, 'Divehi, Dhivehi, Maldivian', 'Divehi, Dhivehi, Maldivian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(428, 'Dzongkha', 'Dzongkha', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(429, 'Ewe', 'Ewe', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(430, 'Greek (Modern)', 'Greek (Modern)', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(431, 'English', 'English', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(432, 'Esperanto', 'Esperanto', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(433, 'Spanish, Castilian', 'Spanish, Castilian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(434, 'Estonian', 'Estonian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(435, 'Basque', 'Basque', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(436, 'Persian', 'Persian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(437, 'Fulah', 'Fulah', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(438, 'Finnish', 'Finnish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(439, 'Fijian', 'Fijian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(440, 'Faroese', 'Faroese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(441, 'French', 'French', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(442, 'Western Frisian', 'Western Frisian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(443, 'Irish', 'Irish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(444, 'Gaelic, Scottish Gaelic', 'Gaelic, Scottish Gaelic', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(445, 'Galician', 'Galician', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(446, 'Guarani', 'Guarani', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(447, 'Gujarati', 'Gujarati', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(448, 'Manx', 'Manx', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(449, 'Hausa', 'Hausa', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(450, 'Hebrew', 'Hebrew', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(451, 'Hindi', 'Hindi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(452, 'Hiri Motu', 'Hiri Motu', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(453, 'Croatian', 'Croatian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(454, 'Haitian, Haitian Creole', 'Haitian, Haitian Creole', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(455, 'Hungarian', 'Hungarian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(456, 'Armenian', 'Armenian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(457, 'Herero', 'Herero', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(458, 'Interlingua (International Auxiliary Language Association)', 'Interlingua (International Auxiliary Language Association)', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(459, 'Indonesian', 'Indonesian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(460, 'Interlingue', 'Interlingue', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(461, 'Igbo', 'Igbo', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(462, 'Nuosu, Sichuan Yi', 'Nuosu, Sichuan Yi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(463, 'Inupiaq', 'Inupiaq', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(464, 'Ido', 'Ido', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(465, 'Icelandic', 'Icelandic', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(466, 'Italian', 'Italian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(467, 'Inuktitut', 'Inuktitut', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(468, 'Japanese', 'Japanese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(469, 'Javanese', 'Javanese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(470, 'Georgian', 'Georgian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(471, 'Kongo', 'Kongo', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(472, 'Gikuyu, Kikuyu', 'Gikuyu, Kikuyu', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(473, 'Kwanyama, Kuanyama', 'Kwanyama, Kuanyama', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(474, 'Kazakh', 'Kazakh', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(475, 'Greenlandic, Kalaallisut', 'Greenlandic, Kalaallisut', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(476, 'Central Khmer', 'Central Khmer', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(477, 'Kannada', 'Kannada', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(478, 'Korean', 'Korean', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(479, 'Kanuri', 'Kanuri', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(480, 'Kashmiri', 'Kashmiri', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(481, 'Kurdish', 'Kurdish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(482, 'Komi', 'Komi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(483, 'Cornish', 'Cornish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(484, 'Kyrgyz', 'Kyrgyz', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(485, 'Latin', 'Latin', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(486, 'Letzeburgesch, Luxembourgish', 'Letzeburgesch, Luxembourgish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(487, 'Ganda', 'Ganda', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(488, 'Limburgish, Limburgan, Limburger', 'Limburgish, Limburgan, Limburger', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(489, 'Lingala', 'Lingala', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(490, 'Lao', 'Lao', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(491, 'Lithuanian', 'Lithuanian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(492, 'Luba-Katanga', 'Luba-Katanga', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(493, 'Latvian', 'Latvian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(494, 'Malagasy', 'Malagasy', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(495, 'Marshallese', 'Marshallese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(496, 'Maori', 'Maori', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(497, 'Macedonian', 'Macedonian', '2024-05-15 21:26:45', '2024-05-15 21:26:45');
INSERT INTO `translates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(498, 'Malayalam', 'Malayalam', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(499, 'Mongolian', 'Mongolian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(500, 'Marathi', 'Marathi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(501, 'Malay', 'Malay', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(502, 'Maltese', 'Maltese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(503, 'Burmese', 'Burmese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(504, 'Norwegian Bokmål', 'Norwegian Bokmål', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(505, 'Northern Ndebele', 'Northern Ndebele', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(506, 'Nepali', 'Nepali', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(507, 'Ndonga', 'Ndonga', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(508, 'Dutch, Flemish', 'Dutch, Flemish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(509, 'Norwegian Nynorsk', 'Norwegian Nynorsk', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(510, 'Norwegian', 'Norwegian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(511, 'South Ndebele', 'South Ndebele', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(512, 'Navajo, Navaho', 'Navajo, Navaho', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(513, 'Chichewa, Chewa, Nyanja', 'Chichewa, Chewa, Nyanja', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(514, 'Occitan (post 1500)', 'Occitan (post 1500)', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(515, 'Ojibwa', 'Ojibwa', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(516, 'Oromo', 'Oromo', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(517, 'Oriya', 'Oriya', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(518, 'Ossetian, Ossetic', 'Ossetian, Ossetic', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(519, 'Panjabi, Punjabi', 'Panjabi, Punjabi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(520, 'Pali', 'Pali', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(521, 'Polish', 'Polish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(522, 'Pashto, Pushto', 'Pashto, Pushto', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(523, 'Portuguese', 'Portuguese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(524, 'Quechua', 'Quechua', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(525, 'Romansh', 'Romansh', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(526, 'Rundi', 'Rundi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(527, 'Moldovan, Moldavian, Romanian', 'Moldovan, Moldavian, Romanian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(528, 'Russian', 'Russian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(529, 'Kinyarwanda', 'Kinyarwanda', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(530, 'Sanskrit', 'Sanskrit', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(531, 'Sardinian', 'Sardinian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(532, 'Sindhi', 'Sindhi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(533, 'Northern Sami', 'Northern Sami', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(534, 'Sango', 'Sango', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(535, 'Sinhala, Sinhalese', 'Sinhala, Sinhalese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(536, 'Slovak', 'Slovak', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(537, 'Slovenian', 'Slovenian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(538, 'Samoan', 'Samoan', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(539, 'Shona', 'Shona', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(540, 'Somali', 'Somali', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(541, 'Albanian', 'Albanian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(542, 'Serbian', 'Serbian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(543, 'Swati', 'Swati', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(544, 'Sotho, Southern', 'Sotho, Southern', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(545, 'Sundanese', 'Sundanese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(546, 'Swedish', 'Swedish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(547, 'Swahili', 'Swahili', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(548, 'Tamil', 'Tamil', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(549, 'Telugu', 'Telugu', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(550, 'Tajik', 'Tajik', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(551, 'Thai', 'Thai', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(552, 'Tigrinya', 'Tigrinya', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(553, 'Turkmen', 'Turkmen', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(554, 'Tagalog', 'Tagalog', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(555, 'Tswana', 'Tswana', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(556, 'Tonga (Tonga Islands)', 'Tonga (Tonga Islands)', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(557, 'Turkish', 'Turkish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(558, 'Tsonga', 'Tsonga', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(559, 'Tatar', 'Tatar', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(560, 'Twi', 'Twi', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(561, 'Tahitian', 'Tahitian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(562, 'Uighur, Uyghur', 'Uighur, Uyghur', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(563, 'Ukrainian', 'Ukrainian', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(564, 'Urdu', 'Urdu', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(565, 'Uzbek', 'Uzbek', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(566, 'Venda', 'Venda', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(567, 'Vietnamese', 'Vietnamese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(568, 'Volap_k', 'Volap_k', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(569, 'Walloon', 'Walloon', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(570, 'Wolof', 'Wolof', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(571, 'Xhosa', 'Xhosa', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(572, 'Yiddish', 'Yiddish', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(573, 'Yoruba', 'Yoruba', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(574, 'Zhuang, Chuang', 'Zhuang, Chuang', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(575, 'Chinese', 'Chinese', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(576, 'Zulu', 'Zulu', '2024-05-15 21:26:45', '2024-05-15 21:26:45'),
(577, 'WordPress Templates, Plugins, PHP Scripts And Graphics Digital Marketplace', 'WordPress Templates, Plugins, PHP Scripts And Graphics Digital Marketplace', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(578, 'JavaScript, PHP Scripts, CSS, HTML5, Site Templates, WordPress Themes, Plugins, Mobile Apps, Graphics, Prints, Brochures, Flyers, Resumes, and More...', 'JavaScript, PHP Scripts, CSS, HTML5, Site Templates, WordPress Themes, Plugins, Mobile Apps, Graphics, Prints, Brochures, Flyers, Resumes, and More...', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(579, 'Search...', 'Search...', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(580, 'Search', 'Search', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(581, 'View All', 'View All', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(582, 'Free', 'Free', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(583, ':count Downloads', ':count Downloads', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(584, 'On Sale', 'On Sale', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(585, ':count Sale', ':count Sale', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(586, ':count Sales', ':count Sales', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(587, 'Trending', 'Trending', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(588, 'All Categories', 'All Categories', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(589, 'View More', 'View More', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(590, 'No Items Found', 'No Items Found', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(591, 'View All Featured Items', 'View All Featured Items', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(592, 'Read More...', 'Read More...', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(593, 'Sign In', 'Sign In', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(594, 'Sign Up', 'Sign Up', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(595, 'Subscribe to Our Newsletter', 'Subscribe to Our Newsletter', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(596, 'Stay tuned for the latest and greatest items and offers, delivered right to your inbox!', 'Stay tuned for the latest and greatest items and offers, delivered right to your inbox!', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(597, 'Subscribe', 'Subscribe', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(598, 'Items Sold', 'Items Sold', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(599, 'Sales Amount', 'Sales Amount', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(600, 'All rights reserved', 'All rights reserved', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(601, 'Copied to clipboard', 'Copied to clipboard', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(602, 'Are you sure?', 'Are you sure?', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(603, 'Nothing selected', 'Nothing selected', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(604, 'No results match', 'No results match', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(605, '{0} of {1} selected', '{0} of {1} selected', '2024-09-29 14:46:04', '2024-09-29 14:46:04'),
(606, 'Home', 'Home', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(607, 'Categories', 'Categories', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(608, 'All results for the \":name\" category', 'All results for the \":name\" category', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(609, 'Options', 'Options', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(610, 'Best Selling', 'Best Selling', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(611, 'Featured', 'Featured', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(612, 'Price', 'Price', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(613, 'min', 'min', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(614, 'max', 'max', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(615, 'Rating', 'Rating', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(616, 'Show All', 'Show All', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(617, '5 stars', '5 stars', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(618, '4 stars', '4 stars', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(619, '3 stars', '3 stars', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(620, '2 stars', '2 stars', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(621, '1 star', '1 star', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(622, 'Date Added', 'Date Added', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(623, 'Any time', 'Any time', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(624, 'This month', 'This month', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(625, 'Last month', 'Last month', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(626, 'This year', 'This year', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(627, 'Last year', 'Last year', '2024-09-29 14:46:17', '2024-09-29 14:46:17'),
(628, 'Your search results for the \":name\" category', 'Your search results for the \":name\" category', '2024-09-29 14:46:20', '2024-09-29 14:46:20'),
(629, 'Clear All', 'Clear All', '2024-09-29 14:46:20', '2024-09-29 14:46:20'),
(630, 'Items', 'Items', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(631, 'Live Preview', 'Live Preview', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(632, 'Recently Updated', 'Recently Updated', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(633, 'Description', 'Description', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(634, 'Comments (:count)', 'Comments (:count)', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(635, 'Free Item', 'Free Item', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(636, 'Free items policy', 'Free items policy', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(637, 'This item is available for free download. You may download and use it according to the free item policy.', 'This item is available for free download. You may download and use it according to the free item policy.', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(638, 'Download', 'Download', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(639, 'License certificate', 'License certificate', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(640, 'Last Update', 'Last Update', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(641, 'Published', 'Published', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(642, 'Version', 'Version', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(643, 'v:version', 'v:version', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(644, 'Category', 'Category', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(645, 'Tags', 'Tags', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(646, 'Share', 'Share', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(647, 'Similar items', 'Similar items', '2024-09-29 14:46:21', '2024-09-29 14:46:21'),
(648, 'Comments', 'Comments', '2024-09-29 14:46:23', '2024-09-29 14:46:23'),
(649, 'This item has no comments', 'This item has no comments', '2024-09-29 14:46:23', '2024-09-29 14:46:23'),
(650, ':sign_in to comment', ':sign_in to comment', '2024-09-29 14:46:23', '2024-09-29 14:46:23'),
(651, 'Screenshots', 'Screenshots', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(652, '(:count Review)', '(:count Review)', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(653, 'Changelogs', 'Changelogs', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(654, 'Reviews (:count)', 'Reviews (:count)', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(655, 'Support', 'Support', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(656, 'License Option', 'License Option', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(657, 'Licenses terms', 'Licenses terms', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(658, 'Regular', 'Regular', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(659, 'For one project', 'For one project', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(660, 'Extended', 'Extended', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(661, 'For unlimited projects', 'For unlimited projects', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(662, 'Add to Cart', 'Add to Cart', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(663, 'Buy Now', 'Buy Now', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(664, 'Quality checked by :website_name', 'Quality checked by :website_name', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(665, 'Full Documentation', 'Full Documentation', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(666, 'Future updates', 'Future updates', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(667, '24/7 Support', '24/7 Support', '2024-09-29 14:46:28', '2024-09-29 14:46:28'),
(668, 'Version :version', 'Version :version', '2024-09-29 14:46:37', '2024-09-29 14:46:37'),
(669, 'Reviews', 'Reviews', '2024-09-29 14:46:38', '2024-09-29 14:46:38'),
(670, ':count out of 5 stars', ':count out of 5 stars', '2024-09-29 14:46:38', '2024-09-29 14:46:38'),
(671, 'By :username', 'By :username', '2024-09-29 14:46:38', '2024-09-29 14:46:38'),
(672, 'Admin', 'Admin', '2024-09-29 14:46:40', '2024-09-29 14:46:40'),
(673, 'Purchased', 'Purchased', '2024-09-29 14:46:40', '2024-09-29 14:46:40'),
(674, 'This item is supported by :website_name', 'This item is supported by :website_name', '2024-09-29 14:46:40', '2024-09-29 14:46:40'),
(675, 'Read the support instructions below to know how you can get help.', 'Read the support instructions below to know how you can get help.', '2024-09-29 14:46:40', '2024-09-29 14:46:40'),
(676, 'Supported', 'Supported', '2024-09-29 14:46:40', '2024-09-29 14:46:40'),
(677, 'Support instructions', 'Support instructions', '2024-09-29 14:46:40', '2024-09-29 14:46:40'),
(678, 'Your search results', 'Your search results', '2024-09-29 14:46:44', '2024-09-29 14:46:44'),
(679, 'Enter your account details to sign in', 'Enter your account details to sign in', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(680, 'Email or Username', 'Email or Username', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(681, 'Password', 'Password', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(682, 'Forgot Your Password?', 'Forgot Your Password?', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(683, 'Remember Me', 'Remember Me', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(684, 'Or With', 'Or With', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(685, 'Facebook', 'Facebook', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(686, 'Google', 'Google', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(687, 'Microsoft', 'Microsoft', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(688, 'Vkontakte', 'Vkontakte', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(689, 'Envato', 'Envato', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(690, 'Github', 'Github', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(691, 'You don\'t have an account?', 'You don\'t have an account?', '2024-09-29 14:46:51', '2024-09-29 14:46:51'),
(692, 'Your Cart', 'Your Cart', '2024-09-29 14:46:52', '2024-09-29 14:46:52'),
(693, 'Cart', 'Cart', '2024-09-29 14:46:52', '2024-09-29 14:46:52'),
(694, 'Your Cart is Empty', 'Your Cart is Empty', '2024-09-29 14:46:52', '2024-09-29 14:46:52'),
(695, 'Your cart is currently empty. Start adding items to make your shopping experience complete!', 'Your cart is currently empty. Start adding items to make your shopping experience complete!', '2024-09-29 14:46:52', '2024-09-29 14:46:52'),
(696, 'Browse Items', 'Browse Items', '2024-09-29 14:46:52', '2024-09-29 14:46:52'),
(697, 'The item added to cart', 'The item added to cart', '2024-09-29 14:46:56', '2024-09-29 14:46:56'),
(698, 'Continue browsing', 'Continue browsing', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(699, 'Empty Cart', 'Empty Cart', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(700, 'License Type', 'License Type', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(701, 'Quantity', 'Quantity', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(702, 'Update', 'Update', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(703, 'Your Cart Total', 'Your Cart Total', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(704, 'Checkout', 'Checkout', '2024-09-29 14:46:57', '2024-09-29 14:46:57'),
(705, 'The cart item has been updated', 'The cart item has been updated', '2024-09-29 14:47:01', '2024-09-29 14:47:01'),
(706, 'Reset Password', 'Reset Password', '2024-09-29 14:47:05', '2024-09-29 14:47:05'),
(707, 'You will receive an email with a link to reset your password', 'You will receive an email with a link to reset your password', '2024-09-29 14:47:05', '2024-09-29 14:47:05'),
(708, 'Email address', 'Email address', '2024-09-29 14:47:05', '2024-09-29 14:47:05'),
(709, 'Reset', 'Reset', '2024-09-29 14:47:05', '2024-09-29 14:47:05'),
(710, 'You remembered the password?', 'You remembered the password?', '2024-09-29 14:47:05', '2024-09-29 14:47:05'),
(711, 'Enter your details to create an account.', 'Enter your details to create an account.', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(712, 'First Name', 'First Name', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(713, 'Last Name', 'Last Name', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(714, 'Username', 'Username', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(715, 'Confirm password', 'Confirm password', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(716, 'I agree to the', 'I agree to the', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(717, 'You an account already?', 'You an account already?', '2024-09-29 14:47:09', '2024-09-29 14:47:09'),
(718, 'My Wallet', 'My Wallet', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(719, 'Purchases', 'Purchases', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(720, 'Favorites', 'Favorites', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(721, 'Transactions', 'Transactions', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(722, 'Refunds', 'Refunds', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(723, 'Tickets', 'Tickets', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(724, 'Settings', 'Settings', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(725, 'Logout', 'Logout', '2024-09-29 14:47:18', '2024-09-29 14:47:18'),
(726, 'User', 'User', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(727, 'ID', 'ID', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(728, 'Details', 'Details', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(729, 'Support Expiry Date', 'Support Expiry Date', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(730, 'Purchase Date', 'Purchase Date', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(731, 'Action', 'Action', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(732, 'Write a review', 'Write a review', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(733, 'Purchase code', 'Purchase code', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(734, 'Request a refund', 'Request a refund', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(735, 'Your Purchase Code', 'Your Purchase Code', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(736, 'Buy Support', 'Buy Support', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(737, 'Continue', 'Continue', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(738, 'Extend Support', 'Extend Support', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(739, 'Balance', 'Balance', '2024-09-29 14:47:20', '2024-09-29 14:47:20'),
(740, 'Account details', 'Account details', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(741, 'Choose Avatar', 'Choose Avatar', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(742, 'Address line 1', 'Address line 1', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(743, 'Address line 2', 'Address line 2', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(744, 'City', 'City', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(745, 'State', 'State', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(746, 'Postal code', 'Postal code', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(747, 'Country', 'Country', '2024-09-29 14:47:23', '2024-09-29 14:47:23'),
(748, 'Save Changes', 'Save Changes', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(749, 'Change Password', 'Change Password', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(750, 'New Password', 'New Password', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(751, 'Confirm New Password', 'Confirm New Password', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(752, '2FA Authentication', '2FA Authentication', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(753, 'Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.', 'Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(754, 'Enable 2FA Authentication', 'Enable 2FA Authentication', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(755, 'To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:', 'To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(756, 'Google Authenticator for iOS', 'Google Authenticator for iOS', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(757, 'Google Authenticator for Android', 'Google Authenticator for Android', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(758, 'Microsoft Authenticator for iOS', 'Microsoft Authenticator for iOS', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(759, 'Microsoft Authenticator for Android', 'Microsoft Authenticator for Android', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(760, 'OTP Code', 'OTP Code', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(761, 'Close', 'Close', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(762, 'Enable', 'Enable', '2024-09-29 14:47:24', '2024-09-29 14:47:24'),
(763, 'Opened Tickets', 'Opened Tickets', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(764, 'Closed Tickets', 'Closed Tickets', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(765, 'Status', 'Status', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(766, 'Opened', 'Opened', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(767, 'Closed', 'Closed', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(768, 'Ticket ID', 'Ticket ID', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(769, 'Subject', 'Subject', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(770, 'Created Date', 'Created Date', '2024-09-29 14:47:28', '2024-09-29 14:47:28'),
(771, 'Ticket #:ticket_id', 'Ticket #:ticket_id', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(772, 'Reply', 'Reply', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(773, 'Attachments (:types)', 'Attachments (:types)', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(774, 'Send', 'Send', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(775, 'Last Activity', 'Last Activity', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(776, 'Max :max files can be uploaded', 'Max :max files can be uploaded', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(777, 'Back', 'Back', '2024-09-29 14:47:29', '2024-09-29 14:47:29'),
(778, 'Pending', 'Pending', '2024-09-29 14:47:32', '2024-09-29 14:47:32'),
(779, 'Accepted', 'Accepted', '2024-09-29 14:47:32', '2024-09-29 14:47:32'),
(780, 'Declined', 'Declined', '2024-09-29 14:47:32', '2024-09-29 14:47:32'),
(781, 'Purchased Item', 'Purchased Item', '2024-09-29 14:47:32', '2024-09-29 14:47:32'),
(782, 'Date', 'Date', '2024-09-29 14:47:32', '2024-09-29 14:47:32'),
(783, 'Refund: :item_name', 'Refund: :item_name', '2024-09-29 14:47:33', '2024-09-29 14:47:33'),
(784, 'Refund ID', 'Refund ID', '2024-09-29 14:47:33', '2024-09-29 14:47:33'),
(785, 'Downloaded', 'Downloaded', '2024-09-29 14:47:33', '2024-09-29 14:47:33'),
(786, 'Yes', 'Yes', '2024-09-29 14:47:33', '2024-09-29 14:47:33'),
(787, 'Type', 'Type', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(788, 'Purchase', 'Purchase', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(789, 'Support Purchase', 'Support Purchase', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(790, 'Support Extend', 'Support Extend', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(791, 'Deposit', 'Deposit', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(792, 'Subscription', 'Subscription', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(793, 'Paid', 'Paid', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(794, 'Cancelled', 'Cancelled', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(795, 'SubTotal', 'SubTotal', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(796, 'Tax', 'Tax', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(797, 'Fees', 'Fees', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(798, 'Total', 'Total', '2024-09-29 14:47:34', '2024-09-29 14:47:34'),
(799, 'Invoice #:number', 'Invoice #:number', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(800, 'Transaction ID', 'Transaction ID', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(801, 'Transaction Date', 'Transaction Date', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(802, 'Transaction Status', 'Transaction Status', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(803, 'Transaction Type', 'Transaction Type', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(804, 'Payment Method', 'Payment Method', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(805, 'Regular License', 'Regular License', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(806, ':tax_name (:tax_rate%)', ':tax_name (:tax_rate%)', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(807, 'Invoice', 'Invoice', '2024-09-29 14:47:37', '2024-09-29 14:47:37'),
(808, 'Number', 'Number', '2024-09-29 14:47:38', '2024-09-29 14:47:38'),
(809, 'Billed to', 'Billed to', '2024-09-29 14:47:38', '2024-09-29 14:47:38'),
(810, 'Item', 'Item', '2024-09-29 14:47:39', '2024-09-29 14:47:39'),
(811, '* This transaction was processed by :payment_method', '* This transaction was processed by :payment_method', '2024-09-29 14:47:39', '2024-09-29 14:47:39'),
(812, 'Print', 'Print', '2024-09-29 14:47:39', '2024-09-29 14:47:39'),
(813, 'Available Balance', 'Available Balance', '2024-09-29 14:47:47', '2024-09-29 14:47:47'),
(814, 'Statements', 'Statements', '2024-09-29 14:47:47', '2024-09-29 14:47:47'),
(815, 'Contact US', 'Contact US', '2024-09-29 14:48:02', '2024-09-29 14:48:02'),
(816, 'Name', 'Name', '2024-09-29 14:48:02', '2024-09-29 14:48:02'),
(817, 'Email', 'Email', '2024-09-29 14:48:02', '2024-09-29 14:48:02'),
(818, 'Message', 'Message', '2024-09-29 14:48:02', '2024-09-29 14:48:02'),
(819, 'Users', 'Users', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(820, 'Sales', 'Sales', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(821, 'Dashboard', 'Dashboard', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(822, 'Total Sales (:count)', 'Total Sales (:count)', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(823, 'Support Sales (:count)', 'Support Sales (:count)', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(824, 'Total Items', 'Total Items', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(825, 'Total Sales', 'Total Sales', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(826, 'Total Refunds', 'Total Refunds', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(827, 'Total Users', 'Total Users', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(828, 'Total Transactions', 'Total Transactions', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(829, 'Total Tickets', 'Total Tickets', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(830, 'Users Statistics For This Month', 'Users Statistics For This Month', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(831, 'Recently registered', 'Recently registered', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(832, 'Top Selling Items', 'Top Selling Items', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(833, 'Sales (:count)', 'Sales (:count)', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(834, 'Sales Statistics For This Month', 'Sales Statistics For This Month', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(835, 'Purchasing Countries', 'Purchasing Countries', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(836, 'Top Purchasing Countries', 'Top Purchasing Countries', '2024-09-29 14:48:11', '2024-09-29 14:48:11'),
(837, 'Members', 'Members', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(838, 'Admins', 'Admins', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(839, 'Advertisements', 'Advertisements', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(840, 'Records', 'Records', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(841, 'Support Earnings', 'Support Earnings', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(842, 'KYC', 'KYC', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(843, 'Verifications', 'Verifications', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(844, 'Reports', 'Reports', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(845, 'Item Comments', 'Item Comments', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(846, 'Main Categories', 'Main Categories', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(847, 'Sub Categories', 'Sub Categories', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(848, 'Category Options', 'Category Options', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(849, 'Navigation', 'Navigation', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(850, 'Navbar Links', 'Navbar Links', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(851, 'Footer Links', 'Footer Links', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(852, 'Blog', 'Blog', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(853, 'Articles', 'Articles', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(854, 'Newsletter', 'Newsletter', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(855, 'Subscribers', 'Subscribers', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(856, 'Appearance', 'Appearance', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(857, 'Themes', 'Themes', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(858, 'Financial', 'Financial', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(859, 'Taxes', 'Taxes', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(860, 'Payment Gateways', 'Payment Gateways', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(861, 'General', 'General', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(862, 'Item Settings', 'Item Settings', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(863, 'Ticket Settings', 'Ticket Settings', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(864, 'Support Periods', 'Support Periods', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(865, 'OAuth Providers', 'OAuth Providers', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(866, 'Captcha Providers', 'Captcha Providers', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(867, 'SMTP Settings', 'SMTP Settings', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(868, 'Manage Pages', 'Manage Pages', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(869, 'Extensions', 'Extensions', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(870, 'Language', 'Language', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(871, 'Mail Templates', 'Mail Templates', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(872, 'Sections', 'Sections', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(873, 'Announcement', 'Announcement', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(874, 'Home Sections', 'Home Sections', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(875, 'Home Categories', 'Home Categories', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(876, 'Manage FAQs', 'Manage FAQs', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(877, 'Testimonials', 'Testimonials', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(878, 'System', 'System', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(879, 'Information', 'Information', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(880, 'API', 'API', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(881, 'Maintenance', 'Maintenance', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(882, 'Addons', 'Addons', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(883, 'Admin Style', 'Admin Style', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(884, 'Cron Job', 'Cron Job', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(885, 'License Verification', 'License Verification', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(886, 'Clear Cache', 'Clear Cache', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(887, 'Preview', 'Preview', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(888, 'Notifications', 'Notifications', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(889, 'Mark All as Read', 'Mark All as Read', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(890, 'Account', 'Account', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(891, 'Quick Access', 'Quick Access', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(892, 'General Settings', 'General Settings', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(893, 'All rights reserved.', 'All rights reserved.', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(894, 'Powered by Vironeer', 'Powered by Vironeer', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(895, 'No data available in table', 'No data available in table', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(896, 'Start typing to search...', 'Start typing to search...', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(897, 'Rows per page _MENU_', 'Rows per page _MENU_', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(898, 'Showing page _PAGE_ of _PAGES_', 'Showing page _PAGE_ of _PAGES_', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(899, 'Showing 0 to 0 of 0 entries', 'Showing 0 to 0 of 0 entries', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(900, '(filtered from _MAX_ total entries)', '(filtered from _MAX_ total entries)', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(901, 'No matching records found', 'No matching records found', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(902, 'First', 'First', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(903, 'Last', 'Last', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(904, 'Active', 'Active', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(905, 'Disabled', 'Disabled', '2024-09-29 14:48:12', '2024-09-29 14:48:12'),
(906, 'You can use this tool to verify license codes after receiving them from your buyers.', 'You can use this tool to verify license codes after receiving them from your buyers.', '2024-09-29 14:48:27', '2024-09-29 14:48:27'),
(907, 'Enter purchase code', 'Enter purchase code', '2024-09-29 14:48:27', '2024-09-29 14:48:27'),
(908, 'Verify', 'Verify', '2024-09-29 14:48:27', '2024-09-29 14:48:27'),
(909, 'Not data found', 'Not data found', '2024-09-29 14:48:27', '2024-09-29 14:48:27'),
(910, 'Make All as Read', 'Make All as Read', '2024-09-29 14:48:31', '2024-09-29 14:48:31'),
(911, 'Delete All Read', 'Delete All Read', '2024-09-29 14:48:31', '2024-09-29 14:48:31'),
(912, 'Account settings', 'Account settings', '2024-09-29 14:48:33', '2024-09-29 14:48:33'),
(913, 'Choose Image', 'Choose Image', '2024-09-29 14:48:33', '2024-09-29 14:48:33'),
(914, '2Factor Authentication', '2Factor Authentication', '2024-09-29 14:48:33', '2024-09-29 14:48:33'),
(915, 'From Date', 'From Date', '2024-09-29 14:48:35', '2024-09-29 14:48:35'),
(916, 'To Date', 'To Date', '2024-09-29 14:48:35', '2024-09-29 14:48:35'),
(917, 'Delete', 'Delete', '2024-09-29 14:48:35', '2024-09-29 14:48:35'),
(918, 'View Purchase', 'View Purchase', '2024-09-29 14:48:36', '2024-09-29 14:48:36'),
(919, 'Refund #:refund_id', 'Refund #:refund_id', '2024-09-29 14:48:37', '2024-09-29 14:48:37'),
(920, 'System Information', 'System Information', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(921, 'Application', 'Application', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(922, 'Laravel Version', 'Laravel Version', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(923, 'Timezone', 'Timezone', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(924, 'Server Details', 'Server Details', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(925, 'Software', 'Software', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(926, 'PHP Version', 'PHP Version', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(927, 'IP Address', 'IP Address', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(928, 'Protocol', 'Protocol', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(929, 'HTTP Host', 'HTTP Host', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(930, 'Port', 'Port', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(931, 'System Cache', 'System Cache', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(932, 'Compiled views will be cleared', 'Compiled views will be cleared', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(933, 'Application cache will be cleared', 'Application cache will be cleared', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(934, 'Route cache will be cleared', 'Route cache will be cleared', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(935, 'Configuration cache will be cleared', 'Configuration cache will be cleared', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(936, 'All Other Caches will be cleared', 'All Other Caches will be cleared', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(937, 'Error logs file will be cleared', 'Error logs file will be cleared', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(938, 'Clear System Cache', 'Clear System Cache', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(939, 'info', 'info', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(940, 'Get Help', 'Get Help', '2024-09-29 14:48:41', '2024-09-29 14:48:41'),
(941, 'API Key', 'API Key', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(942, 'Generate', 'Generate', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(943, 'Save', 'Save', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(944, 'Documentation', 'Documentation', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(945, 'Purchase Validation', 'Purchase Validation', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(946, 'Endpoint', 'Endpoint', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(947, 'Parameters', 'Parameters', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(948, 'Your API key', 'Your API key', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(949, 'required', 'required', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(950, 'The purchase code to validate', 'The purchase code to validate', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(951, 'Responses', 'Responses', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(952, 'Success Response:', 'Success Response:', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(953, 'This will be null when its not supported', 'This will be null when its not supported', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(954, 'This will be null when its not exists', 'This will be null when its not exists', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(955, 'Item options here...', 'Item options here...', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(956, 'This is not included for audio items', 'This is not included for audio items', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(957, 'This is only included for video items', 'This is only included for video items', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(958, 'This is only included for audio items', 'This is only included for audio items', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(959, 'This will be null when the item is free', 'This will be null when the item is free', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(960, 'Error Response', 'Error Response', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(961, 'Invalid purchase code', 'Invalid purchase code', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(962, 'Load All Items', 'Load All Items', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(963, 'Success Response', 'Success Response', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(964, 'Load Single Item', 'Load Single Item', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(965, 'The ID of the item to retrieve', 'The ID of the item to retrieve', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(966, 'Item Not Found', 'Item Not Found', '2024-09-29 14:48:43', '2024-09-29 14:48:43'),
(967, 'Maintenance Mode', 'Maintenance Mode', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(968, 'Note!', 'Note!', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(969, 'As an admin, you can still view and control your website but the visitors will redirect to the maintenance page.', 'As an admin, you can still view and control your website but the visitors will redirect to the maintenance page.', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(970, 'Icon', 'Icon', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(971, 'Image', 'Image', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(972, 'Supported (JPEG, JPG, PNG, SVG)', 'Supported (JPEG, JPG, PNG, SVG)', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(973, 'Title', 'Title', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(974, 'Body', 'Body', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(975, 'Pass Code', 'Pass Code', '2024-09-29 14:48:45', '2024-09-29 14:48:45'),
(976, 'Upload', 'Upload', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(977, 'No Data Found', 'No Data Found', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(978, 'It appears that the section is empty or your', 'It appears that the section is empty or your', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(979, 'search did not return any results', 'search did not return any results', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(980, 'Upload an addon', 'Upload an addon', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(981, 'Important!', 'Important!', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(982, 'Make sure you are uploading the correct files.', 'Make sure you are uploading the correct files.', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(983, 'Before uploading a new addon make sure to take a backup of your website files and database.', 'Before uploading a new addon make sure to take a backup of your website files and database.', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(984, 'Addon Purchase Code', 'Addon Purchase Code', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(985, 'Addon Files (Zip)', 'Addon Files (Zip)', '2024-09-29 14:48:47', '2024-09-29 14:48:47'),
(986, 'Admin Panel Style', 'Admin Panel Style', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(987, 'Colors', 'Colors', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(988, 'Primary color', 'Primary color', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(989, 'Secondary color', 'Secondary color', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(990, 'Background color', 'Background color', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(991, 'Sidebar background color', 'Sidebar background color', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(992, 'Navbar background color', 'Navbar background color', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(993, 'Custom CSS', 'Custom CSS', '2024-09-29 14:48:48', '2024-09-29 14:48:48'),
(994, 'Command', 'Command', '2024-09-29 14:48:50', '2024-09-29 14:48:50'),
(995, 'The cron job command must be set to run every minute', 'The cron job command must be set to run every minute', '2024-09-29 14:48:50', '2024-09-29 14:48:50'),
(996, 'Generate Key', 'Generate Key', '2024-09-29 14:48:50', '2024-09-29 14:48:50'),
(997, 'Remove Key', 'Remove Key', '2024-09-29 14:48:50', '2024-09-29 14:48:50'),
(998, 'cronjob', 'cronjob', '2024-09-29 14:48:50', '2024-09-29 14:48:50'),
(999, 'Announcement Body', 'Announcement Body', '2024-09-29 14:48:52', '2024-09-29 14:48:52'),
(1000, 'Button Title', 'Button Title', '2024-09-29 14:48:52', '2024-09-29 14:48:52'),
(1001, 'Button Link', 'Button Link', '2024-09-29 14:48:52', '2024-09-29 14:48:52'),
(1002, 'Announcement Background Color', 'Announcement Background Color', '2024-09-29 14:48:52', '2024-09-29 14:48:52'),
(1003, 'Button Background Color', 'Button Background Color', '2024-09-29 14:48:52', '2024-09-29 14:48:52'),
(1004, 'Button Text Color', 'Button Text Color', '2024-09-29 14:48:52', '2024-09-29 14:48:52'),
(1005, 'Faqs', 'Faqs', '2024-09-29 14:48:56', '2024-09-29 14:48:56'),
(1006, 'General Details', 'General Details', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1007, 'Site Name', 'Site Name', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1008, 'Site URL', 'Site URL', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1009, 'Contact Email', 'Contact Email', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1010, 'This email is required to receive emails from contact page', 'This email is required to receive emails from contact page', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1011, 'Date format', 'Date format', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1012, 'Social Media Links', 'Social Media Links', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1013, 'X', 'X', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1014, 'Youtube', 'Youtube', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1015, 'Linkedin', 'Linkedin', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1016, 'Instagram', 'Instagram', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1017, 'Pinterest', 'Pinterest', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1018, 'Links', 'Links', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1019, 'Terms of use link', 'Terms of use link', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1020, 'Licenses terms link', 'Licenses terms link', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1021, 'SEO', 'SEO', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1022, 'Home title', 'Home title', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1023, 'Title must be within 70 Characters', 'Title must be within 70 Characters', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1024, 'Description must be within 150 Characters', 'Description must be within 150 Characters', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1025, 'Site keywords', 'Site keywords', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1026, 'keyword1, keyword2, keyword3', 'keyword1, keyword2, keyword3', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1027, 'Actions', 'Actions', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1028, 'Registration', 'Registration', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1029, 'Email verification', 'Email verification', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1030, 'Gdpr cookie', 'Gdpr cookie', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1031, 'Force ssl', 'Force ssl', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1032, 'Contact page', 'Contact page', '2024-09-29 14:48:59', '2024-09-29 14:48:59'),
(1033, 'Edit', 'Edit', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1034, 'KYC Verification Approved', 'KYC Verification Approved', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1035, 'KYC Verification Rejected', 'KYC Verification Rejected', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1036, 'New Ticket', 'New Ticket', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1037, 'New Ticket Reply', 'New Ticket Reply', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1038, 'Buyer Item Update', 'Buyer Item Update', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1039, 'Subscriber New Item', 'Subscriber New Item', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1040, 'Payment Confirmation', 'Payment Confirmation', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1041, 'Purchase Confirmation', 'Purchase Confirmation', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1042, 'Transaction Cancelled', 'Transaction Cancelled', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1043, 'Item Comment Reply', 'Item Comment Reply', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1044, 'Refund Request New Reply', 'Refund Request New Reply', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1045, 'Refund Request Accepted', 'Refund Request Accepted', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1046, 'Refund Request Declined', 'Refund Request Declined', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1047, 'Admin KYC Pending', 'Admin KYC Pending', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1048, 'Admin Transaction Pending', 'Admin Transaction Pending', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1049, 'Admin New Ticket', 'Admin New Ticket', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1050, 'Admin New Ticket Reply', 'Admin New Ticket Reply', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1051, 'Admin Item Comment ', 'Admin Item Comment ', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1052, 'Admin Item Comment Reply', 'Admin Item Comment Reply', '2024-09-29 14:49:01', '2024-09-29 14:49:01');
INSERT INTO `translates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1053, 'Admin Item Review ', 'Admin Item Review ', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1054, 'Admin Refund Request', 'Admin Refund Request', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1055, 'Admin Refund Request Reply', 'Admin Refund Request Reply', '2024-09-29 14:49:01', '2024-09-29 14:49:01'),
(1056, 'Direction', 'Direction', '2024-09-29 14:49:04', '2024-09-29 14:49:04'),
(1057, 'LTR', 'LTR', '2024-09-29 14:49:04', '2024-09-29 14:49:04'),
(1058, 'RTL', 'RTL', '2024-09-29 14:49:04', '2024-09-29 14:49:04'),
(1059, 'View Translates', 'View Translates', '2024-09-29 14:49:04', '2024-09-29 14:49:04'),
(1060, 'Logo', 'Logo', '2024-09-29 14:49:05', '2024-09-29 14:49:05'),
(1061, 'Google Analytics 4', 'Google Analytics 4', '2024-09-29 14:49:05', '2024-09-29 14:49:05'),
(1062, 'Tawk.to', 'Tawk.to', '2024-09-29 14:49:05', '2024-09-29 14:49:05'),
(1063, 'Imgur', 'Imgur', '2024-09-29 14:49:05', '2024-09-29 14:49:05'),
(1064, 'Enabled', 'Enabled', '2024-09-29 14:49:05', '2024-09-29 14:49:05'),
(1065, 'Trustip', 'Trustip', '2024-09-29 14:49:05', '2024-09-29 14:49:05'),
(1066, 'Pages', 'Pages', '2024-09-29 14:49:07', '2024-09-29 14:49:07'),
(1067, 'Page Name', 'Page Name', '2024-09-29 14:49:07', '2024-09-29 14:49:07'),
(1068, 'Views', 'Views', '2024-09-29 14:49:07', '2024-09-29 14:49:07'),
(1069, 'SMTP', 'SMTP', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1070, 'SMTP details', 'SMTP details', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1071, 'Mail mailer', 'Mail mailer', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1072, 'SENDMAIL', 'SENDMAIL', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1073, 'Mail Host', 'Mail Host', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1074, 'Enter mail host', 'Enter mail host', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1075, 'Mail Port', 'Mail Port', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1076, 'Enter mail port', 'Enter mail port', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1077, 'Mail username', 'Mail username', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1078, 'Enter username', 'Enter username', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1079, 'Mail password', 'Mail password', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1080, 'Enter password', 'Enter password', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1081, 'Mail encryption', 'Mail encryption', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1082, 'TLS', 'TLS', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1083, 'SSL', 'SSL', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1084, 'From email', 'From email', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1085, 'Enter from email', 'Enter from email', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1086, 'From name', 'From name', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1087, 'Enter from name', 'Enter from name', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1088, 'Testing', 'Testing', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1089, 'E-mail Address', 'E-mail Address', '2024-09-29 14:49:09', '2024-09-29 14:49:09'),
(1090, 'Google reCAPTCHA', 'Google reCAPTCHA', '2024-09-29 14:49:10', '2024-09-29 14:49:10'),
(1091, '(Default)', '(Default)', '2024-09-29 14:49:10', '2024-09-29 14:49:10'),
(1092, 'hCaptcha', 'hCaptcha', '2024-09-29 14:49:10', '2024-09-29 14:49:10'),
(1093, 'Make default', 'Make default', '2024-09-29 14:49:10', '2024-09-29 14:49:10'),
(1094, 'Cloudflare Turnstile', 'Cloudflare Turnstile', '2024-09-29 14:49:10', '2024-09-29 14:49:10'),
(1095, 'Allowed file types', 'Allowed file types', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1096, 'Enter the file extension', 'Enter the file extension', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1097, 'Max upload files', 'Max upload files', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1098, 'Max size per file', 'Max size per file', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1099, 'MB', 'MB', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1100, 'ticket', 'ticket', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1101, 'Show free item total downloads', 'Show free item total downloads', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1102, 'No', 'No', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1103, 'Item Changelogs', 'Item Changelogs', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1104, 'Disable', 'Disable', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1105, 'Item Reviews', 'Item Reviews', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1106, 'Item Support', 'Item Support', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1107, 'Buy Now Button', 'Buy Now Button', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1108, 'Trending And Best selling', 'Trending And Best selling', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1109, 'Trending Items Number', 'Trending Items Number', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1110, 'Best Selling Items Number', 'Best Selling Items Number', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1111, 'You must setup the cron job to refresh the Items every 24 hours.', 'You must setup the cron job to refresh the Items every 24 hours.', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1112, 'Setup Cron Job', 'Setup Cron Job', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1113, 'Files', 'Files', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1114, 'File Duration', 'File Duration', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1115, 'Hours', 'Hours', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1116, 'Uploaded files will expire after this time if you did not use them.', 'Uploaded files will expire after this time if you did not use them.', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1117, 'Convert Images To WEBP', 'Convert Images To WEBP', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1118, 'Convert uploaded images to WEBP like Preview Image, Screenshots, etc...', 'Convert uploaded images to WEBP like Preview Image, Screenshots, etc...', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1119, 'Files Storage', 'Files Storage', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1120, 'Storage Provider', 'Storage Provider', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1121, 'When you change the storage provider, you must move all files form those paths to new storage provider.', 'When you change the storage provider, you must move all files form those paths to new storage provider.', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1122, 'Local', 'Local', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1123, 's3 and others', 's3 and others', '2024-09-29 14:49:15', '2024-09-29 14:49:15'),
(1124, 'Financial settings', 'Financial settings', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1125, 'Currency', 'Currency', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1126, 'Currency Code', 'Currency Code', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1127, 'USD', 'USD', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1128, 'Currency Symbol', 'Currency Symbol', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1129, 'Currency position', 'Currency position', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1130, 'Before price', 'Before price', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1131, 'After price', 'After price', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1132, 'Minimum Deposit Amount', 'Minimum Deposit Amount', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1133, 'Maximum Deposit Amount', 'Maximum Deposit Amount', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1134, 'Rate', 'Rate', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1135, 'Countries', 'Countries', '2024-09-29 14:49:18', '2024-09-29 14:49:18'),
(1136, ':count Countries', ':count Countries', '2024-09-29 14:49:19', '2024-09-29 14:49:19'),
(1137, 'Make Active', 'Make Active', '2024-09-29 14:49:22', '2024-09-29 14:49:22'),
(1138, 'Upload a theme', 'Upload a theme', '2024-09-29 14:49:22', '2024-09-29 14:49:22'),
(1139, 'Before uploading a new theme make sure to take a backup of your website files and database.', 'Before uploading a new theme make sure to take a backup of your website files and database.', '2024-09-29 14:49:22', '2024-09-29 14:49:22'),
(1140, 'Theme Purchase Code', 'Theme Purchase Code', '2024-09-29 14:49:22', '2024-09-29 14:49:22'),
(1141, 'Theme Files (Zip)', 'Theme Files (Zip)', '2024-09-29 14:49:22', '2024-09-29 14:49:22'),
(1142, ':theme_name Theme Settings', ':theme_name Theme Settings', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1143, 'home page', 'home page', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1144, 'footer', 'footer', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1145, 'extra codes', 'extra codes', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1146, 'Logo dark', 'Logo dark', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1147, 'Allowed types (JPG,JPEG,PNG,SVG,WEBP)', 'Allowed types (JPG,JPEG,PNG,SVG,WEBP)', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1148, 'Logo light', 'Logo light', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1149, 'Favicon', 'Favicon', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1150, 'Allowed types (JPG,JPEG,PNG,ICO)', 'Allowed types (JPG,JPEG,PNG,ICO)', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1151, 'Brand Icon', 'Brand Icon', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1152, 'Allowed types (JPG,JPEG,PNG)', 'Allowed types (JPG,JPEG,PNG)', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1153, 'Social Image', 'Social Image', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1154, 'Allowed types (JPG,JPEG)', 'Allowed types (JPG,JPEG)', '2024-09-29 14:49:24', '2024-09-29 14:49:24'),
(1155, 'Newsletter Settings', 'Newsletter Settings', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1156, 'Newsletter Status', 'Newsletter Status', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1157, 'Show Popup', 'Show Popup', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1158, 'Show Form In Footer', 'Show Form In Footer', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1159, 'Register New Users', 'Register New Users', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1160, 'Popup', 'Popup', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1161, 'PopUp Image', 'PopUp Image', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1162, 'Supported (JPEG, JPG, PNG, WEBP) Size (1200x800px)', 'Supported (JPEG, JPG, PNG, WEBP) Size (1200x800px)', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1163, 'PopUp Reminder After', 'PopUp Reminder After', '2024-09-29 14:49:26', '2024-09-29 14:49:26'),
(1164, 'Newsletter Subscribers', 'Newsletter Subscribers', '2024-09-29 14:49:27', '2024-09-29 14:49:27'),
(1165, 'Send Mail All Subscribers', 'Send Mail All Subscribers', '2024-09-29 14:49:27', '2024-09-29 14:49:27'),
(1166, 'Reply to', 'Reply to', '2024-09-29 14:49:27', '2024-09-29 14:49:27'),
(1167, 'Send Mail', 'Send Mail', '2024-09-29 14:49:27', '2024-09-29 14:49:27'),
(1168, 'Export All', 'Export All', '2024-09-29 14:49:27', '2024-09-29 14:49:27'),
(1169, 'Blog Articles', 'Blog Articles', '2024-09-29 14:49:28', '2024-09-29 14:49:28'),
(1170, 'Article', 'Article', '2024-09-29 14:49:28', '2024-09-29 14:49:28'),
(1171, 'Published date', 'Published date', '2024-09-29 14:49:28', '2024-09-29 14:49:28'),
(1172, 'View', 'View', '2024-09-29 14:49:28', '2024-09-29 14:49:28'),
(1173, 'Blog Categories', 'Blog Categories', '2024-09-29 14:49:30', '2024-09-29 14:49:30'),
(1174, 'Blog Comments', 'Blog Comments', '2024-09-29 14:49:30', '2024-09-29 14:49:30'),
(1175, 'Posted by', 'Posted by', '2024-09-29 14:49:30', '2024-09-29 14:49:30'),
(1176, 'Posted date', 'Posted date', '2024-09-29 14:49:30', '2024-09-29 14:49:30'),
(1177, 'View Comment', 'View Comment', '2024-09-29 14:49:30', '2024-09-29 14:49:30'),
(1178, 'Publish', 'Publish', '2024-09-29 14:49:30', '2024-09-29 14:49:30'),
(1179, 'Ticket Categories', 'Ticket Categories', '2024-09-29 14:49:35', '2024-09-29 14:49:35'),
(1180, 'Main Category', 'Main Category', '2024-09-29 14:49:38', '2024-09-29 14:49:38'),
(1181, 'Option Name', 'Option Name', '2024-09-29 14:49:39', '2024-09-29 14:49:39'),
(1182, 'Reported Item Comments', 'Reported Item Comments', '2024-09-29 14:49:40', '2024-09-29 14:49:40'),
(1183, 'KYC Settings', 'KYC Settings', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1184, 'When KYC is required the user will not be able to buy or sell items until finish the KYC verification.', 'When KYC is required the user will not be able to buy or sell items until finish the KYC verification.', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1185, 'Kyc Status', 'Kyc Status', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1186, 'Selfie Verification', 'Selfie Verification', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1187, 'Avatars', 'Avatars', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1188, 'Choose ID Front Image', 'Choose ID Front Image', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1189, 'Choose ID Back Image', 'Choose ID Back Image', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1190, 'Choose ID Passport Image', 'Choose ID Passport Image', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1191, 'Choose Selfie Image', 'Choose Selfie Image', '2024-09-29 14:49:41', '2024-09-29 14:49:41'),
(1192, 'KYC Verifications', 'KYC Verifications', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1193, 'Approved', 'Approved', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1194, 'Rejected', 'Rejected', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1195, 'Document Type', 'Document Type', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1196, 'National ID', 'National ID', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1197, 'Passport', 'Passport', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1198, 'User details', 'User details', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1199, 'Document Number', 'Document Number', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1200, 'Submited Date', 'Submited Date', '2024-09-29 14:49:42', '2024-09-29 14:49:42'),
(1201, 'Refunded', 'Refunded', '2024-09-29 14:49:44', '2024-09-29 14:49:44'),
(1202, 'Buyer', 'Buyer', '2024-09-29 14:49:44', '2024-09-29 14:49:44'),
(1203, 'View Sale', 'View Sale', '2024-09-29 14:49:45', '2024-09-29 14:49:45'),
(1204, 'Statments', 'Statments', '2024-09-29 14:49:46', '2024-09-29 14:49:46'),
(1205, 'Total Cedited', 'Total Cedited', '2024-09-29 14:49:46', '2024-09-29 14:49:46'),
(1206, 'Total Debited', 'Total Debited', '2024-09-29 14:49:46', '2024-09-29 14:49:46'),
(1207, 'Amount', 'Amount', '2024-09-29 14:49:46', '2024-09-29 14:49:46'),
(1208, 'View User', 'View User', '2024-09-29 14:49:46', '2024-09-29 14:49:46'),
(1209, 'Position', 'Position', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1210, 'Size', 'Size', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1211, 'Head Code', 'Head Code', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1212, 'Home Page (Top)', 'Home Page (Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1213, 'Home Page (Center)', 'Home Page (Center)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1214, 'Home Page (Bottom)', 'Home Page (Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1215, 'Item Page (Top)', 'Item Page (Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1216, 'Item Page (Sidebar)', 'Item Page (Sidebar)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1217, 'Item Page (Description Top)', 'Item Page (Description Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1218, 'Item Page (Description Bottom)', 'Item Page (Description Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1219, 'Item Page (Bottom)', 'Item Page (Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1220, 'Category Page (Top)', 'Category Page (Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1221, 'Category Page (Bottom)', 'Category Page (Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1222, 'Search Page (Top)', 'Search Page (Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1223, 'Search Page (Bottom)', 'Search Page (Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1224, 'Blog Page (Top)', 'Blog Page (Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1225, 'Blog Page (Bottom)', 'Blog Page (Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1226, 'Blog Article Page (Top)', 'Blog Article Page (Top)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1227, 'Blog Article Page (Bottom)', 'Blog Article Page (Bottom)', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1228, 'ads', 'ads', '2024-09-29 14:49:47', '2024-09-29 14:49:47'),
(1229, 'Videos', 'Videos', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1230, 'Audios', 'Audios', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1231, 'Others', 'Others', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1232, 'Licenses Price', 'Licenses Price', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1233, 'Edit Details', 'Edit Details', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1234, 'View Item', 'View Item', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1235, 'Make Featured', 'Make Featured', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1236, 'Remove Featured', 'Remove Featured', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1237, 'New Item', 'New Item', '2024-09-29 14:49:50', '2024-09-29 14:49:50'),
(1238, 'Banned', 'Banned', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1239, 'KYC Verified', 'KYC Verified', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1240, 'KYC Unverified', 'KYC Unverified', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1241, 'Email Verified', 'Email Verified', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1242, 'Email Unverified', 'Email Unverified', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1243, 'Account Status', 'Account Status', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1244, 'Verified', 'Verified', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1245, 'Unverified', 'Unverified', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1246, 'Email Status', 'Email Status', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1247, 'Registred date', 'Registred date', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1248, 'View Details', 'View Details', '2024-09-29 14:49:52', '2024-09-29 14:49:52'),
(1249, ':name Account details', ':name Account details', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1250, 'Total Spend', 'Total Spend', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1251, 'Quick Actions', 'Quick Actions', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1252, 'Open a Ticket', 'Open a Ticket', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1253, 'Wallet', 'Wallet', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1254, 'Login Logs', 'Login Logs', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1255, 'Send Email', 'Send Email', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1256, 'Send Mail to :email', 'Send Mail to :email', '2024-09-29 14:49:55', '2024-09-29 14:49:55'),
(1257, ':name Account balance', ':name Account balance', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1258, 'Account balance', 'Account balance', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1259, 'Current balance', 'Current balance', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1260, 'View Statements', 'View Statements', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1261, 'Credit or Debit the balance', 'Credit or Debit the balance', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1262, 'Credit', 'Credit', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1263, 'Debit', 'Debit', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1264, 'Submit', 'Submit', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1265, ':name Password', ':name Password', '2024-09-29 14:49:58', '2024-09-29 14:49:58'),
(1266, ':name Actions', ':name Actions', '2024-09-29 14:49:59', '2024-09-29 14:49:59'),
(1267, 'Two-Factor Authentication', 'Two-Factor Authentication', '2024-09-29 14:49:59', '2024-09-29 14:49:59'),
(1268, ':name Login logs', ':name Login logs', '2024-09-29 14:50:00', '2024-09-29 14:50:00'),
(1269, 'IP', 'IP', '2024-09-29 14:50:00', '2024-09-29 14:50:00'),
(1270, 'Location', 'Location', '2024-09-29 14:50:00', '2024-09-29 14:50:00'),
(1271, 'Browser', 'Browser', '2024-09-29 14:50:00', '2024-09-29 14:50:00'),
(1272, 'OS', 'OS', '2024-09-29 14:50:00', '2024-09-29 14:50:00'),
(1273, 'Discount', 'Discount', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1274, 'Statistics', 'Statistics', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1275, 'Name And Description', 'Name And Description', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1276, 'Slug', 'Slug', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1277, 'Category And Attributes', 'Category And Attributes', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1278, 'SubCategory (Optional)', 'SubCategory (Optional)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1279, 'Version (Optional)', 'Version (Optional)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1280, '1.0 or 1.0.0', '1.0 or 1.0.0', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1281, 'Demo Link (Optional)', 'Demo Link (Optional)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1282, 'Embed', 'Embed', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1283, 'Direct', 'Direct', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1284, 'Drop files here to upload', 'Drop files here to upload', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1285, 'Drag and drop or click here to upload. All file types are allowed, with no maximum size.', 'Drag and drop or click here to upload. All file types are allowed, with no maximum size.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1286, 'Thumbnail', 'Thumbnail', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1287, 'Thumbnail (.JPG or .PNG)', 'Thumbnail (.JPG or .PNG)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1288, 'Preview Image', 'Preview Image', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1289, 'Preview image (.JPG or .PNG)', 'Preview image (.JPG or .PNG)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1290, 'Main File', 'Main File', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1291, 'External', 'External', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1292, 'Upload the item files that will buyers download', 'Upload the item files that will buyers download', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1293, 'Enter the external URL where the buyer will be redirected to download the file.', 'Enter the external URL where the buyer will be redirected to download the file.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1294, 'Screenshots (Optional)', 'Screenshots (Optional)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1295, 'Item screenshots images (.JPG or .PNG)', 'Item screenshots images (.JPG or .PNG)', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1296, 'file is too big max file size: {{maxFilesize}}MiB.', 'file is too big max file size: {{maxFilesize}}MiB.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1297, 'Server responded with {{statusCode}} code.', 'Server responded with {{statusCode}} code.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1298, 'Your browser does not support drag and drop file uploads.', 'Your browser does not support drag and drop file uploads.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1299, 'Please use the fallback form below to upload your files like in the olden days.', 'Please use the fallback form below to upload your files like in the olden days.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1300, 'You cannot upload files of this type.', 'You cannot upload files of this type.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1301, 'Cancel upload', 'Cancel upload', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1302, 'Are you sure you want to cancel this upload?', 'Are you sure you want to cancel this upload?', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1303, 'Remove file', 'Remove file', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1304, 'You can not upload any more files.', 'You can not upload any more files.', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1305, 'B', 'B', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1306, 'KB', 'KB', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1307, 'GB', 'GB', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1308, 'TB', 'TB', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1309, 'You cannot attach the same file twice', 'You cannot attach the same file twice', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1310, 'Empty files cannot be uploaded', 'Empty files cannot be uploaded', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1311, 'Item will be supported?', 'Item will be supported?', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1312, 'Instructions', 'Instructions', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1313, 'Enter the instructions that the buyer should follow to get support. ', 'Enter the instructions that the buyer should follow to get support. ', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1314, 'Regular License Price', 'Regular License Price', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1315, 'Extended License Price', 'Extended License Price', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1316, 'Send update notification to the buyers', 'Send update notification to the buyers', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1317, 'Item details', 'Item details', '2024-09-29 14:50:41', '2024-09-29 14:50:41'),
(1318, 'New Log', 'New Log', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1319, 'Regular License discount', 'Regular License discount', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1320, 'The maximum discount percentage is 90%', 'The maximum discount percentage is 90%', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1321, 'Discount Percentage', 'Discount Percentage', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1322, 'Purchase price', 'Purchase price', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1323, 'Extended License discount (Optional)', 'Extended License discount (Optional)', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1324, 'Discount Period', 'Discount Period', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1325, 'The starting date cannot be in the past', 'The starting date cannot be in the past', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1326, 'to', 'to', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1327, 'Create a discount', 'Create a discount', '2024-09-29 14:50:43', '2024-09-29 14:50:43'),
(1328, 'Review', 'Review', '2024-09-29 14:50:44', '2024-09-29 14:50:44'),
(1329, 'Comment', 'Comment', '2024-09-29 14:50:44', '2024-09-29 14:50:44'),
(1330, 'Total Sales Amount', 'Total Sales Amount', '2024-09-29 14:50:45', '2024-09-29 14:50:45'),
(1331, 'Total Views', 'Total Views', '2024-09-29 14:50:45', '2024-09-29 14:50:45'),
(1332, 'Sales Statistics', 'Sales Statistics', '2024-09-29 14:50:45', '2024-09-29 14:50:45'),
(1333, 'Views Statistics', 'Views Statistics', '2024-09-29 14:50:45', '2024-09-29 14:50:45'),
(1334, 'Top Referrals', 'Top Referrals', '2024-09-29 14:50:45', '2024-09-29 14:50:45'),
(1335, ':language_name Translates', ':language_name Translates', '2024-09-29 14:51:07', '2024-09-29 14:51:07'),
(1336, 'There are some words that should not be translated that start with some tags or are inside a tag :words etc...', 'There are some words that should not be translated that start with some tags or are inside a tag :words etc...', '2024-09-29 14:51:07', '2024-09-29 14:51:07'),
(1337, 'You must clear the cache after saving the translations.', 'You must clear the cache after saving the translations.', '2024-09-29 14:51:07', '2024-09-29 14:51:07'),
(1338, 'translates', 'translates', '2024-09-29 14:51:07', '2024-09-29 14:51:07'),
(1339, 'Deleted Successfully', 'Deleted Successfully', '2024-09-29 14:53:28', '2024-09-29 14:53:28'),
(1340, 'All notifications marked as read', 'All notifications marked as read', '2024-09-29 14:53:36', '2024-09-29 14:53:36'),
(1341, 'Read notifications deleted successfully', 'Read notifications deleted successfully', '2024-09-29 14:53:38', '2024-09-29 14:53:38'),
(1342, 'No notifications found', 'No notifications found', '2024-09-29 14:53:38', '2024-09-29 14:53:38'),
(1343, 'Edit Advertisement', 'Edit Advertisement', '2024-09-29 14:54:57', '2024-09-29 14:54:57'),
(1344, 'Premium Color', 'Premium Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1345, 'Inner Background Color', 'Inner Background Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1346, 'Elements Background Color', 'Elements Background Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1347, 'Elements Inner Background Color', 'Elements Inner Background Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1348, 'Trending Item Badge Color', 'Trending Item Badge Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1349, 'Sale Item Badge Color', 'Sale Item Badge Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1350, 'Free Item Badge Color', 'Free Item Badge Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1351, 'Premium Item Badge Color', 'Premium Item Badge Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1352, 'Text Color', 'Text Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1353, 'Text Muted', 'Text Muted', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1354, 'Text Green', 'Text Green', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1355, 'Border Color', 'Border Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1356, 'Item Preview Navbar Background', 'Item Preview Navbar Background', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1357, 'Footer Background Color', 'Footer Background Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1358, 'Footer Heading Color', 'Footer Heading Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1359, 'Footer Border Color', 'Footer Border Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1360, 'Footer Text Color', 'Footer Text Color', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1361, 'Choose Header Background', 'Choose Header Background', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1362, 'Supported (JPEG, JPG, PNG, SVG, WEBP) Size 1920x700px.', 'Supported (JPEG, JPG, PNG, SVG, WEBP) Size 1920x700px.', '2024-09-29 14:55:13', '2024-09-29 14:55:13'),
(1363, 'Header Background', 'Header Background', '2024-09-29 14:55:14', '2024-09-29 14:55:14'),
(1364, 'Supported (SVG) Size 1780x250.', 'Supported (SVG) Size 1780x250.', '2024-09-29 14:55:14', '2024-09-29 14:55:14'),
(1365, 'Footer About', 'Footer About', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1366, 'Hide', 'Hide', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1367, 'Show', 'Show', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1368, 'Footer Payment Methods', 'Footer Payment Methods', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1369, 'Footer Logo', 'Footer Logo', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1370, 'Footer Payment Methods Logo', 'Footer Payment Methods Logo', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1371, 'About Content', 'About Content', '2024-09-29 14:55:15', '2024-09-29 14:55:15'),
(1372, 'Footer Code', 'Footer Code', '2024-09-29 14:55:16', '2024-09-29 14:55:16'),
(1373, 'Captcha verification failed.', 'Captcha verification failed.', '2024-09-29 15:15:45', '2024-09-29 15:15:45'),
(1374, 'The email type are not allowed.', 'The email type are not allowed.', '2024-09-29 15:15:45', '2024-09-29 15:15:45'),
(1375, 'Admin Panel', 'Admin Panel', '2024-09-29 15:38:26', '2024-09-29 15:38:26'),
(1376, 'Enter PassCode', 'Enter PassCode', '2024-09-29 17:47:33', '2024-09-29 17:47:33'),
(1377, 'Unlock', 'Unlock', '2024-09-29 17:47:33', '2024-09-29 17:47:33'),
(1378, 'Your Email', 'Your Email', '2024-09-29 17:47:33', '2024-09-29 17:47:33'),
(1379, 'Remind me later', 'Remind me later', '2024-09-29 17:47:33', '2024-09-29 17:47:33'),
(1380, 'We use cookies to personalize your experience. By continuing to visit this website you agree to our use of cookies', 'We use cookies to personalize your experience. By continuing to visit this website you agree to our use of cookies', '2024-09-29 17:47:33', '2024-09-29 17:47:33'),
(1381, 'Got it', 'Got it', '2024-09-29 17:47:33', '2024-09-29 17:47:33'),
(1382, 'More', 'More', '2024-09-29 17:47:33', '2024-09-29 17:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_at` datetime NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double DEFAULT '0',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `microsoft_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vkontakte_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envato_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `was_subscribed` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `kyc_status` tinyint(1) NOT NULL DEFAULT '0',
  `google2fa_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Disabled, 1: Active',
  `google2fa_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Banned, 1: Active',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_logs`
--

CREATE TABLE `user_login_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `addons_alias_unique` (`alias`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_articles`
--
ALTER TABLE `blog_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_articles_slug_unique` (`slug`),
  ADD KEY `blog_articles_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_comments_blog_article_id_foreign` (`blog_article_id`),
  ADD KEY `blog_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `captcha_providers`
--
ALTER TABLE `captcha_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_item_id_foreign` (`item_id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_support_period_id_foreign` (`support_period_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_options`
--
ALTER TABLE `category_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_options_category_id_foreign` (`category_id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_item_id_foreign` (`item_id`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_links_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `home_categories`
--
ALTER TABLE `home_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_name_unique` (`name`),
  ADD UNIQUE KEY `items_slug_unique` (`slug`),
  ADD KEY `items_category_id_foreign` (`category_id`),
  ADD KEY `items_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `item_change_logs`
--
ALTER TABLE `item_change_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_change_logs_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_comments`
--
ALTER TABLE `item_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_comments_user_id_foreign` (`user_id`),
  ADD KEY `item_comments_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_comment_replies`
--
ALTER TABLE `item_comment_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_comment_replies_item_comment_id_foreign` (`item_comment_id`),
  ADD KEY `item_comment_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `item_comment_reports`
--
ALTER TABLE `item_comment_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_comment_reports_item_comment_reply_id_foreign` (`item_comment_reply_id`),
  ADD KEY `item_comment_reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `item_discounts`
--
ALTER TABLE `item_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_discounts_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_reviews`
--
ALTER TABLE `item_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_reviews_user_id_foreign` (`user_id`),
  ADD KEY `item_reviews_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_review_replies`
--
ALTER TABLE `item_review_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_review_replies_item_review_id_foreign` (`item_review_id`),
  ADD KEY `item_review_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `item_views`
--
ALTER TABLE `item_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_views_item_id_foreign` (`item_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kyc_verifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navbar_links`
--
ALTER TABLE `navbar_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `navbar_links_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_providers`
--
ALTER TABLE `oauth_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premium_earnings`
--
ALTER TABLE `premium_earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `premium_earnings_subscription_id_foreign` (`subscription_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_code_unique` (`code`),
  ADD KEY `purchases_user_id_foreign` (`user_id`),
  ADD KEY `purchases_sale_id_foreign` (`sale_id`),
  ADD KEY `purchases_item_id_foreign` (`item_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refunds_user_id_foreign` (`user_id`),
  ADD KEY `refunds_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `refund_replies`
--
ALTER TABLE `refund_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_replies_refund_id_foreign` (`refund_id`),
  ADD KEY `refund_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_item_id_foreign` (`item_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statements`
--
ALTER TABLE `statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statements_user_id_foreign` (`user_id`);

--
-- Indexes for table `storage_providers`
--
ALTER TABLE `storage_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_slug_unique` (`slug`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `support_earnings`
--
ALTER TABLE `support_earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_earnings_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `support_periods`
--
ALTER TABLE `support_periods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_periods_name_unique` (`name`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `themes_alias_unique` (`alias`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_ticket_category_id_foreign` (`ticket_category_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_categories_name_unique` (`name`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_replies_user_id_foreign` (`user_id`),
  ADD KEY `ticket_replies_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `ticket_reply_attachments`
--
ALTER TABLE `ticket_reply_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_reply_attachments_ticket_reply_id_foreign` (`ticket_reply_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_payment_gateway_id_foreign` (`payment_gateway_id`),
  ADD KEY `transactions_purchase_id_foreign` (`purchase_id`),
  ADD KEY `transactions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_items_item_id_foreign` (`item_id`),
  ADD KEY `transaction_items_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `translates`
--
ALTER TABLE `translates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_files_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_facebook_id_unique` (`facebook_id`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD UNIQUE KEY `users_microsoft_id_unique` (`microsoft_id`),
  ADD UNIQUE KEY `users_vkontakte_id_unique` (`vkontakte_id`),
  ADD UNIQUE KEY `users_envato_id_unique` (`envato_id`),
  ADD UNIQUE KEY `users_github_id_unique` (`github_id`);

--
-- Indexes for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_logs_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blog_articles`
--
ALTER TABLE `blog_articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `captcha_providers`
--
ALTER TABLE `captcha_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category_options`
--
ALTER TABLE `category_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `home_categories`
--
ALTER TABLE `home_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `item_change_logs`
--
ALTER TABLE `item_change_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_comments`
--
ALTER TABLE `item_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `item_comment_replies`
--
ALTER TABLE `item_comment_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_comment_reports`
--
ALTER TABLE `item_comment_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `item_discounts`
--
ALTER TABLE `item_discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_reviews`
--
ALTER TABLE `item_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `item_review_replies`
--
ALTER TABLE `item_review_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_views`
--
ALTER TABLE `item_views`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `navbar_links`
--
ALTER TABLE `navbar_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_providers`
--
ALTER TABLE `oauth_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `premium_earnings`
--
ALTER TABLE `premium_earnings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `refund_replies`
--
ALTER TABLE `refund_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `statements`
--
ALTER TABLE `statements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `storage_providers`
--
ALTER TABLE `storage_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `support_earnings`
--
ALTER TABLE `support_earnings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `support_periods`
--
ALTER TABLE `support_periods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_reply_attachments`
--
ALTER TABLE `ticket_reply_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translates`
--
ALTER TABLE `translates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1383;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_articles`
--
ALTER TABLE `blog_articles`
  ADD CONSTRAINT `blog_articles_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_blog_article_id_foreign` FOREIGN KEY (`blog_article_id`) REFERENCES `blog_articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_support_period_id_foreign` FOREIGN KEY (`support_period_id`) REFERENCES `support_periods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_options`
--
ALTER TABLE `category_options`
  ADD CONSTRAINT `category_options_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD CONSTRAINT `footer_links_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `footer_links` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_change_logs`
--
ALTER TABLE `item_change_logs`
  ADD CONSTRAINT `item_change_logs_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_comments`
--
ALTER TABLE `item_comments`
  ADD CONSTRAINT `item_comments_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_comment_replies`
--
ALTER TABLE `item_comment_replies`
  ADD CONSTRAINT `item_comment_replies_item_comment_id_foreign` FOREIGN KEY (`item_comment_id`) REFERENCES `item_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_comment_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_comment_reports`
--
ALTER TABLE `item_comment_reports`
  ADD CONSTRAINT `item_comment_reports_item_comment_reply_id_foreign` FOREIGN KEY (`item_comment_reply_id`) REFERENCES `item_comment_replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_comment_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_discounts`
--
ALTER TABLE `item_discounts`
  ADD CONSTRAINT `item_discounts_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_reviews`
--
ALTER TABLE `item_reviews`
  ADD CONSTRAINT `item_reviews_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_review_replies`
--
ALTER TABLE `item_review_replies`
  ADD CONSTRAINT `item_review_replies_item_review_id_foreign` FOREIGN KEY (`item_review_id`) REFERENCES `item_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_review_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_views`
--
ALTER TABLE `item_views`
  ADD CONSTRAINT `item_views_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  ADD CONSTRAINT `kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `navbar_links`
--
ALTER TABLE `navbar_links`
  ADD CONSTRAINT `navbar_links_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `navbar_links` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `premium_earnings`
--
ALTER TABLE `premium_earnings`
  ADD CONSTRAINT `premium_earnings_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refunds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refund_replies`
--
ALTER TABLE `refund_replies`
  ADD CONSTRAINT `refund_replies_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `refunds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refund_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statements`
--
ALTER TABLE `statements`
  ADD CONSTRAINT `statements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_earnings`
--
ALTER TABLE `support_earnings`
  ADD CONSTRAINT `support_earnings_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ticket_category_id_foreign` FOREIGN KEY (`ticket_category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_reply_attachments`
--
ALTER TABLE `ticket_reply_attachments`
  ADD CONSTRAINT `ticket_reply_attachments_ticket_reply_id_foreign` FOREIGN KEY (`ticket_reply_id`) REFERENCES `ticket_replies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`),
  ADD CONSTRAINT `transactions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD CONSTRAINT `uploaded_files_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD CONSTRAINT `user_login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

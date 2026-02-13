-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 07:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `five_nine`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'such as home_banner',
  `page` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `slug`, `type`, `page`, `created_at`, `updated_at`) VALUES
(1, 'Header_Logo', 'Header Logo', 'Header', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(2, 'Header_Navigation', 'Header Navigation', 'Header', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(3, 'Header_button', 'Header Button', 'Header', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(4, 'Hero_Banner_Section', 'Hero Banner Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(5, 'Hero_Video_Banner_Section', 'Hero Video Banner Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(6, 'Marque_Section', 'Marque Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(7, 'About_Us_Section', 'About Us Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(8, 'Mission_Section', 'Mission Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(9, 'Service_Section', 'Services Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(10, 'Why_Choose_Us_Section', 'Why Choose Us Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(11, 'Capabilities_Section', 'Capabilities Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(12, 'Blog_Section', 'Blog Section', 'home', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(13, 'Testimonials_Section', 'Testimonials Section', 'testimonials', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(14, 'Newsletter_Section', 'Newsletter Section', 'footer', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(15, 'Footer_Section', 'Footer Section', 'footer', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(16, 'Footer_Navigation', 'Footer Navigation', 'footer', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(17, 'Banner_Section', 'Banner Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(18, 'Content_Section', 'Content Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(19, 'Capabilities_Section', 'Capabilities Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(20, 'Business_Section', 'Business Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(21, 'Why_Choose_Us_Section', 'Why Choose Us Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(22, 'Advisory_Section', 'Advisory Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24'),
(23, 'Available_Section', 'Available Section', 'about-us', '2026-01-29 23:11:24', '2026-01-29 23:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `cms_metas`
--

CREATE TABLE `cms_metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cms_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL COMMENT 'such as banner_image',
  `meta_value` longtext DEFAULT NULL COMMENT 'such as banner_image URL , HEIGHT,WIDTH',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_metas`
--

INSERT INTO `cms_metas` (`id`, `cms_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'logo', 'http://172.168.2.122:8000/images/header_logos/1769821360.png', '2026-01-30 23:53:47', '2026-01-30 20:02:40'),
(2, 2, 'navigation', 'Home', '2026-01-30 23:53:47', '2026-02-02 19:55:35'),
(3, 2, 'navigation', 'About Us', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(4, 2, 'navigation', 'Services', '2026-01-30 23:53:47', '2026-02-06 15:00:06'),
(5, 2, 'navigation', 'Capabilities', '2026-01-30 23:53:47', '2026-02-05 18:35:01'),
(6, 2, 'navigation', 'Blog', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(7, 2, 'navigation', 'Contact Us', '2026-01-30 23:53:47', '2026-02-05 15:49:54'),
(8, 3, 'button text', 'Get Started', '2026-01-30 23:53:47', '2026-02-02 19:25:00'),
(9, 3, 'button url', '/', '2026-01-30 23:53:47', '2026-02-02 19:25:00'),
(14, 4, 'heading', 'Reliable Systems, Zero Downtime', '2026-01-30 23:53:47', '2026-02-06 19:01:26'),
(15, 4, 'sub_heading', 'Stay Online, Scale Cleanly, and Remove Capital Strain.', '2026-01-30 23:53:47', '2026-02-06 18:17:43'),
(19, 5, 'video', 'http://172.168.2.122:8000/videos/hero_video_banner/1770426051.mp4', '2026-01-30 23:53:47', '2026-02-06 20:00:51'),
(23, 5, 'para', 'Your systems can\'t afford to go down. We architect, deploy, and monitor infrastructure that stays operational when competitors are scrambling to recover. HAaaS and DRaaS services are designed for organizations that demand reliability, not excuses.', '2026-01-30 23:53:47', '2026-01-30 20:00:18'),
(24, 5, 'button_text', 'GET STARTED', '2026-01-30 23:53:47', '2026-01-30 20:00:07'),
(25, 5, 'button_url', NULL, '2026-01-30 23:53:47', '2026-02-06 20:08:19'),
(26, 6, 'heading_1', 'EMPOWERING RESILIENCE,', '2026-01-30 23:53:47', '2026-01-30 20:13:19'),
(27, 6, 'heading_2', 'ANYTIME,', '2026-01-30 23:53:47', '2026-01-30 20:13:27'),
(28, 6, 'heading_3', 'ANYWHERE', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(29, 6, 'sub_heading', 'Our Name Comes from “Five Nines”', '2026-01-30 23:53:47', '2026-01-30 20:13:51'),
(30, 6, 'para', 'Which means 99.999% Uptime is Our Standard. Five 9 is your enterprise technology partner, delivering senior expertise and execution power on demand without hiring additional full-time staff.', '2026-01-30 23:53:47', '2026-01-30 20:14:05'),
(31, 6, 'button_text', 'GET STARTED', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(32, 6, 'button_url', 'https://shanon-gordan.vercel.app/our-services', '2026-01-30 23:53:47', '2026-02-09 12:51:59'),
(38, 7, 'title', 'About Us', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(39, 7, 'heading', 'More Than 35 Markets Protected Across the Globe', '2026-01-30 23:53:47', '2026-02-09 13:40:14'),
(40, 7, 'para', 'Since 2014, Five 9 has focused on keeping business systems operational. Our name refers to the industry gold standard of 99.999% availability. That number represents what we deliver every single day. We build the technology foundations that companies rely on to serve their customers, process transactions, and run their operations.on:', '2026-01-30 23:53:47', '2026-02-09 13:28:22'),
(41, 7, 'button_text', 'READ MORE', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(42, 7, 'button_url', 'https://shanon-gordan.vercel.app/our-services', '2026-01-30 23:53:47', '2026-02-09 13:43:22'),
(47, 8, 'crud', 'cards', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(189, 16, 'navigation', 'Home', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(190, 16, 'navigation', 'Home', '2026-01-30 23:53:47', '2026-02-12 15:51:05'),
(191, 16, 'navigation', 'Home', '2026-01-30 23:53:47', '2026-02-12 15:51:19'),
(192, 16, 'navigation', 'Home', '2026-01-30 23:53:47', '2026-02-12 15:51:26'),
(193, 16, 'navigation', 'Home', '2026-01-30 23:53:47', '2026-02-12 15:53:58'),
(194, 16, 'navigation', 'Contact Us', '2026-01-30 23:53:47', '2026-01-30 23:53:47'),
(212, 9, 'heading', 'Our Services', '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(213, 9, 'sub_heading', 'Access senior expertise exactly when you need it. Pay only for what you use.', '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(214, 9, 'background_image', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(215, 9, 'crud', 'cards', '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(241, 11, 'heading_1', 'EMPOWERING RESILIENCE,', '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(242, 11, 'heading_2', 'ANYTIME,', '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(243, 11, 'heading_3', 'ANYWHERE', '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(244, 11, 'sub_heading', 'Five Specialized Domains. One Reliable Partner.', '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(245, 11, 'para', 'Five 9 delivers technology capability as a service across five specialized areas. Each domain has dedicated experts focusing entirely on their field. You get deep knowledge from specialists, and advices from generalists.', '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(246, 11, 'crud', 'cards', '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(253, 12, 'heading', 'Our Latest Blog', '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(254, 12, 'button_text', 'VIEW ALL', '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(255, 12, 'button_url', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(256, 12, 'para', 'Expert perspectives on building resilient, secure, and scalable technology systems.', '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(257, 12, 'crud', 'cards', '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(258, 13, 'heading', 'CLIENT TESTIMONIALS', '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(259, 13, 'crud', 'cards', '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(262, 10, 'heading', 'Why Choose Five9?', '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(263, 10, 'sub_heading', 'We Extend Your Capabilities, So You Don’t Hire More', '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(264, 10, 'para', 'Over the past decade, we\'ve fixed the problems that destroy businesses. System crashes. Security breaches. Failed recovery attempts. We know what breaks and learned how to prevent it. Our managed technology execution approach implements, monitor, and optimize them as your needs change.', '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(265, 10, 'button_text', 'GET STARTED', '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(266, 10, 'button_url', 'https://shanon-gordan.vercel.app/our-capabilities', '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(267, 10, 'crud', 'cards', '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(277, 14, 'heading', 'SPOT TECHNOLOGY VULNERABILITIES FAST? FIND OUT IN 30 MINUTES', '2026-02-09 19:32:35', '2026-02-09 19:32:35'),
(278, 17, 'heading', 'Your Trusted Technology Partner for Over a Decade', '2026-02-10 21:47:53', '2026-02-10 17:55:59'),
(279, 17, 'title', 'About Us', '2026-02-10 21:47:53', '2026-02-10 17:56:08'),
(280, 18, 'heading', 'Helping companies stay online with scalable, expert IT solutions since 2014.', '2026-01-30 23:53:47', '2026-02-10 18:05:00'),
(281, 18, 'para', 'Five 9 has spent over a decade helping companies stay online with reliable, scalable IT solutions. We started after seeing businesses lose money from downtime, security breaches, and outdated technology. Our founders’ experience building dependable systems shaped our approach. Named after the gold standard of 99.999% uptime—just 5 minutes of downtime per year—Five 9 keeps critical systems operational, secure, and scalable. We don’t just give advice; we stay through implementation to ensure solutions actually work. Our on-demand technology teams provide database, security, and cloud experts exactly when you need them, giving businesses the expertise to solve complex problems without the cost or overhead of full-time hires.', '2026-01-30 23:53:47', '2026-02-09 13:28:22'),
(282, 18, 'image', NULL, '2026-01-30 23:53:47', '2026-02-10 18:06:26'),
(283, 19, 'heading_1', 'EMPOWERING RESILIENCE,', NULL, '2026-02-10 18:43:43'),
(284, 19, 'heading_2', 'ANYTIME,', NULL, NULL),
(285, 19, 'heading_3', 'ANYWHERE', NULL, NULL),
(286, 19, 'sub_heading', 'Who We Are', NULL, NULL),
(287, 19, 'para', 'We are specialists in building systems that work. From Fortune 500 to startups, our team solves downtime, security, and scalability challenges. We focus on real results, keeping your business running smoothly without unnecessary costs or complexity.', NULL, NULL),
(288, 20, 'heading', 'Get Enterprise Technology Support Now', NULL, '2026-02-10 18:46:49'),
(289, 20, 'sub_heading', 'Our Mission', NULL, NULL),
(290, 20, 'para', 'We help businesses use technology the right way. Every recommendation must improve operations. No wasted software, no unnecessary consultants, no downtime. Our success comes from making your systems reliable, scalable, and aligned with your business goals.', NULL, '2026-02-10 18:47:04'),
(291, 20, 'button_text', 'GET STARTED', NULL, NULL),
(292, 20, 'button_url', NULL, NULL, '2026-02-10 18:46:39'),
(293, 21, 'heading', 'What We Do', NULL, '2026-02-10 18:59:15'),
(294, 21, 'para', 'We don’t just advise—you get implementation too. Our on-demand teams deliver expertise when you need it. Security, infrastructure, applications, AI, and transformation projects are handled by specialists. We ensure systems work reliably, improve efficiency, and grow with your business.', NULL, '2026-02-10 18:59:27'),
(295, 22, 'heading', 'Why Clients Choose Five 9 Services', NULL, NULL),
(296, 22, 'para', 'Our 90% retention rate reflects the trust clients place in us. We stay involved long-term, solving issues quickly and scaling technology alongside your business. No surprise bills, no disappearing consultants, no unnecessary services. From startups to enterprises across 35+ U.S. markets, every client receives the same commitment: reliable systems, expert guidance, and solutions that genuinely support growth. Your technology works when you need it most.', NULL, NULL),
(297, 22, 'crud', 'bullets', NULL, NULL),
(298, 23, 'heading', 'We Answer When You Call', NULL, '2026-02-10 19:23:33'),
(299, 23, 'para', 'Our 24/7 support isn\'t outsourced to a call center in another country. When you have an emergency at 2 AM, you talk to someone who knows your systems and can actually fix the problem.', NULL, '2026-02-10 19:23:43'),
(387, 15, 'logo_img', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(388, 15, 'para', 'Delivering 99.999% uptime for businesses since 2014. Expert IT solutions that keep your systems reliable, scalable, and secure.', '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(389, 15, 'crud', 'cards', '2026-02-12 15:07:46', '2026-02-12 15:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `cms_meta_values`
--

CREATE TABLE `cms_meta_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cms_meta_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL COMMENT 'such as image_url, height, width',
  `value` longtext DEFAULT NULL COMMENT 'such as actual URL, height value, width value',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_meta_values`
--

INSERT INTO `cms_meta_values` (`id`, `cms_meta_id`, `key`, `value`, `parent_id`, `created_at`, `updated_at`) VALUES
(127, 2, 'url', 'https://shanon-gordan.vercel.app', NULL, '2026-01-30 17:37:48', '2026-01-30 15:14:59'),
(128, 3, 'url', 'https://shanon-gordan.vercel.app/about-us', NULL, '2026-01-30 17:37:48', '2026-01-30 15:13:39'),
(129, 4, 'url', 'https://shanon-gordan.vercel.app/our-services', NULL, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(130, 5, 'url', 'https://shanon-gordan.vercel.app/our-capabilities', NULL, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(131, 6, 'url', 'https://shanon-gordan.vercel.app/blogs', NULL, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(132, 7, 'url', 'https://shanon-gordan.vercel.app/contact-us', NULL, '2026-01-30 17:37:48', '2026-02-05 15:49:54'),
(135, 189, 'url', 'https://shanon-gordan.vercel.app', NULL, '2026-01-30 17:37:48', '2026-02-05 18:10:48'),
(136, 190, 'url', 'https://shanon-gordan.vercel.app', NULL, '2026-01-30 17:37:48', '2026-02-12 15:51:05'),
(137, 191, 'url', 'https://shanon-gordan.vercel.app', NULL, '2026-01-30 17:37:48', '2026-02-12 15:51:19'),
(138, 192, 'url', 'https://shanon-gordan.vercel.app', NULL, '2026-01-30 17:37:48', '2026-02-12 15:51:26'),
(139, 193, 'url', 'https://shanon-gordan.vercel.app', NULL, '2026-01-30 17:37:48', '2026-02-12 15:53:58'),
(140, 194, 'url', 'https://shanon-gordan.vercel.app/contact-us', NULL, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(141, 5, 'Transformation', 'https://shanon-gordan.vercel.app/our-capabilities/Transformation', 130, '2026-01-30 17:37:48', '2026-01-30 17:58:08'),
(142, 5, 'Artificial-intelligence', 'https://shanon-gordan.vercel.app/our-capabilities/Artificial-intelligence', 130, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(143, 5, 'security', 'https://shanon-gordan.vercel.app/our-capabilities/security', 130, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(144, 5, 'Infrastructure', 'https://shanon-gordan.vercel.app/our-capabilities/Infrastructure', 130, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(145, 5, 'Applications', 'https://shanon-gordan.vercel.app/our-capabilities/Applications', 130, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(146, 5, 'Data-Engineering', 'https://shanon-gordan.vercel.app/our-capabilities/Data-Engineering', 130, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(147, 5, 'Cloud', 'https://shanon-gordan.vercel.app/our-capabilities/Cloud', 130, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(148, 4, 'Strategy', 'https://shanon-gordan.vercel.app/our-services/strategy', 129, '2026-01-30 17:37:48', '2026-01-30 18:09:20'),
(149, 4, 'Fractional-CTO', 'https://shanon-gordan.vercel.app/our-services/fractional-CTO', 129, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(150, 4, 'Digital', 'https://shanon-gordan.vercel.app/our-services/digital-services', 129, '2026-01-30 17:37:48', '2026-02-06 15:28:28'),
(151, 4, 'Consulting', 'https://shanon-gordan.vercel.app/our-services/consulting', 129, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(152, 4, 'Advisory', 'https://shanon-gordan.vercel.app/our-services/advisory', 129, '2026-01-30 17:37:48', '2026-01-30 17:37:48'),
(228, 215, '#title', 'Consulting', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(229, 215, 'para', 'When your team faces complex technical challenges, we provide experienced experts for targeted projects like security audits, cloud migrations, or performance improvements delivering fast solutions without the cost of permanent hires.', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(230, 215, 'button_text', 'LEARN MORE', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(231, 215, 'button_url', '', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(232, 215, 'title_bg_image', NULL, NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(233, 215, '#title', 'Advisory', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(234, 215, 'para', 'Major technology decisions need expert insight. Our human-led advisors bring Fortune 500 and startup experience, offering proven judgment to guide critical choices and help you avoid costly mistakes.', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(235, 215, 'button_text', 'LEARN MORE', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(236, 215, 'button_url', '', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(237, 215, 'title_bg_image', NULL, NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(238, 215, '#title', 'Strategy', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(239, 215, 'para', 'We assess your current systems, identify what works and what doesn’t, then create a clear technology roadmap that prioritizes spending, fits your budget, and drives measurable revenue growth over time.', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(240, 215, 'button_text', 'LEARN MORE', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(241, 215, 'button_url', '', NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(242, 215, 'title_bg_image', NULL, NULL, '2026-02-03 20:20:58', '2026-02-03 20:20:58'),
(291, 246, '#box_heading', 'Security', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(292, 246, 'box_para', 'Protect your data with testing, compliance, and incident response services.', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(293, 246, 'box_image', NULL, NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(294, 246, '#box_heading', 'Transformation', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(295, 246, 'box_para', 'Modernize systems safely, migrate data, train staff, and improve operations.', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(296, 246, 'box_image', NULL, NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(297, 246, '#box_heading', 'Infrastructure', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(298, 246, 'box_para', 'Build scalable, redundant infrastructure with monitoring to prevent failures.', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(299, 246, 'box_image', NULL, NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(300, 246, '#box_heading', 'AI', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(301, 246, 'box_para', 'Implement AI for analytics, automation, and measurable business results.', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(302, 246, 'box_image', NULL, NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(303, 246, '#box_heading', 'Applications', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(304, 246, 'box_para', 'Develop, integrate, and optimize applications to boost team productivity.', NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(305, 246, 'box_image', NULL, NULL, '2026-02-04 16:50:54', '2026-02-04 16:50:54'),
(342, 257, '#box_heading', 'Why Most Disaster Recovery Plans Fail...\"', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(343, 257, 'box_para', '60% of businesses that test their disaster recovery plans...', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(344, 257, 'box_image', NULL, NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(345, 257, 'box_date', '2026-02-15', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(346, 257, 'box_button_text', 'READ MORE', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(347, 257, 'box_button_url', '', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(348, 257, '#box_heading', 'Why Most Disaster Recovery Plans Fail...\"', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(349, 257, 'box_para', '60% of businesses that test their disaster recovery plans...', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(350, 257, 'box_image', NULL, NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(351, 257, 'box_date', '2026-02-15', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(352, 257, 'box_button_text', 'READ MORE', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(353, 257, 'box_button_url', '', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(354, 257, '#box_heading', 'Why Most Disaster Recovery Plans Fail...\"', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(355, 257, 'box_para', '60% of businesses that test their disaster recovery plans...', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(356, 257, 'box_image', NULL, NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(357, 257, 'box_date', '2026-02-15', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(358, 257, 'box_button_text', 'READ MORE', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(359, 257, 'box_button_url', '', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(360, 257, '#box_heading', 'Why Most Disaster Recovery Plans Fail...\"', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(361, 257, 'box_para', '60% of businesses that test their disaster recovery plans...', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(362, 257, 'box_image', NULL, NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(363, 257, 'box_date', '2026-02-15', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(364, 257, 'box_button_text', 'READ MORE', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(365, 257, 'box_button_url', '', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(366, 257, '#box_heading', 'Why Most Disaster Recovery Plans Fail...\"', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(367, 257, 'box_para', '60% of businesses that test their disaster recovery plans...', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(368, 257, 'box_image', NULL, NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(369, 257, 'box_date', '2026-02-15', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(370, 257, 'box_button_text', 'READ MORE', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(371, 257, 'box_button_url', '', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(372, 257, '#box_heading', 'Why Most Disaster Recovery Plans Fail...\"', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(373, 257, 'box_para', '60% of businesses that test their disaster recovery plans...', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(374, 257, 'box_image', NULL, NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(375, 257, 'box_date', '2026-02-15', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(376, 257, 'box_button_text', 'READ MORE', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(377, 257, 'box_button_url', '', NULL, '2026-02-04 19:25:43', '2026-02-04 19:25:43'),
(379, 259, '#title', 'Finally, Someone Who Speaks English', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(380, 259, 'para', '\"Every other consultant talked in acronyms and jargon. Five 9 explains things in plain language. If I don\'t understand something, they explain it differently until I do. That\'s respect for the client.\"', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(381, 259, 'client_name', 'Jennifer Williams', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(382, 259, 'client_designation', 'CEO', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(383, 259, 'client_company_name', 'RetailTech Solutions', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(384, 259, '#title', 'They Actually Did What They Promised', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(385, 259, 'para', '\"We worked with three consultants before Five 9. The others gave us reports and disappeared. Five 9 stayed through implementation and made sure everything worked. That\'s the difference between wasted money and actual results.\"', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(386, 259, 'client_name', 'Sarah Chen', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(387, 259, 'client_designation', 'COO,', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(388, 259, 'client_company_name', 'RetailTech Solutions', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(389, 259, '#title', 'Like Having a CTO Without the Cost', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(390, 259, 'para', '\"Our fractional CTO saved us from making a $500,000 mistake on a vendor contract. That one conversation paid for a year of services. Now he\'s part of every major technology decision we make.\"', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(391, 259, 'client_name', 'Michael Rodriguez', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(392, 259, 'client_designation', 'CEO', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(393, 259, 'client_company_name', 'HealthFirst Medical', NULL, '2026-02-05 12:32:18', '2026-02-05 12:32:18'),
(432, 47, '#title', 'Our Vision', NULL, '2026-02-09 17:28:56', '2026-02-09 17:28:56'),
(433, 47, 'para', 'Technology should make businesses run more smoothly, not make them more complicated. Companies of any size deserve access to the same quality infrastructure that large enterprises use. We\'re working toward a future where your budget and company size don\'t limit your technology capabilities.', NULL, '2026-02-09 17:28:56', '2026-02-09 17:28:56'),
(434, 47, '#title', 'Our Mission', NULL, '2026-02-09 17:28:56', '2026-02-09 17:28:56'),
(435, 47, 'para', 'We help organizations build technology that actually supports their growth. Every system we work on gets stronger, costs less to maintain over time, and grows alongside your business. Strategy alone isn’t enough. We stay accountable through execution, so plans actually move the business forward.', NULL, '2026-02-09 17:28:56', '2026-02-09 17:28:56'),
(436, 267, '#box_heading', '35+', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(437, 267, 'box_text', 'Markets in U.S.', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(438, 267, 'box_image', 'http://172.168.2.122:8000/images/whychoose-us/cards/1770682162.png', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(439, 267, '#box_heading', '90%', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(440, 267, 'box_text', 'Retention Rate', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(441, 267, 'box_image', NULL, NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(442, 267, '#box_heading', '24/7', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(443, 267, 'box_text', 'Support', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(444, 267, 'box_image', NULL, NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(445, 267, '#box_heading', '15+', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(446, 267, 'box_text', 'Products', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(447, 267, 'box_image', NULL, NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(448, 297, '#point', 'On-demand technology experts', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(449, 297, '#point', 'Security planning and audits', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(450, 297, '#point', 'Scalable infrastructure solutions', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(451, 297, '#point', 'Cloud migrations and management', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(452, 297, '#point', 'Custom application development', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(453, 297, '#point', 'AI and automation solutions', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(454, 297, '#point', 'System monitoring and support', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(455, 297, '#point', 'Disaster recovery planning', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(456, 297, '#point', 'Continuous improvement guidance', NULL, '2026-02-09 19:09:22', '2026-02-09 19:09:22'),
(481, 389, '#title', 'Reach Us', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(482, 389, 'info_1', '+1 877 853 4839', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(483, 389, 'info_2', 'info@five9.co', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(484, 389, '#title', 'Contact Us', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(485, 389, 'info_1', '8310 S. Valley Highway Suite 300', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46'),
(486, 389, 'info_2', 'null', NULL, '2026-02-12 15:07:46', '2026-02-12 15:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_29_185335_create_personal_access_tokens_table', 1),
(5, '2026_01_29_223513_create_cms_table', 2),
(6, '2026_01_29_223521_create_cms_metas_table', 2),
(8, '2026_01_30_005551_create_cms_meta_values_table', 3),
(9, '2026_02_12_181732_create_newsletters_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `name`, `email`, `company_name`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Abc', 'test@gmail.com', NULL, NULL, 'testing', '2026-02-12 13:28:15', '2026-02-12 13:28:15'),
(2, 'Abc', 'info@five9.co', NULL, NULL, 'testing', '2026-02-12 13:59:16', '2026-02-12 13:59:16'),
(3, 'dnas', 'test@gmail.com', NULL, NULL, 'test', '2026-02-12 17:55:27', '2026-02-12 17:55:27'),
(4, 'Abc', 'info@five9.co', NULL, NULL, 'testing', '2026-02-12 18:07:05', '2026-02-12 18:07:05'),
(5, 'Abc', 'info@five9.co', NULL, NULL, 'testing', '2026-02-12 18:07:14', '2026-02-12 18:07:14'),
(6, 'Abc', 'jhonathan123@yopmail.com', NULL, NULL, NULL, '2026-02-12 18:09:59', '2026-02-12 18:09:59'),
(7, 'Abc', 'jhonathan123@yopmail.com', NULL, NULL, 'testing', '2026-02-12 18:14:09', '2026-02-12 18:14:09'),
(8, 'Abc', 'jhonathan123@yopmail.com', 'new Company', NULL, 'testing', '2026-02-12 18:14:32', '2026-02-12 18:14:32'),
(9, 'Abc', 'jhonathan123@yopmail.com', 'new Company', '+1 4587298987', 'testing', '2026-02-12 18:14:52', '2026-02-12 18:14:52'),
(10, 'Abc', 'jhonathan123@yopmail.com', 'new Company', '+1 4587298987', 'testing', '2026-02-12 18:15:50', '2026-02-12 18:15:50'),
(11, 'Henry', 'henry.99@yopmail.com', NULL, NULL, 'Test Message', '2026-02-12 18:17:07', '2026-02-12 18:17:07'),
(12, 'Henry', 'henry.99@yopmail.com', NULL, NULL, 'Test Message', '2026-02-12 18:18:13', '2026-02-12 18:18:13'),
(13, 'menamuw@mailinator.com', 'pymavyr@mailinator.com', 'rycu@mailinator.com', '24', 'Eius excepteur quis', '2026-02-12 18:34:40', '2026-02-12 18:34:40'),
(14, 'anas', 'jhonathan123@yopmail.com', 'TMV', '0121212', 'hello berooo!!', '2026-02-12 18:36:19', '2026-02-12 18:36:19'),
(15, 'tester1', 'jhonathan123@yopmail.com', NULL, NULL, 'hello again beroo!!!', '2026-02-12 18:36:54', '2026-02-12 18:36:54'),
(16, 'tester', 'jhonathan123@yopmail.com', 'TMV', '090909090', 'hello again', '2026-02-12 18:41:11', '2026-02-12 18:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '$2y$12$/TatsqvRMp3k1ciN7hCReOVI1P4MrAIzfWZoVRA5NvkxJVLwvnP1K', '2026-01-29 16:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(76, 'App\\Models\\User', 1, 'api-token', 'c7d2d043ea750dd191c51e163917bd9b4bc1fee469fd9e14a0dbc04ff14ac674', '[\"*\"]', NULL, NULL, '2026-02-13 11:29:02', '2026-02-13 11:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('eEkrPUlOPDgJze4LI3XhXpirCYzZxnDjOA0R80fv', NULL, '172.168.2.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWV0dXB6UXFFaDA4SWcwM2FyUWptTkpuZG5QWXVoUk1zOXVsczBsUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTY4LjIuMTIyOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770426352),
('mJEgjHo5jlRBIes3juCdASXAk1JmMc1Hdyh51tJq', NULL, '172.168.2.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGNqSFFrVGVGMERkWm9Db1lnU1pGMHBXd3FNYUtEQ2FmVWZkQkU3UCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTY4LjIuMTIyOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770077709),
('nrXw8rmXX4uNtgYaRulNaHYKNG4hlfzSg2yLKCSl', NULL, '172.168.2.122', 'PostmanRuntime/7.51.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEpHajBWS1VsM0RMamdTb0VQQkJLZ3RvQjJhY3Y1TnE5ZlNzMk9GeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTY4LjIuMTIyOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769719181),
('qolVcP0HDhMVpBYpxUl0SPnhMMtCXAEnScgm56nW', NULL, '172.168.2.122', 'PostmanRuntime/7.51.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2FGWHIyVjNHaDR5VTRZTGNQa1ZMNXBKRmtMWHhMaVJiT2VwMmFZMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTY4LjIuMTIyOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769800526),
('rJO8cxS355WSA366gvePM864LcH8NouVuQlF8zVS', NULL, '172.168.2.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVhOYXphcVl5V0NJUENiRnB2Y09WQmFoR2FMSDhncWpUZEpMdGJHRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTY4LjIuMTIyOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770135685),
('Xbt9xCc5Dsseqymt61E9FdL1QwpPYraC4bDgNlUa', NULL, '172.168.2.111', 'node', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXNBWkdjcVRsZVphaTl4aWRYaGdZd0YwZzdsSjRmU0RZMEFjbTA5NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNzIuMTY4LjIuMTIyOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769725777);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'new User', 'admin@gmail.com', NULL, '$2y$12$87DkvbvLGkuHkEleHOXIPe6G9jHJP6P7DDaswLVIO7mOf5fB90AOO', NULL, '2026-01-29 19:30:12', '2026-01-29 19:30:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_metas`
--
ALTER TABLE `cms_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cms_metas_cms_id_foreign` (`cms_id`);

--
-- Indexes for table `cms_meta_values`
--
ALTER TABLE `cms_meta_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cms_meta_values_cms_meta_id_foreign` (`cms_meta_id`),
  ADD KEY `fk_parent_meta_value` (`parent_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cms_metas`
--
ALTER TABLE `cms_metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;

--
-- AUTO_INCREMENT for table `cms_meta_values`
--
ALTER TABLE `cms_meta_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cms_metas`
--
ALTER TABLE `cms_metas`
  ADD CONSTRAINT `cms_metas_cms_id_foreign` FOREIGN KEY (`cms_id`) REFERENCES `cms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cms_meta_values`
--
ALTER TABLE `cms_meta_values`
  ADD CONSTRAINT `cms_meta_values_cms_meta_id_foreign` FOREIGN KEY (`cms_meta_id`) REFERENCES `cms_metas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_parent_meta_value` FOREIGN KEY (`parent_id`) REFERENCES `cms_meta_values` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

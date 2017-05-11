-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 11, 2017 at 07:11 
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `place-corner`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `order_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `image`, `status`, `is_deleted`, `order_number`) VALUES
(1, 0, 'ae33dede026de1e9828dc7d25db69ea9.jpeg', 1, 0, 0),
(2, 0, 'eabccfdb4b7ed266cfde732b84eec28d.jpeg', 1, 0, 0),
(3, 0, '61fe2efe46cb5e0b44260bbf38100864.jpeg', 1, 0, 0),
(4, 0, '4060eaefd3f459ebd1cc893736f62ba8.jpeg', 1, 0, 0),
(5, 0, '01453bb8f4e03e44781273ead5f08759.jpeg', 1, 0, 0),
(6, 0, '85648bb8016d7b00d5542982a766a73b.jpeg', 1, 0, 0),
(7, 0, '6831f89d3bf7f3c8b14a0b9c45e4de8a.jpeg', 1, 0, 0),
(8, 0, '98cc069737381f9e04f94493925f67dd.jpeg', 1, 0, 0),
(9, 0, '7cdd4d4b66c0da9f05c98f0e40e03180.jpeg', 1, 0, 0),
(10, 0, 'ad5f01693ea404d08e5d21a55a9d099c.jpeg', 1, 0, 0),
(11, 0, 'ff06bd2a2d86fbea0a128f509f24fba4.jpeg', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category_translation`
--

CREATE TABLE `category_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_translation`
--

INSERT INTO `category_translation` (`id`, `translatable_id`, `title`, `description`, `seo_title`, `seo_description`, `seo_keywords`, `locale`) VALUES
(1, 1, 'Historical Places', 'Historical Places', 'Historical Places', 'Historical Places', 'Historical Places', 'en'),
(2, 2, 'Towers and Forts', 'Towers and Forts', 'Towers and Forts', 'Towers and Forts', 'Towers and Forts', 'en'),
(3, 3, 'Cultural Places', 'Cultural Places', 'Cultural Places', 'Cultural Places', 'Cultural Places', 'en'),
(4, 4, 'Shopping', 'Shopping', 'Shopping', 'Shopping', 'Shopping', 'en'),
(5, 5, 'Club & Nighlife', 'Club & Nighlife', 'Club & Nighlife', 'Club & Nighlife', 'Club & Nighlife', 'en'),
(6, 6, 'Festivals', 'Festivals', 'Festivals', 'Festivals', 'Festivals', 'en'),
(7, 7, 'Sport Events', 'Sport Events', 'Sport Events', 'Sport Events', 'Sport Events', 'en'),
(8, 8, 'Hostels', 'Hostels', 'Hostels', 'Hostels', 'Hostels', 'en'),
(9, 9, 'Rooms', 'Rooms', 'Rooms', 'Rooms', 'Rooms', 'en'),
(10, 10, 'Bed & Breakfast', 'Bed & Breakfast', 'Bed & Breakfast', 'Bed & Breakfast', 'Bed & Breakfast', 'en'),
(11, 11, 'Parks and Gardens', 'Parks and Gardens', 'Parks and Gardens', 'Parks and Gardens', 'Parks and Gardens', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  `image` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `order_number` int(11) NOT NULL,
  `map` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `region_id`, `image`, `status`, `is_deleted`, `order_number`, `map`) VALUES
(1, 1, 'dc09298abe9b3761f01b2f981d604f80.jpeg', 1, 0, 0, '44.74906345183866, 20.455322228372097'),
(2, 1, 'd01b9f62e643c664236b8c575a4c198a.jpeg', 1, 0, 0, '45.822286658569595, 15.989990215748549'),
(3, 1, '5079f45330fbd3c8e7cb0f6536bb1d4a.jpeg', 1, 0, 0, '47.46224514438097, 19.135742112994194'),
(4, 1, '8781d32783cf5b557dfe7564370200df.jpeg', 1, 0, 0, '37.94267829665602, 23.735656708013266'),
(5, 1, '36c6783eea1ae1190bb3200f59a93027.jpeg', 1, 0, 0, '48.1964809456899, 16.39648435637355'),
(6, 1, '6c582aa52d0d0c86b9bca08e20d18fd5.jpeg', 1, 0, 0, '41.885203956033365, 12.484435988590121'),
(7, 1, '8a68344e3387a418c902fa224acb5abe.jpeg', 1, 0, 0, '55.75540228373546, 37.605896070599556');

-- --------------------------------------------------------

--
-- Table structure for table `city_translation`
--

CREATE TABLE `city_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` longtext COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `city_translation`
--

INSERT INTO `city_translation` (`id`, `translatable_id`, `name`, `seo_title`, `seo_description`, `seo_keywords`, `locale`) VALUES
(1, 1, 'Belgrade', 'Belgrade', 'Belgrade', 'Belgrade', 'en'),
(2, 2, 'Zagreb', 'Zagreb', 'Zagreb', 'Zagreb', 'en'),
(3, 3, 'Budapest', 'Budapest', 'Budapest', 'Budapest', 'en'),
(4, 4, 'Athens', 'Athens', 'Athens', 'Athens', 'en'),
(5, 5, 'Vienna', 'Vienna', 'Vienna', 'Vienna', 'en'),
(6, 6, 'Rome', 'Rome', 'Rome', 'Rome', 'en'),
(7, 7, 'Mosow', 'Mosow', 'Mosow', 'Mosow', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `order_number` int(11) NOT NULL,
  `map` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `status`, `is_deleted`, `order_number`, `map`) VALUES
(1, 1, 0, 0, '44.118922485727914, 20.718994103372097'),
(2, 1, 0, 0, '45.034499169854826, 15.072021447122097'),
(3, 1, 0, 0, '42.04883951964304, 24.760742029175162'),
(4, 1, 0, 0, '39.55441284155227, 22.167968675494194'),
(5, 1, 0, 0, '46.93484421783329, 19.333495683968067'),
(6, 1, 0, 0, '47.57570422549774, 14.189452975988388'),
(7, 1, 0, 0, '42.79495289430259, 12.258300706744194'),
(8, 1, 0, 0, '61.43409936151792, 92.42188453674316'),
(9, 1, 0, 0, '22.575697015022655, -46.48437738418579');

-- --------------------------------------------------------

--
-- Table structure for table `country_translation`
--

CREATE TABLE `country_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country_translation`
--

INSERT INTO `country_translation` (`id`, `translatable_id`, `name`, `locale`) VALUES
(1, 1, 'Serbia', 'en'),
(2, 2, 'Croatia', 'en'),
(3, 3, 'Bulgaria', 'en'),
(4, 4, 'Greece', 'en'),
(5, 5, 'Hungary', 'en'),
(6, 6, 'Austria', 'en'),
(7, 7, 'Italy', 'en'),
(8, 8, 'Russia', 'en'),
(9, 9, 'Uncategorized', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20170418090503'),
('20170418131342'),
('20170419164357'),
('20170420195016'),
('20170420223606'),
('20170421110244'),
('20170423212259'),
('20170423212437'),
('20170430155913'),
('20170501102550'),
('20170501132536'),
('20170501141417'),
('20170501154347'),
('20170502000145'),
('20170510213839'),
('20170510231830'),
('20170510233847');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `useragent` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `date_subscribed` datetime NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `country_id`, `email`, `ip`, `useragent`, `date_subscribed`, `status`) VALUES
(1, NULL, 'djordjestojilljkovic@gmail.com', '178.220.204.22', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0 Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:42.0) Gecko/20100101 Firefox/42.0.', '2017-05-10 00:00:00', 1),
(3, 5, 'bulgaria@email.com', '21.1212.2121', 'awodwakdwakdawkodkwao', '2017-05-11 01:02:02', 1),
(4, 8, 'Ruski@emal.co', '20919240', 'kldaklaklkalwakdwl', '2017-05-11 01:09:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `is_deleted` smallint(6) NOT NULL,
  `order_number` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `image`, `status`, `is_deleted`, `order_number`, `link`) VALUES
(1, NULL, 1, 0, 0, '#sr'),
(2, NULL, 1, 0, 0, 'dd');

-- --------------------------------------------------------

--
-- Table structure for table `page_translation`
--

CREATE TABLE `page_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page_translation`
--

INSERT INTO `page_translation` (`id`, `translatable_id`, `title`, `content`, `seo_title`, `seo_description`, `seo_keywords`, `locale`) VALUES
(1, 1, 'Page title on Englishs', '<p>Page description on English</p>', 'SEO on EN', 'SEO Desc EN', 'SEO Keys \\EN', 'en'),
(2, 1, 'Име странице на руском', '<p>Руски језик превод</p>', 'СЕО Руски', 'СЕО опис', 'СЕО Речи', 'ru'),
(3, 1, 'Sradawdawd', '<p>awdawdawdawd</p>', 'awdawd', 'awdawd', 'dawadwadw', 'sr'),
(4, 2, 'adwawd', '<p>dawdwadwdaw</p>', 'awddawdawdaw', 'dawadwadw', 'waadwdaadwadw', 'en'),
(5, 2, 'dwadwdawdad', '<p>wadwdadawdadadwadwadwdadawdadadwadwadwdadawdadadwadwadwdadawdadadwadwadwdadawdadadwadwadwdadawdadadwadwadwdadawdadadwadwadwdadawdadadwad</p>', 'adawawd', 'wadwdadawdadadwad', 'wadwdadawdadadwad', 'sr'),
(6, 2, 'dwawddwadwa', 'dddd', 'ddd', 'dddd', 'dddd', 'ru');

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `municipality_id` int(11) DEFAULT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `map` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `working_hours` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL,
  `social_facebook` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_youtube` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_instagram` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_twitter` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `user_type`, `user_id`, `country_id`, `region_id`, `city_id`, `municipality_id`, `gallery_id`, `map`, `working_hours`, `address`, `phone`, `email`, `website`, `views`, `social_facebook`, `social_youtube`, `social_instagram`, `social_twitter`, `status`, `is_deleted`) VALUES
(1, 1, 1, 2, 1, 1, NULL, NULL, 'dawdwawawd', 'adwdawawdwd', 'awdawwaddwa', '1331312123321', 'awddaw@adadw.com', 'www.test.com', 25, NULL, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `place_translation`
--

CREATE TABLE `place_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `seo_title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `place_translation`
--

INSERT INTO `place_translation` (`id`, `translatable_id`, `title`, `content`, `seo_title`, `seo_description`, `seo_keywords`, `locale`) VALUES
(1, 1, 'Test Item', 'awdawddwadwdaw', 'adwdawdaw', NULL, NULL, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `order_number` int(11) NOT NULL,
  `map` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `status`, `is_deleted`, `order_number`, `map`, `country_id`) VALUES
(1, 1, 0, 0, '53.04635225772446, -26.562500596046448', 9);

-- --------------------------------------------------------

--
-- Table structure for table `region_translation`
--

CREATE TABLE `region_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `region_translation`
--

INSERT INTO `region_translation` (`id`, `translatable_id`, `name`, `locale`) VALUES
(1, 1, 'Uncategorized', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `is_deleted` smallint(6) NOT NULL,
  `order_number` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `status`, `is_deleted`, `order_number`) VALUES
(1, 1, 0, 1),
(2, 1, 0, 2),
(3, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tag_translation`
--

CREATE TABLE `tag_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tag_translation`
--

INSERT INTO `tag_translation` (`id`, `translatable_id`, `title`, `locale`) VALUES
(1, 1, 'Clubing & Lifestyless', 'en'),
(2, 2, 'Beaches no more', 'en'),
(3, 3, 'Test tag', 'en'),
(4, 1, 'Srpski tag', 'sr'),
(5, 1, 'Ruski tag', 'ru');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username_canonical` varchar(180) NOT NULL,
  `email_canonical` varchar(180) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:array)',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `username_canonical`, `email_canonical`, `enabled`, `salt`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `first_name`, `last_name`, `is_deleted`) VALUES
(1, 'djordjeadmin', 'djordjestojilljkovic@gmail.com', '$2y$13$a8NnPaP.GerWDx6hPhm0seEaj1Ywg3tY9I8T.RiB0ztfTt74BS7tO', 'djordjeadmin', 'djordjestojilljkovic@gmail.com', 1, NULL, '2017-05-11 14:10:49', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'Djordje ', 'Stojiljkovic', 0),
(2, 'username', 'mejl@mejl', '$2y$13$WHB7TWLw5w7jz6fT6thoX.Hn/5H1nxLw2eR/RZFTkC0dssxrrA7aO', 'username', 'mejl@mejl', 1, NULL, '2017-04-19 22:19:27', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'sdawdawdawd', 'Ruta', 0),
(3, 'metropolitan', 'metropolitan@gmail.com', '$2y$13$qoU5Pzpouwx31ZXUqERMk.qS5QrLg8km6UMpAmiJ8vxFJ42eYHQTe', 'metropolitan', 'metropolitan@gmail.com', 1, NULL, NULL, NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'Demo', 'Korisnik', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_translation`
--
ALTER TABLE `category_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_3F207042C2AC5D3` (`translatable_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2D5B023498260155` (`region_id`);

--
-- Indexes for table `city_translation`
--
ALTER TABLE `city_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_97DD5B602C2AC5D3` (`translatable_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_translation`
--
ALTER TABLE `country_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_A1FE6FA42C2AC5D3` (`translatable_id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_translation`
--
ALTER TABLE `page_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_A3D51B1D2C2AC5D3` (`translatable_id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_translation`
--
ALTER TABLE `place_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `place_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_BA9C0DCB2C2AC5D3` (`translatable_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F62F176F92F3E70` (`country_id`);

--
-- Indexes for table `region_translation`
--
ALTER TABLE `region_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `region_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_634570B52C2AC5D3` (`translatable_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_translation`
--
ALTER TABLE `tag_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_A8A03F8F2C2AC5D3` (`translatable_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `category_translation`
--
ALTER TABLE `category_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `city_translation`
--
ALTER TABLE `city_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `country_translation`
--
ALTER TABLE `country_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `page_translation`
--
ALTER TABLE `page_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `place_translation`
--
ALTER TABLE `place_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `region_translation`
--
ALTER TABLE `region_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tag_translation`
--
ALTER TABLE `tag_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_translation`
--
ALTER TABLE `category_translation`
  ADD CONSTRAINT `FK_3F207042C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `FK_2D5B023498260155` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`);

--
-- Constraints for table `city_translation`
--
ALTER TABLE `city_translation`
  ADD CONSTRAINT `FK_97DD5B602C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `city` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `country_translation`
--
ALTER TABLE `country_translation`
  ADD CONSTRAINT `FK_A1FE6FA42C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `country` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_translation`
--
ALTER TABLE `page_translation`
  ADD CONSTRAINT `FK_A3D51B1D2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `page` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `place_translation`
--
ALTER TABLE `place_translation`
  ADD CONSTRAINT `FK_BA9C0DCB2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `place` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `FK_F62F176F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Constraints for table `region_translation`
--
ALTER TABLE `region_translation`
  ADD CONSTRAINT `FK_634570B52C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `region` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_translation`
--
ALTER TABLE `tag_translation`
  ADD CONSTRAINT `FK_A8A03F8F2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

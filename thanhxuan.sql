-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2017 at 12:03 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thanhxuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `txd_advs`
--

CREATE TABLE `txd_advs` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_dimension` varchar(255) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `url_path` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text NOT NULL,
  `code` text NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `time_limited` tinyint(1) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_advs`
--

INSERT INTO `txd_advs` (`id`, `image_name`, `image_dimension`, `position`, `url_path`, `status`, `type`, `title`, `summary`, `code`, `created_date`, `updated_date`, `start_time`, `end_time`, `time_limited`, `lang`, `creator`, `editor`) VALUES
(1, 'boxtelc3dc1_25ba1.png', '1224x938', 1, '', 1, 3, '', '', '', '2015-12-17 05:01:41', '2015-12-21 15:45:29', 0, 0, 0, 'vi', 1, 1),
(2, 'dongycotruyen_2287a.jpg', '277x196', 1, '', 1, 4, '', '', '', '2015-12-17 06:35:05', '2016-01-18 14:14:35', 0, 0, 0, 'vi', 1, 1),
(3, 'sanphamlamdep11f481_1990c.png', '274x190', 1, '', 1, 5, '', '', '', '2015-12-17 07:35:44', '2016-01-16 10:47:16', 0, 0, 0, 'vi', 1, 1),
(4, 'sanphamsuckhoe11f511_199c5.png', '278x194', 1, '', 1, 6, '', '', '', '2015-12-17 07:35:53', '2016-01-16 10:49:01', 0, 0, 0, 'vi', 1, 1),
(5, 'homecross_11ffa.png', '931x130', 1, '', 1, 7, '', '', '', '2015-12-17 07:37:23', '2015-12-17 07:37:23', 0, 0, 0, 'vi', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_advs_categories`
--

CREATE TABLE `txd_advs_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dimension` varchar(255) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_advs_categories`
--

INSERT INTO `txd_advs_categories` (`id`, `title`, `dimension`, `lang`, `creator`, `editor`) VALUES
(7, 'Banner ngang', '', 'vi', 1, 0),
(3, 'Box tư vấn', '300x230', 'vi', 1, 0),
(4, 'Box sản phẩm 1', '', 'vi', 1, 0),
(5, 'Box sản phẩm 2', '', 'vi', 1, 0),
(6, 'Box sản phẩm 3', '', 'vi', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `txd_advs_click`
--

CREATE TABLE `txd_advs_click` (
  `id` int(11) NOT NULL,
  `advs_id` int(11) NOT NULL,
  `click_time` int(11) NOT NULL,
  `backlink` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `current_ip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_ci_sessions`
--

CREATE TABLE `txd_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_ci_sessions`
--

INSERT INTO `txd_ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('2ebcc71d35d4f3c1565e6b2abec4a04c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0', 1495447305, 'a:1:{s:13:"cart_contents";a:3:{s:32:"8e296a067a37563370ded05f5a3bf3ec";a:11:{s:5:"rowid";s:32:"8e296a067a37563370ded05f5a3bf3ec";s:2:"id";s:2:"25";s:3:"qty";s:1:"4";s:5:"price";s:6:"275000";s:4:"name";s:30:"Trị sâu răng, Hôi miệng";s:8:"cat_name";s:22:"Đông y cổ truyền";s:6:"cat_id";s:1:"2";s:6:"images";s:31:"trisauranghoimieng_25_22cd6.jpg";s:4:"size";s:0:"";s:4:"slug";s:27:"tri-sau-rang-hoi-mieng.html";s:8:"subtotal";i:1100000;}s:11:"total_items";i:4;s:10:"cart_total";i:1100000;}}'),
('67abb2a09cce92004c220227abffaded', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0', 1495440397, ''),
('b2ca204520653444b7a117cd1ffdbaa1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36', 1495442485, ''),
('ece45944e3007b7e5799f68fd38db317', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36', 1495443024, 'a:1:{s:9:"user_data";s:0:"";}'),
('9bc53a551226e66a2549b51939ef19c1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0', 1495446281, '');

-- --------------------------------------------------------

--
-- Table structure for table `txd_configuration`
--

CREATE TABLE `txd_configuration` (
  `id` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL DEFAULT 'vi',
  `contact_email` varchar(500) DEFAULT NULL,
  `order_email` varchar(500) DEFAULT NULL,
  `meta_title` varchar(500) DEFAULT NULL,
  `meta_keywords` varchar(500) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `favicon` varchar(500) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `news_per_page` smallint(6) DEFAULT NULL,
  `products_per_page` smallint(6) DEFAULT NULL,
  `number_products_per_home` smallint(6) NOT NULL,
  `number_news_per_home` smallint(6) NOT NULL,
  `number_news_per_side` smallint(6) NOT NULL,
  `products_side_per_page` smallint(6) DEFAULT NULL,
  `image_per_page` smallint(6) DEFAULT NULL,
  `google_tracker` text,
  `webmaster_tracker` text,
  `order_email_content` text,
  `footer_infomation` text NOT NULL,
  `footer_contact` text NOT NULL,
  `footer_logo` varchar(500) NOT NULL,
  `footer_link_list` text NOT NULL,
  `company_infomation` text NOT NULL,
  `contact_infomation` text NOT NULL,
  `google_map_code` text NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `number_products_per_side` int(11) NOT NULL DEFAULT '1',
  `editor` int(11) NOT NULL DEFAULT '0',
  `slogan` varchar(500) DEFAULT NULL,
  `pay_bank` longtext NOT NULL,
  `pay_people` longtext NOT NULL,
  `pay_info` longtext NOT NULL,
  `success_order` longtext NOT NULL,
  `livechat` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_configuration`
--

INSERT INTO `txd_configuration` (`id`, `lang`, `contact_email`, `order_email`, `meta_title`, `meta_keywords`, `meta_description`, `favicon`, `logo`, `news_per_page`, `products_per_page`, `number_products_per_home`, `number_news_per_home`, `number_news_per_side`, `products_side_per_page`, `image_per_page`, `google_tracker`, `webmaster_tracker`, `order_email_content`, `footer_infomation`, `footer_contact`, `footer_logo`, `footer_link_list`, `company_infomation`, `contact_infomation`, `google_map_code`, `telephone`, `facebook_id`, `number_products_per_side`, `editor`, `slogan`, `pay_bank`, `pay_people`, `pay_info`, `success_order`, `livechat`) VALUES
(1, 'vi', 'tson171192@gmail.com', 'tson171192@gmail.com', 'Sức khỏe - Sắc Đẹp - Thanh Xuân Dược', '', 'Thanh Xuân Dược - Cung cấp các sản phẩm làm đẹp, sức khỏe tốt nhất. Thanh xuân dược cam kết mang lại sức khỏe và sức đẹp cho bạn', 'icon_1b32a.jpg', 'logo_24dec.png', 6, 12, 4, 0, 5, 0, 10, '', '', '<p>Xin k&iacute;nh ch&agrave;o qu&yacute; kh&aacute;ch: <strong>{ten_nguoi_dat}</strong></p>\r\n<p>Xin ch&uacute;c mừng qu&yacute; kh&aacute;ch đ&atilde; đặt h&agrave;ng th&agrave;nh c&ocirc;ng đơn h&agrave;ng:</p>\r\n<ul>\r\n<li>M&atilde; số đơn h&agrave;ng: <strong>{ma_don_hang}</strong></li>\r\n<li>Thời gian đặt h&agrave;ng: Ng&agrave;y <strong>{ngay_dat}</strong>, v&agrave;o l&uacute;c <strong>{gio_dat}</strong></li>\r\n<li>Địa chỉ: <strong>{dia_chi}</strong></li>\r\n<li>Điện thoại li&ecirc;n hệ: <strong>{dien_thoai}</strong></li>\r\n<li>Email li&ecirc;n hệ: <strong>{email}</strong></li>\r\n</ul>\r\n<p>Đơn h&agrave;ng:</p>\r\n<p>{danh_sach_san_pham}</p>\r\n<p>C&aacute;c tư vấn vi&ecirc;n sẽ li&ecirc;n lạc lại với bạn trong thời gian gần nhất.</p>\r\n<p>&nbsp;</p>', '0', '<p><strong>C&ocirc;ng ty TNHH Quốc Tế Eros</strong></p>\r\n<p>Địa chỉ: &Ocirc; 29 L&ocirc; 6 Đền Lừ 2, Ho&agrave;ng Văn Thụ, Ho&agrave;ng Mai, H&agrave; Nội.</p>\r\n<p>Email:&nbsp;phucanh3386@gmail.com</p>\r\n<p>ĐT: 04 6259 2145</p>\r\n<p>Holine: 094 789 3386 - 0965 613 469</p>', '', '0', '0', '<p><strong>C&ocirc;ng ty TNHH Quốc Tế Eros</strong></p>\r\n<p>Địa chỉ: &Ocirc; 29 L&ocirc; 6 Đền Lừ 2, Ho&agrave;ng Văn Thụ, Ho&agrave;ng Mai, H&agrave; Nội.</p>\r\n<p>Email:&nbsp;phucanh3386@gmail.com</p>\r\n<p>ĐT: 04 6259 2145</p>\r\n<p>Holine: 094 789 3386 - 0965 613 469</p>', '', '0988 258 392', '', 3, 1, '', '0', '0', '0', '<p><strong>Ch&uacute;c mừng bạn đ&atilde; đặt h&agrave;ng th&agrave;nh c&ocirc;ng! Ch&uacute;ng t&ocirc;i sẽ li&ecirc;n lạc với bạn trong thời gian sớm nhất.</strong></p>\r\n<p><strong>Mời bạn&nbsp;<a title="Quay lại trang chủ" href="http://thanhxuanduoc.com/">Click v&agrave;o đ&acirc;y</a> để quay lại trang chủ.</strong></p>', ''),
(2, 'en', '', '0', '', '', '', NULL, '', 6, 3, 3, 0, 6, 5, 10, '', '', '0', '', '', '', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `txd_contact`
--

CREATE TABLE `txd_contact` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL,
  `current_ip` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_customers`
--

CREATE TABLE `txd_customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `DOB` datetime DEFAULT NULL COMMENT 'Date Of Birth',
  `address` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL COMMENT '	',
  `company` varchar(256) DEFAULT NULL,
  `roles_id` int(11) DEFAULT NULL,
  `active` smallint(1) DEFAULT '1',
  `alias_name` varchar(15) DEFAULT NULL,
  `cities_id` int(11) NOT NULL,
  `joined_date` datetime DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `is_openid` tinyint(4) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL COMMENT 'Giới tính.',
  `city_id` tinyint(4) DEFAULT NULL COMMENT 'thành phố',
  `district_id` tinyint(4) DEFAULT NULL COMMENT 'Quận/huyện',
  `number_house` varchar(256) DEFAULT NULL COMMENT 'Số nhà, ngõ ngách',
  `road` varchar(256) DEFAULT NULL COMMENT 'Đường',
  `level` varchar(256) DEFAULT NULL COMMENT 'Lầu',
  `type` tinyint(4) DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_download`
--

CREATE TABLE `txd_download` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `ext` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(500) NOT NULL,
  `type` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_download_categories`
--

CREATE TABLE `txd_download_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_faq`
--

CREATE TABLE `txd_faq` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `cat_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `tags` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_faq_categories`
--

CREATE TABLE `txd_faq_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_faq_professionals`
--

CREATE TABLE `txd_faq_professionals` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_gallery`
--

CREATE TABLE `txd_gallery` (
  `id` int(11) NOT NULL,
  `gallery_name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `summary` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `position` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_gallery_categories`
--

CREATE TABLE `txd_gallery_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_gallery_images`
--

CREATE TABLE `txd_gallery_images` (
  `id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `caption` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_menus`
--

CREATE TABLE `txd_menus` (
  `id` int(11) NOT NULL,
  `caption` varchar(256) NOT NULL,
  `url_path` varchar(512) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `level` tinyint(4) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(1) DEFAULT '1',
  `css` varchar(50) DEFAULT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_menus`
--

INSERT INTO `txd_menus` (`id`, `caption`, `url_path`, `parent_id`, `level`, `cat_id`, `position`, `active`, `css`, `thumbnail`, `lang`, `creator`, `editor`, `private`) VALUES
(1, 'Dashboard', '/dashboard', 0, 0, 2, 2, 1, 'fa-dashboard', '', 'vi', 0, 0, 0),
(3, 'Thêm sản phẩm', '/dashboard/products/add', 55, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(4, 'Tất cả sản phẩm', '/dashboard/products', 55, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(11, 'Phân loại sản phẩm', '/dashboard/products/cat', 55, 1, 2, 3, 1, '', '', 'vi', 0, 0, 0),
(14, 'Bài viết', '/dashboard/news', 0, 0, 2, 3, 1, 'fa-file-text', '', 'vi', 0, 0, 0),
(38, 'Hệ thống Menu', '/dashboard/menus', 101, 1, 2, 4, 1, '', '', 'vi', 0, 1, 0),
(43, 'Hỗ trợ trực tuyến', '/dashboard/supports', 101, 1, 2, 3, 1, '', '', 'vi', 0, 0, 0),
(45, 'Phân loại bài viết', '/dashboard/news/cat', 14, 1, 2, 3, 1, '', '', 'vi', 0, 0, 0),
(46, 'Banner quảng cáo', '/dashboard/advs', 101, 1, 2, 2, 1, '', '', 'vi', 0, 1, 0),
(50, 'Trang', '/dashboard/pages', 0, 0, 2, 7, 1, 'fa-puzzle-piece', '', 'vi', 0, 0, 0),
(55, 'Sản phẩm', '/dashboard/products', 0, 0, 2, 4, 1, 'fa-gift', '', 'vi', 0, 0, 0),
(62, 'Thêm bài viết', '/dashboard/news/add', 14, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(87, 'Thay đổi mật khẩu', '/dashboard/auth/change_password', 100, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(99, 'Cấu hình chung', '/dashboard/system_config', 100, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(100, 'Cài đặt', '#', 0, 0, 2, 19, 1, 'fa-cog', '', 'vi', 0, 0, 0),
(101, 'Giao diện', '#', 0, 0, 2, 18, 1, 'fa-pencil', '', 'vi', 0, 0, 0),
(152, 'Trang chủ', '/', 0, 0, 2, 1, 1, 'fa-home', '', 'vi', 0, 1, 0),
(151, 'Tất cả liên hệ', '/dashboard/contact', 150, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(150, 'Liên hệ/Phản hồi', '/dashboard/contact', 0, 0, 2, 11, 1, 'fa-phone', '', 'vi', 0, 1, 0),
(224, 'Phân loại tranh ảnh', '/dashboard/gallery/cat', 221, 1, 2, 3, 1, '', '', 'vi', 0, 0, 0),
(223, 'Thêm tranh ảnh', '/dashboard/gallery/add', 221, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(123, 'Đơn vị', '/dashboard/products/units', 55, 1, 2, 4, 0, '', '', 'vi', 0, 0, 0),
(126, 'Tất cả bài viết', '/dashboard/news', 14, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(127, 'Tất cả trang tin', '/dashboard/pages', 50, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(128, 'Thêm trang tin', '/dashboard/pages/add', 50, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(129, 'Tất cả menu', '/dashboard/menus', 38, 2, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(130, 'Thêm menu', '/dashboard/menus/add', 38, 2, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(131, 'Phân loại menu', '/dashboard/menus/cat', 38, 2, 2, 3, 0, '', '', 'vi', 0, 0, 0),
(132, 'Tất cả banner', '/dashboard/advs', 46, 2, 2, 4, 1, '', '', 'vi', 0, 0, 0),
(133, 'Thêm banner', '/dashboard/advs/add', 46, 2, 2, 5, 1, '', '', 'vi', 0, 0, 0),
(134, 'Phân loại banner', '/dashboard/advs/cat', 46, 2, 2, 6, 0, '', '', 'vi', 0, 0, 0),
(135, 'Tất cả hỗ trợ', '/dashboard/supports', 43, 2, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(136, 'Thêm hỗ trợ', '/dashboard/supports/add', 43, 2, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(175, 'Tài liệu', '/dashboard/download', 0, 0, 2, 12, 0, 'fa-download', '', 'vi', 0, 1, 0),
(222, 'Tất cả tranh ảnh', '/dashboard/gallery', 221, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(221, 'Tranh ảnh', '/dashboard/gallery', 0, 0, 2, 13, 0, 'fa-dashboard', '', 'vi', 0, 0, 0),
(199, 'Tất cả Tài liệu', '/dashboard/download', 175, 1, 2, 1, 1, '', '', 'vi', 0, 1, 0),
(200, 'Phân loại Tài liệu', '/dashboard/download/cat', 175, 1, 2, 3, 1, '', '', 'vi', 0, 1, 0),
(225, 'Thêm Tài liệu', '/dashboard/download/add', 175, 1, 2, 2, 1, '', '', 'vi', 0, 1, 0),
(311, 'Hỏi đáp', '/dashboard/faq', 0, 0, 2, 10, 0, 'fa-question', '', 'vi', 0, 0, 0),
(312, 'Tất cả hỏi đáp', '/dashboard/faq', 311, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(313, 'Thêm hỏi đáp', '/dashboard/faq/add', 311, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(314, 'Phân loại hỏi đáp', '/dashboard/faq/cat', 311, 1, 2, 3, 1, '', '', 'vi', 0, 0, 0),
(632, 'Videos', '/dashboard/videos', 0, 0, 2, 14, 0, 'fa-youtube', '', 'vi', 0, 0, 0),
(633, 'Tất cả Videos', '/dashboard/videos', 632, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(634, 'Thêm Videos', '/dashboard/videos/add', 632, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(635, 'Phân loại Videos', '/dashboard/videos/cat', 632, 1, 2, 3, 1, '', '', 'vi', 0, 0, 0),
(636, 'Người dùng', '/dashboard/auth', 0, 0, 2, 17, 1, 'fa-users', '', 'vi', 0, 0, 0),
(637, 'Tất cả người dùng', '/dashboard/auth', 636, 1, 2, 1, 1, '', '', 'vi', 0, 0, 0),
(638, 'Thêm người dùng', '/dashboard/auth/add', 636, 1, 2, 2, 1, '', '', 'vi', 0, 0, 0),
(674, 'Vai trò', '/dashboard/auth/roles', 636, 1, 2, 3, 1, '', '', 'vi', 1, 1, 0),
(683, 'Màu sắc', '/dashboard/products/color', 55, 1, 2, 7, 0, '', '', 'vi', 1, 1, 0),
(712, 'Chuyên gia tư vấn', '/dashboard/faq/pro', 311, 1, 2, 4, 1, '', '', 'vi', 1, 1, 0),
(713, 'Thương hiệu', '/dashboard/products/trademark', 55, 1, 2, 5, 0, '', '', 'vi', 1, 1, 0),
(714, 'Xuất xứ', '/dashboard/products/origin', 55, 1, 2, 6, 0, '', '', 'vi', 1, 1, 0),
(715, 'Trang chủ', '/', 0, 0, 1, 1, 1, '', '', 'vi', 1, 1, 0),
(717, 'Đông Y', '/dong-y-co-truyen', 0, 0, 1, 3, 1, '', '', 'vi', 1, 1, 0),
(718, 'Làm đẹp', '/tu-van-lam-dep', 0, 0, 1, 4, 1, '', '', 'vi', 1, 1, 0),
(719, 'Đặt mua hàng', '/san-pham', 0, 0, 1, 7, 1, '', '', 'vi', 1, 1, 0),
(720, 'Câu hỏi thường gặp', '/cau-hoi-thuong-gap', 0, 0, 1, 6, 1, '', '', 'vi', 1, 1, 0),
(721, 'Giỏ hàng', '/gio-hang', 0, 0, 1, 8, 1, '', '', 'vi', 1, 1, 0),
(728, 'Đơn hàng', '/dashboard/orders', 0, 0, 2, 15, 1, 'fa-bar-chart-o', '', 'vi', 1, 1, 0),
(729, 'Khách hàng', '/dashboard/customers', 0, 0, 2, 16, 1, 'fa-users', '', 'vi', 1, 1, 0),
(771, 'Tất cả mã coupon', '/dashboard/products/coupon_item', 745, 2, 2, 1, 0, '', '', 'vi', 1, 1, 0),
(742, 'Kích cỡ', '/dashboard/products/size', 55, 1, 2, 8, 0, '', '', 'vi', 1, 1, 0),
(743, 'Chất liệu', '/dashboard/products/material', 55, 1, 2, 9, 0, '', '', 'vi', 1, 1, 0),
(744, 'Kiểu dáng', '/dashboard/products/style', 55, 1, 2, 10, 0, '', '', 'vi', 1, 1, 0),
(745, 'Mã coupon', '/dashboard/products/coupon', 55, 1, 2, 11, 0, '', '', 'vi', 1, 1, 0),
(746, 'Thoái hóa khớp gối', '#', 0, 0, 6, 1, 1, '', '', 'vi', 1, 1, 0),
(747, 'Thoái hóa khớp gối', '#', 0, 0, 6, 2, 1, '', '', 'vi', 1, 1, 0),
(748, 'Thoái hóa khớp gối', '#', 0, 0, 6, 3, 1, '', '', 'vi', 1, 1, 0),
(749, 'Thoái hóa khớp gối', '#', 0, 0, 6, 4, 1, '', '', 'vi', 1, 1, 0),
(750, 'Thoái hóa khớp gối', '#', 0, 0, 6, 5, 1, '', '', 'vi', 1, 1, 0),
(751, 'Thoái hóa khớp gối', '#', 0, 0, 6, 6, 1, '', '', 'vi', 1, 1, 0),
(752, 'Thoái hóa khớp gối', '#', 0, 0, 6, 7, 1, '', '', 'vi', 1, 1, 0),
(753, 'Thoái hóa khớp gối', '#', 0, 0, 6, 8, 1, '', '', 'vi', 1, 1, 0),
(754, 'Điều khoản chung', '#', 0, 0, 7, 1, 1, '', '', 'vi', 1, 1, 0),
(755, 'Thanh toán', '#', 0, 0, 7, 2, 1, '', '', 'vi', 1, 1, 0),
(756, 'Vận chuyển - giao hàng', '#', 0, 0, 7, 3, 1, '', '', 'vi', 1, 1, 0),
(757, 'Bảo hành - đổi trả hàng', '#', 0, 0, 7, 4, 1, '', '', 'vi', 1, 1, 0),
(758, 'Bảo mật thông tin', '#', 0, 0, 7, 5, 1, '', '', 'vi', 1, 1, 0),
(780, 'Sức khỏe', '/suc-khoe', 0, 0, 5, 5, 1, '', '', 'vi', 1, 1, 0),
(779, 'Làm đẹp', '/lam-dep', 0, 0, 5, 4, 1, '', '', 'vi', 1, 1, 0),
(778, 'Giảm cân', '/giam-can', 0, 0, 5, 3, 1, '', '', 'vi', 1, 1, 0),
(777, 'Tin tức', '/tin-tuc', 0, 0, 5, 2, 1, '', '', 'vi', 1, 1, 0),
(776, 'Trang chủ', '/', 0, 0, 5, 1, 1, '', '', 'vi', 1, 1, 0),
(770, 'Sức khỏe', '/tu-van-suc-khoe', 0, 0, 1, 5, 1, '', '', 'vi', 1, 1, 0),
(772, 'Liên hệ', '/lien-he', 0, 0, 1, 9, 1, '', '', 'vi', 1, 1, 0),
(781, 'Đặt mua hàng', '/dat-mua-hang', 0, 0, 5, 6, 1, '', '', 'vi', 1, 1, 0),
(782, 'Hướng dẫn mua hàng', '/huong-dan-mua-hang.html', 0, 0, 5, 7, 1, '', '', 'vi', 1, 1, 0),
(783, 'Câu hỏi thường gặp', '/cau-hoi-thuong-gap', 0, 0, 5, 8, 1, '', '', 'vi', 1, 1, 0),
(784, 'Liên hệ', '/lien-he', 0, 0, 5, 9, 1, '', '', 'vi', 1, 1, 0),
(785, 'Trà figura 2', '#', 0, 0, 6, 9, 1, '', '', 'vi', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `txd_menus_categories`
--

CREATE TABLE `txd_menus_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_menus_categories`
--

INSERT INTO `txd_menus_categories` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(1, 'Menu Phía trên', 1, 0, 1),
(2, 'Menu quản trị', 1, 0, 0),
(3, 'Menu Bên trái', 0, 0, 1),
(4, 'Menu Bên phải', 0, 0, 1),
(5, 'Menu cuối trang 1', 1, 0, 1),
(6, 'Menu cuối trang 2', 1, 1, 1),
(7, 'Menu cuối trang 3', 1, 1, 1),
(8, 'Menu cuối trang 4', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_news`
--

CREATE TABLE `txd_news` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  `content` text,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `viewed` int(11) DEFAULT '0',
  `thumbnail` varchar(500) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `lang` varchar(20) DEFAULT 'vi',
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `startups` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `txd_news`
--

INSERT INTO `txd_news` (`id`, `title`, `summary`, `content`, `created_date`, `updated_date`, `cat_id`, `position`, `viewed`, `thumbnail`, `city_id`, `meta_title`, `meta_keywords`, `meta_description`, `tags`, `lang`, `status`, `home`, `startups`, `creator`, `editor`) VALUES
(57, 'Cách chăm sóc da nhờn, mụn đúng cách', 'Da nhờn không chỉ khiến bạn mất tự tin mà nó còn là nguyên nhân khiến bạn dễ bị nổi mụn. Hãy tham khảo những bước chăm sóc da nhờn dưới đây của làm đẹp da để khắc phục tình trạng da dầu nhé!', '<p style="text-align: justify;">Da nhờn kh&ocirc;ng chỉ khiến bạn mất tự tin m&agrave; n&oacute; c&ograve;n l&agrave; nguy&ecirc;n nh&acirc;n khiến bạn dễ bị nổi mụn. H&atilde;y tham khảo những bước chăm s&oacute;c da nhờn dưới đ&acirc;y của l&agrave;m đẹp da để khắc phục t&igrave;nh trạng da dầu nh&eacute;!</p>\n<h2 style="text-align: justify;">L&agrave;m thế n&agrave;o để kiểm so&aacute;t da nhờn?</h2>\n<p style="text-align: justify;">L&agrave; một nguy&ecirc;n nh&acirc;n g&acirc;y ra mụn nhưng chất nhờn lại c&oacute; vai tr&ograve; quan trọng đối với da, n&oacute; gi&uacute;p l&agrave;m ẩm v&agrave; b&ocirc;i trơn da đồng thời thải ra những chất bẩn v&agrave; c&aacute;c tế b&agrave;o da chết ứ đọng trong th&agrave;nh của lỗ ch&acirc;n l&ocirc;ng. V&igrave; vậy c&aacute;ch chăm s&oacute;c tốt nhất đối với da nhờn kh&ocirc;ng phải l&agrave; l&agrave;m sạch chất nhờn tr&ecirc;n da m&agrave; l&agrave; giữ cho lỗ ch&acirc;n l&ocirc;ng lu&ocirc;n tho&aacute;ng v&agrave; ngăn chặn sự h&igrave;nh th&agrave;nh của mụn.<br />Chất nhờn v&agrave; bụi bẩn kh&ocirc;ng phải l&agrave; nguy&ecirc;n nh&acirc;n trực tiếp của mụn như bạn nghĩ, nhưng nếu ch&uacute;ng xuất hiện qu&aacute; nhều sẽ g&acirc;y b&iacute;t lỗ ch&acirc;n l&ocirc;ng v&agrave; gi&aacute;n tiếp tạo n&ecirc;n mụn. V&igrave; vậy rửa mặt đ&uacute;ng c&aacute;ch l&agrave; một phương ph&aacute;p ngừa mụn hiệu quả v&agrave; cần thiết. Sử dụng c&aacute;c loại sữa rửa mặt c&oacute; chất tẩy mạnh hay nước qu&aacute; n&oacute;ng kh&ocirc;ng hề l&agrave;m giảm mụn m&agrave; tr&aacute;i lại n&oacute; l&agrave;m da bạn trở n&ecirc;n kh&ocirc; v&agrave; xấu đi. Hầu hết c&aacute;c loại sữa rửa mặt trị mụn đều l&agrave;m kh&ocirc; da bạn, khiến bạn kh&ocirc;ng sử dụng hiệu quả c&aacute;c loại kem trị mụn thực sự c&oacute; t&aacute;c dụng.</p>\n<h2 style="text-align: justify;">Mặt nạ cho da nhờn</h2>\n<p style="text-align: justify;"><img src="http://1.bp.blogspot.com/-_WtdUCMubbQ/UqWSBZQyOWI/AAAAAAAAAJY/YUbIblwf4LQ/s1600/mat-na-cho-da-nhon.jpg" alt="" border="0" /><br /><br />T&aacute;o v&agrave; mật ong: Bạn c&oacute; thể chọn một quả t&aacute;o cỡ trung b&igrave;nh, rửa sạch, nghiền nhỏ bằng một m&aacute;y xay sinh tố. Đổ 5 muỗng canh mật ong v&agrave;o v&agrave; bắt đầu trộn đều. &Aacute;p dụng hỗn hợp n&agrave;y l&ecirc;n mặt v&agrave; cổ. Sau 10 ph&uacute;t, rửa sạch mặt bằng nước lạnh.<br />Nước cốt chanh v&agrave; l&ograve;ng trắng trứng g&agrave;: D&ugrave;ng 2 th&igrave;a c&agrave; ph&ecirc; nước cốt chanh trộn thật đều với 1 l&ograve;ng trắng trứng g&agrave;. D&ugrave;ng hỗn hợp n&agrave;y thoa l&ecirc;n mặt. Sau 15-20 ph&uacute;t, rửa sạch da với nước ấm. Nước cốt chanh v&agrave; l&ograve;ng trắng trứng gi&uacute;p l&agrave;m sạch c&aacute;c bụi bẩn v&agrave; chất nhờn tr&ecirc;n da mặt, l&agrave;m se kh&iacute;t c&aacute;c lỗ ch&acirc;n l&ocirc;ng.<br />Khoai t&acirc;y, sữa chua v&agrave; bạc h&agrave;: Trộn đều 20g khoai t&acirc;y đ&atilde; luộc ch&iacute;n với 2 th&igrave;a sữa chua v&agrave; 2 th&igrave;a tinh dầu bạc h&agrave;. Đắp đều l&ecirc;n da sau đ&oacute; rửa lại bằng nước sạch. Sữa chua gi&uacute;p l&agrave;m trắng v&agrave; l&agrave;m mềm da. Tinh dầu bạc h&agrave; mang lại cảm gi&aacute;c m&aacute;t mẻ cho da, gi&uacute;p l&agrave;m sạch da v&agrave; se lỗ ch&acirc;n l&ocirc;ng. Khoai t&acirc;y gi&uacute;p da mịn m&agrave;ng.<br /><img src="http://4.bp.blogspot.com/-8kx5iJyODUE/UqWSYrmnE3I/AAAAAAAAAJg/pImY88lVJIU/s1600/mat-na-cho-da-nhon1.jpg" alt="" border="0" /><br /><br />D&acirc;u t&acirc;y, mật ong v&agrave; bột m&igrave;: Nghiền nhỏ 2 quả d&acirc;u t&acirc;y. Cho th&ecirc;m 1 th&igrave;a c&agrave; ph&ecirc; mật ong, 1 th&igrave;a c&agrave; ph&ecirc; bột m&igrave;. Trộn đều hỗn hợp. Rửa sạch mặt, d&ugrave;ng khăn b&ocirc;ng lau kh&ocirc; rồi đắp hỗn hợp l&ecirc;n mặt. Sau 15 ph&uacute;t, rửa mặt bằng nước ấm. D&acirc;u t&acirc;y gi&uacute;p thanh lọc c&aacute;c độc tố dưới da. Vitamin C gi&uacute;p kh&ocirc;i phục độ s&aacute;ng b&oacute;ng của l&agrave;n da. Bột m&igrave; c&oacute; t&aacute;c dụng h&uacute;t ẩm.<br />C&agrave; chua, mật ong: D&ugrave;ng 100g c&agrave; chua &eacute;p lấy nước. Cho th&ecirc;m 1 th&igrave;a mật ong, trộn đều. B&ocirc;i hỗn hợp l&ecirc;n da mặt rồi m&aacute;t xa nhẹ nh&agrave;ng trong v&ograve;ng 20 ph&uacute;t. Rửa lại bằng nước sạch. C&agrave; chua chứa chất chống oxy h&oacute;a tự nhi&ecirc;n, gi&uacute;p ngăn chặn qu&aacute; tr&igrave;nh l&atilde;o h&oacute;a da. Ngo&agrave;i ra kali v&agrave; vitamin C c&oacute; trong loại quả n&agrave;y gi&uacute;p l&agrave;m giảm lượng dầu tr&ecirc;n da v&agrave; se lỗ ch&acirc;n l&ocirc;ng.</p>\n<h2 style="text-align: justify;">Sử dụng mỹ phẩm cần tu&acirc;n theo thứ tự đ&uacute;ng c&aacute;ch:</h2>\n<p style="text-align: justify;"><br />- Nhẹ nh&agrave;ng rửa mặt sạch sẽ.<br />- B&ocirc;i thuốc trị mụn. Nếu thuốc g&acirc;y cảm gi&aacute;c ch&acirc;m ch&iacute;ch hay bỏng r&aacute;t da, h&atilde;y chờ khoảng 5-15 ph&uacute;t sau khi rửa mặt rồi h&atilde;y b&ocirc;i thuốc.<br />- B&ocirc;i chất giữ ẩm hoặc kem chống nắng.<br />- Trang điểm. Nếu bạn kh&ocirc;ng biết chọn loại sản phẩm trang điểm ph&ugrave; hợp với thuốc trị mụn th&igrave; tham khảo &yacute; kiến b&aacute;c sĩ da liễu.<br />Tr&aacute;nh nắng tối đa trong qu&aacute; tr&igrave;nh điều trị da nhờn<br />N&ecirc;n tr&aacute;nh nắng, nhất l&agrave; khi đang sử dụng thuốc c&oacute; chứa retinoids l&agrave;m cho da nhạy cảm hơn. Tr&aacute;nh nắng bằng c&aacute;ch đeo khẩu trang, đội n&oacute;n, sử dụng kem chống nắng loại d&agrave;nh ri&ecirc;ng cho da nhờn.<br />Đối với nam giới khi cần phải cạo r&acirc;u, cần lưu &yacute;:- Trước khi cạo, n&ecirc;n l&agrave;m mềm r&acirc;u bằng c&aacute;ch rửa mặt bằng nước ấm.- N&ecirc;n thử dao cạo bằng điện hay dao cạo bằng tay để chọn lựa loại th&iacute;ch hợp nhất cho da.- N&ecirc;n chắc chắn l&agrave; lưỡi dao cạo mới, sạch v&agrave; phải sắc b&eacute;n để tr&aacute;nh k&iacute;ch ứng v&agrave; nhiễm tr&ugrave;ng da.- Cạo một c&aacute;ch nhẹ nh&agrave;ng.- Kh&ocirc;ng được cạo trọc mụn.<br /><img src="http://1.bp.blogspot.com/-yILzsnCNunY/UqWSx16ocBI/AAAAAAAAAJo/1LdXw141Ob0/s1600/mat-na-cho-da-nhon2.jpg" alt="" border="0" /></p>\n<h2 style="text-align: justify;">Chế độ ăn uống sinh hoạt hợp l&yacute;</h2>\n<p style="text-align: justify;"><br /><br />Tăng cường uống nhiều nước h&agrave;ng ng&agrave;y, ăn nhiều rau xanh, hoa quả tươi để da lu&ocirc;n đẹp v&agrave; hạn chế nhờn, mụn. Tr&aacute;nh ăn những loại thức ăn dễ g&acirc;y k&iacute;ch ứng nổi mụn như: ớt, ti&ecirc;u, hải sản v&agrave; hạn chế c&aacute;c loại thức ăn c&oacute; nhiều chất b&eacute;o để giảm qu&aacute; tr&igrave;nh tăng tiết b&atilde; nhờn.<br />Ngo&agrave;i chế độ ăn uống, bạn cũng n&ecirc;n lưu &yacute; điều chỉnh chế độ sinh hoạt cho thật khoa học sẽ gi&uacute;p l&agrave;n da giảm nhờn v&agrave; mụn. Ngủ đủ giấc, kh&ocirc;ng thức khuya, hạn chế stress cũng sẽ gi&uacute;p cho t&igrave;nh trạng da nhờn dễ bị nổi mụn của bạn được cải thiện đ&aacute;ng kể.<br /><br />Từ kh&oacute;a google</p>\n<ul>\n<li style="text-align: justify;"></li>\n<li style="text-align: justify;">chăm s&oacute;c da nhờn mụn</li>\n<li style="text-align: justify;">chăm s&oacute;c da nhờn bị mụn</li>\n<li style="text-align: justify;">chăm s&oacute;c da nhờn lỗ ch&acirc;n l&ocirc;ng to</li>\n<li style="text-align: justify;">chăm s&oacute;c da nhờn m&ugrave;a h&egrave;</li>\n<li style="text-align: justify;">chăm s&oacute;c da nhờn đ&uacute;ng c&aacute;ch</li>\n<li style="text-align: justify;">chăm s&oacute;c da nhờn webtretho</li>\n<li style="text-align: justify;">c&aacute;ch chăm s&oacute;c da nhờn bị mụn</li>\n<li style="text-align: justify;">c&aacute;ch chăm s&oacute;c da nhờn v&agrave; mụn</li>\n</ul>', '2015-12-22 16:42:00', '2015-12-22 16:45:01', 7, 3, 105, '/images/source/thumb/cach-cham-soc-da-nhon-mun-dung-cach.jpg', NULL, '', '', '', '', 'vi', 1, 0, 0, 1, 1),
(56, 'Cách làm đẹp da bằng sữa chua', 'Ngoài việc ăn sữa chua hàng ngày, bạn gái hãy tận dụng nó để chế mặt nạ làm đẹp cực hữu hiệu. Sữa chua có khả năng làm trắng da, giảm thiệu mụn và tàn nhan.', '<h2 style="text-align: justify;">Sữa chua rất tốt cho sức khỏe v&agrave; l&agrave;n da, h&atilde;y tận dụng n&oacute; để l&agrave;m đẹp&nbsp;</h2>\n<p style="text-align: justify;">Ngo&agrave;i việc ăn sữa chua h&agrave;ng ng&agrave;y, bạn g&aacute;i h&atilde;y tận dụng n&oacute; để chế mặt nạ l&agrave;m đẹp cực hữu hiệu. Sữa chua c&oacute; khả năng l&agrave;m trắng da, giảm thiệu mụn v&agrave; t&agrave;n nhan... Trong b&agrave;i viết n&agrave;y, ch&uacute;ng t&ocirc;i xin gợi &yacute; những c&ocirc;ng thức chế biến mặt nạ c&oacute; t&aacute;c dụng l&agrave;m s&aacute;ng da từ sữa chua.Với c&aacute;c c&aacute;c kho&aacute;ng chất th&agrave;nh phần như protein, canxi hay sắt, th&igrave; sữa ngo&agrave;i c&ocirc;ng dụng mang đến cho bạn nguồn năng lượng qu&yacute; gi&aacute;, cũng g&oacute;p phần kh&ocirc;ng nhỏ trong &ldquo;c&ocirc;ng cuộc&rdquo; l&agrave;m đẹp của chị em. Điều đ&aacute;ng n&oacute;i ở đ&acirc;y l&agrave; sữa chua kh&ocirc;ng c&oacute; t&aacute;c dụng nhanh v&agrave; mạnh như c&aacute;c sản phẩm h&oacute;a học kh&aacute;c v&igrave; vậy c&aacute;c bạn h&atilde;y thật ki&ecirc;n tr&igrave; để c&oacute; được vẻ đẹp từ trong ra ngo&agrave;i nh&eacute;!</p>\n<table cellspacing="0" cellpadding="0" align="center">\n<tbody>\n<tr>\n<td><img src="http://4.bp.blogspot.com/-87CCtT1oY-k/UqaYtcryaRI/AAAAAAAAAKI/UwxHngvZYeM/s1600/lam-dep-da-voi-sua-chua.jpg" alt="" border="0" /></td>\n</tr>\n<tr>\n<td>L&agrave;m đẹp da mặt với sữa chua</td>\n</tr>\n</tbody>\n</table>\n<h2 style="text-align: justify;">Sữa rửa mặt l&agrave;m trắng</h2>\n<p style="text-align: justify;"><br />Lấy 1/2 cốc sữa tươi, vắt v&agrave;o 7-10 giọt nước cốt chanh rồi khuấy đều. Bạn d&ugrave;ng hỗn hợp n&agrave;y thoa đều rồi massage l&ecirc;n da mặt khoảng 10 ph&uacute;t rồi rửa sạch lại bằng nước m&aacute;t. Nếu bạn muốn sớm c&oacute; l&agrave;n da s&aacute;ng mịn, h&atilde;y chăm chỉ thực hiện 3-4 lần/tuần nh&eacute;!</p>\n<h2 style="text-align: justify;"><br />Sữa chua trị da kh&ocirc; rất tốt</h2>\n<p style="text-align: justify;"><br />Trộn đều 1 ch&eacute;n sữa tươi, 1 ch&eacute;n nước &eacute;p c&agrave; rốt v&agrave; 1 ch&eacute;n nước cam vắt. D&ugrave;ng hỗn hợp thu được b&ocirc;i l&ecirc;n da v&agrave; để trong 15 ph&uacute;t. Sau đ&oacute; rửa lại bằng nước sạch. C&aacute;c dưỡng chất c&oacute; trong lớp mặt nạ sẽ nhanh ch&oacute;ng thẩm thấu v&agrave; cung cấp độ ẩm thiếu hụt, &ldquo;h&ocirc; biến&rdquo; to&agrave;n bộ l&agrave;n da kh&ocirc; r&aacute;p l&uacute;c đầu. Với c&aacute;ch n&agrave;y, bạn n&ecirc;n chăm chỉ thực hiện 2 lần/tuần để c&oacute; được l&agrave;n da như &yacute; nh&eacute;.</p>\n<h2 style="text-align: justify;">L&agrave;m mờ vết t&agrave;n nhang, th&acirc;m, n&aacute;m bằng sữa chua</h2>\n<p style="text-align: justify;"><br />Với những vết t&agrave;n nhang cứng đầu chễm chệ tr&ecirc;n khu&ocirc;n mặt, sữa tươi cũng ch&iacute;nh l&agrave; &ldquo;thần dược&rdquo; m&agrave; bạn t&igrave;m lại vẻ đẹp bấy l&acirc;u nay. Bạn d&ugrave;ng 1 th&igrave;a cafe sữa tươi, 2 th&igrave;a hydrogen peroxide, 3 th&igrave;a cafe bột m&igrave; v&agrave; 3 ch&eacute;n nước, trộn đều để tạo th&agrave;nh hỗn hợp đặc s&aacute;nh. Đắp hỗn hợp n&agrave;y l&ecirc;n mặt v&agrave; để cho kh&ocirc; ho&agrave;n to&agrave;n trong 15 &ndash; 20 ph&uacute;t. Sau đ&oacute; rửa lại mặt bằng nước m&aacute;t v&agrave; thấm kh&ocirc; bằng khăn mềm. Ngo&agrave;i ra, bạn cũng c&oacute; thể xay nhuyễn 2 quả hạnh trộn c&ugrave;ng 1/2 ch&eacute;n sữa tươi v&agrave; l&agrave;m mặt nạ thoa l&ecirc;n da trước khi đi ngủ. C&aacute;c vết th&acirc;m n&aacute;m sẽ nhanh ch&oacute;ng biến mất cho m&agrave; xem.</p>\n<table cellspacing="0" cellpadding="0" align="center">\n<tbody>\n<tr>\n<td><img src="http://4.bp.blogspot.com/-diBpYhJI9-8/UqaZH7P2KoI/AAAAAAAAAKQ/Dfz8jChTroA/s1600/lam-dep-da-voi-sua-chua1.jpg" alt="" border="0" /></td>\n</tr>\n<tr>\n<td>L&agrave;m đẹp da mặt với sữa chua</td>\n</tr>\n</tbody>\n</table>\n<h2 style="text-align: justify;">Tẩy c&aacute;c tế b&agrave;o chết&nbsp;</h2>\n<p style="text-align: justify;"><br />Ngo&agrave;i c&ocirc;ng dụng l&agrave;m trắng da, sữa tươi cũng c&oacute; &ldquo;biệt t&agrave;i&rdquo; trong việc lấy đi c&aacute;c lớp tế b&agrave;o chết cực k&igrave; hiệu quả. Bạn trộn 1 ch&eacute;n muối tinh, 1 th&igrave;a cafe dầu dừa v&agrave; 1 th&igrave;a cafe sữa tươi. D&ugrave;ng tay xoa nhẹ nh&agrave;ng hỗn hợp n&agrave;y l&ecirc;n da trong v&ograve;ng 5 ph&uacute;t rồi tr&aacute;ng lại bằng nước ấm. Tiếp tục thoa sữa tươi l&ecirc;n v&ugrave;ng da vừa tẩy để xoa dịu l&agrave;n da v&agrave; đạt hiệu quả tối ưu nhất.</p>\n<h2 style="text-align: justify;">X&oacute;a quầng th&acirc;m mắt</h2>\n<p style="text-align: justify;"><br />Sau 1 đ&ecirc;m thức khuya hay mất ngủ, bạn thường phải thức dậy với đ&ocirc;i mắt &ldquo;gấu tr&uacute;c&rdquo; mệt mỏi trong gương. Tuy nhi&ecirc;n, việc giải quyết &ldquo;thảm họa&rdquo; n&agrave;y cũng kh&ocirc;ng hề kh&oacute; khăn như bạn nghĩ. L&uacute;c đ&oacute;, bạn chỉ việc d&ugrave;ng khăn mềm thấm sữa tươi đều l&ecirc;n v&ugrave;ng da quanh mắt. Để kh&ocirc; rồi lau sạch lại bằng khăn ướt. C&aacute;c vết th&acirc;m đ&aacute;ng gh&eacute;t sẽ biến mất tức th&igrave;.<br /><br /></p>\n<h2 style="text-align: justify;">Dung dịch tẩy trang bằng sữa chua cực an to&agrave;n</h2>\n<p style="text-align: justify;"><br />Trong trường hợp hết nước tẩy trang, bạn chỉ việc, thấm v&agrave;o khăn b&ocirc;ng v&agrave; sữa tươi kh&ocirc;ng đường rồi lau đều l&ecirc;n mặt, sau đ&oacute; rửa lại bằng nước m&aacute;t. Mọi lớp son phấn sẽ được mang đi, để lại cho bạn l&agrave;n da mịn m&agrave;ng mơ ước.<br /><br /></p>\n<h2 style="text-align: justify;">L&agrave;m dịu vết ch&aacute;y nắng bằng sữa chua th&igrave; c&ograve;n g&igrave; bẳng!</h2>\n<p style="text-align: justify;"><br />Sau những k&igrave; nghỉ d&agrave;i ng&agrave;y, da bạn c&oacute; thể bị bỏng r&aacute;t do tiếp x&uacute;c trực tiếp với &aacute;nh nắng cường độ mạnh. L&uacute;c n&agrave;y, h&atilde;y trộn 1 ch&eacute;n sữa tươi v&agrave;o 2 ch&eacute;n nước, cho th&ecirc;m v&agrave;o đ&oacute; 1 th&igrave;a cafe muối tinh. H&ograve;a tan rồi nhẹ nh&agrave;ng thoa l&ecirc;n v&ugrave;ng da bị ch&aacute;y nắng, c&aacute;c enzym c&oacute; trong sữa sẽ nhanh ch&oacute;ng xoa dịu v&agrave; &ldquo;cứu v&atilde;n&rdquo; vẻ trắng s&aacute;ng vốn c&oacute; của l&agrave;n da sạm m&agrave;u.<br /><br /></p>\n<h2 style="text-align: justify;">Sữa tắm l&agrave;m trắng da</h2>\n<p style="text-align: justify;"><br />Đ&acirc;y ch&iacute;nh l&agrave; 1 trong những b&iacute; quyết l&agrave;m đẹp cực k&igrave; hiệu quả được học hỏi từ những mỹ nữ thời xưa. Mỗi tuần 2 lần, bạn h&atilde;y ng&acirc;m m&igrave;nh 20 ph&uacute;t trong bồn tắm đầy sữa tươi. Hoặc tiết kiệm hơn với bồn nước c&ugrave;ng 5 ch&eacute;n sữa bột. Bằng c&aacute;ch n&agrave;y, sữa sẽ thấm s&acirc;u trong da, l&agrave;m đều m&agrave;u v&agrave; đem đến cho bạn l&agrave;n da mịn m&agrave;ng &ldquo;như da em b&eacute;&rdquo;. Ngo&agrave;i ra, nếu th&iacute;ch l&agrave;n da c&oacute; m&ugrave;i hương thơm m&aacute;t, bạn c&oacute; thể nhỏ v&agrave;i giọt tinh dầu thơm hay c&aacute;nh hoa hồng gi&atilde; nhỏ v&agrave; bồn tắm.<br /><img src="http://4.bp.blogspot.com/-JktxhRp2ZHs/UqaZaVcCZMI/AAAAAAAAAKY/6UnrYhuZGVk/s1600/lam-dep-da-voi-sua-chua-2.jpg" alt="" border="0" /><br /><br />Mặt nạ sữa chua mang lại cảm gi&aacute;c m&aacute;t mẻ, sạch sẽ v&agrave; tươi mới. N&oacute; ph&ugrave; hợp với tất cả c&aacute;c loại da. Tuy nhi&ecirc;n, trước khi bắt tay v&agrave;o l&agrave;m, bạn phải kiểm tra xem da m&igrave;nh c&oacute; dị ứng với sữa chua, mật ong hay axit chanh kh&ocirc;ng nh&eacute;.</p>\n<h2 style="text-align: justify;">Mặt nạ sữa chua mật ong</h2>\n<p style="text-align: justify;"><br /><br />Th&agrave;nh phần: Sữa chua, mật ong v&agrave; bột mỳ<br />Lấy một muỗng sữa chua, mật ong v&agrave; th&ecirc;m &iacute;t nước trộn với bột mỳ sao cho th&agrave;nh một hỗn hợp sệt. Sau đ&oacute;, nhẹ nh&agrave;ng b&ocirc;i mặt nạ n&agrave;y l&ecirc;n mặt v&agrave; cổ. Để khoảng 15 ph&uacute;t cho mặt nạ kh&ocirc;, lấy khăn ấm lau sạch, đồng thời m&aacute;t xa để gi&uacute;p m&aacute;u lưu th&ocirc;ng.<br /><img src="http://4.bp.blogspot.com/-iVxo0a_8Ct4/UqaZvUvSigI/AAAAAAAAAKg/vqU6gQybKKM/s1600/mat-na-mat-ong-va-sua-chua-3.jpg" alt="" border="0" /></p>\n<h2 style="text-align: justify;">Mặt nạ sữa chua d&acirc;u t&acirc;y</h2>\n<p style="text-align: justify;">Rửa sạch d&acirc;u t&acirc;y v&agrave; để r&aacute;o nước, sau đ&oacute; &eacute;p lấy nước trộn với sữa chua, mật ong đ&atilde; chuẩn bị trước. B&ocirc;i hỗn hợp n&agrave;y l&ecirc;n da m&aacute;t xa nhẹ nh&agrave;ng v&agrave; giữ khoảng 15 ph&uacute;t rồi sửa sach. Loại mặt nạ n&agrave;y kh&ocirc;ng chỉ c&oacute; t&aacute;c dụng l&agrave;m trắng m&agrave; c&ograve;n đẩy l&ugrave;i mụn trứng c&aacute; hiệu quả.<br />Ch&uacute;c bạn th&agrave;nh c&ocirc;ng!<br />Từ kh&oacute;a googlec&aacute;ch l&agrave;m đẹp với dầu oliu<br />c&aacute;ch l&agrave;m đẹp facebook<br />c&aacute;ch l&agrave;m đẹp da mặt tự nhi&ecirc;n<br />c&aacute;ch l&agrave;m đẹp với c&aacute;m gạo<br />c&aacute;ch l&agrave;m đẹp với t&oacute;c ngắn<br />c&aacute;ch l&agrave;m đẹp tự nhi&ecirc;n<br />c&aacute;ch l&agrave;m đẹp da mặt<br />c&aacute;ch l&agrave;m đẹp da</p>', '2015-12-22 16:39:00', '2015-12-22 16:42:13', 3, 2, 132, '/images/source/thumb/cach-lam-dep-da-bang-sua-chua.jpg', NULL, '', '', '', '', 'vi', 1, 0, 0, 1, 1),
(55, 'Làm thế nào để có da đẹp tự nhiên', 'Làm thế nào để có da đẹp tự nhiên ? là câu hỏi mà rất nhiều bạn đã hỏi Blog Làm đẹp da. Mình xin chia sẻ một số kinh nghiệp để có làn da đẹp tự nhiên', '<p style="text-align: justify;"><strong>L&agrave;m thế n&agrave;o để c&oacute; da đẹp tự nhi&ecirc;n ? l&agrave; c&acirc;u hỏi m&agrave; rất nhiều bạn đ&atilde; hỏi Blog L&agrave;m đẹp da. M&igrave;nh xin chia sẻ một số kinh nghiệp để c&oacute; l&agrave;n da đẹp tự nhi&ecirc;n</strong><br />L&agrave;n da l&agrave; nơi phản &aacute;nh r&otilde; r&agrave;ng nhất vẻ đẹp v&agrave; sức khỏe của mỗi người. Với l&agrave;n da mịn m&agrave;ng, tươi s&aacute;ng chắc chắn chị em sẽ tự tin tỏa s&aacute;ng.<br />C&aacute;c chị em ai cũng mong muốn c&oacute; một l&agrave;n da đẹp, nhưng chắc chắn rằng chưa mấy ai thừa nhận rằng ch&iacute;nh c&aacute;c sống, c&aacute;ch ăn uống v&agrave; sử dụng c&aacute;c sản phẩm l<strong>&agrave;m đẹp hằng ng&agrave;y</strong> của ch&uacute;ng ta vẫn c&ograve;n đ&acirc;u đ&oacute; sự chưa ch&iacute;nh x&aacute;c .<br />L&agrave;n da l&agrave; nơi phản &aacute;nh r&otilde; r&agrave;ng nhất vẻ đẹp v&agrave; sức khỏe của mỗi người. <strong>Với l&agrave;n da mịn m&agrave;ng</strong>, tươi s&aacute;ng chắc chắn chị em sẽ tự tin tỏa s&aacute;ng. H&atilde;y &aacute;p dụng ngay những phương ph&aacute;p dưới đ&acirc;y lu&ocirc;n c&oacute; v&agrave; giữ được <strong>l&agrave;n da khỏe đẹp</strong> cho m&igrave;nh nh&eacute;.</p>\n<h2 style="text-align: justify;">UỐNG NHIỀU NƯỚC ĐỂ THẢI C&Aacute;C CHẤT ĐỘC, MỘT L&Iacute;T RƯỠI NƯỚC MỖI NG&Agrave;Y</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/lam-nao-de-co-da-dep-tu-nhien1.jpg" alt="" width="500" height="500" /><br /><br /><br /><em>Bạn cần uống nhiều nước để thải c&aacute;c chất độc nhưng chỉ n&ecirc;n uống khoảng 1 l&iacute;t rưỡi mỗi ng&agrave;y</em>, đấy l&agrave; lượng nước, gồm cả nước trong thức ăn m&agrave; ch&uacute;ng ta cần nạp v&agrave;o cơ thể mỗi ng&agrave;y để c&acirc;n bằng lượng nước mất đi, ngoại trừ trường hợp bị bệnh thận hay tim.<br />Ở c&aacute;c nước nhiệt đới hay khi luyện tập thể thao, do lượng nước mất đi nhiều n&ecirc;n lượng nước bổ sung cũng cần tăng l&ecirc;n. Chẳng hạn, một vận động vi&ecirc;n chạy marathon mất l&iacute;t rưỡi nước n&ecirc;n phải đảm bảo lượng nước v&agrave;o cơ thể lớn hơn con số ấy.<br />C&oacute; khoảng 160-180 l&iacute;t nước chạy qua thận mỗi ng&agrave;y, nhưng chỉ c&oacute; từ 1-1,5 l&iacute;t nước được thải ra ngo&agrave;i (nước tiểu). Nếu ch&uacute;ng ta uống nhiều nước, nước tiểu sẽ bị pha lo&atilde;ng hơn, chứ kh&ocirc;ng hề tập trung nhiều hơn c&aacute;c độc tố. Tuy nhi&ecirc;n, uống nhiều nước lại c&oacute; t&aacute;c dụng th&uacute;c đẩy b&agrave;i tiết qua đường tiết niệu.<br />Bắt đầu từ 3 l&iacute;t nước/ng&agrave;y trở l&ecirc;n mới c&oacute; thể g&acirc;y t&aacute;c dụng ngược. Với lượng nước ấy, sẽ xuất hiện t&igrave;nh trạng natri trong cơ thể bị pha lo&atilde;ng.<br />Tuy nhi&ecirc;n, với những người đang theo chế độ giảm muối, uống nhiều nước lại rất cần thiết.<br />1,5 l&iacute;t nước mỗi ng&agrave;y lu&ocirc;n lu&ocirc;n cần thiết cho hoạt động của cơ thể. Nếu ch&uacute;ng ta uống &iacute;t nước, cơ thể sẽ tự giữ lại v&igrave; sợ thiếu nước. Tốt nhất l&agrave; uống nước đều đặn với một lượng nhỏ mỗi lần trong cả ng&agrave;y.<br />Nếu hiện tượng giữ nước khiến cơ thể ph&ugrave;, cần đến gặp b&aacute;c sĩ để t&igrave;m ra nguy&ecirc;n nh&acirc;n.</p>\n<h2 style="text-align: justify;">Cố gắng c&acirc;n bằng lối sống</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/can-diu-cuoc-song.jpg" alt="" width="500" height="500" /><br /><br />Kh&ocirc;ng phải tự nhi&ecirc;n m&agrave; c&aacute;c cụ xưa c&oacute; dạy &ldquo;một nụ cười bằng mười thang thuốc bổ&rdquo;. Nụ cười l&agrave;m cho gương mặt của bạn rạng ngời, th&acirc;n thiện hơn rất nhiều. Đồng thời cười cũng l&agrave; b&agrave;i tập thể dục đơn giản nhất cho c&aacute;c cơ tr&ecirc;n gương mặt của chị em đấy nh&eacute;!<br />Trước v&agrave; hiện giờ, thời điểm bạn sinh hoạt thất thường, thức qu&aacute; khuya hay dậy qu&aacute; muộn, bỏ bữa hoặc tiệc t&ugrave;ng li&ecirc;n mi&ecirc;n khiến đồng hồ sinh học bị đảo lộn, cơ thể sẽ dễ mất c&acirc;n bằng, dẫn đến l&agrave;n da cũng bị ảnh hưởng trực tiếp như sần s&ugrave;i, nổi mụn hoặc th&ocirc; r&aacute;p, sạm đen. V&igrave; thế, h&atilde;y cố gắng c&acirc;n bằng lối sống bằng c&aacute;ch ngủ đủ giấc, kh&ocirc;ng bỏ bữa v&agrave; cũng kh&ocirc;ng ăn uống qu&aacute; đ&agrave;. Ch&uacute; &yacute; bổ sung rau xanh sau những bữa tiệc &ecirc; hề đạm, uống thật nhiều nước lọc hoặc nước hoa quả v&agrave; hạn chế tối đa thức uống c&oacute; cồn, cafeine, c&aacute;c loại nước ngọt đ&oacute;ng lon.</p>\n<h2 style="text-align: justify;">Bổ sung vitamin C</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/bo-xung-vitamin-c.jpg" alt="" width="500" height="500" /><br /><br />Vintamin C vốn được coi l&agrave; bạn tốt của da, gi&uacute;p <strong>x&oacute;a mờ vết th&acirc;m đen</strong>. Những sản phẩm dưỡng da c&oacute; chứa vitamin C t&aacute;c động t&iacute;ch cực l&ecirc;n l&agrave;n da c&oacute; nhiều v&igrave; vết, gi&uacute;p cải thiện da của bạn một c&aacute;ch nhanh ch&oacute;ng. Ngo&agrave;i ra, bạn c&oacute; thể d&ugrave;ng vi&ecirc;n uống vitamin C hoặc ăn bổ sung c&aacute;c loại rau xanh,<strong> hoa quả gi&agrave;u vitamin C</strong> tự nhi&ecirc;n cũng sẽ khiến da s&aacute;ng v&agrave; mịn mượt hơn trong những ng&agrave;y Tết.</p>\n<h2 style="text-align: justify;">Chọn mỹ phẩm c&oacute; nguồn gốc, xuất sứ r&otilde; r&agrave;ng</h2>\n<p style="text-align: justify;"><br />Chuy&ecirc;n gia tư vấn của thẩm mỹ viện Thi&ecirc;n H&agrave; khuyến c&aacute;o kh&aacute;ch h&agrave;ng trong việc sửa dụng mĩ phẩm phải c&oacute; hạn sử dụng r&otilde; r&agrave;ng.<br />Với sự thay đổi thời tiết, kh&oacute;i bụi, &ocirc; nhiễm m&ocirc;i trường đều c&oacute; t&aacute;c động rất khắc nghiệt với l&agrave;n da, khiến da dễ xỉn m&agrave;u, sần s&ugrave;i, kh&ocirc; r&aacute;p. Da kh&ocirc; kh&ocirc;ng ảnh hưởng đến sức khỏe nhưng g&acirc;y kh&oacute; chịu v&agrave; mất thẩm mỹ, khiến bạn kh&oacute; khăn hơn trong việc &ldquo;make up&rdquo;.<br />Đồng thời, trong việc sử dụng c&aacute;c sản phẩm mỹ phẩm, phải đặc biệt lưu &yacute; đến nguồn gốc, xuất xứ, c&ugrave;ng như hạn sử dụng của c&aacute;c sản phẩm d&agrave;nh cho da. H&atilde;y chăm chỉ sử dụng kem giữ ẩm l&agrave;m mềm da để cải thiện l&agrave;n da của m&igrave;nh nh&eacute;.<br />Nhiều người c&oacute; th&oacute;i quen tự thưởng cho m&igrave;nh một v&agrave;i liệu tr&igrave;nh chăm s&oacute;c da tại spa hay sắm cho m&igrave;nh một bộ sản phẩm đặc trị để việc chăm dưỡng da được chuy&ecirc;n s&acirc;u hơn. Đ&oacute; l&agrave; điều rất đ&aacute;ng khuyến kh&iacute;ch. Chỉ c&oacute; một điều bạn cần lưu &yacute; l&agrave; kh&ocirc;ng n&ecirc;n &ldquo;mạo hiểm&rdquo; với những loại<strong> mỹ phẩm </strong>mới hay những g&oacute;i trị liệu mới m&agrave; bạn chưa từng d&ugrave;ng trước đ&oacute;, hoặc ở một v&agrave;i nơi chi ph&iacute; thấp nhưng chưa c&oacute; thương hiệu.</p>\n<h2 style="text-align: justify;">Đắp mặt nạ h&agrave;ng tuần</h2>\n<p style="text-align: justify;"><br />Rau củ quả, rượu vang l&agrave; những nguy&ecirc;n liệu rất sẵn để l&agrave;m những chiếc mặt nạ cho da hiệu quả tại nh&agrave;. H&atilde;y tận dụng ch&uacute;ng để l&agrave;n da của bạn tỏa s&aacute;ng.<br /><br /></p>\n<h2 style="text-align: justify;">M&aacute;ch bạn một số c&aacute;ch l&agrave;m mặt nạ cho da:</h2>\n<p style="text-align: justify;"><br /><strong>Sữa tươi v&agrave; chanh</strong>: Trộn 2 th&igrave;a c&agrave; ph&ecirc; sữa tươi, 1 th&igrave;a nước cốt chanh, 1 muỗng canh bột m&igrave; th&agrave;nh hỗn hợp sệt, đắp lại l&ecirc;n mặt trong 20 ph&uacute;t rồi rửa sạch. Mặt nạ n&agrave;y sẽ gi&uacute;p nhẹ nh&agrave;ng tẩy đi lớp da xỉn m&agrave;u, trả lại l&agrave;n da s&aacute;ng mịn.<br /><strong>Khoai t&acirc;y: </strong>Luộc ch&iacute;n một củ khoai t&acirc;y, trộn với một th&igrave;a dầu olive si&ecirc;u nguy&ecirc;n chất, nghiền nhuyễn v&agrave; đắt l&ecirc;n mặt trong 20 ph&uacute;t rồi rửa sạch, sẽ <strong>gi&uacute;p l&agrave;n da mịn m&agrave;ng</strong>, giảm th&ocirc; r&aacute;p, nứt nẻ.<br /><strong>Dưa chuột: </strong>Th&aacute;i dưa chuột th&agrave;nh những l&aacute;t mỏng đắp l&ecirc;n mặt khoảng 20 ph&uacute;t rồi rửa sạch. Mặt nạ dưa chuột l&agrave;m trắng da v&agrave; đem lại cảm gi&aacute;c tươi mới cho l&agrave;n da.<br /><strong>C&agrave; rốt: </strong>C&agrave; rốt nghiền n&aacute;t trộn th&ecirc;m v&agrave;i giọt dầu thực vật đắp l&ecirc;n mặt 20 ph&uacute;t rồi rửa sạch. Mặt nạ c&agrave; rốt th&iacute;ch hợp với loại da nhiều dầu, nhiều trứng c&aacute; đồng thời c&oacute; t&aacute;c dụng l&agrave;m mờ những vết th&acirc;m n&aacute;m, t&agrave;n nhang, cho l&agrave;n da s&aacute;ng mịn.<br /><strong>Với những c&aacute;ch tr&ecirc;n m&agrave; Blog L&agrave;m đẹp da chia sẻ hy vọng bạn sẽ c&oacute; c&acirc;u trả l&ograve;i cho ch&iacute;nh m&igrave;nh. Ch&uacute;c bạn th&agrave;nh c&ocirc;ng !</strong></p>', '2015-12-22 16:32:00', '2015-12-22 16:38:57', 3, 1, 96, '/images/source/thumb/am-nao-de-co-da-dep-tu-nhien.jpg', NULL, '', '', '', '', 'vi', 1, 0, 0, 1, 1),
(66, 'Mẹo chữa hôi miệng đơn giản hiệu quả cao', 'Hãy cũng Thanh Xuân Dược đi tiếp những mẹo chữa bệnh hôi miệng đơn giản mà hiệu quả cao.', '<p>Bạn thấy sao khi giao tiếp với người bị <strong>h&ocirc;i miệng</strong>, Nếu đặt trường hợp người bị h&ocirc;i miệng l&agrave; bạn th&igrave; sao? Người đối diện ch&aacute;c hẳn sẽ cảm thấy kh&oacute; chịu v&agrave; kh&ocirc;ng muốn giao tiếp với bạn nữa.</p>\n<p>H&atilde;y cũng Thanh Xu&acirc;n Dược đi tiếp những mẹo chữa bệnh h&ocirc;i miệng đơn giản m&agrave; hiệu quả cao.</p>\n<p>Căn bệnh phổ biến nhưng kh&ocirc;ng kh&oacute; để chữa trị, bạn c&oacute; thể d&ugrave;ng những c&aacute;ch chữa h&ocirc;i miệng đơn giản dưới đ&acirc;y để tự tin hơn với bản th&acirc;n m&igrave;nh.</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/meo-chua-hoi-mieng-don-gian-hieu-qua-cao.jpg" alt="" width="500" height="360" /></p>\n<h2>Chữa h&ocirc;i miệng bằng chanh</h2>\n<p>Quả chanh c&oacute; một lượng vitamin C rất lớn gi&uacute;p đ&aacute;nh tan m&ugrave;i h&ocirc;i miệng hiệu quả, thực hiện kh&aacute; đơn giản bằng c&aacute;ch lấy một th&igrave;a chanh h&ograve;a c&ugrave;ng với 1 th&igrave;a mật ong, sau đ&oacute; ngậm khoảng 3-5 ph&uacute;t, bạn n&ecirc;n thực hiện v&agrave;o buổi s&aacute;ng v&agrave; tối để đạt hiệu quả tốt nhất.</p>\n<p>Bạn cũng c&oacute; thể h&ograve;a nước chanh v&agrave; muối để c&oacute; thể s&uacute;c miệng hằng ng&agrave;y, sẽ gi&uacute;p loại bỏ c&aacute;c vi khuẩn v&agrave; vết ố v&agrave;ng gi&uacute;p răng trắng v&agrave; hoi thở thơm m&aacute;t hơn.</p>\n<h2>Chữa h&ocirc;i miệng bằng tinh dầu tr&agrave;m</h2>\n<p>Diệt khuẩn v&agrave; loại bỏ m&ugrave;i h&ocirc;i đ&oacute; l&agrave; c&ocirc;ng dụng ch&iacute;nh của tinh dầu tr&agrave;m, tinh dầu tr&agrave;m được sử dụng rất nhiều trong việc điều trị bệnh cũng như l&agrave;m đẹp, tinh dầu tr&agrave;m tốt nhất c&oacute; ở Miền Nam, bạn c&oacute; thể t&igrave;m mua ở c&aacute;c cửa h&agrave;ng mỹ phẩm uy t&iacute;n để c&oacute; được sản phẩm tốt nhất.</p>\n<p>Bạn sử dụng tinh dầu tr&agrave;m bằng c&aacute;ch mỗi lần khi đ&aacute;nh răng th&igrave; bạn n&ecirc;n nhỏ v&agrave;i giọt v&agrave;o b&agrave;n trải, thực hiện hằng ng&agrave;y, sau khoảng 2- 3 tuần th&igrave; bạn sẽ thấy hiệu quả r&otilde; rệt.</p>\n<h2>Chữa h&ocirc;i miệng bằng c&acirc;y đinh hương</h2>\n<p>L&agrave; một trong những loại thảo dược rất tốt cho sức khỏe đặc biệt đối với người bị s&acirc;u răng, h&ocirc;i iệng, bạn c&oacute; thể ng&acirc;m c&aacute;c mảng đinh hương cho tới khi mềm v&agrave; ngậm khoảng 2 -3 ph&uacute;t, mỗi ng&agrave;y bạn thực hiện 1 lần, ki&ecirc;n tr&igrave; thực hiện trong 1 thời gian để kiểm chứng kết quả.</p>\n<h2>Chữa h&ocirc;i miệng bằng hương nhu</h2>\n<p>C&acirc;y hương nhu c&oacute; m&ugrave;i thơm, vị kh&ocirc;ng cay lắm, l&agrave; một trong những vị thuốc kh&ocirc;ng thể thiếu trong điều trị nhiều bệnh. C&acirc;y hương nhu n&agrave;y rất dễ kiếm, được trồng nhiều tại c&aacute;c v&ugrave;ng đồng bằng, bạn chỉ việc phơi kh&ocirc;, sau đ&oacute; đun c&ugrave;ng với nước, sử dụng nước uống hằng ng&agrave;y.</p>\n<h2>Chữa bệnh h&ocirc;i miệng bằng tr&agrave; xanh</h2>\n<p>Trong tr&agrave; xanh c&oacute; một chất poluphenol gi&uacute;p ngăn chặn sự ph&aacute;t triển của vi khuẩn, khử m&ugrave;i h&ocirc;i b&ecirc;nh cạnh đ&oacute; c&ograve;n c&oacute; c&ocirc;ng dụng l&agrave;m đẹp, gi&uacute;p răng nướu khỏe mạnh. Bạn n&ecirc;n uống tr&agrave; xanh hằng ng&agrave;y sẽ kh&ocirc;ng c&ograve;n bị h&ocirc;i miệng nữa.</p>\n<p>Những c&aacute;ch chữa <em>h&ocirc;i miệng</em> n&ecirc;u tr&ecirc;n rất đơn giản, dễ l&agrave;m, rẻ tiền bạn c&oacute; thể l&agrave;m tại nh&agrave; để tự tin với hơi thở thơm m&aacute;t.</p>\n<p>Với những c&aacute;ch chữa h&ocirc;i miệng ở tr&ecirc;n rất dễ thực hiện bạn c&oacute; thể sử dụng hằng ng&agrave;y. Hoặc bạn cũng c&oacute; thể tham khảo sử dụng những loại thuốc chiết xuất từ thảo mộc thi&ecirc;n nhi&ecirc;n sẽ gi&uacute;p bạn tự tin hơn khi giao tiếp, kh&ocirc;ng c&ograve;n phải lo ngại chuyện h&ocirc;i miệng.</p>\n<p>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng !</p>', '2016-01-18 11:49:00', '2016-02-25 00:17:15', 2, 12, 69, '/images/source/thumb/meo-chua-hoi-mieng-don-gian-hieu-qua-cao.jpg', NULL, '', '', '', '', 'vi', 1, 0, 0, 1, 5),
(65, '5 mẹo trị hôi chân hiệu quả tại nhà', 'Bạn đã bao giờ ngửi thấy mùi hôi chân? Quả thực là ác mộng đúng không. Với những ai bị hôi chân thì ngoài việc cảm thấy khó chịu bạn muốn có cảm giác mất tự tin khi đứng nơi đông người với mùi hôi của chân.', '<p style="text-align: justify;">Bạn đ&atilde; bao giờ ngửi thấy m&ugrave;i h&ocirc;i ch&acirc;n? Quả thực l&agrave; &aacute;c mộng đ&uacute;ng kh&ocirc;ng. Với những ai bị h&ocirc;i ch&acirc;n th&igrave; ngo&agrave;i việc cảm thấy kh&oacute; chịu bạn muốn c&oacute; cảm gi&aacute;c mất tự tin khi đứng nơi đ&ocirc;ng người với m&ugrave;i h&ocirc;i của ch&acirc;n.</p>\n<p style="text-align: justify;">Dưới đ&acirc;y ch&uacute;ng t&ocirc;i sẽ chia sẻ cho c&aacute;c bạn những c&aacute;ch c&oacute; thể thực hiện tại nh&agrave; để cải thiện t&igrave;nh h&igrave;nh khi bị h&ocirc;i ch&acirc;n.</p>\n<p style="text-align: justify;"><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/5-meo-tri-hoi-chan-hieu-qua-tai-nha.jpg" alt="" width="637" height="460" /></p>\n<h2 style="text-align: justify;">Bạn n&ecirc;n giữ cho đ&ocirc;i b&agrave;n ch&acirc;n lu&ocirc;n được kh&ocirc; tho&aacute;ng, sạch sẽ</h2>\n<p style="text-align: justify;">Hằng ng&agrave;y bạn n&ecirc;n vệ sinh sạch sẽ bằng x&agrave; ph&ograve;ng, n&ecirc;n rửa ch&acirc;n sạch trước khi đi ngủ, bạn cũng c&oacute; thể ng&acirc;m ch&acirc;n v&agrave;o nước ấm c&oacute; pha ch&uacute;t gừng sẽ khiến đ&ocirc;i ch&acirc;n của bạn trở n&ecirc;n thoải m&aacute;i hơn.</p>\n<p style="text-align: justify;">Khi đi l&agrave;m hay đi đ&acirc;u m&agrave; phải mang gi&agrave;y th&igrave; bạn n&ecirc;n lau ch&ugrave;i sạch sẽ đ&ocirc;i gi&agrave;y của m&igrave;nh để khi đi sẽ kh&ocirc;ng bị h&ocirc;i.</p>\n<p style="text-align: justify;">Để cho đ&ocirc;i ch&acirc;n lu&ocirc;n được mềm mại th&igrave; bạn n&ecirc;n sử dụng kem dưỡng da cũng như thường xuy&ecirc;n cắt tỉa c&aacute;c m&oacute;ng ch&acirc;n của m&igrave;nh.</p>\n<h2 style="text-align: justify;">Lựa chọn loại tất, gi&agrave;y hợp l&yacute;</h2>\n<p style="text-align: justify;">Bạn n&ecirc;n sử dụng loại tất ch&acirc;n được l&agrave;m bằng cotton thấm mồ h&ocirc;i gi&uacute;p hạn chế tối đa sự ph&aacute;t triển của c&aacute;c loại vi khuẩn.</p>\n<p style="text-align: justify;">Thay v&igrave; đi đ&ocirc;i gi&agrave;y k&iacute;n m&iacute;t, việc lựa chọn những đ&ocirc;i gi&agrave;y hở mũi sẽ gi&uacute;p cho đ&ocirc;i ch&acirc;n của bạn trở n&ecirc;n th&ocirc;ng tho&aacute;ng v&agrave; kh&ocirc;ng bị ẩm ướt.</p>\n<p style="text-align: justify;">Lưu &yacute; quan trọng đ&oacute; l&agrave; kh&ocirc;ng n&ecirc;n đi 1 đ&ocirc;i gi&agrave;y trong một thời gian qu&aacute; d&agrave;i, bạn n&ecirc;n sắm cho m&igrave;nh v&agrave;i ba đ&ocirc;i gi&agrave;y để c&oacute; thể thay đổi li&ecirc;n tục kh&ocirc;ng bị g&ograve; b&oacute;.</p>\n<p style="text-align: justify;">Trước khi đi gi&agrave;y bạn c&oacute; thể cho một &iacute;t phấn r&ocirc;m trước khi đi, sẽ kh&ocirc;ng c&ograve;n m&ugrave;i kh&oacute; chịu nữa.</p>\n<h2 style="text-align: justify;">Sử dụng c&aacute;ch ng&acirc;m ch&acirc;n hằng ng&agrave;y</h2>\n<p style="text-align: justify;">Sử dụng ng&acirc;m nước ấm, muối v&agrave; gừng: Bạn n&ecirc;n thực hiện 1 tuần 3 -4 lần bằng c&aacute;ch như sau: đun s&ocirc;i 2 l&iacute;t nước, sau đ&oacute; cho một muỗm nhỏ muối hạt, v&agrave; khoảng v&agrave;i l&aacute;t gừng đập dập v&agrave; chờ nước nguội, th&igrave; bạn ng&acirc;m ch&acirc;n v&agrave; thư gi&atilde;n khoảng 30 - 45 ph&uacute;t mỗi ng&agrave;y, trước khi ng&acirc;m ch&acirc;n th&igrave; bạn n&ecirc;n rửa sạch sẽ ch&acirc;n, thực hiện đều đặn như thế sẽ kh&ocirc;ng c&ograve;n ngại về m&ugrave;i h&ocirc;i ch&acirc;n, m&agrave; ngược lại tạo cảm gi&aacute;c rất thoải m&aacute;i, tự tin.</p>\n<p style="text-align: justify;">Bạn cũng c&oacute; thể thực hiện c&aacute;ch tr&ecirc;n tương tự đối với củ cải trắng, hay l&aacute; ch&egrave; xanh.</p>\n<p style="text-align: justify;">Với những c&aacute;ch như tr&ecirc;n c&oacute; thể gi&uacute;p bạn tống khứ v&agrave; x&oacute;a bỏ m&ugrave;i h&ocirc;i ch&acirc;n trong một khoảng thời gian nhất định, nhưng nhớ l&agrave; phải ki&ecirc;n tr&igrave; thực hiện để c&oacute; kết quả tốt nhất.</p>\n<p style="text-align: justify;">Đối với những c&aacute;ch ở tr&ecirc;n th&igrave; chỉ c&oacute; thể điều trị tạm thời, để khỏi được vĩnh viễn th&igrave; cần phải c&oacute; một giải ph&aacute;p điều trị h&ocirc;i ch&acirc;n. Bạn c&oacute; thể tham khảo b&agrave;i thuốc d&acirc;n gian của d&acirc;n tộc T&agrave;y với 1 liệu tr&igrave;nh duy nhất, gi&uacute;p trị vĩnh viễn được bệnh. Bạn c&oacute; thể tham khảo th&ecirc;m <a title="Thuốc trị h&ocirc;i miệng" href="http://thanhxuanduoc.com/tri-sau-rang-hoi-mieng.html"><strong>tại đ&acirc;y</strong></a></p>', '2016-01-18 11:40:00', '2016-02-25 00:22:00', 2, 11, 52, '/images/source/thumb/5-meo-tri-hoi-chan-hieu-qua-tai-nha.jpg', NULL, '5 mẹo trị hôi chân hiệu quả tại nhà', '', '5 mẹo trị hôi chân hiệu quả tại nhà với những phương pháp tự nhiên, dễ làm nhưng vẫn mang lại hiệu quả cao', '', 'vi', 1, 0, 0, 1, 5),
(59, 'Cách xử lí cấp tốc khi da bị dị ứng mỹ phẩm', 'Tình trạng mỹ phẩm đểu, hàng kém chất lượng và có xuất xứ không rõ ràng đang được bán tràn lan như hiện nay. Tuy nhiên không phải ai cũng có cách ứng khó kịp thời khi bị dị ứng mỹ phẩm', '<p><p><h2 class="knd-sapo" style="text-align: justify;" data-field="sapo">T&igrave;nh trạng mỹ phẩm đểu, h&agrave;ng k&eacute;m chất lượng v&agrave; c&oacute; xuất xứ kh&ocirc;ng r&otilde; r&agrave;ng đang được b&aacute;n tr&agrave;n lan như hiện nay. Tuy nhi&ecirc;n kh&ocirc;ng phải ai cũng c&oacute; c&aacute;ch ứng kh&oacute; kịp thời khi bị dị ứng mỹ phẩm. Sau đ&acirc;y Thanh xu&acirc;n dược xin chia sẻ&nbsp;C&aacute;ch xử l&iacute; cấp tốc khi da bị dị ứng mỹ phẩm</h2> <p style="text-align: justify;"><strong>Dấu hiệu dị ứng mỹ phẩm</strong></p> <p style="text-align: justify;">Điều quan trọng nhất l&agrave; bạn phải x&aacute;c định được khi n&agrave;o m&igrave;nh bị dị ứng mỹ phẩm để kịp thời xử l&yacute;. C&aacute;c dấu hiệu dị ứng ti&ecirc;u biểu l&agrave;:</p> <p style="text-align: justify;"><em>Nổi mụn</em>: Sự xuất hiện của mụn nước hoặc mụn mủ l&agrave; dấu hiệu phổ biến nhất m&agrave; ch&uacute;ng ta thường gặp. Do sử dụng một số loại mỹ phẩm kh&ocirc;ng ph&ugrave; hợp l&agrave;m tăng tiết b&atilde; nhờn, b&iacute;t k&iacute;n lỗ ch&acirc;n l&ocirc;ng khiến da lu&ocirc;n trong t&igrave;nh trạng "nghẹt thở".</p> <p style="text-align: justify;"><em>Mề đay</em>: Biểu hiện n&agrave;y g&acirc;y ngứa r&aacute;t kh&oacute; chịu, n&oacute; c&oacute; thể diễn ra trong v&ograve;ng v&agrave;i ph&uacute;t đến 1 giờ sau khi da bắt đầu bị k&iacute;ch ứng.</p> <p style="text-align: justify;"><em>Vi&ecirc;m da dị ứng</em>: Đ&acirc;y l&agrave; loại dị ứng nghi&ecirc;m trọng hơn, khi đ&oacute; tr&ecirc;n da xuất hiện mụn, bỏng nước g&acirc;y ngứa dữ dội v&agrave; đau r&aacute;t. T&igrave;nh trạng n&agrave;y nếu kh&ocirc;ng được xử l&iacute; v&agrave; chữa trị kịp thời rất dễ g&acirc;y nhiễm tr&ugrave;ng da.</p> <p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/cach-xu-li-cap-toc-khi-da-bi-di-ung-my-pham.png" alt="" width="640" height="370" /></p> <p style="text-align: justify;"><em>L&atilde;o h&oacute;a da</em>: Việc chủ quan v&agrave; lạm dụng c&aacute;c loại mỹ phẩm trong thời gian d&agrave;i g&acirc;y dị ứng khiến da bị kh&ocirc;, bong tr&oacute;c, dễ bắt nắng hơn l&agrave;m xuất hiện c&aacute;c vết n&aacute;m sạm v&agrave; đốm n&acirc;u.</p> <p style="text-align: justify;">Sốc phản vệ: Hiện tượng n&agrave;y hiếm gặp nhưng c&oacute; thể g&acirc;y tử vong cho người mắc phải. Khi đ&oacute; cơ thể sẽ cảm thấy kh&oacute; thở, buồn n&ocirc;n, ph&aacute;t ban lớn l&agrave;m ảnh hưởng nghi&ecirc;m trọng đến c&aacute;c cơ quan kh&aacute;c.</p> <p style="text-align: justify;"><strong>C&aacute;ch xử l&iacute; khi dị ứng mỹ phẩm</strong></p> <p style="text-align: justify;">Khi t&igrave;nh trạng dị ứng bắt đầu t&aacute;i ph&aacute;t, ch&uacute;ng ta cần nhớ v&agrave; xử l&iacute; theo c&aacute;c bước sau:</p> <p style="text-align: justify;"><em>Bước 1</em>: Trước hết, bạn cần ngưng sử dụng c&aacute;c loại mỹ phẩm, kh&ocirc;ng tự &yacute; nặn mụn cũng như sờ tay l&ecirc;n những v&ugrave;ng bị tổn thương để tr&aacute;nh g&acirc;y nhiễm tr&ugrave;ng.</p> <p style="text-align: justify;"><em>Bước 2</em>: Rửa mặt nhẹ nh&agrave;ng với nước sạch hoặc dung dịch nước muối lo&atilde;ng để loại bỏ hết cặn mỹ phẩm c&ograve;n x&oacute;t tr&ecirc;n da 2 lần/ng&agrave;y.</p> <p style="text-align: justify;"><em>Bước 3</em>: Tr&aacute;nh để da tiếp x&uacute;c với &aacute;nh nắng mặt trời v&agrave; theo d&otilde;i t&igrave;nh trạng dị ứng. Với những trường hợp nhẹ c&oacute; thể sử dụng một số loại thuốc theo chỉ định. Khi c&aacute;c triệu chứng k&eacute;o d&agrave;i v&agrave; kh&ocirc;ng c&oacute; dấu hiệu giảm, bạn cần đến gặp b&aacute;c sĩ da liễu kh&aacute;m v&agrave; kịp thời chữa trị để tr&aacute;nh những biến chứng nguy hiểm.</p> <p style="text-align: justify;"><strong>C&aacute;ch ph&ograve;ng tr&aacute;nh dị ứng mỹ phẩm</strong></p> <p style="text-align: justify;">Một số lưu &yacute; sau đ&acirc;y sẽ gi&uacute;p bạn y&ecirc;n t&acirc;m hơn khi sử dụng mỹ phẩm đấy!</p> <p style="text-align: justify;">- Mua mỹ phẩm c&oacute; nguồn gốc r&otilde; r&agrave;ng tại những nơi đảm bảo uy t&iacute;n.</p> <p style="text-align: justify;">- Lựa chọn c&aacute;c sản phẩm l&agrave;m đẹp ph&ugrave; hợp v&agrave; an to&agrave;n cho da.</p> <p style="text-align: justify;">- Lưu &yacute; thử ch&uacute;ng trước ở những v&ugrave;ng da nhỏ, nếu thấy những biểu hiện kh&aacute;c lạ cần ngưng sử dụng ngay.</p> <p style="text-align: justify;">- Kh&ocirc;ng n&ecirc;n sử dụng mỹ phẩm khi da kh&ocirc;ng khỏe mạnh hoặc đang trong t&igrave;nh trạng vi&ecirc;m nhiễm.</p> <p style="text-align: justify;">- Ưu ti&ecirc;n những sản phẩm c&oacute; nguồn gốc từ thi&ecirc;n nhi&ecirc;n v&agrave; tr&aacute;nh lạm dụng c&aacute;c sản phẩm h&oacute;a chất.</p> <p style="text-align: justify;">- Giữ da mặt sạch v&agrave; tẩy trang kĩ sau mỗi lần trang điểm để tr&aacute;nh tạo điệu kiện cho vi khuẩn tr&uacute; ngụ g&acirc;y dị ứng da.</p> <p style="text-align: justify;">- Uống đủ nước v&agrave; tăng cường bổ sung tr&aacute;i c&acirc;y gi&uacute;p l&agrave;n da lu&ocirc;n tươi trẻ v&agrave; khỏe khoắn</p> <p style="text-align: justify;">Ch&uacute;c bạn th&agrave;nh c&ocirc;ng !</p></p></p>', '2016-01-16 10:49:00', '2016-01-16 10:57:07', 5, 5, 84, '/images/source/thumb/cach-xu-li-cap-toc-khi-da-bi-di-ung-my-pham.png', NULL, '', '', '', '', 'vi', 1, 0, 0, 1, 1),
(60, 'Những triệu chứng bệnh yếu sinh lý ở nam giới', 'Nhưng bạn đã biết những hậu quả của việc yếu sinh lý ở nam, Nó khiến nam giới thiếu tự tin và cũng là nguyên nhân dẫn tới việc nhiều gia đình đổ vỡ', '<h2 style="text-align: justify;">Nhưng bạn đ&atilde; biết những hậu quả của việc yếu sinh l&yacute; ở nam, N&oacute; khiến nam giới thiếu tự tin v&agrave; cũng l&agrave; nguy&ecirc;n nh&acirc;n dẫn tới việc nhiều gia đ&igrave;nh đổ vỡ</h2>\n<p style="text-align: justify;">Những triệu chứng của bệnh yếu sinh l&yacute; nam giới. Yếu sinh l&yacute; l&agrave;m cho đ&agrave;n &ocirc;ng thiếu tự tin, mặc cảm trước bạn t&igrave;nh. Mặc d&ugrave; căn bệnh yếu sinh l&yacute; kh&ocirc;ng g&acirc;y ảnh hưởng tới t&iacute;nh mạng nhưng n&oacute; lại mang lại những t&aacute;c hại cho sức khỏe nam giới v&agrave; ảnh hưởng rất lớn tới hạnh ph&uacute;c gia đ&igrave;nh, g&acirc;y ảnh hưởng xấu cho quan hệ t&igrave;nh dục. H&atilde;y trang bị cho m&igrave;nh một kiến thức cơ bản về yếu sinh l&yacute; cũng như những b&agrave;i thuốc cơ bản để đẩy l&ugrave;i căn bệnh yếu sinh l&yacute;.</p>\n<h2 style="text-align: justify;">Những triệu chứng nhận biết bạn bị yếu sinh l&yacute;:</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/trieu-chung0-yeu-sinh-ly-o-nam-gioi.png" alt="" width="600" height="387" /></p>\n<p style="text-align: justify;"><strong>những triệu chứng thường gặp khi bị yếu sinh l&yacute;.</strong></p>\n<h2 style="text-align: justify;">Rối loạn cương dương:</h2>\n<p style="text-align: justify;">Rối loạn cương dương (liệt dương) thường c&oacute; biểu hiện &ldquo;dương vật&rdquo; bị mềm sớm trước khi xuất tinh;kh&ocirc;ng c&oacute; hứng th&uacute; t&igrave;nh dục; kh&ocirc;ng xuất tinh; xuất tinh sớm; thiếu hay mất cực kho&aacute;i. Cậu nhỏ kh&ocirc;ng thể cương cứng chọn vẹn trong cuộc giao hợp.</p>\n<h2 style="text-align: justify;">Rối loạn xuất tinh:</h2>\n<p style="text-align: justify;">Nam giới khi hưng phấn cao độ c&oacute; thể xuất tinh nhưng kh&ocirc;ng xuất tinh b&igrave;nh thường đ&acirc;y ch&iacute;nh l&agrave; biểu hiện của hiện tượng suy giảm chức năng sinh l&yacute;, thậm ch&iacute; c&oacute; thể dẫn đến kh&ocirc;ng xuất tinh. Rối loạn xuất tinh c&oacute; thể g&acirc;y ra xuất tinh sớm, kh&ocirc;ng xuất tinh hoặc xuất tinh ngược d&ograve;ng.</p>\n<h2 style="text-align: justify;">Suy giảm chức năng t&igrave;nh dục:</h2>\n<p style="text-align: justify;">C&oacute; thể c&oacute; cảm x&uacute;c t&igrave;nh dục nhưng kh&ocirc;ng thể cương cứng, hoặc kh&ocirc;ng đủ cương cứng để giao hợp. C&oacute; thể do c&aacute;c yếu tố bất thường như: yếu tố tinh thần, chấn thương về t&acirc;m l&yacute;, trầm cảm&hellip; cũng l&agrave; yếu tố t&aacute;c động đến sinh l&yacute; t&igrave;nh dục.</p>\n<h2 style="text-align: justify;">Đau nhức khi quan hệ t&igrave;nh dục:</h2>\n<p style="text-align: justify;">l&agrave; hiện tượng thường gặp của suy giảm chức năng t&igrave;nh dục, nam giới c&oacute; cảm gi&aacute;c đau nhức khi cương cứng, do bị k&iacute;ch th&iacute;ch l&ecirc;n quy đầu dương vật, bao quy đầu, đau khi xuất tinh, tiểu buốt tiểu r&aacute;t sau khi xuất tinh&hellip;</p>\n<p style="text-align: justify;"><strong><em>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng v&agrave; hạnh ph&uacute;c</em></strong></p>', '2016-01-16 11:04:00', '2016-01-16 11:09:05', 5, 6, 82, '/images/source/thumb/trieu-chung0-yeu-sinh-ly-o-nam-gioi.png', NULL, 'Những triệu chứng bệnh yếu sinh lý ở nam giới', '', 'Nhưng bạn đã biết những hậu quả của việc yếu sinh lý ở nam, Nó khiến nam giới thiếu tự tin và cũng là nguyên nhân dẫn tới việc nhiều gia đình đổ vỡ', '', 'vi', 1, 0, 0, 1, 1);
INSERT INTO `txd_news` (`id`, `title`, `summary`, `content`, `created_date`, `updated_date`, `cat_id`, `position`, `viewed`, `thumbnail`, `city_id`, `meta_title`, `meta_keywords`, `meta_description`, `tags`, `lang`, `status`, `home`, `startups`, `creator`, `editor`) VALUES
(61, 'Mách nhỏ: Những thực phẩm mẹ bầu nên ăn', 'Với bà bầu thì việc bổ xung những chất dinh dương là điều cực kỳ quan trọng vì nó quyết định tới việc phát triển của thai nhi và bé sau này. Tuy nhiên thì không phải bà bầu nào cũng biết những kiến thức về dinh dưỡng', '<p style="text-align: justify;">Với b&agrave; bầu th&igrave; việc bổ xung những chất dinh dương l&agrave; điều cực kỳ quan trọng v&igrave; n&oacute; quyết định tới việc ph&aacute;t triển của thai nhi v&agrave; b&eacute; sau n&agrave;y. Tuy nhi&ecirc;n th&igrave; kh&ocirc;ng phải b&agrave; bầu n&agrave;o cũng biết những kiến thức về dinh dưỡng</p>\n<p style="text-align: justify;">B&agrave; bầu kh&ocirc;ng những cần ki&ecirc;ng một số thực phẩm kh&ocirc;ng tốt cho thai nhi như đu đủ xanh, bia, rượu, cafe&hellip; M&agrave; c&ograve;n c&oacute; những th&oacute;i quen m&agrave; mẹ bầu n&ecirc;n tr&aacute;nh như hoạt động thể thao qu&aacute; độ, lạm dụng mỹ phẩm&hellip;Ngo&agrave;i những điều cần tr&aacute;nh th&igrave; mẹ bầu cũng n&ecirc;n bổ sung c&aacute;c thực phẩm như:</p>\n<h2 style="text-align: justify;">Trứng</h2>\n<p style="text-align: justify;"><img src="http://thanhxuanduoc.com/images/source/nhung-thuc-pham-me-bau-nen-an-1.png" alt="" width="800" height="533" /></p>\n<p style="text-align: justify;">Trứng rất tốt cho mẹ bầu</p>\n<p style="text-align: justify;">Đ&acirc;y l&agrave; loại thực phẩm chứa nhiều choline trong l&ograve;ng đỏ. Chất n&agrave;y gi&uacute;p hỗ trợ qu&aacute; tr&igrave;nh sản xuất ra acetycholine, chất quan trọng của hệ thần kinh t&aacute;c động trực tiếp đến tr&iacute; nhớ, ph&aacute;t triển tr&iacute; n&atilde;o của b&agrave;o thai v&agrave; hỗ trợ tr&iacute; nhớ cho mẹ bầu. C&oacute; c&aacute;c m&oacute;n ăn từ trứng như trứng luộc, trứng r&aacute;n, trứng hấp, canh trứng&hellip;</p>\n<p style="text-align: justify;">&nbsp;</p>\n<p style="text-align: justify;">C&aacute; hồi</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/nhung-thuc-pham-me-bau-nen-an-2.png" alt="" width="493" height="335" /></p>\n<p style="text-align: justify;">C&aacute; hồi cung cấp nhiều DHA</p>\n<p style="text-align: justify;">Trong c&aacute; hồi c&oacute; rất nhiều DHA gi&uacute;p tăng tr&iacute; tuệ v&agrave; rất tốt cho mắt của trẻ. H&atilde;y bổ sung thật nhiều c&aacute; hồi để cơ thể hấp thụ lượng DHA tự nhi&ecirc;n v&agrave; tốt nhất l&agrave; trong 3 th&aacute;ng cuối thai kỳ. Mặc d&ugrave; vậy nhưng qu&aacute; nhiều cũng kh&ocirc;ng tốt. Cần c&acirc;n đối lượng DHA trong c&aacute; ăn hằng ng&agrave;y n&ecirc;n tham khảo b&aacute;c sỹ để c&oacute; chỉ định ph&ugrave; hợp.</p>\n<p style="text-align: justify;">Măng t&acirc;y</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/nhung-thuc-pham-me-bau-nen-an-3.png" alt="" width="550" height="550" /></p>\n<p style="text-align: justify;">Măng t&acirc;y chứa nhiều vitamin D</p>\n<p style="text-align: justify;">Tham khảo: Những lưu &yacute; khi chọn mua đồng hồ cho nam giới&nbsp;&ndash;&nbsp;lựa chọn đồng hồ nam ph&ugrave; hợp với từng người v&agrave; từng ho&agrave;n cảnh.</p>\n<p style="text-align: justify;">Măng t&acirc;y chứa rất nhiều vitamin D l&agrave; chất rất tốt cho hệ thần kinh v&agrave; tr&iacute; n&atilde;o của trẻ. Ngo&agrave;i ra măng t&acirc;y c&ograve;n c&oacute; axit folic v&agrave; folacin l&agrave; hai chất n&agrave;y gi&uacute;p cho qu&aacute; tr&igrave;nh h&igrave;nh th&agrave;nh v&agrave; ph&aacute;t triển c&aacute;c tế b&aacute;o m&aacute;u, ph&ograve;ng tr&aacute;nh khuyết tật ống thần kinh v&agrave; nứt đốt sống ở thai nhi.</p>\n<h2 style="text-align: justify;">sữa chua</h2>\n<p style="text-align: justify;">C&aacute;c sản phẩm từ sữa cung cấp canxi cần thiết cho b&agrave; bầu. Sữa chua c&oacute; nhiều canxi hơn c&aacute;c loại sữa kh&aacute;c n&ecirc;n gi&uacute;p xương của cả mẹ v&agrave; con ph&aacute;t triển. Trong sữa chua c&ograve;n chứa nhiều vitamin B, protein v&agrave; kẽm l&agrave; c&aacute;c chất cần thi&ecirc;&yacute; cho qu&aacute; tr&igrave;nh tăng trưởng v&agrave; ph&aacute;t triển c&aacute;c tế b&agrave;o, hỗ trợ qu&aacute; tr&igrave;nh di truyền, tăng khả năng miễn dịch.</p>\n<h2 style="text-align: justify;">Cam</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/nhung-thuc-pham-me-bau-nen-an-5.png" alt="" width="461" height="434" /></p>\n<h2 style="text-align: justify;">Mỗi ng&agrave;y n&ecirc;n uống một ly nước cam</h2>\n<p style="text-align: justify;">Cam chứa nhiều vitamin C tăng cường miễn dịch, chống cảm v&agrave; gi&uacute;p hấp thụ c&aacute;c chất kh&aacute;c tốt hơn cho mẹ bầu. Mỗi ng&agrave;y n&ecirc;n uống một ly nước cam để bổ sung c&aacute;c dưỡng chất cần thiết như vitamin C, kali, axit folate&hellip;để ngăn ngừa c&aacute;c khuyết tật bẩm sinh, gi&uacute;p thai nhi ph&aacute;t triển khỏe mạnh, tăng cường qu&aacute; tr&igrave;nh trao đổi chất v&agrave; gi&uacute;p mẹ bầu khỏe mạnh</p>\n<p style="text-align: justify;"><strong><em>Ch&uacute;c mẹ v&agrave; b&eacute; mạnh khỏe v&agrave; th&ocirc;ng minh &nbsp;!</em></strong></p>', '2016-01-16 11:11:00', '2016-01-16 11:21:10', 5, 7, 83, '/images/source/thumb/nhung-thuc-pham-me-bau-nen-an-5.png', NULL, '', '', '', '', 'vi', 1, 0, 0, 1, 1),
(62, 'Tại sao Vô sinh ngay cả khi có tinh trùng?', 'Có rất nhiều nguyên nhân dẫn tới việc vô sinh. Tuy nhiên Vô sinh ngay cả khi có tinh trùng thì cũng không phải là chuyện lạ. Bạn đang mắc phải vấn đề này, hãy nghe tư vấn của bác sỹ.', '<h2 style="text-align: justify;">C&oacute; rất nhiều nguy&ecirc;n nh&acirc;n dẫn tới việc v&ocirc; sinh. Tuy nhi&ecirc;n V&ocirc; sinh ngay cả khi c&oacute; tinh tr&ugrave;ng th&igrave; cũng kh&ocirc;ng phải l&agrave; chuyện lạ. Bạn đang mắc phải vấn đề n&agrave;y, h&atilde;y nghe tư vấn của b&aacute;c sỹ.</h2>\n<p style="text-align: justify;">L&acirc;u nay, phụ nữ Việt Nam thường phải g&aacute;nh chịu tất cả lỗi về t&igrave;nh trạng kh&ocirc;ng c&oacute; con. Nhưng theo GS.TS Trần Qu&aacute;n Anh &ndash; Gi&aacute;m đốc Ph&ograve;ng kh&aacute;m Tiết niệu v&agrave; Nam học T&acirc;m Anh, thực tế ho&agrave;n to&agrave;n kh&ocirc;ng phải như vậy. Về mặt số liệu thống k&ecirc;, đ&agrave;n &ocirc;ng v&agrave; đ&agrave;n b&agrave; gặp rắc rối như nhau với v&ocirc; sinh.</p>\n<p style="text-align: justify;">Trong vấn đề v&ocirc; sinh nam th&igrave; c&oacute; nhiều nguy&ecirc;n nh&acirc;n dẫn tới căn bệnh n&agrave;y như: Rối loạn cương dương, nhiễm tr&ugrave;ng hệ tiết niệu &ndash; sinh dục (vi&ecirc;m tinh ho&agrave;n, vi&ecirc;m tuyến tiền liệt&hellip;), những bất thường bẩm sinh về nhiễm sắc thể giới t&iacute;nh hay mắc c&aacute;c tật như kh&ocirc;ng tinh ho&agrave;n, tinh ho&agrave;n kh&ocirc;ng xuống b&igrave;u, tắc ống dẫn tinh, cấu tr&uacute;c bất thường của tinh tr&ugrave;ng&hellip;</p>\n<p style="text-align: justify;"><br />Theo GS.TS Trần Qu&aacute;n Anh th&igrave; cứ 100 cặp vợ chồng th&igrave; c&oacute; 15 cặp kh&ocirc;ng thể c&oacute; con, trong đ&oacute; tr&ecirc;n 50% l&agrave; do nguy&ecirc;n nh&acirc;n từ nam giới v&agrave; tỉ lệ n&agrave;y đang c&oacute; chiều hướng gia tăng mạnh.</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/vo-sinh-ngay-ca-khi-co-tinh-trung.png" alt="" width="450" height="460" /></p>\n<p style="text-align: justify;">Cũng c&oacute; thể do bệnh nh&acirc;n mắc c&aacute;c yếu tố mắc phải như: Nghiện rượu, h&uacute;t thuốc l&aacute;, sau h&oacute;a trị liệu, nhiễm độc tia xạ, gi&atilde;n tĩnh mạch tinh, suy sinh dục (tại tinh ho&agrave;n v&agrave; ngo&agrave;i tinh ho&agrave;n), kh&aacute;ng thể kh&aacute;ng tinh tr&ugrave;ng g&acirc;y hiện tượng ngưng kết v&agrave; bất động tinh tr&ugrave;ng&hellip;.</p>\n<p style="text-align: justify;">Tại c&aacute;c khoa Hiếm muộn của c&aacute;c bệnh viện phụ sản v&agrave; c&aacute;c bệnh viện, ph&ograve;ng kh&aacute;m nam khoa đ&atilde; c&oacute; nhiều nam giới đi c&ugrave;ng vợ đến kh&aacute;m. Tuy nhi&ecirc;n, kh&ocirc;ng phải đấng nam nhi n&agrave;o cũng sẵn s&agrave;ng cho chuyện n&agrave;y.<br />Ho&agrave;ng Minh &ndash; 28 tuổi, kỹ sư tin học &ndash; kh&ocirc;ng thoải m&aacute;i khi xếp h&agrave;ng chờ c&ugrave;ng vợ ở sảnh Bệnh viện Phụ sản H&agrave; Nội. Bắt quen với một thanh ni&ecirc;n kh&aacute;c c&ugrave;ng cảnh ngộ, Ho&agrave;ng ph&agrave;n n&agrave;n:</p>\n<p style="text-align: justify;">&ldquo;Cả nh&agrave; t&ocirc;i lẫn nh&agrave; vợ &eacute;p t&ocirc;i phải đi kh&aacute;m để kh&ocirc;ng ai đổ lỗi do chồng hay vợ. Nhưng n&oacute;i thật, &ocirc;ng xem t&ocirc;i ho&agrave;nh tr&aacute;ng thế n&agrave;y, nh&agrave; t&ocirc;i mấy đời ai cũng đủ nếp đủ tẻ, v&ocirc; sinh thế qu&aacute;i n&agrave;o được&rdquo;.</p>\n<p style="text-align: justify;">Người đ&agrave;n &ocirc;ng được Ho&agrave;ng t&acirc;m sự th&igrave; rụt r&egrave;: &ldquo;Em cũng kh&ocirc;ng r&otilde; thế n&agrave;o nhưng nh&igrave;n thấy bạn em m&atilde;i kh&ocirc;ng c&oacute; con n&ecirc;n m&igrave;nh đi sớm ng&agrave;y n&agrave;o hay ng&agrave;y ấy. Hơn 1 năm vợ em kh&ocirc;ng c&oacute; bầu, em cũng lo lo. Th&ocirc;i, cứ kh&aacute;m cho y&ecirc;n t&acirc;m, kh&ocirc;ng sao th&igrave; c&agrave;ng tốt&rdquo;.</p>\n<h2 style="text-align: justify;">C&agrave;ng giấu, c&agrave;ng kh&oacute; chữa</h2>\n<p style="text-align: justify;">GS.TS Trần Qu&aacute;n Anh cho biết phần lớn nam giới đến Ph&ograve;ng kh&aacute;m đều bắt đầu kh&aacute;m với l&yacute; do trục trặc về sinh l&yacute;. Trong số những người đến kh&aacute;m, qua qu&aacute; tr&igrave;nh l&agrave;m c&aacute;c x&eacute;t nghiệm v&agrave; điều trị mới biết m&igrave;nh kh&ocirc;ng thể c&oacute; con. C&oacute; bệnh nh&acirc;n đ&atilde; &ldquo;sốc&rdquo; khi biết được kết quả n&agrave;y, họ cứ nghĩ rằng nguy&ecirc;n nh&acirc;n kh&ocirc;ng c&oacute; con l&agrave; từ người vợ, chứ kh&ocirc;ng phải do m&igrave;nh.</p>\n<p style="text-align: justify;">C&oacute; những cặp vợ chồng sống với nhau 10 năm kh&ocirc;ng c&oacute; con nhưng khi cần t&igrave;m ra nguy&ecirc;n nh&acirc;n th&igrave; nam giới dứt kho&aacute;t kh&ocirc;ng chịu đi kh&aacute;m v&ocirc; sinh m&agrave; bắt vợ phải đi. Nhiều người vợ tới thăm kh&aacute;m ở b&aacute;c sĩ th&igrave; thở ph&agrave;o v&igrave; m&igrave;nh &ldquo;vẫn chạy tốt&rdquo; nhưng cửa ải kh&oacute; khăn nhất l&agrave; thuyết phục chồng tới bệnh viện kiểm tra.</p>\n<p style="text-align: justify;">BS Hồ Mạnh Tường (Khoa Hiếm muộn, Bệnh viện Từ Dũ) cho biết, v&ocirc; sinh nam l&agrave; một trong những nguy&ecirc;n nh&acirc;n ch&iacute;nh g&acirc;y v&ocirc; sinh. Thiểu năng tinh tr&ugrave;ng chiếm đa số c&aacute;c nguy&ecirc;n nh&acirc;n g&acirc;y v&ocirc; sinh nam. Trong nhiều trường hợp, kết quả nguy&ecirc;n nh&acirc;n hiếm muộn l&agrave; do người chồng c&oacute; bất thường ở cơ quan sinh dục.</p>\n<p style="text-align: justify;">Phần lớn đ&agrave;n &ocirc;ng chỉ nghĩ l&agrave; m&igrave;nh bị &ldquo;trục trặc&rdquo; v&igrave; kh&ocirc;ng hợp với vợ hoặc do m&igrave;nh hơi yếu (?!) V&agrave; cũng v&igrave; c&aacute;i t&ocirc;i &ldquo;bản lĩnh đ&agrave;n &ocirc;ng&rdquo; kh&ocirc;ng thể l&ocirc;i ra để gi&atilde;i b&agrave;y n&ecirc;n nhiều người đ&agrave;nh để &ldquo;c&aacute;i tiếng&rdquo; cho vợ. Sự im lặng v&agrave; kh&ocirc;ng chịu đến c&aacute;c bệnh viện kh&aacute;m chữa của họ đ&atilde; khiến nhiều gia đ&igrave;nh đ&atilde; tan n&aacute;t v&agrave; họ th&igrave; ng&agrave;y c&agrave;ng &ldquo;mắc kẹt&rdquo;. Chỉ đến khi niềm mong mỏi c&oacute; mụn con &ldquo;nối d&otilde;i&rdquo; trở n&ecirc;n qu&aacute; xa vời họ mới chịu đến t&igrave;m b&aacute;c sĩ.</p>\n<h2 style="text-align: justify;">Thăm kh&aacute;m, điều trị ngay khi sau 1 năm kh&ocirc;ng c&oacute; con</h2>\n<p style="text-align: justify;">Điều đ&aacute;ng quan t&acirc;m l&agrave; c&oacute; những cặp vợ chồng đ&atilde; đi kh&aacute;m v&agrave; được kết luận l&agrave; b&igrave;nh thường nhưng vẫn kh&ocirc;ng thể c&oacute; con. Trong c&aacute;c nghi&ecirc;n cứu ở cả trong v&agrave; ngo&agrave;i nước, c&oacute; khoảng 10% cặp vợ chồng v&ocirc; sinh được chẩn đo&aacute;n chưa r&otilde; nguy&ecirc;n nh&acirc;n. Ch&iacute;nh điều đ&oacute; c&agrave;ng khiến c&aacute;c cặp n&agrave;y lo lắng, vấn đề băn khoăn nhất của họ l&agrave; b&igrave;nh thường nhưng kh&ocirc;ng c&oacute; con th&igrave; liệu c&oacute; phải điều trị?</p>\n<p style="text-align: justify;">C&aacute;c chuy&ecirc;n gia vẫn khuy&ecirc;n, đối với c&aacute;c trường hợp được kết luận l&agrave; v&ocirc; sinh th&igrave; n&ecirc;n điều trị từ những biện ph&aacute;p đơn giản nhất, như bơm tinh tr&ugrave;ng v&agrave;o buồng tử cung c&oacute; kết hợp k&iacute;ch th&iacute;ch buồng trứng&hellip;</p>\n<p style="text-align: justify;">&Aacute;p lực c&ocirc;ng việc, sự thay đổi m&ocirc;i trường sống đang t&aacute;c động mạnh đến &ldquo;thi&ecirc;n chức&rdquo; của c&aacute;c qu&yacute; &ocirc;ng, kh&ocirc;ng ph&acirc;n biệt tuổi t&aacute;c, th&agrave;nh phần. Sự gia tăng đ&aacute;ng lo ngại chứng bệnh nam khoa, bệnh v&ocirc; sinh ở nam giới đe doạ sự bền vững của c&aacute;c tổ ấm gia đ&igrave;nh.</p>\n<p style="text-align: justify;">GS Trần Qu&aacute;n Anh cho hay, kh&ocirc;ng c&oacute; một toa thuốc n&agrave;o duy nhất chữa cho mọi bệnh nh&acirc;n v&ocirc; sinh. Tốt nhất, nếu một năm sau khi cưới m&agrave; chưa c&oacute; con, cả hai vợ chồng c&ugrave;ng n&ecirc;n đi kh&aacute;m để t&igrave;m nguy&ecirc;n nh&acirc;n v&agrave; chữa trị sớm. Đặc biệt, với c&aacute;c qu&yacute; &ocirc;ng, khi gặp những vấn đề trục trặc về y học t&igrave;nh dục, khả năng sinh con, h&atilde;y vượt qua ngại ngần t&igrave;m đến cơ sở kh&aacute;m chữa bệnh chuy&ecirc;n khoa để được tư vấn v&agrave; điều trị.</p>\n<p style="text-align: justify;">Khảo s&aacute;t cho thấy, c&oacute; 44% trong số cặp vợ chồng Việt Nam kh&ocirc;ng c&oacute; con kh&ocirc;ng t&igrave;m kiếm việc điều trị, để c&oacute; thai, m&agrave; vẫn tin v&agrave;o may mắn.</p>\n<p style="text-align: justify;">Thậm ch&iacute;, 30% phụ nữ Việt Nam được khảo s&aacute;t, đ&atilde; cố gắng c&oacute; thai hơn 6 th&aacute;ng, m&agrave; vẫn kh&ocirc;ng biết trung t&acirc;m sức khỏe sinh sản gần nhất nằm ở đ&acirc;u.</p>\n<p style="text-align: justify;">Trong một khảo s&aacute;t t&igrave;nh trạng hiếm muộn với 1.000 phụ nữ ch&acirc;u &Aacute;, trong đ&oacute; c&oacute; cả Việt Nam, do Merck Sorono (Đức) phối hợp với Bệnh viện Đại học Quốc gia ở Singapore nghi&ecirc;n cứu đ&atilde; n&ecirc;u r&otilde; hạn chế về nhận thức của phụ nữ Việt Nam về vấn đề v&ocirc; sinh v&agrave; l&agrave; nguy&ecirc;n nh&acirc;n khiến phụ nữ chậm chọn lựa điều trị v&ocirc; sinh v&agrave; phải chịu nhiều hậu quả.</p>\n<p style="text-align: justify;">Đ&aacute;ng lo ngại khi tới 83% phụ nữ Việt Nam kh&ocirc;ng nghi ngờ t&igrave;nh trạng sinh sản của người chồng v&agrave; 70% phụ nữ được khảo s&aacute;t kh&ocirc;ng nghi ngờ t&igrave;nh trạng sinh sản của họ.</p>\n<p style="text-align: justify;">C&oacute; tới 56% kh&ocirc;ng biết rằng, đ&agrave;n &ocirc;ng c&oacute; thể v&ocirc; sinh ngay cả khi anh ta c&oacute; thể sản xuất ra tinh tr&ugrave;ng, cũng như vẫn cương dương; 54% phụ nữ kh&ocirc;ng biết rằng l&agrave; c&aacute;c c&aacute;c cặp vợ chồng được xem l&agrave; v&ocirc; sinh nếu kh&ocirc;ng c&oacute; thai sau một năm cố gắng.</p>\n<p style="text-align: justify;"><em><strong>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng - Sức khỏe</strong></em></p>', '2016-01-16 11:34:00', '2016-01-16 11:40:44', 5, 8, 340, '/images/source/thumb/vo-sinh-ngay-ca-khi-co-tinh-trung.png', NULL, 'Tại sao Vô sinh ngay cả khi có tinh trùng?', '', 'Có rất nhiều nguyên nhân dẫn tới việc vô sinh. Tuy nhiên Vô sinh ngay cả khi có tinh trùng thì cũng không phải là chuyện lạ. Bạn đang mắc phải vấn đề này, hãy nghe tư vấn của bác sỹ.', '', 'vi', 1, 0, 0, 1, 1),
(63, 'Bí quyết hồi xuân với mặt nạ dưỡng da cực dễ làm', 'Bí quyết hồi xuân với mặt nạ dưỡng da cực dễ làm nhưng mang lại hiệu quả cao giúp bạn đón xuân với nét đẹp tự nhiên', '<h2>B&iacute; quyết hồi xu&acirc;n với mặt nạ dưỡng da cực dễ l&agrave;m nhưng mang lại hiệu quả cao gi&uacute;p bạn đ&oacute;n xu&acirc;n với n&eacute;t đẹp tự nhi&ecirc;n</h2>\n<p>Sẽ thật kh&oacute; chịu khi nh&igrave;n thấy l&agrave;n da của bạn bị sạm đi v&agrave; thiếu đi sức sống. T&agrave;n nhang, vết n&aacute;m l&agrave; "thủ phạm" lấy đi tuổi thanh xu&acirc;n của c&aacute;c chị em. Trước khi những "kẻ th&ugrave;" của l&agrave;n da khiến gương mặt của b&agrave;n gi&agrave; đi, chị em h&atilde;y d&agrave;nh ch&uacute;t &iacute;t thời gian chăm ch&uacute;t cho ch&iacute;nh m&igrave;nh, tự l&agrave;m mặt nạ để đẩy l&ugrave;i "n&eacute;t thời gian" tr&ecirc;n gương mặt.</p>\n<p>Chuối, yến mạch, mật ong hay nước cam đều l&agrave; những nguy&ecirc;n liệu kh&ocirc;ng thể kh&ocirc;ng thiếu trong nh&agrave; bếp. Dưới đ&acirc;y l&agrave; những c&ocirc;ng thức đơn giản, cực kỳ dễ l&agrave;m gi&uacute;p chị em lấy lại sắc xu&acirc;n tr&ecirc;n gương mặt.</p>\n<h2>Mặt nạ chuối - nước cam - mật ong</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/hoi-xuan-voi-mat-na-duong-da-cuc-de-lam-1.png" alt="" width="500" height="440" /></p>\n<p>Đ&acirc;y l&agrave; loại mặt nạ l&agrave;m đẹp cho mọi loại da, gi&uacute;p l&agrave;n da lấy lại vẻ tươi s&aacute;ng v&agrave; khỏe khoắn</p>\n<h2>Mặt nạ đu đủ</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/hoi-xuan-voi-mat-na-duong-da-cuc-de-lam-2.png" alt="" width="500" height="440" /></p>\n<p>Mặt nạ đu đủ - mật ong l&agrave; vị cứu tinh cho n&agrave;ng n&agrave;o da sạm, da n&aacute;m v&agrave; t&agrave;n nhang. Đu đủ gi&uacute;p tẩy tế b&agrave;o chết đem lại l&agrave;n da mềm mại, kh&ocirc;ng t&igrave; vết</p>\n<h2>Mặt nạ mật ong- nước cam</h2>\n<h2><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/hoi-xuan-voi-mat-na-duong-da-cuc-de-lam-3.png" alt="" width="500" height="440" /></h2>\n<p>C&aacute;ch nhanh nhất để lấy lại l&agrave;n da trắng s&aacute;ng l&agrave; đắp hỗn hợp mật ong - nước cam</p>\n<h2>Mặt nạ yến mạch - l&ograve;ng đỏ trứng-dầu oliu</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/hoi-xuan-voi-mat-na-duong-da-cuc-de-lam-4.png" alt="" width="500" height="440" /></p>\n<p>Hỗn hợp yến mạch, mật ong, dầu oliu, l&ograve;ng đỏ trứng gi&agrave;u h&agrave;m lượng protein, gi&uacute;p kiềm dầu v&agrave; ph&ugrave; ph&eacute;p cho l&agrave;n da s&aacute;ng b&oacute;ng</p>\n<p><em><strong>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng v&agrave; lu&ocirc;n xinh đẹp</strong></em></p>', '2016-01-16 11:45:00', '2016-02-23 09:20:42', 3, 9, 78, '/images/source/thumb/hoi-xuan-voi-mat-na-duong-da-cuc-de-lam-3.png', NULL, 'Bí quyết hồi xuân với mặt nạ dưỡng da cực dễ làm', '', 'Bí quyết hồi xuân với mặt nạ dưỡng da cực dễ làm nhưng mang lại hiệu quả cao giúp bạn đón xuân với nét đẹp tự nhiên', '', 'vi', 1, 0, 0, 1, 5),
(64, 'Bí quyết giúp bạn tiệc tùng thả ga ngày Tết không lo tăng cân', 'Bí quyết giúp bạn tiệc tùng thả ga ngày Tết không lo tăng cân bạn có tin không. Hãy cùng thành xuân dược khám phá 8 bí quyết này', '<p><h2 style="text-align: justify;">B&iacute; quyết gi&uacute;p bạn tiệc t&ugrave;ng thả ga ng&agrave;y Tết kh&ocirc;ng lo tăng c&acirc;n bạn c&oacute; tin kh&ocirc;ng. H&atilde;y c&ugrave;ng th&agrave;nh xu&acirc;n dược kh&aacute;m ph&aacute; 8 b&iacute; quyết n&agrave;y</h2> <p style="text-align: justify;">Cần phải biết ăn uống một c&aacute;ch hợp l&yacute;, kết hợp với một số kỹ năng để thỏa sức tham gia c&aacute;c buổi tiệc t&ugrave;ng, hội họp m&agrave; vẫn giữ được v&oacute;c d&aacute;ng như mong muốn.</p> <p style="text-align: justify;">Những ng&agrave;y nghỉ lễ, đặc biệt l&agrave; dịp Tết sắp đến,&nbsp;thường l&agrave; nỗi lo sợ của những người muốn giảm c&acirc;n. Thực tế, th&igrave; m&ugrave;a n&agrave;o cũng c&oacute; c&aacute;c bữa tiệc, c&aacute;c cuộc họp hay c&aacute;c buổi lễ kỷ niệm. Bạn kh&ocirc;ng thể bỏ qua được những cuộc vui như thế, v&igrave; thế bạn cần học c&aacute;ch sống chung với ch&uacute;ng v&agrave; duy tr&igrave; một chế độ ăn hợp l&yacute; cho m&igrave;nh.</p> <p style="text-align: justify;">Nhiều người nghĩ cứ&nbsp;ăn thả ga rồi sẽ tập luyện cường độ cao từ ng&agrave;y h&ocirc;m sau. Điều đ&oacute; l&agrave; v&ocirc; nghĩa. H&atilde;y l&agrave;m theo 8 b&iacute; quyết dưới đ&acirc;y để bạn vừa c&oacute; thể c&oacute; những cuộc vui trọn vẹn&nbsp;vừa c&oacute; thể giữ được v&oacute;c d&aacute;ng.</p> <p style="text-align: justify;"><strong>1. N&oacute;i chuyện l&agrave;m quen&nbsp;trước khi ăn</strong></p> <p><span class="img-share"><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/bi-quyet-tiec-tung-tha-ga-khong-lo-tang-can-1.png" alt="" width="500" height="333" /><br /><br /></span></p> <p style="text-align: justify;">Đừng bao giờ chăm ch&uacute; lu&ocirc;n v&agrave;o thức ăn hay đồ uống ngay khi bạn đến một buổi tiệc. H&atilde;y giết thời gian bằng c&aacute;ch h&ograve;a m&igrave;nh v&agrave;o mọi người, với chủ nh&agrave; hoặc c&aacute;c vị kh&aacute;ch kh&aacute;c. Nếu bạn kh&ocirc;ng biết nhiều người ở đ&oacute;, h&atilde;y chủ động tự giới thiệu bản th&acirc;n. Bạn c&agrave;ng n&oacute;i chuyện nhiều, th&igrave; thời gian ăn của bạn c&agrave;ng &iacute;t đi. V&igrave; thế b&iacute; quyết ở đ&acirc;y l&agrave; h&atilde;y tập trung v&agrave;o con người, kh&ocirc;ng phải l&agrave; v&agrave;o đồ ăn.</p> <p style="text-align: justify;"><strong>2. Uống thật nhiều nước</strong></p> <p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/bi-quyet-tiec-tung-tha-ga-khong-lo-tang-can-2.png" alt="" width="500" height="333" /></p> <p style="text-align: justify;">Uống nước nhiều gi&uacute;p bạn cảm thấy no v&agrave; giảm lượng thức ăn nạp v&agrave;o cơ thể</p> <p style="text-align: justify;">Uống nước sẽ l&agrave;m bạn mau ch&oacute;ng c&oacute; cảm gi&aacute;c no, gi&uacute;p&nbsp;giảm lượng thức ăn nạp v&agrave;o cơ thể&nbsp;trong c&aacute;c buổi tiệc. Điều quan trọng l&agrave; mọi người thường nhầm lẫn giữa kh&aacute;t v&agrave; đ&oacute;i, n&ecirc;n thường ăn c&aacute;i g&igrave; đ&oacute; thay v&igrave; uống nước. Thế n&ecirc;n lu&ocirc;n nhớ rằng cần uống cốc nước trước khi ăn.</p> <p style="text-align: justify;"><strong>3. L&agrave;m m&igrave;nh bận rộn với những thứ kh&aacute;c</strong></p> <p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/bi-quyet-tiec-tung-tha-ga-khong-lo-tang-can-3.png" alt="" width="500" height="333" /></p> <p style="text-align: justify;">Bạn c&oacute; thể chơi game để giảm thời gian ăn uống của m&igrave;nh</p> <p style="text-align: justify;">Một khi bạn đ&atilde; bắt đầu ăn tại một buổi tiệc, thật kh&oacute; c&oacute; thể cưỡng lại. Thức ăn tiệc thường ngon v&agrave; tr&ocirc;ng hấp dẫn. Để giảm thời gian ăn uống, h&atilde;y tập trung v&agrave;o một việc kh&aacute;c. Chẳng hạn, nếu c&oacute; một nh&oacute;m người đang chơi game, h&atilde;y lại gần v&agrave; c&ugrave;ng tham gia. Nếu chưa c&oacute; hoạt động n&agrave;o, h&atilde;y l&agrave; người khởi xướng. Điếu đ&oacute; sẽ gi&uacute;p bạn kh&ocirc;ng nghĩ tới đồ ăn trong nhiều&nbsp;giờ.</p> <p style="text-align: justify;"><strong>4. Tr&aacute;nh đồ uống c&oacute; cồn</strong></p> <p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/bi-quyet-tiec-tung-tha-ga-khong-lo-tang-can-4.png" alt="" width="500" height="333" /></p> <p style="text-align: justify;">N&ecirc;n hạn chế đồ uống c&oacute; cồn nếu bạn muốn duy tr&igrave; v&oacute;c d&aacute;ng. Nếu muốn uống một c&aacute;i g&igrave; đ&oacute;, kh&ocirc;ng n&ecirc;n uống một c&aacute;ch x&ocirc; bồ. Thay v&agrave;o đ&oacute; h&atilde;y nh&acirc;m nhi v&agrave; thưởng thức n&oacute; l&acirc;u hơn. Bạn cũng n&ecirc;n cẩn thận với những đồ uống c&oacute; ga. Uống qu&aacute; nhiều bất cứ thứ g&igrave; cũng đều kh&ocirc;ng&nbsp;hiệu quả cho chế độ ăn ki&ecirc;ng của bạn. Nước lu&ocirc;n l&agrave; đồ uống được ưu ti&ecirc;n số 1.</p> <p style="text-align: justify;">Bạn c&oacute; thể nghĩ tốt hơn n&ecirc;n ăn nhẹ hoặc kh&ocirc;ng ăn g&igrave; trước khi tham dự tiệc. Nhưng đ&oacute; l&agrave; một sai lầm m&agrave; nhiều người mắc phải. Bởi khi đến bữa tiệc cũng l&agrave; l&uacute;c bạn cảm thấy đ&oacute;i. Mọi thứ trước mắt bạn đều hấp dẫn v&agrave; kh&ocirc;ng g&igrave; c&oacute; thể cưỡng lại. Bạn kh&ocirc;ng bao giờ n&ecirc;n đến cửa h&agrave;ng tạp h&oacute;a khi đang đ&oacute;i, v&igrave; thế cũng đừng bao giờ tới dự tiệc với một c&aacute;i bụng trống rỗng. Bữa ăn s&aacute;ng của bạn n&ecirc;n đầy đủ chất dinh dưỡng.</p> <p style="text-align: justify;"><strong>6. Ăn chậm</strong></p> <p style="text-align: justify;">Nếu vội v&atilde; ăn một đĩa thức ăn trong v&ograve;ng v&agrave;i ph&uacute;t, bạn nghĩ m&igrave;nh vẫn đ&oacute;i v&agrave; lại tiếp tục ăn. H&atilde;y ăn chậm v&agrave; nhai kỹ thức ăn để gi&uacute;p ti&ecirc;u h&oacute;a tốt, mang lại một th&acirc;n h&igrave;nh như mong muốn.</p> <p style="text-align: justify;"><strong>7. Ăn nhiều rau v&agrave; tr&aacute;i c&acirc;y</strong></p> <p style="text-align: justify;">H&atilde;y cho đầy đĩa thức ăn của bạn bằng rau v&agrave; tr&aacute;i c&acirc;y, gi&uacute;p bạn tr&aacute;nh ăn nhiều những thức ăn g&acirc;y b&eacute;o. Với c&aacute;c thực phẩm dễ l&agrave;m tăng c&acirc;n th&igrave; n&ecirc;n ăn một lượng nhỏ. H&atilde;y chỉ&nbsp;lấy một l&aacute;t b&aacute;nh mỏng hoặc chia sẻ bớt&nbsp;với bạn b&egrave;, người th&acirc;n của m&igrave;nh. Hoặc thay v&igrave; ăn ba chiếc b&aacute;nh, th&igrave; h&atilde;y chỉ ăn một chiếc</p> <p style="text-align: justify;"><strong>8. Tập luyện trước ng&agrave;y tiệc</strong></p> <p style="text-align: justify;">Để cảm thấy hứng th&uacute; hơn khi đi tiệc v&agrave; &lsquo;nu&ocirc;ng chiều&rsquo; bản th&acirc;n một ch&uacute;t, bạn n&ecirc;n tập luyện trước. L&agrave;m tăng qu&aacute; tr&igrave;nh trao đổi chất lu&ocirc;n l&agrave; c&aacute;ch l&agrave;m tốt nhất. Bạn c&oacute; thể sẽ&nbsp;đưa ra sự lựa chọn thức ăn đ&uacute;ng đắn hơn v&igrave; kh&ocirc;ng muốn l&agrave;m lại c&ocirc;ng việc tập luyện vất vả của m&igrave;nh.</p> <p style="text-align: justify;"><strong><em>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng !</em></strong></p></p>', '2016-01-16 11:52:00', '2016-01-16 12:00:09', 3, 10, 375, '/images/source/thumb/bi-quyet-tiec-tung-tha-ga-khong-lo-tang-can-1.jpg', NULL, 'Bí quyết giúp bạn tiệc tùng thả ga ngày Tết không lo tăng cân', '', 'Bí quyết giúp bạn tiệc tùng thả ga ngày Tết không lo tăng cân bạn có tin không. Hãy cùng thành xuân dược khám phá 8 bí quyết này', '', 'vi', 1, 0, 0, 1, 1),
(67, '6 Cách trị đau đầu không cần dùng thuốc', 'Với những ai đang bị cơn đau đầu hàng hạ cả ngày thì bạn hiểu cảm giác đó khó chịu như thế nào, Bạn không thể tập trung cho bất cứ việc gì chỉ vì cơn đau đầu hành hạ', '<p>Với những ai đang bị cơn đau đầu h&agrave;ng hạ cả ng&agrave;y th&igrave; bạn hiểu cảm gi&aacute;c đ&oacute; kh&oacute; chịu như thế n&agrave;o, Bạn kh&ocirc;ng thể tập trung cho bất cứ việc g&igrave; chỉ v&igrave; cơn đau đầu h&agrave;nh hạ.</p>\n<p>Với những ai đang bị cơn đau đầu h&agrave;ng hạ cả ng&agrave;y th&igrave; bạn hiểu cảm gi&aacute;c đ&oacute; kh&oacute; chịu như thế n&agrave;o, Bạn kh&ocirc;ng thể tập trung cho bất cứ việc g&igrave; chỉ v&igrave; cơn đau đầu h&agrave;nh hạ. C&oacute; nhiều người đ&atilde; nghĩ tới việc d&ugrave;ng thuốc, tuy nhi&ecirc;n nhưng lợi &iacute;ch tức th&igrave; n&oacute; mang lại th&igrave; ai cũng biết nhưng những hệ quả sau n&agrave;y th&igrave; &iacute;t người nghĩ tới.</p>\n<p>Đấy l&agrave; l&yacute; do tại sao Thanh Xu&acirc;n Dược khuy&ecirc;n bạn n&ecirc;n sử dụng c&aacute;c sản phẩm tự nhi&ecirc;n, Những mẹo tự nhi&ecirc;n đơn giản, nhưng lại mang lại hiệu quả l&acirc;u d&agrave;i</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/6-cach-tri-dau-dau-khong-can-dung-thuoc_1.jpg" alt="" width="500" height="466" /></p>\n<ol>\n<li>\n<h3>Trị đau đầu bằng Nước</h3>\n</li>\n</ol>\n<p>Đ&ocirc;i khi l&agrave;m việc mệt mỏi, căng thẳng c&oacute; thể dẫn tới đau đầu, mỗi ng&agrave;y thức dậy bạn n&ecirc;n uống một cốc nước để c&oacute; thể cung cấp đủ nước cho cơ thể. Để cơ thể lu&ocirc;n tr&agrave;n đầy năng lượng bạn n&ecirc;n sử dụng mỗi ng&agrave;y từ 5-8 ly nước mỗi ng&agrave;y gi&uacute;p ngăn ngừa chứng đau đầu m&agrave; lại tốt cho sức khỏe.</p>\n<ol start="2">\n<li>\n<h3>Trị đau đầu bằng Tắm nước ấm</h3>\n</li>\n</ol>\n<p>Một c&aacute;ch c&oacute; thể gi&uacute;p bạn tho&aacute;t khỏi chứng đau đầu kinh ni&ecirc;n đ&oacute; l&agrave; tắm nước ấm hằng ng&agrave;y, bạn n&ecirc;n trang bị cho nh&agrave; tắm của m&igrave;nh một cheiecs v&ograve;i tắm hoa sen, v&ograve;i hoa sen sẽ gi&uacute;p bạn massage cơ thể, nước ấm sẽ gi&uacute;p cho đầu &oacute;c của bạn trở n&ecirc;n linh hoạt hơn, x&oacute;a tan mệt mỏi, căng thẳng. Sau đ&oacute; bạn sử dụng 2 ng&oacute;n tay xoay nhẹ 2 v&ugrave;ng th&aacute;i dương gần mắt, l&agrave;m đi l&agrave;m lại khoảng 10 lần, sẽ thấy dễ chịu hơn.</p>\n<ol start="3">\n<li>\n<h3>Trị đau đầu bằng khăn ấm</h3>\n</li>\n</ol>\n<p>C&aacute;ch n&agrave;y kh&aacute; đơn giản v&agrave; dễ l&agrave;m bằng c&aacute;ch sử dụng khăn ấm v&agrave; sau đ&oacute; bạn nhỏ một &iacute;t tinh dầu bạc h&agrave; v&agrave; đắp l&ecirc;n tr&aacute;n, sau đ&oacute; nằm im khoảng từ 15 &ndash; 20 ph&uacute;t sẽ thấy hiệu quả ngay.</p>\n<ol start="4">\n<li>\n<h3>Trị đau đầu bằng bấm huyệt</h3>\n</li>\n</ol>\n<p>Đối với c&aacute;ch n&agrave;y th&igrave; bạn c&oacute; thể nhờ những người c&oacute; kinh nghiệm để gi&uacute;p bạn thực hiện việc bấm huyệt ở đầu, nhờ đ&oacute; gi&uacute;p căng thẳng, mệt mỏi, bấm huyệt gi&uacute;p cho lượng m&aacute;u được lưu th&ocirc;ng tốt v&agrave; đồng thời t&aacute;c động v&agrave;o c&aacute;c d&acirc;y thần kinh l&agrave;m dịu cơn đau ngay lập tức.</p>\n<ol start="6">\n<li>\n<h3>Trị đau đầu bằng đ&aacute; lạnh</h3>\n</li>\n</ol>\n<p>V&agrave;o m&ugrave;a h&egrave; do trời nắng qu&aacute;, bạn bị đau đầu ch&oacute;ng mặt bạn thực hiện theo c&aacute;ch n&agrave;y sẽ đỡ hơn rất nhiều bằng c&aacute;ch: sử dụng khăn sau đ&oacute; cho v&agrave;i vi&ecirc;n đ&aacute; nhỏ v&agrave;o, v&agrave; chườm đi chườm lại khoảng 5 ph&uacute;t, bởi v&igrave; bộ n&atilde;o của ch&uacute;ng ta khi c&aacute;i lạnh k&iacute;ch th&iacute;ch khiến ch&uacute;ng ta kh&ocirc;ng c&ograve;n nghĩ tới cơn đau.</p>\n<p>Đau đầu l&agrave; một trong những căn bệnh gặp ở rất nhiều người, n&oacute; ảnh hưởng trực tiếp tới chất lượng cuộc sống hằng ng&agrave;y, c&oacute; rất nhiều nguy&ecirc;n nh&acirc;n dẫn tới đau đầu thường th&igrave; mọi người sẽ đi mua thuốc ở ngo&agrave;i hiệu thuốc m&agrave; bỏ qua một số c&aacute;c phương ph&aacute;p đơn giản từ thi&ecirc;n nhi&ecirc;n c&oacute; thể điều trị dứt điểm.</p>\n<p>Tr&ecirc;n đ&acirc;y l&agrave; một số c&aacute;ch trị đau đầu, bạn c&oacute; thể thực hiện tại nh&agrave;, tuy nhi&ecirc;n th&igrave; những c&aacute;ch n&agrave;y chỉ c&oacute; thể điều trị tạm thời, nếu bạn bị đau đầu trong thời gian d&agrave;i m&agrave; vẫn kh&ocirc;ng khỏi th&igrave; n&ecirc;n t&igrave;m một loại thuốc, thảo được c&oacute; nguồn gốc từ thi&ecirc;n nhi&ecirc;n c&oacute; thể điều trị dứt điểm bệnh đau đầu n&agrave;y.</p>\n<p>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng v&agrave; lu&ocirc;n mạnh khỏe!</p>', '2016-01-18 11:58:00', '2016-02-25 00:13:39', 2, 13, 68, '/images/source/thumb/6-cach-tri-dau-dau-khong-can-dung-thuoc.jpg', NULL, '6 Cách trị đau đầu không cần dùng thuốc', '', 'Với những ai đang bị cơn đau đầu hàng hạ cả ngày thì bạn hiểu cảm giác đó khó chịu như thế nào, Bạn không thể tập trung cho bất cứ việc gì chỉ vì cơn đau đầu hành hạ', '', 'vi', 1, 0, 0, 1, 5),
(68, '5 cách chữa đau họng không cần dùng thuốc', 'Cách chữa đau họng không cần dùng thuốc nhưng mang lại hiệu quả cao và đặc biệt rất dễ sử dụng', '<p>Khi v&agrave;o thời điểm giao m&ugrave;a, c&oacute; rất nhiều người thường cảm thấy kh&oacute; chịu với bệnh đau họng, nếu kh&ocirc;ng được điều trị sớm bệnh t&aacute;i ph&aacute;t c&oacute; thể chuyển th&agrave;nh m&atilde;n t&iacute;nh. Dưới đ&acirc;y ch&uacute;ng t&ocirc;i sẽ tư vấn cho c&aacute;c bạn một v&agrave;i c&aacute;ch chữa đau họng hiệu quả c&oacute; thể &aacute;p dụng ngay sauy khi đọc b&agrave;i viết n&agrave;y.</p>\n<h2>Nguy&ecirc;n nh&acirc;n đau họng do đ&acirc;u?</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/5-cach-chua-dau-hong-khong-can-dung-thuoc-1.jpg" alt="" width="585" height="404" /></p>\n<p>C&oacute; rất nhiều nguy&ecirc;n nh&acirc;n dẫn tới đau họng như do nhiễm khuẩn hoặc dị ứng, v&agrave; cũng c&oacute; thể do uống nước đ&aacute; lạnh hoặc do c&uacute;m, cảm lạnh. Khi bị đau họng th&igrave; bạn c&oacute; thể l&agrave;m giảm c&aacute;c cơn đau bằng c&aacute;c biện ph&aacute;p tự nhi&ecirc;n sẽ gi&uacute;p bạn kh&ocirc;ng bị đau họng, bạn c&oacute; thể &aacute;p dụng một số c&aacute;ch dưới đ&acirc;y:</p>\n<h3>Nước muối</h3>\n<p>Nước muối c&oacute; t&aacute;c dụng trong việc l&agrave;m giảm đau họng. Bạn c&oacute; thể thực hiện bằng c&aacute;ch: pha nước muối với nước đun s&ocirc;i để nguội khoảng 30 gi&acirc;y, sau đ&oacute; s&uacute;c miệng khoảng 2-3 lần, khi s&uacute;c miệng th&igrave; phải ngửa cổ ra đến mức tối đa để nước muối chạm tới th&agrave;nh họng, cứ thực hiện như thế, sau v&agrave;i ng&agrave;y th&igrave; bạn sẽ kh&ocirc;ng c&ograve;n cảm gi&aacute;c đau, r&aacute;t cổ họng nữa.</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/5-cach-chua-dau-hong-khong-can-dung-thuoc-2.jpg" alt="" width="600" height="337" /></p>\n<p>Với những người bị vi&ecirc;m họng trong thời gian d&agrave;i th&igrave; n&ecirc;n đi tới bệnh viện để thăm kh&aacute;m v&agrave; điều trị theo lộ tr&igrave;nh của b&aacute;c sĩ v&agrave; kết hợp với nước muối sẽ l&agrave;m bệnh lui nhanh hơn.</p>\n<h3>Mật ong</h3>\n<p>Mật ong chứa rất nhiều vitamin c&oacute; lợi cho sức khỏe, miễn dịch tốt, v&agrave; l&agrave; một trong những sản phẩm gi&uacute;p chị em l&agrave;m đẹp. Sử dụng mật ong trong việc điều trị vi&ecirc;m họng l&agrave; một c&aacute;ch kh&aacute; hữu hiệu bạn kh&ocirc;ng n&ecirc;n bỏ qua, mật ong cũng giống như một loại thuốc gi&uacute;p kh&aacute;n khuẩn v&agrave; chống vi&ecirc;m nhiễm rất tốt. Vị ngọt của mật ong c&oacute; t&aacute;c dụng l&agrave;m cho cổ hỏng kh&ocirc;ng bị ngứa, r&aacute;t v&agrave; l&agrave;m giảm đau v&agrave; c&aacute;c acid amin v&agrave; c&aacute;c kho&aacute;ng chất c&oacute; trong cơ thể gi&uacute;p đề kh&aacute;ng tốt.</p>\n<p>Bạn c&oacute; thể pha một th&igrave;a mật ong v&agrave; 1 th&igrave;a nước cốt chanh, h&ograve;a tan v&agrave;o nhau, sau đ&oacute; sử dụng 2 lần s&aacute;ng v&agrave; tối, thực hiện như thế sau v&agrave;i lần sẽ thấy sự kh&aacute;c biệt.</p>\n<h3>Gừng</h3>\n<p>Gừng l&agrave; một trong những b&agrave;i thuốc d&acirc;n gian hiệu quả bạn c&oacute; thể sử dụng để điều trị vi&ecirc;m họng bằng c&aacute;ch sau: cho khoảng 3-5 l&aacute;t gừng mỏng v&agrave;o 1 cốc nước s&ocirc;i, để khoảng 10 ph&uacute;t v&agrave; uống, sau một thời gian sẽ thấy ngay hiệu quả.</p>\n<h3>Thức ăn</h3>\n<p>Bạn n&ecirc;n lựa chọn những loại đồ ăn dạng lỏng như ch&aacute;o hoặc s&uacute;p cho người mắc bệnh vi&ecirc;m họng v&igrave; những thức ăn dạng n&agrave;y l&agrave;m giảm k&iacute;ch th&iacute;ch ni&ecirc;m mạc gi&uacute;p giảm đau họng.</p>\n<h2>Lưu &yacute; trong khi bị vi&ecirc;m họng:</h2>\n<p>Tr&aacute;nh bia, rượu v&agrave; kh&ocirc;ng h&uacute;t thuốc</p>\n<p>Kh&ocirc;ng n&ecirc;n uống nước đ&aacute; hay đồ lạnh, tắm nước qu&aacute; lạnh, hoặc ở trong ph&ograve;ng điều h&ograve;a thấp dễ g&acirc;y vi&ecirc;m họng.</p>\n<p>S&uacute;c miệng bằng nước muối trước khi đi ngủ v&agrave; buổi s&aacute;ng khi thức dậy.</p>\n<p>Tr&ecirc;n đ&acirc;y l&agrave; một số c&aacute;ch gi&uacute;p điều trị bệnh vi&ecirc;m họng hiệu quả. Bạn c&oacute; thể &aacute;p dụng ngay tại nh&agrave;. Hy vọng với b&agrave;i viết tr&ecirc;n sẽ gi&uacute;p cho c&aacute;c bạn c&oacute; th&ecirc;m kiến thức về việc chăm s&oacute;c sức khỏe cho bạn v&agrave; gia đ&igrave;nh bạn.</p>\n<p>Ch&uacute;c c&aacute;c bạn th&agrave;nh c&ocirc;ng!</p>', '2016-01-18 12:35:00', '2016-02-23 17:50:22', 2, 14, 354, '/images/source/thumb/5-cach-chua-dau-hong-khong-can-dung-thuoc-1.jpg', NULL, '5 cách chữa đau họng không cần dùng thuốc', '', '5 cách chữa đau họng không cần dùng thuốc nhưng mang lại hiệu quả cao và đặc biệt rất dễ sử dụng', '', 'vi', 1, 0, 0, 1, 5),
(69, 'cách trị hôi nách bằng phèn chua hiệu quả', 'Hiện nay có rất nhiều bài thuốc hay trị hôi nách hiệu quả. Thanh Xuân Dược sẽ giới thiệu bạn cách trị hôi nách với phèn chua', '<p style="text-align: justify;">Với những ai đang bị h&ocirc;i n&aacute;ch sẽ cảm nhận thấy r&otilde;. Bạn lu&ocirc;n cảm gi&aacute;c mất tự tin khi giao tiếp, cảm thấy kh&oacute; chịu. Hiện nay c&oacute; rất nhiều b&agrave;i thuốc hay trị h&ocirc;i n&aacute;ch hiệu quả. Thanh Xu&acirc;n Dược sẽ giới thiệu bạn c&aacute;ch trị h&ocirc;i n&aacute;ch với ph&egrave;n chua, một trong những biện ph&aacute;p trị h&ocirc;i n&aacute;ch được &aacute;p dụng phổ biến v&agrave; hiệu quả hi&ecirc;n nay.</p>\n<h2 style="text-align: justify;">C&aacute;ch chữa h&ocirc;i n&aacute;ch bằng ph&egrave;n chua c&ugrave;ng với thảo dược</h2>\n<p style="text-align: justify;"><span style="text-decoration: underline;">Nghiền n&aacute;t những nguy&ecirc;n liệu:</span></p>\n<ul style="text-align: justify;">\n<li>Đinh hương, thanh mộc hương, nhũ hương, ph&ograve;ng hương 60 gram mỗi vị thuốc.</li>\n<li>500 gram v&ocirc;i sống.</li>\n<li>120 gram ph&egrave;n chua, quất b&igrave;, dương khởi thạch 90 gram mỗi vị thuốc.</li>\n</ul>\n<p style="text-align: justify;"><span style="text-decoration: underline;">C&aacute;ch d&ugrave;ng:</span></p>\n<ul style="text-align: justify;">\n<li>Lấy 1 lượng d&ugrave;ng vừa đủ rồi rải l&ecirc;n một mảnh vải, cột cố định ở 2 b&ecirc;n n&aacute;ch.</li>\n</ul>\n<h2 style="text-align: justify;">C&aacute;ch chữa h&ocirc;i n&aacute;ch bằng&nbsp;Chưng ph&egrave;n chua</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/tri-hoi-nach-voi-phen-chua.jpg" alt="" width="500" height="300" /></p>\n<p style="text-align: justify;"><br />Đem bột n&agrave;y r&acirc;y mịn cho v&agrave;o lọ n&uacute;t k&iacute;n, d&ugrave;ng dần. Mỗi khi tắm hoặc rửa n&aacute;ch thật sạch bằng x&agrave; ph&ograve;ng, b&ocirc;i bột ph&egrave;n chua v&agrave;o. Việc b&ocirc;i thuốc thường xuy&ecirc;n sau mỗi lần tắm rửa sẽ gi&uacute;p khử hết m&ugrave;i h&ocirc;i cơ thể bạn nh&eacute;.D&ugrave;ng khoảng 50g ph&egrave;n chua đ&atilde; gi&atilde; nhỏ cho v&agrave;o nồi (nếu c&oacute; nồi đất th&igrave; c&agrave;ng tốt), chưng đến khi ph&egrave;n đ&atilde; hết nước trở n&ecirc;n xốp, nở phồng ra gấp đ&ocirc;i l&uacute;c đầu, khi đ&oacute; sản phẩm thu được l&agrave; bột ph&egrave;n chua.</p>\n<p style="text-align: justify;"><strong>Lưu &yacute;:</strong> Phải chưng ph&egrave;n chua thật kỹ th&igrave; ph&egrave;n mới mịn. Khuyến kh&iacute;ch cho ph&egrave;n chua v&agrave;o bọc vải v&agrave; l&agrave;m ấm l&ecirc;n mỗi khi ch&agrave; x&aacute;t v&agrave;o n&aacute;ch nhằm l&agrave;m co bớt lỗ ch&acirc;n l&ocirc;ng v&agrave; h&uacute;t mồ h&ocirc;i, m&ugrave;i h&ocirc;i ở n&aacute;ch.</p>\n<p style="text-align: justify;"><strong>Hỗn hợp ph&egrave;n chua c&ugrave;ng phấn thơm</strong></p>\n<p style="text-align: justify;">Lấy 15 gram ph&egrave;n chua, 30 gram mỗi vị thuốc thanh mộc hương, phụ tử v&agrave; v&ocirc;i sống. Nghiền tất cả cho ra bột mịn rồi trộn c&ugrave;ng phấn thơm rồi thoa v&agrave;o 2 b&ecirc;n n&aacute;ch.</p>\n<p style="text-align: justify;"><strong>Ph&egrave;n chua v&agrave; rượu</strong></p>\n<p style="text-align: justify;">M&agrave;i ph&egrave;n chua với nước hoặc rượu, sau đ&oacute; th&ecirc;m v&agrave;o đ&oacute; 1 ch&uacute;t tinh dầu thơm m&agrave; bạn th&iacute;ch. Đựng v&agrave;o lọ k&iacute;n, thoa đều v&agrave;o n&aacute;ch mỗi khi ra ngo&agrave;i.&nbsp;Ph&egrave;n chua kết hợp với nước sau đ&oacute; b&ocirc;i l&ecirc;n n&aacute;ch sẽ gi&uacute;p bạn tự tin hơn.</p>\n<p style="text-align: justify;"><strong>S&aacute;t trực tiếp ph&egrave;n chua l&ecirc;n n&aacute;ch</strong></p>\n<p style="text-align: justify;">Sau khi tắm xong, c&aacute;c bạn c&oacute; thể d&ugrave;ng cục ph&egrave;n chua nhỏ x&aacute;t v&agrave;o n&aacute;ch. C&aacute;ch n&agrave;y thường c&aacute;c bạn sẽ thấy đau r&aacute;t v&ugrave;ng n&aacute;ch khi mới d&ugrave;ng. Nếu xoa nhẹ th&igrave; cũng kh&ocirc;ng mang lại nhiều hiệu quả.</p>\n<p style="text-align: justify;"><br />Lấy 20 g l&aacute; ngải phơi kh&ocirc;, gi&atilde; nhỏ, đảo đều với 20 g bột ph&egrave;n chua, v&agrave; 200 g muối tinh, bắc l&ecirc;n bếp đảo n&oacute;ng, sau đ&oacute; đổ hỗn hợp v&agrave;o t&uacute;i vải, rồi kẹp ở dưới n&aacute;ch 5 ph&uacute;t, c&oacute; t&aacute;c dụng loại trừ bệnh h&ocirc;i n&aacute;ch, &aacute;p dụng sau 1 th&aacute;ng l&agrave; c&oacute; kết quả.<strong>L&aacute; ngải kết hợp với ph&egrave;n trị bệnh h&ocirc;i n&aacute;ch</strong></p>\n<p style="text-align: justify;"><strong>Hơ ph&egrave;n chua tr&ecirc;n trứng</strong></p>\n<p style="text-align: justify;">Bỏ ph&egrave;n chua v&agrave;o một tr&aacute;i trứng rồi đem đi hơ lửa đến khi n&agrave;o ph&egrave;n ra nước. Bạn chờ cho ph&egrave;n cứng rồi mới gi&atilde; nhuyễn. Nhớ b&ocirc;i hai lần một ng&agrave;y để l&agrave;m giảm h&ocirc;i n&aacute;ch. H&atilde;y ki&ecirc;n tr&igrave; &aacute;p dụng c&aacute;ch trị h&ocirc;i n&aacute;ch bằng ph&egrave;n chua n&agrave;y mới thấy được hiệu quả tuyệt vời m&agrave; n&oacute; đem lại.</p>\n<h2 style="text-align: justify;">Trị H&ocirc;i N&aacute;ch với b&agrave;i&nbsp;thuốc đ&ocirc;ng y của d&acirc;n tộc T&agrave;y</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/tri-hoi-nach.jpg" alt="" width="400" height="400" /></p>\n<p>C&ograve;n ai đang khổ t&acirc;m với mấy bệnh n&agrave;y hay bệnh ra mồ h&ocirc;i ch&acirc;n tay qu&aacute; nhiều h&atilde;y sử dụng b&agrave;i thuốc đ&ocirc;ng y của d&acirc;n tộc T&agrave;y. Cam kết về chất lượng thuốc.</p>\n<p>TRỊ VĨNH VIẾN H&Ocirc;I N&Aacute;CH, H&Ocirc;I CH&Acirc;N V&Agrave; BỆNH CH&Acirc;N TAY RA NHIỀU MỒ H&Ocirc;I VỚI B&Agrave;I THUỐC QU&Yacute; CỦA NGƯỜI T&Agrave;Y DUY NHẤT 1 LIỆU TR&Igrave;NH 15-30 NG&Agrave;Y.</p>\n<p><strong>LH tư vấn: 094 789 3386 - 0965 613 469</strong></p>\n<p style="text-align: justify;">Xem chi tiết tại:&nbsp;<strong><a href="http://thanhxuanduoc.com/tri-hoi-nach.html">Trị h&ocirc;i n&aacute;ch</a></strong></p>\n<p style="text-align: justify;"><strong>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng !</strong></p>', '2016-02-01 13:04:00', '2016-02-23 18:01:10', 8, 15, 75, '/images/source/thumb/tri-hoi-nach-voi-phen-chua.jpg', NULL, 'cách trị hôi nách bằng phèn chua hiệu quả', '', 'cách trị hôi nách bằng phèn chua hiệu quả, Chia sẽ những biện pháp trị hôi nách nhanh nhất, hiệu quả nhất với phèn chua kết hợp với các thảo dược khác', '', 'vi', 1, 0, 0, 1, 5),
(70, 'Cách trị hôi nách bằng mướp đắng hiệu quả', 'Cách trị hôi nách bằng mướp đắng hiệu quả như thế nào hiệu quả. Hãy cùng thanh xuân dược tìm hiểu chủ đề này nhé.', '<p>H&ocirc;i n&aacute;ch lu&ocirc;n l&agrave;m cho bạn mất tự tin v&agrave; giao tiếp với mọi người. Để loại bỏ được h&ocirc;i n&aacute;ch kh&ocirc;ng phải l&agrave; chuyện một sớm một chiều m&agrave; phải thực hiện trong thời gian d&agrave;i th&igrave; mới c&oacute; kết quả. Trong b&agrave;i viết dưới đ&acirc;y ch&uacute;ng t&ocirc;i sẽ tư vấn cho c&aacute;c bạn một c&aacute;ch&nbsp;<strong><a href="http://thanhxuanduoc.com/tri-hoi-nach">trị h&ocirc;i n&aacute;ch</a></strong> bằng c&aacute;ch sử dụng mướp đắng, một loại quả rất dễ t&igrave;m. C&ugrave;ng t&igrave;m hieu nh&eacute;:</p>\n<h2>Mướp đắng c&oacute; t&aacute;c dụng g&igrave; trong việc điều trị bệnh h&ocirc;i n&aacute;ch</h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/cach-tri-hoi-nach-bang-muop-dang-hieu-qua.png" alt="" width="500" height="368" /></p>\n<p>Mướp đắng l&agrave; một trong những m&oacute;n ăn cực kỳ bổ dưỡng, c&oacute; t&ecirc;n gọi kh&aacute;c l&agrave; quả khổ qua rất tốt cho sức khỏe c&oacute; nhiều c&ocirc;ng dụng như thanh lọc cơ thể, gi&uacute;p giảm lượng đường trong m&aacute;u, tốt cho người mắc c&aacute;c bệnh ung thư, mướp đắng ăn v&agrave;o m&ugrave;a h&egrave; l&agrave; th&iacute;ch hợp nhất. B&ecirc;n cạnh đ&oacute; mướp đắng c&ograve;n gi&uacute;p loại bỏ m&ugrave;i cơ thể, c&aacute;ch l&agrave;m như thế n&agrave;o ch&uacute;ng ta c&ugrave;ng xem c&aacute;c bước dưới đ&acirc;y:</p>\n<h2>C&aacute;ch chữa h&ocirc;i n&aacute;ch bằng mướp đắng:</h2>\n<h3>C&aacute;ch 1: Sử dụng l&aacute; c&acirc;y mướp đắng</h3>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/cach-tri-hoi-nach-bang-muop-dang-hieu-qua1.jpg" alt="c&aacute;ch điều trị h&ocirc;i n&aacute;ch bằng l&aacute; mướp đắng" width="500" height="350" /></p>\n<ul>\n<li>Bạn ngắn khoảng 10-15 l&aacute; mướp đắng, nếu c&oacute; m&aacute;y xay sinh tố th&igrave; bạn xay nhuyễn ra, hoặc kh&ocirc;ng th&igrave; bạn gi&atilde; nhuyễn, lấy c&aacute;i phần nước cốt b&ocirc;i v&agrave;o n&aacute;ch. 1 tuần bạn n&ecirc;n thực hiện từ 4-5 lần th&igrave; m&ugrave;i h&ocirc;i sẽ thuy&ecirc;n giảm đi rất nhiều. Đối với c&aacute;i b&atilde; của l&aacute; mướp đắng m&agrave; bạn vừa xay, c&oacute; thể b&ocirc;i v&agrave;o n&aacute;ch trước khi ngủ, sẽ thấy ngay sự chuyển biến r&otilde; rệt.</li>\n</ul>\n<h3>C&aacute;ch 2: Sử dụng quả mướp đắng</h3>\n<ul>\n<li>Những quả mướp đắng gi&agrave; sau khi được phơi kh&ocirc; dưới nhiệt độ ngo&agrave;i trời khoảng 30-35 độ C khoảng 2 ng&agrave;y, th&igrave; bạn sử dụng để pha tr&agrave; uống như b&igrave;nh thường, bạn n&ecirc;n th&aacute;i mỏng độ d&agrave;y khoảng 2-3 cm. Đ&acirc;y l&agrave; một trong những c&aacute;ch trị h&ocirc;i n&aacute;ch từ b&ecirc;n trong, bạn n&ecirc;n pha tr&agrave; mướp đắng hằng ng&agrave;y th&igrave; sau một thời gian sẽ kh&ocirc;ng c&ograve;n m&ugrave;i h&ocirc;i của n&aacute;ch nữa.</li>\n</ul>\n<p>C&ugrave;ng với c&aacute;c c&aacute;ch tr&ecirc;n để đạt được hiệu quả tốt nhất th&igrave; bạn n&ecirc;n:</p>\n<h3>Lưu &yacute; trong khi điều trị bệnh h&ocirc;i n&aacute;ch</h3>\n<ul>\n<li>N&ecirc;n tắm rửa mỗi ng&agrave;y với loại sữa tắm cho loại da nhờn, bạn c&oacute; thể sử dụng x&agrave; b&ocirc;ng hoặc loại sữa rửa mặt d&agrave;nh cho da nhờn để rửa v&ugrave;ng n&aacute;ch.</li>\n<li>Bạn cũng c&oacute; thể sử dụng chanh, trước khi tắm khoảng 5 ph&uacute;t bạn b&ocirc;i v&agrave;o n&aacute;ch, sau đ&oacute; th&igrave; đi tắm b&igrave;nh thường.</li>\n<li>Khi đi l&agrave;m hay đi đ&acirc;u th&igrave; n&ecirc;n ăn mặc một c&aacute;ch rộng r&atilde;i nhất, tho&aacute;ng kh&iacute; nhất l&agrave; v&ugrave;ng n&aacute;ch, kh&ocirc;ng n&ecirc;n mặc đồ qu&aacute; chật, v&igrave; như thế c&aacute;c chất trong tuyến mồ h&ocirc;i sẽ ph&aacute;t triển khiến m&ugrave;i c&agrave;ng nặng hơn.</li>\n<li>L&agrave; một người bị h&ocirc;i n&aacute;ch l&acirc;u năm bạn n&ecirc;n loại bỏ những loại củ c&oacute; m&ugrave;i hăng như h&agrave;nh, tỏi v&agrave; n&ecirc;n ăn nhiều loại rau củ, tr&aacute;i c&acirc;y v&agrave; uống nhiều nước.</li>\n</ul>\n<p>C&aacute;ch chữa h&ocirc;i n&aacute;ch bằng mướp đắng chỉ c&oacute; hiệu quả tạm thời chứ kh&ocirc;ng loại bỏ được m&ugrave;i h&ocirc;i n&aacute;ch vĩnh viễn. Để loại bỏ h&ocirc;i n&aacute;ch triệt để với thuốc trị h&ocirc;i n&aacute;ch gia truyền</p>\n<p>Ch&uacute;ng t&ocirc; đ&atilde; giới thiệu cho c&aacute;c bạn c&aacute;ch chữa h&ocirc;i n&aacute;ch bằng mướp đắng, với c&aacute;ch n&agrave;y th&igrave; chỉ c&oacute; hiệu quả tạm thời chữ kh&ocirc;ng loại bỏ được m&ugrave;i h&ocirc;i vĩnh viễn. Với kinh nghiệm nghi&ecirc;n cứu trong nhiều năm Thanhxuanduoc.com đ&atilde; đưa ra một b&agrave;i thuốc b&iacute; truyền với sự kết hợp của c&aacute;c loại thảo dược qu&yacute; hiếm gi&uacute;p loại bỏ ho&agrave;n to&agrave;n m&ugrave;i h&ocirc;i tr&ecirc;n cơ thể. Bạn c&oacute; thể tham khảo sản phẩm đặc trị h&ocirc;i n&aacute;ch <strong><a href="http://thanhxuanduoc.com/tri-hoi-nach.html">tại đ&acirc;y</a></strong>.</p>', '2016-02-02 20:35:00', '2016-02-23 17:44:47', 8, 16, 56, '/images/source/thumb/cach-tri-hoi-nach-bang-muop-dang-hieu-qua1.jpg', NULL, 'Cách trị hôi nách bằng mướp đắng hiệu quả', '', 'Cách trị hôi nách bằng mướp đắng hiệu quả với những bước làm đơn giản bạn đã có một công thức trị hôi nách hiệu quả không tốn thời gian', '', 'vi', 1, 0, 0, 1, 5);
INSERT INTO `txd_news` (`id`, `title`, `summary`, `content`, `created_date`, `updated_date`, `cat_id`, `position`, `viewed`, `thumbnail`, `city_id`, `meta_title`, `meta_keywords`, `meta_description`, `tags`, `lang`, `status`, `home`, `startups`, `creator`, `editor`) VALUES
(71, 'Cách trị hôi nách bằng trứng gà hiệu quả tại nhà', 'Cách trị hôi nách bằng trứng gà hiệu quả tại nhà với cách làm đơn giản nhưng lại mang lại hiệu quả cao và rất dễ làm', '<p>Trong d&acirc;n gian c&oacute; rất nhiều c&aacute;ch <a title="Trị h&ocirc;i n&aacute;ch" href="http://thanhxuanduoc.com/tri-hoi-nach">trị h&ocirc;i n&aacute;ch</a>, trong b&agrave;i viết n&agrave;y ch&uacute;ng t&ocirc;i sẽ m&aacute;ch cho c&aacute;c bạn một c&aacute;ch c&oacute; thể thực hiện tại nh&agrave; mang lại hiệu quả v&agrave; cực kỳ dễ l&agrave;m.</p>\n<h2>Trứng g&agrave; c&oacute; thể chữa được h&ocirc;i n&aacute;ch v&igrave; sao?</h2>\n<p>Thanhxuanduoc.com sẽ c&ugrave;ng với c&aacute;c bạn t&igrave;m hiểu xem trong trứng g&agrave; c&oacute; c&aacute;c chất dinh dưỡng g&igrave; v&agrave; c&oacute; t&aacute;c động như thế n&agrave;o tới n&aacute;ch của ch&uacute;ng ta.</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/cach-tri-hoi-nach-bang-trung-ga.jpg" alt="c&aacute;ch trị h&ocirc;i n&aacute;ch bằng trứng g&agrave;" width="592" height="298" /></p>\n<p style="text-align: center;">C&aacute;ch trị h&ocirc;i n&aacute;ch bằng trứng g&agrave; hiệu quả</p>\n<p style="text-align: justify;">Trứng g&agrave; l&agrave; một trong những thực phẩm bổ dưỡng v&agrave; được hơn 95% gia đ&igrave;nh tr&ecirc;n thế giới sử dụng trong gia đ&igrave;nh. Người Israel đứng đầu về lượng trứng g&agrave; được sử dụng với 440 trứng/người.</p>\n<p style="text-align: justify;">L&agrave; một thực phẩm được đa số người d&acirc;n tr&ecirc;n tr&ecirc;n giới tin tưởng sử dụng, trứng g&agrave; c&ograve;n được xem như l&agrave; một sản phẩm gi&uacute;p chị em l&agrave;m đẹp hiệu quả.</p>\n<p style="text-align: justify;">Trứng g&agrave; cung cấp rất nhiều c&aacute;c chất dinh dưỡng như c&aacute;c loại vitamin A, B6, D...v&agrave; c&aacute;c kho&aacute;ng chất như: sắt, kẽm, canxi... Trứng g&agrave; c&ograve;n mang lại những lợi &iacute;ch tuyệt vời kh&aacute;c ngo&agrave;i việc cung cấp c&aacute;c dưỡng chất cho sức khỏe như l&agrave;m giảm th&acirc;m tr&ecirc;n v&ugrave;ng n&aacute;ch, th&acirc;m t&iacute;m da, tẩy tế b&agrave;o chết, đặc biệt l&agrave; trị h&ocirc;i n&aacute;ch hiệu quả.</p>\n<p style="text-align: justify;">Chữa h&ocirc;i n&aacute;ch bằng trứng g&agrave; c&oacute; từ rất l&acirc;u đời v&agrave; l&agrave; một trong những c&aacute;ch d&acirc;n gian hiệu quả kh&ocirc;ng tốn k&eacute;m.</p>\n<h2>C&aacute;c bước trị h&ocirc;i n&aacute;ch bằng trứng g&agrave; si&ecirc;u tiết kiệm</h2>\n<p style="text-align: justify;">Chuẩn bị:</p>\n<p style="text-align: justify;">Bạn c&oacute; thể mua ngo&agrave;i chợ 2 quả trứng g&agrave; ta kh&ocirc;ng qu&aacute; nhỏ.</p>\n<p style="text-align: justify;">C&aacute;c bước thực hiện như sau:</p>\n<ol style="text-align: justify;">\n<li>Trứng rửa sạch sau đ&oacute; cho v&agrave;o nồi, đổ nước ngập trứng v&agrave; sau đ&oacute; để khoảng từ 5-7 ph&uacute;t l&agrave; trứng ch&iacute;n v&agrave; sẽ kh&ocirc;ng bị mất đi c&aacute;c chất cần thiết.</li>\n<li>Lấy trứng ra v&agrave; b&oacute;c khi trứng đang c&ograve;n n&oacute;ng, v&agrave; sau đ&oacute; lăn mỗi b&ecirc;nh n&aacute;ch một quả.</li>\n<li>Bạn lăn đi lăn lại khoảng 2 &ndash; 3 ph&uacute;t khi n&agrave;o trứng nguội th&igrave; th&ocirc;i, sau khi thực hiện xong bạn cắt 2 l&aacute;t gừng mỏng ch&agrave; x&aacute;t v&agrave;o n&aacute;ch, sau khoảng 10 ph&uacute;t th&igrave; bạn đi rửa lại nước. Với c&aacute;ch n&agrave;y th&igrave; bạn n&ecirc;n thực hiện 1 tuần từ 3-4 lần để thấy được hiệu quả tốt nhất.</li>\n</ol>\n<h2 style="text-align: justify;">Phương ph&aacute;p trị h&ocirc;i n&aacute;ch bằng trứng g&agrave; kh&ocirc;ng được nhiều người biết tới v&igrave; sao?</h2>\n<p style="text-align: justify;">Với c&aacute;c phương ph&aacute;p d&acirc;n gian n&agrave;y th&igrave; bạn phải thực hiện trong thời gian d&agrave;i, ki&ecirc;n tr&igrave; sẽ thấy được hiệu quả đồng thời phải kết hợp với c&aacute;ch sinh hoạt ăn uống hằng ng&agrave;y.</p>\n<p style="text-align: justify;">Bạn c&oacute; thể sử dụng c&aacute;c thảo dược từ thi&ecirc;n nhi&ecirc;n kết hợp với c&aacute;ch ăn mặc,sinh hoạt hằng ng&agrave;y gi&uacute;p cho v&ugrave;ng n&aacute;ch kh&ocirc;ng bị b&iacute;. Bạn c&oacute; thể tham khảo b&agrave;i thuốc của thanhxuanduoc.com với c&aacute;c th&agrave;nh phần ho&agrave;n to&agrave;n từ thảo mộc tinh chế kh&ocirc;ng c&oacute; t&aacute;c dụng phụ m&agrave; bất kỳ ai bị h&ocirc;i n&aacute;ch cũng c&oacute; thể sử dụng được, khi sử dụng thuốc đặc trị n&agrave;y sẽ gi&uacute;p bạn tự tin hơn trong c&ocirc;ng việc v&agrave; khi giao tiếp với mọi người.</p>\n<p>&nbsp;</p>\n<p><em>Ch&uacute;c bạn th&agrave;nh c&ocirc;ng !</em></p>\n<p><em>&nbsp;</em></p>\n<p><em>Từ kh&oacute;a gơi &yacute; google</em></p>\n<p>chữa h&ocirc;i n&aacute;ch bằng trứng g&agrave;<br />trị h&ocirc;i n&aacute;ch bằng trứng g&agrave;</p>', '2016-02-02 20:55:00', '2016-02-23 17:37:41', 8, 17, 290, '/images/source/thumb/Tri-hoi-nach-voi-trung-ga.jpg', NULL, 'Cách trị hôi nách bằng trứng gà hiệu quả tại nhà', '', 'Cách trị hôi nách bằng trứng gà hiệu quả tại nhà với cách làm đơn giản nhưng lại mang lại hiệu quả cao và rất dễ làm', '', 'vi', 1, 0, 0, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `txd_news_categories`
--

CREATE TABLE `txd_news_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(256) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` tinyint(4) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `lang` varchar(20) DEFAULT 'vi',
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `grid` tinyint(1) NOT NULL DEFAULT '0',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `txd_news_categories`
--

INSERT INTO `txd_news_categories` (`id`, `category`, `parent_id`, `level`, `position`, `thumbnail`, `summary`, `content`, `meta_title`, `meta_keywords`, `meta_description`, `lang`, `status`, `home`, `grid`, `creator`, `editor`, `private`) VALUES
(1, 'Tin tức', 0, 0, 1, '', '', '', '', '', '', 'vi', 1, 1, 0, 2, 1, 0),
(2, 'Đông y cổ truyền', 0, 0, 2, '', '', '', '', '', '', 'vi', 1, 0, 0, 1, 1, 0),
(3, 'Tư vấn làm đẹp', 0, 0, 3, '', '', '', '', '', '', 'vi', 1, 0, 0, 1, 1, 0),
(5, 'Tư vấn sức khỏe', 0, 0, 4, '', '', '', '', '', '', 'vi', 1, 1, 0, 1, 1, 0),
(7, 'Câu hỏi thường gặp', 0, 0, 5, '', '', '', '', '', '', 'vi', 1, 1, 0, 1, 1, 0),
(8, 'Trị hôi nách', 0, 0, 6, '', '', '', 'cách chữa Trị hôi nách hiệu quả nhất', 'cach tri hoi nach, cách trị đổ mồ hôi nách, cách trị hôi nách hiệu quả, cách trị hôi nách hiệu quả nhất, cách chữa hôi nách hiệu quả nhất, cách chữa trị hôi nách', 'cách chữa Trị hôi nách hiệu quả nhất với những phong pháp trị hôi nách đơn giản mang lại hiệu quả cao. Thanh xuân dược câp cấp phương pháp trị hôi nách hiệu quả nhất', 'vi', 1, 1, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `txd_orders`
--

CREATE TABLE `txd_orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `reserve_time` varchar(255) DEFAULT NULL COMMENT 'Ngay giao hang',
  `kind_pay` int(11) DEFAULT NULL COMMENT 'Hinh thuc thanh toan 1 la truc tiep 2 la chuyen khoan',
  `source_order` int(11) NOT NULL COMMENT '1 SEO ,2 là Facebook ADS,3 là google ad',
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `sale_date` datetime DEFAULT NULL,
  `payment` tinyint(4) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `total_all` double DEFAULT NULL,
  `total_discount` double NOT NULL COMMENT 'total sau khi nhap ma giam gia',
  `coupon_code` varchar(255) NOT NULL,
  `order_status` tinyint(4) DEFAULT '0',
  `receiver` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `tel` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `nhacnho` varchar(255) DEFAULT NULL,
  `other` text,
  `city_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `current_ip` varchar(255) NOT NULL,
  `lang` varchar(20) NOT NULL DEFAULT 'vi',
  `str_created_order` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_orders`
--

INSERT INTO `txd_orders` (`id`, `reserve_time`, `kind_pay`, `source_order`, `user_id`, `fullname`, `company`, `sale_date`, `payment`, `total`, `total_all`, `total_discount`, `coupon_code`, `order_status`, `receiver`, `address`, `phone`, `tel`, `fax`, `email`, `facebook`, `message`, `nhacnho`, `other`, `city_id`, `district_id`, `create_time`, `update_time`, `current_ip`, `lang`, `str_created_order`) VALUES
(2, NULL, 3, 0, 0, 'Nguyễn Phúc Ánh', '', '2016-02-23 09:03:37', NULL, 0, 50000, 0, '', 3, NULL, 'Ô 29 Lô 6 Đền Lừ 2, Hoàng Văn Thụ, Hoàng Mai, Hà Nội', NULL, '0965613469', '', 'phucanh3386@gmail.com', 'http://facebook.com', 'âdadas', NULL, NULL, NULL, NULL, 1456193017, 1456193017, '117.5.41.65', 'vi', '1456160400000'),
(3, NULL, 1, 0, 0, 'Nguyễn Phúc Ánh', '', '2016-02-26 11:25:48', NULL, 0, 100000, 0, '', 0, NULL, 'hà nội, việt nam', NULL, '0947893386', '', 'phhucan@gmail.com', 'http://facebook.com/deviliuvk', 'Tôi muốn mua thuốc hôi nách', NULL, NULL, NULL, NULL, 1456460748, 1456460748, '117.5.36.26', 'vi', '1456419600000'),
(17, NULL, 2, 2, 1, 'Trần Tuấn Anh', '', '2016-03-20 16:30:27', NULL, 750000, 500001, 0, '', 3, NULL, 'hà nội', NULL, '0988 258 392', '', 'son.kul9x@gmail.com', 'http://facebook.com/deviliuvk', 'a', NULL, NULL, NULL, NULL, 1458466179, 1458466179, '127.0.0.1', 'vi', '1458406800000'),
(18, NULL, 2, 0, 0, 'Trần Văn Sơn', '', '2016-03-27 09:50:09', NULL, 610000, 0, 0, '', 3, NULL, 'Hà Nội', NULL, 'dsa', '', 'son.kul9x@gmail.com', '', 'dsds', NULL, NULL, NULL, NULL, 1459047009, 1459047009, '127.0.0.1', 'vi', '1459011600000'),
(19, NULL, 2, 2, 1, 'Trần Tuấn ANH', '', '2016-03-27 10:01:17', NULL, 0, 11520000, 0, '', 2, NULL, 'Hà Nội', NULL, '0988258392', '', 'tson171192@gmail.com', 'http://facebook.com/deviliuvk', 'ABCb', NULL, NULL, NULL, NULL, 1459047639, 1459047639, '127.0.0.1', 'vi', '1459011600000'),
(20, NULL, 1, 1, 1, 'Trần Văn Sơn', '', '2016-03-27 11:05:03', NULL, 5800000, 5830000, 0, '', 3, NULL, '', NULL, '0988258392', '', '', '', 'acsadadas', NULL, NULL, NULL, NULL, 1459051474, 1459051474, '127.0.0.1', 'vi', '1459011600000'),
(21, NULL, 2, 2, 1, 'Trần Việt Tuấn', '', '2016-04-03 13:16:02', NULL, 9920000, 9950000, 0, '', 2, NULL, 'Hà Nội', NULL, '0243154335', '', 'tuananh@gmail.com', 'facebook.com', 'abc', NULL, NULL, NULL, NULL, 1459664030, 1459664030, '127.0.0.1', 'vi', '1459616400000'),
(22, NULL, 1, 0, 0, 'Trần Văn Sơn', '', '2017-05-11 00:01:48', NULL, 990000, NULL, 0, '', 0, NULL, 'ab', NULL, '321', '', 'tson171192@gmail.com', '', 'a', NULL, NULL, NULL, NULL, 1494435708, 1494435708, '127.0.0.1', 'vi', '1494435600000');

-- --------------------------------------------------------

--
-- Table structure for table `txd_orders_details`
--

CREATE TABLE `txd_orders_details` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_orders_details`
--

INSERT INTO `txd_orders_details` (`order_id`, `product_id`, `quantity`, `price`, `size`) VALUES
(1, 18, 1, 390000, '0'),
(2, 25, 1, 275000, '0'),
(3, 27, 1, 220000, '0'),
(4, 26, 1, 250000, '0'),
(5, 26, 5, 250000, '0'),
(NULL, 22, 6, 0, '0'),
(9, 24, 7, 1240000, '0'),
(10, 27, 6, 220000, '0'),
(11, 25, 8, 275000, '0'),
(12, 24, 9, 1240000, '0'),
(13, 27, 9, 220000, '0'),
(14, 18, 4, 390000, '0'),
(NULL, 24, 6, 1240000, '0'),
(NULL, 24, 9, 1240000, '0'),
(15, 22, 3, 0, '0'),
(16, 25, 9, 275000, '0'),
(17, 26, 3, 250000, '0'),
(18, 26, 1, 250000, '0'),
(18, 20, 1, 360000, '0'),
(19, 26, 16, 250000, '0'),
(19, 19, 4, 990000, '0'),
(19, 27, 16, 220000, '0'),
(20, 27, 15, 220000, '0'),
(20, 26, 10, 250000, '0'),
(21, 24, 4, 1240000, '0'),
(21, 24, 4, 1240000, '0'),
(22, 19, 1, 990000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `txd_pages`
--

CREATE TABLE `txd_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `uri` varchar(255) NOT NULL,
  `content` text,
  `created_date` datetime DEFAULT NULL,
  `viewed` int(11) DEFAULT '0',
  `summary` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` tinyint(4) DEFAULT '1',
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_pages`
--

INSERT INTO `txd_pages` (`id`, `title`, `uri`, `content`, `created_date`, `viewed`, `summary`, `meta_title`, `meta_keywords`, `meta_description`, `tags`, `status`, `lang`, `creator`, `editor`) VALUES
(14, 'Hướng dẫn mua hàng', '/huong-dan-mua-hang.html', '<p>Hướng dẫn mua h&agrave;ng</p>', '2015-12-15 21:44:45', 361, 'Hướng dẫn mua hàng', '', '', '', '', 1, 'vi', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products`
--

CREATE TABLE `txd_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `price_old` double NOT NULL DEFAULT '0',
  `summary` text,
  `description` text,
  `code` varchar(255) DEFAULT NULL,
  `manufacturer` text NOT NULL,
  `specifications` text NOT NULL,
  `guarantee` varchar(255) NOT NULL,
  `quantum` varchar(255) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `trademark_id` int(11) NOT NULL,
  `state_id` tinyint(1) NOT NULL,
  `colors` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `material_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `viewed` int(11) DEFAULT '0',
  `position` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `home` tinyint(1) NOT NULL DEFAULT '0',
  `top_seller` tinyint(4) DEFAULT NULL,
  `typical` tinyint(1) NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `tags` text,
  `unit_id` tinyint(4) DEFAULT NULL,
  `unit_id_old` tinyint(4) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0',
  `link_demo` varchar(500) NOT NULL DEFAULT '#'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `txd_products`
--

INSERT INTO `txd_products` (`id`, `product_name`, `created_date`, `updated_date`, `price`, `price_old`, `summary`, `description`, `code`, `manufacturer`, `specifications`, `guarantee`, `quantum`, `origin_id`, `trademark_id`, `state_id`, `colors`, `size`, `material_id`, `style_id`, `users_id`, `categories_id`, `viewed`, `position`, `status`, `home`, `top_seller`, `typical`, `new`, `tags`, `unit_id`, `unit_id_old`, `lang`, `meta_title`, `meta_keywords`, `meta_description`, `creator`, `editor`, `link_demo`) VALUES
(20, 'Bổ Não Focus DHA', '2015-12-22 11:15:18', '2016-01-16 10:07:21', 360000, 420000, 'Giúp hoạt huyết, dưỡng não, tăng cường dưỡng chất cho não, Giúp làm giảm các triệu chứng ù tai', '<p>Gi&uacute;p hoạt huyết, dưỡng n&atilde;o, tăng cường dưỡng chất cho n&atilde;o, Gi&uacute;p l&agrave;m giảm c&aacute;c triệu chứng &ugrave; tai</p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 4, 388, 7, 1, 0, 1, 0, 0, '', 0, 0, 'vi', '', '', '', 1, 1, '0'),
(22, 'Bổ não DHA Plus', '2015-12-22 14:01:53', '2016-01-16 10:05:37', 0, 0, 'Giúp hoạt huyết, dưỡng não, tăng cường dưỡng chất cho não, Giúp làm giảm các triệu chứng ù tai..', '<p>Bổ n&atilde;o DHA Plus</p>\n<p>Quy c&aacute;ch: Lọ 60 vi&ecirc;n</p>\n<p>C&aacute;ch d&ugrave;ng: Uống 1-2 vi&ecirc;n mối ng&agrave;y.</p>\n<p>Th&agrave;nh phần trong 2 vi&ecirc;n DHA Plus:</p>\n<p>Nattokinase extract powder......................................... 320 mg</p>\n<p>Red yeast rice extract powder..................................... 100 mg</p>\n<p>Ginkoba...................................................................... 120 mg</p>\n<p>Blueberry Extract.................................................... 2000 mcg</p>\n<p>Coenzyme&nbsp; Q10...................................................... 3000 mcg</p>\n<p>Vitamine B6............................................................ 1200 mcg</p>\n<p>Collagen.................................................................. 2000 mcg</p>\n<p>Maca Giseng............................................................... 60 mcg</p>\n<p>Silymarin..................................................................... 60 mcg</p>\n<p>Rhodiola Extract........................................................... 40 mg</p>\n<p>Turmeric Extract......................................................... 60 mcg</p>\n<p>C&ocirc;ng dụng:</p>\n<ul>\n<li>Gi&uacute;p hoạt huyết, dưỡng n&atilde;o, tăng cường dưỡng chất cho n&atilde;o.</li>\n<li>Gi&uacute;p l&agrave;m giảm c&aacute;c triệu chứng &ugrave; tai, đau đầu, suy giảm tr&iacute; nhớ, rối loạn thần kinh thị gi&aacute;c, chống gốc tự do.</li>\n<li>Bảo về v&agrave; tăng cường hoạt động n&atilde;o, tim mạch.</li>\n<li>Gi&uacute;p hỗ trợ điều trị trước v&agrave; sau tai biến mạch m&aacute;u n&atilde;o. Gi&uacute;p hoạt huyết, dưỡng n&atilde;o, tăng cường dưỡng chất cho n&atilde;o</li>\n</ul>\n<p>Xuất xứ: USA</p>\n<p>Nh&agrave; sản xuất: Power Nutritional CO.</p>\n<p>Địa chỉ: 5102 Azusa Canyon RD. Irwindale CA 91706</p>\n<p>C&ocirc;ng ty nhập khẩu: C&ocirc;ng ty TNHH DP Green</p>\n<p>Địa chỉ: Số 10/32/293 Tam Trinh, HVT, HM, H&agrave; Nội</p>\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 4, 392, 9, 1, 0, 1, 0, 0, '', 0, 0, 'vi', '', '', '', 1, 1, '0'),
(24, 'Ancan - Thực Phẩm Chức Năng', '2015-12-22 16:18:53', '2016-01-16 10:03:49', 1240000, 1400000, 'Giúp cơ thể tăng cường sức đề kháng, giảm oxi hóa, chống lão hóa tăng cường chức năng gan', '<p><strong>Bản quyền sản xuất</strong> : C&ocirc;ng ty CP Triệu Sơn</p>\n<p><strong>Gia c&ocirc;ng sản xuất : </strong>C&ocirc;ng ty CP Đầu tư v&agrave; Sản xuất &Acirc;u Cơ</p>\n<p><strong>T&iacute;nh năng ch&iacute;nh :</strong></p>\n<p> Gi&uacute;p cơ thể tăng cường sức đề kh&aacute;ng</p>\n<p> Gi&uacute;p giảm oxi h&oacute;a, chống l&atilde;o h&oacute;a tăng cường chức năng gan</p>\n<p> Hỗ trợ giảm thiểu c&aacute;c nguy cơ g&acirc;y ra khối u v&agrave; ung thư do t&aacute;c nh&acirc;n oxi h&oacute;a</p>\n<p> Ph&ograve;ng v&agrave; hỗ trợ điều trị tiểu đường</p>\n<p> Bảo vệ dạ d&agrave;y</p>\n<p> Gi&uacute;p an thần, ngủ ngon.&nbsp;<em>Lưu &yacute;: Sản phẩm n&agrave;y kh&ocirc;ng phải l&agrave; thuốc v&agrave; kh&ocirc;ng c&oacute; t&aacute;c dụng thay thế thuốc chữa bệnh</em>&nbsp;<strong>Gi&aacute; sản phẩm:&nbsp;</strong>1.240.000 đồng/ Hộp</p>\n<p>C&aacute;c hoạt chất c&oacute; trong Ancan</p>\n<p><br />1-Cao tr&agrave; xanh : Hợp chất catechin c&oacute; t&aacute;c dụng giảm nguy cơ g&acirc;y ung thư, giảm k&iacute;ch thước khối u, giảm lượng đường trong m&aacute;u, giảm cholesteron , ức chế vius , vi khuẩn v&agrave; chống chất ph&oacute;ng xạ th&acirc;m nhập trong cơ thể.</p>\n<p><br />2-Cao xạ đen : Flavonoid &amp; saponin trong Xạ đen c&oacute; t&aacute;c dụng chống chất oxi h&oacute;a ,t&aacute;c dụng ph&ograve;ng chống ung thư,m&aacute;t gan giải độc tăng cường sức đề kh&aacute;ng.</p>\n<p><br />3- Selenium : l&agrave; nguy&ecirc;n tố vi lượng c&oacute; t&aacute;c dụng giải độc tế b&agrave;o, tăng cường sức đề kh&aacute;ng cho cơ thể.</p>\n<p><br />4 - Curcumin: &nbsp;C&oacute; t&aacute;c dụng hủy diệt v&agrave; ức chế tế b&agrave;o ung thư khu tr&uacute; ở nội tạng ( gan ,ruột, dạ d&agrave;y, v&ograve;m họng, tử cung ,b&agrave;ng quang..)<br />K&igrave;m h&atilde;m c&aacute;c virut HIV-1, HIV-1RT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />Bồi bổ cho nội tạng,tăng sinh tế b&agrave;o non gi&uacute;p vết thương mau l&agrave;nh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />L&agrave; một chất chống c&aacute;c gốc tự do rất mạnh,gi&uacute;p cơ thể thanh lọc c&aacute;c chất độc hại nội sinh</p>\n<p><br />5 - Bioperin: L&agrave; hợp chất tự nhi&ecirc;n c&oacute; t&aacute;c dụng bảo vệ curcumin khỏi bị ph&aacute; hủy của dịch ti&ecirc;u h&oacute;a,tăng hiệu suất hấp thu l&ecirc;n 8-20 lần,đồng nghĩa tăng hiệu suất hỗ trợ tương ứng</p>\n<p><br />6 - Pychnogenol: L&agrave; sản phẩm tr&iacute;ch xuất từ c&acirc;y th&ocirc;ng đỏ c&oacute; t&aacute;c dụng chống gốc tự do c&oacute; hại được sinh ra trong qu&aacute; tr&igrave;nh chuyển h&oacute;a vật chất của cơ thể, gi&uacute;p tế b&agrave;o ph&aacute;t triển khỏe mạnh trong m&ocirc;i trường trong sạch nhất.T&aacute;c dụng n&agrave;y mạnh hơn vita min E đến 50 lần</p>\n<p><br />7 - Cao rau m&aacute;: C&oacute; t&aacute;c dụng thanh nhiệt, giải độc hỗ trợ t&aacute;c dụng cho c&aacute;c hoạt chất c&acirc;n bằng cơ thể.</p>\n<p>&nbsp;</p>\n<p>8 - Cao Linh chi: Linh chi l&agrave; nấm h&oacute;a gỗ, c&oacute; nhiều t&aacute;c dụng nổi trội như chống tiểu đường, chữa đau thắt ngực, bệnh mạch v&agrave;nh, huyết &aacute;p dao động, vi&ecirc;m phế quản, hen, vi&ecirc;m gan mạn, thấp khớp, c&aacute;c bệnh đường ti&ecirc;u h&oacute;a, rối loạn tiền m&atilde;n kinh, loạn dưỡng cơ, tăng tr&iacute; nhớ. Germani tr&ograve;ng nấm Linh chi gi&uacute;p kh&iacute; huyết lưu th&ocirc;ng, tế b&agrave;o hấp thu oxy tốt hơn, polysaccharid của Linh chi gi&uacute;p tăng khả năng miễn dịch, cải thiện chức năng gan, chống dị ứng, chống vi&ecirc;m.</p>\n<p>&nbsp;</p>\n<p>9 - Vitamin B1:&nbsp;Ph&ograve;ng ngừa v&agrave; điều trị bệnh t&ecirc; ph&ugrave;, đau d&acirc;y thần kinh, nhiễm độc thần kinh do nghiện rượu, chống mệt mỏi k&eacute;m ăn, rối loạn ti&ecirc;u h&oacute;a, người mang thai, thời kỳ cho con b&uacute;.</p>\n<p>&nbsp;</p>\n<p>10 - Vitamin B5: L&agrave; axit pantothenic v&agrave;o cơ thể tồn tại ở dạng coenzym A v&agrave; l&agrave; một chất kh&ocirc;ng thể thiếu th&uacute;c đẩy chuyển h&oacute;a năng lượng của tế b&agrave;o,tham gia v&agrave;o việc tổng hợp c&aacute;c hormon steroid, colagen v&agrave; củng cố hệ thần kinh trung ương;</p>\n<p>11 - Vitamin B6: Tham gia v&agrave;o c&aacute;c enzym x&uacute;c t&aacute;c cho hơn 100 phản ứng chuyển h&oacute;a protid, lipid v&agrave; hydrat carbon, cũng tham gia tổng hợp nhiều chất trung gian thần kinh, v&agrave;o chuyển h&oacute;a của một số vitamin kh&aacute;c v&agrave; v&agrave;o tạo th&agrave;nh hemoglobin.</p>\n<p><em>Lưu &yacute;: Sản phẩm n&agrave;y kh&ocirc;ng phải l&agrave; thuốc v&agrave; kh&ocirc;ng c&oacute; t&aacute;c dụng thay thế thuốc chữa bệnh</em></p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 4, 401, 11, 1, 0, 1, 0, 1, '', 0, 0, 'vi', '', '', '', 1, 1, '0'),
(18, 'Nhau thai cừu Australia placentra super vip 30.000 mg', '2015-12-22 01:01:47', '2016-01-18 14:09:23', 390000, 420000, 'Australia placentra super vip 30.000 mg giúp Làm đẹp da, chống lão hóa, Làm da trắng', '<p><strong>NTC AUSTRALIA PLACENTRA SUPER VIP 30.000 MG</strong></p>\n<p>Lọ 60 vi&ecirc;n, 120 vi&ecirc;n</p>\n<p><strong>C&aacute;ch d&ugrave;ng</strong>: 1 vi&ecirc;n/ng&agrave;y sau ăn</p>\n<p><strong>Th&agrave;nh phần:</strong></p>\n<p>Nhau thai cừu........................................................... 1000 mg</p>\n<p>Colagen tu&yacute;p I&amp;III.................................................... 1000 mg</p>\n<p>Isoflavon.................................................................... 200 mg</p>\n<p>Glutathion................................................................... 150 mg</p>\n<p>Vitamine A................................................................... 10 mg</p>\n<p>Vitamine E.................................................................. 100 mg</p>\n<p>Vitamine C.................................................................... 50 mg</p>\n<p><strong>C&ocirc;ng dụng:</strong></p>\n<p>- L&agrave;m đẹp da, chống l&atilde;o h&oacute;a.</p>\n<p>- L&agrave;m da trắng s&aacute;ng, mịn m&agrave;ng.</p>\n<p>- Hỗ trợ điều trị th&acirc;m n&aacute;m, l&agrave;m mờ t&agrave;n nhang, c&aacute;c vết đồi mồi.</p>\n<p>- Cải thiện sắc tố da, tăng t&iacute;nh đ&agrave;n hồi v&agrave; chống chảy xệ</p>\n<p>- Cải thiện sinh l&yacute; nữ, bổ sung cung cấp v&agrave; c&acirc;n bằng h&agrave;m lượng estrogen giảm s&uacute;t cơ thể.</p>\n<p>- Hỗ trợ điều h&ograve;a kinh nguyệt v&agrave; giảm đau trong k&igrave; kinh.</p>\n<p>- K&eacute;o d&agrave;i tuổi thọ, tăng cường hệ miễn dịch đồng thời chống stress giảm mất ngủ.</p>\n<p><strong>Xuất xứ</strong>: Autralia</p>\n<p>Số đăng k&yacute;: 13112/2015/ATTP-XNCB</p>\n<p>NSX: Cosdermis Autralia</p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 5, 353, 5, 1, 0, 1, 0, 1, '', 0, 0, 'vi', '', '', '', 1, 1, '0'),
(19, 'Nhau thai cừu JoLie placenta of baby sheep 50.000 mg', '2015-12-22 01:24:44', '2016-02-23 09:23:20', 990000, 1100000, 'JoLie placenta of baby sheep 50.000 mg Làm đẹp da, chống lão hóa Hỗ trợ điều trị thâm nám', '<p>JOLIE PLACENTA OF BABY SHEEP</p>\n<p>Lọ 100 vi&ecirc;n</p>\n<p>C&aacute;ch d&ugrave;ng: uống1 vi&ecirc;n/ng&agrave;y sau ăn</p>\n<p>Th&agrave;nh phần:</p>\n<p>- Nhau thai cừu........................................................... 150 mg</p>\n<p>Isoflavon...................................................................... 50 mg</p>\n<p>Vitamine E.................................................................... 15 mg</p>\n<p>Vitamine C...................................................................... 5 mg</p>\n<p>Omega 3.................................................................... 300 mcg</p>\n<p>Glutathion..................................................................... 80 mg</p>\n<p>Chiết xuất từ hạt nho................................................. 300 mcg</p>\n<p>C&ocirc;ng dụng:</p>\n<p>- L&agrave;m đẹp da, chống l&atilde;o h&oacute;a.</p>\n<p>- Hỗ trợ điều trị th&acirc;m n&aacute;m, l&agrave;m mờ t&agrave;n nhang, c&aacute;c vết đồi mồi.</p>\n<p>- Cải thiện sắc tố da, tăng t&iacute;nh đ&agrave;n hồi v&agrave; chống chảy xệ, l&agrave;m mờ c&aacute;c vết nhăn.</p>\n<p>- L&agrave;m da trắng s&aacute;ng, mịn m&agrave;ng.</p>\n<p>- Cải thiện sinh l&yacute; nữ v&agrave; hội chứng thời kỳ tiền m&atilde;n kinh.</p>\n<p>- Bổ sung cung cấp v&agrave; c&acirc;n bằng h&agrave;m lượng estrogen giảm s&uacute;t cơ thể.</p>\n<p>- Hỗ trợ điều h&ograve;a kinh nguyệt v&agrave; giảm đau trong k&igrave; kinh.</p>\n<p>- K&eacute;o d&agrave;i tuổi thọ, tăng cường hệ miễn dịch đồng thời chống stress giảm mất ngủ.</p>\n<p>Xuất xứ: Australia</p>\n<p>Số đăng k&yacute;: 12510/2015/ATTP-XNCB</p>\n<p>NSX: Cosdermis Autralia</p>\n<p>Địa chỉ: 555 Marmion St 6154 Booragoon Australia.</p>\n<p>C&ocirc;ng ty nhập khẩu: C&ocirc;ng ty TNHH DP Green</p>\n<p>Độc quyền ph&acirc;n phối:&nbsp;http://thanhxuanduoc.com</p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 5, 342, 6, 1, 0, 0, 0, 0, '', 0, 0, 'vi', '', '', '', 1, 5, '0'),
(25, 'Trị sâu răng, Hôi miệng', '2016-01-18 13:31:33', '2016-02-19 20:50:42', 275000, 300000, 'Thuốc nam đặc trị sâu răng, Hôi miệng, Viêm Lợi, Chảy máu chân răng, Ghê buốt răng', '<p style="text-align: justify;">THUỐC NAM ĐẶC TRỊ S&Acirc;U RĂNG ,H&Ocirc;I MIỆNG, VI&Ecirc;M LỢI , CHẢY M&Aacute;U CH&Acirc;N RĂNG , GH&Ecirc; BUỐT RĂNG &hellip; D&Acirc;N TỘC DAO&nbsp;</p>\n<p style="text-align: justify;">B&agrave;i thuốc đ&atilde; gi&uacute;p h&agrave;ng ng&agrave;n ng&agrave;n người khỏi bệnh qua bao đời nay. Với th&agrave;nh phần ho&agrave;n to&agrave;n tự nhi&ecirc;n từ những c&acirc;y thuốc qu&yacute; &ndash; hiếm m&agrave; nh&agrave; m&igrave;nhi khai th&aacute;c ,thu gom ở nhiều rừng trong cộng đồng người Dao rồi tiến h&agrave;nh sơ chế , sao phơi .</p>\n<p style="text-align: justify;"><img src="http://thanhxuanduoc.com/images/source/tri-sau-rang-mau-mieng.jpg" alt="" width="960" height="720" /></p>\n<p style="text-align: justify;"><br /><strong>&bull; Th&agrave;nh phần</strong> : ho&agrave;n to&agrave;n bằng thảo mộc như : V&agrave;ng tằng , Nh&agrave;i trạ ,N&agrave;ng nh&agrave; h&acirc;y ,hoa c&uacute;c dại ,l&agrave;y toong` đ&igrave;a&hellip; v&agrave; c&aacute;c vi thuốc b&iacute; truyền kh&aacute;c đư<span class="text_exposed_show">ợc ng&acirc;m hạ thổ bảy bảy bốn ch&iacute;n ng&agrave;y ,đảm bảo c&aacute;c chứng b&ecirc;nh về răng miệng của bạn sẽ TUYỆT ĐỐI KH&Ocirc;NG Đ&Aacute;NG LO NỮA ..</span></p>\n<p style="text-align: justify;"><span class="text_exposed_show"><strong>&bull; Thuốc c&oacute; t&aacute;c dụng</strong> diệt trừ c&aacute;c mảng b&aacute;m vi khuẩn g&acirc;y s&acirc;u răng , h&ocirc;i miệng ở những chỗ s&acirc;u nhất trong răng v&agrave; kẽ răng , l&agrave;m răng v&agrave; lợi chắc khỏe , khử m&ugrave;i h&ocirc;i v&agrave; ngăn ngừa những chứng bệnh kh&aacute;c &hellip;</span></p>\n<p style="text-align: justify;"><span class="text_exposed_show">- Thuốc c&oacute; giấy ph&eacute;p kinh doanh v&agrave; chứng nhận l&agrave;ng nghề của nh&agrave; nước năm 2013.<br />Với đạo đức kinh doanh v&agrave; lương t&acirc;m của những người l&agrave;m thuốc điều m&igrave;nh muốn hướng tới v&agrave; cũng l&agrave; niềm mong mỏi lớn nhất đ&oacute; l&agrave; v&igrave; sức khỏe của cộng đồng .</span></p>\n<p style="text-align: justify;"><span style="font-size: 18pt;"><strong><span class="text_exposed_show">LH:&nbsp;<span style="color: #ff6600;">094 789 3386 &nbsp; - &nbsp;0965 613 469</span></span></strong></span></p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 2, 367, 12, 1, 0, 1, 0, 0, '', 0, 0, 'vi', 'Trị sâu răng, hôi miếng, chảy máu chân răng, viêm lợi', '', 'Thuốc nam đặc trị sâu răng, Hôi miệng, Viêm Lợi, Chảy máu chân răng, Ghê buốt răng. Sản phẩm của dân tộc Dao', 1, 1, '0'),
(26, 'Thuốc xoa bóp', '2016-01-18 13:50:34', '2016-02-19 20:50:20', 250000, 265000, 'Thời tiết trở trời,rất nhiều người bị đau xương khớp,đặc biết là người già và phụ nữ trung tuổi', '<p style="text-align: justify;">Thời tiết trở trời,rất nhiều người bị đau xương khớp,đặc biết l&agrave; người gi&agrave; v&agrave; phụ nữ trung tuổi.Nh&agrave; m&igrave;nh c&oacute; thuốc xoa b&oacute;p của người Dao,xoa giảm cơn đau rất nhanh,chịu kh&oacute; xoa thuốc h&agrave;ng ng&agrave;y sau 1 thời gian sẽ khỏi bệnh.</p>\n<p style="text-align: justify;">Thực sự l&agrave; mọi người khen về thuốc qu&aacute; nhiều ạ.H&atilde;y quan t&acirc;m tới &ocirc;ng b&agrave;,cha mẹ của m&igrave;nh bằng 1 h&agrave;nh động nhỏ m&agrave; tr&agrave;n đầy &yacute; nghĩa .</p>\n<p style="text-align: justify;">Chỉ 1 lọ thuốc n&agrave;y th&ocirc;i ạ,c&ograve;n qu&yacute; hơn biếu tiền bạc nhiều lần.Thuốc qu&yacute; d&acirc;n tộc Dao c&ograve;n trị c&aacute;c vết bầm t&iacute;m,muỗi đốt,giảm đau nhanh ch&oacute;ng kh&ocirc;ng cần d&ugrave;ng tới thuốc T&acirc;y.</p>', '', '', '', '', '', 0, 0, 0, ',,', ',,', 0, 0, NULL, 2, 328, 13, 1, 0, 0, 0, 1, '', 0, 0, 'vi', 'thuốc xoa bóp gia truyền', '', 'thuốc xoa bóp của người Dao,xoa giảm cơn đau rất nhanh,chịu khó xoa thuốc hàng ngày sau 1 thời gian sẽ khỏi bệnh.', 1, 1, '0'),
(27, 'Trị hôi nách', '2016-01-18 14:19:53', '2017-05-14 11:51:23', 220000, 230000, 'Có rất nhiều người bị hôi nách tỏ ra hoang mang không biết xử dụng loại thuốc hay biện pháp', '<h2 style="text-align: justify;">C&oacute; rất nhiều người bị h&ocirc;i n&aacute;ch tỏ ra hoang mang kh&ocirc;ng biết xử dụng loại thuốc hay biện ph&aacute;p n&agrave;o để điều trị tận gốc h&ocirc;i n&aacute;ch. H&atilde;y c&ugrave;ng chuy&ecirc;n gia đ&aacute;nh gi&aacute; về c&aacute;ch điều trị h&ocirc;i n&aacute;ch an to&agrave;n v&agrave; hiệu quả nhất.</h2>\r\n<p style="text-align: justify;">H&ocirc;i n&aacute;ch l&agrave; bệnh l&yacute; thường gặp trong cuộc sống.Chứng bệnh h&ocirc;i n&aacute;ch lu&ocirc;n g&acirc;y nhiều phiền to&aacute;i rắc rối, sự mất tự tin, t&acirc;m l&yacute; nặng nề , mặc cảm tự ti trong cuộc sống . Bệnh thường tạo ra m&ugrave;i h&ocirc;i nồng nặc kh&oacute; chịu khiến người xung quanh phải xa l&aacute;nh, ngại tiếp x&uacute;c trong cuộc sống. Ch&iacute;nh v&igrave; vậy, mong muốn t&igrave;m ra c&aacute;ch chữa trị h&ocirc;i n&aacute;ch lu&ocirc;n l&agrave; mối quan t&acirc;m h&agrave;ng đầu của người bệnh.</p>\r\n<p style="text-align: justify;">Đối với người bị bệnh h&ocirc;i n&aacute;ch chỉ cần hoạt động nhẹ ra mồ h&ocirc;i l&agrave; cơ thể sẽ bắt đầu c&oacute; m&ugrave;i bởi v&igrave; khi ta vận động c&aacute;c tuyến mồ h&ocirc;i trong cơ thể bị k&iacute;ch th&iacute;ch sẽ tiết ra axit b&eacute;o ở dạng lỏng, sau khi axit kết hợp với vi khuẩn ph&acirc;n hủy tr&ecirc;n bề mặt da sẽ h&igrave;nh th&agrave;nh một loại axit b&eacute;o kh&ocirc;ng b&atilde;o h&ograve;a c&oacute; m&ugrave;i kh&oacute; ngửi, được gọi l&agrave; m&ugrave;i h&ocirc;i n&aacute;ch. Bệnh h&ocirc;i n&aacute;ch thường li&ecirc;n quan nhiều đến yếu tố di truyền , nội tiết , tuổi t&aacute;c , giới t&iacute;nh.Bệnh c&oacute; thể gặp ở cả nam lẫn nữ</p>\r\n<p><br /><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/dieutrihoinach.jpg" alt="" width="398" height="457" /><br />Bị h&ocirc;i n&aacute;ch kh&oacute; chịu m&ugrave;i h&ocirc;i cơ thể, khử m&ugrave;i cũng kh&ocirc;ng hết, tắm v&agrave; giặt sạch vẫn kh&ocirc;ng đi, m&ugrave;i h&ocirc;i sẽ mang đến ảnh hưởng cho người t&acirc;m trạng lo ngại, kh&ocirc;ng đủ tự tin, buồn phiền , học h&agrave;nh, giao tiếp sự nghiệp v&agrave; nhất l&agrave; h&ocirc;n nh&acirc;n sẽ g&acirc;y &aacute;p lực căng thẳng, h&ocirc;i n&aacute;ch tiếp tục k&eacute;o d&agrave;i sẽ rất nghi&ecirc;m trọng ảnh hưởng đến sức khỏe v&agrave; sinh hoạt hằng ng&agrave;y.</p>\r\n<h2 style="text-align: justify;">Giải ph&aacute;p điều trị h&ocirc;i n&aacute;ch</h2>\r\n<p style="text-align: justify;">C&oacute; nhiều bạn v&agrave;o hỏi thuốc trị h&ocirc;i n&aacute;ch, h&ocirc;i ch&acirc;n nh&agrave; m&igrave;nh c&oacute; tốt kh&ocirc;ng? Sao rẻ hơn thuốc của Trần Mười với Hồng Sơn, tiện đ&acirc;y m&igrave;nh cũng n&oacute;i lu&ocirc;n,bởi c&aacute;c nh&agrave; thuốc tốn rất nhiều chi ph&iacute; chạy quảng c&aacute;o v&agrave; chi ph&iacute; thu&ecirc; nh&acirc;n vi&ecirc;n tư vấn cho kh&aacute;ch, về chất lượng th&igrave; kh&ocirc;ng ai d&aacute;m khẳng định thuốc n&agrave;o tốt hơn?Nhưng c&oacute; rất nhiều kh&aacute;ch d&ugrave;ng thuốc của nh&agrave; m&igrave;nh sau đ&oacute; giới thiệu cho bạn b&egrave; người th&acirc;n sử dụng rất nhiều, kh&ocirc;ng mất chi ph&iacute; chạy quảng c&aacute;o m&agrave; hiệu ứng th&igrave; qu&aacute; tốt ạ.</p>\r\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://thanhxuanduoc.com/images/source/tri-hoi-nach.jpg" alt="" width="400" height="400" /></p>\r\n<p style="text-align: justify;">C&ograve;n ai đang khổ t&acirc;m với mấy bệnh n&agrave;y hay bệnh ra mồ h&ocirc;i ch&acirc;n tay qu&aacute; nhiều h&atilde;y sử dụng b&agrave;i thuốc đ&ocirc;ng y của d&acirc;n tộc T&agrave;y.Cam kết về chất lượng thuốc.</p>\r\n<p style="text-align: justify;">TRỊ VĨNH VIẾN H&Ocirc;I N&Aacute;CH,H&Ocirc;I CH&Acirc;N V&Agrave; BỆNH CH&Acirc;N TAY RA NHIỀU MỒ H&Ocirc;I VỚI B&Agrave;I THUỐC QU&Yacute; CỦA NGƯỜI T&Agrave;Y DUY NHẤT 1 LIỆU TR&Igrave;NH 15-30 NG&Agrave;Y.</p>\r\n<p style="text-align: justify;"><strong><span style="font-size: 18pt;">LH tư vấn: <span style="color: #ff0000;">094 789 3386 - 0965 613 469</span></span></strong></p>\r\n<p style="text-align: justify;">&nbsp;</p>', '', '', '', '', '', 0, 0, 1, ',,', ',,', 0, 0, NULL, 2, 402, 17, 1, 0, 0, 0, 1, '', 0, 0, 'vi', 'Trị hôi nách tận gốc', '', 'TRỊ VĨNH VIẾN HÔI NÁCH,HÔI CHÂN VÀ BỆNH CHÂN TAY RA NHIỀU MỒ HÔI VỚI BÀI THUỐC QUÝ CỦA NGƯỜI TÀY DUY NHẤT 1 LIỆU TRÌNH 15-30 NGÀY', 1, 1, '0'),
(29, 'Kem chống nắng', '2017-05-14 11:51:33', '2017-05-22 11:50:19', 333000, 333000, '', '<p>Th&ocirc;ng tin sản phẩm</p>', '', '', '', '', '', 0, 0, 1, ',2,', ',1,', 0, 0, NULL, 5, 49, 15, 1, 0, 0, 0, 0, '', 0, 0, 'vi', '', '', '', 1, 1, '0'),
(33, 'Áo sơ mi', '2017-05-22 13:55:16', '2017-05-22 14:41:55', 2000000, 2100000, 'Mô tả ngắn', '<p>th&ocirc;ng tin sản phẩm</p>', '', '', '', '', '', 0, 0, 1, ',3,', ',1,2,3,4,5,', 0, 0, NULL, 3, 53, 18, 1, 0, 0, 0, 0, 'quần,áo,vớ', 0, 0, 'vi', '', '', 'đây mà description', 1, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_categories`
--

CREATE TABLE `txd_products_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(256) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` tinyint(4) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `avatar` varchar(500) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `home` tinyint(1) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_categories`
--

INSERT INTO `txd_products_categories` (`id`, `category`, `parent_id`, `level`, `position`, `thumbnail`, `avatar`, `summary`, `content`, `status`, `meta_title`, `meta_keywords`, `meta_description`, `home`, `lang`, `creator`, `editor`) VALUES
(2, 'Đông y cổ truyền', 0, 0, 1, '', '', '', '', 1, '', '', '', 1, 'vi', 1, 1),
(3, 'Làm đẹp', 0, 0, 2, '', '', '', '', 1, '', '', '', 1, 'vi', 1, 1),
(4, 'Sức khỏe', 0, 0, 3, '', '', '', '', 1, '', '', '', 1, 'vi', 1, 1),
(5, 'Nhau thai cừu', 3, 1, 1, '', '', '', '', 1, '', '', '', 0, 'vi', 1, 1),
(6, 'Collagen', 3, 1, 2, '', '', '', '', 1, '', '', '', 0, 'vi', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_color`
--

CREATE TABLE `txd_products_color` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_color`
--

INSERT INTO `txd_products_color` (`id`, `name`, `code`, `status`, `creator`, `editor`) VALUES
(1, 'Trắng', 'FFFFFF', 1, 1, 1),
(2, 'Đen', '000000', 1, 1, 1),
(3, 'Đỏ', 'FF0000', 1, 1, 1),
(4, 'Xanh lá cây', '00FF00', 1, 1, 1),
(5, 'Xanh lam', '0000FF', 1, 1, 1),
(6, 'Vàng', 'FFFF00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_coupon`
--

CREATE TABLE `txd_products_coupon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'kiểu giảm giá',
  `discount` double NOT NULL COMMENT 'số lượng giảm',
  `price_min` double NOT NULL DEFAULT '0',
  `end_date` datetime NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1' COMMENT 'số lần sử dụng',
  `count` int(11) NOT NULL DEFAULT '1' COMMENT 'số lượng mã',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `creator` int(11) NOT NULL DEFAULT '1',
  `editor` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_coupon`
--

INSERT INTO `txd_products_coupon` (`id`, `name`, `discount_type`, `discount`, `price_min`, `end_date`, `number`, `count`, `status`, `creator`, `editor`) VALUES
(1, 'Test mã coupon', 2, 100000, 500000, '2015-09-30 09:49:00', 1, 100, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_coupon_item`
--

CREATE TABLE `txd_products_coupon_item` (
  `code` varchar(255) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_coupon_item`
--

INSERT INTO `txd_products_coupon_item` (`code`, `coupon_id`, `status`) VALUES
('NVESLKJ53O', 1, 1),
('FRMI9OYXQD', 1, 1),
('YEOVEWECRN', 1, 1),
('7QYNW1JEOC', 1, 1),
('M4O1G8T12S', 1, 1),
('PGMCP9G8PR', 1, 1),
('ISKE9IQNZ7', 1, 1),
('72ILOSP588', 1, 1),
('JAKYE9EY3J', 1, 1),
('9ASIJWBG3G', 1, 1),
('81ANCUOOZ4', 1, 1),
('XAVQ7N63SG', 1, 1),
('VY5RGENASL', 1, 1),
('JG41CXWE1P', 1, 1),
('R6QYR4IA3A', 1, 1),
('AXNOIAGRFS', 1, 1),
('4WT7AM3TWT', 1, 1),
('WJ254Y390J', 1, 1),
('NXQQSVQQJD', 1, 1),
('6UVXIFS2R1', 1, 1),
('LWQAYLGQPS', 1, 1),
('LA9B2753MJ', 1, 1),
('0XYRHSJ74F', 1, 1),
('HWJVSKFAHN', 1, 1),
('XP0DD0CY6I', 1, 1),
('7BDK4N3BP2', 1, 1),
('RHZE6QZ0V0', 1, 1),
('4X5WBMHK3E', 1, 1),
('DLTYBNDS8I', 1, 1),
('HF73NOCT7C', 1, 1),
('W9QLSF03X0', 1, 1),
('VJE6UXATUG', 1, 1),
('PS8P9G3P4Q', 1, 1),
('M42SBP3RPL', 1, 1),
('OFI8ILUSD8', 1, 1),
('X29UNSMJ2S', 1, 1),
('VD8MA1OZVJ', 1, 1),
('7CXL6JLYKN', 1, 1),
('2WUBN09MG0', 1, 1),
('AZ3Q2YUW4G', 1, 1),
('VZ9CUEMOBW', 1, 1),
('TD0T46ROPB', 1, 1),
('T4WFG84U1L', 1, 1),
('RE1B300C2Y', 1, 1),
('NFDR86LPK0', 1, 1),
('O2XSYBDY99', 1, 1),
('B2GNBA68U7', 1, 1),
('0SSGJ9EQZ1', 1, 1),
('JDOSP37V58', 1, 1),
('TUVA1L3NOH', 1, 1),
('2MGV6IUVF4', 1, 1),
('FEU5D0ZVDW', 1, 1),
('RQVWGGL4SJ', 1, 1),
('OAGMDCAVX1', 1, 1),
('POEQYCIU5D', 1, 1),
('H59BF9ZRZX', 1, 1),
('2Z43VG8RSY', 1, 1),
('022VL25P4Q', 1, 0),
('S4HNZL45JA', 1, 1),
('5FUHNO50SE', 1, 1),
('DZASV6CQ4Z', 1, 1),
('I9XTWN9R6L', 1, 1),
('XX851RPX5S', 1, 1),
('TBYYQKPELZ', 1, 1),
('BIPEQR4CPG', 1, 1),
('SBMYSX6C0M', 1, 1),
('B6R863DISR', 1, 1),
('NGO80GC4CV', 1, 1),
('QRR94QNSY8', 1, 1),
('3IWGDRGW0N', 1, 1),
('6OTIEB2KL7', 1, 1),
('B4E6QNCTUD', 1, 1),
('F7RN6CLOPO', 1, 1),
('HCFKBL85N6', 1, 1),
('T69RIZAYNA', 1, 1),
('CDO9EU3QI5', 1, 1),
('4TWBGB8K0U', 1, 1),
('EBO06RBK0F', 1, 1),
('WHL1SW0B8I', 1, 1),
('2R9CSF1TXU', 1, 1),
('HML8S9Q2X9', 1, 1),
('JQCL7P0JBA', 1, 1),
('5O55GBOB2C', 1, 1),
('A9GC2RWAQO', 1, 1),
('63TQX8WEG0', 1, 1),
('PZ63CLM08C', 1, 1),
('EPYDP4ZQ3D', 1, 1),
('MX27U2XPNY', 1, 1),
('QALGN4FWMW', 1, 1),
('YPFJII9Q0E', 1, 1),
('W8IM8F8P4L', 1, 1),
('WRBYV6C19Y', 1, 1),
('9Q13NS1J0J', 1, 1),
('K8B0VIG8DV', 1, 1),
('SF88OH4DZB', 1, 1),
('6FMF88AMYX', 1, 1),
('0IYRU3ZXUX', 1, 1),
('ICY8QSF7OR', 1, 1),
('RLU9MSMQOD', 1, 1),
('6GKJYWQETK', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_material`
--

CREATE TABLE `txd_products_material` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_material`
--

INSERT INTO `txd_products_material` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(1, 'Da trơn', 1, 1, 1),
(2, 'Da lộn', 1, 1, 1),
(3, 'Da sần', 1, 1, 1),
(4, 'Da sáp', 1, 1, 1),
(5, 'Nỉ', 1, 1, 1),
(6, 'Lưới', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_origin`
--

CREATE TABLE `txd_products_origin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_origin`
--

INSERT INTO `txd_products_origin` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(4, 'Pháp', 1, 1, 1),
(2, 'Mỹ', 1, 1, 1),
(3, 'Hàn quốc', 1, 1, 1),
(5, 'Việt Nam', 1, 1, 1),
(6, 'Trung Quốc', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_size`
--

CREATE TABLE `txd_products_size` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_size`
--

INSERT INTO `txd_products_size` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(1, '35', 1, 1, 1),
(2, '36', 1, 1, 1),
(3, '37', 1, 1, 1),
(4, '38', 1, 1, 1),
(5, '39', 1, 1, 1),
(6, '40', 1, 1, 1),
(7, '41', 1, 1, 1),
(8, '42', 1, 1, 1),
(9, '43', 1, 1, 1),
(12, 'M', 1, 1, 1),
(11, 'S', 1, 1, 1),
(13, 'L', 1, 1, 1),
(14, 'XL', 1, 1, 1),
(15, 'XXL', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_state`
--

CREATE TABLE `txd_products_state` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_state`
--

INSERT INTO `txd_products_state` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(1, 'Còn hàng', 1, 1, 1),
(2, 'Hết hàng', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_style`
--

CREATE TABLE `txd_products_style` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_style`
--

INSERT INTO `txd_products_style` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(1, 'Giày sneaker nam', 1, 1, 1),
(2, 'Giày sneaker nữ', 1, 1, 1),
(3, 'Giày slip-on nam', 1, 1, 1),
(4, 'Giày slip-on nữ', 1, 1, 1),
(5, 'Giày running nam', 1, 1, 1),
(6, 'Giày running nữ', 1, 1, 1),
(7, 'Giày tập gym nam', 1, 1, 1),
(8, 'Giày tập gym nữ', 1, 1, 1),
(9, 'Giày sneaker trẻ em', 1, 1, 1),
(10, 'Giày slipon trẻ em', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_products_trademark`
--

CREATE TABLE `txd_products_trademark` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_products_trademark`
--

INSERT INTO `txd_products_trademark` (`id`, `name`, `status`, `creator`, `editor`) VALUES
(1, 'Nike', 1, 1, 1),
(2, 'Adidas', 1, 1, 1),
(3, 'Puma', 1, 1, 1),
(4, 'New Balance', 1, 1, 1),
(5, 'Asics', 1, 1, 1),
(6, 'Reebok', 1, 1, 1),
(7, 'Saucony', 1, 1, 1),
(8, 'Uniqlo', 1, 1, 1),
(9, 'Morino', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_product_images`
--

CREATE TABLE `txd_product_images` (
  `id` int(11) NOT NULL,
  `image_name` varchar(256) NOT NULL,
  `position` tinyint(1) DEFAULT '0',
  `products_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `txd_product_images`
--

INSERT INTO `txd_product_images` (`id`, `image_name`, `position`, `products_id`) VALUES
(54, 'trihoinach_27_32035.jpg', 1, 27),
(53, 'trisauranghoimieng_25_22cd6.jpg', 1, 25),
(36, 'bonaofocusdha_20_1b3bf.jpg', 1, 20),
(39, 'bonaodhaplus_22_27a87.jpg', 1, 22),
(38, 'ancanthucphamchucnang_24_27884.jpg', 1, 24),
(51, 'thuocxoabop_26_2261a.jpg', 1, 26),
(35, 'nhauthaicuujolieplacentaofbabysheep50000mg_19_1b2cb.jpg', 1, 19),
(34, 'nhauthaicuuaustraliaplacentrasupervip30000mg_18_1b206.png', 1, 18),
(59, 'kemchongnang_29_1be8a.jpg', 3, 29),
(57, 'kemchongnang_29_171ed.jpg', 1, 29),
(58, 'kemchongnang_29_171ee.png', 2, 29),
(65, '24356_33_22922.jpg', 1, 33);

-- --------------------------------------------------------

--
-- Table structure for table `txd_roles`
--

CREATE TABLE `txd_roles` (
  `id` int(11) NOT NULL,
  `roles` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `publisher` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `txd_roles`
--

INSERT INTO `txd_roles` (`id`, `roles`, `name`, `publisher`, `status`, `creator`, `editor`) VALUES
(1, 'all', 'Quản trị hệ thống', 1, 1, 1, 1),
(2, '["2"]', 'Đăng bài viết', 0, 1, 1, 1),
(3, '["1","12","5"]', 'test', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_roles_menus`
--

CREATE TABLE `txd_roles_menus` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `url_path` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_roles_menus`
--

INSERT INTO `txd_roles_menus` (`id`, `label`, `module`, `url_path`, `status`) VALUES
(1, 'Người dùng', 'auth', '/dashboard/auth', 1),
(2, 'Bài viết', 'news', '/dashboard/news', 1),
(3, 'Sản phẩm', 'products', '/dashboard/products', 1),
(4, 'Trang', 'pages', '/dashboard/pages', 1),
(5, 'Liên hệ', 'contact', '/dashboard/contact', 1),
(6, 'Tải files', 'download', '/dashboard/download', 0),
(7, 'Tranh ảnh', 'gallery', '/dashboard/gallery', 0),
(8, 'Videos', 'videos', '/dashboard/videos', 0),
(9, 'Banner', 'advs', '/dashboard/advs,/dashboard/advs/add,/dashboard/advs/cat', 1),
(10, 'Hỗ trợ trực tuyến', 'supports', '/dashboard/supports', 1),
(11, 'Hệ thống menu', 'menus', '/dashboard/menus', 1),
(12, 'Cấu hình chung', 'configurations', '/dashboard/system_config', 1),
(13, 'Hỏi đáp', 'faq', '/dashboard/faq', 0),
(14, 'Đơn hàng', 'orders', '/dashboard/orders', 1),
(15, 'Khách hàng', 'customers', '/dashboard/customers', 0);

-- --------------------------------------------------------

--
-- Table structure for table `txd_slug`
--

CREATE TABLE `txd_slug` (
  `id` int(11) NOT NULL,
  `slug` varchar(1000) NOT NULL,
  `type` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_slug`
--

INSERT INTO `txd_slug` (`id`, `slug`, `type`, `type_id`) VALUES
(1508, 'dong-y-co-truyen', 4, 2),
(1510, 'tin-tuc', 2, 1),
(1609, '6-cach-tri-dau-dau-khong-can-dung-thuoc.html', 1, 67),
(1610, '5-cach-chua-dau-hong-khong-can-dung-thuoc.html', 1, 68),
(1611, 'tri-sau-rang-hoi-mieng.html', 3, 25),
(1612, 'thuoc-xoa-bop.html', 3, 26),
(1613, 'tri-hoi-nach.html', 3, 27),
(1516, 'dong-y-co-truyen', 2, 2),
(1615, 'cach-tri-hoi-nach-bang-phen-chua-hieu-qua.html', 1, 69),
(1616, 'cach-tri-hoi-nach-bang-muop-dang-hieu-qua.html', 1, 70),
(1617, 'cach-tri-hoi-nach-bang-trung-ga-hieu-qua-tai-nha.html', 1, 71),
(1522, 'tu-van-lam-dep', 2, 3),
(1601, 'cach-xu-li-cap-toc-khi-da-bi-di-ung-my-pham.html', 1, 59),
(1602, 'nhung-trieu-chung-benh-yeu-sinh-ly-o-nam-gioi.html', 1, 60),
(1603, 'mach-nho-nhung-thuc-pham-me-bau-nen-an.html', 1, 61),
(1604, 'tai-sao-vo-sinh-ngay-ca-khi-co-tinh-trung.html', 1, 62),
(1605, 'bi-quyet-hoi-xuan-voi-mat-na-duong-da-cuc-de-lam.html', 1, 63),
(1606, 'bi-quyet-giup-ban-tiec-tung-tha-ga-ngay-tet-khong-lo-tang-can.html', 1, 64),
(1608, 'meo-chua-hoi-mieng-don-gian-hieu-qua-cao.html', 1, 66),
(1596, 'lam-the-nao-de-co-da-dep-tu-nhien.html', 1, 55),
(1597, 'cach-lam-dep-da-bang-sua-chua.html', 1, 56),
(1598, 'cach-cham-soc-da-nhon-mun-dung-cach.html', 1, 57),
(1607, '5-meo-tri-hoi-chan-hieu-qua-tai-nha.html', 1, 65),
(1542, 'lam-dep', 4, 3),
(1546, 'suc-khoe', 4, 4),
(1595, 'ancan-thuc-pham-chuc-nang.html', 3, 24),
(1573, 'tu-van-suc-khoe', 2, 5),
(1578, 'cau-hoi-thuong-gap', 2, 7),
(1577, 'huong-dan-mua-hang.html', 11, 14),
(1592, 'bo-nao-focus-dha.html', 3, 20),
(1614, 'tri-hoi-nach', 2, 8),
(1594, 'bo-nao-dha-plus.html', 3, 22),
(1588, 'nhau-thai-cuu', 4, 5),
(1589, 'collagen', 4, 6),
(1590, 'nhau-thai-cuu-australia-placentra-super-vip-30000-mg.html', 3, 18),
(1591, 'nhau-thai-cuu-jolie-placenta-of-baby-sheep-50000-mg.html', 3, 19),
(1618, 'kem-chong-nang.html', 3, 29),
(1619, 'ao-so-mi.html', 3, 33);

-- --------------------------------------------------------

--
-- Table structure for table `txd_supports`
--

CREATE TABLE `txd_supports` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` tinyint(4) DEFAULT NULL,
  `content` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL,
  `editor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='User Editable Pages';

--
-- Dumping data for table `txd_supports`
--

INSERT INTO `txd_supports` (`id`, `title`, `type`, `content`, `position`, `create_time`, `update_time`, `status`, `lang`, `creator`, `editor`) VALUES
(1, 'Tư vấn Bán Hàng', 3, '094 789 3386', 1, 1429759849, 1450687491, 1, 'vi', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_units`
--

CREATE TABLE `txd_units` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `txd_units`
--

INSERT INTO `txd_units` (`id`, `name`, `position`, `lang`, `creator`, `editor`) VALUES
(1, 'Chiếc', 1, 'vi', 1, 1),
(2, 'Cái', 2, 'vi', 1, 1),
(3, 'Bộ', 3, 'vi', 1, 1),
(4, 'Túi', 4, 'vi', 1, 1),
(5, 'Đôi', 5, 'vi', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_users`
--

CREATE TABLE `txd_users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `DOB` datetime DEFAULT NULL COMMENT 'Date Of Birth',
  `address` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `tel` varchar(25) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL COMMENT '	',
  `level` int(11) NOT NULL DEFAULT '0',
  `company` varchar(256) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `active` smallint(1) DEFAULT '1',
  `alias_name` varchar(15) DEFAULT NULL,
  `cities_id` int(11) NOT NULL DEFAULT '1',
  `joined_date` datetime DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `is_openid` tinyint(4) DEFAULT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `txd_users`
--

INSERT INTO `txd_users` (`id`, `fullname`, `DOB`, `address`, `email`, `tel`, `username`, `password`, `level`, `company`, `role_id`, `active`, `alias_name`, `cities_id`, `joined_date`, `avatar`, `is_openid`, `creator`, `editor`) VALUES
(1, 'Administrator', NULL, NULL, '', '', 'admin', '5458186f57705ea77db17feea4ff67f5', 1, NULL, 1, 1, NULL, 1, '2016-02-26 11:50:35', NULL, NULL, 1, 1),
(5, 'Hoàng Yến', NULL, NULL, 'dinhhoangyenit@gmail.com', '0974318892', 'hoangyen', '641c75f0bf4bc3771582818531f153d5', 1, NULL, 1, 1, NULL, 1, '2016-02-23 09:05:40', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `txd_videos`
--

CREATE TABLE `txd_videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `avatar` varchar(500) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `home` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_videos_categories`
--

CREATE TABLE `txd_videos_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `status` tinyint(1) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `creator` int(11) NOT NULL DEFAULT '0',
  `editor` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `txd_videos_items`
--

CREATE TABLE `txd_videos_items` (
  `id` int(11) NOT NULL,
  `url` varchar(500) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `youtube_video_id` varchar(255) NOT NULL,
  `summary` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `position` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `txd_advs`
--
ALTER TABLE `txd_advs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_advs_categories`
--
ALTER TABLE `txd_advs_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_advs_click`
--
ALTER TABLE `txd_advs_click`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_ci_sessions`
--
ALTER TABLE `txd_ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `txd_configuration`
--
ALTER TABLE `txd_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_contact`
--
ALTER TABLE `txd_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_customers`
--
ALTER TABLE `txd_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_download`
--
ALTER TABLE `txd_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_download_categories`
--
ALTER TABLE `txd_download_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_faq`
--
ALTER TABLE `txd_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_faq_categories`
--
ALTER TABLE `txd_faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_faq_professionals`
--
ALTER TABLE `txd_faq_professionals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_gallery`
--
ALTER TABLE `txd_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_gallery_categories`
--
ALTER TABLE `txd_gallery_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_gallery_images`
--
ALTER TABLE `txd_gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_menus`
--
ALTER TABLE `txd_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_menus_categories`
--
ALTER TABLE `txd_menus_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_news`
--
ALTER TABLE `txd_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_news_categories` (`cat_id`);

--
-- Indexes for table `txd_news_categories`
--
ALTER TABLE `txd_news_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_orders`
--
ALTER TABLE `txd_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_pages`
--
ALTER TABLE `txd_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products`
--
ALTER TABLE `txd_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_users` (`users_id`),
  ADD KEY `fk_products_categories` (`categories_id`);
ALTER TABLE `txd_products` ADD FULLTEXT KEY `product_name` (`product_name`);
ALTER TABLE `txd_products` ADD FULLTEXT KEY `product_name_2` (`product_name`);

--
-- Indexes for table `txd_products_categories`
--
ALTER TABLE `txd_products_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_color`
--
ALTER TABLE `txd_products_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_coupon`
--
ALTER TABLE `txd_products_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_coupon_item`
--
ALTER TABLE `txd_products_coupon_item`
  ADD KEY `code` (`code`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `txd_products_material`
--
ALTER TABLE `txd_products_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_origin`
--
ALTER TABLE `txd_products_origin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_size`
--
ALTER TABLE `txd_products_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_state`
--
ALTER TABLE `txd_products_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_style`
--
ALTER TABLE `txd_products_style`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_products_trademark`
--
ALTER TABLE `txd_products_trademark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_product_images`
--
ALTER TABLE `txd_product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_images_products` (`products_id`);

--
-- Indexes for table `txd_roles`
--
ALTER TABLE `txd_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_roles_menus`
--
ALTER TABLE `txd_roles_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_slug`
--
ALTER TABLE `txd_slug`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_supports`
--
ALTER TABLE `txd_supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_units`
--
ALTER TABLE `txd_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_users`
--
ALTER TABLE `txd_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_videos`
--
ALTER TABLE `txd_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_videos_categories`
--
ALTER TABLE `txd_videos_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txd_videos_items`
--
ALTER TABLE `txd_videos_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `txd_advs`
--
ALTER TABLE `txd_advs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `txd_advs_categories`
--
ALTER TABLE `txd_advs_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `txd_advs_click`
--
ALTER TABLE `txd_advs_click`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_configuration`
--
ALTER TABLE `txd_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `txd_contact`
--
ALTER TABLE `txd_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `txd_customers`
--
ALTER TABLE `txd_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_download`
--
ALTER TABLE `txd_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_download_categories`
--
ALTER TABLE `txd_download_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_faq`
--
ALTER TABLE `txd_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_faq_categories`
--
ALTER TABLE `txd_faq_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `txd_faq_professionals`
--
ALTER TABLE `txd_faq_professionals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_gallery`
--
ALTER TABLE `txd_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_gallery_categories`
--
ALTER TABLE `txd_gallery_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_gallery_images`
--
ALTER TABLE `txd_gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_menus`
--
ALTER TABLE `txd_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=786;
--
-- AUTO_INCREMENT for table `txd_menus_categories`
--
ALTER TABLE `txd_menus_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `txd_news`
--
ALTER TABLE `txd_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `txd_news_categories`
--
ALTER TABLE `txd_news_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `txd_orders`
--
ALTER TABLE `txd_orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `txd_pages`
--
ALTER TABLE `txd_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `txd_products`
--
ALTER TABLE `txd_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `txd_products_categories`
--
ALTER TABLE `txd_products_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `txd_products_color`
--
ALTER TABLE `txd_products_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `txd_products_coupon`
--
ALTER TABLE `txd_products_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `txd_products_material`
--
ALTER TABLE `txd_products_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `txd_products_origin`
--
ALTER TABLE `txd_products_origin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `txd_products_size`
--
ALTER TABLE `txd_products_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `txd_products_state`
--
ALTER TABLE `txd_products_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `txd_products_style`
--
ALTER TABLE `txd_products_style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `txd_products_trademark`
--
ALTER TABLE `txd_products_trademark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `txd_product_images`
--
ALTER TABLE `txd_product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `txd_roles`
--
ALTER TABLE `txd_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `txd_roles_menus`
--
ALTER TABLE `txd_roles_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `txd_slug`
--
ALTER TABLE `txd_slug`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1620;
--
-- AUTO_INCREMENT for table `txd_supports`
--
ALTER TABLE `txd_supports`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `txd_units`
--
ALTER TABLE `txd_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `txd_users`
--
ALTER TABLE `txd_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `txd_videos`
--
ALTER TABLE `txd_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_videos_categories`
--
ALTER TABLE `txd_videos_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `txd_videos_items`
--
ALTER TABLE `txd_videos_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

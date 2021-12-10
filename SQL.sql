-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2020 at 12:50 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multipurpose`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_table`
--

CREATE TABLE `activity_table` (
  `activity_id` int(11) NOT NULL,
  `activity_user_id` int(11) NOT NULL,
  `activity_agent` varchar(255) NOT NULL,
  `activity_time` varchar(20) NOT NULL,
  `activity_ip` varchar(15) NOT NULL,
  `activity_login_status` tinyint(1) NOT NULL COMMENT '1: Success | 2: UnSuccess',
  `activity_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Activity Table';

-- --------------------------------------------------------

--
-- Table structure for table `admob_setting_table`
--

CREATE TABLE `admob_setting_table` (
  `admob_setting_id` int(11) NOT NULL,
  `admob_setting_app_id` varchar(255) NOT NULL,
  `admob_setting_banner_unit_id` varchar(255) NOT NULL,
  `admob_setting_interstitial_unit_id` varchar(255) NOT NULL,
  `admob_setting_rewarded_unit_id` varchar(255) NOT NULL,
  `admob_setting_native_advanced_unit_id` varchar(255) NOT NULL,
  `admob_setting_banner_size` varchar(35) NOT NULL,
  `admob_setting_interstitial_clicks` smallint(6) NOT NULL,
  `admob_setting_banner_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `admob_setting_interstitial_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `admob_setting_rewarded_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `admob_setting_native_advanced_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='AdMob Setting Table';

--
-- Dumping data for table `admob_setting_table`
--

INSERT INTO `admob_setting_table` (`admob_setting_id`, `admob_setting_app_id`, `admob_setting_banner_unit_id`, `admob_setting_interstitial_unit_id`, `admob_setting_rewarded_unit_id`, `admob_setting_native_advanced_unit_id`, `admob_setting_banner_size`, `admob_setting_interstitial_clicks`, `admob_setting_banner_status`, `admob_setting_interstitial_status`, `admob_setting_rewarded_status`, `admob_setting_native_advanced_status`) VALUES
(1, 'ca-app-pub-3940256099942544~3347511713', 'ca-app-pub-3940256099942544/6300978111', 'ca-app-pub-3940256099942544/1033173712', '', '', 'LARGE_BANNER', 5, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `api_table`
--

CREATE TABLE `api_table` (
  `api_id` int(11) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `api_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='API Table';

--
-- Dumping data for table `api_table`
--

INSERT INTO `api_table` (`api_id`, `api_key`, `api_status`) VALUES
(1, 'mPddYY6gr41q2tyHF2x1jKOplr14zA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_table`
--

CREATE TABLE `bookmark_table` (
  `bookmark_id` int(11) NOT NULL,
  `bookmark_user_id` int(11) NOT NULL,
  `bookmark_content_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bookmark Table';

--
-- Dumping data for table `bookmark_table`
--

INSERT INTO `bookmark_table` (`bookmark_id`, `bookmark_user_id`, `bookmark_content_id`) VALUES
(6, 1, 17),
(8, 1, 8),
(9, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `captcha_table`
--

CREATE TABLE `captcha_table` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `captcha_ip_address` varchar(45) NOT NULL,
  `captcha_word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `captcha_table`
--

INSERT INTO `captcha_table` (`captcha_id`, `captcha_time`, `captcha_ip_address`, `captcha_word`) VALUES
(6, 1582436063, '::1', '72360'),
(7, 1582436066, '::1', '38078'),
(8, 1582436087, '::1', '28089'),
(9, 1582956186, '::1', '75270'),
(10, 1586580514, '::1', '83981'),
(11, 1588569401, '::1', '98798'),
(12, 1588570609, '10.10.11.195', '87732'),
(13, 1588570642, '10.10.11.195', '92138'),
(14, 1588570667, '10.10.11.195', '36014'),
(15, 1590121423, '::1', '16220'),
(16, 1590121428, '::1', '35115'),
(17, 1590121493, '::1', '95620'),
(18, 1590388828, '::1', '11831'),
(19, 1590389120, '::1', '47420'),
(20, 1590389136, '::1', '36305'),
(21, 1590389556, '::1', '44074'),
(22, 1590389565, '::1', '52785'),
(23, 1590389568, '::1', '53897'),
(24, 1590389589, '::1', '39423'),
(25, 1590664494, '::1', '61406'),
(26, 1590664522, '::1', '77434'),
(27, 1590664748, '::1', '72345'),
(28, 1590664769, '::1', '94785'),
(29, 1590748573, '::1', '35547'),
(30, 1590748582, '::1', '13317'),
(31, 1590748582, '::1', '56449'),
(32, 1590748583, '::1', '19776'),
(33, 1590748584, '::1', '99161'),
(34, 1590748588, '::1', '11404'),
(35, 1590748593, '::1', '53166'),
(36, 1590748600, '::1', '61345'),
(37, 1591007423, '192.168.1.3', '24712'),
(38, 1591446857, '::1', '12154'),
(39, 1591446862, '::1', '40124'),
(40, 1591446864, '::1', '43702'),
(41, 1591446866, '::1', '38885'),
(42, 1591446870, '::1', '47200'),
(43, 1591785888, '::1', '34607');

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

CREATE TABLE `category_table` (
  `category_id` int(11) NOT NULL,
  `category_parent_id` int(11) NOT NULL,
  `category_title` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `category_image` varchar(100) NOT NULL,
  `category_icon` varchar(50) NOT NULL DEFAULT 'fab fa-android',
  `category_color` varchar(20) NOT NULL DEFAULT '#FF0000',
  `category_role_id` tinyint(4) NOT NULL,
  `category_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active',
  `category_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Category Table';

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_parent_id`, `category_title`, `category_slug`, `category_image`, `category_icon`, `category_color`, `category_role_id`, `category_status`, `category_order`) VALUES
(1, 0, 'Video & Movie', 'video-movie', '3eed636dc0d0c6917c122e466221e4dc.png', 'fab fa-android', '#FF0000', 0, 1, 1),
(2, 0, 'Music & Audio', 'music-audio', '1d022a8456930325d76378ed57546cb8.png', 'fab fa-android', '#FF0000', 0, 1, 2),
(3, 0, 'HTML5 Game', 'html5-game', '289a4ec1e630dbb5a5b803b1faf21b4f.png', 'fab fa-android', '#FF0000', 0, 1, 3),
(4, 0, 'Text & Article', 'text-article', '0d25cdd8a627ab6a1b50deca770a2e38.png', 'fab fa-android', '#FF0000', 0, 1, 4),
(5, 0, 'PDF Reader', 'pdf-reader', '2bd9524c5019092018d866cf1a3aa7c9.png', 'fab fa-android', '#FF0000', 0, 1, 5),
(6, 0, 'News', 'news', 'e067d88100271d7c3fa16dc87ff564a8.png', 'fab fa-android', '#FF0000', 0, 1, 6),
(7, 0, 'Product', 'product', 'd93e1febde16cc0fabc6ff8099e5a6fa.png', 'fab fa-android', '#FF0000', 0, 1, 7),
(8, 0, 'Buy & Sell', 'buy-sell', '636ab98976d4c22133d34128e32960e6.png', 'fab fa-android', '#FF0000', 0, 1, 8),
(9, 0, 'City Guide', 'city-guide', '5f6c559a9d1093773459881b106dcc2c.png', 'fab fa-android', '#FF0000', 0, 1, 9),
(10, 0, 'Download', 'download', 'c011552a9334cd8a5f2095b2801ee876.png', 'fab fa-android', '#FF0000', 0, 1, 10),
(11, 0, 'Hyperlink', 'hyperlink', '74fc2cdfc1dba644b6d1321b095a732a.png', 'fab fa-android', '#FF0000', 0, 1, 11),
(12, 0, 'Categories', 'categories', 'd500f83efb83338101ab0fbcac467a1c.png', 'fab fa-android', '#FF0000', 0, 1, 12),
(20, 3, 'Action', 'action', '2d6e4b200b96b4941f60ad3a762fcc01.png', 'fab fa-android', '#FF0000', 0, 1, 1),
(21, 3, 'Adventure', 'adventure', 'd58919db41a8dd9c578a0fa2ae7a55fd.png', 'fab fa-android', '#FF0000', 0, 1, 2),
(22, 3, 'Casual', 'casual', 'b9600dec52362eb58417e96845e1ac5b.png', 'fab fa-android', '#FF0000', 0, 1, 3),
(23, 3, 'Educational', 'educational', '0e27b3614cb8b50fb5383ec3d4277bec.png', 'fab fa-android', '#FF0000', 0, 1, 4),
(24, 3, 'Family', 'family', '8254234468c251f2d74b562a361753f9.png', 'fab fa-android', '#FF0000', 0, 1, 5),
(25, 3, 'Puzzle', 'puzzle', '44b8779a26f35e16443f5e8582d6a3b8.png', 'fab fa-android', '#FF0000', 0, 1, 6),
(26, 3, 'Racing', 'racing', '16a7653da0c35502cbcde1d5c322e33f.png', 'fab fa-android', '#FF0000', 0, 1, 7),
(27, 3, 'Role Playing', 'role-playing', 'a0938dfd65351c0ca083ec62e67fa941.png', 'fab fa-android', '#FF0000', 0, 1, 8),
(28, 3, 'Simulation', 'simulation', 'b620c8737653a7f4af867fad92ccbefb.png', 'fab fa-android', '#FF0000', 0, 1, 9),
(29, 3, 'Sport', 'sport', '63efff7f4ce86edf3a6d6c0ae8721042.png', 'fab fa-android', '#FF0000', 0, 1, 10),
(30, 3, 'Strategy', 'strategy', '69579003fba91c5bda3439ec021ad694.png', 'fab fa-android', '#FF0000', 0, 1, 11),
(31, 3, 'Words', 'words', '7e00cc9e750c00f9723723febb97e9b2.png', 'fab fa-android', '#FF0000', 0, 1, 12),
(32, 1, 'YouTube', 'youtube', '789f97b339ddae18600d62f3906d831f.png', 'fab fa-android', '#FF0000', 0, 1, 1),
(33, 1, 'Vimeo', 'vimeo', '9d7dca95eed517eee6afdf9a47c447bf.png', 'fab fa-android', '#FF0000', 0, 1, 2),
(34, 1, 'HD Movei', 'hd-movei', '040b56158431a86d8ce1f785da59f6da.png', 'fab fa-android', '#FF0000', 0, 1, 3),
(35, 1, 'Television', 'television', 'b7a66492ef36117aff6baa12014789fe.png', 'fab fa-android', '#FF0000', 0, 1, 4),
(36, 1, 'Streaming', 'streaming', '80b8a5555c089a789830a02f11726143.png', 'fab fa-android', '#FF0000', 0, 1, 5),
(37, 1, 'Series', 'series', '0a3f2b541e0794bf5bb531f28c5af794.png', 'fab fa-android', '#FF0000', 0, 1, 6),
(38, 34, 'Action Movie', 'action-movie', '92d1ef5fd41570f8ad4b17484ee15fe7.png', 'fab fa-android', '#FF0000', 0, 1, 1),
(39, 34, 'Comedy Movie', 'comedy-movie', '0d4ea6b0551cf581df66566fdeccec1f.png', 'fab fa-android', '#FF0000', 0, 1, 2),
(40, 34, 'Animation Movie', 'animation-movie', 'f10a82a8676b27377a189314b9d6de6c.png', 'fab fa-android', '#FF0000', 0, 1, 3),
(41, 34, 'Horror Movie', 'horror-movie', '6ff587315218a379f75776892f87ff69.png', 'fab fa-android', '#FF0000', 0, 1, 4),
(42, 34, 'Funny Movie', 'funny-movie', 'fb67e3b498b48e25579a768d1cdf68ad.png', 'fab fa-android', '#FF0000', 0, 1, 5),
(43, 12, 'Level two category', 'level-two-category', '34974536899140be29563b247aa19c37.png', 'fab fa-android', '#FF0000', 0, 1, 1),
(44, 43, 'Level three category', 'level-three-category', '4812f947f0e51b0a878dd41163341438.png', 'fab fa-android', '#FF0000', 0, 1, 1),
(45, 44, 'Level four category', 'level-four-category', 'a8055ed4afb4c3e1bf80349d111c4c74.png', 'fab fa-android', '#FF0000', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment_table`
--

CREATE TABLE `comment_table` (
  `comment_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL,
  `comment_device_type_id` int(11) NOT NULL,
  `comment_content_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_rate` float NOT NULL COMMENT '1 ~ 5 star',
  `comment_user_ip` varchar(80) NOT NULL,
  `comment_user_agent` varchar(255) NOT NULL,
  `comment_time` varchar(20) NOT NULL,
  `comment_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment_status` int(11) NOT NULL DEFAULT 0 COMMENT '0: Not Approved | 1: Approved | 2: Removed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Comment Table';

-- --------------------------------------------------------

--
-- Table structure for table `content_table`
--

CREATE TABLE `content_table` (
  `content_id` int(11) NOT NULL,
  `content_user_id` int(11) NOT NULL,
  `content_title` varchar(255) NOT NULL,
  `content_slug` varchar(255) NOT NULL,
  `content_description` longtext NOT NULL,
  `content_phone` varchar(15) DEFAULT NULL,
  `content_email` varchar(100) DEFAULT NULL,
  `content_latitude` varchar(30) DEFAULT '0',
  `content_longitude` varchar(30) DEFAULT '0',
  `content_property1` varchar(100) NOT NULL COMMENT 'Custom Property',
  `content_property2` varchar(100) NOT NULL,
  `content_orientation` tinyint(1) NOT NULL COMMENT '1: It does not matter | 2: portrait | 3: landscape',
  `content_price` float NOT NULL,
  `content_type_id` tinyint(4) NOT NULL,
  `content_player_type_id` tinyint(4) NOT NULL DEFAULT 1,
  `content_access` tinyint(1) NOT NULL COMMENT '1: Indirect Access | 2: Direct Access',
  `content_category_id` smallint(6) NOT NULL,
  `content_user_role_id` tinyint(4) NOT NULL,
  `content_image` varchar(100) DEFAULT NULL,
  `content_url` varchar(200) NOT NULL,
  `content_open_url_inside_app` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1: Inside App | 0: Outside App',
  `content_duration` varchar(15) DEFAULT NULL,
  `content_viewed` int(11) NOT NULL,
  `content_liked` int(11) NOT NULL,
  `content_featured` tinyint(1) NOT NULL COMMENT '0: Not Featured | 1: Featured',
  `content_special` tinyint(1) NOT NULL COMMENT '0: Not Special | 1: Special',
  `content_cached` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_rating_average` float NOT NULL DEFAULT 0,
  `content_rating_count` int(11) NOT NULL DEFAULT 0,
  `content_publish_date` varchar(20) NOT NULL,
  `content_publish_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `content_expired_date` varchar(20) NOT NULL,
  `content_order` int(11) NOT NULL DEFAULT 1,
  `content_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active | 2: Expired'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Item Tables';

--
-- Dumping data for table `content_table`
--

INSERT INTO `content_table` (`content_id`, `content_user_id`, `content_title`, `content_slug`, `content_description`, `content_phone`, `content_email`, `content_latitude`, `content_longitude`, `content_property1`, `content_property2`, `content_orientation`, `content_price`, `content_type_id`, `content_player_type_id`, `content_access`, `content_category_id`, `content_user_role_id`, `content_image`, `content_url`, `content_open_url_inside_app`, `content_duration`, `content_viewed`, `content_liked`, `content_featured`, `content_special`, `content_cached`, `content_rating_average`, `content_rating_count`, `content_publish_date`, `content_publish_timestamp`, `content_expired_date`, `content_order`, `content_status`) VALUES
(1, 1, 'Rugby Kicks', 'rugby-kicks', '<p>This is a <strong>HTML5 Game</strong> for demo. This game load from: www.codethislab.com</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '', '', '', '', 'p1', 'p2', 2, 0, 13, 1, 1, 29, 5, 'af2ed23b19a6a6cd3ef5e76618abe8de.jpg', 'https://showcase.codethislab.com/games/rugby_kicks/', 0, '', 17, 0, 1, 0, 1, 0, 0, '1583215490', '2020-03-03 06:04:50', '2371615490', 1, 1),
(2, 1, 'Slalom Ski', 'slalom-ski', '<p>This is a <strong>HTML5 Game</strong> for demo. This game load from: www.codethislab.com</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '', '', '', '', 'p1', 'p2', 3, 0, 13, 1, 1, 29, 5, '0e0e4d337f148bdba983fab39faf98e1.jpg', 'https://showcase.codethislab.com/games/slalom_ski/', 0, '', 31, 0, 0, 0, 1, 0, 0, '1583219516', '2020-03-03 07:11:56', '2371619516', 1, 1),
(3, 1, 'Dead City', 'dead-city', '<p>This is a <strong>HTML5 Game</strong> for demo. This game load from: www.codethislab.com</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '', '', '', '', 'p1', 'p2', 3, 0, 13, 1, 1, 21, 5, '4f260500b158d5d897afcc2f08ad0547.jpg', 'https://showcase.codethislab.com/games/dead_city/', 0, '', 14, 0, 1, 0, 1, 0, 0, '1583221725', '2020-03-03 07:48:45', '2371621725', 1, 1),
(4, 1, 'Rock Paper Scissor', 'rock-paper-scissor', '<p>This is a <strong>HTML5 Game</strong> for demo. This game load from: www.codethislab.com</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '', '', '', '', 'p1', 'p2', 3, 0, 13, 1, 1, 22, 6, '5e1bf00ece65149241be2034879c27b0.jpg', 'https://showcase.codethislab.com/games/rock_paper_scissor/', 0, '', 2, 0, 1, 0, 1, 0, 0, '1583221782', '2020-03-03 07:49:42', '2371621782', 1, 1),
(5, 1, 'Nothing Else Matters', 'nothing-else-matters', '<p>Nothing Else Matters\" by Metallica. Instrumental cover arranged and performed on violin and electric guitar by Golden Salt duo.</p>\r\n<p>Nothing Else Matters\" by Metallica. Instrumental cover arranged and performed on violin and electric guitar by Golden Salt duo.</p>', '', '', '', '', 'p1', 'p2', 1, 0, 11, 4, 1, 32, 5, '659d7035ef04698f3db51172a845436f.jpg', 'sjLyRTwaEp4', 0, '04:19', 13, 0, 1, 0, 1, 0, 0, '1583221893', '2020-03-03 07:51:33', '2371621893', 1, 1),
(6, 1, 'Vimeo Test', 'vimeo-test', '<p>This is a Vimeo embeded player. This is a Vimeo embeded player. This is a Vimeo embeded player. This is a Vimeo embeded player. This is a Vimeo embeded player.</p>', '', '', '', '', 'p1', 'p2', 1, 0, 11, 6, 1, 33, 5, 'c3869019221b485c01f3fd822a41aee4.jpg', '253989945', 0, '00:05', 14, 0, 1, 0, 1, 0, 0, '1583222051', '2020-03-03 07:54:11', '2371622051', 1, 1),
(7, 1, 'Fast and Furious', 'fast-and-furious', '<p><span class=\"st\"><em>Fast</em> & <em>Furious</em> (occasionally referred to as The <em>Fast</em> and the <em>Furious</em>) is an American media franchise centered on a series of action films that is largely concerned with illegal street racing, heists and spies.</span></p>', '', '', '', '', 'p1', 'p2', 1, 0, 11, 1, 1, 38, 5, '00035a31ac3bd6372621092f9f090716.jpg', 'http://content.inw24.com/shaw.mp4', 0, '05:40', 65, 0, 1, 0, 1, 5, 1, '1583222276', '2020-03-03 07:57:56', '2371622276', 1, 1),
(8, 1, 'Streaming m3u8', 'streaming-m3u8', '<p>This is a streaming format (m3u8) for test.</p>', '', '', '', '', 'p1', 'p2', 1, 0, 11, 7, 1, 36, 5, '986377803d5fee4f080ed564751a9159.jpg', 'http://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8', 0, '14:48', 11, 0, 0, 0, 1, 0, 0, '1583222437', '2020-03-03 08:00:37', '2371622437', 1, 1),
(9, 1, 'RT Channel TV', 'rt-channel-tv', '<p>RT Channel TV Streaming. This is live TV.</p>', '', '', '', '', 'p1', 'p2', 1, 0, 1, 7, 1, 11, 5, '72cf8bb6b3fa0c71f41489179065976d.png', 'https://rt-usa.secure.footprint.net/1105.m3u8?fluxustv.m3u8', 0, '00:00', 8, 0, 1, 0, 1, 0, 0, '1583222607', '2020-03-03 08:03:27', '2371622607', 1, 1),
(10, 1, 'Xiaomi Note 8', 'xiaomi-note-8', '<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '0018181234567', 'test@gmail.com', '39.058158', '-94.629090', 'p1', 'p2', 1, 1200, 17, 1, 1, 7, 5, '8b957a05b6dab6d049d3f2d548e37607.png', '', 0, '', 32, 0, 0, 1, 1, 0, 0, '1583243233', '2020-03-03 13:47:13', '2371643233', 1, 1),
(11, 1, 'Apartment 150', 'apartment-150', '<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '0018181234567', 'test@gmail.com', '39.058158', '-94.629090', 'p1', 'p2', 1, 850000, 17, 1, 1, 7, 5, '3866781ea677b2ccbf2f269979b5cc6a.jpg', '', 0, '', 19, 0, 0, 0, 1, 4, 1, '1583303727', '2020-03-04 06:35:27', '2371703727', 1, 1),
(12, 1, 'BMW M2 CS 2020', 'bmw-m2-cs-2020', '<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '0018181234567', 'test@gmail.com', '39.058158', '-94.629090', 'p1', 'p2', 1, 35000, 17, 1, 1, 7, 5, '37e95b917cc2dda3115e9d3132a96027.jpg', '', 0, '', 52, 0, 0, 0, 1, 5, 1, '1583304451', '2020-03-04 06:47:31', '2371704451', 1, 1),
(13, 1, 'The Weeknd Heartless', 'the-weeknd-heartless', '<p>Trying to find the one that can fix me<br>I’ve been dodging death in the six-speed<br>Amphetamine got my stomach feeling sickly<br>Yeah, I want it all now<br>I’ve been running through the pussy, need a dog pound<br>Hundred models getting faded in the compound<br>Trying to love me but they never get a pulse down<br><br>‘Cause I’m heartless<br>And I’m back to my ways ’cause I’m heartless<br>All this money and this pain got me heartless<br>Low life for life ’cause I’m heartless<br>Said I’m heartless<br>Trying to be a better man but I’m heartless<br>Never be a wedding plan for the heartless<br>Low life for life ’cause I’m heartless<br><br>Said I’m heartless<br>So much pussy, it be falling out the pocket<br>Metro Boomin, turn this hoe into a mosh pit<br>Tesla pill got me flying like a cockpit<br>Yeah, I got her watching<br>Call me up, turn that pussy to a faucet<br>Duffel bags full of drugs and a rocket<br>Stix drunk but he never miss a target<br>Photoshoots, I’m a star now<br>I’m talkin’ Time, Rolling Stone and Bazaar now<br>Selling dreams to these girls with their guard down<br>Seven years I’ve been swimming with the sharks now<br><br>‘Cause I’m heartless<br>And I’m back to my ways cause I’m heartless<br>All this money and this pain got me heartless<br>Low life for life ’cause I’m heartless<br>Said I’m heartless<br>Tryna be a better man but I’m heartless<br>Never be a wedding plan for the heartless<br>Low life for life ’cause I’m heartless<br><br>I lost my heart and my mind<br>I tried to always do right<br>I thought I lost you this time<br>You just came back in my life<br>You never gave up on me<br>I’ll never know what you see<br>I don’t do well when alone<br>You hear it clearly in my tone<br><br>‘Cause I’m heartless<br>And I’m back to my ways cause I’m heartless<br>All this money and this pain got me heartless<br>Low life for life ’cause I’m heartless<br>Said I’m heartless<br>Tryna be a better man but I’m heartless<br>Never be a wedding plan for the heartless<br>Low life for life ’cause I’m heartless</p>', '', '', '', '', 'p1', 'p2', 1, 0, 12, 1, 1, 2, 5, '6078908bca02049982ed9f6bda5a9425.jpg', 'http://srv1.mihn.xyz/s7/archive/foreign/t/The Weeknd/music/128/The Weeknd - Heartless [128].mp3', 0, '03:51', 43, 0, 1, 1, 1, 0, 0, '1583308393', '2020-03-04 07:53:13', '2371708393', 1, 1),
(14, 1, 'Office Guy', 'office-guy', '<p>This is a <strong>HTML5 Game</strong> for demo.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '', '', '', '', 'p1', 'p2', 3, 0, 13, 1, 1, 20, 5, '28e04f560aa606d556348702936e38fe.jpg', 'http://gamestation.inw24.com/games/Office_Guy/Main/HTML5/index.html', 0, '', 18, 0, 0, 0, 1, 0, 0, '1590642254', '2020-05-28 05:04:14', '2379042254', 1, 1),
(15, 1, 'Sample text content', 'sample-text-content', '<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '', '', '', '', 'p1', 'p2', 1, 0, 14, 1, 1, 4, 5, 'content.png', '', 0, '', 7, 0, 0, 0, 1, 0, 0, '1590642372', '2020-05-28 05:06:12', '2379042372', 1, 1),
(16, 1, 'Coronavirus pandemic', 'coronavirus-pandemic', '<p>Coronavirus is continuing its spread across the world, with more than 5.6 million confirmed cases in 188 countries. More than 350,000 people have lost their lives.<br>This series of maps and charts tracks the global outbreak of the virus since it emerged in China in December last year.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '', '', '', '', 'p1', 'p2', 1, 0, 16, 1, 1, 6, 5, '8c3d2674e00be6d2a5b1c3f664af5c78.jpg', '', 0, '', 42, 0, 0, 0, 1, 0, 0, '1590642592', '2020-05-28 05:09:52', '2379042592', 1, 1),
(17, 1, 'China great wall', 'china-great-wall', '<p>The Great Wall of China (Chinese: 萬里長城; pinyin: Wànlǐ Chángchéng) is the collective name of a series of fortification systems generally built across the historical northern borders of China to protect and consolidate territories of Chinese states and empires against various nomadic groups of the steppe and their polities. Several walls were being built from as early as the 7th century BC by ancient Chinese states;[2] selective stretches were later joined together by Qin Shi Huang (220–206 BC), the first emperor of China. Little of the Qin wall remains.[3] Later on, many successive dynasties have built and maintained multiple stretches of border walls. The most well-known sections of the wall were built by the Ming dynasty (1368–1644).<br><br>Apart from defense, other purposes of the Great Wall have included border controls, allowing the imposition of duties on goods transported along the Silk Road, regulation or encouragement of trade and the control of immigration and emigration. Furthermore, the defensive characteristics of the Great Wall were enhanced by the construction of watch towers, troop barracks, garrison stations, signaling capabilities through the means of smoke or fire, and the fact that the path of the Great Wall also served as a transportation corridor.<br><br>The frontier walls built by different dynasties have multiple courses. Collectively, they stretch from Liaodong in the east to Lop Lake in the west, from the present-day Sino–Russian border in the north to Taohe River in the south; along an arc that roughly delineates the edge of Mongolian steppe. A comprehensive archaeological survey, using advanced technologies, has concluded that the walls built by the Ming dynasty measure 8,850 km (5,500 mi).[4] This is made up of 6,259 km (3,889 mi) sections of actual wall, 359 km (223 mi) of trenches and 2,232 km (1,387 mi) of natural defensive barriers such as hills and rivers.[4] Another archaeological survey found that the entire wall with all of its branches measures out to be 21,196 km (13,171 mi).[5] Today, the defensive system of the Great Wall is generally recognized as one of the most impressive architectural feats in history.[6]</p>', '0018181234567', 'test@gmail.com', '40.4319', '116.5704', 'p1', 'p2', 1, 0, 19, 1, 1, 9, 5, '5f25f66fd02bdddb8d07a5a3859b8635.png', '', 0, '', 14, 0, 0, 1, 1, 5, 1, '1590642797', '2020-05-28 05:13:17', '2379042797', 1, 1),
(18, 1, 'Download file', 'download-file', '<p>Write Something...</p>', '', '', '', '', 'p1', 'p2', 1, 0, 20, 1, 1, 10, 5, 'c96030a8493bfc11ea6b3f3cea679e54.png', 'http://MultiPurpose.inw24.com/dl/app.apk', 0, '', 24, 0, 0, 0, 1, 0, 0, '1590642929', '2020-05-28 05:15:29', '2379042929', 1, 1),
(19, 1, 'Open URL outside', 'open-url-outside', '<p>Outside URL</p>', '', '', '', '', 'p1', 'p2', 1, 0, 21, 1, 1, 11, 5, '624028bc4b73d0281a08a879e3a4c71d.png', 'https://www.ViaCoders.com', 0, '', 15, 0, 0, 0, 1, 0, 0, '1590643165', '2020-05-28 05:19:25', '2379043165', 1, 1),
(20, 1, 'Open URL inside', 'open-url-inside', '<p>Inside URL</p>', '', '', '', '', 'p1', 'p2', 1, 0, 21, 1, 1, 11, 5, 'cf39c24a51e3980732d8df45ba41adbb.png', 'https://www.ViaCoders.com', 1, '', 21, 0, 0, 0, 1, 0, 0, '1590643390', '2020-05-28 05:23:10', '2379043390', 1, 1),
(21, 1, 'Simple PDF format', 'simple-pdf-format', '<p>Write Something...</p>', '', '', '', '', 'p1', 'p2', 1, 0, 15, 1, 1, 5, 5, '3f5448a8dc45760ada8321da60dec7f6.jpg', 'http://www.africau.edu/images/default/sample.pdf', 0, '', 30, 0, 0, 0, 1, 5, 1, '1590643966', '2020-05-28 05:32:46', '2379043966', 1, 1),
(22, 1, 'Unlimited Category', 'unlimited-category', '<p>1. Main Category</p>\r\n<p>     2. Level Tow Category</p>\r\n<p>          3. Level Three Category</p>\r\n<p>               4. Level Four Category</p>\r\n<p> </p>', '', '', '', '', 'p1', 'p2', 1, 0, 14, 1, 1, 45, 5, 'e1ba615c3d45214a43691ae341300a34.png', '', 0, '', 20, 0, 0, 1, 1, 5, 1, '1590679215', '2020-05-28 15:20:15', '2379079215', 1, 1),
(23, 1, 'Watercraft Rush', 'watercraft-rush', '<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>\r\n<p>This is a <strong>HTML5 Game</strong> for demo. This game load from: <em>www.codethislab.com</em></p>', '', '', '', '', 'p1', 'p2', 3, 0, 13, 1, 1, 29, 5, '7acc35cbb991143e6391ddea4a8d7bf4.jpg', 'http://showcase.codethislab.com/games/watercraft_rush/', 0, '', 8, 0, 0, 0, 1, 5, 1, '1590729438', '2020-05-29 05:17:18', '2379129438', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `content_type_table`
--

CREATE TABLE `content_type_table` (
  `content_type_id` int(11) NOT NULL,
  `content_type_title` varchar(40) NOT NULL,
  `content_type_description` varchar(60) NOT NULL,
  `content_type_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Type Table';

--
-- Dumping data for table `content_type_table`
--

INSERT INTO `content_type_table` (`content_type_id`, `content_type_title`, `content_type_description`, `content_type_status`) VALUES
(11, 'Video & Movie', 'For playing video, movie, TV channel, streaming', 1),
(12, 'Music & Audio', 'For playing music and audio', 1),
(13, 'HTML5 Game', 'For HTML5 games', 1),
(14, 'Text & Article', 'For text, article', 1),
(15, 'PDF Reader', 'For reading PDF', 1),
(16, 'News', 'For news', 1),
(17, 'Product', 'For product, catalog', 1),
(18, 'Buy & Sell', 'For ads, classify', 1),
(19, 'City Guide', 'For address and location', 1),
(20, 'Download', 'For direct download', 1),
(21, 'Hyperlink', 'For opening a URL inside app or phone\'s browser', 1),
(22, 'Images Gallery', 'For showing images gallery', 0);

-- --------------------------------------------------------

--
-- Table structure for table `currency_table`
--

CREATE TABLE `currency_table` (
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(5) NOT NULL COMMENT 'eg. IRR, USD, GBP, etc...',
  `currency_prefix` varchar(15) NOT NULL,
  `currency_suffix` varchar(15) NOT NULL,
  `currency_decimals` tinyint(1) NOT NULL,
  `currency_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Currency Table';

--
-- Dumping data for table `currency_table`
--

INSERT INTO `currency_table` (`currency_id`, `currency_code`, `currency_prefix`, `currency_suffix`, `currency_decimals`, `currency_rate`) VALUES
(1, 'USD', '', '$', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_type_table`
--

CREATE TABLE `device_type_table` (
  `device_type_id` int(11) NOT NULL,
  `device_type_title` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Device Type Table';

--
-- Dumping data for table `device_type_table`
--

INSERT INTO `device_type_table` (`device_type_id`, `device_type_title`) VALUES
(1, 'Website'),
(2, 'Android'),
(3, 'iOS'),
(4, 'AdminPanel');

-- --------------------------------------------------------

--
-- Table structure for table `email_setting_table`
--

CREATE TABLE `email_setting_table` (
  `email_setting_id` tinyint(4) NOT NULL,
  `email_setting_mailtype` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_smtpport` smallint(6) NOT NULL,
  `email_setting_smtphost` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_smtpuser` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_smtppass` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_crypto` varchar(5) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_fromname` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_fromemail` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_cc` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_signature` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='Email Setting Table';

--
-- Dumping data for table `email_setting_table`
--

INSERT INTO `email_setting_table` (`email_setting_id`, `email_setting_mailtype`, `email_setting_smtpport`, `email_setting_smtphost`, `email_setting_smtpuser`, `email_setting_smtppass`, `email_setting_crypto`, `email_setting_fromname`, `email_setting_fromemail`, `email_setting_cc`, `email_setting_signature`, `email_setting_status`) VALUES
(1, 'mail', 0, '', '', '', 'none', 'Multi Purpose', 'No-Reply@MultiContent.inw24.com', '', 'Best Purpose,<br>\r\nMultiPurpose.inw24.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `images_gallery_table`
--

CREATE TABLE `images_gallery_table` (
  `images_gallery_id` int(11) NOT NULL,
  `images_gallery_content_id` int(11) NOT NULL,
  `images_gallery_image` varchar(100) NOT NULL,
  `images_gallery_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Images Gallery Table';

-- --------------------------------------------------------

--
-- Table structure for table `page_table`
--

CREATE TABLE `page_table` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(100) NOT NULL,
  `page_slug` varchar(100) NOT NULL,
  `page_type` tinyint(2) NOT NULL COMMENT '1:News | 2: Annunciation | 3: Page | 4: Version',
  `page_content` mediumtext NOT NULL,
  `page_image` varchar(60) DEFAULT NULL,
  `page_keyword` varchar(100) DEFAULT NULL,
  `page_publish_time` varchar(15) NOT NULL,
  `page_status` tinyint(4) NOT NULL COMMENT '0:Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Page Table';

--
-- Dumping data for table `page_table`
--

INSERT INTO `page_table` (`page_id`, `page_title`, `page_slug`, `page_type`, `page_content`, `page_image`, `page_keyword`, `page_publish_time`, `page_status`) VALUES
(1, 'Terms of Service', 'terms-of-service', 3, '<p>Terms of Service: You can edit this page from admin dashboard. some<strong> HTML5</strong> tags are supported here.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '', '', '1543481842', 1),
(2, 'Privacy Policy', 'privacy-policy', 3, '<p>Privacy Policy: You can edit this page from admin dashboard. some<strong> HTML5</strong> tags are supported here.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '', '', '1543481882', 1),
(3, 'GDPR Law', 'gdpr-law', 3, '<p>GDPR Law: You can edit this page from admin dashboard. some<strong> HTML5</strong> tags are supported here.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '', '', '1543481894', 1),
(4, 'About Us', 'about-us', 3, '<p>About Us: You can edit this page from admin dashboard. some<strong> HTML5</strong> tags are supported here.</p>\r\n<p>Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using, making it look like readable English.</p>', '', '', '1543481904', 1),
(5, 'Contact Us', 'contact-us', 3, '<p><strong>Website:</strong> <br><a href=\"http://www.inw24.com\">www.inw24.com</a></p>\r\n<p><strong>Email:</strong><br><a href=\"mailto:inw24.com@gmail.com\">inw24.com@gmail.com</a></p>\r\n<p><strong>Purchase This App:<br></strong><a href=\"https://codecanyon.net/user/inw24\">https://codecanyon.net/user/inw24</a></p>', '', '', '1543731556', 1),
(6, 'Reward Coin', 'reward-coin', 3, '<p>Do the following to reward coins and get more services with the coins you reward</p>\r\n<ol>\r\n<li>Watching Video:<br><strong>One coin</strong> per 1 hour.<br><br></li>\r\n<li>Listen to Music:<br><strong>One coin</strong> per 1 hour.<br><br></li>\r\n<li>...</li>\r\n</ol>', '', '', '1543731622', 1),
(7, 'Advertising', 'advertising', 3, '<p>Need digital advertising help? Contact us today for a consultation.<br> </p>\r\n<ul>\r\n<li>Email: <strong><a href=\"mailto:Ads@YourDomain.com\">Ads@YourDomain.com</a></strong></li>\r\n<li>Phone: <strong>0018180000000</strong></li>\r\n<li>WhatsApp:<strong> 123456789</strong></li>\r\n</ul>', '', '', '1566137566', 1),
(8, 'Reserved Page 1', 'reserved-page-1', 3, '<p>Reserved Page 1</p>', NULL, NULL, '1576145214', 0),
(9, 'Reserved Page 2', 'reserved-page-2', 3, '<p>Reserved Page 2</p>', NULL, NULL, '1576145252', 0),
(10, 'Version 1.0.0', 'version-100', 4, '<p><code class=\"html plain\">Version 1.0.0 - June 12th, 2020</code></p>\r\n<p><code class=\"html plain\">- Initial release.</code></p>', NULL, NULL, '1576145327', 1);

-- --------------------------------------------------------

--
-- Table structure for table `player_type_table`
--

CREATE TABLE `player_type_table` (
  `player_type_id` int(11) NOT NULL,
  `player_type_title` varchar(30) NOT NULL,
  `player_type_description` varchar(100) NOT NULL,
  `player_type_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Player Type Table';

--
-- Dumping data for table `player_type_table`
--

INSERT INTO `player_type_table` (`player_type_id`, `player_type_title`, `player_type_description`, `player_type_status`) VALUES
(1, 'ExoPlayer', 'Write full direct URL', 1),
(2, 'JzPlayer', 'Write full direct URL', 1),
(3, 'WebView Player', 'Write full direct URL', 1),
(4, 'YouTube Player', 'Only write Youtube Id. ex: MJLB4Qv38vM ', 1),
(5, 'YouTube Embed Player', 'Only write Youtube Id. ex: MJLB4Qv38vM ', 1),
(6, 'Vimeo Embed Player', 'Only write Vimeo Id. ex: 253989945', 1),
(7, 'HLS ExoPlayer', 'Write full direct HLS URL like m3u8', 1),
(8, 'Native Player', 'Write full direct URL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reward_coin_table`
--

CREATE TABLE `reward_coin_table` (
  `reward_coin_id` int(11) NOT NULL,
  `reward_coin_banner_ad_exp` int(11) NOT NULL COMMENT 'Expiration: 3600 = 1 Hour',
  `reward_coin_interstitial_ad_exp` int(11) NOT NULL COMMENT 'Expiration: 3600 = 1 Hour',
  `reward_coin_rewarded_ad_exp` int(11) NOT NULL COMMENT 'Expiration: 3600 = 1 Hour',
  `reward_coin_native_ad_exp` int(11) NOT NULL COMMENT 'Expiration: 3600 = 1 Hour',
  `reward_coin_play_game_exp` int(11) NOT NULL COMMENT ' Expiration: 3600 = 1 Hour ',
  `reward_coin_watching_video_exp` int(11) NOT NULL COMMENT 'Expiration: 3600 = 1 Hour ',
  `reward_coin_banner_ad_coin_req` int(11) NOT NULL COMMENT 'Account Update: Coin Requirement',
  `reward_coin_interstitial_ad_coin_req` int(11) NOT NULL COMMENT 'Account Update: Coin Requirement',
  `reward_coin_rewarded_ad_coin_req` int(11) NOT NULL COMMENT 'Account Update: Coin Requirement',
  `reward_coin_native_ad_coin_req` int(11) NOT NULL COMMENT 'Account Update: Coin Requirement',
  `reward_coin_vip_user_coin_req` int(11) NOT NULL COMMENT ' Account Update: Coin Requirement ',
  `reward_coin_banner_ad_click` int(11) NOT NULL COMMENT 'Each click, reward x coin',
  `reward_coin_interstitial_ad_click` int(11) NOT NULL COMMENT ' Each click, reward x coin ',
  `reward_coin_rewarded_ad_click` int(11) NOT NULL COMMENT ' Each click, reward x coin ',
  `reward_coin_native_ad_click` int(11) NOT NULL COMMENT ' Each click, reward x coin ',
  `reward_coin_write_review` int(11) NOT NULL COMMENT 'Write a review, reward x coin ',
  `reward_coin_play_game` int(11) NOT NULL COMMENT 'Play game, reward x coin',
  `reward_coin_watching_video` int(11) NOT NULL COMMENT 'Watch video, reward x coin',
  `reward_coin_referral_user` int(11) NOT NULL COMMENT 'Give referral ID to reward coin',
  `reward_coin_referral_friend` int(11) NOT NULL COMMENT 'Get referral ID to reward coin',
  `reward_coin_publish_game` int(100) NOT NULL COMMENT 'Publish a game to reward coin',
  `reward_coin_new_registeration` int(11) NOT NULL DEFAULT 10,
  `reward_coin_withdrawal_coin_minimum_req` int(11) NOT NULL DEFAULT 1000 COMMENT 'Minimum number of coins to withdraw from the account',
  `reward_coin_price_of_each_coin` float NOT NULL DEFAULT 0.01 COMMENT 'The price of each coin. For example 1000 coins * 0.01 = 10 USD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Reward Coin Table';

--
-- Dumping data for table `reward_coin_table`
--

INSERT INTO `reward_coin_table` (`reward_coin_id`, `reward_coin_banner_ad_exp`, `reward_coin_interstitial_ad_exp`, `reward_coin_rewarded_ad_exp`, `reward_coin_native_ad_exp`, `reward_coin_play_game_exp`, `reward_coin_watching_video_exp`, `reward_coin_banner_ad_coin_req`, `reward_coin_interstitial_ad_coin_req`, `reward_coin_rewarded_ad_coin_req`, `reward_coin_native_ad_coin_req`, `reward_coin_vip_user_coin_req`, `reward_coin_banner_ad_click`, `reward_coin_interstitial_ad_click`, `reward_coin_rewarded_ad_click`, `reward_coin_native_ad_click`, `reward_coin_write_review`, `reward_coin_play_game`, `reward_coin_watching_video`, `reward_coin_referral_user`, `reward_coin_referral_friend`, `reward_coin_publish_game`, `reward_coin_new_registeration`, `reward_coin_withdrawal_coin_minimum_req`, `reward_coin_price_of_each_coin`) VALUES
(1, 21600, 21600, 21600, 21600, 3600, 3600, 1000, 1000, 1000, 1000, 2000, 2, 2, 2, 2, 1, 1, 1, 10, 10, 50, 10, 1000, 0.01);

-- --------------------------------------------------------

--
-- Table structure for table `seo_table`
--

CREATE TABLE `seo_table` (
  `seo_id` int(11) NOT NULL,
  `seo_description` varchar(100) NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `seo_author` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='SEO Table';

--
-- Dumping data for table `seo_table`
--

INSERT INTO `seo_table` (`seo_id`, `seo_description`, `seo_keywords`, `seo_author`) VALUES
(1, 'Multi purpose app and website, You can publish any kind of content like video, music, news, text, pd', 'multi purpose, application, website, video, YouTube, Vimeo, streaming, article, news, product, catalog, buy sell, city guide, images, Firebase, OneSignal', 'ViaCoders.com');

-- --------------------------------------------------------

--
-- Table structure for table `setting_table`
--

CREATE TABLE `setting_table` (
  `setting_id` int(11) NOT NULL,
  `setting_app_name` varchar(50) NOT NULL,
  `setting_app_desc` varchar(100) NOT NULL,
  `setting_website` varchar(50) NOT NULL,
  `setting_email` varchar(50) NOT NULL,
  `setting_phone1` varchar(15) NOT NULL,
  `setting_phone2` varchar(15) NOT NULL,
  `setting_phone3` varchar(15) NOT NULL,
  `setting_sms_no` varchar(20) NOT NULL,
  `setting_address` varchar(100) NOT NULL,
  `setting_logo` varchar(80) NOT NULL,
  `setting_favicon` varchar(50) NOT NULL,
  `setting_version_code` smallint(6) NOT NULL,
  `setting_version_string` varchar(25) NOT NULL,
  `setting_skype` varchar(60) NOT NULL,
  `setting_telegram` varchar(60) NOT NULL,
  `setting_whatsapp` varchar(60) NOT NULL,
  `setting_instagram` varchar(60) NOT NULL,
  `setting_facebook` varchar(60) NOT NULL,
  `setting_twiiter` varchar(60) NOT NULL,
  `setting_custom1` varchar(60) NOT NULL,
  `setting_custom2` varchar(60) NOT NULL,
  `setting_one_signal_app_id` varchar(255) NOT NULL,
  `setting_one_signal_rest_api_key` varchar(255) NOT NULL,
  `setting_youtube_api_key` varchar(255) NOT NULL,
  `setting_text_maintenance` varchar(255) NOT NULL,
  `setting_site_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_android_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_ios_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_other_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_disable_registration` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_checking` int(11) NOT NULL,
  `setting_pc` tinyint(1) DEFAULT NULL,
  `setting_mobile_verification` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 0: No Need | Need To Verify ',
  `setting_email_verification` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 0: No Need | Need To Verify ',
  `setting_document_verification` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 0: No Need | Need To Verify '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Setting Table';

--
-- Dumping data for table `setting_table`
--

INSERT INTO `setting_table` (`setting_id`, `setting_app_name`, `setting_app_desc`, `setting_website`, `setting_email`, `setting_phone1`, `setting_phone2`, `setting_phone3`, `setting_sms_no`, `setting_address`, `setting_logo`, `setting_favicon`, `setting_version_code`, `setting_version_string`, `setting_skype`, `setting_telegram`, `setting_whatsapp`, `setting_instagram`, `setting_facebook`, `setting_twiiter`, `setting_custom1`, `setting_custom2`, `setting_one_signal_app_id`, `setting_one_signal_rest_api_key`, `setting_youtube_api_key`, `setting_text_maintenance`, `setting_site_maintenance`, `setting_android_maintenance`, `setting_ios_maintenance`, `setting_other_maintenance`, `setting_disable_registration`, `setting_checking`, `setting_pc`, `setting_mobile_verification`, `setting_email_verification`, `setting_document_verification`) VALUES
(1, 'Multi Purpose', 'Multi Purpose App + Website', 'http://MultiPurpose.inw24.com', 'inw24.com@gmail.com', '01234', '', '', '', '2354 Alanin street, Ollka blv, no.1542', '53611f1a730f535f022382610d88cd8f.png', '', 3, '1.2.0', 'Skype', '', 'WhatsApp', 'Instagram', '', 'Twiiter', '', '', 'CDlWZFdo', 'VWQGNAE.', 'xxx', 'We are under maintenance mode. Please try again later.', 0, 0, 1, 1, 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `slider_table`
--

CREATE TABLE `slider_table` (
  `slider_id` int(11) NOT NULL,
  `slider_category_id` smallint(6) NOT NULL,
  `slider_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `slider_slug` varchar(255) CHARACTER SET utf8 NOT NULL,
  `slider_description` varchar(255) CHARACTER SET utf8 NOT NULL,
  `slider_url` varchar(100) CHARACTER SET utf8 NOT NULL,
  `slider_image` varchar(120) CHARACTER SET utf8 NOT NULL,
  `slider_content_id` int(11) DEFAULT 0,
  `slider_content_type_id` int(11) NOT NULL DEFAULT 1,
  `slider_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='Slider Table';

--
-- Dumping data for table `slider_table`
--

INSERT INTO `slider_table` (`slider_id`, `slider_category_id`, `slider_title`, `slider_slug`, `slider_description`, `slider_url`, `slider_image`, `slider_content_id`, `slider_content_type_id`, `slider_status`) VALUES
(1, 0, 'BMW M2 CS 2020', 'test-product-map', 'BMW M2 CS 2020', '', '0a589317e053db75ac7f6e96cc57e6d0.jpg', 12, 17, 1),
(2, 0, 'PDF Reader', 'pdf-reader', 'PDF Reader', '', 'afda3413d06856d029b56543a047024f.png', 21, 15, 1),
(3, 0, 'Watercraft Rush', 'watercraft-rush', 'Watercraft Rush', '', '52e29ac36d82a86a264d2d5173f59128.jpg', 23, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `update_coin_table`
--

CREATE TABLE `update_coin_table` (
  `update_coin_id` bigint(20) NOT NULL,
  `update_coin_user_id` int(11) NOT NULL,
  `update_coin_type` varchar(35) NOT NULL,
  `update_coin_time` int(10) NOT NULL,
  `update_coin_user_ip` varchar(30) NOT NULL,
  `update_coin_user_agent` varchar(60) NOT NULL,
  `update_coin_status` tinyint(1) NOT NULL COMMENT '0: Expired | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Update Coin Table';

--
-- Dumping data for table `update_coin_table`
--

INSERT INTO `update_coin_table` (`update_coin_id`, `update_coin_user_id`, `update_coin_type`, `update_coin_time`, `update_coin_user_ip`, `update_coin_user_agent`, `update_coin_status`) VALUES
(10, 1, 'openURL', 1590728240, '192.168.1.3', 'Dalvik/2.1.0 (Linux; U; Android 10; Android SDK built for x8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_table`
--

CREATE TABLE `user_role_table` (
  `user_role_id` smallint(6) NOT NULL,
  `user_type_id` smallint(6) NOT NULL,
  `user_role_title` varchar(30) NOT NULL,
  `user_role_price` float NOT NULL,
  `user_role_permission` text NOT NULL COMMENT 'Seprrate laste segment with |',
  `user_role_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Active | 2: Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Role Table';

--
-- Dumping data for table `user_role_table`
--

INSERT INTO `user_role_table` (`user_role_id`, `user_type_id`, `user_role_title`, `user_role_price`, `user_role_permission`, `user_role_status`) VALUES
(1, 1, 'Super Admin', 0, 'No need to set permission for Super Admin.', 1),
(2, 1, 'Admin', 0, 'index users_list show_user add_user delete_user users_role delete_role general_settings email_settings sliders delete_slider edit_slider pages add_page delete_page edit_page users_activity categories edit_category delete_category content_list add_content edit_content delete_content push_notification admob_settings api_key withdrawal_coins show_withdrawal_coin', 1),
(3, 1, 'Employee', 0, 'index users_list show_user add_user delete_user users_role delete_role general_settings email_settings sliders delete_slider edit_slider pages add_page delete_page edit_page users_activity categories edit_category delete_category content_list add_content edit_content delete_content push_notification withdrawal_coins show_withdrawal_coin', 1),
(4, 1, 'Demo Admin', 0, 'index users_list show_user add_user delete_user users_role delete_role general_settings email_settings sliders delete_slider edit_slider pages add_page delete_page edit_page users_activity categories edit_category delete_category content_list add_content edit_content delete_content push_notification admob_settings api_key comments_list show_comment reward_settings withdrawal_coins show_withdrawal_coin', 2),
(5, 2, 'Regular', 0, 'index withdrawal_coins show_withdrawal_coin add_content content_list', 1),
(6, 2, 'VIP', 2000, 'index add_content content_list edit_content withdrawal_coins show_withdrawal_coin', 1),
(7, 2, 'Demo User', 0, 'index add_content content_list edit_content withdrawal_coins show_withdrawal_coin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_firstname` varchar(50) DEFAULT NULL,
  `user_lastname` varchar(50) DEFAULT NULL,
  `user_image` varchar(80) NOT NULL DEFAULT 'avatar.png',
  `user_credit` float DEFAULT 0,
  `user_coin` int(11) NOT NULL DEFAULT 0,
  `user_type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1: Staff | 2: User | 3: Guest',
  `user_role_id` smallint(6) NOT NULL DEFAULT 5,
  `user_duration` int(11) DEFAULT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_mobile` varchar(15) DEFAULT NULL,
  `user_phone` varchar(15) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: Deactive | 1: Active',
  `user_reg_date` varchar(12) NOT NULL,
  `user_last_login` varchar(12) DEFAULT NULL,
  `user_device_type_id` tinyint(2) NOT NULL,
  `user_note` text DEFAULT NULL,
  `user_referral` int(11) NOT NULL,
  `user_mobile_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No| 1: Yes',
  `user_mobile_verification_code` varchar(100) DEFAULT NULL,
  `user_email_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No| 1: Yes',
  `user_email_verification_code` varchar(100) DEFAULT NULL,
  `user_document_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No| 1: Yes',
  `user_online` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Offline | 1: Online',
  `user_onesignal_player_id` varchar(100) NOT NULL DEFAULT 'Not set yet.',
  `user_hide_banner_ad` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Disable | 1: Enable (Hide)',
  `user_hide_interstitial_ad` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Disable | 1: Enable (Hide)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Table';

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_username`, `user_firstname`, `user_lastname`, `user_image`, `user_credit`, `user_coin`, `user_type`, `user_role_id`, `user_duration`, `user_email`, `user_password`, `user_mobile`, `user_phone`, `user_status`, `user_reg_date`, `user_last_login`, `user_device_type_id`, `user_note`, `user_referral`, `user_mobile_verified`, `user_mobile_verification_code`, `user_email_verified`, `user_email_verification_code`, `user_document_verified`, `user_online`, `user_onesignal_player_id`, `user_hide_banner_ad`, `user_hide_interstitial_ad`) VALUES
(1, 'admin', 'Super', 'Admin', 'eb3719cb638e7859a4872772b13115fa.png', 0, 1, 1, 1, 0, 'inw24.com@gmail.com', 'd21933a6ee50e4dcaa8424f85582c3f51abf6379', '0124', '', 1, '1575811526', '', 4, 'Website: www.ViaCoders.com', 0, 1, '', 1, '', 1, 0, 'Not set yet.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type_table`
--

CREATE TABLE `user_type_table` (
  `user_type_id` smallint(6) NOT NULL COMMENT '1: Staff | 2: User | 3: Guest',
  `user_type_title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Type Table';

--
-- Dumping data for table `user_type_table`
--

INSERT INTO `user_type_table` (`user_type_id`, `user_type_title`) VALUES
(1, 'Staff'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_account_type_table`
--

CREATE TABLE `withdrawal_account_type_table` (
  `withdrawal_account_type_id` int(11) NOT NULL,
  `withdrawal_account_type_title` varchar(30) NOT NULL,
  `withdrawal_account_type_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Withdrawal Account Type Table';

--
-- Dumping data for table `withdrawal_account_type_table`
--

INSERT INTO `withdrawal_account_type_table` (`withdrawal_account_type_id`, `withdrawal_account_type_title`, `withdrawal_account_type_status`) VALUES
(1, 'PayPal', 1),
(2, 'WebMoney', 1),
(3, 'WesternUnion', 1),
(4, 'Bitcoin', 1),
(5, 'Offline Bank', 1),
(6, 'Gift Card', 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_table`
--

CREATE TABLE `withdrawal_table` (
  `withdrawal_id` int(11) NOT NULL,
  `withdrawal_user_id` int(11) NOT NULL,
  `withdrawal_account_type` varchar(60) NOT NULL COMMENT ' For example: PayPal| Bitcoin',
  `withdrawal_account_name` varchar(60) NOT NULL COMMENT 'For example: PayPal Email | Bitcoin Wallet Address',
  `withdrawal_req_coin` int(11) NOT NULL,
  `withdrawal_req_cash` float DEFAULT NULL,
  `withdrawal_req_date` varchar(12) NOT NULL,
  `withdrawal_date_paid` varchar(12) DEFAULT NULL,
  `withdrawal_transaction` varchar(60) DEFAULT NULL,
  `withdrawal_user_comment` varchar(255) DEFAULT NULL,
  `withdrawal_admin_comment` varchar(255) DEFAULT NULL,
  `withdrawal_status` tinyint(1) NOT NULL COMMENT '1: Pending | 2: Paid | 3. Cancel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Withdrawal Table';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_table`
--
ALTER TABLE `activity_table`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `admob_setting_table`
--
ALTER TABLE `admob_setting_table`
  ADD PRIMARY KEY (`admob_setting_id`);

--
-- Indexes for table `api_table`
--
ALTER TABLE `api_table`
  ADD PRIMARY KEY (`api_id`);

--
-- Indexes for table `bookmark_table`
--
ALTER TABLE `bookmark_table`
  ADD PRIMARY KEY (`bookmark_id`);

--
-- Indexes for table `captcha_table`
--
ALTER TABLE `captcha_table`
  ADD PRIMARY KEY (`captcha_id`),
  ADD KEY `captcha_word` (`captcha_word`);

--
-- Indexes for table `category_table`
--
ALTER TABLE `category_table`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comment_table`
--
ALTER TABLE `comment_table`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `content_table`
--
ALTER TABLE `content_table`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `content_type_table`
--
ALTER TABLE `content_type_table`
  ADD PRIMARY KEY (`content_type_id`);

--
-- Indexes for table `currency_table`
--
ALTER TABLE `currency_table`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `device_type_table`
--
ALTER TABLE `device_type_table`
  ADD PRIMARY KEY (`device_type_id`);

--
-- Indexes for table `email_setting_table`
--
ALTER TABLE `email_setting_table`
  ADD PRIMARY KEY (`email_setting_id`);

--
-- Indexes for table `images_gallery_table`
--
ALTER TABLE `images_gallery_table`
  ADD PRIMARY KEY (`images_gallery_id`);

--
-- Indexes for table `page_table`
--
ALTER TABLE `page_table`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `player_type_table`
--
ALTER TABLE `player_type_table`
  ADD PRIMARY KEY (`player_type_id`);

--
-- Indexes for table `reward_coin_table`
--
ALTER TABLE `reward_coin_table`
  ADD PRIMARY KEY (`reward_coin_id`);

--
-- Indexes for table `seo_table`
--
ALTER TABLE `seo_table`
  ADD PRIMARY KEY (`seo_id`);

--
-- Indexes for table `setting_table`
--
ALTER TABLE `setting_table`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `slider_table`
--
ALTER TABLE `slider_table`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `update_coin_table`
--
ALTER TABLE `update_coin_table`
  ADD PRIMARY KEY (`update_coin_id`);

--
-- Indexes for table `user_role_table`
--
ALTER TABLE `user_role_table`
  ADD PRIMARY KEY (`user_role_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_type_table`
--
ALTER TABLE `user_type_table`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `withdrawal_account_type_table`
--
ALTER TABLE `withdrawal_account_type_table`
  ADD PRIMARY KEY (`withdrawal_account_type_id`);

--
-- Indexes for table `withdrawal_table`
--
ALTER TABLE `withdrawal_table`
  ADD PRIMARY KEY (`withdrawal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_table`
--
ALTER TABLE `activity_table`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admob_setting_table`
--
ALTER TABLE `admob_setting_table`
  MODIFY `admob_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_table`
--
ALTER TABLE `api_table`
  MODIFY `api_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookmark_table`
--
ALTER TABLE `bookmark_table`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `captcha_table`
--
ALTER TABLE `captcha_table`
  MODIFY `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `category_table`
--
ALTER TABLE `category_table`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `comment_table`
--
ALTER TABLE `comment_table`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_table`
--
ALTER TABLE `content_table`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `content_type_table`
--
ALTER TABLE `content_type_table`
  MODIFY `content_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `currency_table`
--
ALTER TABLE `currency_table`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `device_type_table`
--
ALTER TABLE `device_type_table`
  MODIFY `device_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_setting_table`
--
ALTER TABLE `email_setting_table`
  MODIFY `email_setting_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images_gallery_table`
--
ALTER TABLE `images_gallery_table`
  MODIFY `images_gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_table`
--
ALTER TABLE `page_table`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `player_type_table`
--
ALTER TABLE `player_type_table`
  MODIFY `player_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reward_coin_table`
--
ALTER TABLE `reward_coin_table`
  MODIFY `reward_coin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seo_table`
--
ALTER TABLE `seo_table`
  MODIFY `seo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_table`
--
ALTER TABLE `setting_table`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider_table`
--
ALTER TABLE `slider_table`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `update_coin_table`
--
ALTER TABLE `update_coin_table`
  MODIFY `update_coin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_role_table`
--
ALTER TABLE `user_role_table`
  MODIFY `user_role_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_type_table`
--
ALTER TABLE `user_type_table`
  MODIFY `user_type_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '1: Staff | 2: User | 3: Guest', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdrawal_account_type_table`
--
ALTER TABLE `withdrawal_account_type_table`
  MODIFY `withdrawal_account_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `withdrawal_table`
--
ALTER TABLE `withdrawal_table`
  MODIFY `withdrawal_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

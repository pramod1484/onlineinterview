-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2014 at 06:24 PM
-- Server version: 5.5.37
-- PHP Version: 5.4.29-2+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crm_ee`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `savedName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_by_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_type` enum('email','history','template') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `attachment`
--

INSERT INTO `attachment` (`id`, `savedName`, `name`, `type`, `size`, `created_at`, `deleted`, `created_by_id`, `parent_id`, `parent_type`) VALUES
(1, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:37:57', 1, NULL, NULL, NULL),
(2, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:41:54', 0, NULL, NULL, NULL),
(3, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:45:15', 0, NULL, NULL, NULL),
(4, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:48:22', 1, NULL, NULL, NULL),
(5, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:49:41', 1, NULL, NULL, NULL),
(6, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:51:23', 1, NULL, NULL, NULL),
(7, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:51:35', 1, NULL, NULL, NULL),
(8, '', 'chart.png', 'image/png', 36658, '2014-07-03 14:52:11', 1, NULL, NULL, NULL),
(9, '', 'Certificate.pdf', 'application/pdf', 143781, '2014-07-03 14:52:30', 1, NULL, NULL, NULL),
(10, 'd3d9446802a44259755d38e6d163e820', 'chart.png', 'image/png', 36658, '2014-07-03 14:55:22', 0, 1, 3, 'template'),
(11, '', 'Certificate.pdf', 'application/pdf', 143781, '2014-07-03 14:55:54', 1, NULL, NULL, NULL),
(12, 'c20ad4d76fe97759aa27a0c99bff6710', 'Certificate.pdf', 'application/pdf', 143781, '2014-07-03 14:56:45', 0, 1, 209, 'history'),
(13, '', '1342811156.jpg', 'image/jpeg', 46480, '2014-07-04 12:25:39', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `call`
--

CREATE TABLE IF NOT EXISTS `call` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('Planned','Held','Not Held') COLLATE utf8_unicode_ci DEFAULT 'Planned',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT '3600',
  `direction` enum('Outbound','Inbound') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Outbound',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `assigned_user_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_type` enum('Opportunity') COLLATE utf8_unicode_ci DEFAULT 'Opportunity',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `call`
--

INSERT INTO `call` (`id`, `name`, `status`, `date_start`, `date_end`, `duration`, `direction`, `description`, `created_at`, `modified_at`, `deleted`, `assigned_user_id`, `modified_by_id`, `created_by_id`, `parent_id`, `parent_type`) VALUES
(1, 'Test Call', 'Held', '2014-06-25 06:00:00', '2014-06-25 06:05:00', 300, 'Inbound', 'Suspendisse nisl elit rhoncus', '2014-06-25 16:11:04', '2014-06-25 18:35:38', 1, 23, 1, 1, 4, 'Opportunity'),
(2, 'Praesent egestas neque eu', 'Planned', '2014-06-25 09:00:00', '2014-06-25 09:10:00', 600, 'Outbound', 'Curabitur ullamcorper ultricies nisi. Ut non enim eleifend felis pretium feugiat. Sed libero. Etiam sit amet orci eget eros faucibus tincidunt. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi.', '2014-06-25 16:17:16', '2014-06-25 16:17:16', 1, 23, 1, 1, 17, 'Opportunity'),
(3, 'Etiam iaculis nunc ac', 'Held', '2014-06-27 04:45:00', '2014-06-27 04:50:00', 300, 'Inbound', 'Vivamus aliquet elit ac nisl. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Pellentesque dapibus hendrerit tortor. Nunc egestas, augue at pellentesque laoreet, felis eros vehicula leo, at malesuada velit leo quis pede. Cras sagittis.', '2014-06-25 18:30:58', '2014-06-25 18:35:20', 1, 24, 1, 1, 18, 'Opportunity'),
(4, 'Test', 'Planned', '2014-06-27 04:45:00', '2014-06-27 04:50:00', 300, 'Outbound', 'Curabitur a felis in nunc fringilla tristique. Etiam feugiat lorem non metus. Morbi nec metus. Curabitur vestibulum aliquam leo. Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi.', '2014-06-27 18:45:55', '2014-06-27 18:45:55', 0, 1, 1, 1, 13, 'Opportunity');

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE IF NOT EXISTS `calls` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `duration` varchar(20) NOT NULL,
  PRIMARY KEY (`call_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `calls`
--

INSERT INTO `calls` (`call_id`, `user_id`, `lead_id`, `created_at`, `start_time`, `end_time`, `duration`) VALUES
(1, 1, 6, '2014-07-01', '2014-07-01 14:56:52', '0000-00-00 00:00:00', ''),
(2, 1, 6, '2014-07-01', '2014-07-01 14:56:57', '0000-00-00 00:00:00', ''),
(3, 1, 6, '2014-07-01', '2014-07-01 14:56:59', '0000-00-00 00:00:00', ''),
(4, 1, 6, '2014-07-01', '2014-07-01 15:03:11', '0000-00-00 00:00:00', ''),
(5, 23, 6, '2014-07-03', '2014-07-03 12:00:37', '0000-00-00 00:00:00', ''),
(6, 23, 6, '2014-07-03', '2014-07-03 12:01:08', '0000-00-00 00:00:00', ''),
(7, 23, 13, '2014-07-03', '2014-07-03 12:22:47', '0000-00-00 00:00:00', ''),
(8, 23, 13, '2014-07-03', '2014-07-03 12:23:17', '0000-00-00 00:00:00', ''),
(9, 23, 13, '2014-07-03', '2014-07-03 12:25:14', '0000-00-00 00:00:00', ''),
(10, 23, 13, '2014-07-03', '2014-07-03 12:25:23', '0000-00-00 00:00:00', ''),
(11, 23, 13, '2014-07-03', '2014-07-03 12:34:32', '0000-00-00 00:00:00', ''),
(12, 23, 13, '2014-07-03', '2014-07-03 12:37:01', '0000-00-00 00:00:00', ''),
(13, 23, 13, '2014-07-03', '2014-07-03 12:38:33', '0000-00-00 00:00:00', ''),
(14, 23, 13, '2014-07-03', '2014-07-03 12:38:54', '0000-00-00 00:00:00', ''),
(15, 23, 13, '2014-07-03', '2014-07-03 12:39:37', '0000-00-00 00:00:00', ''),
(16, 23, 13, '2014-07-03', '2014-07-03 12:47:24', '0000-00-00 00:00:00', ''),
(17, 1, 22, '2014-07-03', '2014-07-03 13:04:20', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `call_entity`
--

CREATE TABLE IF NOT EXISTS `call_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `callId` int(11) DEFAULT '0',
  `entityId` int(11) DEFAULT '0',
  `entityType` enum('Lead','Opportunity','User') COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `call_entity`
--

INSERT INTO `call_entity` (`id`, `callId`, `entityId`, `entityType`, `deleted`) VALUES
(3, 2, 23, 'User', 0),
(4, 2, 101, 'Lead', 0),
(15, 3, 23, 'User', 0),
(16, 3, 60, 'Lead', 0),
(17, 1, 24, 'User', 0),
(18, 1, 111, 'Lead', 0),
(19, 4, 33, 'User', 0),
(20, 4, 105, 'Lead', 0);

-- --------------------------------------------------------

--
-- Table structure for table `email_inbound`
--

CREATE TABLE IF NOT EXISTS `email_inbound` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` varchar(255) COLLATE utf8_unicode_ci DEFAULT '143',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monitored_folders` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'INBOX',
  `trash_folder` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'INBOX.Trash',
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `team_id` int(11) DEFAULT NULL,
  `assigned_user_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B3E13488296CD8AE` (`team_id`),
  KEY `IDX_B3E134886D716643` (`assigned_user_id`),
  KEY `IDX_B3E1348899049ECE` (`modified_by_id`),
  KEY `IDX_B3E13488B03A8386` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `email_inbound`
--

INSERT INTO `email_inbound` (`id`, `name`, `status`, `host`, `port`, `username`, `password`, `monitored_folders`, `trash_folder`, `created_at`, `modified_at`, `deleted`, `team_id`, `assigned_user_id`, `modified_by_id`, `created_by_id`) VALUES
(1, 'Test', 0, 'localhost', '143', 'root', 'root', 'INBOX', 'INBOX.Trash', '2014-06-27 15:48:22', '2014-06-27 18:35:54', 1, 4, 24, 1, 1),
(2, 'Inbound Test', 1, 'localhost', '143', 'root', 'root', 'INBOX', 'INBOX.Trash', '2014-06-27 16:30:50', '2014-06-27 16:30:50', 1, 0, 33, 1, 1),
(3, 'Test 2', 1, 'mail.easternenterprise.com', '143', 'v.awate@easternenterprise.com', 'test123', 'INBOX', 'INBOX.Trash', '2014-06-27 16:34:22', '2014-06-27 16:34:22', 1, 2, 37, 1, 1),
(4, 'Inbound Test', 1, 'localhost', '143', 'root', 'root', 'INBOX', 'INBOX.Trash', '2014-06-27 18:23:46', '2014-06-27 18:23:46', 1, 1, 33, 1, 1),
(5, 'Test', 0, 'localhost', '143', 'root', 'root', 'INBOX', 'INBOX.Trash', '2014-06-27 18:34:24', '2014-06-27 18:34:24', 1, 5, 24, 1, 1),
(6, 'Test2', 0, 'localhost', '143', 'root', 'root', 'INBOX', 'INBOX.Trash', '2014-06-27 18:34:48', '2014-06-27 18:34:48', 1, 5, 24, 1, 1),
(7, 'Pellentesque habitant', 1, 'localhost', '143', 'admin', 'admin', 'INBOX', 'INBOX.Trash', '2014-06-27 18:44:25', '2014-06-27 18:44:25', 1, 2, 34, 1, 1),
(8, 'Etiam iaculis', 1, 'localhost', '143', 'carlos', 'hood', 'INBOX', 'INBOX.Trash', '2014-06-27 18:48:21', '2014-06-27 18:48:21', 0, 3, 23, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_outbound`
--

CREATE TABLE IF NOT EXISTS `email_outbound` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `server` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` int(11) DEFAULT '25',
  `auth` tinyint(1) DEFAULT '1',
  `security` enum('ssl','tls') COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email_outbound`
--

INSERT INTO `email_outbound` (`id`, `name`, `server`, `port`, `auth`, `security`, `username`, `password`, `from_name`, `from_address`, `deleted`, `user_id`) VALUES
(1, 'Outbound Mail', 'mail.easternenterprise.com', 25, 1, 'tls', 'v.awate@easternenterprise.com', 'D8IoAozY', 'EELocal', 'eecrm@easternenterprise.com', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci,
  `is_html` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `modified_by_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `assigned_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9C0600CA99049ECE` (`modified_by_id`),
  KEY `IDX_9C0600CAB03A8386` (`created_by_id`),
  KEY `IDX_9C0600CAADF66B1A` (`assigned_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `name`, `subject`, `body`, `is_html`, `created_at`, `modified_at`, `deleted`, `modified_by_id`, `created_by_id`, `assigned_user_id`) VALUES
(1, 'Test Template', 'test Subject', '<p>Hello {name},</p><p>Hesdfsfs <span style="font-weight: bold;">test</span> 123123</p>', 1, '2014-06-30 14:40:58', '2014-06-30 14:40:58', 0, 1, 1, 24),
(2, 'Briar Kitra', 'test Subject', '<p><span style="font-weight: bold;">Terst</span> 34242 23fsdfsd</p>', 1, '2014-06-30 14:42:32', '2014-06-30 14:42:32', 0, 1, 1, 24),
(3, 'Test Temp', 'test Subject', '<p>dfgdfgdfgfdgg fdgdfg</p>', 1, '2014-07-03 14:55:26', '2014-07-03 14:55:26', 0, 1, 1, 33),
(4, 'Test Temp2', 'Test Temp2', '<p>Test Temp2</p>', 1, '2014-07-03 14:56:02', '2014-07-03 14:56:02', 0, 1, 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `entity_phone`
--

CREATE TABLE IF NOT EXISTS `entity_phone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `entity_type` enum('Lead','Opportunity') NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `entity_phone`
--

INSERT INTO `entity_phone` (`id`, `entity_id`, `entity_type`, `phone`) VALUES
(1, 111, 'Lead', '1234567890'),
(32, 112, 'Lead', '2147483647'),
(33, 112, 'Lead', '1234567890'),
(38, 19, 'Opportunity', '1234567890'),
(43, 20, 'Opportunity', '2147483647'),
(44, 20, 'Opportunity', '2147483647'),
(51, 12, 'Lead', '321312123'),
(54, 16, 'Lead', '2147483647'),
(55, 4, 'Lead', '1234567890'),
(56, 4, 'Lead', '2147483647'),
(60, 1, 'Opportunity', '342342423'),
(61, 1, 'Opportunity', '4324242'),
(62, 21, 'Opportunity', '2147483647'),
(63, 21, 'Opportunity', '2147483647'),
(66, 9, 'Lead', '1234567890'),
(69, 6, 'Lead', '2147483647'),
(70, 6, 'Lead', '2147483647'),
(78, 7, 'Lead', '2147483647'),
(79, 7, 'Lead', '1234567890'),
(80, 7, 'Lead', '2147483647'),
(83, 38, 'Lead', '2147483647'),
(97, 13, 'Lead', '0687924217'),
(98, 13, 'Lead', '0676730772'),
(99, 22, 'Opportunity', '0676730772'),
(100, 23, 'Opportunity', '1234567890'),
(101, 24, 'Opportunity', '2147483647'),
(102, 113, 'Lead', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `entity_team`
--

CREATE TABLE IF NOT EXISTS `entity_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) DEFAULT '0',
  `team_id` int(11) DEFAULT '0',
  `entity_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=350 ;

--
-- Dumping data for table `entity_team`
--

INSERT INTO `entity_team` (`id`, `entity_id`, `team_id`, `entity_type`, `deleted`) VALUES
(3, 3, 1, 'Lead', 0),
(8, 3, 5, 'Lead', 0),
(63, 2, 1, 'Opportunity', 0),
(64, 2, 2, 'Opportunity', 0),
(65, 2, 3, 'Opportunity', 0),
(87, 101, 1, 'Lead', 0),
(88, 62, 2, 'Lead', 0),
(91, 10, 2, 'Opportunity', 0),
(94, 11, 3, 'Opportunity', 0),
(115, 102, 1, 'Lead', 0),
(118, 12, 1, 'Opportunity', 0),
(119, 13, 3, 'Opportunity', 0),
(125, 14, 2, 'Opportunity', 0),
(127, 103, 3, 'Lead', 0),
(130, 15, 3, 'Opportunity', 0),
(132, 104, 4, 'Lead', 0),
(144, 16, 4, 'Opportunity', 0),
(150, 105, 1, 'Lead', 0),
(153, 107, 3, 'Lead', 0),
(155, 17, 1, 'Opportunity', 0),
(156, 106, 3, 'Lead', 0),
(232, 1, 4, 'Lead', 0),
(233, 1, 3, 'Lead', 0),
(254, 9, 3, 'Lead', 0),
(262, 108, 4, 'Lead', 0),
(263, 109, 1, 'Lead', 0),
(264, 110, 3, 'Lead', 0),
(265, 111, 3, 'Lead', 0),
(284, 112, 3, 'Lead', 0),
(288, 18, 3, 'Opportunity', 0),
(289, 19, 3, 'Opportunity', 0),
(294, 20, 1, 'Opportunity', 0),
(297, 16, 0, 'Lead', 0),
(298, 4, 4, 'Lead', 0),
(299, 4, 3, 'Lead', 0),
(300, 4, 2, 'Lead', 0),
(309, 1, 4, 'Opportunity', 0),
(310, 1, 3, 'Opportunity', 0),
(312, 2, 3, 'Meeting', 0),
(314, 4, 4, 'Meeting', 0),
(318, 1, 3, 'Meeting', 0),
(319, 3, 3, 'Meeting', 0),
(320, 6, 4, 'Meeting', 0),
(322, 2, 2, 'Call', 0),
(328, 3, 5, 'Call', 0),
(329, 1, 4, 'Call', 0),
(330, 21, 1, 'Opportunity', 0),
(336, 1, 3, 'Task', 0),
(338, 4, 3, 'Call', 0),
(339, 2, 4, 'Task', 0),
(340, 7, 4, 'Meeting', 0),
(341, 2, 4, 'Template', 0),
(342, 6, 1, 'Lead', 0),
(345, 7, 3, 'Lead', 0),
(346, 7, 5, 'Lead', 0),
(347, 13, 0, 'Lead', 0),
(348, 22, 0, 'Opportunity', 0),
(349, 23, 3, 'Opportunity', 0);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `history_id` int(24) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `next_assigned_to` int(11) NOT NULL,
  `change_param` int(11) NOT NULL,
  `changeType` enum('Assign','Create','Post','Status','Stage') NOT NULL,
  `remark` text NOT NULL,
  `entity_type` enum('Lead','Opportunity') NOT NULL,
  `action_date` date NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=223 ;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `entity_id`, `user_id`, `next_assigned_to`, `change_param`, `changeType`, `remark`, `entity_type`, `action_date`, `change_date`) VALUES
(30, 1, 1, 0, 0, 'Create', '', 'Opportunity', '2014-06-03', '2014-06-02 18:30:00'),
(32, 1, 1, 0, 2, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(35, 4, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(36, 6, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(37, 5, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(38, 8, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(39, 7, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(40, 9, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(41, 1, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-02', '2014-06-01 18:30:00'),
(43, 10, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-09', '2014-06-08 18:30:00'),
(44, 10, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-09', '2014-06-08 18:30:00'),
(45, 1, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(46, 1, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(47, 1, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(48, 1, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(49, 1, 1, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(50, 1, 1, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(51, 1, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(52, 4, 1, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(53, 4, 1, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(54, 4, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(55, 4, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(56, 4, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(57, 4, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(58, 4, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(59, 4, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(60, 4, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(62, 14, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(63, 14, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(64, 14, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(65, 14, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(66, 14, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(68, 15, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(69, 15, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(71, 16, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(72, 16, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(73, 16, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(74, 16, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(75, 16, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(76, 16, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(77, 16, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-10', '2014-06-09 18:30:00'),
(78, 105, 23, 0, 4, 'Create', '', 'Lead', '2014-06-10', '2014-06-09 18:30:00'),
(79, 105, 23, 0, 4, 'Create', '', 'Lead', '2014-06-10', '2014-06-09 18:30:00'),
(80, 105, 23, 0, 4, 'Create', '', 'Lead', '2014-06-10', '2014-06-09 18:30:00'),
(81, 106, 23, 0, 4, 'Create', '', 'Lead', '2014-06-10', '2014-06-09 18:30:00'),
(82, 107, 23, 0, 4, 'Create', '', 'Lead', '2014-06-11', '2014-06-10 18:30:00'),
(83, 17, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-11', '2014-06-10 18:30:00'),
(84, 17, 23, 0, 3, 'Create', '', 'Opportunity', '2014-06-11', '2014-06-10 18:30:00'),
(85, 1, 1, 0, 6, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(86, 1, 1, 0, 5, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(87, 1, 1, 0, 6, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(88, 1, 1, 0, 1, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(89, 1, 1, 0, 7, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(90, 1, 1, 0, 4, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(91, 1, 1, 0, 5, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(92, 1, 1, 0, 4, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(93, 1, 1, 0, 6, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(94, 1, 1, 0, 4, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(95, 1, 1, 0, 5, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(96, 1, 1, 0, 4, 'Status', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(97, 1, 1, 0, 21, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(98, 1, 1, 0, 23, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(99, 1, 1, 0, 21, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(100, 1, 1, 0, 0, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(101, 1, 1, 0, 23, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(102, 1, 1, 0, 0, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(103, 4, 1, 0, 23, 'Assign', '', 'Lead', '2014-06-16', '2014-06-15 18:30:00'),
(104, 4, 1, 0, 22, 'Assign', '', 'Lead', '2014-06-17', '2014-06-16 18:30:00'),
(105, 4, 1, 0, 23, 'Assign', '', 'Lead', '2014-06-17', '2014-06-16 18:30:00'),
(106, 4, 1, 0, 5, 'Status', '', 'Lead', '2014-06-17', '2014-06-16 18:30:00'),
(107, 4, 1, 0, 4, 'Status', '', 'Lead', '2014-06-17', '2014-06-16 18:30:00'),
(108, 4, 1, 0, 3, 'Status', '', 'Lead', '2014-06-17', '2014-06-16 18:30:00'),
(109, 18, 1, 0, 2, 'Assign', '', 'Opportunity', '2014-06-18', '2014-06-17 18:30:00'),
(110, 19, 1, 0, 2, 'Assign', '', 'Opportunity', '2014-06-18', '2014-06-17 18:30:00'),
(111, 6, 1, 0, 23, 'Assign', '', 'Lead', '2014-06-19', '2014-06-18 18:30:00'),
(112, 20, 1, 0, 2, 'Assign', '', 'Opportunity', '2014-06-19', '2014-06-18 18:30:00'),
(113, 6, 1, 0, 5, 'Status', '', 'Lead', '2014-06-19', '2014-06-18 18:30:00'),
(114, 16, 1, 0, 1, 'Status', '', 'Lead', '2014-06-19', '2014-06-18 18:30:00'),
(115, 16, 1, 0, 2, 'Status', '', 'Lead', '2014-06-19', '2014-06-19 11:38:23'),
(116, 4, 23, 0, 4, 'Status', '', 'Lead', '2014-06-19', '2014-06-19 12:21:01'),
(117, 4, 1, 0, 24, 'Assign', '', 'Lead', '2014-06-20', '2014-06-20 05:22:48'),
(125, 4, 1, 0, 0, 'Post', 'rwerwrwe', 'Lead', '2014-06-20', '2014-06-20 11:37:43'),
(126, 4, 1, 0, 0, 'Post', 'dfsfsd', 'Lead', '2014-06-20', '2014-06-20 11:37:49'),
(127, 4, 1, 0, 0, 'Post', 'sdfs', 'Lead', '2014-06-20', '2014-06-20 11:38:01'),
(128, 4, 23, 0, 0, 'Post', 'zxczxc', 'Lead', '2014-06-20', '2014-06-20 11:42:02'),
(129, 4, 23, 0, 0, 'Post', 'zxczxc', 'Lead', '2014-06-20', '2014-06-20 11:42:10'),
(130, 4, 23, 0, 0, 'Post', 'eere', 'Lead', '2014-06-20', '2014-06-20 11:59:05'),
(131, 4, 23, 0, 0, 'Post', 'gdgf', 'Lead', '2014-06-20', '2014-06-20 11:59:47'),
(132, 16, 23, 0, 0, 'Post', 'fhgh', 'Lead', '2014-06-20', '2014-06-20 12:26:56'),
(133, 16, 23, 0, 0, 'Post', 'fhghffhfh', 'Lead', '2014-06-20', '2014-06-20 12:26:59'),
(134, 16, 23, 0, 0, 'Post', 'hfgh', 'Lead', '2014-06-20', '2014-06-20 12:27:03'),
(135, 16, 23, 0, 0, 'Post', 'tyutyu', 'Lead', '2014-06-20', '2014-06-20 12:27:10'),
(136, 12, 23, 0, 0, 'Post', 'gddgd', 'Lead', '2014-06-20', '2014-06-20 12:27:25'),
(137, 12, 23, 0, 0, 'Post', 'gddgddgdfg', 'Lead', '2014-06-20', '2014-06-20 12:27:29'),
(138, 12, 23, 0, 0, 'Post', 'ert', 'Lead', '2014-06-20', '2014-06-20 12:27:31'),
(139, 12, 23, 0, 0, 'Post', 'ert', 'Lead', '2014-06-20', '2014-06-20 12:27:40'),
(140, 12, 23, 0, 0, 'Post', 'ert', 'Lead', '2014-06-20', '2014-06-20 12:27:55'),
(141, 13, 23, 0, 0, 'Post', 'dsdfs', 'Lead', '2014-06-20', '2014-06-20 12:28:59'),
(142, 13, 23, 0, 0, 'Post', 'dsdfs', 'Lead', '2014-06-20', '2014-06-20 12:29:02'),
(143, 13, 23, 0, 0, 'Post', 'dsdfs', 'Lead', '2014-06-20', '2014-06-20 12:29:04'),
(144, 13, 23, 0, 0, 'Post', 'dsdfs', 'Lead', '2014-06-20', '2014-06-20 12:29:06'),
(145, 13, 23, 0, 0, 'Post', 'dsdfs', 'Lead', '2014-06-20', '2014-06-20 12:29:08'),
(146, 13, 23, 0, 0, 'Post', 'uyuiyi', 'Lead', '2014-06-20', '2014-06-20 12:33:57'),
(147, 13, 23, 0, 0, 'Post', 'uyuiyi', 'Lead', '2014-06-20', '2014-06-20 12:34:05'),
(148, 13, 23, 0, 0, 'Post', 'fhfghf', 'Lead', '2014-06-20', '2014-06-20 12:35:21'),
(149, 22, 23, 0, 0, 'Post', 'yryryrty', 'Lead', '2014-06-20', '2014-06-20 12:35:34'),
(150, 22, 23, 0, 0, 'Post', 'yryryrty', 'Lead', '2014-06-20', '2014-06-20 12:35:37'),
(151, 22, 23, 0, 0, 'Post', 'yryryrty', 'Lead', '2014-06-20', '2014-06-20 12:35:38'),
(152, 22, 23, 0, 0, 'Post', 'yryryrty', 'Lead', '2014-06-20', '2014-06-20 12:35:40'),
(153, 22, 23, 0, 0, 'Post', 'ttt', 'Lead', '2014-06-20', '2014-06-20 12:35:46'),
(154, 22, 23, 0, 0, 'Post', 'rrr', 'Lead', '2014-06-20', '2014-06-20 12:35:51'),
(155, 22, 23, 0, 0, 'Post', 'asd', 'Lead', '2014-06-20', '2014-06-20 12:40:09'),
(156, 22, 23, 0, 0, 'Post', 'dgdgd', 'Lead', '2014-06-20', '2014-06-20 12:41:14'),
(157, 22, 23, 0, 0, 'Post', 'fsasafasffas', 'Lead', '2014-06-20', '2014-06-20 12:41:40'),
(158, 0, 1, 0, 0, 'Post', 'gyg', '', '2014-06-23', '2014-06-23 05:08:31'),
(159, 0, 1, 0, 0, 'Post', 'tyut', '', '2014-06-23', '2014-06-23 05:08:44'),
(160, 4, 1, 0, 0, 'Post', 'ss', 'Lead', '2014-06-23', '2014-06-23 08:51:26'),
(161, 4, 1, 0, 0, 'Post', 'fsdfsdf', 'Lead', '2014-06-23', '2014-06-23 09:40:15'),
(162, 4, 1, 0, 0, 'Post', 'hfghf', 'Lead', '2014-06-23', '2014-06-23 09:45:28'),
(163, 4, 23, 0, 0, 'Post', 'sdf', 'Lead', '2014-06-23', '2014-06-23 09:46:29'),
(164, 4, 23, 0, 0, 'Post', '', 'Lead', '2014-06-23', '2014-06-23 09:52:25'),
(165, 4, 23, 0, 0, 'Post', 'xcz', 'Lead', '2014-06-23', '2014-06-23 09:52:42'),
(166, 4, 23, 0, 0, 'Post', 'tyrt', 'Lead', '2014-06-23', '2014-06-23 10:11:21'),
(167, 4, 23, 0, 0, 'Post', 'dfsd', 'Lead', '2014-06-23', '2014-06-23 10:11:24'),
(168, 4, 23, 0, 0, 'Post', 'dgdgg', 'Lead', '2014-06-23', '2014-06-23 10:14:45'),
(169, 4, 23, 0, 0, 'Post', 'dfgdf', 'Lead', '2014-06-23', '2014-06-23 10:14:46'),
(170, 4, 23, 0, 0, 'Post', 'sdasda', 'Lead', '2014-06-23', '2014-06-23 10:15:52'),
(171, 4, 23, 0, 0, 'Post', 'asda', 'Lead', '2014-06-23', '2014-06-23 10:15:54'),
(172, 4, 23, 0, 0, 'Post', 'dsfs', 'Lead', '2014-06-23', '2014-06-23 10:17:42'),
(173, 4, 23, 0, 0, 'Post', 'sdfs', 'Lead', '2014-06-23', '2014-06-23 10:18:11'),
(174, 4, 23, 0, 0, 'Post', 'fsdf', 'Lead', '2014-06-23', '2014-06-23 10:18:13'),
(175, 4, 23, 0, 0, 'Post', 'Test', 'Lead', '2014-06-23', '2014-06-23 10:18:54'),
(176, 4, 23, 0, 0, 'Post', '', 'Lead', '2014-06-23', '2014-06-23 10:19:41'),
(177, 4, 23, 0, 0, 'Post', '', 'Lead', '2014-06-23', '2014-06-23 10:38:45'),
(178, 4, 23, 0, 0, 'Post', 'Test 343242', 'Lead', '2014-06-23', '2014-06-23 10:39:00'),
(179, 4, 23, 0, 0, 'Post', '', 'Lead', '2014-06-23', '2014-06-23 11:42:39'),
(180, 4, 23, 0, 5, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:43:47'),
(181, 4, 23, 0, 6, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:46:45'),
(182, 4, 23, 0, 7, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:48:00'),
(183, 4, 23, 0, 1, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:48:31'),
(184, 4, 23, 0, 2, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:49:13'),
(185, 4, 23, 0, 3, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:50:19'),
(186, 4, 23, 0, 4, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:51:51'),
(187, 4, 23, 0, 5, 'Status', '', 'Lead', '2014-06-23', '2014-06-23 11:52:09'),
(188, 4, 23, 0, 23, 'Assign', '', 'Lead', '2014-06-23', '2014-06-23 11:53:44'),
(189, 0, 23, 0, 0, 'Post', 'hfgf', '', '2014-06-23', '2014-06-23 11:54:31'),
(190, 9, 23, 0, 0, 'Post', 'dasd', 'Opportunity', '2014-06-23', '2014-06-23 11:57:47'),
(191, 4, 23, 0, 21, 'Assign', '', 'Lead', '2014-06-23', '2014-06-23 12:04:47'),
(192, 4, 23, 0, 0, 'Post', 'test', 'Lead', '2014-06-23', '2014-06-23 12:04:57'),
(193, 1, 23, 0, 4, 'Stage', '', 'Opportunity', '2014-06-23', '2014-06-23 12:53:56'),
(194, 1, 23, 0, 5, 'Stage', '', 'Opportunity', '2014-06-23', '2014-06-23 12:54:37'),
(195, 1, 23, 0, 6, 'Stage', '', 'Opportunity', '2014-06-23', '2014-06-23 12:54:55'),
(196, 1, 23, 0, 1, 'Stage', '', 'Opportunity', '2014-06-23', '2014-06-23 12:57:55'),
(197, 1, 23, 0, 23, 'Assign', '', 'Opportunity', '2014-06-23', '2014-06-23 13:11:31'),
(198, 1, 23, 0, 24, 'Assign', '', 'Opportunity', '2014-06-23', '2014-06-23 13:11:41'),
(199, 1, 23, 0, 23, 'Assign', '', 'Opportunity', '2014-06-23', '2014-06-23 13:11:56'),
(200, 1, 23, 0, 25, 'Assign', '', 'Opportunity', '2014-06-23', '2014-06-23 13:27:30'),
(201, 1, 23, 0, 23, 'Assign', '', 'Opportunity', '2014-06-23', '2014-06-23 13:27:41'),
(202, 1, 23, 0, 0, 'Post', 'sdfsdf', 'Opportunity', '2014-06-23', '2014-06-23 13:30:28'),
(203, 1, 23, 0, 0, 'Post', 'rtyr', 'Opportunity', '2014-06-23', '2014-06-23 13:31:06'),
(204, 1, 23, 0, 0, 'Post', 'fsdf', 'Opportunity', '2014-06-23', '2014-06-23 13:36:20'),
(205, 21, 23, 0, 2, 'Create', '', 'Opportunity', '2014-06-25', '2014-06-25 13:08:47'),
(206, 6, 1, 0, 0, 'Post', '', 'Lead', '2014-06-30', '2014-06-30 09:38:25'),
(207, 22, 1, 0, 2, 'Create', '', 'Opportunity', '2014-07-03', '2014-07-03 07:33:53'),
(208, 8, 1, 0, 0, 'Post', 'dasd', 'Lead', '2014-07-03', '2014-07-03 09:24:30'),
(209, 8, 1, 0, 0, 'Post', 'fsdfss', 'Lead', '2014-07-03', '2014-07-03 09:26:47'),
(210, 9, 1, 0, 0, 'Post', 'hrdgf', 'Lead', '2014-07-03', '2014-07-03 13:22:45'),
(211, 9, 1, 0, 0, 'Post', 'ghfhgfh', 'Lead', '2014-07-03', '2014-07-03 13:22:52'),
(212, 9, 1, 0, 6, 'Status', '', 'Lead', '2014-07-03', '2014-07-03 13:23:30'),
(213, 22, 1, 0, 0, 'Post', 'hii', 'Opportunity', '2014-07-03', '2014-07-03 13:24:00'),
(214, 22, 1, 0, 0, 'Post', 'xvxv', 'Opportunity', '2014-07-03', '2014-07-03 13:24:07'),
(215, 23, 1, 0, 2, 'Create', '', 'Opportunity', '2014-07-03', '2014-07-03 13:25:12'),
(216, 23, 23, 0, 0, 'Post', 'dfsd', 'Opportunity', '2014-07-03', '2014-07-03 13:40:29'),
(217, 23, 23, 0, 3, 'Stage', '', 'Opportunity', '2014-07-03', '2014-07-03 13:43:14'),
(218, 23, 23, 0, 2, 'Stage', '', 'Opportunity', '2014-07-03', '2014-07-03 13:51:40'),
(219, 10, 23, 0, 0, 'Post', 'fdgd', 'Lead', '2014-07-03', '2014-07-03 13:53:41'),
(220, 24, 23, 0, 2, 'Create', '', 'Opportunity', '2014-07-03', '2014-07-03 13:56:44'),
(221, 113, 23, 0, 1, 'Create', '', 'Lead', '2014-07-03', '2014-07-03 14:06:11'),
(222, 10, 1, 0, 0, 'Post', 'hii', 'Lead', '2014-07-04', '2014-07-04 06:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `source` int(11) DEFAULT '1',
  `opportunity_amount_currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `opportunity_amount` double DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_street` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_state` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_postal_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_office` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `do_not_call` tinyint(1) DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `account_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_opportunity_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_contact_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_account_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `assigned_user_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `salutation_name`, `first_name`, `last_name`, `title`, `status`, `source`, `opportunity_amount_currency`, `opportunity_amount`, `website`, `address_street`, `address_city`, `address_state`, `address_country`, `address_postal_code`, `email_address`, `phone`, `fax`, `phone_office`, `do_not_call`, `description`, `created_at`, `modified_at`, `account_name`, `deleted`, `created_opportunity_id`, `created_contact_id`, `created_account_id`, `assigned_user_id`, `modified_by_id`, `created_by_id`) VALUES
(1, 'Mr.', 'Caryn', 'Cheyenne', 'Andrew Lynn', 4, 1, 'USD', 8, 'http://test123.co.uk', '406-3320 Quam St.', 'Hamburg', 'HH', 'Mongolia', '5594', 'test@test.com', '(030) 34770855', '(039481) 126662', '(033767) 640138', NULL, 'nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis.\n\nTest 123123 453453', '2014-12-17 22:41:59', '2014-06-16 19:08:41', 'Elmo Test', 1, '0', '0', '0', '', '1', '2'),
(2, 'Mrs.', 'Meghan', 'Taylor', 'Tyrone Haney', 0, 0, 'USD', 6, 'Donec.feugiat@Fuscefeugiat.org', '7412 Nunc Av.', 'Jonesboro', 'AR', 'Solomon Islands', 'AM5 4EZ', '', '(039245) 854272', '(039) 60910434', '(055) 96340963', 1, 'est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non', '2014-02-04 02:59:17', '2015-01-25 00:14:53', 'Salvador', 0, '0', '0', '0', '2', '1', '2'),
(3, 'Mr.', 'Garrett', 'Elaine', 'Hayes Harding', 0, 0, 'USD', 8, 'tempor@lacusUtnec.org', 'Ap #768-4290 Morbi Ave', 'ÃƒÂvila', 'CL', 'Montenegro', '80063', '', '(035) 40029635', '(0403) 06260869', '(0495) 21290636', 1, 'egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam', '2013-08-23 19:08:50', '2014-04-11 12:13:02', 'Elvis', 0, '0', '0', '0', '2', '1', '1'),
(4, 'Dr.', 'Kennan', 'Noelle', 'Levi Booker', 5, 10, 'USD', 5, 'enimSuspendisse.com', 'Ap #973-1013 Ante, Rd.', 'Pamplona', 'Navarra', 'Congo, the Democratic Republic of the', '6659', 'kennan@mailinator.com', '1234567890,0676730772', '(07095) 1022697', '(06683) 6713274', NULL, 'tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus', '2014-10-19 05:21:19', '2014-06-23 17:34:47', 'Keylegfgf', 1, '0', '0', '0', '21', '23', '1'),
(5, 'Mr.', 'Blair', 'Yolanda', 'Barclay Guzman', 0, 0, 'USD', 7, 'a.sollicitudin.orci@Maurisblandit.ca', 'Ap #250-2572 Felis Avenue', 'ÃƒÂ‰vreux', 'Haute-Normandie', 'Cuba', '33387', '', '(026) 22901853', '(090) 57609402', '(0134) 63078230', 1, 'ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis.', '2014-06-07 03:42:36', '2014-11-23 14:25:34', 'Brennan', 0, '0', '0', '0', '2', '1', '2'),
(6, 'Mr.', 'Briar', 'Kitra', 'Simon Gallegos', 7, 3, 'USD', 5, 'Aenean@orci.ca', '339-9028 Mus. St.', 'Boston', 'Massachusetts', 'Norway', '75209', 'briar@mailinator.com', '(0590) 15779999', '(039550) 429751', '(0844) 40833203', NULL, 'consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc', '2013-10-06 02:00:00', '2014-07-03 12:02:21', 'Priced', 1, '0', '0', '0', '23', '23', '1'),
(7, 'Mr.', 'Gisela', 'Alyssa', 'Hector Daugherty', 7, 8, 'USD', 5, 'auctor.odio.a@tempor.org', '397-1705 Montes, Rd.', 'Ketchikan', 'Alaska', 'Saint Barth', '11300', 'gisela@mailinator.com', '(0536) 78098892', '(034877) 582182', '(0914) 89431493', NULL, 'velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem', '2013-12-12 05:31:35', '2014-07-03 12:02:58', 'Austin', 0, '0', '0', '0', '23', '23', '2'),
(8, 'Mr.', 'Ramona', 'Derek', 'Castor Blankenship', 7, 4, 'USD', 7, 'magna.Lorem.ipsum@asollicitudin.ca', 'P.O. Box 575, 9184 Vitae, Road', 'Berlin', 'BE', 'Belize', '46355', 'ramona@mailinator.com', '(031498) 936363', '(024) 23396062', '(06165) 6686692', NULL, 'rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit', '2014-02-02 21:55:37', '2014-06-02 13:17:59', 'Noble', 1, '0', '0', '0', '23', '23', '1'),
(9, 'Mrs.', 'Helen', 'Leroy', 'Brady Walter', 7, 5, 'USD', 5, 'ultricessitamet.edu', '120-5551 Sit Av.', 'Orilla', 'Ontario', 'Moldova', '57664', 'nulla.ante@ultricessitamet.edu', '(037320) 271301', '(00766) 4701910', '(037530) 727068', 0, 'diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis', '2013-07-10 08:42:59', '2014-07-03 18:53:30', 'Hope', 0, '0', '0', '0', '1', '1', '1'),
(10, 'Mr.', 'Britanni', 'Zelenia', 'Arden Vaughn', 6, 8, 'USD', 6, 'http://sagittisplacerat.com', '8062 Hendrerit Av.', 'Oss', 'Noord Brabant', 'Cayman Islands', '5894', 'briani@mailinator.com', '(035528) 713230', '(09005) 6782464', '(031638) 817885', NULL, 'aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc', '2015-04-14 05:12:19', '2014-07-04 18:22:03', 'Nathan', 0, '0', '0', '0', '1', '', '2'),
(11, 'Dr.', 'Ori', 'Kirestin', 'Lester Peters', 7, 10, 'USD', 9, 'erat.eget@ametornarelectus.com', '821-8313 In, Street', 'Wichita', 'KS', 'Puerto Rico', '01896', '', '(030220) 133305', '(03592) 1985783', '(0199) 59414248', NULL, 'et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac', '2014-05-08 14:11:34', '2014-05-23 18:48:52', 'Connor', 0, '0', '0', '0', '1', '1', '2'),
(12, 'Mrs.', 'Isabelle', 'Owen', 'Jameson Maxwell', 3, 5, 'USD', 9, 'ut@enimcondimentumeget.net', 'Ap #359-6828 Sed Rd.', 'Orangeville', 'Ontario', 'Czech Republic', 'PH32 5GB', '', '(0408) 95734011', '(0442) 25194254', '(0459) 18872259', NULL, 'neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus.', '2014-09-02 17:12:11', '2014-05-23 18:48:36', 'Asher', 0, '0', '0', '0', '1', '1', '1'),
(13, 'Mr.', 'Rhea', 'Kai', 'August Morales', 3, 8, 'USD', 6, 'Sed@massaInteger.edu', 'Ap #595-742 Ligula. St.', 'Wolfsberg', 'Kt', 'Germany', '21100-054', 'Sed@massaInteger.edu', '(0268) 99147927', '(037123) 418886', '(0752) 87780151', NULL, 'commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc,', '2013-10-22 17:58:18', '2014-07-03 12:16:08', 'Vaughan', 0, '0', '0', '0', '1', '23', '1'),
(14, '', 'Zephania', 'Ila', 'Macaulay Joyce', 0, 0, 'USD', 5, 'pede.et@Phasellusliberomauris.co.uk', 'Ap #593-2340 Scelerisque Road', 'Horsham', 'Victoria', 'Saint Pierre and Miquelon', '374459', '', '(037182) 755832', '(013) 08437120', '(084) 42187757', 1, 'eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus', '2014-03-07 23:03:55', '2014-05-24 05:55:06', 'Marshall', 0, '0', '0', '0', '2', '1', '1'),
(15, 'Mrs.', 'Cassandra', 'Sandra', 'Zeph Holcomb', 0, 0, 'USD', 8, 'dictum@sedsapien.ca', 'Ap #932-4401 Arcu. Ave', 'Portland', 'OR', 'Equatorial Guinea', 'KT8 3KD', '', '(0152) 19064871', '(016) 44746105', '(0241) 07199363', 1, 'dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem', '2014-11-21 14:00:15', '2014-03-31 18:47:20', 'Brent', 0, '0', '0', '0', '2', '1', '2'),
(16, 'Mr.', 'Jamalia', 'Lani', 'Yuli Knapp', 7, 6, 'USD', 7, 'ac.turpis.egestas@Aliquam.com', 'Ap #623-3284 Amet Rd.', 'Hartford', 'CT', 'Comoros', '35624', 'jamalia@mailinator.com', '(096) 04118020', '(030365) 321296', '(08762) 6200609', NULL, 'elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum', '2014-07-04 00:07:43', '2014-06-19 17:08:23', 'Clark', 0, '0', '0', '0', '23', '1', '2'),
(17, 'Mrs.', 'Laith', 'Hu', 'Dennis Sweeney', 0, 0, 'USD', 9, 'malesuada@semper.co.uk', 'P.O. Box 277, 1398 Augue. St.', 'Spijkenisse', 'Z.', 'Afghanistan', 'P9X 6T5', '', '(035168) 809556', '(030548) 345829', '(069) 77614877', 1, 'bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat', '2014-03-02 17:19:41', '2014-06-21 02:57:06', 'Carter', 0, '0', '0', '0', '2', '1', '1'),
(18, 'Ms.', 'Lawrence', 'Phillip', 'Baxter Kramer', 0, 0, 'USD', 5, 'tristique.senectus.et@Suspendisse.net', 'Ap #726-8447 Bibendum Street', 'SÃƒÂ£o JoÃƒÂ£o de Meriti', 'RJ', 'Saint Lucia', '5534', '', '(012) 96612852', '(028) 21002702', '(033) 61923612', 0, 'Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit', '2013-11-09 22:50:22', '2015-01-04 17:17:12', 'Harding', 0, '0', '0', '0', '2', '1', '1'),
(19, 'Mrs.', 'Sonia', 'Forrest', 'Hyatt Mack', 0, 0, 'USD', 9, 'ac@mollisvitae.co.uk', 'P.O. Box 100, 991 Auctor Street', 'Penrith', 'New South Wales', 'Lithuania', '8316', '', '(0552) 27224241', '(035) 48008597', '(03832) 7451808', 1, 'diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam', '2015-01-13 13:39:18', '2013-11-18 10:49:30', 'Paki', 0, '0', '0', '0', '2', '1', '1'),
(20, 'Ms.', 'Travis', 'Tarik', 'Jin Salinas', 0, 0, 'USD', 7, 'egestas.ligula.Nullam@sedduiFusce.ca', '4865 Cras Av.', 'Hilo', 'HI', 'China', 'M3 9IA', '', '(056) 75379594', '(033516) 337011', '(036309) 764145', 1, 'ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero.', '2015-01-12 14:14:33', '2014-11-04 23:50:03', 'Grady', 0, '0', '0', '0', '2', '1', '2'),
(21, 'Mr.', 'Myles', 'Iona', 'Tucker Cole', 0, 0, 'USD', 5, 'nec.euismod@gravidasagittisDuis.edu', '318-9389 Adipiscing Avenue', 'Norfolk', 'Virginia', 'Korea, North', 'P2T 5A2', '', '(0566) 79256369', '(0937) 98348957', '(080) 57132144', 1, 'mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In', '2013-05-29 17:04:00', '2014-01-26 20:22:37', 'Wallace', 0, '0', '0', '0', '2', '1', '1'),
(22, 'Mrs.', 'Laura', 'Callie', 'Conan Craig', 4, 6, 'USD', 9, 'sed.consequat.auctor@Donecnibhenim.ca', '227 Sit St.', 'Haldia', 'West Bengal', 'Paraguay', '01470', '', '(031060) 277458', '(0845) 17933836', '(038) 87381758', NULL, 'amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc.', '2013-11-15 11:56:36', '2014-05-23 19:22:59', 'Dolan', 0, '0', '0', '0', '1', '31', '2'),
(23, '', 'Gray', 'Grant', 'Byron Joyner', 0, 0, 'USD', 9, 'dictum.Phasellus.in@semperegestasurna.co.uk', '804-807 Aliquam Street', 'Zelzate', 'Oost-Vlaanderen', 'Serbia', '3465KX', '', '(0442) 87211833', '(05620) 4507126', '(032025) 261796', 1, 'vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam', '2014-11-10 03:42:01', '2014-08-31 03:07:38', 'Salvador', 0, '0', '0', '0', '2', '1', '1'),
(24, 'Ms.', 'Maggie', 'Fleur', 'Lyle Ramsey', 0, 0, 'USD', 5, 'Nullam.lobortis@aliquam.co.uk', 'Ap #124-155 Nec Av.', 'San Francisco', 'H', 'China', '42790', '', '(033985) 663026', '(067) 44581383', '(03223) 6350920', 0, 'convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer', '2014-11-21 13:56:16', '2014-05-07 11:36:34', 'Amir', 0, '0', '0', '0', '2', '1', '2'),
(25, 'Mr.', 'Zorita', 'Asher', 'Drake Buckley', 4, 11, 'USD', 7, 'Donec.at@facilisi.com', '7301 Morbi Road', 'Pocatello', 'ID', 'Mauritania', '6381', '', '(034707) 600306', '(046) 46205448', '(038) 78784632', NULL, 'lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat,', '2013-08-06 14:15:46', '2014-05-23 19:23:12', 'Brent', 0, '0', '0', '0', '1', '31', '1'),
(26, 'Mrs.', 'Griffith', 'Noah', 'Cruz Hudson', 4, 11, 'USD', 7, 'orci.lacus.vestibulum@ipsum.net', 'Ap #688-1089 Nulla Street', 'La MatapÃ¯Â¿Â½dia', 'QC', 'Guam', '92151', '', '(004) 92892739', '(04957) 7534221', '(06118) 6016093', NULL, 'odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec,', '2014-11-16 03:00:43', '2014-05-23 19:19:30', 'Wesley', 0, '0', '0', '0', '1', '23', '2'),
(27, 'Mr.', 'Wyoming', 'Axel', 'Jesse Yates', 4, 7, 'USD', 9, 'vestibulum@Integer.com', 'Ap #400-5155 Sagittis Street', 'Duffel', 'AN', 'Bosnia and Herzegovina', '93759', '', '(031143) 571723', '(034788) 852015', '(094) 36492057', NULL, 'Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est.', '2014-09-10 13:59:13', '2014-05-23 19:19:53', 'Samuel', 0, '0', '0', '0', '1', '23', '2'),
(28, 'Mrs.', 'April', 'Alma', 'Hop Tran', 4, 11, 'USD', 8, 'Nullam.lobortis@vitae.edu', '304-4406 Gravida Rd.', 'Etawah', 'UP', 'Kenya', '20472-423', '', '(04862) 0277084', '(08588) 6340000', '(065) 07238707', NULL, 'viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer', '2014-01-12 11:47:48', '2014-05-23 19:23:24', 'Bevis', 0, '0', '0', '0', '1', '31', '2'),
(29, 'Mr.', 'Kirestin', 'Silas', 'Hop Burch', 4, 8, 'USD', 9, 'Mauris.molestie@Donecfringilla.co.uk', 'Ap #943-9449 Arcu Rd.', 'Osasco', 'SÃƒÂ£o Paulo', 'Bahrain', '5666', '', '(065) 08117788', '(050) 89723513', '(008) 84040792', NULL, 'metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim.', '2014-02-03 21:46:31', '2014-05-23 19:23:46', 'Daquan', 0, '0', '0', '0', '1', '33', '2'),
(30, 'Dr.', 'Stewart', 'Aaron', 'Aaron Odonnell', 7, 7, 'USD', 9, 'justo.nec@gravidasagittis.org', '921-2213 Est, St.', 'Walsall', 'Staffordshire', 'Serbia', '7205', 'stewart@mailinator.com', '(059) 88568957', '(00340) 7489444', '(091) 99505316', NULL, 'arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla.', '2014-11-11 14:15:29', '2014-06-02 13:22:49', 'Ross', 0, '0', '0', '0', '23', '23', '2'),
(31, 'Mr.', 'Conan', 'Chiquita', 'Abraham Dennis', 0, 0, 'USD', 6, 'risus@euismodindolor.net', 'Ap #237-6951 Cras Av.', 'Vienna', 'Vienna', 'Algeria', '40608', '', '(036763) 887231', '(07137) 2123961', '(082) 04516494', 0, 'tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas', '2014-02-22 15:44:17', '2015-03-04 08:44:50', 'Emerson', 0, '0', '0', '0', '2', '1', '2'),
(32, 'Mrs.', 'Joelle', 'Dante', 'Stewart Carr', 4, 9, 'USD', 6, 'gravida@sed.co.uk', '3187 In Rd.', 'Governador Valadares', 'MG', 'Aruba', '112948', '', '(032330) 931243', '(032) 81700696', '(04451) 9430185', NULL, 'mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc.', '2013-07-04 17:31:22', '2014-05-23 19:19:39', 'Eaton', 0, '0', '0', '0', '1', '23', '1'),
(33, 'Ms.', 'Renee', 'Tatiana', 'Raphael Rocha', 0, 0, 'USD', 9, 'ligula.elit.pretium@elita.com', 'P.O. Box 609, 9455 At, St.', 'Waterbury', 'CT', 'Malta', '3179', '', '(0714) 92086272', '(0980) 29328007', '(0956) 04799861', 1, 'non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc', '2015-01-15 18:36:58', '2014-08-15 09:01:53', 'Harper', 0, '0', '0', '0', '2', '1', '1'),
(34, 'Mr.', 'Jerry', 'Echo', 'Nissim Sanchez', 4, 8, 'USD', 9, 'Nullam.enim@Craseu.co.uk', 'Ap #773-8435 Metus. Ave', 'Collecchio', 'ER', 'Gambia', '39213', '', '(0977) 87200495', '(0516) 92147682', '(07843) 5221582', NULL, 'purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris', '2013-08-29 12:33:05', '2014-05-23 19:24:32', 'Keaton', 0, '0', '0', '0', '1', '33', '1'),
(35, 'Mrs.', 'Price', 'Kirby', 'Lester Gill', 4, 1, 'USD', 6, 'commodo.tincidunt.nibh@condimentum.org', 'Ap #795-553 Ut, Rd.', 'Bevel', 'Antwerpen', 'Cyprus', '2873', '', '(02241) 9272531', '(0945) 54305996', '(00193) 7722474', NULL, 'nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec', '2014-02-10 12:44:13', '2014-05-27 12:13:54', 'Macon', 0, '0', '0', '0', '1', '25', '1'),
(36, '', 'Hayes', 'Xenos', 'Nasim Bradshaw', 0, 0, 'USD', 9, 'mauris@conubianostraper.net', '855-9857 Arcu St.', 'Gander', 'Newfoundland and Labrador', 'Tunisia', '02344', '', '(003) 89851582', '(033983) 857792', '(033882) 849624', 0, 'nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet', '2013-07-02 09:42:17', '2013-09-29 05:44:39', 'Xavier', 0, '0', '0', '0', '2', '1', '1'),
(37, 'Ms.', 'Justine', 'Kennedy', 'Merrill Hoffman', 0, 0, 'USD', 6, 'molestie.Sed@utaliquamiaculis.edu', '484-505 Nonummy St.', 'Arbre', 'NA', 'Sweden', '53194', '', '(085) 96750532', '(033619) 299448', '(038009) 790218', 1, 'nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante', '2013-07-05 08:30:32', '2014-01-14 23:44:40', 'Ahmed', 0, '0', '0', '0', '2', '1', '2'),
(38, 'Mr.', 'Sybil', 'Hiram', 'Ciaran May', 4, 11, 'USD', 9, 'neque.tellus@montes.net', 'P.O. Box 382, 7716 Mauris St.', 'Westmount', 'Quebec', 'Serbia', '231148', '', '(0964) 12517819', '(0034) 12912329', '(05490) 2243782', NULL, 'laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur', '2014-01-21 10:40:02', '2014-05-27 12:15:34', 'Garrison', 0, '0', '0', '0', '1', '24', '1'),
(39, 'Dr.', 'Hollee', 'Pascale', 'Emery Potts', 7, 5, 'USD', 5, 'Cras@rhoncusidmollis.com', 'Ap #179-3545 Sed Rd.', 'Pukekohe', 'North Island', 'French Polynesia', '5208', 'hollee@mailinator.om', '(036544) 592281', '(049) 47384659', '(032753) 830277', NULL, 'egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id', '2014-02-06 10:15:59', '2014-06-02 13:22:27', 'Deacon', 0, '0', '0', '0', '23', '23', '1'),
(40, 'Mrs.', 'Amethyst', 'Tanya', 'Dalton Golden', 0, 0, 'USD', 7, 'sodales.purus@vulputate.ca', 'P.O. Box 216, 5721 Pede, Street', 'Tirunelveli', 'Tamil Nadu', 'Andorra', '06038', '', '(0162) 17971295', '(09172) 4539066', '(051) 77315300', 0, 'Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula.', '2013-07-13 22:57:12', '2014-07-09 03:44:04', 'Jonas', 0, '0', '0', '0', '2', '1', '2'),
(41, 'Mr.', 'Keefe', 'Neville', 'Christopher Michael', 0, 0, 'USD', 8, 'ut.pellentesque@leoCrasvehicula.net', 'P.O. Box 433, 8914 Neque St.', 'Omaha', 'NE', 'Uruguay', '9567', '', '(062) 09313521', '(0810) 96037301', '(026) 42266403', 1, 'vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis,', '2014-11-07 16:14:06', '2015-02-06 21:43:59', 'Igor', 0, '0', '0', '0', '2', '1', '2'),
(42, 'Mr.', 'Rose', 'Anika', 'Baxter Hood', 4, 4, 'USD', 9, 'sit.amet.ante@liberomaurisaliquam.co.uk', 'P.O. Box 656, 2156 Purus, St.', 'Geertruidenberg', 'N.', 'Congo (Brazzaville)', 'J4Z 9K6', '', '(050) 75329723', '(0664) 94128160', '(02414) 6496204', NULL, 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut', '2013-10-30 16:02:10', '2014-05-27 12:20:15', 'Matthew', 0, '0', '0', '0', '1', '28', '2'),
(43, 'Mrs.', 'Gloria', 'Jerome', 'Brendan Rush', 0, 0, 'USD', 5, 'interdum@tristique.edu', 'P.O. Box 891, 7492 Laoreet St.', 'Harrisburg', 'PA', 'Saint Martin', '30704', '', '(05096) 1082145', '(032159) 848241', '(05838) 2093325', 1, 'arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc', '2014-09-20 10:02:01', '2013-08-02 04:22:07', 'Craig', 0, '0', '0', '0', '2', '1', '2'),
(44, 'Ms.', 'Kelsie', 'Shea', 'Hayes Barnes', 0, 0, 'USD', 7, 'metus.Aenean.sed@eu.net', 'Ap #612-2856 Consectetuer Ave', 'Wilmington', 'Delaware', 'Slovakia', '1018', '', '(0998) 19264695', '(017) 41838598', '(0240) 39966390', 0, 'quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a', '2014-05-18 04:32:53', '2015-05-01 13:38:44', 'Tyrone', 0, '0', '0', '0', '2', '1', '2'),
(45, 'Dr.', 'Baxter', 'Harper', 'Jordan Suarez', 4, 3, 'USD', 8, 'Aliquam.tincidunt@neque.co.uk', 'P.O. Box 931, 8410 Quis Street', 'Leiden', 'Z.', 'Spain', '6707FV', '', '(050) 89098147', '(08211) 3000039', '(02393) 4056543', NULL, 'ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis,', '2014-09-24 00:25:24', '2014-05-27 12:16:35', 'Lucius', 0, '0', '0', '0', '1', '24', '1'),
(46, 'Mrs.', 'Julian', 'Bethany', 'Aristotle Garza', 0, 0, 'USD', 6, 'aliquet.Proin@SedmolestieSed.com', '985 Lacus. St.', 'San Isidro', 'San JosÃƒÂ©', 'Nauru', '62922', '', '(07540) 4149426', '(00153) 9357207', '(07475) 5960253', 1, 'dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper.', '2014-05-15 10:06:26', '2014-03-30 13:42:11', 'Aladdin', 0, '0', '0', '0', '2', '1', '1'),
(47, 'Dr.', 'Dawn', 'Barbara', 'Martin Barry', 4, 1, 'USD', 8, 'mauris.eu@nequeNullamnisl.net', 'P.O. Box 699, 6973 Risus. Avenue', 'Tarbes', 'Mi', 'Uganda', '7321', '', '(031719) 127144', '(0883) 09900482', '(01175) 2919947', NULL, 'sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh.', '2014-08-21 19:21:21', '2014-05-27 12:19:47', 'David', 0, '0', '0', '0', '1', '28', '2'),
(48, 'Dr.', 'Noelani', 'Renee', 'Garrett Weaver', 4, 11, 'USD', 5, 'nulla.Integer.urna@malesuadavel.edu', '334-7797 Pede, St.', 'Zamora', 'CL', 'Monaco', '13301', '', '(07381) 3826473', '(051) 45757380', '(08950) 4379741', NULL, 'sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a,', '2015-04-27 08:54:02', '2014-05-27 12:20:26', 'Ivan', 0, '0', '0', '0', '1', '28', '2'),
(49, 'Mr.', 'Rose', 'Melyssa', 'Dean Hubbard', 0, 0, 'USD', 9, 'sed.dictum@Innec.ca', '232-7738 Arcu Ave', 'Port Hope', 'ON', 'Hong Kong', '2296FX', '', '(06995) 2762007', '(06783) 1813332', '(056) 12861064', 0, 'vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet', '2014-12-16 13:39:54', '2014-09-28 14:18:31', 'Blake', 0, '0', '0', '0', '2', '1', '2'),
(50, 'Mrs.', 'Wayne', 'Shana', 'Beau Giles', 0, 0, 'USD', 7, 'at.pretium@Nullainterdum.edu', '604-476 Massa. Avenue', 'Llandrindod Wells', 'Radnorshire', 'Brunei', '16064', '', '(095) 13479568', '(085) 31413560', '(019) 83089367', 0, 'sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing,', '2014-09-22 16:09:28', '2015-01-10 02:57:04', 'John', 0, '0', '0', '0', '2', '1', '1'),
(51, 'Mr.', 'Germaine', 'Lionel', 'Dorian Buchanan', 4, 6, 'USD', 6, 'eget.ipsum.Donec@nectempusscelerisque.org', 'P.O. Box 937, 4558 Et Rd.', 'Langenhagen', 'NI', 'Jamaica', '68852', '', '(0154) 97479727', '(08032) 4267565', '(0843) 41174221', NULL, 'facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis', '2015-05-19 19:52:55', '2014-05-27 12:14:17', 'Gregory', 0, '0', '0', '0', '1', '25', '2'),
(52, '', 'Murphy', 'Ivor', 'Trevor Higgins', 0, 0, 'USD', 8, 'purus.in.molestie@Morbisit.com', '794-200 Cras St.', 'Deventer', 'Overijssel', 'Iceland', '437311', '', '(0525) 12707211', '(05576) 7524958', '(087) 52917521', 0, 'magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem', '2013-10-21 12:34:18', '2015-04-18 17:21:39', 'Harding', 0, '0', '0', '0', '2', '1', '2'),
(53, 'Mr.', 'Rhea', 'Cherokee', 'Salvador Franks', 4, 6, 'USD', 9, 'Donec.est@nonmassa.com', '4430 Pede, St.', 'Rothes', 'MO', 'Ethiopia', '6280OB', '', '(0543) 82158661', '(086) 49200051', '(07193) 4690831', NULL, 'placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia', '2014-12-10 01:48:47', '2014-05-27 12:20:02', 'Francis', 0, '0', '0', '0', '1', '28', '1'),
(54, '', 'Kane', 'Rose', 'Hyatt Mcpherson', 0, 0, 'USD', 5, 'eleifend.nunc.risus@egestas.net', '109-5044 Cras Rd.', 'Kapiti', 'North Island', 'Isle of Man', '61401', '', '(0436) 73321386', '(0253) 01617443', '(0578) 77891654', 1, 'id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus', '2014-04-30 22:51:45', '2014-11-12 13:10:31', 'Silas', 0, '0', '0', '0', '2', '1', '2'),
(55, 'Mr.', 'Florence', 'Uriel', 'Gavin French', 4, 4, 'USD', 6, 'imperdiet.ullamcorper.Duis@milaciniamattis.ca', 'P.O. Box 140, 2510 Ut, Avenue', 'Sandy', 'Utah', 'Denmark', '7551', '', '(09505) 9163783', '(0116) 15635366', '(033712) 586634', NULL, 'ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis. Duis sit amet diam eu', '2014-06-15 18:04:14', '2014-05-27 12:16:48', 'Walter', 0, '0', '0', '0', '1', '24', '1'),
(56, 'Dr.', 'Martin', 'Barclay', 'Thor Daugherty', 4, 8, 'USD', 9, 'adipiscing.Mauris.molestie@sempererat.ca', 'Ap #721-8065 Vitae, Av.', 'Rae Bareli', 'UP', 'Spain', '44752', '', '(065) 84510592', '(033610) 824028', '(02656) 9571897', NULL, 'Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam', '2014-10-18 15:03:29', '2014-05-27 12:16:12', 'Jeremy', 0, '0', '0', '0', '1', '24', '2'),
(57, 'Mr.', 'Noel', 'Chiquita', 'Carson Dunn', 4, 11, 'USD', 9, 'egestas@lorem.com', '6425 Sed Av.', 'Cambridge', 'North Island', 'Malaysia', '8075', '', '(033146) 632131', '(09910) 0211305', '(036728) 071061', NULL, 'sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac', '2014-02-23 17:06:07', '2014-05-27 12:19:19', 'Leroy', 0, '0', '0', '0', '1', '28', '1'),
(58, 'Dr.', 'Indira', 'Brenda', 'Dustin Rios', 0, 0, 'USD', 9, 'Quisque.libero@Namporttitor.edu', '3205 Nullam Rd.', 'Vieste', 'PU', 'Swaziland', '55414', '', '(0638) 43043328', '(030286) 761875', '(0176) 40745652', 1, 'lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames', '2014-12-02 09:15:50', '2013-06-28 02:06:54', 'Gabriel', 0, '0', '0', '0', '2', '1', '2'),
(59, 'Mrs.', 'Denton', 'Eagan', 'Alvin Colon', 4, 2, 'USD', 9, 'ut.pharetra@blanditNam.com', 'P.O. Box 433, 779 Sem, Ave', 'Oosterhout', 'Noord Brabant', 'Swaziland', '9947', '', '(087) 43303251', '(024) 28499455', '(072) 74545936', NULL, 'at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac', '2014-07-07 10:13:44', '2014-05-27 12:20:40', 'Myles', 0, '0', '0', '0', '1', '28', '2'),
(60, 'Mr.', 'Joan', 'Hoyt', 'Joshua Good', 7, 8, 'USD', 8, 'vulputate.risus@quislectus.co.uk', '1504 Vehicula. St.', 'Warren', 'MI', 'Brunei', 'H3H 5K1', 'joan@mailinator.com', '(04361) 6231081', '(094) 14456076', '(05862) 5694542', NULL, 'ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras', '2013-06-30 07:28:20', '2014-06-02 13:31:53', 'Jakeem', 0, '0', '0', '0', '23', '23', '2'),
(61, '', 'Hedwig', 'Pandora', 'Simon Durham', 0, 0, 'USD', 5, 'ac.sem.ut@mattisornare.net', '455-199 Sapien, Rd.', 'Kitchener', 'ON', 'Luxembourg', '2378', '', '(091) 05457804', '(0148) 05985907', '(007) 29100431', 0, 'at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor', '2014-09-13 08:29:00', '2013-07-03 22:12:31', 'Leroy', 0, '0', '0', '0', '2', '1', '2'),
(62, 'Mr.', 'Shea', 'Moses', 'Merritt Parrish', 7, 3, 'USD', 5, 'Morbi@necmalesuada.ca', '2746 Non, Road', 'Vitry-sur-Seine', 'ÃƒÂŽ', 'Sudan', '20810', 'shea@mailinator.com', '(00838) 5509517', '(001) 06627578', '(0927) 98993984', NULL, 'nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet', '2015-02-14 06:01:55', '2014-06-09 15:13:47', 'Scott', 0, '0', '0', '0', '23', '37', '2'),
(63, '', 'Amela', 'Maile', 'Beck Farley', 0, 0, 'USD', 9, 'dolor@Nullam.ca', '934-8695 Fermentum Ave', 'Campinas', 'SP', 'French Polynesia', '935071', '', '(03862) 1636582', '(0471) 76810358', '(056) 19898387', 1, 'Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl', '2014-12-25 06:48:08', '2013-09-17 16:36:21', 'Kadeem', 0, '0', '0', '0', '1', '1', '1'),
(64, '', 'Brady', 'Melodie', 'Louis Parks', 0, 0, 'USD', 7, 'enim@augueSedmolestie.net', 'Ap #445-3731 Ipsum Ave', 'Harlingen', 'Fr', 'Azerbaijan', '31416', '', '(05259) 1636486', '(00422) 2970826', '(00759) 3867654', 0, 'ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue.', '2013-09-17 22:24:10', '2013-08-24 05:11:33', 'Gareth', 0, '0', '0', '0', '1', '1', '1'),
(65, 'Mr.', 'Arsenio', 'Hanna', 'Drew Thompson', 4, 9, 'USD', 5, 'Nulla.interdum.Curabitur@ullamcorpermagna.edu', 'P.O. Box 726, 6570 Nec Avenue', 'San Rafael', 'C', 'Rwanda', 'K8 5ZN', '', '(00793) 6766905', '(03669) 3619058', '(061) 42131006', NULL, 'facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus', '2014-01-07 21:28:05', '2014-05-27 12:15:03', 'Peter', 0, '0', '0', '0', '1', '25', '2'),
(66, '', 'Maggy', 'Martin', 'Chester Dodson', 0, 0, 'USD', 9, 'est@egetmetusIn.edu', '309-7339 Tortor Rd.', 'Ham-sur-Heure-Nalinnes', 'HE', 'Latvia', '58140', '', '(016) 66346768', '(081) 63311947', '(0759) 49036439', 0, 'fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas.', '2015-05-03 00:03:42', '2014-03-22 18:05:25', 'Kieran', 0, '0', '0', '0', '2', '1', '2'),
(67, 'Mrs.', 'Phoebe', 'Diana', 'Trevor Craig', 0, 0, 'USD', 7, 'blandit.mattis.Cras@adipiscing.com', 'P.O. Box 252, 6967 Dui Av.', 'Vienna', 'Vienna', 'French Guiana', '25051', '', '(06679) 3580336', '(0771) 93952232', '(032417) 835843', 0, 'imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna.', '2014-10-30 16:55:50', '2014-12-18 00:13:13', 'Edward', 0, '0', '0', '0', '1', '1', '1'),
(68, 'Mr.', 'Dora', 'Camden', 'Lucas Gallagher', 0, 0, 'USD', 5, 'pellentesque.massa.lobortis@velquamdignissim.com', 'P.O. Box 313, 3717 Vel Road', 'Neu-Ulm', 'BY', 'Malta', '84132', '', '(01601) 4594812', '(0054) 96860599', '(0658) 32950621', 0, 'gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', '2014-01-25 12:03:52', '2014-06-15 12:04:11', 'Elijah', 0, '0', '0', '0', '2', '1', '2'),
(69, '', 'Rinah', 'Bradley', 'Brent Kidd', 0, 0, 'USD', 8, 'Sed.molestie@iderat.org', '2193 Sed St.', 'Colombes', 'ÃƒÂŽle-de-France', 'Saint BarthÃƒÂ©lemy', '43602-462', '', '(034) 28291322', '(089) 61520793', '(032518) 351119', 1, 'aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,', '2014-11-19 13:22:50', '2013-07-23 06:23:36', 'Brennan', 0, '0', '0', '0', '2', '1', '1'),
(70, 'Mr.', 'Petra', 'Sade', 'Chester Mayer', 0, 0, 'USD', 9, 'odio.a.purus@FuscemollisDuis.ca', '2034 Et St.', 'Agra', 'Uttar Pradesh', 'Latvia', '73189', '', '(038163) 583487', '(07913) 0720675', '(0434) 82232878', 0, 'ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend.', '2013-12-27 01:44:14', '2014-07-27 07:13:56', 'Kenneth', 0, '0', '0', '0', '2', '1', '1'),
(71, 'Mr.', 'Kenyon', 'Sebastian', 'Jonah Christensen', 0, 0, 'USD', 8, 'ornare.sagittis@arcuimperdietullamcorper.ca', '7084 Nulla Street', 'Lincoln', 'NE', 'Serbia', '46778-449', '', '(067) 69856541', '(03764) 2395769', '(033281) 023678', 0, 'semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus.', '2015-01-05 22:54:11', '2014-11-28 15:43:17', 'Myles', 0, '0', '0', '0', '2', '1', '2'),
(72, 'Ms.', 'Kathleen', 'Tate', 'Kennedy Garza', 0, 0, 'USD', 7, 'Aliquam.tincidunt@Maurismolestie.org', 'P.O. Box 231, 5467 Non St.', 'Coldstream', 'British Columbia', 'Haiti', '10190', '', '(033417) 806769', '(033835) 910505', '(079) 08735180', 0, 'eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque', '2014-05-13 02:30:40', '2013-10-01 05:02:49', 'Samson', 0, '0', '0', '0', '2', '1', '2'),
(73, 'Mr.', 'Miriam', 'Lucas', 'Baker Meadows', 0, 0, 'USD', 8, 'Duis.risus.odio@famesac.org', 'P.O. Box 481, 2956 Aptent Rd.', 'Feilding', 'North Island', 'Swaziland', '46668', '', '(02524) 7354102', '(043) 07871422', '(04244) 9189282', 0, 'vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum.', '2015-04-26 19:07:27', '2013-06-18 23:26:55', 'Zeph', 0, '0', '0', '0', '2', '1', '1'),
(74, 'Dr.', 'Solomon', 'Bertha', 'Orson Henderson', 4, 0, 'USD', 5, 'pellentesque.Sed.dictum@malesuadaaugue.co.uk', 'P.O. Box 687, 9424 Eleifend St.', 'RibeirÃƒÂ£o Preto', 'SP', 'Macao', '2685', '', '(0134) 70767788', '(086) 07783677', '(0546) 13241930', NULL, 'elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum', '2014-11-08 21:05:24', '2014-05-29 05:41:39', 'Francis', 0, '0', '0', '0', '1', '1', '2'),
(75, 'Mrs.', 'Rylee', 'Gabriel', 'Nolan Koch', 0, 0, 'USD', 7, 'Etiam.imperdiet.dictum@nuncsit.edu', 'P.O. Box 848, 4767 Volutpat. Road', 'Cumberland', 'Ontario', 'Palau', '24760-909', '', '(029) 70113436', '(099) 81325507', '(036639) 599077', 1, 'ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue.', '2014-09-17 20:59:15', '2014-10-03 15:27:09', 'George', 0, '0', '0', '0', '1', '1', '1'),
(76, 'Ms.', 'Martha', 'Dara', 'Griffin Moses', 0, 0, 'USD', 7, 'eu.dui.Cum@laciniavitae.com', 'P.O. Box 672, 8080 Lacus. Rd.', 'Huesca', 'AragÃƒÂ³n', 'Malaysia', '6878MO', '', '(01998) 9296809', '(0070) 77993782', '(0849) 88037563', 0, 'Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.', '2014-12-21 04:54:22', '2015-02-17 12:35:05', 'Knox', 0, '0', '0', '0', '1', '1', '1'),
(77, 'Ms.', 'Isabella', 'Aphrodite', 'Odysseus Mcpherson', 0, 0, 'USD', 6, 'augue.scelerisque@CurabiturmassaVestibulum.co.uk', '744-9479 Nec, Rd.', 'Liberia', 'Guanacaste', 'Belize', '5008', '', '(092) 94911206', '(022) 92565423', '(09210) 8647289', 1, 'id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque', '2013-12-12 04:27:36', '2014-04-30 22:50:49', 'Harlan', 0, '0', '0', '0', '1', '1', '2'),
(78, 'Dr.', 'Dai', 'Lunea', 'Gabriel Peterson', 0, 0, 'USD', 9, 'Integer.eu.lacus@Vestibulumanteipsum.ca', '1159 Curae; Street', 'Smithers', 'British Columbia', 'Jersey', '6856FW', '', '(035410) 765369', '(068) 18946051', '(030484) 361368', 1, 'eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis', '2015-03-04 01:13:05', '2014-07-12 19:08:24', 'David', 0, '0', '0', '0', '2', '1', '2'),
(79, '', 'Odette', 'Bethany', 'Finn Brooks', 0, 0, 'USD', 5, 'consectetuer.adipiscing.elit@quisturpisvitae.co.uk', '842-8836 Quam Ave', 'Lithgow', 'NS', 'Tanzania', '47071', '', '(078) 52408428', '(087) 30085484', '(0808) 97996661', 0, 'vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit', '2013-10-11 20:07:39', '2013-08-13 21:17:47', 'Alden', 0, '0', '0', '0', '1', '1', '1'),
(80, 'Mrs.', 'Melissa', 'Griffin', 'Holmes Mayo', 4, 10, 'USD', 6, 'Duis@velitin.ca', 'Ap #675-2487 Faucibus Avenue', 'Vorst', 'Antwerpen', 'Armenia', '1174', '', '(032871) 864342', '(00473) 5100089', '(07838) 3588667', NULL, 'Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo.', '2014-04-25 13:52:59', '2014-05-27 15:09:37', 'Ferris', 0, '0', '0', '0', '1', '29', '2'),
(81, 'Ms.', 'Bruce', 'Buckminster', 'Lev Hooper', 0, 0, 'USD', 8, 'luctus.sit.amet@lacuspedesagittis.com', 'P.O. Box 516, 7771 Nisl. St.', 'Lower Hutt', 'North Island', 'Kiribati', '61416', '', '(0468) 95323533', '(034) 56928969', '(091) 66856318', 1, 'odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec,', '2013-05-29 07:39:16', '2015-02-07 14:04:14', 'Hilel', 0, '0', '0', '0', '2', '1', '1'),
(82, 'Mr.', 'Chava', 'Dieter', 'Lawrence Castillo', 0, 0, 'USD', 9, 'neque@posuereatvelit.com', '471-6901 Odio. Street', 'Duluth', 'MN', 'Turkmenistan', '8552', '', '(090) 32349654', '(025) 57525567', '(05900) 5165733', 1, 'Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus', '2013-07-22 21:21:22', '2013-06-29 06:01:30', 'Logan', 0, '0', '0', '0', '2', '1', '1'),
(83, '', 'Xaviera', 'Jacqueline', 'Raphael Barrett', 0, 0, 'USD', 9, 'congue@ametluctusvulputate.net', '9369 Accumsan Ave', 'Campinas', 'SÃƒÂ£o Paulo', 'South Africa', '41001', '', '(079) 27525095', '(037) 40847301', '(032124) 802711', 0, 'semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet', '2013-07-13 03:27:38', '2013-11-07 11:12:31', 'Griffith', 0, '0', '0', '0', '1', '1', '1'),
(84, 'Mr.', 'Adena', 'Vance', 'Fuller Miles', 0, 0, 'USD', 9, 'ante.dictum.mi@morbitristique.org', 'Ap #511-6945 Nec Street', 'Langley', 'BC', 'Bolivia', '3126', '', '(0957) 86499563', '(02695) 9435021', '(07239) 9057221', 1, 'quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem', '2014-10-07 15:27:13', '2014-09-28 16:38:20', 'Jin', 0, '0', '0', '0', '1', '1', '1'),
(85, 'Mr.', 'Elliott', 'Barrett', 'Neville Leon', 4, 9, 'USD', 8, 'bibendum.Donec@NullafacilisisSuspendisse.com', 'Ap #583-2330 Non, Avenue', 'Owen Sound', 'Ontario', 'British Indian Ocean Territory', '6183PJ', '', '(088) 40979089', '(036091) 992952', '(030) 65241903', NULL, 'cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel,', '2014-08-16 16:59:03', '2014-05-27 15:09:13', 'Neville', 0, '0', '0', '0', '1', '29', '2'),
(86, 'Mr.', 'Hilda', 'Lee', 'Isaiah Jenkins', 0, 0, 'USD', 8, 'sodales.purus@mollisvitae.com', 'P.O. Box 992, 5374 Neque Road', 'Vienna', 'Vienna', 'Trinidad and Tobago', '6181', '', '(0805) 88785292', '(093) 96433431', '(01042) 4509422', 1, 'quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra', '2015-04-24 14:38:59', '2013-05-31 04:39:16', 'Reese', 0, '0', '0', '0', '2', '1', '2'),
(87, '', 'Hayfa', 'Chava', 'Jermaine Heath', 0, 0, 'USD', 9, 'cursus@malesuadavel.co.uk', '547 Enim Street', 'RibeirÃƒÂ£o Preto', 'SÃƒÂ£o Paulo', 'Bonaire, Sint Eustatius and Saba', '18437', '', '(031896) 038913', '(08159) 1660497', '(036817) 619329', 1, 'faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque', '2015-04-13 21:23:45', '2014-04-02 06:16:01', 'Ronan', 0, '0', '0', '0', '2', '1', '1'),
(88, 'Dr.', 'Baxter', 'Galena', 'Ulysses Patrick', 0, 0, 'USD', 5, 'imperdiet.ullamcorper.Duis@erat.net', '3490 Ac Rd.', 'Kota', 'RJ', 'Mexico', '47748', '', '(056) 50923525', '(04206) 9290003', '(037249) 180493', 1, 'risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce', '2014-10-17 15:12:05', '2014-07-06 22:30:17', 'Trevor', 0, '0', '0', '0', '2', '1', '2'),
(89, 'Dr.', 'Quintessa', 'Jarrod', 'Wing Lewis', 0, 0, 'USD', 7, 'Sed@sem.edu', '6132 A, St.', 'Erie', 'Pennsylvania', 'Korea, South', 'B01 1AQ', '', '(08789) 7529454', '(067) 96602138', '(032025) 170555', 1, 'urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet,', '2014-05-07 17:00:42', '2014-04-08 13:49:23', 'Emery', 0, '0', '0', '0', '1', '1', '1'),
(90, 'Dr.', 'Octavia', 'Moses', 'Caldwell Sanchez', 0, 0, 'USD', 5, 'orci.adipiscing@arcuSed.com', '5246 Viverra. St.', 'Upper Hutt', 'North Island', 'Guam', '40423', '', '(030447) 816949', '(0322) 19417977', '(030329) 211559', 0, 'tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla', '2014-01-12 17:33:47', '2014-09-24 07:18:09', 'Cameron', 0, '0', '0', '0', '2', '1', '1'),
(91, 'Mrs.', 'Kai', 'Blaze', 'Wesley Carter', 0, 0, 'USD', 8, 'eu.lacus.Quisque@dui.net', 'P.O. Box 980, 6504 Nisl. Road', 'Rocca San Felice', 'Campania', 'Lebanon', '39661', '', '(030565) 031481', '(036486) 729166', '(006) 12676328', 1, 'et ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem,', '2013-11-18 21:38:50', '2013-06-19 14:59:33', 'Erasmus', 0, '0', '0', '0', '2', '1', '1'),
(92, 'Mr.', 'Virginia', 'Mira', 'Aidan Gray', 0, 0, 'USD', 7, 'mauris.Integer@dolor.net', 'P.O. Box 735, 7088 Gravida Street', 'Winterswijk', 'Gl', 'Niger', '9371', '', '(031650) 661411', '(034566) 391250', '(009) 48309668', 1, 'at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum', '2015-01-06 06:29:12', '2014-10-16 18:02:26', 'Craig', 0, '0', '0', '0', '2', '1', '1'),
(93, 'Mr.', 'Suki', 'Nora', 'Ivor Emerson', 4, 3, 'USD', 8, 'pede.ac@egetvolutpatornare.com', 'Ap #121-1544 Odio St.', 'Palencia', 'Castilla y LeÃƒÂ³n', 'Azerbaijan', 'S9S 3S2', '', '(0131) 29887471', '(0711) 81311069', '(0318) 71436067', NULL, 'malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis.', '2013-12-07 01:06:49', '2014-05-27 15:09:26', 'Chancellor', 0, '0', '0', '0', '1', '29', '1'),
(94, 'Dr.', 'Ariana', 'Lila', 'Jerry Boone', 0, 0, 'USD', 8, 'suscipit.est.ac@varius.ca', 'P.O. Box 917, 1273 Parturient Rd.', 'Presteigne', 'RA', 'Burundi', '81859', '', '(0121) 38859578', '(033418) 333397', '(076) 12827188', 0, 'Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit.', '2014-12-14 15:08:26', '2014-05-17 09:21:51', 'Hilel', 0, '0', '0', '0', '2', '1', '2'),
(95, '', 'Aimee', 'Ifeoma', 'Hu Carver', 0, 0, 'USD', 7, 'justo.Praesent@pedemalesuadavel.edu', 'P.O. Box 200, 2826 Vestibulum Ave', 'Berlin', 'Berlin', 'American Samoa', '834912', '', '(0371) 45051330', '(033730) 546103', '(037627) 297367', 0, 'egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis', '2014-03-19 07:45:52', '2015-02-24 07:38:52', 'Peter', 0, '0', '0', '0', '1', '1', '1'),
(96, '', 'Dennis', 'Rajah', 'Nolan Lott', 0, 0, 'USD', 7, 'sed@id.co.uk', 'P.O. Box 421, 195 Dictum St.', 'San JosÃƒÂ© de Alajuela', 'Alajuela', 'Tonga', '7411', '', '(0670) 90599403', '(0833) 21775672', '(0426) 81029797', 0, 'nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit', '2013-09-04 20:52:48', '2013-07-25 06:44:41', 'Noble', 0, '0', '0', '0', '2', '1', '2'),
(97, 'Mrs.', 'Quamar', 'Owen', 'Damon Mclean', 0, 0, 'USD', 7, 'non.hendrerit@adipiscingfringilla.net', '491-6857 Sed Street', 'Lithgow', 'NS', 'Seychelles', 'HG1 2ZH', '', '(09244) 6722310', '(05728) 5664147', '(0771) 17226288', 1, 'Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus', '2013-07-28 05:12:14', '2014-06-24 18:08:18', 'Kieran', 0, '0', '0', '0', '1', '1', '1'),
(98, '', 'Wyatt', 'Samuel', 'Channing Puckett', 0, 0, 'USD', 5, 'sit.amet.risus@ridiculusmus.edu', '1618 Phasellus Avenue', 'Mission', 'British Columbia', 'Cook Islands', '1566', '', '(02941) 1432880', '(056) 82366968', '(053) 48375574', 1, 'varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem', '2014-12-29 07:01:50', '2013-10-25 12:05:59', 'Josiah', 0, '0', '0', '0', '1', '1', '2'),
(99, '', 'Signe', 'Cameron', 'Matthew Moran', 0, 0, 'USD', 8, 'Duis@feugiat.edu', 'Ap #985-8563 Primis Ave', 'B.S.D.', 'Luik', 'Timor-Leste', '30810', '', '(02342) 0168745', '(00640) 5266494', '(031) 40506312', 0, 'In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant', '2014-08-22 03:45:04', '2013-12-26 05:32:26', 'Kane', 0, '0', '0', '0', '1', '1', '1'),
(100, '', 'Norman', 'Lance', 'Theodore Hines', 0, 0, 'USD', 6, 'et.lacinia@lectusasollicitudin.net', '3415 Aliquam St.', 'TorrejÃƒÂ³n de Ardoz', 'Madrid', 'Monaco', '32194', '', '(0559) 27419129', '(032545) 665883', '(0385) 06496807', 1, 'mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac', '2014-12-09 16:30:15', '2015-04-30 13:21:49', 'Knox', 0, '0', '0', '0', '2', '1', '2'),
(101, 'Mr.', 'Roger', 'Decosta', 'roger pinto', 7, 1, 'USD', 1000, 'www.roger.com', 'Bouwmeestershoeve 28', 'Apeldoorn', 'RR', 'Netherland', '7632', 'roger@yahoo.com', '020254678912', NULL, NULL, NULL, 'Cras vehicula velit vitae nunc convallis eleifend. Fusce vel enim viverra fusce.', '2014-06-09 14:54:49', '2014-06-09 14:58:48', '', 0, NULL, NULL, NULL, '23', '37', '37'),
(102, 'Mr.', 'Walt de', 'Vente', 'Walt de', 7, 1, 'USD', 0, 'test.com', 'Voorsterweg 175', 'Brummen', 'GM', 'Netherlands', '6971', 'waltdevente@mailinator.com', '0637027249', NULL, NULL, 0, 'Fusce sagittis eu libero eget gravida. Sed fermentum luctus nibh, et massa nunc.', '2014-06-10 15:51:49', NULL, NULL, 0, NULL, NULL, NULL, '23', NULL, '23'),
(103, 'Mr.', 'Merlijn', 'Ouwendijk', 'Merlijn Best', 7, 1, 'USD', 0, '', 'Deldensestraat 67', 'Nijverdal', 'KV', 'Netherlands', '7441', 'merlijn@mailinator.com', '0636824371', NULL, NULL, NULL, 'Donec nec ligula dignissim dolor ultrices molestie. Aliquam ut orci in volutpat.', '2014-06-10 16:36:02', '2014-06-10 16:36:40', '', 0, NULL, NULL, NULL, '23', '23', '23'),
(104, 'Mr.', 'Jimme', 'Bruines', 'Jimme Boss', 7, 1, 'USD', 0, 'test.com', 'Pastoor Jacobsstraat 56', 'Deurne', 'JE', 'Netherlands', '5751', 'bimmebruines@mailinator.com', '0665283619', NULL, NULL, NULL, 'Maecenas in urna laoreet, aliquet ipsum eget, tristique leo. Vivamus quis metus.', '2014-06-10 16:52:06', '2014-06-10 16:53:23', 'Good Times', 0, NULL, NULL, NULL, '23', '23', '23'),
(105, 'Mr.', 'Manasse', 'Hove', 'Manasse', 7, 1, 'USD', 0, 'test.com', 'Spekloane 123', 'Boelenslaan', 'LK', 'Netherlands', '9233', 'manassevanhove@mailinator.com', '0683894178', NULL, NULL, NULL, 'Phasellus elementum ornare leo, in hendrerit ligula fringilla sed. Duis posuere.', '2014-06-10 18:34:31', '2014-06-10 18:54:33', '', 0, NULL, NULL, NULL, '23', '23', '23'),
(106, 'Mr.', 'Justus', 'Sheikh', 'The Justus', 4, 1, 'USD', 0, 'www.test.com', 'Via Raffaele Conforti, 87', 'Castel Di Sangro', 'AQ', 'Netherlands', '67031', 'justussheikh@mailinator.com', '03571770063', NULL, NULL, NULL, 'Proin non lacus cursus, dictum urna ac, placerat nunc. Curabitur in quam nullam.', '2014-06-10 18:59:41', '2014-06-11 15:27:12', 'On Cue', 0, NULL, NULL, NULL, '23', '23', '23'),
(107, 'Mr.', 'Frenk', 'Hendrix', 'The Frenk', 4, 1, 'USD', 0, 'test.com', 'IJsselstraat 195', 'IJsselstein', 'DK', 'Netherlands', '3401', 'frenkhendrix@mailinator.com', '0657295416', NULL, NULL, 0, 'Maecenas luctus dolor at diam ornare lacinia. Pellentesque adipiscing cras amet.', '2014-06-11 11:57:31', NULL, NULL, 0, NULL, NULL, NULL, '23', NULL, '23'),
(108, 'Mr.', 'Janice', 'Lee', 'JaniceCLee', 3, 1, 'USD', 0, 'http://JaniceCLee.com', '1022 Sweetwood Drive', 'Denver', 'CO', 'Netherland', '80220', 'JaniceCLee@mailinator.com', NULL, NULL, NULL, 0, 'Logged in users can view full social security numbers and can save their fake names to use later.', '2014-06-18 16:36:12', NULL, NULL, 0, NULL, NULL, NULL, '23', NULL, '1');
INSERT INTO `leads` (`id`, `salutation_name`, `first_name`, `last_name`, `title`, `status`, `source`, `opportunity_amount_currency`, `opportunity_amount`, `website`, `address_street`, `address_city`, `address_state`, `address_country`, `address_postal_code`, `email_address`, `phone`, `fax`, `phone_office`, `do_not_call`, `description`, `created_at`, `modified_at`, `account_name`, `deleted`, `created_opportunity_id`, `created_contact_id`, `created_account_id`, `assigned_user_id`, `modified_by_id`, `created_by_id`) VALUES
(109, 'Mrs.', 'Marie', 'Dollar', 'MarieCDollar', 3, 1, 'USD', 0, 'http://MarieCDollar.com', '2203 Birch Street', 'Brownsburg', 'IN', 'Netherland', '46112', 'MarieCDollar@mailinator.com', NULL, NULL, NULL, 0, 'Logged in users can view full social security numbers and can save their fake names to use later.', '2014-06-18 16:39:18', NULL, NULL, 0, NULL, NULL, NULL, '23', NULL, '1'),
(110, 'Dr.', 'Gregory', 'Ayers', 'GregoryPAyers', 2, 1, 'USD', 0, 'http://GregoryPAyers.us', '1424 Freedom Lane', 'Modesto', 'CA', 'Netherland', '95354', 'GregoryPAyers@mailinator.us', NULL, NULL, NULL, 0, 'Logged in users can view full social security numbers and can save their fake names to use later.', '2014-06-18 16:43:57', NULL, NULL, 0, NULL, NULL, NULL, '23', NULL, '1'),
(111, 'Dr.', 'Gregory', 'Ayers', 'GregoryPAyers', 7, 1, 'USD', 0, 'http://GregoryPAyers.us', '1424 Freedom Lane', 'Modesto', 'CA', 'Netherland', '95354', 'GregoryPAyers@mailinator.us', NULL, NULL, NULL, 0, 'Logged in users can view full social security numbers and can save their fake names to use later.', '2014-06-18 16:45:53', '2014-06-18 17:39:47', 'Joe', 0, NULL, NULL, NULL, '23', '1', '1'),
(112, 'Mrs.', 'Tatjana', 'Steur', 'TatjanaSteur', 7, 1, 'USD', 0, 'http://TatjanaSteur.com', 'Pieter Jacobus Oudstraat 139', 'Papendrecht', 'VE', 'Netherlands', '3354', 'TatjanaSteur@armyspy.com', '2147483647', NULL, NULL, NULL, 'Logged in users can view full social security numbers and can save their fake names to use later.', '2014-06-18 17:37:40', '2014-06-18 18:31:00', 'Elmo', 0, NULL, NULL, NULL, '23', '1', '1'),
(113, 'Mr.', 'Test', 'Sdfsf', 'TatjanaSteur', 1, 1, NULL, NULL, 'http://TatjanaSteur.com', 'Pieter Jacobus Oudstraat 139', 'Papendrecht', 'VE', 'Netherlands', '3354', 'TatjanaSteur@armyspy.com', NULL, NULL, NULL, 0, 'Praesent venenatis metus at', '2014-07-03 19:36:11', NULL, 'sdfsfd', 0, NULL, NULL, NULL, '23', NULL, '23');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `signin_time` datetime NOT NULL,
  `signout_time` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `sign_out_by_system` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `login_id`, `signin_time`, `signout_time`, `description`, `ip_address`, `status`, `sign_out_by_system`) VALUES
(1, 24, '2014-05-28 16:25:50', '2014-05-28 16:26:07', '', '127.0.0.1', 0, NULL),
(2, 24, '2014-05-28 16:28:10', '2014-05-28 16:28:26', '', '127.0.0.1', 0, NULL),
(3, 24, '2014-05-28 16:28:46', '2014-05-28 17:01:14', '', '127.0.0.1', 0, NULL),
(4, 24, '2014-05-28 17:01:19', '2014-05-28 17:08:56', '', '127.0.0.1', 0, NULL),
(5, 28, '2014-05-28 17:09:09', '2014-05-28 17:10:17', '', '127.0.0.1', 0, NULL),
(6, 25, '2014-05-28 17:10:24', '2014-05-28 17:12:12', '', '127.0.0.1', 0, NULL),
(7, 1, '2014-05-28 17:14:13', '2014-05-28 18:02:20', '', '127.0.0.1', 0, NULL),
(8, 1, '2014-05-28 17:55:35', '2014-05-28 17:55:35', '', '192.168.0.34', 1, NULL),
(9, 1, '2014-05-28 18:02:30', '2014-05-28 18:02:37', '', '127.0.0.1', 0, NULL),
(10, 1, '2014-05-28 18:02:45', '2014-05-28 18:59:00', '', '127.0.0.1', 0, NULL),
(11, 0, '2014-05-28 18:59:05', '2014-05-28 18:59:05', '', '127.0.0.1', 1, NULL),
(12, 24, '2014-05-28 18:59:10', '2014-05-28 18:59:10', '', '127.0.0.1', 1, NULL),
(13, 1, '2014-05-29 04:54:18', '2014-05-29 04:54:18', '', '103.8.194.105', 1, NULL),
(14, 1, '2014-05-29 05:03:19', '2014-05-29 05:03:19', '', '103.8.194.105', 1, NULL),
(15, 1, '2014-05-29 05:04:16', '2014-05-29 05:04:16', '', '103.8.194.105', 1, NULL),
(16, 1, '2014-05-29 05:04:48', '2014-05-29 05:04:48', '', '103.8.194.105', 1, NULL),
(17, 1, '2014-05-29 05:05:18', '2014-05-29 05:05:18', '', '103.8.194.105', 1, NULL),
(18, 1, '2014-05-29 05:05:36', '2014-05-29 05:05:36', '', '103.8.194.105', 1, NULL),
(19, 1, '2014-05-29 05:06:00', '2014-05-29 05:06:00', '', '103.8.194.105', 1, NULL),
(20, 1, '2014-05-29 05:07:21', '2014-05-29 05:07:21', '', '103.8.194.105', 1, NULL),
(21, 0, '2014-05-29 05:08:17', '2014-05-29 05:08:17', '', '103.8.194.105', 1, NULL),
(22, 1, '2014-05-29 05:09:22', '2014-05-29 05:09:22', '', '103.8.194.105', 1, NULL),
(23, 1, '2014-05-29 05:10:05', '2014-05-29 05:37:54', '', '103.8.194.105', 0, NULL),
(24, 1, '2014-05-29 05:37:34', '2014-05-29 05:37:34', '', '49.248.146.42', 1, NULL),
(25, 1, '2014-05-29 05:40:17', '2014-05-29 05:40:17', '', '103.8.194.105', 1, NULL),
(26, 1, '2014-05-29 17:55:50', '2014-05-29 17:55:50', '', '127.0.0.1', 1, NULL),
(27, 1, '2014-05-29 18:57:54', '2014-05-29 18:57:54', '', '127.0.0.1', 1, NULL),
(28, 1, '2014-05-30 10:12:48', '2014-05-30 10:12:48', '', '127.0.0.1', 1, NULL),
(29, 1, '2014-05-30 10:37:11', '2014-05-30 10:37:11', '', '127.0.0.1', 1, NULL),
(30, 1, '2014-05-30 10:49:06', '2014-05-30 10:49:06', '', '127.0.0.1', 1, NULL),
(31, 1, '2014-05-30 13:06:43', '2014-05-30 13:06:43', '', '192.168.0.32', 1, NULL),
(32, 1, '2014-05-30 16:06:30', '2014-05-30 16:06:30', '', '127.0.0.1', 1, NULL),
(33, 1, '2014-05-30 18:26:12', '2014-05-30 18:26:12', '', '127.0.0.1', 1, NULL),
(36, 1, '2014-06-02 12:11:42', '2014-06-02 12:13:10', '', '127.0.0.1', 0, NULL),
(37, 1, '2014-06-02 12:13:13', '2014-06-02 12:13:13', '', '127.0.0.1', 1, NULL),
(38, 1, '2014-06-02 12:39:24', '2014-06-02 12:42:56', '', '127.0.0.1', 0, NULL),
(39, 1, '2014-06-02 12:43:01', '2014-06-02 12:43:04', '', '127.0.0.1', 0, NULL),
(40, 23, '2014-06-02 12:43:08', '2014-06-02 12:43:08', '', '127.0.0.1', 1, NULL),
(41, 1, '2014-06-02 14:50:10', '2014-06-02 14:50:10', '', '127.0.0.1', 1, NULL),
(42, 1, '2014-06-02 15:53:30', '2014-06-02 15:53:30', '', '192.168.0.34', 1, NULL),
(43, 1, '2014-06-09 11:00:37', '2014-06-09 11:00:37', '', '127.0.0.1', 1, NULL),
(44, 35, '2014-06-09 14:25:50', '2014-06-09 14:27:51', '', '127.0.0.1', 0, NULL),
(45, 35, '2014-06-09 14:30:00', '2014-06-09 14:50:46', '', '127.0.0.1', 0, NULL),
(46, 1, '2014-06-09 14:50:50', '2014-06-09 14:52:56', '', '127.0.0.1', 0, NULL),
(47, 37, '2014-06-09 14:53:02', '2014-06-09 15:26:57', '', '127.0.0.1', 0, NULL),
(48, 23, '2014-06-09 15:27:02', '2014-06-09 15:27:02', '', '127.0.0.1', 1, NULL),
(49, 1, '2014-06-09 16:33:32', '2014-06-09 17:05:50', '', '127.0.0.1', 0, NULL),
(50, 1, '2014-06-09 17:05:52', '2014-06-09 17:05:52', '', '127.0.0.1', 1, NULL),
(51, 1, '2014-06-10 11:30:57', '2014-06-10 11:30:57', '', '127.0.0.1', 1, NULL),
(52, 1, '2014-06-10 12:51:10', '2014-06-10 12:51:10', '', '127.0.0.1', 1, NULL),
(53, 0, '2014-06-10 13:53:22', '2014-06-10 13:53:22', '', '127.0.0.1', 1, NULL),
(54, 1, '2014-06-10 13:53:29', '2014-06-10 14:58:01', '', '127.0.0.1', 0, NULL),
(55, 1, '2014-06-10 14:18:25', '2014-06-10 14:18:25', '', '127.0.0.1', 1, NULL),
(56, 0, '2014-06-10 14:58:25', '2014-06-10 14:58:25', '', '127.0.0.1', 1, NULL),
(57, 0, '2014-06-10 14:58:36', '2014-06-10 14:58:36', '', '127.0.0.1', 1, NULL),
(58, 23, '2014-06-10 14:59:11', '2014-06-10 14:59:11', '', '127.0.0.1', 1, NULL),
(59, 1, '2014-06-10 17:06:04', '2014-06-10 17:06:04', '', '127.0.0.1', 1, NULL),
(60, 23, '2014-06-10 18:25:16', '2014-06-10 18:25:16', '', '127.0.0.1', 1, NULL),
(61, 1, '2014-06-11 10:32:26', '2014-06-11 10:32:26', '', '127.0.0.1', 1, NULL),
(62, 1, '2014-06-11 11:42:19', '2014-06-11 11:42:19', '', '127.0.0.1', 1, NULL),
(63, 23, '2014-06-11 11:42:56', '2014-06-11 11:42:56', '', '127.0.0.1', 1, NULL),
(64, 1, '2014-06-11 12:12:20', '2014-06-11 12:12:20', '', '127.0.0.1', 1, NULL),
(65, 23, '2014-06-11 14:04:17', '2014-06-11 14:04:17', '', '127.0.0.1', 1, NULL),
(66, 23, '2014-06-11 14:48:19', '2014-06-11 14:48:19', '', '127.0.0.1', 1, NULL),
(67, 1, '2014-06-11 15:03:54', '2014-06-11 15:03:54', '', '127.0.0.1', 1, NULL),
(68, 1, '2014-06-11 17:29:41', '2014-06-11 17:29:41', '', '127.0.0.1', 1, NULL),
(69, 1, '2014-06-11 18:52:12', '2014-06-11 18:52:12', '', '127.0.0.1', 1, NULL),
(70, 1, '2014-06-12 10:37:41', '2014-06-12 10:37:41', '', '127.0.0.1', 1, NULL),
(71, 1, '2014-06-12 12:46:34', '2014-06-12 12:46:34', '', '127.0.0.1', 1, NULL),
(72, 1, '2014-06-12 14:44:43', '2014-06-12 14:44:43', '', '127.0.0.1', 1, NULL),
(73, 1, '2014-06-13 10:35:49', '2014-06-13 10:35:49', '', '127.0.0.1', 1, NULL),
(74, 1, '2014-06-13 14:24:19', '2014-06-13 14:24:19', '', '127.0.0.1', 1, NULL),
(75, 1, '2014-06-16 10:43:44', '2014-06-16 10:43:44', '', '127.0.0.1', 1, NULL),
(76, 1, '2014-06-16 12:59:30', '2014-06-16 12:59:30', '', '127.0.0.1', 1, NULL),
(77, 1, '2014-06-16 14:26:48', '2014-06-16 14:26:48', '', '127.0.0.1', 1, NULL),
(78, 1, '2014-06-16 16:36:55', '2014-06-16 16:36:55', '', '127.0.0.1', 1, NULL),
(79, 1, '2014-06-17 10:44:44', '2014-06-17 10:44:44', '', '127.0.0.1', 1, NULL),
(80, 1, '2014-06-17 12:03:40', '2014-06-17 12:03:40', '', '127.0.0.1', 1, NULL),
(81, 1, '2014-06-17 12:40:59', '2014-06-17 12:40:59', '', '127.0.0.1', 1, NULL),
(82, 1, '2014-06-17 17:28:48', '2014-06-17 17:28:48', '', '127.0.0.1', 1, NULL),
(83, 1, '2014-06-18 12:56:28', '2014-06-18 12:56:28', '', '127.0.0.1', 1, NULL),
(84, 1, '2014-06-18 15:50:40', '2014-06-18 15:50:40', '', '127.0.0.1', 1, NULL),
(85, 1, '2014-06-19 10:48:40', '2014-06-19 10:48:40', '', '127.0.0.1', 1, NULL),
(86, 1, '2014-06-19 14:46:26', '2014-06-19 14:46:26', '', '127.0.0.1', 1, NULL),
(87, 1, '2014-06-19 17:44:42', '2014-06-19 17:50:17', '', '127.0.0.1', 0, NULL),
(88, 23, '2014-06-19 17:50:31', '2014-06-19 17:50:31', '', '127.0.0.1', 1, NULL),
(89, 1, '2014-06-20 10:29:19', '2014-06-20 10:29:19', '', '127.0.0.1', 1, NULL),
(90, 1, '2014-06-20 16:40:35', '2014-06-20 17:11:45', '', '127.0.0.1', 0, NULL),
(91, 23, '2014-06-20 17:11:55', '2014-06-20 17:11:55', '', '127.0.0.1', 1, NULL),
(92, 1, '2014-06-20 19:32:57', '2014-06-20 19:32:57', '', '127.0.0.1', 1, NULL),
(93, 1, '2014-06-23 10:35:19', '2014-06-23 10:35:19', '', '127.0.0.1', 1, NULL),
(94, 1, '2014-06-23 11:21:32', '2014-06-23 11:21:32', '', '127.0.0.1', 1, NULL),
(95, 1, '2014-06-23 14:02:55', '2014-06-23 15:15:51', '', '127.0.0.1', 0, NULL),
(96, 23, '2014-06-23 15:16:08', '2014-06-23 15:16:08', '', '127.0.0.1', 1, NULL),
(97, 1, '2014-06-24 10:09:29', '2014-06-24 10:09:29', '', '127.0.0.1', 1, NULL),
(98, 1, '2014-06-24 11:39:44', '2014-06-24 11:39:44', '', '127.0.0.1', 1, NULL),
(99, 1, '2014-06-24 14:15:13', '2014-06-24 14:15:13', '', '127.0.0.1', 1, NULL),
(100, 1, '2014-06-24 15:59:34', '2014-06-24 15:59:34', '', '127.0.0.1', 1, NULL),
(101, 1, '2014-06-24 17:49:00', '2014-06-24 17:49:00', '', '127.0.0.1', 1, NULL),
(102, 1, '2014-06-25 10:32:42', '2014-06-25 10:32:42', '', '127.0.0.1', 1, NULL),
(103, 1, '2014-06-25 10:32:42', '2014-06-25 10:32:42', '', '127.0.0.1', 1, NULL),
(104, 1, '2014-06-25 12:49:20', '2014-06-25 13:01:23', '', '127.0.0.1', 0, NULL),
(105, 0, '2014-06-25 13:01:30', '2014-06-25 13:01:30', '', '127.0.0.1', 1, NULL),
(106, 23, '2014-06-25 13:01:34', '2014-06-25 13:01:34', '', '127.0.0.1', 1, NULL),
(107, 1, '2014-06-25 14:26:42', '2014-06-25 18:36:37', '', '127.0.0.1', 0, NULL),
(108, 23, '2014-06-25 18:36:42', '2014-06-25 18:36:42', '', '127.0.0.1', 1, NULL),
(109, 1, '2014-06-26 10:38:15', '2014-06-26 10:38:15', '', '127.0.0.1', 1, NULL),
(110, 1, '2014-06-26 14:35:39', '2014-06-26 14:35:39', '', '127.0.0.1', 1, NULL),
(111, 1, '2014-06-26 17:08:46', '2014-06-26 17:08:46', '', '127.0.0.1', 1, NULL),
(112, 1, '2014-06-27 10:35:47', '2014-06-27 10:35:47', '', '127.0.0.1', 1, NULL),
(113, 0, '2014-06-27 12:11:14', '2014-06-27 12:11:14', '', '127.0.0.1', 1, NULL),
(114, 1, '2014-06-27 12:11:18', '2014-06-27 12:11:18', '', '127.0.0.1', 1, NULL),
(115, 1, '2014-06-27 14:06:20', '2014-06-27 14:06:20', '', '127.0.0.1', 1, NULL),
(116, 1, '2014-06-27 16:38:26', '2014-06-27 16:38:26', '', '127.0.0.1', 1, NULL),
(117, 1, '2014-06-27 17:55:12', '2014-06-27 17:55:12', '', '127.0.0.1', 1, NULL),
(118, 1, '2014-06-30 11:53:12', '2014-06-30 11:53:12', '', '127.0.0.1', 1, NULL),
(119, 1, '2014-06-30 16:21:25', '2014-06-30 16:21:25', '', '127.0.0.1', 1, NULL),
(120, 1, '2014-07-01 10:49:30', '2014-07-01 10:49:30', '', '127.0.0.1', 1, NULL),
(121, 1, '2014-07-01 14:04:44', '2014-07-01 14:04:44', '', '127.0.0.1', 1, NULL),
(122, 1, '2014-07-03 10:58:42', '2014-07-03 11:27:12', '', '127.0.0.1', 0, NULL),
(123, 23, '2014-07-03 11:27:17', '2014-07-03 13:02:40', '', '127.0.0.1', 0, NULL),
(124, 1, '2014-07-03 13:02:44', '2014-07-03 13:02:44', '', '127.0.0.1', 1, NULL),
(125, 1, '2014-07-03 17:57:37', '2014-07-03 19:10:11', '', '127.0.0.1', 0, NULL),
(126, 23, '2014-07-03 19:10:20', '2014-07-03 19:10:20', '', '127.0.0.1', 1, NULL),
(127, 1, '2014-07-04 12:21:01', '2014-07-04 12:21:01', '', '127.0.0.1', 1, NULL),
(128, 1, '2014-07-04 14:59:25', '2014-07-04 14:59:25', '', '127.0.0.1', 1, NULL),
(129, 1, '2014-07-04 18:22:09', '2014-07-04 18:22:09', '', '127.0.0.1', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_master`
--

CREATE TABLE IF NOT EXISTS `login_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `login_date` date DEFAULT NULL,
  `hours_worked` varchar(50) DEFAULT NULL,
  `hours_break` varchar(50) DEFAULT NULL,
  `number_of_breaks` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `first_singin_time` datetime DEFAULT NULL,
  `last_sign_of_time` datetime DEFAULT NULL,
  `logged_from_outside` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `login_master`
--

INSERT INTO `login_master` (`id`, `login_id`, `login_date`, `hours_worked`, `hours_break`, `number_of_breaks`, `description`, `first_singin_time`, `last_sign_of_time`, `logged_from_outside`) VALUES
(1, 24, '2014-05-28', '1.43', NULL, 0, '', '2014-05-28 16:25:50', '2014-05-28 17:09:50', NULL),
(2, 28, '2014-05-28', '0.41', NULL, 0, '', '2014-05-28 17:09:09', '2014-05-28 17:50:17', NULL),
(3, 25, '2014-05-28', '0.39', NULL, 0, '', '2014-05-28 17:10:24', '2014-05-28 18:50:12', NULL),
(6, 1, '2014-05-29', '0.43', NULL, 0, '', '2014-05-29 04:54:18', '2014-05-29 05:37:54', NULL),
(8, 24, '2014-05-29', '0.43', NULL, 0, '', '2014-05-29 16:25:50', '2014-05-29 17:09:50', NULL),
(9, 28, '2014-05-29', '0.41', NULL, 0, '', '2014-05-29 17:09:09', '2014-05-29 17:50:17', NULL),
(10, 25, '2014-05-29', '0.39', NULL, 0, '', '2014-05-29 17:10:24', '2014-05-29 18:50:12', NULL),
(11, 1, '2014-05-30', NULL, NULL, 0, '', '2014-05-30 10:12:48', '2014-05-30 10:12:48', NULL),
(13, 1, '2014-06-02', '0.31', NULL, 0, '', '2014-06-02 12:11:42', '2014-06-02 12:43:04', NULL),
(14, 23, '2014-06-02', NULL, NULL, 0, '', '2014-06-02 12:43:08', '2014-06-02 12:43:08', NULL),
(15, 1, '2014-06-09', '6.5', NULL, 0, '', '2014-06-09 11:00:37', '2014-06-09 17:05:50', NULL),
(16, 35, '2014-06-09', '0.24', NULL, 0, '', '2014-06-09 14:25:50', '2014-06-09 14:50:46', NULL),
(17, 37, '2014-06-09', '0.33', NULL, 0, '', '2014-06-09 14:53:02', '2014-06-09 15:26:57', NULL),
(18, 23, '2014-06-09', NULL, NULL, 0, '', '2014-06-09 15:27:02', '2014-06-09 15:27:02', NULL),
(19, 1, '2014-06-10', '3.27', NULL, 0, '', '2014-06-10 11:30:57', '2014-06-10 14:58:01', NULL),
(20, 0, '2014-06-10', NULL, NULL, 0, '', '2014-06-10 13:53:22', '2014-06-10 13:53:22', NULL),
(21, 23, '2014-06-10', NULL, NULL, 0, '', '2014-06-10 14:59:11', '2014-06-10 14:59:11', NULL),
(22, 1, '2014-06-11', NULL, NULL, 0, '', '2014-06-11 10:32:26', '2014-06-11 10:32:26', NULL),
(23, 23, '2014-06-11', NULL, NULL, 0, '', '2014-06-11 11:42:56', '2014-06-11 11:42:56', NULL),
(24, 1, '2014-06-12', NULL, NULL, 0, '', '2014-06-12 10:37:41', '2014-06-12 10:37:41', NULL),
(25, 1, '2014-06-13', NULL, NULL, 0, '', '2014-06-13 10:35:49', '2014-06-13 10:35:49', NULL),
(26, 1, '2014-06-16', NULL, NULL, 0, '', '2014-06-16 10:43:44', '2014-06-16 10:43:44', NULL),
(27, 1, '2014-06-17', NULL, NULL, 0, '', '2014-06-17 10:44:44', '2014-06-17 10:44:44', NULL),
(28, 1, '2014-06-18', NULL, NULL, 0, '', '2014-06-18 12:56:28', '2014-06-18 12:56:28', NULL),
(29, 1, '2014-06-19', '7.1', NULL, 0, '', '2014-06-19 10:48:40', '2014-06-19 17:50:17', NULL),
(30, 23, '2014-06-19', NULL, NULL, 0, '', '2014-06-19 17:50:31', '2014-06-19 17:50:31', NULL),
(31, 1, '2014-06-20', '6.42', NULL, 0, '', '2014-06-20 10:29:19', '2014-06-20 17:11:45', NULL),
(32, 23, '2014-06-20', NULL, NULL, 0, '', '2014-06-20 17:11:55', '2014-06-20 17:11:55', NULL),
(33, 1, '2014-06-23', '4.40', NULL, 0, '', '2014-06-23 10:35:19', '2014-06-23 15:15:51', NULL),
(34, 23, '2014-06-23', NULL, NULL, 0, '', '2014-06-23 15:16:08', '2014-06-23 15:16:08', NULL),
(35, 1, '2014-06-24', NULL, NULL, 0, '', '2014-06-24 10:09:29', '2014-06-24 10:09:29', NULL),
(36, 1, '2014-06-25', '8.3', NULL, 0, '', '2014-06-25 10:32:42', '2014-06-25 18:36:37', NULL),
(37, 0, '2014-06-25', NULL, NULL, 0, '', '2014-06-25 13:01:30', '2014-06-25 13:01:30', NULL),
(38, 23, '2014-06-25', NULL, NULL, 0, '', '2014-06-25 13:01:34', '2014-06-25 13:01:34', NULL),
(39, 1, '2014-06-26', NULL, NULL, 0, '', '2014-06-26 10:38:15', '2014-06-26 10:38:15', NULL),
(40, 1, '2014-06-27', NULL, NULL, 0, '', '2014-06-27 10:35:47', '2014-06-27 10:35:47', NULL),
(41, 0, '2014-06-27', NULL, NULL, 0, '', '2014-06-27 12:11:14', '2014-06-27 12:11:14', NULL),
(42, 1, '2014-06-30', NULL, NULL, 0, '', '2014-06-30 11:53:12', '2014-06-30 11:53:12', NULL),
(43, 1, '2014-07-01', NULL, NULL, 0, '', '2014-07-01 10:49:30', '2014-07-01 10:49:30', NULL),
(44, 1, '2014-07-03', '8.11', NULL, 0, '', '2014-07-03 10:58:42', '2014-07-03 19:10:11', NULL),
(45, 23, '2014-07-03', '1.35', NULL, 0, '', '2014-07-03 11:27:17', '2014-07-03 13:02:40', NULL),
(46, 1, '2014-07-04', NULL, NULL, 0, '', '2014-07-04 12:21:01', '2014-07-04 12:21:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE IF NOT EXISTS `meeting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('Planned','Held','Not Held') COLLATE utf8_unicode_ci DEFAULT 'Planned',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT '3600',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `assigned_user_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_type` enum('Opportunity') COLLATE utf8_unicode_ci DEFAULT 'Opportunity',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`id`, `name`, `status`, `date_start`, `date_end`, `duration`, `description`, `created_at`, `modified_at`, `deleted`, `assigned_user_id`, `modified_by_id`, `created_by_id`, `parent_id`, `parent_type`) VALUES
(3, 'Test12', 'Held', '2014-06-25 04:45:00', '2014-06-25 05:45:00', 3600, 'Curabitur ullamcorper ultricies nisi. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Suspendisse feugiat. Nullam dictum felis eu pede mollis pretium. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem.', '2014-06-24 18:04:02', '2014-06-25 12:57:43', 1, 1, 1, 1, 18, 'Opportunity'),
(4, 'Meeting 2', 'Held', '2014-06-26 02:00:00', '2014-06-26 03:00:00', 3600, 'Duis leo. Curabitur a felis in nunc fringilla tristique. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.', '2014-06-24 20:01:16', '2014-06-24 20:01:16', 1, 23, 1, 1, 0, 'Opportunity'),
(5, 'Meeting3', 'Planned', '2014-06-25 04:45:00', '2014-06-25 05:45:00', 3600, 'Morbi mattis ullamcorper velit', '2014-06-25 10:54:57', '2014-06-25 10:54:57', 1, 23, 1, 1, 0, 'Opportunity'),
(6, 'Test Meeting', 'Held', '2014-06-26 20:00:00', '2014-06-26 20:30:00', 1800, 'Praesent venenatis metus at tortor pulvinar varius. Nullam accumsan lorem in dui.. Etiam sit amet orci eget eros faucibus tincidunt. Etiam ut purus mattis mauris sodales aliquam.', '2014-06-25 13:05:20', '2014-06-25 13:05:20', 1, 23, 23, 23, 6, 'Opportunity'),
(7, 'Briar Kitra', 'Planned', '2014-06-27 04:45:00', '2014-06-27 05:45:00', 3600, 'Praesent vestibulum dapibus nibh. Phasellus consectetuer vestibulum elit. Nullam vel sem. Suspendisse eu ligula. Fusce risus nisl, viverra et, tempor et, pretium in, sapien.', '2014-06-27 18:49:49', '2014-06-27 18:49:49', 0, 1, 1, 1, 1, 'Opportunity');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_entity`
--

CREATE TABLE IF NOT EXISTS `meeting_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meetingId` int(11) DEFAULT '0',
  `entityId` int(11) DEFAULT '0',
  `entityType` enum('Lead','Opportunity','User') COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `meeting_entity`
--

INSERT INTO `meeting_entity` (`id`, `meetingId`, `entityId`, `entityType`, `deleted`) VALUES
(5, 4, 24, 'User', 0),
(6, 4, 1, 'User', 0),
(19, 1, 23, 'User', 0),
(20, 1, 24, 'User', 0),
(21, 1, 39, 'Lead', 0),
(22, 1, 103, 'Lead', 0),
(23, 3, 23, 'User', 0),
(24, 3, 39, 'Lead', 0),
(25, 6, 24, 'User', 0),
(26, 6, 102, 'Lead', 0),
(27, 7, 33, 'User', 0),
(28, 7, 60, 'Lead', 0);

-- --------------------------------------------------------

--
-- Table structure for table `opportunities`
--

CREATE TABLE IF NOT EXISTS `opportunities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stage` int(11) DEFAULT '0',
  `lead_source` int(11) DEFAULT '0',
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `assigned_user_id` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by_id` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by_id` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `opportunities`
--

INSERT INTO `opportunities` (`id`, `lead_id`, `company_name`, `contact_person`, `stage`, `lead_source`, `email_address`, `phone`, `website`, `address_street`, `address_city`, `address_state`, `address_country`, `address_postal_code`, `description`, `created_at`, `modified_at`, `deleted`, `assigned_user_id`, `modified_by_id`, `created_by_id`) VALUES
(1, 0, 'Elmo Company1', 'Caryn Cheyen', 1, 6, 'caryn12@mailinator.com', '03034770855', 'www.sitametornare.co.uk', '406-3320 Test st', 'Hamburg', 'DD', 'Mongolia', '5594', 'Mauris pharetra eget massa molestie sed. gdgdfgffd', '2014-06-02 12:42:05', '2014-06-23 18:57:41', 1, '23', '23', '1'),
(4, 0, 'Clarke', 'Jamalia Lani', 3, 6, 'jamalia@mailinator.com', '(096) 04118020', 'ac.turpis.egestas@Aliquam.com', 'Ap #623-3284 Amet Rd.', 'Hartford', 'CT', 'Comoros', '35624', 'In quis iaculis dolor! Nullam cras amet.', '2014-06-02 13:23:37', '2014-06-10 15:46:09', 1, '23', '23', '23'),
(5, 0, 'Ross', 'Stewart Aaron', 3, 7, 'stewart@mailinator.com', '(059) 88568957', 'justo.nec@gravidasagittis.org', '921-2213 Est, St.', 'Walsall', 'Staffordshire', 'Serbia', '7205', NULL, '2014-06-02 13:23:49', '2014-06-02 13:29:48', 1, '23', '23', '23'),
(6, 0, 'Deacon', 'Hollee Pascale', 2, 5, 'hollee@mailinator.om', '(036544) 592281', 'Cras@rhoncusidmollis.com', 'Ap #179-3545 Sed Rd.', 'Pukekohe', 'North Island', 'French Polynesia', '5208', NULL, '2014-06-02 13:23:58', '2014-06-02 13:29:36', 1, '23', '23', '23'),
(7, 0, 'Austin', 'Gisela Alyssa', 2, 8, 'gisela@mailinator.com', '(0536) 78098892', 'auctor.odio.a@tempor.org', '397-1705 Montes, Rd.', 'Ketchikan', 'Alaska', 'Saint BarthÃƒÂ©lemy', '11300', NULL, '2014-06-02 13:27:46', '2014-06-02 13:30:06', 1, '23', '23', '23'),
(8, 0, 'Noble', 'Ramona Derek', 3, 4, 'ramona@mailinator.com', '(031498) 936363', 'magna.Lorem.ipsum@asollicitudin.ca', 'P.O. Box 575, 9184 Vitae, Road', 'Berlin', 'BE', 'Belize', '46355', NULL, '2014-06-02 13:27:59', '2014-06-02 13:29:56', 1, '23', '23', '23'),
(9, 0, 'Jakeem', 'Joan Hoyt', 2, 8, 'joan@mailinator.com', '(04361) 6231081', 'vulputate.risus@quislectus.co.uk', '1504 Vehicula. St.', 'Warren', 'MI', 'Brunei', 'H3H 5K1', NULL, '2014-06-02 13:32:06', '2014-06-02 13:32:12', 1, '23', '23', '23'),
(10, 101, 'Roger Ltd', 'Roger Decosta', 2, 1, 'roger@yahoo.com', '020254678912', 'www.roger.com', 'Bouwmeestershoeve 28', 'Apeldoorn', 'RR', 'Netherland', '7632', NULL, '2014-06-09 15:28:41', '2014-06-09 15:38:18', 1, '23', '23', '23'),
(11, 7, 'Austin', 'Gisela Alyssa', 2, 8, 'gisela@mailinator.com', '(0536) 78098892', 'auctor.odio.a@tempor.org', '397-1705 Montes, Rd.', 'Ketchikan', 'Alaska', 'Saint BarthÃƒÂ©lemy', '11300', NULL, '2014-06-10 14:20:18', NULL, 1, '23', NULL, '1'),
(12, 102, 'Lechmere', 'Walt de Vente', 6, 1, 'waltdevente@mailinator.com', '0637027249', 'test.com', 'Voorsterweg 175', 'Brummen', 'GM', 'Netherlands', '6971', '', '2014-06-10 15:54:45', '2014-06-10 16:08:55', 1, '23', '1', '23'),
(13, 7, 'Austin', 'Gisela Alyssa', 2, 8, 'gisela@mailinator.com', '(0536) 78098892', 'auctor.odio.a@tempor.org', '397-1705 Montes, Rd.', 'Ketchikan', 'Alaska', 'Saint BarthÃƒÂ©lemy', '11300', NULL, '2014-06-10 16:16:22', NULL, 1, '23', NULL, '23'),
(14, 62, 'Scott', 'Shea Moses', 3, 3, 'shea@mailinator.com', '(00838) 5509517', 'Morbi@necmalesuada.ca', '2746 Non, Road', 'Vitry-sur-Seine', 'ÃƒÂŽ', 'Sudan', '20810', 'Morbi eget dui et lacus semper volutpat.', '2014-06-10 16:20:06', '2014-06-10 16:24:05', 1, '23', '23', '23'),
(15, 103, 'HomeBase', 'Merlijn Ouwendijk', 3, 1, 'merlijn@mailinator.com', '0636824371', 'test.com', 'Deldensestraat 67', 'Nijverdal', 'KV', 'Netherlands', '7441', 'Aliquam nec ligula vitae libero posuere.', '2014-06-10 16:44:12', '2014-06-10 16:48:24', 1, '23', '23', '23'),
(16, 104, 'Good Times', 'Jimme Bruines', 4, 1, 'bimmebruines@mailinator.com', '0665283619', 'test.com', 'Pastoor Jacobsstraat 56', 'Deurne', 'JE', 'Netherlands', '5751', 'Nam placerat leo eu eros hendrerit amet.', '2014-06-10 16:55:37', '2014-06-10 17:11:16', 1, '23', '23', '23'),
(17, 105, 'Manasse ltd', 'Manasse Hove', 3, 1, 'manassevanhove@mailinator.com', '0683894178', 'test.com', 'Spekloane 123', 'Boelenslaan', 'LK', 'Netherlands', '9233', 'Vestibulum consequat posuere nibh metus.', '2014-06-11 14:53:47', '2014-06-11 15:08:14', 1, '23', '23', '23'),
(18, 112, 'Elmo', 'Tatjana Steur', 2, 1, 'TatjanaSteur@armyspy.com', '', 'http://TatjanaSteur.com', 'Pieter Jacobus Oudstraat 139', 'Papendrecht', 'VE', 'Netherlands', '3354', 'Logged in users can view full social security numbers and can save their', '2014-06-18 19:06:20', NULL, 1, '23', NULL, '1'),
(19, 111, 'Joe', 'Gregory Ayers', 2, 1, 'GregoryPAyers@mailinator.us', '', 'http://GregoryPAyers.us', '1424 Freedom Lane', 'Modesto', 'CA', 'Netherland', '95354', 'dg fdfgdfgd', '2014-06-18 19:10:47', NULL, 1, '23', NULL, '1'),
(20, 6, 'Price', 'Briar Kitra', 2, 3, 'briar@mailinator.com', '', 'Aenean@orci.ca', '339-9028 Mus. St.', 'Boston', 'Massachusetts', 'Norway', '75209', 'Mauris turpis nunc, blandit et, volutpat molestie, porta ut, ligula. Nam at tortor in tellus interdum sagittis. Aenean ut eros et nisl sagittis vestibulum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla neque dolor, sagittis eget, iaculis quis, molestie non, velit.', '2014-06-19 11:18:12', '2014-06-19 12:10:16', 1, '23', '1', '1'),
(21, 6, 'Price', 'Briar Kitra', 2, 3, 'briar@mailinator.com', '', 'Aenean@orci.ca', '339-9028 Mus. St.', 'Boston', 'Massachusetts', 'Norway', '75209', 'Aenean viverra rhoncus pede', '2014-06-25 18:38:47', NULL, 1, '23', NULL, '23'),
(22, 11, 'Connor', 'Ori Kirestin', 2, 10, 'erat.eget@mailinator.com', '', 'erat.eget@ametornarelectus.com', '821-8313 In, Street', 'Wichita', 'KS', 'Puerto Rico', '01896', 'Fusce pharetra convallis urna', '2014-07-03 13:03:53', NULL, 0, '1', NULL, '1'),
(23, 9, 'Hope', 'Helen Leroy', 2, 5, 'nulla.ante@ultricessitamet.edu', '', 'ultricessitamet.edu', '120-5551 Sit Av.', 'Orilla', 'Ontario', 'Moldova', '57664', 'Sed fringilla mauris sit', '2014-07-03 18:55:11', '2014-07-03 19:21:40', 0, '1', '23', '1'),
(24, 16, 'Clark', 'Jamalia Lani', 2, 6, 'jamalia@mailinator.com', '', 'ac.turpis.egestas@Aliquam.com', 'Ap #623-3284 Amet Rd.', 'Hartford', 'CT', 'Comoros', '35624', 'Etiam iaculis nunc ac', '2014-07-03 19:26:44', NULL, 0, '23', NULL, '23');

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE IF NOT EXISTS `sources` (
  `source_id` int(11) NOT NULL AUTO_INCREMENT,
  `source_name` varchar(255) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`source_id`, `source_name`, `created_by_id`, `deleted`, `created_at`) VALUES
(1, 'Email', 1, 0, '2014-05-23 00:00:00'),
(2, 'Public Relations', 1, 0, '2014-05-23 00:00:00'),
(3, 'Web Site', 1, 0, '2014-05-23 00:00:00'),
(4, 'Cold Calling', 1, 0, '2014-05-23 00:00:00'),
(5, 'Web Site', 1, 0, '2014-05-23 00:00:00'),
(6, 'Cold Calling', 1, 0, '2014-05-23 00:00:00'),
(7, 'Trade Fairs', 1, 0, '2014-05-23 00:00:00'),
(8, 'Social Media', 1, 0, '2014-05-23 00:00:00'),
(9, 'Vacancy Sites', 1, 0, '2014-05-23 00:00:00'),
(10, 'Bidding Sites', 1, 0, '2014-05-23 00:00:00'),
(11, 'References', 1, 0, '2014-05-23 00:00:00'),
(12, 'Technical Collaborations', 1, 0, '2014-05-23 00:00:00'),
(13, 'Test1', 1, 1, '2014-07-04 15:51:16'),
(14, 'test2', 1, 1, '2014-07-04 15:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

CREATE TABLE IF NOT EXISTS `stages` (
  `stage_id` int(11) NOT NULL AUTO_INCREMENT,
  `stage_name` varchar(255) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`stage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `stages`
--

INSERT INTO `stages` (`stage_id`, `stage_name`, `created_by_id`, `deleted`, `created_at`) VALUES
(1, 'Hot lead', 1, 0, '2014-05-23 00:00:00'),
(2, 'Appointment', 1, 0, '2014-05-23 00:00:00'),
(3, 'Specification', 1, 0, '2014-05-23 00:00:00'),
(4, 'Estimate', 1, 0, '2014-05-23 00:00:00'),
(5, 'Pilot', 1, 0, '2014-05-23 00:00:00'),
(6, 'Client', 1, 0, '2014-05-23 00:00:00'),
(7, 'Test1', 1, 1, '2014-07-04 16:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`, `created_by_id`, `deleted`, `created_at`) VALUES
(1, 'Undefined', 1, 0, '2014-05-23 00:00:00'),
(2, 'Not Reached', 1, 0, '2014-05-23 00:00:00'),
(3, 'Send Info', 1, 0, '2014-05-23 00:00:00'),
(4, 'Info Sent', 1, 0, '2014-05-23 00:00:00'),
(5, 'Short Term', 1, 0, '2014-05-23 00:00:00'),
(6, 'Long Term', 1, 0, '2014-05-23 00:00:00'),
(7, 'Converted', 1, 0, '2014-05-23 00:00:00'),
(8, 'Test', 1, 1, '2014-07-04 14:42:53');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('Not Started','Started','Completed','Canceled') COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `priority` enum('Low','Normal','High','Urgent') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Normal',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `assigned_user_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_type` enum('Opportunity','Lead') COLLATE utf8_unicode_ci DEFAULT 'Opportunity',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `status`, `date_start`, `date_end`, `priority`, `description`, `created_at`, `modified_at`, `deleted`, `assigned_user_id`, `modified_by_id`, `created_by_id`, `parent_id`, `parent_type`) VALUES
(1, 'Test Task', 'Not Started', '2014-06-27 04:45:00', '2014-06-30 05:45:00', 'Low', 'Vestibulum ante ipsum primis', '2014-06-26 11:37:51', '2014-06-26 12:17:28', 1, 23, 1, 1, 4, 'Opportunity'),
(2, 'Test Task', 'Not Started', '2014-06-27 04:45:00', '2014-06-27 05:45:00', 'Normal', 'Phasellus magna. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Praesent ut ligula non mi varius sagittis. Fusce commodo aliquam arcu. Integer tincidunt.', '2014-06-27 18:49:13', '2014-06-27 18:49:13', 0, 1, 1, 1, 13, 'Opportunity');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `deleted`) VALUES
(1, 'Sales Team', 0),
(2, 'Reporting Team', 0),
(3, 'Calling Team', 0),
(4, 'Ananlysis Team', 0),
(5, 'Managment Team', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_users`
--

CREATE TABLE IF NOT EXISTS `team_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `team_id` (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `team_users`
--

INSERT INTO `team_users` (`id`, `team_id`, `user_id`, `deleted`) VALUES
(14, '1', '36', 0),
(15, '2', '36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) DEFAULT '0',
  `user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salutation_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `default_team_id` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `default_team_id` (`default_team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_admin`, `user_name`, `salutation_name`, `first_name`, `last_name`, `email_address`, `password`, `title`, `phone`, `deleted`, `default_team_id`) VALUES
(1, 1, 'admin', 'Mr.', 'Admin', 'Nevenend', 'a.more@easternenterprise.com', '21232f297a57a5a743894a0e4a801fc3', 'Admin title', '0201234567890', 0, '0'),
(21, 0, 'rogerfedder', 'Mr.', 'Roger', 'Fedder', 'roger@mailinator.com', '202cb962ac59075b964b07152d234b70', 'title for roger fedder', '0', 0, '0'),
(22, 0, 'test', 'Mr.', 'test', 'test', 'test@test.com', '202cb962ac59075b964b07152d234b70', 'test', '0', 0, '0'),
(23, 0, 'carlos', 'Mr.', 'Carlos', 'Hood', 'carlos@mailinator.com', '202cb962ac59075b964b07152d234b70', 'the carlos never hacked', '0204567891230', 0, '0'),
(24, 0, 'john', 'Mr.', 'John', 'Cena', 'john@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', 'the world champion', '0', 0, '0'),
(25, 0, 'sunny', 'Mr.', 'Sunny', 'Singal', 'sunny@mailinator.com', '202cb962ac59075b964b07152d234b70', 'Sunny The Great', '0', 0, '0'),
(26, 0, 'iamstupid', 'Mr.', 'Rahul', 'Gandhi', 'iamduffer@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Great Duffer', '02012345678', 0, '0'),
(27, 0, 'uwekohl', 'Mr.', 'Uwe', 'Kohl', 'uwe@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', '', '0657056524', 0, '0'),
(28, 0, 'thomas', 'Mr.', 'Thomas', 'Bayer', 'thomas@mailinator.com', '202cb962ac59075b964b07152d234b70', '', '0689876439', 0, '0'),
(29, 0, 'jurgen', 'Mr.', 'Jurgen', 'Konig', 'jurgen@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Jurgen Konig', '0666428530', 0, '0'),
(30, 0, 'ulrich', 'Mr.', 'Ulrich', 'Mayer', 'ulrich@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Ulrich Mayer', '0', 0, '0'),
(31, 0, 'mario', 'Mr.', 'Mario', 'Wanger', 'mario@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Mario', '065025106', 0, '0'),
(32, 0, 'tom', 'Mr.', 'Tom', 'Austrelize', 'tom@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Tom', '0683446664', 0, '0'),
(33, 0, 'erik', 'Mr.', 'Erik', 'Faber', 'erik@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Faber Erik', '0657846841', 0, '0'),
(34, 0, 'dennis', 'Mr.', 'Dennis', 'Hertzog', 'dennis@mailinator.com', '202cb962ac59075b964b07152d234b70', '', '0632114819', 0, '0'),
(35, 0, 'tim', 'Mr.', 'Tim', 'Bar', 'tim@mailinator.com', '202cb962ac59075b964b07152d234b70', 'The Tim', '0647217537', 0, '0'),
(36, 0, 'rockjohnson', 'Mr.', 'Rock', 'Johnson', 'rockjohnson@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', 'the rock is cooking', '0204567891230', 0, '4'),
(37, 0, 'vithal', 'Mr.', 'Vithal', 'Awate', 'v.awate@easternenterprise.com', '202cb962ac59075b964b07152d234b70', 'the great', '9874563210', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_efforts`
--

CREATE TABLE IF NOT EXISTS `users_efforts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `efforts_date` date NOT NULL,
  `info_sent_count` int(11) NOT NULL DEFAULT '0',
  `calls_count` int(11) NOT NULL DEFAULT '0',
  `appointments_count` int(11) NOT NULL DEFAULT '0',
  `specs_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `users_efforts`
--

INSERT INTO `users_efforts` (`id`, `user_id`, `efforts_date`, `info_sent_count`, `calls_count`, `appointments_count`, `specs_count`) VALUES
(1, 1, '2014-06-02', 0, 0, 1, 1),
(2, 23, '2014-06-02', 0, 0, 4, 2),
(3, 1, '2014-06-09', 0, 0, 0, 0),
(4, 35, '2014-06-09', 0, 0, 0, 0),
(5, 37, '2014-06-09', 0, 0, 0, 0),
(6, 23, '2014-06-09', 0, 0, 2, 0),
(7, 1, '2014-06-10', 0, 0, 3, 6),
(8, 0, '2014-06-10', 0, 0, 0, 0),
(9, 23, '2014-06-10', 4, 0, 10, 11),
(10, 1, '2014-06-11', 0, 0, 0, 0),
(11, 23, '2014-06-11', 1, 0, 1, 1),
(12, 1, '2014-06-12', 0, 0, 0, 0),
(13, 1, '2014-06-13', 0, 0, 0, 0),
(14, 1, '2014-06-16', 4, 0, 0, 0),
(15, 1, '2014-06-17', 1, 0, 0, 0),
(16, 1, '2014-06-18', 0, 0, 0, 0),
(17, 1, '2014-06-19', 0, 0, 0, 0),
(18, 23, '2014-06-19', 1, 0, 0, 0),
(19, 1, '2014-06-20', 0, 0, 0, 0),
(20, 23, '2014-06-20', 0, 0, 0, 0),
(21, 1, '2014-06-23', 0, 0, 0, 0),
(22, 23, '2014-06-23', 1, 0, 0, 0),
(23, 1, '2014-06-24', 0, 0, 0, 0),
(24, 1, '2014-06-25', 0, 0, 0, 0),
(25, 0, '2014-06-25', 0, 0, 0, 0),
(26, 23, '2014-06-25', 0, 0, 1, 0),
(27, 1, '2014-06-26', 0, 0, 0, 0),
(28, 1, '2014-06-27', 0, 0, 0, 0),
(29, 0, '2014-06-27', 0, 0, 0, 0),
(30, 1, '2014-06-30', 0, 0, 0, 0),
(31, 1, '2014-07-01', 0, 0, 0, 0),
(32, 1, '2014-07-03', 0, 0, 2, 0),
(33, 23, '2014-07-03', 0, 0, 2, 1),
(34, 1, '2014-07-04', 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

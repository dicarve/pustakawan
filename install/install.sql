-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 21, 2015 at 03:04 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pustakawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `pst_config`
--

CREATE TABLE IF NOT EXISTS `pst_config` (
  `config_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `config_val` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pst_config`
--

INSERT INTO `pst_config` (`config_name`, `config_val`) VALUES
('content.contact', 'a:2:{s:5:"title";s:17:"Contact Librarian";s:7:"content";s:32:"Arie Nugraha - dicarve@gmail.com";}'),
('content.homepage', 'a:2:{s:5:"title";s:20:"Homepage Information";s:7:"content";s:187:"Welcome to our Library subject guide. please feel free to contact our librarian if you have any question regarding your research topic information resources, we will be happy to help you!";}'),
('pathfinder/2.hidden_type', 'a:6:{i:0;s:21:"Audio Recording/Music";i:1;s:12:"Book Section";i:2;s:22:"Conference Proceedings";i:3;s:12:"Dissertation";i:4;s:20:"Encyclopedia Article";i:5;s:4:"Film";}'),
('site_name', 's:21:"Library Subject Guide";');

-- --------------------------------------------------------

--
-- Table structure for table `pst_pathfinder`
--

CREATE TABLE IF NOT EXISTS `pst_pathfinder` (
`id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subjects` text COLLATE utf8_unicode_ci,
  `subjects_array` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `target_users` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scope` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authors` text COLLATE utf8_unicode_ci NOT NULL,
  `image_filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pst_pathfinder_resources`
--

CREATE TABLE IF NOT EXISTS `pst_pathfinder_resources` (
  `pid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pst_resource`
--

CREATE TABLE IF NOT EXISTS `pst_resource` (
`id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `series_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `format` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `classification` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authors` text COLLATE utf8_unicode_ci,
  `authors_array` text COLLATE utf8_unicode_ci,
  `subjects` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subjects_array` text COLLATE utf8_unicode_ci,
  `publisher` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish_year` int(4) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `doi_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isbn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `collation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abstract` text COLLATE utf8_unicode_ci,
  `notes` text COLLATE utf8_unicode_ci,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pst_taxonomy_term`
--

CREATE TABLE IF NOT EXISTS `pst_taxonomy_term` (
`tid` int(11) NOT NULL COMMENT 'Primary Key: Unique term ID.',
  `vocabulary` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The term name.',
  `description` longtext COMMENT 'A description of the term.',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT 'The weight of this term in relation to other terms.'
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='Stores term information.';

--
-- Dumping data for table `pst_taxonomy_term`
--

INSERT INTO `pst_taxonomy_term` (`tid`, `vocabulary`, `name`, `description`, `weight`) VALUES
(1, 'Subject', 'Library', NULL, 0),
(2, 'Subject', 'Library Science', NULL, 0),
(3, 'Subject', 'Library Administration', NULL, 0),
(4, 'Subject', 'Library Patron', NULL, 0),
(5, 'Subject', 'Information Science', NULL, 0),
(6, 'Subject', 'Information Literacy', NULL, 0),
(7, 'Subject', 'Reference Service', NULL, 0),
(8, 'Subject', 'Reference Librarian', NULL, 0),
(9, 'Category', 'Post Graduate', NULL, 0),
(10, 'Category', 'Doctoral', NULL, 0),
(11, 'Category', 'Undergraduate', NULL, 0),
(15, 'Type', 'Book', NULL, 0),
(16, 'Type', 'Journal Article', NULL, 0),
(17, 'Type', 'Conference Proceedings', NULL, 0),
(18, 'Type', 'Magazine Article', NULL, 0),
(19, 'Type', 'Newspaper Article', NULL, 0),
(20, 'Type', 'Report', NULL, 0),
(21, 'Type', 'Patent', NULL, 0),
(22, 'Type', 'Web Article', NULL, 0),
(23, 'Type', 'Working Paper', NULL, 0),
(24, 'Type', 'Encyclopedia Article', NULL, 0),
(25, 'Type', 'Thesis', NULL, 0),
(26, 'Type', 'Dissertation', NULL, 0),
(27, 'Type', 'Book Section', NULL, 0),
(28, 'Type', 'Film', NULL, 0),
(29, 'Type', 'Audio Recording/Music', NULL, 0),
(30, 'Type', 'Online Database', NULL, 0),
(31, 'Format', 'Printed', NULL, 0),
(32, 'Format', 'Digital', NULL, 0),
(33, 'Format', 'Multimedia', NULL, 0),
(34, 'Format', 'Analog', NULL, 0),
(35, 'Author', 'Arie Nugraha', 'Arie Nugraha', -38),
(36, 'Subject', 'Artificial Intelligence', 'Artificial Intelligence', -37),
(37, 'Subject', 'Data Mining', 'Data Mining', -50),
(38, 'Subject', 'Big Data', 'Big Data', -20),
(39, 'Location', 'My Library', 'My Library', -50),
(40, 'Subject', 'Biomedical', 'Biomedical', -50),
(41, 'Subject', 'Knowledge Industry', 'Knowledge Industry', -40),
(42, 'Author', 'Utami Hariyadi', 'Utami Hariyadi', -50),
(43, 'Author', 'Farli Elnumeri', 'Farli Elnumeri', -30),
(44, 'Subject', 'Natural Language Processing', 'Natural Language Processing', -50),
(45, 'Author', 'Moniruzzaman, A B M', 'Moniruzzaman, A B M', -50),
(46, 'Subject', 'Database', 'Database', -50),
(47, 'Author', 'Sharma, Meenakshi', 'Sharma, Meenakshi', -50),
(48, 'Author', 'Suri, Pushpa', 'Suri, Pushpa', -50);

-- --------------------------------------------------------

--
-- Table structure for table `pst_taxonomy_term_hierarchy`
--

CREATE TABLE IF NOT EXISTS `pst_taxonomy_term_hierarchy` (
  `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Primary Key: The dipi_taxonomy_term_data.tid of the term.',
  `parent` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Primary Key: The dipi_taxonomy_term_data.tid of the term’s parent. 0 indicates no parent.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores the hierarchical relationship between terms.';

-- --------------------------------------------------------

--
-- Table structure for table `pst_users`
--

CREATE TABLE IF NOT EXISTS `pst_users` (
  `id` int(11) NOT NULL,
  `realname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_data` text COLLATE utf8_unicode_ci,
  `groups` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pst_users`
--

INSERT INTO `pst_users` (`id`, `realname`, `username`, `passwd`, `email`, `description`, `other_data`, `groups`, `created`, `updated`) VALUES
(1, 'Administrator', 'librarian', '0e43650b148e1557def21ef7ae16ebd8f7c21ccfa676e0d9f64e042681855970', NULL, NULL, NULL, 'Librarian', '2015-08-20 00:00:00', '2015-08-20 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pst_config`
--
ALTER TABLE `pst_config`
 ADD PRIMARY KEY (`config_name`);

--
-- Indexes for table `pst_pathfinder`
--
ALTER TABLE `pst_pathfinder`
 ADD PRIMARY KEY (`id`), ADD KEY `category` (`category`), ADD FULLTEXT KEY `FT_SEARCH` (`title`,`subjects`,`description`);

--
-- Indexes for table `pst_pathfinder_resources`
--
ALTER TABLE `pst_pathfinder_resources`
 ADD PRIMARY KEY (`pid`,`rid`);

--
-- Indexes for table `pst_resource`
--
ALTER TABLE `pst_resource`
 ADD PRIMARY KEY (`id`), ADD KEY `format` (`format`), ADD KEY `type` (`type`), ADD KEY `doi_id` (`doi_id`), ADD FULLTEXT KEY `FT_SEARCH_RES` (`title`,`series_title`,`authors`,`subjects`,`abstract`);

--
-- Indexes for table `pst_taxonomy_term`
--
ALTER TABLE `pst_taxonomy_term`
 ADD PRIMARY KEY (`tid`), ADD KEY `taxonomy_tree` (`vocabulary`,`weight`,`name`), ADD KEY `vid_name` (`vocabulary`,`name`), ADD KEY `name` (`name`), ADD KEY `vocabulary` (`vocabulary`);

--
-- Indexes for table `pst_taxonomy_term_hierarchy`
--
ALTER TABLE `pst_taxonomy_term_hierarchy`
 ADD PRIMARY KEY (`tid`,`parent`), ADD KEY `parent` (`parent`);

--
-- Indexes for table `pst_users`
--
ALTER TABLE `pst_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pst_pathfinder`
--
ALTER TABLE `pst_pathfinder`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pst_resource`
--
ALTER TABLE `pst_resource`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pst_taxonomy_term`
--
ALTER TABLE `pst_taxonomy_term`
MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key: Unique term ID.',AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

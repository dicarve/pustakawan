-- Pustakawan SQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `pst_config`;
CREATE TABLE `pst_config` (
  `config_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `config_val` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pst_config` (`config_name`, `config_val`) VALUES
('content.contact',	'a:2:{s:5:\"title\";s:17:\"Contact Librarian\";s:7:\"content\";s:32:\"Arie Nugraha - dicarve@gmail.com\";}'),
('content.homepage',	'a:2:{s:5:\"title\";s:20:\"Homepage Information\";s:7:\"content\";s:187:\"Welcome to our Library subject guide. please feel free to contact our librarian if you have any question regarding your research topic information resources, we will be happy to help you!\";}'),
('site_name',	's:21:\"Library Subject Guide\";');

DROP TABLE IF EXISTS `pst_pathfinder`;
CREATE TABLE `pst_pathfinder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subjects` text COLLATE utf8_unicode_ci,
  `subjects_array` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `target_users` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scope` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authors` text COLLATE utf8_unicode_ci NOT NULL,
  `image_filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `promoted` smallint(1) DEFAULT '0',
  `weight` int(11) DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  FULLTEXT KEY `FT_SEARCH` (`title`,`subjects`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pst_pathfinder` (`id`, `title`, `category`, `subjects`, `subjects_array`, `description`, `target_users`, `scope`, `authors`, `image_filename`, `promoted`, `weight`, `created`, `updated`) VALUES
(1,	'Sample subject guide',	'Post Graduate',	'Metadata ; Reference Librarian ; Reference Service',	'a:3:{i:0;s:8:\"Metadata\";i:1;s:19:\"Reference Librarian\";i:2;s:17:\"Reference Service\";}',	'This guide is intended as an example. Mention the description of your subject guide here.',	'Postgraduate students',	'Scope of this guide',	'Administrator',	'Primer_Amanecer_2010_by_letoloke.jpg',	0,	0,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `pst_pathfinder_resources`;
CREATE TABLE `pst_pathfinder_resources` (
  `pid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`pid`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pst_pathfinder_resources` (`pid`, `rid`, `created`) VALUES
(1,	1,	'2015-08-21 23:45:32');

DROP TABLE IF EXISTS `pst_resource`;
CREATE TABLE `pst_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `publish_place` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `format` (`format`),
  KEY `type` (`type`),
  KEY `doi_id` (`doi_id`),
  FULLTEXT KEY `FT_SEARCH_RES` (`title`,`series_title`,`authors`,`subjects`,`abstract`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pst_resource` (`id`, `title`, `series_title`, `format`, `language`, `type`, `classification`, `authors`, `authors_array`, `subjects`, `subjects_array`, `publisher`, `publish_year`, `publish_place`, `url`, `doi_id`, `other_id`, `isbn`, `issn`, `location`, `collation`, `abstract`, `notes`, `filename`, `image_filename`, `created`, `updated`) VALUES
(1,	'Metadata for information management and retrieval',	'',	'Printed',	'US English',	'Book',	'025',	'Haynes, David',	'a:1:{i:0;s:13:\"Haynes, David\";}',	'Metadata',	'a:1:{i:0;s:8:\"Metadata\";}',	'Facet Publishing',	2004,	'Jakarta',	'',	'',	'',	'9781856044899',	'',	'My Library',	'xiv, 186 p. ; 24 cm.',	'',	NULL,	'',	NULL,	'0000-00-00 00:00:00',	'2015-08-22 00:00:00');

DROP TABLE IF EXISTS `pst_sessions`;
CREATE TABLE `pst_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `pst_taxonomy_term`;
CREATE TABLE `pst_taxonomy_term` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key: Unique term ID.',
  `vocabulary` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The term name.',
  `description` longtext COLLATE utf8_unicode_ci COMMENT 'A description of the term.',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT 'The weight of this term in relation to other terms.',
  PRIMARY KEY (`tid`),
  KEY `taxonomy_tree` (`vocabulary`,`weight`,`name`),
  KEY `vid_name` (`vocabulary`,`name`),
  KEY `name` (`name`),
  KEY `vocabulary` (`vocabulary`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores term information.';

INSERT INTO `pst_taxonomy_term` (`tid`, `vocabulary`, `name`, `description`, `weight`) VALUES
(1,	'Subject',	'Library',	NULL,	0),
(2,	'Subject',	'Library Science',	NULL,	0),
(3,	'Subject',	'Library Administration',	NULL,	0),
(4,	'Subject',	'Library Patron',	NULL,	0),
(5,	'Subject',	'Information Science',	NULL,	0),
(6,	'Subject',	'Information Literacy',	NULL,	0),
(7,	'Subject',	'Reference Service',	NULL,	0),
(8,	'Subject',	'Reference Librarian',	NULL,	0),
(9,	'Category',	'Post Graduate',	NULL,	0),
(10,	'Category',	'Doctoral',	NULL,	0),
(11,	'Category',	'Undergraduate',	NULL,	0),
(15,	'Type',	'Book',	NULL,	0),
(16,	'Type',	'Journal Article',	NULL,	0),
(17,	'Type',	'Conference Proceedings',	NULL,	0),
(18,	'Type',	'Magazine Article',	NULL,	0),
(19,	'Type',	'Newspaper Article',	NULL,	0),
(20,	'Type',	'Report',	NULL,	0),
(21,	'Type',	'Patent',	NULL,	0),
(22,	'Type',	'Web Article',	NULL,	0),
(23,	'Type',	'Working Paper',	NULL,	0),
(24,	'Type',	'Encyclopedia Article',	NULL,	0),
(25,	'Type',	'Thesis',	NULL,	0),
(26,	'Type',	'Dissertation',	NULL,	0),
(27,	'Type',	'Book Section',	NULL,	0),
(28,	'Type',	'Film',	NULL,	0),
(29,	'Type',	'Audio Recording/Music',	NULL,	0),
(30,	'Type',	'Online Database',	NULL,	0),
(31,	'Format',	'Printed',	NULL,	-50),
(32,	'Format',	'Digital',	NULL,	-49),
(33,	'Format',	'Multimedia',	NULL,	0),
(34,	'Format',	'Analog',	NULL,	0),
(35,	'Author',	'Arie Nugraha',	'Arie Nugraha',	-38),
(36,	'Subject',	'Artificial Intelligence',	'Artificial Intelligence',	-37),
(37,	'Subject',	'Data Mining',	'Data Mining',	-50),
(38,	'Subject',	'Big Data',	'Big Data',	-20),
(39,	'Location',	'My Library',	'My Library',	-50),
(40,	'Subject',	'Biomedical',	'Biomedical',	-50),
(41,	'Subject',	'Knowledge Industry',	'Knowledge Industry',	-40),
(42,	'Author',	'Utami Hariyadi',	'Utami Hariyadi',	-50),
(43,	'Author',	'Farli Elnumeri',	'Farli Elnumeri',	-30),
(44,	'Subject',	'Natural Language Processing',	'Natural Language Processing',	-50),
(46,	'Subject',	'Database',	'Database',	-50),
(49,	'Subject',	'Metadata',	'Wakil singkat dari suatu sumber informasi',	-50),
(50,	'Author',	'Taylor, Arlene G.',	'',	-50),
(51,	'Publisher',	'Wiley',	'Wiley',	-50),
(54,	'Publisher',	'Pearson',	'Pearson',	-50),
(55,	'Place',	'Jakarta',	'Indonesia',	-50),
(56,	'Author',	'Saffady, William',	'Saffady, William',	-50),
(57,	'Author',	'Rowley, Jennifer',	'Rowley, Jennifer',	-50),
(58,	'Language',	'US English',	'US English',	-50),
(59,	'Language',	'Bahasa Indonesia',	'Bahasa Indonesia',	-50),
(60,	'Author',	'Haynes, David',	'Haynes, David',	-50),
(61,	'Publisher',	'Facet Publishing',	'Facet Publishing',	-50);

DROP TABLE IF EXISTS `pst_taxonomy_term_hierarchy`;
CREATE TABLE `pst_taxonomy_term_hierarchy` (
  `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Primary Key: The dipi_taxonomy_term_data.tid of the term.',
  `parent` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Primary Key: The dipi_taxonomy_term_data.tid of the term’s parent. 0 indicates no parent.',
  PRIMARY KEY (`tid`,`parent`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the hierarchical relationship between terms.';


DROP TABLE IF EXISTS `pst_users`;
CREATE TABLE `pst_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_data` text COLLATE utf8_unicode_ci,
  `groups` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pst_users` (`id`, `realname`, `username`, `passwd`, `email`, `description`, `other_data`, `groups`, `created`, `updated`) VALUES
(1,	'Administrator',	'librarian',	'0e43650b148e1557def21ef7ae16ebd8f7c21ccfa676e0d9f64e042681855970',	'admin@pustakawan.or.id',	NULL,	NULL,	'Librarian',	'2015-08-20 00:00:00',	'2015-08-21 22:56:25');

-- 2016-03-12 06:31:29

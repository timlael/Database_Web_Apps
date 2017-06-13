-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 02, 2017 at 03:53 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj23`
--

-- --------------------------------------------------------

--
-- Table structure for table `concepts`
--

CREATE TABLE IF NOT EXISTS `concepts` (
  `id` int(11) NOT NULL COMMENT 'auto incremented concept id',
  `name` varchar(40) NOT NULL COMMENT 'concept text description'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `concepts`
--

INSERT INTO `concepts` (`id`, `name`) VALUES
(4, 'Holidays'),
(5, 'Greetings'),
(6, 'Numbers');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `videoid` int(11) NOT NULL COMMENT 'auto incremented record identifier',
  `youid` varchar(30) NOT NULL COMMENT 'youtube video identifier',
  `description` varchar(256) DEFAULT NULL COMMENT 'video description limited to 256 chars',
  `title` varchar(128) DEFAULT NULL COMMENT 'video title limited to 128 char'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='youtube videos';

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`videoid`, `youid`, `description`, `title`) VALUES
(1, '2wY1BQZaaEQ', 'How to say hello in Japanese', 'Lesson 1'),
(2, 'xK_Hai0zaMA', 'How to sound Japanese', 'Lesson 2'),
(3, 'jh5He7xdNlY', 'Japanese holiday greetings', 'Lesson 3'),
(4, 'B_XvpcOKdj0', 'Are you polite enough in Japanese', 'Lesson 4'),
(5, 'ooT9YJmbZpQ', 'How to complain politely', 'Lesson 5'),
(6, 'DWkHHXoE3kM', 'How to count in Japanese', 'Lesson 6'),
(7, 'lwMF-xpvtrQ', 'How to Write Japanese - Hiragana Special Symbols and Rules', 'Lesson 15.6');

-- --------------------------------------------------------

--
-- Table structure for table `video_concept_map`
--

CREATE TABLE IF NOT EXISTS `video_concept_map` (
  `id` int(11) NOT NULL COMMENT 'table record identifier',
  `conceptid` int(11) NOT NULL COMMENT 'concept record identifier from concepts table',
  `videoid` int(11) NOT NULL COMMENT 'video record identifier from video table',
  `start` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_concept_map`
--

INSERT INTO `video_concept_map` (`id`, `conceptid`, `videoid`, `start`, `duration`) VALUES
(7, 4, 1, 90, 10),
(8, 4, 2, 10, 45),
(5, 4, 7, 55, 60),
(6, 5, 4, 90, 45),
(4, 6, 3, 45, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `concepts`
--
ALTER TABLE `concepts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`name`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`videoid`),
  ADD UNIQUE KEY `youid` (`youid`);

--
-- Indexes for table `video_concept_map`
--
ALTER TABLE `video_concept_map`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conceptid` (`conceptid`,`videoid`,`start`,`duration`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concepts`
--
ALTER TABLE `concepts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incremented concept id',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `videoid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incremented record identifier',AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `video_concept_map`
--
ALTER TABLE `video_concept_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'table record identifier',AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

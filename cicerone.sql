-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2015 at 01:52 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cicerone`
--

-- --------------------------------------------------------

--
-- Table structure for table `cicerone_activities`
--

CREATE TABLE IF NOT EXISTS `cicerone_activities` (
  `id` int(6) unsigned NOT NULL,
  `project_id` int(6) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL,
  `types` text,
  `description` text,
  `uriLink` text,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cicerone_activities`
--

INSERT INTO `cicerone_activities` (`id`, `project_id`, `name`, `duration`, `types`, `description`, `uriLink`, `dateCreated`) VALUES
(8, 1, 'Cicerone - Start', 7500, 'web,php,html,sql,mysql,phpmyadmin', 'Wrote simple form for input. Designed and created database to store activities. Hooked up form to insert activity into db using a post-redirect-get pattern. Added a query to be able to calculate total hours inserted into db and display at bottom. Worked on design to make form prettier/more friendly.			', '', '2015-05-31 02:44:58'),
(14, 1, 'simple UI and "Project" Backend', 9000, 'web,php,html,css,sql', 'Made the forms for activities prettier using a grid css framework. Added a db table for projects. Added foreign key to activities to determine which project they belong to. Added a file/page/form that allows user to create a project and insert that project into the db. Added a dynamic list to index page that shows all projects. Added (temporary) select dropdown for projects. Created github repo for Cicerone and committed.				', 'https://github.com/cicerone-trh/cicerone/commit/d713baa8531cb0bde020658507dede7707f9b038', '2015-05-31 05:26:39'),
(15, 2, 'player controls, drawing of road', 10200, 'games,XNA,C#,visual studio', 'player exists in world;\r\nplayer can change lanes, speed up, slow down, set cruise control;\r\ndistance a player has moved determines where lines of road are drawn;\r\nsetup git repo			', 'https://github.com/cicerone-trh/traffic-game/commit/bba6904c0f3b21b9e91a964d4a1f61ca8ef8f1a5', '2015-05-31 05:47:39'),
(16, 1, 'Design project viewing', 3300, 'web,design,jquery,css,php,sql', 'Time spent considering design for viewing projects and activities. Added jquery and made list of projects selectable. Added a "Today" display for # hours entered. Added Types column to database, hooked up form field.				', 'https://github.com/cicerone-trh/cicerone/commit/94ccdeb367892d11ffbc2d2e7a4e6e689406d0b7', '2015-05-31 18:03:51'),
(17, 5, 'Installing Debian 8 on VM', 1620, 'Linux,GNU,Hardware', 'Downloaded the install image, worked through RAID 5 setup, and got it ready to go. I am trying to configure a fully functional Debian setup for when I actually convert my computer. After learning more about the file system and making sure my workflow can be accomplished, I am formatting and installin it.				', 'none', '2015-06-03 17:32:58'),
(18, 1, 'Backend validation, database updating', 7440, 'PHP,SQL', 'Worked on input validation for cicerone activities on back-end. Converted query() to prepare statements	with bind_param. Additionally, added unique database user for cicerone_app, and worked on design for types in the db (though wrote no code and did not update the database).			', '', '2015-06-03 20:28:40'),
(23, 1, 'Add activity validation', 6060, 'PHP,regex,javascript,HTML5', 'added javascript/HTML5/PHP validation for activity form inputs: name, duration, desc required				', 'https://github.com/cicerone-trh/cicerone/commit/a3a8e4cd982236c5e57073c853346d15f4ea167a', '2015-06-04 04:04:07');

-- --------------------------------------------------------

--
-- Table structure for table `cicerone_projects`
--

CREATE TABLE IF NOT EXISTS `cicerone_projects` (
  `id` int(6) unsigned NOT NULL,
  `name` text NOT NULL,
  `description` text,
  `isValue` tinyint(1) NOT NULL,
  `uriLink` text,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cicerone_projects`
--

INSERT INTO `cicerone_projects` (`id`, `name`, `description`, `isValue`, `uriLink`, `dateCreated`) VALUES
(1, 'Cicerone', 'This is a simple web app to keep track of my time spent on projects. I will have a list of projects and whenever I do something towards that project I will record it in the form of an activity.		', 1, 'none', '2015-05-31 04:10:46'),
(2, 'Game of Traffic', 'A video game being written in XNA. It has a variety of game modes, all of which focus on driving down a highway and interacting with traffic.', 1, 'none', '2015-05-31 04:25:02'),
(4, 'Job Seeking', 'Time spent looking up and applying to jobs.', 0, 'none', '2015-05-31 04:30:49'),
(5, 'Misc -- Useful', 'This is a project to group in any sort of learning or small endeavors that do not belong to any particular project. 				', 1, '', '2015-06-03 17:27:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cicerone_activities`
--
ALTER TABLE `cicerone_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cicerone_projects`
--
ALTER TABLE `cicerone_projects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cicerone_activities`
--
ALTER TABLE `cicerone_activities`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cicerone_projects`
--
ALTER TABLE `cicerone_projects`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

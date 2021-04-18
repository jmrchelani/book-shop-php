-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2021 at 10:19 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(20) NOT NULL DEFAULT 'NONE',
  `Name` varchar(256) NOT NULL DEFAULT 'NONE',
  `Description` text NOT NULL,
  `Price` int(11) NOT NULL DEFAULT '0',
  `Img` text NOT NULL,
  `Author` varchar(256) NOT NULL DEFAULT 'None',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`ID`, `ISBN`, `Name`, `Description`, `Price`, `Img`, `Author`) VALUES
(8, '89564636', 'A Dictionary of Architecture', 'Containing over 5,000 entries from Aalto to ziggurat, this is the most comprehensive and up-to-date dictionary of architecture in paperback. Beautifully illustrated and written in a clear and concise style, it is an invaluable work of reference for both students of architecture and the general reader, as well as professional architects. Covers all periods of Western architectural history, from ancient times to the present day Concise biographies of leading architects, from Brunelleschi and Imhotep to Le Corbusier and Richard Rogers Over 250 illustrations specially drawn for this volume', 500, 'uploads/ARC9.jpg', 'Richard Rogers'),
(9, '87558769', 'A Social History', 'Containing over 5,000 entries from Aalto to ziggurat, this is the most comprehensive and up-to-date dictionary of architecture in paperback. Beautifully illustrated and written in a clear and concise style, it is an invaluable work of reference for both students of architecture and the general reader, as well as professional architects. Covers all periods of Western architectural history, from ancient times to the present day Concise biographies of leading architects, from Brunelleschi and Imhotep to Le Corbusier and Richard Rogers Over 250 illustrations specially drawn for this volume', 1000, 'uploads/ARC8.jpg', 'Parmar'),
(10, '9788189866', 'Conserve A Biotechnological Approach to Wild', 'There is a tremendous wealth of mega-biodiversity in the world. But the very existence of this wealth is under threat due to habitat destruction, pushing animals towards inbreeding depression and thereby paving way for their extinction. This has made essential human intervention and assisted reproductive technologies.', 659, 'uploads/biology.gif', 'S Shivaji'),
(11, '8125904182', 'STATISTICS FOR BUSINESS AND ECONOMICS', 'This book covers various aspects of the field of statistics in 20 chapters, making each topic relevant and useful. A unique feature of this book is the inclusion of databases to be utilized by computers and software statistical packages.', 372, 'uploads/busi7.jpg', 'J S CHANDAN'),
(12, '818820417X', 'An ABC of Indian Culture : A Personal Padayatra of Half a Ce', 'An authentic interpretation of over 400 Indian concepts and practices derived from a personal exploration of India over a period of 50 years. Arranged alphabetically,', 595, 'uploads/cul1.jpg', 'Peggy Holroyde'),
(13, '0143101846', 'The Mad, Mad World of Cricket', 'The funny side of the gentleman?s game?captured by a master cartoonist In India cricket is more than a game; it is a national obsession', 780, 'uploads/c1.jpg', 'Sudhir Dar'),
(14, '0887291767', 'Insight Guide Iceland', 'A travel series unlike any other, Insight Guides go beyond the sights and into reality.', 935, 'uploads/t2.jpg', 'Perrottet, Tony (Edt)');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FName` varchar(100) NOT NULL,
  `LName` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Zip` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`ID`, `Username`, `Password`, `FName`, `LName`, `City`, `Zip`) VALUES
(1, 'jmrchelani', '12345678', 'Milton', 'Kumar', 'Hyderabad', '71000'),
(2, 'arsamjaan', 'none', 'Arsam', 'Awan', 'Hyderabad', '90000');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(100) NOT NULL,
  `ISBN` varchar(100) NOT NULL,
  `Price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`ID`, `Username`, `ISBN`, `Price`) VALUES
(6, 'jmrchelani', '9788189866', 659),
(5, 'jmrchelani', '87558769', 1000),
(7, 'jmrchelani', '89564636', 1000),
(8, 'jmrchelani', '87558769', 1000),
(9, 'jmrchelani', '9788189866', 659),
(10, 'jmrchelani', '89564636', 1000),
(11, 'jmrchelani', '87558769', 1000),
(12, 'jmrchelani', '8125904182', 372),
(13, 'jmrchelani', '818820417X', 595),
(14, 'jmrchelani', '0143101846', 780),
(15, 'jmrchelani', '87558769', 4000),
(16, 'jmrchelani', '87558769', 5000),
(17, 'jmrchelani', '87558769', 5000),
(18, 'jmrchelani', '818820417X', 5950),
(19, 'arsamjaan', '0143101846', 2340),
(20, 'arsamjaan', '8125904182', 744);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Username` varchar(256) NOT NULL DEFAULT 'NA',
  `Email` varchar(256) NOT NULL DEFAULT 'NA',
  `Password` varchar(256) NOT NULL DEFAULT 'NONENONE',
  `Name` varchar(100) NOT NULL DEFAULT 'NONAME'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Username`, `Email`, `Password`, `Name`) VALUES
('admin', 'jmrchelani@gmail.com', 'admin', 'Admin Mr'),
('arsam', 'arsamjaani@gmail.com', 'arsam', 'Arsam');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

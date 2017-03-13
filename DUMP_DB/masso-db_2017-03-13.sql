-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 13, 2017 at 05:00 PM
-- Server version: 5.7.17-log
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masso`
--

-- --------------------------------------------------------

--
-- Table structure for table `interventi`
--

CREATE TABLE `interventi` (
  `id` int(10) UNSIGNED NOT NULL,
  `pc_id` int(10) UNSIGNED NOT NULL,
  `dataintervento` date NOT NULL,
  `descrizione` varchar(200) NOT NULL,
  `spesa` int(11) NOT NULL,
  `ore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interventi`
--

INSERT INTO `interventi` (`id`, `pc_id`, `dataintervento`, `descrizione`, `spesa`, `ore`) VALUES
(1, 1, '2017-03-13', 'descr1', 10, 5),
(2, 2, '2003-03-03', 'descr2', 20, 10),
(3, 3, '1999-02-02', 'descr2', 30, 15),
(4, 4, '2009-02-01', 'descr4', 90, 2),
(5, 6, '2006-02-01', 'descr5', 24, 12);

-- --------------------------------------------------------

--
-- Stand-in structure for view `listainterventi`
-- (See below for the actual view)
--
CREATE TABLE `listainterventi` (
`id` int(10) unsigned
,`dataintervento` date
,`descrizione` varchar(200)
,`spesa` int(11)
,`ore` int(11)
,`hostname` varchar(100)
,`modello` varchar(100)
,`sn` varchar(100)
,`marca` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `marche`
--

CREATE TABLE `marche` (
  `id` int(11) NOT NULL,
  `marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marche`
--

INSERT INTO `marche` (`id`, `marca`) VALUES
(1, 'dell'),
(2, 'asus'),
(3, 'apple'),
(4, 'toshiba'),
(5, 'sony');

-- --------------------------------------------------------

--
-- Table structure for table `pc`
--

CREATE TABLE `pc` (
  `id` int(10) UNSIGNED NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `marche_id` int(11) NOT NULL,
  `modello` varchar(100) NOT NULL,
  `sn` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pc`
--

INSERT INTO `pc` (`id`, `hostname`, `marche_id`, `modello`, `sn`) VALUES
(1, 'host0', 1, 'modello0', 'sn0'),
(2, 'host1', 1, 'modello1', 'sn1'),
(3, 'host2', 1, 'modello2', 'sn2'),
(4, 'host3', 2, 'modello3', 'sn3'),
(6, 'host5', 4, 'modello5', 'sn5'),
(7, 'host6', 1, 'modello6', 'sn6');

-- --------------------------------------------------------

--
-- Table structure for table `pinco`
--

CREATE TABLE `pinco` (
  `hostname` varchar(100) DEFAULT NULL,
  `sn` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pinco`
--

INSERT INTO `pinco` (`hostname`, `sn`) VALUES
('host0', 'sn0'),
('host1', 'sn1'),
('host1', 'sn1'),
('host1', 'sn1'),
('host3', 'sn3');

-- --------------------------------------------------------

--
-- Structure for view `listainterventi`
--
DROP TABLE IF EXISTS `listainterventi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `listainterventi`  AS  select `interventi`.`id` AS `id`,`interventi`.`dataintervento` AS `dataintervento`,`interventi`.`descrizione` AS `descrizione`,`interventi`.`spesa` AS `spesa`,`interventi`.`ore` AS `ore`,`pc`.`hostname` AS `hostname`,`pc`.`modello` AS `modello`,`pc`.`sn` AS `sn`,`marche`.`marca` AS `marca` from ((`interventi` left join `pc` on((`interventi`.`pc_id` = `pc`.`id`))) left join `marche` on((`pc`.`marche_id` = `marche`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interventi`
--
ALTER TABLE `interventi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pc_id` (`pc_id`);

--
-- Indexes for table `marche`
--
ALTER TABLE `marche`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pc`
--
ALTER TABLE `pc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marche_id` (`marche_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interventi`
--
ALTER TABLE `interventi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `marche`
--
ALTER TABLE `marche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pc`
--
ALTER TABLE `pc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `interventi`
--
ALTER TABLE `interventi`
  ADD CONSTRAINT `interventi_ibfk_1` FOREIGN KEY (`pc_id`) REFERENCES `pc` (`id`);

--
-- Constraints for table `pc`
--
ALTER TABLE `pc`
  ADD CONSTRAINT `pc_ibfk_1` FOREIGN KEY (`marche_id`) REFERENCES `marche` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

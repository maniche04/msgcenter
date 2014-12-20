-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2014 at 09:22 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `intercity`
--

-- --------------------------------------------------------

--
-- Table structure for table `ic_notifications`
--

CREATE TABLE IF NOT EXISTS `ic_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` varchar(25) NOT NULL,
  `to_user` varchar(25) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `read_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3261 ;

--
-- Dumping data for table `ic_notifications`
--

INSERT INTO `ic_notifications` (`id`, `from_user`, `to_user`, `msg`, `read_status`) VALUES

(3260, 'manish', 'sumit', 'haitteri!', 1);

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'Manish', 'Bhattarai', 'manish', '$2y$10$nOJzVQFWmGKelqyUVYFJzuwfPmw3YzovWYoAX8Oa3iM/LCVKycjTy', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(2, 'Sumit', 'Shrestha', 'sumit', '$2y$10$oKl7w2nLBa9KqtL/bk23XOhhP0vbilaKfiaDW1abWxZDek6Z7s92K', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(3, 'Roshan', 'Khadka', 'roshan', '$2y$10$IunezCQnbh7JNM7aaz1k4uB0qoEGBwowC3arMqRagLDVacvbBQ4VC', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(4, 'Aashish', 'Karki', 'aashish', '$2y$10$BFppk5vm4mmInLFSrY/vse1CtupkqHezH.0m1uIqOO55kfYHRz.2i', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(5, 'Navin', 'Bhandari', 'navin', '$2y$10$KBX5tlNMTKwChNVM8A0riOOxsQsUqXrdIbbuFClOnHITKOZNqym.2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(6, 'Gay', 'Astachan', 'gay', '$2y$10$.KZhIRyXmpnFLwjH0VLPhOiEbi8k1HL3UPzPdIKK9PedPRDT9gE66', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(7, 'John', 'Mark', 'john', '$2y$10$v6ArUsE9A.XE7/BWENPMRubC8AXyT27VRwQ7q6WN.L.BByTjWFwHq', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.4.13.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2016 at 04:26 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_search`
--

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `friendly_url`, `parent_id`, `promote`) VALUES
(1, 'VOID', 'void', 0, 0),
(2, 'NULL', 'null', 1, 0),
(3, 'General Programming', 'general-programming', 0, 0),
(4, 'Language', 'language', 0, 0),
(5, 'OS Programming', 'os-programming', 0, 0),
(6, 'Multimedia', 'multimedia', 0, 0),
(7, 'Web Development', 'web-development', 0, 0),
(8, 'MySQL', 'mysql', 55, 0),
(9, 'Oracle', 'oracle', 55, 0),
(10, 'SQL Server', 'sql-server', 55, 0),
(11, 'Artificial Intelligent', 'artificial-intelligent', 3, 1),
(12, 'Cryptography & Security', 'cryptography-security', 3, 0),
(13, 'Data Structure & Algorithm', 'data-structure-algorithm', 3, 1),
(14, 'Design Pattern', 'design-pattern', 3, 1),
(15, 'Games', 'games', 0, 1),
(16, 'Physics', 'physics', 3, 0),
(17, 'Threads & Processes & IPC', 'threads-processes-ipc', 3, 0),
(18, 'UML', 'uml', 3, 0),
(19, 'Assembly', 'assembly', 4, 0),
(20, 'Batch Script', 'batch-script', 4, 0),
(21, 'C#', 'csharp', 4, 0),
(22, 'C/C++', 'cplusplus', 4, 1),
(23, 'Java', 'java', 4, 0),
(24, 'Lua', 'lua', 4, 0),
(25, 'Perl', 'perl', 4, 0),
(26, 'Python', 'python', 4, 0),
(27, 'Android', 'android', 5, 0),
(28, 'iOS', 'ios', 5, 0),
(29, 'Windows Phone', 'windows-phone', 5, 0),
(30, 'DirectX', 'directx', 6, 0),
(31, 'OpenGL', 'opengl', 6, 0),
(32, 'SDL', 'sdl', 6, 0),
(33, 'AJAX', 'ajax', 7, 0),
(34, 'ASP.NET', 'asp-net', 7, 0),
(35, 'HTML', 'html', 7, 0),
(36, 'PHP', 'php', 7, 1),
(37, 'Programming 101', 'programming-101', 0, 0),
(38, 'Experience', 'experience', 54, 0),
(39, 'STDIO Experience', 'stdio-experience', 54, 0),
(40, 'Tools', 'tools', 54, 0),
(41, 'CGI', 'cgi', 7, 0),
(42, 'Metal', 'metal', 6, 0),
(43, 'XML', 'xml', 7, 0),
(44, 'Math', 'math', 37, 0),
(45, 'Programming', 'programming', 37, 0),
(46, 'Cocos2d-x', 'cocos2d-x', 15, 1),
(47, 'IDE & SDK', 'ide-sdk', 0, 0),
(48, 'Visual Studio', 'visual-studio', 47, 0),
(49, 'Xcode', 'xcode', 47, 0),
(50, 'CSS', 'css', 7, 0),
(51, 'Computer', 'computer', 0, 0),
(52, 'Computer Networking', 'computer-networking', 51, 0),
(53, 'Computer Science', 'computer-science', 51, 0),
(54, 'Development Story', 'development-story', 0, 0),
(55, 'DBMS', 'dbms', 0, 0),
(56, 'Unity', 'unity', 15, 1),
(57, 'Game Programming', 'game-programming', 15, 0),
(58, 'Win32', 'win32', 5, 0),
(59, 'Hardware', 'hardware', 0, 0),
(60, 'Electronics', 'electronics', 59, 0),
(61, 'Hardware Products', 'hardware-products', 59, 0),
(62, 'Smart World', 'smart-world', 0, 0),
(63, 'Smart Home', 'smart-home', 62, 0),
(64, 'Cloud Computing', 'cloud-computing', 51, 0),
(65, 'Arduino', 'arduino', 59, 0),
(66, 'JavaScript', 'javascript', 7, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

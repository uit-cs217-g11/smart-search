-- phpMyAdmin SQL Dump
-- version 4.4.13.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2016 at 01:08 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tag` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `category_id`, `title`, `description`, `author_id`, `content`, `tag`, `friendly_url`) VALUES
(1, 0, 'Lập trình C++', 'Học lập trình', 74, 'Hướng dẫn học lập trình', 'lập trình|c++', 'lap-trinh-cpp'),
(2, 0, 'Trí tuệ nhân tạo trong Game', 'Lập trình Game', 74, 'Hướng dẫn học lập trình trí tuệ nhân tạo trong Game', 'lập trình|c++', 'tri-tue-nhan-tao-trong-game');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `friendly_url`, `parent_id`) VALUES
(1, 'VOID', 'void', 0),
(2, 'NULL', 'null', 1),
(3, 'General Programming', 'general-programming', 0),
(4, 'Language', 'language', 0),
(5, 'OS Programming', 'os-programming', 0),
(6, 'Multimedia', 'multimedia', 0),
(7, 'Web Development', 'web-development', 0),
(8, 'MySQL', 'mysql', 55),
(9, 'Oracle', 'oracle', 55),
(10, 'SQL Server', 'sql-server', 55),
(11, 'Artificial Intelligent', 'artificial-intelligent', 3),
(12, 'Cryptography & Security', 'cryptography-security', 3),
(13, 'Data Structure & Algorithm', 'data-structure-algorithm', 3),
(14, 'Design Pattern', 'design-pattern', 3),
(15, 'Games', 'games', 0),
(16, 'Physics', 'physics', 3),
(17, 'Threads & Processes & IPC', 'threads-processes-ipc', 3),
(18, 'UML', 'uml', 3),
(19, 'Assembly', 'assembly', 4),
(20, 'Batch Script', 'batch-script', 4),
(21, 'C#', 'csharp', 4),
(22, 'C/C++', 'cplusplus', 4),
(23, 'Java', 'java', 4),
(24, 'Lua', 'lua', 4),
(25, 'Perl', 'perl', 4),
(26, 'Python', 'python', 4),
(27, 'Android', 'android', 5),
(28, 'iOS', 'ios', 5),
(29, 'Windows Phone', 'windows-phone', 5),
(30, 'DirectX', 'directx', 6),
(31, 'OpenGL', 'opengl', 6),
(32, 'SDL', 'sdl', 6),
(33, 'AJAX', 'ajax', 7),
(34, 'ASP.NET', 'asp-net', 7),
(35, 'HTML', 'html', 7),
(36, 'PHP', 'php', 7),
(37, 'Programming 101', 'programming-101', 0),
(38, 'Experience', 'experience', 54),
(39, 'STDIO Experience', 'stdio-experience', 54),
(40, 'Tools', 'tools', 54),
(41, 'CGI', 'cgi', 7),
(42, 'Metal', 'metal', 6),
(43, 'XML', 'xml', 7),
(44, 'Math', 'math', 37),
(45, 'Programming', 'programming', 37),
(46, 'Cocos2d-x', 'cocos2d-x', 15),
(47, 'IDE & SDK', 'ide-sdk', 0),
(48, 'Visual Studio', 'visual-studio', 47),
(49, 'Xcode', 'xcode', 47),
(50, 'CSS', 'css', 7),
(51, 'Computer', 'computer', 0),
(52, 'Computer Networking', 'computer-networking', 51),
(53, 'Computer Science', 'computer-science', 51),
(54, 'Development Story', 'development-story', 0),
(55, 'DBMS', 'dbms', 0),
(56, 'Unity', 'unity', 15),
(57, 'Game Programming', 'game-programming', 15),
(58, 'Win32', 'win32', 5),
(59, 'Hardware', 'hardware', 0),
(60, 'Electronics', 'electronics', 59),
(61, 'Hardware Products', 'hardware-products', 59),
(62, 'Smart World', 'smart-world', 0),
(63, 'Smart Home', 'smart-home', 62),
(64, 'Cloud Computing', 'cloud-computing', 51),
(65, 'Arduino', 'arduino', 59),
(66, 'JavaScript', 'javascript', 7);

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL,
  `word` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `weight` float NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`id`, `word`, `weight`, `article_id`) VALUES
(1, 'lập trình', 0.7854, 1),
(2, 'trí tuệ nhân tạo', 0.5, 1),
(3, 'lập trình', 0.3, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `keywords`
--
ALTER TABLE `keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

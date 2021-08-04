-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2021 at 07:44 AM
-- Server version: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gam_review`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `business_id` int(10) UNSIGNED DEFAULT NULL,
  `bookmark_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `business_id`, `bookmark_date`) VALUES
(28, 3, 3, '2020-12-13 18:40:24'),
(31, 3, 2, '2020-12-13 19:19:21'),
(32, 4, 5, '2020-12-13 22:58:06'),
(34, 4, 3, '2020-12-14 00:15:50'),
(36, 4, 4, '2020-12-14 00:21:15'),
(39, 7, 2, '2020-12-14 02:44:37'),
(40, 7, 3, '2020-12-14 02:44:47'),
(41, 7, 8, '2020-12-14 02:47:49'),
(42, 8, 3, '2020-12-14 22:49:21'),
(43, 3, 7, '2021-01-04 20:52:20'),
(44, 3, 1, '2021-01-08 18:01:05'),
(57, 10, 7, '2021-01-20 03:06:50'),
(58, 10, 9, '2021-01-20 03:09:38'),
(59, 10, 8, '2021-01-20 03:10:55'),
(60, 10, 14, '2021-01-20 03:11:09'),
(61, 10, 15, '2021-01-20 03:11:27'),
(63, 11, 11, '2021-01-24 17:58:28'),
(64, 14, 3, '2021-01-24 23:54:57'),
(65, 14, 4, '2021-01-24 23:55:17'),
(66, 14, 17, '2021-01-24 23:55:45'),
(67, 14, 21, '2021-01-24 23:59:16'),
(68, 15, 21, '2021-01-30 07:29:22'),
(69, 15, 17, '2021-01-30 07:30:46'),
(70, 15, 4, '2021-01-30 07:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `business_category` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `contact` varchar(100) NOT NULL,
  `opening_hours` text NOT NULL,
  `about` text NOT NULL,
  `picture` varchar(100) DEFAULT 'profile-none.png',
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `register_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `business_name`, `business_category`, `email`, `password`, `location`, `is_verified`, `contact`, `opening_hours`, `about`, `picture`, `is_blocked`, `register_date`) VALUES
(1, 'Bob\'s Car Repairs', 3, 'bob@gmail.com', '$2y$10$O6fGGnZIuw9l/kbPs8jmLuk2kQn2csjFPSfHZVSbke7jMkOMXMNGK', 'Fajara', 1, '121221', 'Mon 2pm - 4pm\r\nTues 5pm - 6pm\r\nWed 2am - 4pm', 'Repairs and stuff', '5fd15beee29d95.57108582.jpg', 0, '2020-12-09 23:21:18'),
(2, 'La Parisienne', 1, 'paris@gmail.com', '$2y$10$on3nIMqqvYHqMHH8oBpv1ep6D8vEIJLNV5RWIAbmQe04D6kwQWzNW', 'Fajara', 1, '1929812', 'Mon 2pm - 4pm\r\nTues 5pm - 6pm\r\nWed 2am - 4pm', 'Cakes and deliveries. We sell pastries and stuff ', '5fd15c97831260.11985615.jpg', 0, '2020-12-09 23:24:07'),
(3, 'Burger King', 1, 'burger@gmail.com', '$2y$10$8NEJZKubd/IB3Ypn6P3qheHDLuRq0lsjdySAZvbfjTVGRb.Mvp3vC', 'Chicago', 1, '1212212', 'Mon 2pm - 4pm\r\nTues 5pm - 6pm\r\nWed 2am - 4pm\r\nThur 9am - 4pm', 'Tasty food cooked fresh on the premises. Takeaway or delivery - call for our latest deals and offers. Welcome to Pizza World and Charcoal Grill - Order food online in Bracknell Wokingham and Ascot. It is easy fast and convenient, try our online website which contains our take away menu, also available on \'Just Eat\' \'Deliveroo\' and \'Uber Eats\'. Order online your favourite pizza, burgers and kebabs, and get free home delivery service.', '5fd15ce4d04d56.45967201.jpeg', 0, '2020-12-09 23:25:24'),
(4, 'Chipotle', 1, 'chipotle@gmail.com', '$2y$10$HRau9ug731PbtEY9OTYB9.VYaOP5GBgJDohuaTC5XtwHI61Qk1JAK', 'Serrekunda', 1, '4536282 - 9089219', 'Mon 2pm - 4pm\r\nTues 5pm - 6pm\r\nWed 2am - 4pm', 'Tasty food cooked fresh on the premises. Takeaway or delivery - call for our latest deals and offers. Welcome to Pizza World and Charcoal Grill - Order food online in Bracknell Wokingham and Ascot. It is easy fast and convenient, try our online website which contains our take away menu, also available on \'Just Eat\' \'Deliveroo\' and \'Uber Eats\'. Order online your favourite pizza, burgers and kebabs, and get free home delivery service.', '5fd15d96ee9c51.13458614.png', 0, '2020-12-09 23:28:22'),
(5, 'Sat Linkers', 3, 'linkers@gmail.com', '$2y$10$u/QOdIKyDVdLB99OpgYHverfFuOrufv6GXUgXf2B2PFE3ybVh6AWu', 'Kairaba Avenue', 1, '12122121', 'yvuuysiu112', '12122121', '5fd4bc9fbf2a12.94159718.jpg', 0, '2020-12-12 12:50:39'),
(7, 'Novella Salon', 5, 'novella@gmail.com', '$2y$10$eLZ2Ro8kw5IjJaZubhNGAOaNjK.dOkLMIFGvjSJJ0k9ZWSTsQdH/m', 'Chicago', 1, '4536282 9089219', 'Mosibud98h18  i12e1', '4536282 9089219', '5fd4bd7cb53a61.15564894.jpg', 0, '2020-12-12 12:54:20'),
(8, 'Jack', 5, 'jack@gmail.com', '$2y$10$Y9HfTVOlE2JNHMxYYOcIAuVRHcUfUqRQiW7v9r1ZAVWwPgEDP7wKm', 'Serrekunda', 1, '100130 129012', '24/7', 'We cut hair....As the weekend retreat for Thomas Gluck - one of the firm\'s principals - and his family, Tower House was designed as a four-storey tower with a \"treetop aerie\", affording mountain views across the nearby Catskill Park.', '5fd4be92b00699.48966449.jpg', 0, '2020-12-12 12:58:58'),
(9, 'Apple Store', 3, 'applestore@gmail.com', '$2y$10$qxKkAcRmLVwMslWeMuFf2uqNDhbtxFCwiZiFX4OG4BU31w17lNXOG', 'New York', 1, '12122121', 'y82899812', '12122121', '5fd4bfb09e1920.20639878.jpg', 0, '2020-12-12 13:03:44'),
(10, 'Ali Baba', 1, 'alibaba@gmail.com', '$2y$10$nipg2xUKY.OYHg1o3Y5Sh.rb2lGsaxR1pIIrgot3Ml4Li1A1AjE9K', 'Kotu', 1, '12122121', '2234132', '12122121', '5fd4bffce46786.70291532.jpg', 0, '2020-12-12 13:05:00'),
(11, 'The Cove', 1, 'cove@gmail.com', '$2y$10$9B2ZMLCLnM3d9xronhi8LurNJblmmv/Hq/K5cJUD8bmMvy00iG.3q', 'Kotu', 1, '4536282 9089219', 'We are open 24/7', '4536282 9089219', '5fd7f47b16f941.83761252.jpg', 0, '2020-12-14 23:25:47'),
(12, 'Sephora Jane', 2, 'sephora@gmail.com', '$2y$10$wLOcc//UZ7ZyldjEn7QKvuxpffjbxaKlQhRrGO1FnHEhjVB70yOB6', 'Faraba', 1, '4536282 9089219', '24/7 baby', 'We sell makeup and stuff', '5fd8f1452185b0.30366398.jpeg', 0, '2020-12-14 23:40:01'),
(13, 'HER Cosmetics', 2, 'cosmetics@gmail.com', '$2y$10$sNA9UgC8tHG8.ZJfb0SapOYWvWOUG8OHEltez0TFND.rZDMM.iA8K', 'Bakau', 1, '4536282 9089219', 'We are open 24/7', '4536282 9089219', '5fd7f8e4aaf812.04765939.jpg', 0, '2020-12-14 23:44:36'),
(14, 'Luxury Auto', 3, 'luxury@gmail.com', '$2y$10$dtwwJ.gyu7j9NPOhNpQvqepJ39jBf2T43VO0gJwMr2XrH49B/fx4q', 'Kairaba Avenue', 1, '4536282 9089219', '24/7', '4536282 9089219', '5fd7f97ec7cfa6.96099575.png', 0, '2020-12-14 23:47:10'),
(15, 'The Auto Repair Shop', 3, 'repair@gmail.com', '$2y$10$/Ov.6umSgjpRFSNbM3c3VO7f0MW1LRAnB25/z6ROGwhhDRWGNxiLi', 'Banjul', 1, '4536282 9089219', '\r\nMonday	11:00 - 22:00\r\nTuesday	11:00 - 22:00\r\nWednesday	11:00 - 22:00\r\nThursday	11:00 - 22:00\r\nFriday	11:00 - 22:00\r\nSaturday	11:00 - 22:00\r\nSunday	11:00 - 22:00', '4536282 9089219', '5fd8145d28ef74.02238452.jpg', 0, '2020-12-15 01:41:49'),
(16, 'Studio Allston', 6, 'studio@gmail.com', '$2y$10$fU6cwjq0TNNW5BEBsxdNMuHqoouI.8TNfnSkgHRrICVALYGSgV3CO', 'Fajara', 1, '213424 1212133', '24/7', '213424 1212133', '600e04216d0dc5.33495616.jpg', 0, '2021-01-24 23:34:57'),
(17, 'Bulgari', 6, 'bulgari@gmail.com', '$2y$10$MYpHbZbqwbfcXsMEB0eZGeZ/L3/kcEOXa08e6kAE9go/BZZuWv0Zm', 'Kairaba Avenue', 1, '100130 129012', '24/7', '100130 129012', '600e048e324f14.51275412.jpg', 0, '2021-01-24 23:36:46'),
(18, 'Olympia Sports', 4, 'olympia@gmail.com', '$2y$10$/irruLqXTpQ7SI5LilI5x./Vh7dApYC53ssbW24lq4XTLlKeO114i', 'Chicago', 1, '631671 0928982', '24/7', '631671 0928982', '600e05739efb92.29796975.jpg', 0, '2021-01-24 23:40:35'),
(19, 'Hibbett', 4, 'hibbett@gmail.com', '$2y$10$e0IFlBl0UvjlQIruT9uHEeiBDrp3KoffS3R6EgKEnAhiLUEk2klHq', 'New York', 1, '4536282 9089219', '24/7', '4536282 9089219', '600e063d383754.48284190.jpeg', 0, '2021-01-24 23:43:57'),
(20, 'The Clay Oven', 1, 'clay@gmail.com', '$2y$10$o/0Vpwr21ZZ/XpWr9qWq/usqu5EozyXbQJQNUuzmdRj33uhTmrjxG', 'Brikama', 1, '4536282 9089219', '24/7', '4536282 9089219', '600e08494ec912.74871487.jpg', 0, '2021-01-24 23:52:41'),
(21, 'Seneraunt', 1, 'seneraunt@gmail.com', '$2y$10$qy/JLXb.fHk9iltOLQRQ9uSzz67XOZBInz1TejlJuwy/CSe9ChoIy', 'Dakar', 1, '4536282 9089219', '24/7', '4536282 9089219', '600e0898a3c643.16889295.jpg', 0, '2021-01-24 23:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(3, 'Automotive'),
(2, 'Cosmetics '),
(6, 'Hotels'),
(1, 'Restaurants'),
(5, 'Salons'),
(4, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_comment` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `business_id` int(10) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `business_reply` varchar(255) DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp(),
  `reply_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_comment`, `user_id`, `business_id`, `rating`, `business_reply`, `review_date`, `reply_date`) VALUES
(1, 'Changed my review lol! 5 stars', 3, 3, 5, 'Woohoo go ted!', '2020-12-12 14:32:46', '2020-12-14 22:44:50'),
(2, 'Awful cake', 3, 2, 1, NULL, '2020-12-12 15:48:45', NULL),
(3, 'orangensaft', 2, 3, 3, NULL, '2020-12-12 16:18:46', NULL),
(4, 'Meh', 3, 8, 3, NULL, '2020-12-13 01:24:15', NULL),
(5, 'Love it!', 3, 4, 5, NULL, '2020-12-13 01:36:52', NULL),
(6, 'Do better guys', 3, 7, 1, NULL, '2020-12-13 18:23:50', NULL),
(7, 'The morally corrupt Burger King', 4, 3, 1, 'Oh shut it Camille!', '2020-12-13 22:56:09', '2020-12-14 22:45:12'),
(8, 'Ali what now?', 4, 10, 1, NULL, '2020-12-13 22:57:00', NULL),
(9, 'Friendly workers, bad headphones', 4, 5, 2, NULL, '2020-12-13 22:57:55', NULL),
(10, 'This place sucks', 5, 2, 1, 'Gurl we know', '2020-12-13 23:00:52', '2020-12-14 22:50:57'),
(11, 'Same old product every year', 5, 9, 3, NULL, '2020-12-13 23:01:20', NULL),
(12, 'yeahh im into the burgers', 5, 3, 5, 'we know sis', '2020-12-13 23:01:48', '2021-01-08 18:01:51'),
(13, 'Beats lyme disease i guess', 6, 3, 4, NULL, '2020-12-13 23:03:42', NULL),
(14, 'Change Rinna\'s haircut please. She\'s had it for over 20 years', 6, 7, 4, NULL, '2020-12-13 23:05:31', NULL),
(15, 'Hate it', 3, 5, 1, NULL, '2020-12-13 23:59:08', NULL),
(16, 'teslas ans s', 3, 1, 4, NULL, '2020-12-14 00:11:25', NULL),
(17, 'Novella sorta rhymes with Salmonella', 4, 7, 1, NULL, '2020-12-14 00:52:53', NULL),
(18, 'Great burgers', 7, 3, 5, NULL, '2020-12-14 02:40:58', NULL),
(19, 'What\'s that pine tree doing there?', 7, 10, 1, NULL, '2020-12-14 02:42:51', NULL),
(20, 'Kinda average', 8, 3, 3, NULL, '2020-12-14 22:46:15', NULL),
(21, 'The chocolate cake is not so bad.. You are still getting 1 star tho', 8, 2, 1, NULL, '2020-12-14 22:50:04', NULL),
(22, 'Beats, Bears, Battlestar Galactica', 11, 3, 3, NULL, '2021-01-24 17:44:08', NULL),
(23, 'Das buritto schmeckt gut!', 11, 4, 5, NULL, '2021-01-24 17:45:35', NULL),
(24, 'Got the job done!', 11, 8, 4, NULL, '2021-01-24 17:46:11', NULL),
(25, 'It looks alright..', 11, 11, 3, NULL, '2021-01-24 17:58:49', NULL),
(26, 'Best restaurant in town!', 12, 11, 5, NULL, '2021-01-24 18:03:44', NULL),
(27, 'If I had 2 bullets and LP was in a room with Bin Laden and Satan I would shoot LP twice', 12, 2, 1, NULL, '2021-01-24 18:05:01', NULL),
(28, 'top', 14, 3, 5, NULL, '2021-01-24 23:54:55', NULL),
(29, 'Nice food\r\n', 14, 4, 4, NULL, '2021-01-24 23:55:15', NULL),
(30, 'Modern af', 14, 17, 5, NULL, '2021-01-24 23:55:59', NULL),
(31, 'love it', 14, 11, 5, NULL, '2021-01-24 23:56:25', NULL),
(32, 'Nice cuts', 14, 8, 5, NULL, '2021-01-24 23:57:05', NULL),
(33, 'good work ethic', 14, 1, 5, NULL, '2021-01-24 23:58:06', NULL),
(34, 'the macbook is ayt', 14, 9, 5, NULL, '2021-01-24 23:58:31', NULL),
(35, 'Great customer service\r\n', 14, 21, 3, NULL, '2021-01-24 23:59:30', NULL),
(36, 'They also sell shoes', 14, 19, 3, NULL, '2021-01-24 23:59:49', NULL),
(37, 'Edible enough', 15, 21, 4, NULL, '2021-01-30 07:29:16', NULL),
(38, 'cool', 15, 17, 4, NULL, '2021-01-30 07:31:01', NULL),
(39, 'meh', 15, 1, 3, NULL, '2021-01-30 07:31:24', NULL),
(40, 'overhyped\r\n', 15, 4, 3, NULL, '2021-01-30 07:32:02', NULL),
(41, 'stained shirts', 15, 19, 1, NULL, '2021-01-30 07:33:43', NULL),
(42, 'Ich bin müde', 15, 3, 5, NULL, '2021-01-30 07:34:37', NULL),
(43, 'You guys suck so hard! Someone needs to press the delete button on you!', 15, 2, 1, NULL, '2021-01-30 07:36:22', NULL),
(44, 'edible', 15, 11, 5, NULL, '2021-01-30 07:37:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(35) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `register_date` datetime DEFAULT current_timestamp(),
  `profile_pic` varchar(100) DEFAULT 'profile-none.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `is_blocked`, `register_date`, `profile_pic`) VALUES
(1, 'allymenten', 'allymenten@gmail.com', '$2y$10$dx7EgBjx8IVf15aDhKrqbuYGVrNSsQqf1PY1edo003BSSwz4hZ2YW', 0, 0, '2020-12-12 13:54:27', 'profile-none.png'),
(2, 'johndoe', 'john@gmail.com', '$2y$10$7NCpcOB0AXHsNBfiuyIdreLMdmULJyay2UMKSIhFKYS//MAjgbGT6', 0, 0, '2020-12-12 14:21:46', 'profile-none.png'),
(3, 'Ted Talk', 'tedtalk@gmail.com', '$2y$10$B4MfnZ1eTucdwDf6APzPwORpldsjk5eT8V3LAmI.7JIByCqzuIbOm', 0, 0, '2020-12-12 14:26:43', 'profile-none.png'),
(4, 'Camille Grammer', 'camille@gmail.com', '$2y$10$iIaCJGUT0ROIEV7356GyMuHOS1mh.ccw8CMMnYJnEQUZz1zE.3Xxe', 0, 0, '2020-12-13 22:55:38', 'profile-none.png'),
(5, 'Kyle Richards', 'kyle@gmail.com', '$2y$10$TTwojoKPBpmrs3.LvXfXKOgk1g7UINAPPRNZQWKqaxuk7k3JXx8kS', 0, 0, '2020-12-13 23:00:29', 'profile-none.png'),
(6, 'Yolanda Foster', 'yolanda@gmail.com', '$2y$10$ZN8yIJ5tiB/u2G3yhXwth.LWtpj3RHRkB62AscN1rFwxNXNRb9Zji', 0, 0, '2020-12-13 23:03:09', 'profile-none.png'),
(7, 'Kim Richards', 'richards@gmail.com', '$2y$10$rKEqEct4/RBKuRFMP33ObOXupT2cghwL9UxEtfmOHdlQtRy3hNFuy', 0, 0, '2020-12-14 02:40:25', 'profile-none.png'),
(8, 'Faye Resnick', 'faye@gmail.com', '$2y$10$KDgJQtumKXZLNBQnk/i.VOLRwdD.XR2BO2KeEWY8DHH2w3UEJUy4S', 0, 0, '2020-12-14 22:45:59', 'profile-none.png'),
(9, 'Fatou Mbye', 'admin@gamreview.com', '$2y$10$XCMz/NfJFccfSYovO8TuCekfLm8GUQQRNK2PZ4P0mEO.TF8pU40eG', 1, 0, '2021-01-04 14:52:25', 'admin.png'),
(10, 'Jungle', 'jungle@gmail.com', '$2y$10$FvMCYzWi2E1SoSAScXcYMuCFUYvWDJzyrlmmN/8dKAuybzvPMMw8O', 0, 0, '2021-01-20 02:56:13', 'profile-none.png'),
(11, 'Dwight Schrute', 'dwight@gmail.com', '$2y$10$ELjHdlUzVO/jEJOgUNln3e076kX5rxylzXyb5a2CAs2qSniXmaZQW', 0, 0, '2021-01-24 17:43:28', 'profile-none.png'),
(12, 'Michael Scott', 'michael@gmai.com', '$2y$10$.neQ9q3xl/j31JfHi.UFNeYiaeNKJYd.ZnD4VA.KLNwpgO6cxcxt.', 0, 0, '2021-01-24 18:02:31', 'profile-none.png'),
(13, 'Jan Levinson', 'jan@gmail.com', '$2y$10$A/VifxpUT5EAfw1Fbx29sOrtPsIbd8L9A5.dmaDsvp2N81MbTTEB.', 0, 0, '2021-01-24 18:09:27', 'profile-none.png'),
(14, 'Jim Halpert', 'jim@gmail.com', '$2y$10$sepm9ewwsReo8Xd5AzX7Ce1n3iAnFf6/IDpjOEKfr4RG3gPvunzee', 0, 0, '2021-01-24 23:54:40', 'profile-none.png'),
(15, 'Creed', 'creed@gmail.com', '$2y$10$4OejwLJUtJrMv6EjEZk4L.y5ta.AdqML00i74.jnTZTyGtJt3Qwvu', 0, 0, '2021-01-30 07:28:53', 'profile-none.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `business_id` (`business_id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `business_name` (`business_name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `business_category` (`business_category`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `business_id` (`business_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`);

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_ibfk_1` FOREIGN KEY (`business_category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

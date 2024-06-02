-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2024 at 04:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leaguedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(37, '2024_02_28_180121_create_teams_table', 2),
(38, '2024_02_28_180301_create_players_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `salary` double NOT NULL,
  `position` varchar(255) NOT NULL,
  `team_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `first_name`, `last_name`, `salary`, `position`, `team_id`) VALUES
(1, 'Velva', 'Waters', 71681.96, 'Point Guard', 12),
(2, 'Litzy', 'Rippin', 49564.95, 'Small Forward', 1),
(3, 'Edison', 'Brekke', 32456.6, 'Center', 1),
(4, 'Bret', 'Oberbrunner', 83020.47, 'Center', 1),
(5, 'Antwan', 'Yundt', 72352.17, 'Point Guard', 1),
(6, 'Myah', 'Shanahan', 71862.09, 'Center', 1),
(7, 'Ignatius', 'Effertz', 93716.01, 'Small Forward', 1),
(8, 'Braulio', 'Watsica', 98121.55, 'Power Forward', 1),
(9, 'Bradly', 'Lang', 90047.54, 'Power Forward', 1),
(10, 'Elisa', 'Heaney', 65314.18, 'Point Guard', 12),
(11, 'Grayce', 'Krajcik', 20174.12, 'Small Forward', 2),
(12, 'Darius', 'Daugherty', 95344.86, 'Power Forward', 2),
(13, 'Efren', 'Donnelly', 56237.12, 'Shooting Guard', 2),
(14, 'Hollis', 'Schmidt', 40343.14, 'Small Forward', 2),
(15, 'Wilhelm', 'Ankunding', 93069.87, 'Center', 2),
(16, 'Jena', 'Schinner', 94036.69, 'Power Forward', 2),
(17, 'Rowena', 'Williamson', 59082.34, 'Small Forward', 2),
(18, 'Adrienne', 'Harber', 58786.23, 'Small Forward', 2),
(19, 'Beverly', 'Ryan', 74191.75, 'Shooting Guard', 2),
(20, 'Alejandrin', 'Goldner', 62716.13, 'Small Forward', 2),
(21, 'Josianne', 'Feest', 71633.37, 'Small Forward', 3),
(22, 'Larissa', 'Ryan', 66021.9, 'Small Forward', 3),
(23, 'Rebeca', 'Nienow', 28154.22, 'Center', 3),
(24, 'Baron', 'Miller', 28746.67, 'Small Forward', 3),
(25, 'Kenya', 'Bartoletti', 41799.08, 'Point Guard', 3),
(26, 'Jodie', 'McClure', 61649.84, 'Small Forward', 3),
(27, 'Hope', 'Jerde', 46535.53, 'Small Forward', 3),
(28, 'Mya', 'Stark', 25007.62, 'Shooting Guard', 3),
(29, 'Dora', 'Farrell', 74651.25, 'Center', 3),
(30, 'Royce', 'Gorczany', 95460.36, 'Center', 3),
(31, 'Dora', 'Dooley', 95100.04, 'Power Forward', 4),
(32, 'Vanessa', 'Jakubowski', 60946.56, 'Power Forward', 4),
(33, 'Raphaelle', 'Maggio', 72493.9, 'Point Guard', 4),
(34, 'Carli', 'Ankunding', 86483.73, 'Center', 4),
(35, 'Henderson', 'Buckridge', 83095.49, 'Power Forward', 4),
(36, 'Cleora', 'Jacobi', 99210.12, 'Point Guard', 4),
(37, 'Leonie', 'Kshlerin', 53929.99, 'Power Forward', 4),
(38, 'Wilfredo', 'Koelpin', 36073.01, 'Small Forward', 4),
(39, 'Douglas', 'Gleichner', 88910.13, 'Power Forward', 4),
(40, 'Alejandrin', 'Harber', 46046.04, 'Small Forward', 4),
(41, 'Agnes', 'Larkin', 64801.78, 'Small Forward', 5),
(42, 'Katlyn', 'Konopelski', 35752.41, 'Center', 5),
(43, 'Wilfredo', 'Mohr', 61231.73, 'Small Forward', 5),
(44, 'Yadira', 'Gislason', 68720.6, 'Point Guard', 5),
(45, 'Adrain', 'Hintz', 37668.33, 'Point Guard', 5),
(46, 'Judge', 'Shields', 25943.4, 'Point Guard', 5),
(47, 'Alexys', 'O\'Conner', 49273.78, 'Shooting Guard', 5),
(48, 'Anastacio', 'Walker', 62900.57, 'Shooting Guard', 5),
(49, 'Hellen', 'Schowalter', 49053.73, 'Power Forward', 5),
(50, 'Louie', 'Schiller', 38692.81, 'Power Forward', 5),
(51, 'Bertram', 'Goldner', 74108.08, 'Center', 6),
(52, 'Andre', 'Toy', 41809.42, 'Small Forward', 6),
(53, 'Ferne', 'Ledner', 44275.82, 'Power Forward', 6),
(54, 'Bryon', 'Schultz', 79209.52, 'Shooting Guard', 6),
(55, 'Jacques', 'Johns', 34252.03, 'Small Forward', 6),
(56, 'Ida', 'Cruickshank', 37347.71, 'Power Forward', 6),
(57, 'Skylar', 'Jacobi', 93563.52, 'Shooting Guard', 6),
(58, 'Kristy', 'Kerluke', 95021.87, 'Shooting Guard', 6),
(59, 'Dawson', 'Dickinson', 58541.93, 'Small Forward', 6),
(60, 'Danika', 'Beer', 41389.13, 'Point Guard', 6),
(61, 'Myles', 'Lang', 26271.1, 'Point Guard', 7),
(62, 'Dusty', 'Hermann', 98136.5, 'Shooting Guard', 7),
(63, 'Dayne', 'Wiza', 69946.11, 'Small Forward', 7),
(64, 'Maye', 'Langworth', 24294.13, 'Power Forward', 7),
(65, 'Sidney', 'Stiedemann', 77443.95, 'Point Guard', 7),
(66, 'Eleonore', 'Johnston', 61854.79, 'Shooting Guard', 7),
(67, 'Aliyah', 'Barrows', 34778.27, 'Center', 7),
(68, 'Garett', 'Becker', 83935.38, 'Point Guard', 7),
(69, 'Enoch', 'Gaylord', 60872.53, 'Power Forward', 7),
(70, 'Thelma', 'Hansen', 24751.68, 'Power Forward', 7),
(71, 'Devante', 'Osinski', 75280.33, 'Center', 8),
(72, 'Gaetano', 'Bashirian', 38704.11, 'Point Guard', 8),
(73, 'Kennedy', 'Toy', 81562.31, 'Center', 8),
(74, 'Toni', 'Mills', 60830.03, 'Power Forward', 8),
(75, 'Briana', 'Hahn', 51300.09, 'Small Forward', 8),
(76, 'Jack', 'Daugherty', 38073.51, 'Point Guard', 8),
(77, 'Susanna', 'Sipes', 95151.4, 'Point Guard', 8),
(78, 'Allie', 'Wintheiser', 52196.89, 'Power Forward', 8),
(79, 'Rosemary', 'Kautzer', 68202.66, 'Small Forward', 8),
(80, 'Constance', 'Keebler', 25286.83, 'Point Guard', 8),
(81, 'Earnestine', 'Orn', 59423.01, 'Small Forward', 9),
(82, 'Matteo', 'Hamill', 23775.88, 'Point Guard', 9),
(83, 'Dameon', 'Yundt', 36233.12, 'Point Guard', 9),
(84, 'Josie', 'Prohaska', 92131.73, 'Power Forward', 9),
(85, 'Martin', 'Collier', 73205.17, 'Shooting Guard', 9),
(86, 'Damion', 'Considine', 65301.69, 'Power Forward', 9),
(87, 'Maybell', 'Ebert', 56007.46, 'Center', 9),
(88, 'Alena', 'Cartwright', 33311.56, 'Power Forward', 9),
(89, 'Lou', 'Towne', 50186.04, 'Power Forward', 9),
(90, 'Ardella', 'Hodkiewicz', 54482.13, 'Shooting Guard', 9),
(91, 'Duane', 'Heathcote', 20712.19, 'Small Forward', 10),
(92, 'Mazie', 'McCullough', 69234.35, 'Small Forward', 10),
(93, 'Clara', 'Berge', 98049.76, 'Power Forward', 10),
(94, 'Rebeca', 'Kozey', 66956.35, 'Center', 10),
(95, 'Tressa', 'Denesik', 63150.43, 'Small Forward', 10),
(96, 'Eudora', 'Bogan', 23970.04, 'Small Forward', 10),
(97, 'Annabell', 'Hodkiewicz', 69402.5, 'Point Guard', 10),
(98, 'Aditya', 'Emard', 62032.61, 'Center', 10),
(99, 'Magdalen', 'Sauer', 78616.65, 'Small Forward', 10),
(100, 'Monica', 'Bosco', 44640.43, 'Power Forward', 10),
(101, 'Megane', 'Daniel', 32490.67, 'Small Forward', 11),
(102, 'Katheryn', 'Kozey', 49689.24, 'Power Forward', 11),
(103, 'Adella', 'Smith', 68406.04, 'Point Guard', 11),
(104, 'Camille', 'Steuber', 42214.97, 'Shooting Guard', 11),
(105, 'Olen', 'Keebler', 31271.56, 'Small Forward', 11),
(106, 'Waylon', 'Rohan', 49281.07, 'Shooting Guard', 11),
(107, 'Shaun', 'Halvorson', 70079.35, 'Shooting Guard', 11),
(108, 'Ottis', 'Ondricka', 51291.62, 'Small Forward', 11),
(109, 'Brooke', 'Braun', 49955.88, 'Shooting Guard', 11),
(110, 'Bennie', 'Kemmer', 30285.76, 'Center', 11),
(111, 'Garrick', 'Maggio', 60603.3, 'Power Forward', 12),
(112, 'Carlos', 'Williamson', 68049.07, 'Shooting Guard', 12),
(113, 'Stacy', 'Spencer', 61908.76, 'Point Guard', 12),
(114, 'Vivien', 'Sanford', 67918.18, 'Point Guard', 12),
(115, 'Chaim', 'Kohler', 78499.4, 'Shooting Guard', 12),
(116, 'Ransom', 'Cole', 96832.01, 'Center', 12),
(117, 'Jesse', 'Dooley', 40852.54, 'Small Forward', 12),
(118, 'Krystina', 'Labadie', 81923.28, 'Center', 12),
(119, 'Desmond', 'McKenzie', 83512.62, 'Point Guard', 12),
(120, 'Deanna', 'Corwin', 89328.57, 'Point Guard', 12),
(121, 'Juliet', 'Jones', 49816.66, 'Point Guard', 13),
(122, 'Dennis', 'Bode', 79049.77, 'Point Guard', 13),
(123, 'Edgar', 'Dibbert', 81157.12, 'Point Guard', 13),
(124, 'Leanne', 'O\'Connell', 85303.21, 'Center', 13),
(125, 'Bradly', 'Purdy', 30089.79, 'Power Forward', 13),
(126, 'Everardo', 'Hane', 94969.96, 'Power Forward', 13),
(127, 'Erna', 'Kohler', 73628.2, 'Shooting Guard', 13),
(128, 'Heaven', 'Kirlin', 90866.92, 'Small Forward', 13),
(129, 'Dell', 'Berge', 74656.72, 'Point Guard', 13),
(130, 'Arianna', 'Green', 76102.71, 'Power Forward', 13),
(131, 'Isac', 'Kirlin', 53277.42, 'Power Forward', 14),
(132, 'Eunice', 'Mann', 76264.23, 'Center', 14),
(133, 'Viola', 'McGlynn', 81828.39, 'Shooting Guard', 14),
(134, 'Bo', 'Hoeger', 25826.44, 'Point Guard', 14),
(135, 'Sonya', 'Goldner', 92595.03, 'Shooting Guard', 14),
(136, 'Pablo', 'Halvorson', 52158.26, 'Power Forward', 14),
(137, 'Rosemary', 'Swift', 33625.74, 'Shooting Guard', 14),
(138, 'Alanis', 'Olson', 33575.32, 'Point Guard', 14),
(139, 'Vada', 'Veum', 59764.82, 'Center', 14),
(140, 'Enrique', 'Shanahan', 43759.06, 'Small Forward', 14),
(141, 'Meda', 'Mohr', 75074.74, 'Point Guard', 15),
(142, 'Enrique', 'Mills', 95065.91, 'Small Forward', 15),
(143, 'Burley', 'Kemmer', 32247.47, 'Small Forward', 15),
(144, 'Dejah', 'Grant', 82467.96, 'Center', 15),
(145, 'Trystan', 'Gottlieb', 28603.93, 'Point Guard', 15),
(146, 'Darlene', 'Medhurst', 46699.5, 'Shooting Guard', 15),
(147, 'Hailee', 'Orn', 81805.57, 'Shooting Guard', 15),
(148, 'Kyle', 'Wuckert', 67592.67, 'Power Forward', 15),
(149, 'Gabriel', 'Sawayn', 22759.33, 'Center', 15),
(150, 'Brian', 'Gutkowski', 67273.69, 'Shooting Guard', 15),
(151, 'Aymane', 'Testing', 25, 'Center', 16);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `stadium` varchar(255) NOT NULL,
  `numMembers` varchar(255) NOT NULL,
  `budget` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `stadium`, `numMembers`, `budget`) VALUES
(1, 'Hellenfort Eos', 'Randi Lakin', '2422038', 412246.75),
(2, 'Klingstad Saepe', 'Bernie Crooks Jr.', '8612503', 382288.7),
(3, 'Port Michelle Suscipit', 'Clemmie Greenfelder Jr.', '8273479', 224681.53),
(4, 'Lutherburgh Aut', 'Arlie DuBuque', '8664006', 140166.73),
(5, 'West Garland Corporis', 'Asa Thiel', '1219646', 79560.11),
(6, 'South Kianchester Laudantium', 'Maynard Hoppe', '5207793', 838375.68),
(7, 'Schimmelfurt Harum', 'Dr. Andres Greenholt IV', '6989364', 333625.06),
(8, 'Rodriguezside Sequi', 'Mrs. Corene Leannon I', '5039628', 974595.68),
(9, 'Lake Braedentown Facilis', 'Ozella Ullrich', '5737839', 544144.03),
(10, 'Dulcefurt Consequatur', 'Mr. Raymundo Schumm', '3945383', 188509.71),
(11, 'Emardport Accusantium', 'Mr. Arnold Shanahan IV', '5746606', 840329.33),
(12, 'Keshawnland Sapiente', 'Prof. Maurice Kozey', '3280192', 601612.32),
(13, 'East Marley Esse', 'Chandler Kiehn', '4842075', 807122.79),
(14, 'Port Nickolas Repellat', 'Jaylen Konopelski Jr.', '1908967', 573182.63),
(15, 'Hendersonshire Molestias', 'Emmie Spencer', '7687288', 872923.63),
(16, 'Aymane\'s potatoes', 'Big stadium', '20', 900);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `players_team_id_index` (`team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teams_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

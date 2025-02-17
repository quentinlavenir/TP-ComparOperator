-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 17, 2025 at 03:19 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tp_comparoperator`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(1, 'Michel'),
(2, 'René'),
(3, 'Paul'),
(5, 'Rayane'),
(6, 'Quentin'),
(7, 'Samantha Curtis'),
(8, 'Nico'),
(9, 'Tom');

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `tour_operator_id` int NOT NULL,
  `expires_at` datetime NOT NULL,
  `signatory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`tour_operator_id`, `expires_at`, `signatory`) VALUES
(1, '2022-02-09 14:50:07', 'Jean Bertrand'),
(2, '2023-01-02 14:50:07', 'Bernard Michel'),
(9, '2025-12-17 09:47:53', 'admin'),
(10, '2025-12-17 10:39:18', 'admin'),
(12, '2025-12-19 09:54:14', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `id` int NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`id`, `location`, `price`, `description`) VALUES
(1, 'Rome', 1650, 'Plages paradisiaques, temples mystiques et rizières verdoyantes, offre une immersion entre détente et spiritualité, idéale pour les amoureux de nature et de culture.'),
(2, 'Londres', 1100, 'Cette ancienne capitale impériale séduit par ses temples millénaires, ses jardins zen et ses ruelles authentiques où le charme traditionnel prend vie.'),
(3, 'Monaco', 1390, 'Aux portes des paysages volcaniques et des aurores boréales, offre une ambiance chaleureuse où nature sauvage et modernité nordique se rencontrent.'),
(4, 'Tunis', 2390, 'Plages paradisiaques, temples mystiques et rizières verdoyantes, offre une immersion entre détente et spiritualité, idéale pour les amoureux de nature et de culture.');

-- --------------------------------------------------------

--
-- Table structure for table `destination_tour_operator`
--

CREATE TABLE `destination_tour_operator` (
  `id` int NOT NULL,
  `destination_id` int NOT NULL,
  `tour_operator_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `destination_tour_operator`
--

INSERT INTO `destination_tour_operator` (`id`, `destination_id`, `tour_operator_id`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 1),
(4, 4, 3),
(9, 4, 1),
(10, 4, 9),
(11, 1, 3),
(12, 1, 11),
(13, 1, 1),
(14, 1, 10),
(15, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `tour_operator_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `message`, `tour_operator_id`, `author_id`) VALUES
(1, 'Super voyage, prestation au top !!', 2, 1),
(2, 'Tout est inclus dans le prix, c\'est cool, je recommande', 3, 3),
(3, 'Un peu cher, mais ça vaut le coup', 2, 3),
(4, 'arnaque!!!! a fuire!!!', 2, 2),
(5, 'Incroyable séjour !', 10, 5),
(6, 'J\'ai adoré !', 10, 6),
(7, 'Je devrais vraiment faire ça plus souvent.', 10, 6),
(8, 'Je devrais vraiment faire ça plus souvent.', 10, 5),
(9, 'Incroyable séjour !', 11, 6),
(10, 'Super ', 3, 5),
(11, 'Impedit odio quae u', 1, 7),
(12, 'Je devrais vraiment faire ça plus souvent.', 11, 5),
(13, 'Impedit odio quae u', 2, 8),
(14, 'Super ', 2, 5),
(15, 'Impedit odio quae u', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `id` int NOT NULL,
  `value` int NOT NULL,
  `tour_operator_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`id`, `value`, `tour_operator_id`, `author_id`) VALUES
(1, 5, 2, 1),
(2, 4, 3, 3),
(3, 1, 2, 2),
(4, 1, 11, 5),
(5, 4, 11, 6),
(6, 5, 2, 5),
(7, 3, 10, 5),
(8, 2, 2, 9),
(9, 3, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `tour_operator`
--

CREATE TABLE `tour_operator` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tour_operator`
--

INSERT INTO `tour_operator` (`id`, `name`, `link`, `description`) VALUES
(1, 'Salaun Holidays', 'https://www.salaun-holidays.com/', 'Un des plus anciens tours opérateurs français, spécialisé dans les voyages sur mesure et les séjours tout compris en France et à l\'international'),
(2, 'Fram', 'https://www.fram.fr/', 'Spécialiste des vacances culturelles, séjours en bord de mer et escapades nature, en France et en Europe.'),
(3, 'Heliades', 'https://www.heliades.fr/', 'Un des plus anciens tours opérateurs français, spécialisé dans les voyages sur mesure et les séjours tout compris en France et à l\'international'),
(5, 'August Melendez', 'https://www.tedypi.in', 'Référence historique des vacances organisées, propose des séjours balnéaires, circuits culturels et clubs de vacances dans le monde entier.'),
(9, 'Rafael Vargas', 'https://www.qaqytyzinutaq.tv', 'Spécialiste des vacances culturelles, séjours en bord de mer et escapades nature, en France et en Europe.'),
(10, 'Nathan Barnett', 'https://www.ganyjeci.cm', 'Référence historique des vacances organisées, propose des séjours balnéaires, circuits culturels et clubs de vacances dans le monde entier.'),
(11, 'Stephen Young', 'https://www.kyvezolux.me.uk', 'Référence historique des vacances organisées, propose des séjours balnéaires, circuits culturels et clubs de vacances dans le monde entier.'),
(12, 'Rashad Harper', 'https://www.figugomexofy.in', 'Spécialiste des vacances culturelles, séjours en bord de mer et escapades nature, en France et en Europe.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`tour_operator_id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination_tour_operator`
--
ALTER TABLE `destination_tour_operator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_tour_operator_destination_relation` (`destination_id`),
  ADD KEY `destination_tour_operator_tour_operator_relation` (`tour_operator_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_tour_operator` (`tour_operator_id`),
  ADD KEY `review_author` (`author_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_tour_operator` (`tour_operator_id`),
  ADD KEY `score_author` (`author_id`);

--
-- Indexes for table `tour_operator`
--
ALTER TABLE `tour_operator`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `destination_tour_operator`
--
ALTER TABLE `destination_tour_operator`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tour_operator`
--
ALTER TABLE `tour_operator`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Constraints for table `destination_tour_operator`
--
ALTER TABLE `destination_tour_operator`
  ADD CONSTRAINT `destination_tour_operator_destination_relation` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `destination_tour_operator_tour_operator_relation` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `review_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `score_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

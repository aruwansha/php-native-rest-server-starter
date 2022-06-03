-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_taniver
CREATE DATABASE IF NOT EXISTS `db_taniver` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `db_taniver`;

-- Dumping structure for table db_taniver.games
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `genre_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(150) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  `video_link` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_taniver.games: ~6 rows (approximately)
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` (`id`, `user_id`, `genre_id`, `title`, `image`, `link`, `video_link`, `created_at`) VALUES
	(1, 1, 1, 'Resident Evil 2: REMAKE', 'upload/1654234311.png', 'https://www.steamcommunity.com/', 'https://www.youtube.com', '2022-05-29 11:08:48'),
	(2, 1, 1, 'Counter Strike: Global Offensive', 'upload/1654234222.jpg', 'https://www.steamcommunity.com/', 'https://www.youtube.com', '2022-05-29 11:09:43'),
	(79, 1, 1, 'Minecraft Tlauncher', 'upload/1654234070.jpg', 'https://www.tlauncher.org/', 'https://www.youtube.com', '2022-06-02 14:37:05'),
	(80, 1, 1, 'Fall Guys', 'upload/1654233787.jpg', 'https://www.riotgames.com/en', 'https://www.youtube.com', '2022-06-02 15:00:47'),
	(128, 1, 1, 'Resident Evil 4', 'upload/1654235506.webp', 'https://www.steamcommunity.com/', 'https://www.youtube.com', '2022-06-03 12:32:55'),
	(141, 2, 1, 'Among Us', 'upload/1654245509.jpg', 'https://www.steamcommunity.com/', 'https://www.youtube.com', '2022-06-03 15:38:29'),
	(142, 1, 1, 'Varmintz', 'upload/1654269267.jpg', 'https://www.gamehouse.com/', 'https://www.youtube.com', '2022-06-03 21:42:12');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;

-- Dumping structure for table db_taniver.genres
CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_taniver.genres: ~5 rows (approximately)
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` (`id`, `name`) VALUES
	(1, 'Adventure'),
	(2, 'Horror'),
	(3, 'Puzzles'),
	(6, 'Open World'),
	(7, 'Multiplayer');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;

-- Dumping structure for table db_taniver.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_taniver.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
	(1, 'aruwansha', 'ilhamfebrianarwansyah@gmail.com', '$2y$10$QkaKWXoSeS9GXx4pTUhfceKrbclIayTgF9tJcnko2rPoHNNv1WT9C'),
	(2, 'Iqnas', 'iqnasio@gmail.com', '$2y$10$M3kOqmWPhNlp/DAQGMn6FuleeOTfAHgrwqEReNmHs2oObIaLWOmpm'),
	(3, 'Intan', 'intan@gmail.com', '$2y$10$otJd4Pqmimkrr5R5kTrz7upVPxaOEJFcIcaO3MZDRs.nn2Q/r/EUm'),
	(6, 'taniver', 'taniver@gmail.com', '$2y$10$B230l0XkTaadT.s3Eyq9xuXFtvTdX/KibMeJzzh/1.9mpol6N7N7G');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 05:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be22_exam5_animal_adoption_mohammad_afif_haounji`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption`
--

CREATE TABLE `adoption` (
  `adoption_id` int(11) NOT NULL,
  `adoption_status` enum('requested','approved') DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pick_up_date` date NOT NULL,
  `insurance` enum('Yes','No') DEFAULT 'No',
  `user_id` int(11) DEFAULT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `confirmation_status` enum('pending','approved') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption`
--

INSERT INTO `adoption` (`adoption_id`, `adoption_status`, `requested_at`, `pick_up_date`, `insurance`, `user_id`, `pet_id`, `confirmation_status`) VALUES
(4, 'requested', '2024-08-04 14:07:03', '2024-08-15', 'Yes', 25, 1, 'pending'),
(5, 'requested', '2024-08-04 14:13:15', '2024-08-15', 'Yes', 25, 1, 'pending'),
(6, '', '2024-08-04 14:51:43', '2024-12-14', 'No', 25, 2, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `pet_id` int(11) NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `address` varchar(100) NOT NULL,
  `size` enum('small','medium','large') DEFAULT NULL,
  `breed` varchar(50) NOT NULL,
  `vaccinated` enum('yes','no') DEFAULT NULL,
  `status` enum('available','adopted') DEFAULT 'available',
  `sex` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`pet_id`, `pet_name`, `picture`, `age`, `description`, `address`, `size`, `breed`, `vaccinated`, `status`, `sex`) VALUES
(2, 'Sir Meows-a-lot', 'siamese.png', 9, 'A former lounge singer with a penchant for serenading anyone who will listen, Sir Meows-a-lot now performs exclusively in your living room. This sophisticated feline has a charming personality and loves to bask in the spotlight. He is known for his melodic purrs and enjoys a good chin scratch. A true performer, he thrives on attention and will keep you entertained with his antics.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Siamese', 'yes', 'available', 'Male'),
(3, 'Dr. Claws', 'sphynx.jpg', 13, 'Evil genius trapped in a cat’s body, Dr. Claws spends his days plotting world domination from the comfort of his cat tree. When he’s not napping or sharpening his claws on your favorite furniture, he’s probably hatching a scheme to steal the treats. Despite his mischievous nature, he has a soft spot for his humans and loves to curl up on laps.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'small', 'Sphynx', 'yes', 'available', 'Male'),
(4, 'Whisker the Menace', 'maine-coon.jpg', 10, 'Trouble follows Whisker the Menace like a shadow. This mischievous cat has a knack for finding himself in the most peculiar predicaments, from knocking over flower pots to getting stuck in the curtains. His inquisitive nature keeps him constantly exploring, and while he may be a handful, his playful spirit and affectionate purrs make him impossible to resist.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'large', 'Maine Coon', 'yes', 'available', 'Male'),
(5, 'Fido Fiasco', 'bulldog.jpg', 12, 'Professional chaos creator, Fido Fiasco, lives up to his name in every way possible. From chewing up shoes to digging holes in the backyard, he brings a whirlwind of energy and excitement into any home. Despite his penchant for mischief, Fido has a heart of gold and is fiercely loyal to his family. He’s always ready for an adventure or a game of fetch.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Bulldog', 'yes', 'available', 'Male'),
(6, 'Hairy Houdini', 'chihuahua.jpg', 2, 'Escape artist extraordinaire, Hairy Houdini, is a small dog with a big personality. No crate can hold him, and no fence is too high to jump. His curiosity and cleverness keep him constantly on the move, always seeking out new places to explore. He’s a bundle of energy and joy, ready to charm his way into your heart with his playful antics.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'small', 'Chihuahua', 'no', 'available', 'Male'),
(7, 'Mr. Bitey', 'pomeranian.jpg', 3, 'His name says it all – Mr. Bitey has a bit of an attitude and a love for chewing on just about anything. Approach with caution and a thick pair of gloves, and you’ll find a loyal and spirited companion underneath his tough exterior. With the right training and lots of love, Mr. Bitey can become a cherished member of the family.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'medium', 'Pomeranian', 'no', 'available', 'Male'),
(8, 'Diva McWhiskers', 'persian.jpg', 4, 'A total diva who demands nothing but the best, Diva McWhiskers believes she is royalty. She expects to be pampered and will settle for nothing less than premium treats and the softest cushions. With her elegant demeanor and high standards, she’ll make sure you know she’s the queen of the household. Despite her demanding nature, she has a way of endearing herself to everyone she meets.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'small', 'Persian', 'yes', 'available', 'Female'),
(9, 'Rover the Destroyer', 'rottweiler.avif', 5, 'Toys, furniture, hearts – Rover the Destroyer lives up to his name by leaving a trail of destruction in his wake. His powerful jaws can make quick work of even the toughest toys, but his boundless energy and playful spirit make him a joy to be around. When he’s not busy destroying things, he loves to cuddle and show his affectionate side.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'large', 'Rottweiler', 'yes', 'available', 'Male'),
(10, 'Luna-tic', 'husky.jpg', 6, 'A little crazy but aren’t we all? Luna-tic is known for her wild antics and love of midnight howling. Her expressive eyes and playful nature make her a standout character. She thrives on excitement and loves to be the center of attention. With Luna-tic in your life, there’s never a dull moment.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'large', 'Husky', 'yes', 'available', 'Female'),
(11, 'Captain Chaos', 'beagle.jpg', 7, 'Bringing chaos wherever he goes, Captain Chaos is a lovable troublemaker. His boundless energy and adventurous spirit keep him constantly on the move, exploring every nook and cranny. Despite his mischievous ways, he’s incredibly loving and loyal, always ready to snuggle up after a long day of causing havoc.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Beagle', 'yes', 'available', 'Male'),
(12, 'Sir Barksalot', 'jr.jpeg', 1, 'Sir Barksalot barks at everything – leaves, shadows, his own tail. He’s a small dog with a big voice and an even bigger heart. Always alert and ready to protect his home, he takes his job as a watchdog very seriously. When he’s not on duty, he loves to play and is a great companion for an active family.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'small', 'Jack Russell Terrier', 'no', 'available', 'Male'),
(13, 'Princess Growls', 'poodle.jpg', 3, 'Cute but feisty, Princess Growls has a growl that could scare a lion. She may be small, but she’s full of spirit and personality. She knows what she wants and isn’t afraid to let you know. Despite her tough exterior, she has a soft side and loves to be pampered and spoiled.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'small', 'Poodle', 'no', 'available', 'Female'),
(14, 'Mr. Mischief', 'labrador.jpg', 4, 'If there’s trouble, Mr. Mischief will find it and probably roll in it. His curious nature and playful spirit make him a constant source of entertainment. From chasing his tail to sneaking into places he shouldn’t be, he keeps life interesting. He’s a loving companion who thrives on attention and affection.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Labrador Retriever', 'yes', 'available', 'Male'),
(15, 'The Furrminator', 'gr.jpg', 5, 'Sheds like there’s no tomorrow, The Furrminator is your vacuum’s worst nightmare. This fluffy bundle of joy loves to cuddle and is always ready for a game of fetch or a long walk. His friendly and affectionate nature makes him a perfect companion, even if he does leave a trail of fur wherever he goes.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'large', 'Golden Retriever', 'yes', 'available', 'Male'),
(16, 'Pedro', '66aceb4e7df05.png', 3, 'Pedro is not your average raccoon. Known for his love of late-night adventures and his unusual taste for alcohol, Pedro is a party animal in every sense. He’s been spotted raiding not only trash cans but also your liquor cabinet. His quirky habits and charming personality make him a unique and entertaining pet. Always up for a good time, Pedro brings excitement and a bit of wildness into any home.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'small', 'Raccoon', 'yes', 'available', 'Male'),
(17, 'Pikachu', '66acf2c9ae136.jpg', 23, 'adwdawdawdad', 'adwawdaw', 'small', 'aewdawd', 'no', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `pet_id` int(11) NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `address` varchar(100) NOT NULL,
  `size` enum('small','medium','large') DEFAULT NULL,
  `breed` varchar(50) NOT NULL,
  `vaccinated` enum('yes','no') DEFAULT NULL,
  `status` enum('available','reserved','adopted') DEFAULT 'available',
  `sex` enum('Male','Female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`pet_id`, `pet_name`, `picture`, `age`, `description`, `address`, `size`, `breed`, `vaccinated`, `status`, `sex`) VALUES
(1, 'Sir Meows-a-lot', '66af6f259055e.png', 9, 'A former lounge singer with a penchant for serenading anyone who will listen, Sir Meows-a-lot now performs exclusively in your living room. This sophisticated feline has a charming personality and loves to bask in the spotlight. He is known for his melodic purrs and enjoys a good chin scratch. A true performer, he thrives on attention and will keep you entertained with his antics.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Siamese', 'yes', 'reserved', 'Male'),
(2, 'Dr. Claws', '66af6fea0006a.jpg', 13, 'Evil genius trapped in a cat’s body, Dr. Claws spends his days plotting world domination from the comfort of his cat tree. When he’s not napping or sharpening his claws on your favorite furniture, he’s probably hatching a scheme to steal the treats. Despite his mischievous nature, he has a soft spot for his humans and loves to curl up on laps.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'small', 'Sphynx', 'yes', 'reserved', 'Male'),
(3, 'Whisker the Menace', '66af7092cb9a5.jpg', 10, 'Trouble follows Whisker the Menace like a shadow. This mischievous cat has a knack for finding himself in the most peculiar predicaments, from knocking over flower pots to getting stuck in the curtains. His inquisitive nature keeps him constantly exploring, and while he may be a handful, his playful spirit and affectionate purrs make him impossible to resist.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'large', 'Maine Coon', 'yes', 'available', 'Male'),
(4, 'Fido Fiasco', '66af70b3175c7.jpg', 12, 'Professional chaos creator, Fido Fiasco, lives up to his name in every way possible. From chewing up shoes to digging holes in the backyard, he brings a whirlwind of energy and excitement into any home. Despite his penchant for mischief, Fido has a heart of gold and is fiercely loyal to his family. He’s always ready for an adventure or a game of fetch.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Bulldog', 'yes', 'available', 'Male'),
(5, 'Hairy Houdini', '66af71e7eaf98.jpg', 2, 'Escape artist extraordinaire, Hairy Houdini, is a small dog with a big personality. No crate can hold him, and no fence is too high to jump. His curiosity and cleverness keep him constantly on the move, always seeking out new places to explore. He’s a bundle of energy and joy, ready to charm his way into your heart with his playful antics.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'small', 'Chihuahua', 'no', 'available', 'Male'),
(6, 'Mr. Bitey', '66af71fdc9e28.jpg', 3, 'His name says it all – Mr. Bitey has a bit of an attitude and a love for chewing on just about anything. Approach with caution and a thick pair of gloves, and you’ll find a loyal and spirited companion underneath his tough exterior. With the right training and lots of love, Mr. Bitey can become a cherished member of the family.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'small', 'Pomeranian', 'no', 'available', 'Male'),
(7, 'Diva McWhiskers', '66af72336af45.jpg', 4, 'A total diva who demands nothing but the best, Diva McWhiskers believes she is royalty. She expects to be pampered and will settle for nothing less than premium treats and the softest cushions. With her elegant demeanor and high standards, she’ll make sure you know she’s the queen of the household. Despite her demanding nature, she has a way of endearing herself to everyone she meets.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Persian', 'yes', 'available', 'Female'),
(8, 'Rover the Destroyer', '66af72aac5a22.avif', 5, 'Toys, furniture, hearts – Rover the Destroyer lives up to his name by leaving a trail of destruction in his wake. His powerful jaws can make quick work of even the toughest toys, but his boundless energy and playful spirit make him a joy to be around. When he’s not busy destroying things, he loves to cuddle and show his affectionate side.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'large', 'Rottweiler', 'yes', 'available', 'Male'),
(9, 'Luna-tic', '66af72e4cef29.jpg', 6, 'A little crazy but aren’t we all? Luna-tic is known for her wild antics and love of midnight howling. Her expressive eyes and playful nature make her a standout character. She thrives on excitement and loves to be the center of attention. With Luna-tic in your life, there’s never a dull moment.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'large', 'Husky', 'yes', 'available', 'Female'),
(10, 'Captain Chaos', '66af72f42223f.jpg', 7, 'Captain Chaos', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'medium', 'Beagle', 'yes', 'available', 'Female'),
(11, 'Sir Barksalot', '66af7304c01a7.jpeg', 1, 'Sir Barksalot barks at everything – leaves, shadows, his own tail. He’s a small dog with a big voice and an even bigger heart. Always alert and ready to protect his home, he takes his job as a watchdog very seriously. When he’s not on duty, he loves to play and is a great companion for an active family.', 'PetStore3, Neubaugasse 12, 1070 Wien', 'small', 'Jack Russell Terrier', 'yes', 'available', 'Male'),
(12, 'Princess Growls', '66af733c8db73.jpg', 3, 'Cute but feisty, Princess Growls has a growl that could scare a lion. She may be small, but she’s full of spirit and personality. She knows what she wants and isn’t afraid to let you know. Despite her tough exterior, she has a soft side and loves to be pampered and spoiled.', 'PetStore1, Mariahilfer Str. 123, 1060 Wien', 'small', 'Poodle', 'no', 'available', 'Female'),
(13, 'Mr. Mischief', '66af72ca431c1.jpg', 4, 'If there’s trouble, Mr. Mischief will find it and probably roll in it. His curious nature and playful spirit make him a constant source of entertainment. From chasing his tail to sneaking into places he shouldn’t be, he keeps life interesting. He’s a loving companion who thrives on attention and affection.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'large', 'Labrador Retriever', 'no', 'available', 'Male'),
(14, 'The Furrminator', '66af72b9ee306.jpg', 5, 'Sheds like there’s no tomorrow, The Furrminator is your vacuum’s worst nightmare. This fluffy bundle of joy loves to cuddle and is always ready for a game of fetch or a long walk. His friendly and affectionate nature makes him a perfect companion, even if he does leave a trail of fur wherever he goes.', 'PetStore2, Favoritenstr. 200, 1100 Wien', 'large', 'Golden Retriever', 'yes', 'available', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `phone_number` int(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email_address`, `dob`, `phone_number`, `address`, `picture`, `password`, `status`) VALUES
(1, 'Mohammad Afif', 'Haounji', 'test12@gmail.com', '0000-00-00', 2147483647, 'sfefesfsef', '6', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(3, 'testtest', 'test', 'testtest@test.com', '2020-08-12', 56545465, 'sdfsefsef', '66ae3ab8278ec.png', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(4, 'Mohammad Afif', 'Haounji', 'moe.haounji@gmail.com', '1994-12-14', 2147483647, 'Bräuhausgasse 49', '66ae6a3784eb9.png', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(5, 'test', 'test', 'testmoe@test.com', '1994-12-12', 2147483647, 'sdfwefwef', '66af33bd93db4.png', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(25, 'Moe', 'haounji', 'moetest@test.com', '1999-12-12', 2147483647, 'sdfesfsfsef', '66af728131d91.png', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(26, 'Moe', 'Haounji', 'admin@gmail.com', '1994-12-14', 2147483647, 'Teststraße23, 1050, Wien', '66af79b9d1630.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption`
--
ALTER TABLE `adoption`
  ADD PRIMARY KEY (`adoption_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `adoption_ibfk_2` (`pet_id`);

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption`
--
ALTER TABLE `adoption`
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption`
--
ALTER TABLE `adoption`
  ADD CONSTRAINT `adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `adoption_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

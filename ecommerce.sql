-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2022 at 04:38 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comments` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Parent`, `Ordering`, `Visibility`, `Allow_Comments`, `Allow_Ads`) VALUES
(1, 'Cell Phones', 'Phones And others', 0, 1, 0, 0, 0),
(2, 'Nokia', 'nokia phones', 1, 1, 0, 0, 0),
(3, 'Hand Made', 'Made By Our Hand', 0, 2, 0, 0, 0),
(4, 'Huawei', 'huawei phones', 1, 2, 0, 0, 0),
(5, 'test', 'testtttttttttt', 3, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` datetime NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `item_id`, `user_id`) VALUES
(1, 'very good gg', 1, '2022-08-13 14:56:21', 2, 3),
(3, 'very good', 1, '2022-08-13 19:36:31', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Tags` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Last_Modify_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Image`, `Name`, `Description`, `Price`, `Country_Made`, `Add_Date`, `Tags`, `Status`, `Approve`, `Cat_ID`, `Member_ID`, `Last_Modify_Date`) VALUES
(2, '8914620root_PXL_20220611_130129497.PORTRAIT.jpg', 'Necles', 'This necles  Did not Made By Hand Its Made by Love', '3000', 'مصر', '2022-08-13', 'HandMade, Love', '1', 1, 3, 3, '2022-08-13 15:00:38'),
(3, '8566093root_PXL_20220611_130129497.PORTRAIT.jpg', 'Nokia 3310', 'Good', '150', 'Egypt', '2022-08-13', 'nokia, phone', '1', 1, 2, 2, '0000-00-00 00:00:00'),
(4, '7822415root_00000IMG_00000_BURST20201227152343133_COVER.jpg', 'Huawei Y3', 'Good To Own it', '15000', 'Egypt', '2022-08-13', 'huawei, phone', '1', 1, 4, 3, '2022-08-13 16:42:03'),
(5, '2283015root_PXL_20220611_125834066.jpg', 'test', 'testtttttttttt', '1', 'Egypt', '2022-08-13', 'test', '1', 1, 3, 2, '0000-00-00 00:00:00'),
(6, '1463098root_48363.jpg', 'test', 'stests', '15', 'مصر', '2022-08-13', 'huawei, phone', '1', 1, 4, 3, '0000-00-00 00:00:00'),
(7, '2959032root_48334.jpg', 'test', 'Good', '150', 'مصر', '2022-08-13', 'test', '2', 1, 5, 3, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `Avatar` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `RegStatus`, `GroupID`, `Avatar`, `Date`) VALUES
(1, 'abdo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'abdo@gmail.com', 'abdo mohamed', 1, 1, '', '0000-00-00'),
(2, 'khaled', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'khlaed@gmail.com', 'khlaed mohamed abdo', 1, 0, '9909994khaled_WhatsApp Image 2022-04-09 at 4.48.50 PM.jpeg', '2022-08-13'),
(3, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed@gmail.com', 'ahmed mohamed mostafa', 1, 0, '2903815ahmed_PXL_20220611_130436573.PORTRAIT.jpg', '2022-08-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `item_comment` (`item_id`),
  ADD KEY `user_comment` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `user_item` (`Member_ID`),
  ADD KEY `item_category` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `item_category` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_item` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

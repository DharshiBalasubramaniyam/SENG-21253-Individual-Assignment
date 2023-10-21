-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2023 at 06:04 PM
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
-- Database: `se.2020.034`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `description`) VALUES
(1, 'Flower vase', 546.99, 'This is the brief description about this product&#039;s nature and characteristics. You can get a clear idea of the products by reading this.'),
(2, 'Shoes', 756.99, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.'),
(3, 'Ladies bag', 658.81, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.'),
(4, 'Umbrella', 321.25, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.'),
(5, 'Water bottle', 152.65, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.'),
(6, 'Kettle', 410.72, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.'),
(7, 'Watch', 999.99, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.'),
(8, 'lamp', 689.99, 'This Is The Brief Description About This Product&#039;s Nature And Characteristics. You Can Get A Clear Idea Of The Products By Reading This.');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `product_id` int(11) NOT NULL,
  `image_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`product_id`, `image_url`) VALUES
(1, 'uploadImages/vase.jpg'),
(2, 'uploadImages/shoes.jpg'),
(3, 'uploadImages/bag.jpg'),
(4, 'uploadImages/umbrella.jpg'),
(5, 'uploadImages/botttle.jpg'),
(6, 'uploadImages/kettle.jpeg'),
(7, 'uploadImages/watch.jpg'),
(8, 'uploadImages/lamp.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `type` varchar(20) NOT NULL,
  `password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `type`, `password`) VALUES
(1, 'John Smith', 'jsmith@gmail.com', '123456789', 'super admin', 'sadmin1234'),
(2, 'Bob Cruse', 'bcruse@gmail.com', '0789632587', 'admin', 'bob+1234'),
(3, 'James', 'james@gmail.com', '9856321475', 'customer', 'james+1234'),
(4, 'henry', 'hen@gmail.com', '9874563210', 'customer', 'hen+1234'),
(5, 'Alexa', 'alexa@gmail.com', '0789632780', 'admin', 'alexa+1234'),
(6, 'Silviya', 'silviya@gmail.com', '9517538524', 'customer', 'silviya+1234'),
(7, 'Alexander', 'alex@gmail.com', '9765841002', 'customer', 'alex+1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

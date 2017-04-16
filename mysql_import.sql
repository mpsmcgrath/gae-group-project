USE blog_sample; 
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` tinytext NOT NULL,
  `product_img_name` varchar(60) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) AUTO_INCREMENT=1 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `product_img_name`, `price`) VALUES
(1, 'PD1001', 'Coca-Cola Cans', '12 Pack x 330ml', 'coca-cola.jpg', 8.40),
(2, 'PD1002', 'ADIDAS Football', 'Adidas Finale Cardiff 2017 Capitano Ball, White', 'football.jpg', 25.00),
(3, 'PD1003', 'Cadbury Easter Egg', 'Cadbury Dairy Milk Oreo Large Easter Egg 278G', 'easter-egg.jpg', 9.99),
(4, 'PD1004', 'Kelloggs Pop Tarts', 'Strawberry Sensation 400G', 'pop-tarts.jpg', 3.70);

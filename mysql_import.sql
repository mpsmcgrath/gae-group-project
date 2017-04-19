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
(1, 'FOOD01', 'Coca-Cola Cans', '12 Pack x 330ml, guaranteed to rot your teeth', 'coca-cola.jpg', 8.40),
(2, 'FOOD02', 'Sprouts', 'A beautiful sprout, grown in Brussels', 'sprout.jpg', 25.00),
(3, 'FOOD03', 'Cadbury Easter Egg', 'Cadbury Dairy Milk Oreo Large Easter Egg 278G', 'easter-egg.jpg', 9.99),
(4, 'FOOD04', 'Kelloggs Pop Tarts', 'Strawberry Sensation 400G. Packed full of nutritious sugar.', 'pop-tarts.jpg', 3.70),
(5, 'SPRT05', 'ADIDAS Football', 'Adidas Finale Cardiff 2017 Capitano Ball, White', 'football.jpg', 25.00),
(6, 'SPRT06', 'Golf Ball', 'Professional quality golf ball, White', 'golfball.jpg', 5.00),
(7, 'SPRT07', 'Basket Ball', 'A basketball, as thrown and bounced by Basketballers', 'basketball.jpg', 15.00),
(8, 'SPRT08', 'Rugby Ball', 'Regulation sized rugby ball, for playing rugby with', 'rugbyball.jpg', 19.99),
(9, 'DRNK09', 'Buckfast Wine', 'Anti-social behaviour, bottled by monks apparently', 'buckfast.jpg', 12.00),
(10, 'DRNK10', 'Vodka', 'Russian quality vodka, made from potatos and tears', 'vodka.jpg', 25.00),
(11, 'DRNK11', 'Absinthe', 'Quite strong drink, do not operate heavy machinary', 'absinthe.jpg', 37.00),
(12, 'DRNK12', 'Poitin', 'Traditional Irish drink with small chance of death', 'poitin.jpg', 82.50);


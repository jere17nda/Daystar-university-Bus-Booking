-- Dumping data for table `bookings`

INSERT INTO `bookings` (`id`, `booking_id`, `customer_id`, `route_id`, `customer_route`, `booked_amount`, `booked_seat`, `booking_created`) VALUES
(60, 'TBZJ360', 'CUST-2114034', 'RT-1908653', 'CITY1 &rarr; CITY2', 100, '3', '2021-10-16 22:15:13'),
(61, 'QK0MT61', 'CUST-2017936', 'RT-9941455', 'EDROISCHESTER &rarr; BRUGOW', 110, '15', '2021-10-17 22:36:10'),
(62, 'A8L5662', 'CUST-5585037', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '2', '2021-10-18 00:08:51'),
(63, 'QDNGC63', 'CUST-8996235', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '15', '2021-10-18 09:31:30'),
(64, 'X34RW64', 'CUST-9474738', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '6', '2021-10-18 09:32:21'),
(65, 'JKZVT65', 'CUST-4031139', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '18', '2021-10-18 09:33:36'),
(66, 'HIIAN66', 'CUST-9997540', 'RT-5887160', 'FLORIA &rarr; ARKBY', 118, '16', '2021-10-18 09:40:16'),
(67, 'QLOE167', 'CUST-9997540', 'RT-3835554', 'ZEKA &rarr; ZREGOW', 70, '12', '2021-10-18 09:41:01');

-- Dumping data for table `buses`

INSERT INTO `buses` (`id`, `bus_no`, `bus_assigned`, `bus_created`,`Capacity`, `Driver`, `Conductor`, `Phone_Number`) VALUES
(44, 'MVL1000', 0, '2021-10-16 22:05:16'),
(45, 'ABC0010', 1, '2021-10-17 22:32:46'),
(46, 'XYZ7890', 0, '2021-10-17 22:33:15'),
(47, 'BCC9999', 0, '2021-10-17 22:33:22'),
(48, 'RDH4255', 1, '2021-10-17 22:33:36'),
(49, 'TTH8888', 1, '2021-10-18 00:05:32'),
(50, 'MMM9969', 1, '2021-10-18 00:06:02'),
(51, 'LLL7699', 1, '2021-10-18 00:06:42'),
(52, 'SSX6633', 0, '2021-10-18 00:06:52'),
(53, 'NBS4455', 0, '2021-10-18 09:27:49'),
(54, 'CAS3300', 1, '2021-10-18 09:36:54');

-- Dumping data for table `customers`

INSERT INTO `customers` (`id`, `customer_id`, `customer_name`, `customer_phone`, `customer_created`) VALUES
(34, 'CUST-2114034', 'Dfirst Dlast', '7002001200', '2021-10-16 22:09:12'),
(35, 'CUST-8996235', 'Willian Hobbs', '4012222222', '2021-10-17 22:30:23'),
(36, 'CUST-2017936', 'George Watts', '7011111111', '2021-10-17 22:30:53'),
(37, 'CUST-5585037', 'Bobb Horn', '1111111110', '2021-10-17 22:31:20'),
(38, 'CUST-9474738', 'Alan Moore', '7900000000', '2021-10-18 09:32:02'),
(39, 'CUST-4031139', 'Jamie Rhoades', '1003000010', '2021-10-18 09:33:08'),
(40, 'CUST-9997540', 'Demo Customer', '7777777700', '2021-10-18 09:39:10');

-- Dumping data for table `routes`

INSERT INTO `routes` (`id`, `route_id`, `bus_no`, `route_cities`, `route_dep_date`, `route_dep_time`, `route_step_cost`, `route_created`) VALUES
(53, 'RT-1908653', 'MVL1000', 'CITY1,CITY2', '2021-10-17', '22:05:00', 100, '2021-10-16 22:05:42'),
(54, 'RT-3835554', 'MMM9969', 'ZEKA,ZREGOW', '2021-10-19', '23:13:00', 70, '2021-10-16 22:12:32'),
(55, 'RT-9941455', 'RDH4255', 'EDROISCHESTER,BRUGOW', '2021-10-18', '10:00:00', 110, '2021-10-17 22:34:47'),
(56, 'RT-9069556', 'XYZ7890', 'ANTALAND,ZREGOW', '2021-10-19', '11:40:00', 85, '2021-10-17 23:39:57'),
(57, 'RT-775557', 'ABC0010', 'ENCEFORD,VLIRGINIA', '2021-10-19', '13:30:00', 131, '2021-10-17 23:42:12'),
(58, 'RT-753558', 'TTH8888', 'ARKBY,VEIM', '2021-10-20', '12:04:00', 55, '2021-10-18 00:04:42'),
(59, 'RT-6028759', 'LLL7699', 'BELRITH,ARKBY', '2021-10-20', '13:50:00', 166, '2021-10-18 00:07:50'),
(60, 'RT-5887160', 'CAS3300', 'FLORIA,ARKBY', '2021-10-19', '10:30:00', 118, '2021-10-18 09:38:30');

-- Dumping data for table `seats`

INSERT INTO `seats` (`bus_no`, `seat_booked`) VALUES
('ABC0010', NULL),
('BCC9999', NULL),
('CAS3300', '16'),
('LLL7699', NULL),
('MMM9969', '2,15,6,18,12'),
('MVL1000', '3'),
('NBS4455', NULL),
('RDH4255', '15'),
('SSX6633', NULL),
('TTH8888', NULL),
('XYZ7890', NULL);

-- Dumping data for table `users`

INSERT INTO `users` (`user_id`, `user_fullname`, `user_name`, `user_password`, `user_created`) VALUES
(1, 'Liam Moore', 'admin', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', '2021-06-02 13:55:21'),
(2, 'Test Admin', 'testadmin', '$2y$10$A2eGOu1K1TSBqMwjrEJZg.lgy.FmCUPl/l5ugcYOXv4qKWkFEwcqS', '2021-10-17 21:10:07');

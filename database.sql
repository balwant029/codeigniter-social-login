
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `user_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `um_`
--

CREATE TABLE `um_` (
  `user_id` int(11) NOT NULL,
  `email` varchar(112) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(56) NOT NULL,
  `age` int(3) NOT NULL,
  `gender` enum('M','F','','O') NOT NULL,
  `location` varchar(56) NOT NULL,
  `fb_id` varchar(112) NOT NULL,
  `ga_id` varchar(112) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `um_`
--
ALTER TABLE `um_`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `um_`
--
ALTER TABLE `um_`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
  
CREATE TABLE IF NOT EXISTS `um_sessions` (
    `id` varchar(40) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    PRIMARY KEY (id),
    KEY `ci_sessions_timestamp` (`timestamp`)
);


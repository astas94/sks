SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `#__bookpro_agent`;
CREATE TABLE IF NOT EXISTS `#__bookpro_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `brandname` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `desc` text NOT NULL,
  `address` varchar(400) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `city` varchar(200) NOT NULL,
  `skype` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `country_id` int(11) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `birthday` datetime NOT NULL,
  `states` varchar(200) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `#__bookpro_agent` (`id`, `user`, `firstname`, `lastname`, `company`, `brandname`, `image`, `alias`, `desc`, `address`, `email`, `telephone`, `mobile`, `fax`, `city`, `skype`, `website`, `country_id`, `zip`, `birthday`, `states`, `state`, `created`, `params`) VALUES
(1, 424, 'Quan', 'Ngo', 'bookpro', 'bookpro', 'images/bookpro/bus/agents/powered_by.png', '', '', '', '', '0912348149', '0912348149', '', '', '', 'http://joombooking.com', 0, '', '0000-00-00 00:00:00', '', 1, '2014-11-25 03:19:52', '');

DROP TABLE IF EXISTS `#__bookpro_application`;
CREATE TABLE IF NOT EXISTS `#__bookpro_application` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  `state` tinyint(4) NOT NULL,
  `email_send_from_name` varchar(250) NOT NULL,
  `email_send_from` varchar(250) NOT NULL,
  `email_customer_body` text NOT NULL,
  `email_customer_subject` varchar(200) NOT NULL,
  `email_admin` varchar(200) NOT NULL,
  `email_admin_body` text,
  `email_admin_subject` varchar(250) DEFAULT NULL,
  `success` text,
  `failed` text,
  `access` varchar(20) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `views` varchar(250) DEFAULT NULL,
  `service_fee` varchar(45) DEFAULT NULL,
  `params` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `#__bookpro_application` (`id`, `title`, `code`, `desc`, `state`, `email_send_from_name`, `email_send_from`, `email_customer_body`, `email_customer_subject`, `email_admin`, `email_admin_body`, `email_admin_subject`, `success`, `failed`, `access`, `active`, `views`, `service_fee`, `params`) VALUES
(1, 'Bus booking', 'BUS', 'Manager bus ticket ', 1, 'Bus Booking Demo', 'quan@joombooking.com', '<p style="line-height: 15.8079996109009px;">Hello <strong>{firstname} {lastname}</strong></p>\r\n<p style="line-height: 15.8079996109009px;">Your ticket has been reserved at yourcompany.com</p>\r\n<p style="line-height: 15.8079996109009px;">Your booking number is: <strong>{order_number}</strong></p>\r\n<p style="line-height: 15.8079996109009px;"><span style="font-size: 12.1599998474121px; line-height: 15.8079996109009px;">Sub Total: {subtotal}</span></p>\r\n<p style="line-height: 15.8079996109009px;"><span style="font-size: 12.1599998474121px; line-height: 15.8079996109009px;">Tax &amp; fee: </span><span style="font-size: 12.1599998474121px; line-height: 15.8079996109009px;">{tax}</span></p>\r\n<p style="line-height: 15.8079996109009px;">Total amount: {total}</p>\r\n<p style="line-height: 15.8079996109009px;">Following information is booking detail</p>\r\n<p style="line-height: 15.8079996109009px;"><strong>Passenger(s)</strong>:</p>\r\n<p style="line-height: 15.8079996109009px;">{passenger}</p>\r\n<p style="line-height: 15.8079996109009px;"><span style="text-decoration: underline;"><strong>Route information</strong></span></p>\r\n<p style="line-height: 15.8079996109009px;">{tripdetail}</p>\r\n<hr />\r\n<p style="line-height: 15.8079996109009px;">You can track your booking at {order_link}</p>\r\n<p style="line-height: 15.8079996109009px;">If you need any support, please call xxx-xxx xxxx</p>', 'Order confirmation', 'quan@joombooking.com', '<p style="line-height: 15.8079996109009px;">Hello <strong>{firstname} {lastname}</strong></p>\r\n<p style="line-height: 15.8079996109009px;">Your ticket has been reserved at yourcompany.com</p>\r\n<p style="line-height: 15.8079996109009px;">Your booking number is: <strong>{order_number}</strong></p>\r\n<p style="line-height: 15.8079996109009px;">Total amount: {total}</p>\r\n<p style="line-height: 15.8079996109009px;">Following information is booking detail</p>\r\n<p style="line-height: 15.8079996109009px;"><strong>Passenger(s)</strong>:</p>\r\n<p style="line-height: 15.8079996109009px;">{passenger}</p>\r\n<p style="line-height: 15.8079996109009px;"><span style="text-decoration: underline;"><strong>Route information</strong></span></p>\r\n<p style="line-height: 15.8079996109009px;">{tripdetail}</p>\r\n<hr />\r\n<p style="line-height: 15.8079996109009px;">You can track your booking at {order_link}</p>\r\n<p style="line-height: 15.8079996109009px;">If you need any support, please call xxx-xxx xxxx</p>', 'New order received', '', '', '0', 0, 'bustrips;buses;agents;cgroups;seattemplates;pmibustrips;passengers', '0', '1');

DROP TABLE IF EXISTS `#__bookpro_baggage`;
CREATE TABLE IF NOT EXISTS `#__bookpro_baggage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `#__bookpro_baggage` (`id`, `weight`, `agent_id`, `qty`, `price`, `state`) VALUES
(1, 30, 4, 2, 10, 1),
(2, 30, 4, 1, 6, 1),
(3, 30, 4, 3, 13, 1);

DROP TABLE IF EXISTS `#__bookpro_bus`;
CREATE TABLE IF NOT EXISTS `#__bookpro_bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `seat` int(11) DEFAULT NULL,
  `bus_type` int(11) NOT NULL,
  `seattemplate_id` int(11) NOT NULL,
  `upperseattemplate_id` int(11) NOT NULL,
  `desc` text,
  `state` tinyint(4) DEFAULT NULL,
  `image` varchar(145) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `images` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `#__bookpro_bus` (`id`, `agent_id`, `title`, `seat`, `bus_type`, `seattemplate_id`, `upperseattemplate_id`, `desc`, `state`, `image`, `code`, `created_by`, `modified_by`, `images`, `params`) VALUES
(1, 1, 'Wolfline', NULL, 0, 1, 0, '', 1, '', 'test', 423, 0, '', '"{\\"images\\":\\"bookpro\\",\\"video\\":\\"\\"}"'),
(2, 1, 'Van 15 seat', NULL, 0, 3, 0, 'adsadasdads', 1, '', NULL, 423, 0, '', '"{\\"video\\":\\"\\"}"');

DROP TABLE IF EXISTS `#__bookpro_busstop`;
CREATE TABLE IF NOT EXISTS `#__bookpro_busstop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bustrip_id` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `depart` varchar(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `price` float NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bustrip_id` (`bustrip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__bookpro_bustrip`;
CREATE TABLE IF NOT EXISTS `#__bookpro_bustrip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `code` varchar(50) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `state` tinyint(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `publish_date` date NOT NULL,
  `unpublish_date` date DEFAULT NULL,
  `duration` varchar(250) DEFAULT NULL,
  `seats` varchar(200) DEFAULT NULL,
  `door` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `drop_door` tinyint(4) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__bookpro_bus_seattemplate`;
CREATE TABLE IF NOT EXISTS `#__bookpro_bus_seattemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `block_layout` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_track_date` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `#__bookpro_bus_seattemplate` (`id`, `title`, `block_layout`) VALUES
(1, 'Chair seat', '{"row":"4","column":"8","block_type":["seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat"],"seatnumber":["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32"]}'),
(2, 'Upper', '{"row":"4","column":"5","block_type":["sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","sleeper","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat","seat"],"seatnumber":["201","202","203","204","205","206","207","208","209","210","211","212","213","214","215","216","217","218","219","220","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","",""]}'),
(3, 'testvan', '{"row":"3","column":"3","block_type":["hidden","hidden","seat","seat","seat","seat","seat","seat","seat","seat","hidden","hidden","seat","seat","seat"],"seatnumber":["1","4","7","10","13","2","5","8","11","14","3","6","9","12","15"]}');

DROP TABLE IF EXISTS `#__bookpro_cgroup`;
CREATE TABLE IF NOT EXISTS `#__bookpro_cgroup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `desc` varchar(250) DEFAULT NULL,
  `discount` tinyint(1) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `#__bookpro_cgroup` (`id`, `title`, `desc`, `discount`, `state`) VALUES
(1, 'Adult', NULL, 100, 1),
(2, 'Kids', NULL, 70, 1),
(3, 'Senior', NULL, 30, 1);

DROP TABLE IF EXISTS `#__bookpro_country`;
CREATE TABLE IF NOT EXISTS `#__bookpro_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  `state` varchar(45) DEFAULT NULL,
  `desc` varchar(45) DEFAULT NULL,
  `visainfo` varchar(45) DEFAULT NULL,
  `region_id` varchar(45) DEFAULT NULL,
  `intro` text NOT NULL,
  `flag` varchar(200) NOT NULL,
  `image_map` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;

INSERT INTO `#__bookpro_country` (`id`, `country_code`, `country_name`, `state`, `desc`, `visainfo`, `region_id`, `intro`, `flag`, `image_map`) VALUES
(1, 'US', 'United States', '1', NULL, NULL, NULL, '', '', ''),
(2, 'CA', 'Canada', '1', NULL, NULL, NULL, '', '', ''),
(3, 'AF', 'Afghanistan', '1', '', '', '13', '', '', ''),
(4, 'AL', 'Albania', '1', NULL, NULL, NULL, '', '', ''),
(5, 'DZ', 'Algeria', '1', NULL, NULL, NULL, '', '', ''),
(6, 'DS', 'American Samoa', '1', NULL, NULL, NULL, '', '', ''),
(7, 'AD', 'Andorra', '1', NULL, NULL, NULL, '', '', ''),
(8, 'AO', 'Angola', '1', NULL, NULL, NULL, '', '', ''),
(9, 'AI', 'Anguilla', '1', NULL, NULL, NULL, '', '', ''),
(10, 'AQ', 'Antarctica', '1', NULL, NULL, NULL, '', '', ''),
(11, 'AG', 'Antigua and/or Barbuda', '1', NULL, NULL, NULL, '', '', ''),
(12, 'AR', 'Argentina', '1', NULL, NULL, NULL, '', '', ''),
(13, 'AM', 'Armenia', '1', NULL, NULL, NULL, '', '', ''),
(14, 'AW', 'Aruba', '1', NULL, NULL, NULL, '', '', ''),
(15, 'AU', 'Australia', '1', NULL, NULL, NULL, '', '', ''),
(16, 'AT', 'Austria', '1', NULL, NULL, NULL, '', '', ''),
(17, 'AZ', 'Azerbaijan', '1', NULL, NULL, NULL, '', '', ''),
(18, 'BS', 'Bahamas', '1', NULL, NULL, NULL, '', '', ''),
(19, 'BH', 'Bahrain', '1', NULL, NULL, NULL, '', '', ''),
(20, 'BD', 'Bangladesh', '1', NULL, NULL, NULL, '', '', ''),
(21, 'BB', 'Barbados', '1', NULL, NULL, NULL, '', '', ''),
(22, 'BY', 'Belarus', '1', NULL, NULL, NULL, '', '', ''),
(23, 'BE', 'Belgium', '1', NULL, NULL, NULL, '', '', ''),
(24, 'BZ', 'Belize', '1', NULL, NULL, NULL, '', '', ''),
(25, 'BJ', 'Benin', '1', NULL, NULL, NULL, '', '', ''),
(26, 'BM', 'Bermuda', '1', NULL, NULL, NULL, '', '', ''),
(27, 'BT', 'Bhutan', '1', NULL, NULL, NULL, '', '', ''),
(28, 'BO', 'Bolivia', '1', NULL, NULL, NULL, '', '', ''),
(29, 'BA', 'Bosnia and Herzegovina', '1', NULL, NULL, NULL, '', '', ''),
(30, 'BW', 'Botswana', '1', NULL, NULL, NULL, '', '', ''),
(31, 'BV', 'Bouvet Island', '1', NULL, NULL, NULL, '', '', ''),
(32, 'BR', 'Brazil', '1', NULL, NULL, NULL, '', '', ''),
(33, 'IO', 'British lndian Ocean Territory', '1', NULL, NULL, NULL, '', '', ''),
(34, 'BN', 'Brunei Darussalam', '1', NULL, NULL, NULL, '', '', ''),
(35, 'BG', 'Bulgaria', '1', NULL, NULL, NULL, '', '', ''),
(36, 'BF', 'Burkina Faso', '1', NULL, NULL, NULL, '', '', ''),
(37, 'BI', 'Burundi', '1', NULL, NULL, NULL, '', '', ''),
(38, 'KH', 'Cambodia', '1', NULL, NULL, NULL, '', '', ''),
(39, 'CM', 'Cameroon', '1', NULL, NULL, NULL, '', '', ''),
(40, 'CV', 'Cape Verde', '1', NULL, NULL, NULL, '', '', ''),
(41, 'KY', 'Cayman Islands', '1', NULL, NULL, NULL, '', '', ''),
(42, 'CF', 'Central African Republic', '1', NULL, NULL, NULL, '', '', ''),
(43, 'TD', 'Chad', '1', NULL, NULL, NULL, '', '', ''),
(44, 'CL', 'Chile', '1', NULL, NULL, NULL, '', '', ''),
(45, 'CN', 'China', '1', NULL, NULL, NULL, '', '', ''),
(46, 'CX', 'Christmas Island', '1', NULL, NULL, NULL, '', '', ''),
(47, 'CC', 'Cocos (Keeling) Islands', '1', NULL, NULL, NULL, '', '', ''),
(48, 'CO', 'Colombia', '1', NULL, NULL, NULL, '', '', ''),
(49, 'KM', 'Comoros', '1', NULL, NULL, NULL, '', '', ''),
(50, 'CG', 'Congo', '1', NULL, NULL, NULL, '', '', ''),
(51, 'CK', 'Cook Islands', '1', NULL, NULL, NULL, '', '', ''),
(52, 'CR', 'Costa Rica', '1', NULL, NULL, NULL, '', '', ''),
(53, 'HR', 'Croatia (Hrvatska)', '1', NULL, NULL, NULL, '', '', ''),
(54, 'CU', 'Cuba', '1', NULL, NULL, NULL, '', '', ''),
(55, 'CY', 'Cyprus', '1', NULL, NULL, NULL, '', '', ''),
(56, 'CZ', 'Czech Republic', '1', NULL, NULL, NULL, '', '', ''),
(57, 'DK', 'Denmark', '1', NULL, NULL, NULL, '', '', ''),
(58, 'DJ', 'Djibouti', '1', NULL, NULL, NULL, '', '', ''),
(59, 'DM', 'Dominica', '1', NULL, NULL, NULL, '', '', ''),
(60, 'DO', 'Dominican Republic', '1', NULL, NULL, NULL, '', '', ''),
(61, 'TP', 'East Timor', '1', NULL, NULL, NULL, '', '', ''),
(62, 'EC', 'Ecudaor', '1', NULL, NULL, NULL, '', '', ''),
(63, 'EG', 'Egypt', '1', NULL, NULL, NULL, '', '', ''),
(64, 'SV', 'El Salvador', '1', NULL, NULL, NULL, '', '', ''),
(65, 'GQ', 'Equatorial Guinea', '1', NULL, NULL, NULL, '', '', ''),
(66, 'ER', 'Eritrea', '1', NULL, NULL, NULL, '', '', ''),
(67, 'EE', 'Estonia', '1', NULL, NULL, NULL, '', '', ''),
(68, 'ET', 'Ethiopia', '1', NULL, NULL, NULL, '', '', ''),
(69, 'FK', 'Falkland Islands (Malvinas)', '1', NULL, NULL, NULL, '', '', ''),
(70, 'FO', 'Faroe Islands', '1', NULL, NULL, NULL, '', '', ''),
(71, 'FJ', 'Fiji', '1', NULL, NULL, NULL, '', '', ''),
(72, 'FI', 'Finland', '1', NULL, NULL, NULL, '', '', ''),
(73, 'FR', 'France', '1', NULL, NULL, NULL, '', '', ''),
(74, 'FX', 'France, Metropolitan', '1', NULL, NULL, NULL, '', '', ''),
(75, 'GF', 'French Guiana', '1', NULL, NULL, NULL, '', '', ''),
(76, 'PF', 'French Polynesia', '1', NULL, NULL, NULL, '', '', ''),
(77, 'TF', 'French Southern Territories', '1', NULL, NULL, NULL, '', '', ''),
(78, 'GA', 'Gabon', '1', NULL, NULL, NULL, '', '', ''),
(79, 'GM', 'Gambia', '1', NULL, NULL, NULL, '', '', ''),
(80, 'GE', 'Georgia', '1', NULL, NULL, NULL, '', '', ''),
(81, 'DE', 'Germany', '1', NULL, NULL, NULL, '', '', ''),
(82, 'GH', 'Ghana', '1', NULL, NULL, NULL, '', '', ''),
(83, 'GI', 'Gibraltar', '1', NULL, NULL, NULL, '', '', ''),
(84, 'GR', 'Greece', '1', NULL, NULL, NULL, '', '', ''),
(85, 'GL', 'Greenland', '1', NULL, NULL, NULL, '', '', ''),
(86, 'GD', 'Grenada', '1', NULL, NULL, NULL, '', '', ''),
(87, 'GP', 'Guadeloupe', '1', NULL, NULL, NULL, '', '', ''),
(88, 'GU', 'Guam', '1', NULL, NULL, NULL, '', '', ''),
(89, 'GT', 'Guatemala', '1', NULL, NULL, NULL, '', '', ''),
(90, 'GN', 'Guinea', '1', NULL, NULL, NULL, '', '', ''),
(91, 'GW', 'Guinea-Bissau', '1', NULL, NULL, NULL, '', '', ''),
(92, 'GY', 'Guyana', '1', NULL, NULL, NULL, '', '', ''),
(93, 'HT', 'Haiti', '1', NULL, NULL, NULL, '', '', ''),
(94, 'HM', 'Heard and Mc Donald Islands', '1', NULL, NULL, NULL, '', '', ''),
(95, 'HN', 'Honduras', '1', NULL, NULL, NULL, '', '', ''),
(96, 'HK', 'Hong Kong', '1', NULL, NULL, NULL, '', '', ''),
(97, 'HU', 'Hungary', '1', NULL, NULL, NULL, '', '', ''),
(98, 'IS', 'Iceland', '1', NULL, NULL, NULL, '', '', ''),
(99, 'IN', 'India', '1', NULL, NULL, NULL, '', '', ''),
(100, 'ID', 'Indonesia', '1', NULL, NULL, NULL, '', '', ''),
(101, 'IR', 'Iran (Islamic Republic of)', '1', NULL, NULL, NULL, '', '', ''),
(102, 'IQ', 'Iraq', '1', NULL, NULL, NULL, '', '', ''),
(103, 'IE', 'Ireland', '1', NULL, NULL, NULL, '', '', ''),
(104, 'IL', 'Israel', '1', NULL, NULL, NULL, '', '', ''),
(105, 'IT', 'Italy', '1', NULL, NULL, NULL, '', '', ''),
(106, 'CI', 'Ivory Coast', '1', NULL, NULL, NULL, '', '', ''),
(107, 'JM', 'Jamaica', '1', NULL, NULL, NULL, '', '', ''),
(108, 'JP', 'Japan', '1', NULL, NULL, NULL, '', '', ''),
(109, 'JO', 'Jordan', '1', NULL, NULL, NULL, '', '', ''),
(110, 'KZ', 'Kazakhstan', '1', NULL, NULL, NULL, '', '', ''),
(111, 'KE', 'Kenya', '1', NULL, NULL, NULL, '', '', ''),
(112, 'KI', 'Kiribati', '1', NULL, NULL, NULL, '', '', ''),
(113, 'KP', 'Korea, Democratic People''s Republic of', '1', NULL, NULL, NULL, '', '', ''),
(114, 'KR', 'Korea, Republic of', '1', NULL, NULL, NULL, '', '', ''),
(115, 'KW', 'Kuwait', '1', NULL, NULL, NULL, '', '', ''),
(116, 'KG', 'Kyrgyzstan', '1', NULL, NULL, NULL, '', '', ''),
(117, 'LA', 'Laos', '1', '', NULL, NULL, '', '', ''),
(118, 'LV', 'Latvia', '1', NULL, NULL, NULL, '', '', ''),
(119, 'LB', 'Lebanon', '1', NULL, NULL, NULL, '', '', ''),
(120, 'LS', 'Lesotho', '1', NULL, NULL, NULL, '', '', ''),
(121, 'LR', 'Liberia', '1', NULL, NULL, NULL, '', '', ''),
(122, 'LY', 'Libyan Arab Jamahiriya', '1', NULL, NULL, NULL, '', '', ''),
(123, 'LI', 'Liechtenstein', '1', NULL, NULL, NULL, '', '', ''),
(124, 'LT', 'Lithuania', '1', NULL, NULL, NULL, '', '', ''),
(125, 'LU', 'Luxembourg', '1', NULL, NULL, NULL, '', '', ''),
(126, 'MO', 'Macau', '1', NULL, NULL, NULL, '', '', ''),
(127, 'MK', 'Macedonia', '1', NULL, NULL, NULL, '', '', ''),
(128, 'MG', 'Madagascar', '1', NULL, NULL, NULL, '', '', ''),
(129, 'MW', 'Malawi', '1', NULL, NULL, NULL, '', '', ''),
(130, 'MY', 'Malaysia', '1', NULL, NULL, NULL, '', '', ''),
(131, 'MV', 'Maldives', '1', NULL, NULL, NULL, '', '', ''),
(132, 'ML', 'Mali', '1', NULL, NULL, NULL, '', '', ''),
(133, 'MT', 'Malta', '1', NULL, NULL, NULL, '', '', ''),
(134, 'MH', 'Marshall Islands', '1', NULL, NULL, NULL, '', '', ''),
(135, 'MQ', 'Martinique', '1', NULL, NULL, NULL, '', '', ''),
(136, 'MR', 'Mauritania', '1', NULL, NULL, NULL, '', '', ''),
(137, 'MU', 'Mauritius', '1', NULL, NULL, NULL, '', '', ''),
(138, 'TY', 'Mayotte', '1', NULL, NULL, NULL, '', '', ''),
(139, 'MX', 'Mexico', '1', NULL, NULL, NULL, '', '', ''),
(140, 'FM', 'Micronesia, Federated States of', '1', NULL, NULL, NULL, '', '', ''),
(141, 'MD', 'Moldova, Republic of', '1', NULL, NULL, NULL, '', '', ''),
(142, 'MC', 'Monaco', '1', NULL, NULL, NULL, '', '', ''),
(143, 'MN', 'Mongolia', '1', NULL, NULL, NULL, '', '', ''),
(144, 'MS', 'Montserrat', '1', NULL, NULL, NULL, '', '', ''),
(145, 'MA', 'Morocco', '1', NULL, NULL, NULL, '', '', ''),
(146, 'MZ', 'Mozambique', '1', NULL, NULL, NULL, '', '', ''),
(147, 'MM', 'Myanmar', '1', NULL, NULL, NULL, '', '', ''),
(148, 'NA', 'Namibia', '1', NULL, NULL, NULL, '', '', ''),
(149, 'NR', 'Nauru', '1', NULL, NULL, NULL, '', '', ''),
(150, 'NP', 'Nepal', '1', NULL, NULL, NULL, '', '', ''),
(151, 'NL', 'Netherlands', '1', NULL, NULL, NULL, '', '', ''),
(152, 'AN', 'Netherlands Antilles', '1', NULL, NULL, NULL, '', '', ''),
(153, 'NC', 'New Caledonia', '1', NULL, NULL, NULL, '', '', ''),
(154, 'NZ', 'New Zealand', '1', NULL, NULL, NULL, '', '', ''),
(155, 'NI', 'Nicaragua', '1', NULL, NULL, NULL, '', '', ''),
(156, 'NE', 'Niger', '1', NULL, NULL, NULL, '', '', ''),
(157, 'NG', 'Nigeria', '1', NULL, NULL, NULL, '', '', ''),
(158, 'NU', 'Niue', '1', NULL, NULL, NULL, '', '', ''),
(159, 'NF', 'Norfork Island', '1', NULL, NULL, NULL, '', '', ''),
(160, 'MP', 'Northern Mariana Islands', '1', NULL, NULL, NULL, '', '', ''),
(161, 'NO', 'Norway', '1', NULL, NULL, NULL, '', '', ''),
(162, 'OM', 'Oman', '1', NULL, NULL, NULL, '', '', ''),
(163, 'PK', 'Pakistan', '1', '', '', '13', '', '', ''),
(164, 'PW', 'Palau', '1', NULL, NULL, NULL, '', '', ''),
(165, 'PA', 'Panama', '1', NULL, NULL, NULL, '', '', ''),
(166, 'PG', 'Papua New Guinea', '1', NULL, NULL, NULL, '', '', ''),
(167, 'PY', 'Paraguay', '1', NULL, NULL, NULL, '', '', ''),
(168, 'PE', 'Peru', '1', NULL, NULL, NULL, '', '', ''),
(169, 'PH', 'Philippines', '1', NULL, NULL, NULL, '', '', ''),
(170, 'PN', 'Pitcairn', '1', NULL, NULL, NULL, '', '', ''),
(171, 'PL', 'Poland', '1', NULL, NULL, NULL, '', '', ''),
(172, 'PT', 'Portugal', '1', NULL, NULL, NULL, '', '', ''),
(173, 'PR', 'Puerto Rico', '1', NULL, NULL, NULL, '', '', ''),
(174, 'QA', 'Qatar', '1', NULL, NULL, NULL, '', '', ''),
(175, 'RE', 'Reunion', '1', NULL, NULL, NULL, '', '', ''),
(176, 'RO', 'Romania', '1', NULL, NULL, NULL, '', '', ''),
(177, 'RU', 'Russian Federation', '1', NULL, NULL, NULL, '', '', ''),
(178, 'RW', 'Rwanda', '1', NULL, NULL, NULL, '', '', ''),
(179, 'KN', 'Saint Kitts and Nevis', '1', NULL, NULL, NULL, '', '', ''),
(180, 'LC', 'Saint Lucia', '1', NULL, NULL, NULL, '', '', ''),
(181, 'VC', 'Saint Vincent and the Grenadines', '1', NULL, NULL, NULL, '', '', ''),
(182, 'WS', 'Samoa', '1', NULL, NULL, NULL, '', '', ''),
(183, 'SM', 'San Marino', '1', NULL, NULL, NULL, '', '', ''),
(184, 'ST', 'Sao Tome and Principe', '1', NULL, NULL, NULL, '', '', ''),
(185, 'SA', 'Saudi Arabia', '1', NULL, NULL, NULL, '', '', ''),
(186, 'SN', 'Senegal', '1', NULL, NULL, NULL, '', '', ''),
(187, 'SC', 'Seychelles', '1', NULL, NULL, NULL, '', '', ''),
(188, 'SL', 'Sierra Leone', '1', NULL, NULL, NULL, '', '', ''),
(189, 'SG', 'Singapore', '1', NULL, NULL, NULL, '', '', ''),
(190, 'SK', 'Slovakia', '1', NULL, NULL, NULL, '', '', ''),
(191, 'SI', 'Slovenia', '1', NULL, NULL, NULL, '', '', ''),
(192, 'SB', 'Solomon Islands', '1', NULL, NULL, NULL, '', '', ''),
(193, 'SO', 'Somalia', '1', NULL, NULL, NULL, '', '', ''),
(194, 'ZA', 'South Africa', '1', NULL, NULL, NULL, '', '', ''),
(195, 'GS', 'South Georgia South Sandwich Islands', '1', NULL, NULL, NULL, '', '', ''),
(196, 'ES', 'Spain', '1', NULL, NULL, NULL, '', '', ''),
(197, 'LK', 'Sri Lanka', '1', NULL, NULL, NULL, '', '', ''),
(198, 'SH', 'St. Helena', '1', NULL, NULL, NULL, '', '', ''),
(199, 'PM', 'St. Pierre and Miquelon', '1', NULL, NULL, NULL, '', '', ''),
(200, 'SD', 'Sudan', '1', NULL, NULL, NULL, '', '', ''),
(201, 'SR', 'Suriname', '1', NULL, NULL, NULL, '', '', ''),
(202, 'SJ', 'Svalbarn and Jan Mayen Islands', '1', NULL, NULL, NULL, '', '', ''),
(203, 'SZ', 'Swaziland', '1', NULL, NULL, NULL, '', '', ''),
(204, 'SE', 'Sweden', '1', NULL, NULL, NULL, '', '', ''),
(205, 'CH', 'Switzerland', '1', NULL, NULL, NULL, '', '', ''),
(206, 'SY', 'Syrian Arab Republic', '1', NULL, NULL, NULL, '', '', ''),
(207, 'TW', 'Taiwan', '1', NULL, NULL, NULL, '', '', ''),
(208, 'TJ', 'Tajikistan', '1', NULL, NULL, NULL, '', '', ''),
(209, 'TZ', 'Tanzania, United Republic of', '1', NULL, NULL, NULL, '', '', ''),
(210, 'TH', 'Thailand', '1', NULL, NULL, NULL, '', '', ''),
(211, 'TG', 'Togo', '1', NULL, NULL, NULL, '', '', ''),
(212, 'TK', 'Tokelau', '1', NULL, NULL, NULL, '', '', ''),
(213, 'TO', 'Tonga', '1', NULL, NULL, NULL, '', '', ''),
(214, 'TT', 'Trinidad and Tobago', '1', NULL, NULL, NULL, '', '', ''),
(215, 'TN', 'Tunisia', '1', NULL, NULL, NULL, '', '', ''),
(216, 'TR', 'Turkey', '1', NULL, NULL, NULL, '', '', ''),
(217, 'TM', 'Turkmenistan', '1', NULL, NULL, NULL, '', '', ''),
(218, 'TC', 'Turks and Caicos Islands', '1', NULL, NULL, NULL, '', '', ''),
(219, 'TV', 'Tuvalu', '1', NULL, NULL, NULL, '', '', ''),
(220, 'UG', 'Uganda', '1', NULL, NULL, NULL, '', '', ''),
(221, 'UA', 'Ukraine', '1', NULL, NULL, NULL, '', '', ''),
(222, 'AE', 'United Arab Emirates', '1', NULL, NULL, NULL, '', '', ''),
(223, 'GB', 'United Kingdom', '1', NULL, NULL, NULL, '', '', ''),
(224, 'UM', 'United States minor outlying islands', '1', NULL, NULL, NULL, '', '', ''),
(225, 'UY', 'Uruguay', '1', NULL, NULL, NULL, '', '', ''),
(226, 'UZ', 'Uzbekistan', '1', NULL, NULL, NULL, '', '', ''),
(227, 'VU', 'Vanuatu', '1', NULL, NULL, NULL, '', '', ''),
(228, 'VA', 'Vatican City State', '1', NULL, NULL, NULL, '', '', ''),
(229, 'VE', 'Venezuela', '1', '', '', '14', '', '', ''),
(230, 'VN', 'Vietnam', '1', NULL, NULL, NULL, '', '', ''),
(231, 'VG', 'Virigan Islands (British)', '1', NULL, NULL, NULL, '', '', ''),
(232, 'VI', 'Virgin Islands (U.S.)', '1', NULL, NULL, NULL, '', '', ''),
(233, 'WF', 'Wallis and Futuna Islands', '1', NULL, NULL, NULL, '', '', ''),
(234, 'EH', 'Western Sahara', '1', NULL, NULL, NULL, '', '', ''),
(235, 'YE', 'Yemen', '1', NULL, NULL, NULL, '', '', ''),
(236, 'YU', 'Yugoslavia', '1', NULL, NULL, NULL, '', '', ''),
(237, 'ZR', 'Zaire', '1', NULL, NULL, NULL, '', '', ''),
(238, 'ZM', 'Zambia', '1', NULL, NULL, NULL, '', '', ''),
(239, 'ZW', 'Zimbabwe', '1', NULL, NULL, NULL, '', '', '');

DROP TABLE IF EXISTS `#__bookpro_coupon`;
CREATE TABLE IF NOT EXISTS `#__bookpro_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `subtract_type` tinyint(4) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `publish_date` date NOT NULL,
  `unpublish_date` date NOT NULL,
  `state` tinyint(4) NOT NULL,
  `total` smallint(6) NOT NULL,
  `remain` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `#__bookpro_coupon` (`id`, `code`, `title`, `subtract_type`, `amount`, `publish_date`, `unpublish_date`, `state`, `total`, `remain`) VALUES
(1, '10FOFF', '10$ Discount Fixed amount', 0, '10', '2013-10-09', '2013-10-31', 1, 10, 0),
(2, '5POFF', '5 percentage off', 1, '5', '2013-10-01', '2013-12-31', 1, 2, 0);

DROP TABLE IF EXISTS `#__bookpro_currency`;
CREATE TABLE IF NOT EXISTS `#__bookpro_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(255) NOT NULL,
  `currency_code` varchar(255) NOT NULL,
  `currency_symbol` varchar(255) NOT NULL,
  `currency_exchange_rate` decimal(10,5) NOT NULL,
  `currency_display` tinyint(1) NOT NULL,
  `thousand_currency` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `#__bookpro_currency` (`id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_exchange_rate`, `currency_display`, `thousand_currency`, `state`) VALUES
(1, 'USD', 'USD', '$', 1.00000, 0, ',', 1),
(2, 'Euro', 'EUR', '€', 0.07500, 0, ',', 1);

DROP TABLE IF EXISTS `#__bookpro_customer`;
CREATE TABLE IF NOT EXISTS `#__bookpro_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `firstname` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `states` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(20) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `cardholder` varchar(100) DEFAULT NULL,
  `orther` varchar(200) NOT NULL,
  `created` datetime DEFAULT NULL,
  `billing_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` datetime NOT NULL,
  `state` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` date NOT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `cgroup_id` int(11) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `#__bookpro_dest`;
CREATE TABLE IF NOT EXISTS `#__bookpro_dest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `path` varchar(200) NOT NULL,
  `access` tinyint(4) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `value` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `images` tinytext NOT NULL,
  `country_id` int(11) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `ordering` int(11) NOT NULL,
  `code` varchar(4) DEFAULT NULL,
  `state` tinyint(11) NOT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `state_id` smallint(6) DEFAULT NULL,
  `desc` text,
  `metakey` tinytext,
  `metadesc` mediumtext,
  `province` tinyint(4) DEFAULT NULL,
  `air` tinyint(4) DEFAULT NULL,
  `bus` tinyint(4) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `intro` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=397 ;

INSERT INTO `#__bookpro_dest` (`id`, `lft`, `rgt`, `path`, `access`, `parent_id`, `title`, `value`, `image`, `images`, `country_id`, `alias`, `ordering`, `code`, `state`, `longitude`, `latitude`, `state_id`, `desc`, `metakey`, `metadesc`, `province`, `air`, `bus`, `level`, `intro`) VALUES
(1, 0, 67, '', 0, 0, 'Root', '', '', '', 0, 'root', 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, ''),
(391, 25, 26, '', 1, 1, 'Da Nang City', 'Danang city', '/ratnagiri.jpg', '', 230, 'ratnagiri', 0, 'DNA', 1, 108.217, 16.0486, NULL, '', NULL, NULL, 1, 0, 1, 1, ''),
(392, 31, 32, '', 1, 1, 'Hue City', 'Hue', '/raigad.jpg', '', 230, 'raigad', 0, 'HUE', 1, 107.579, 16.4569, NULL, '', NULL, NULL, 1, 0, 1, 1, ''),
(393, 33, 34, '', 1, 1, 'Hanoi', 'Hanoi', '/sindhudurg.jpg', '', 230, 'sindhudurga', 0, 'HAN', 1, 105.834, 21.0267, NULL, '', NULL, NULL, 1, 1, 1, 1, ''),
(394, 37, 38, '', 1, 1, 'Dalat City', 'Dalat', '/sindhudurg.jpg', '', 230, 'mumbai', 0, 'DLC', 1, 108.459, 11.9395, NULL, '', NULL, NULL, 1, 0, 0, 1, ''),
(396, 41, 42, '', 1, 1, 'Ho Chi Minh City', 'Hochiminh', '', '', 230, 'ho-chi-minh-city', 0, 'SGN', 1, 106.634, 10.8208, NULL, '', NULL, NULL, 1, 0, 0, 1, '');

DROP TABLE IF EXISTS `#__bookpro_orders`;
CREATE TABLE IF NOT EXISTS `#__bookpro_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `order_number` varchar(32) DEFAULT NULL,
  `total` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `total_bag` decimal(15,5) NOT NULL,
  `subtotal` decimal(15,5) DEFAULT NULL,
  `pay_method` varchar(100) NOT NULL,
  `pay_status` varchar(20) DEFAULT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(16) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `notes` text NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `tax` varchar(45) DEFAULT NULL,
  `service_fee` varchar(45) DEFAULT NULL,
  `order_status` varchar(20) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `tx_id` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `deposit` decimal(15,5) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `refund_amount` float NOT NULL,
  `refund_date` datetime NOT NULL,
  `seat` varchar(255) NOT NULL,
  `return_seat` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Used to store all orders' AUTO_INCREMENT=80 ;



DROP TABLE IF EXISTS `#__bookpro_passenger`;
CREATE TABLE IF NOT EXISTS `#__bookpro_passenger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `age` varchar(200) NOT NULL,
  `passport` varchar(50) NOT NULL,
  `ppvalid` datetime DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `documenttype` int(11) NOT NULL,
  `seat` varchar(20) NOT NULL,
  `return_seat` varchar(20) NOT NULL,
  `route_id` int(11) NOT NULL,
  `return_route_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `return_price` float NOT NULL,
  `start` datetime NOT NULL,
  `return_start` datetime NOT NULL,
  `bag_qty` int(11) NOT NULL,
  `price_bag` float NOT NULL,
  `return_bag_qty` int(11) NOT NULL,
  `return_price_bag` float NOT NULL,
  `params` text NOT NULL,
  `pnr` varchar(20) NOT NULL,
  `notes` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `#__bookpro_refund`;
CREATE TABLE IF NOT EXISTS `#__bookpro_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_hour` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `#__bookpro_refund` (`id`, `number_hour`, `amount`, `state`) VALUES
(1, 36, 20, 1),
(2, 10, 50, 1),
(3, 1, 100, 1);

DROP TABLE IF EXISTS `#__bookpro_roomrate`;
CREATE TABLE IF NOT EXISTS `#__bookpro_roomrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pricetype` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `adult` float NOT NULL,
  `room_id` int(11) NOT NULL,
  `child` float NOT NULL,
  `infant` float NOT NULL,
  `discount` float NOT NULL,
  `adult_roundtrip` float NOT NULL,
  `child_roundtrip` float NOT NULL,
  `infant_roundtrip` float NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`,`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `#__bookpro_roomratelog`;
CREATE TABLE IF NOT EXISTS `#__bookpro_roomratelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `params` text NOT NULL,
  `weekdays` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

SET foreign_key_checks = 1;

ALTER TABLE `#__bookpro_busstop`
  ADD CONSTRAINT `#__bookpro_busstop_ibfk_2` FOREIGN KEY (`bustrip_id`) REFERENCES `#__bookpro_bustrip` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `#__bookpro_orders`
  ADD CONSTRAINT `#__bookpro_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__bookpro_customer` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `#__bookpro_passenger`
  ADD CONSTRAINT `#__bookpro_passenger_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `#__bookpro_orders` (`id`) ON DELETE CASCADE;


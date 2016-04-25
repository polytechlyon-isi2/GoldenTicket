--
-- Contenu de la table `user`
--

INSERT INTO `user` (`num_user`, `name_user`, `surname_user`, `login_user`, `password_user`, `salt_user`, `role_user`) VALUES
(7, 'admin', 'admin', 'admin', 'YoKhvUWiBBZF+OQ79cmOW6N99fh3JUp51YL1vMKdcLoThwpxjyoEM2Ao1ftxJR7TLV3+r1NeR62h6W3T1GU6AA==', 'd5c0a7a0e0c6efc7e493399', 'ROLE_ADMIN');


--
-- Contenu de la table `eventtype`
--

INSERT INTO `eventtype` (`num_ET`, `name_ET`) VALUES
(4, 'Sport'),
(6, 'Music'),
(7, 'Comedy');

-- --------------------------------------------------------


--
-- Contenu de la table `order_gd`
--

INSERT INTO `order_gd` (`num_order`, `num_user`, `status_order`) VALUES
(4, 7, NULL);


--
-- Contenu de la table `status`
--

INSERT INTO `status` (`num_status`, `name_status`) VALUES
(1, 'Sold-out'),
(2, 'Not open yet'),
(3, 'Available');



--
-- Contenu de la table `event`
--

INSERT INTO `event` (`num_event`, `name_event`, `minimalPrice_event`, `startDate_event`, `startHour_event`, `endDate_event`, `endHour_event`, `desc_event`, `num_status`, `num_ET`, `coverImage_event`) VALUES
(6, 'Beyoncé - The Formation World Tour - MIAMI', 45, '2016-04-27', '19:30:00', '2016-04-28', '00:16:00', 'Infos\r\nThe Formation World Tour is the upcoming seventh concert tour by American singer Beyoncé in support of her sixth studio album, Lemonade. The all-stadium tour was announced following her guest appearance at the Super Bowl 50 halftime show. The tour is currently scheduled to start in Miami, Florida and conclude in Barcelona, Spain. The tour''s title is in reference to Beyoncé''s 2016 song "Formation."\r\n\r\nParking\r\nThere are 4 parking garages on site. $30.00 charge. To purchase parking, go to Marlins.com. \r\n\r\nGeneral Rules\r\nITEMS -NOT- ALLOWED IN FACILITY : GLASS BOTTLES, METAL CANS, HARD-SIDED COOLERS, OPEN OR HARD-SIDED CONTAINERS, COMMERCIAL-GRADE AUDIO, VIDEO OR PHOTOGRAPHIC EQUIPMENT, ALCOHOL OR ILLEGAL SUBSTANCES, SOFT DRINKS OR SPORTS/ENERGY DRINKS, FIREWORKS, LASER POINTERS, BROOMS, POLES, GOLF UMBRELLAS OR STROLLERS, WEAPONS (REGARDLESS OF PERMIT), PETS (EXCEPT FOR SERVICE ANIMALS OR DURING SPECIFIC PROMOTIONS. \r\n\r\n* ITEMS ALLOWED IN FACILITY : ONE SOFT-SIDED, FACTORY-SEALED WATER BOTTLE OF 20 OUNCES OR LESS, ONE SINGLE SERVING FOOD ITEM CONTAINED IN A CLEAR PLASTIC BAG - PIECES OF FRUIT MUST BE SLICED, BAGS NO LARGER THAN 16"X16"X8" IN SIZE - ALL BAGS ARE SUBJECT TO INSPECTION.\r\n\r\n* SMOKING POLICY : SMOKING IS NOT PERMITTED.', NULL, 6, '5539d94c3f2e9b66a8fbcb6a9b5f0f0b.jpg'),
(7, 'Kevin Hart: WHAT NOW TOUR - NEW YORK', 45, '2016-06-15', '19:00:00', '2016-06-15', '23:00:00', 'On July 16, 2015, Universal Pictures announced that Kevin Hart: What Now, a stand-up comedy film starring Kevin Hart, will be released theatrically in the United States on October 14, 2016. The concert was filmed live on August 30, 2015 in front of 53,000 people at Philadelphia’s Lincoln Financial Field, with a live dress rehearsal for a small, intimate audience filmed at the stadium the night before on August 29, 2015.\r\n\r\nThe film''s teaser trailer was released January 12, 2016 and was shown in front of screenings of Universal''s Ride Along 2.', NULL, 7, 'e641795aff833d4c69c6382e76108a0e.jpg');

-- --------------------------------------------------------
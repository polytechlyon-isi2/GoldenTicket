-- Remplissage de la table EventType
INSERT INTO `golden_ticket`.`eventtype` (`num_ET`, `name_ET`)
VALUES
	(NULL, 'Sport'),
	(NULL, 'Musique');

-- Remplissage de la table status
INSERT INTO `golden_ticket`.`status` (`num_status`, `name_status`)
VALUES
	(NULL, 'Sold-out'),
	(NULL, 'Not open yet'),
	(NULL, 'Available');


INSERT INTO `golden_ticket`.`event` (`num_event`, `name_event`, `minimalPrice_event`, `startDate_event`, `startHour_event`, `endDate_event`, `endHour_event`, `desc_event`, `num_status`, `num_ET`, `coverImage_event`)
VALUES
	(NULL, 'Hip-Hop contest', '10', '2016-03-26', '00:50:00', '2016-03-31', '09:00:20', 'Putin de battle de Hip-Hop', '3', '2', NULL),
	(NULL, 'Champions League', '91', '2016-03-30', '21:00:00', '2016-03-30', '23:00:00', 'C''est la Champions League 75 c''est la Champions League 91 c''est la Champions League 92 c''est la Champions League 93 c''est la Champions League 94 c''est la Champions League 95 c''est la Champions League 77 c''est la Champions League 78 c''est la Champions League C''est la Champions League Paname c''est la Champions League Fuck si t''es pas d''ma team Paname c''est la Champions League On baise tout en Champions League Paname c''est la Champions League Fuck si t''es pas d''ma team On baise tout en Champions League', '1', '1', NULL);

INSERT INTO `golden_ticket`.`user` (`num_user`, `name_user`, `surname_user`, `login_user`, `password_user`)
VALUES
	(NULL, 'Jean', 'Michel', 'User1', 'toto'),
	(NULL, 'Jean', 'Kader', 'User2', 'toto');

INSERT INTO `golden_ticket`.`commentary` (`num_commentary`, `rate_commentary`, `text_commentary`, `num_event`, `num_user`)
VALUES
	(NULL, '5', 'De la grosse peufra', '1', '1'),
	(NULL, '5', 'Ici c''est paname Champions League', '2', '2');

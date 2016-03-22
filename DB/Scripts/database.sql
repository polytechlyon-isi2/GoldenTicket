create database if not exists golden_ticket character set utf8 collate utf8_unicode_ci;
<<<<<<< HEAD
use golden_tickets;
=======
use golden_ticket;
>>>>>>> 69b8992d10ba0c6a689fdb78480a6790f65702a4

grant all privileges on golden_ticket.* to 'golden_ticket'@'localhost' identified by 'secret';
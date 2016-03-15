create database if not exists golden_ticket character set utf8 collate utf8_unicode_ci;
use golden_ticket;

grant all privileges on golden_ticket.* to 'golden_ticket'@'localhost' identified by 'secret';
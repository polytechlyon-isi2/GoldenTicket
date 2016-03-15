create database if not exists golden_tickets character set utf8 collate utf8_unicode_ci;
use golden_tickets;

grant all privileges on golden_tickets.* to 'golden_tickets_user'@'localhost' identified by 'secret';
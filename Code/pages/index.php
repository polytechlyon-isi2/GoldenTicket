<?php
$bdd = new PDO('mysql:host=localhost;dbname=golden_ticket;charset=utf8', 'golden_ticket', 'secret');
$events = $bdd->query('select * from event');

// Data display
require 'view.php';

?>

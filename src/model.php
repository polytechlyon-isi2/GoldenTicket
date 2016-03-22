
<?php
function getEvents() {
    $bdd = new PDO('mysql:host=localhost;dbname=golden_ticket;charset=utf8', 'golden_ticket', 'secret');
    $events = $bdd->query('select * from event order by num_event desc');
    return $events;
}

<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="../css/GoldenTicket.css" rel="stylesheet" />
    <title>GoldenTicket - Home</title>
</head>
<body>
    <header>
        <h1>GoldenTicket</h1>
    </header>
    <?php
    $bdd = new PDO('mysql:host=localhost;dbname=golden_ticket;charset=utf8', 'golden_ticket', 'secret');
    $events = $bdd->query('select * from event');
    foreach ($events as $event): ?>
    <article>
        <h2><?php echo $event['event_name'] ?></h2>
        <p><?php echo $event['minimalPrice_event'] ?></p>
    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>
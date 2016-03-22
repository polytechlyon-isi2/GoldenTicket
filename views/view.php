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
    <?php foreach ($events as $event): ?>
    <article>
        <h2><?php echo $event['event_name'] ?></h2>
        <p><?php echo $event['minimalPrice_event'] ?></p>
    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">GoldenTicket</a> is a miimalistic event application built as a showcase for modern PHP development.
    </footer>
</body>
</html>
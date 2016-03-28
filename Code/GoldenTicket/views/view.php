<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="GoldenTicket.css" rel="stylesheet" />
    <title>MicroCMS - Home</title>
</head>
<body>
    <header>
        <h1>MicroCMS</h1>
    </header>
    <?php foreach ($events as $event): ?>
    <article>
        <h2><?php echo $event->getNum() ?></h2>
        <p><?php echo $event->getName() ?></p>
    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>

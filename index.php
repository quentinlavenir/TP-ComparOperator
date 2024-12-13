<?php
require_once 'config/db.php';

$query = $db->query('SELECT * FROM destination');
$destinations = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cherry+Cream+Soda&family=Markazi+Text:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body class="px-20">
    <?php foreach ($destinations as $destination){ ?>
        <div class="flex flex-col items-center bg-blue-400 rounded-lg overflow-hidden">
            <h1 class="text-white"><?= $destination['location'] ?></h1>
            <img src="assets/img/<?= $destination['location'] ?>.jpg" alt="<?= $destination['location'] ?>">
        </div>
    <?php } ?>
</body>
</html>
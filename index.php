<?php
require_once 'classes/manager.php';
require_once 'config/db.php';
require_once 'classes/destination.php';

$manager = new Manager($db);

$destinations = $manager->getDestinations();
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
    <link rel="stylesheet" href="assets/css/font.css">
    <title>Document</title>
</head>
<body class="flex flex-col items-center">
    <header class="bg-green-400 w-full h-12 flex flex-row items-center border-b border-black justify-center mb-10">
        <img class="h-full" src="assets/img/logo.png" alt="logo">
        <h1 class="ml-6 cherry text-white text-xl">Comparoperator</h1>
    </header>
    <span class="markazi mb-4 text-2xl">Destinations</span>
    <div class="flex flex-row flex-wrap justify-center drop-shadow-2xl">
        <?php foreach ($destinations as $destination){ ?>
            <a href="tour-operator.php?location=<?= $destination->getLocation() ?>"><div class="w-72 h-52 flex flex-col items-center bg-blue-400 rounded-lg overflow-hidden m-6 hover:scale-105 cursor-pointer">
                <h1 class="text-white my-1 markazi text-3xl"><?= $destination->getLocation() ?></h1>
                <img class="w-full h-full" src="assets/img/<?= $destination->getLocation() ?>.jpg" alt="<?= $destination->getLocation() ?>">
            </div></a>
        <?php } ?>
    </div>
<script src="assets/js/script.js"></script>
</body>
</html>
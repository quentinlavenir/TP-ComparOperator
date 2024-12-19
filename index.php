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
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body class="flex flex-col items-center">
    <header class="w-full h-44 md:h-80 flex flex-row items-center border-b-2 border-black justify-center mb-10 relative">
        <img src="assets/img/banniere.jpg" alt="banniere" class="w-full h-full absolute z-0">
        <h1 class="ml-6 cherry text-white text-stroke text-2xl md:text-7xl z-10">Comparoperator</h1>
    </header>
    <div class="flex flex-col px-5">
        <span class="markazi mb-4 text-2xl ml-6">Destinations</span>
        <div class="flex flex-row flex-wrap mb-10">
            <?php foreach ($destinations as $destination){ ?>
                <a href="tour-operator.php?destination_id=<?= $destination->getId() ?>"><div class="w-72 flex flex-col items-center bg-blue-400 rounded-lg overflow-hidden m-6 hover:scale-105 cursor-pointer drop-shadow-2xl">
                    <h1 class="text-white my-1 markazi text-3xl"><?= $destination->getLocation() ?></h1>
                    <img class="w-full h-44" src="assets/img/<?= $destination->getLocation() ?>.jpg" alt="<?= $destination->getLocation() ?>">
                    <p class="bg-white markazi text-xl w-full h-full p-5"><?= $destination->getDescription() ?></p>
                </div></a>
            <?php } ?>
        </div>
    </div>
<script src="assets/js/script.js"></script>
</body>
</html>
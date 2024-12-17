<?php
require_once 'config/db.php';
require_once 'classes/manager.php';
require_once 'classes/tour_operateur.php';
require_once 'classes/destination.php';

$manager = new Manager($db);

$destinations = $manager->getDestinations();

$tourOperators = $manager->getTourOperators();

if (isset($_POST['addTourOperator'])) {
    $name = $_POST['name'];
    $link = $_POST['link'];

    $response = $manager->addTourOperator($name, $link);
    $_SESSION['addTourOperatorResponse'] = $response;
}

if (isset($_POST['addDestinationToTourOperator'])) {
    $tourOperatorId = $_POST['tourOperatorId'];
    $destinationId = $_POST['destinationId'];

    if ($tourOperatorId == 'null' || $destinationId == 'null') {
        $response = "Veuillez choisir un tour opérateur et une destination";
    }
    else {
        $response = $manager->addDestinationToTourOperator($tourOperatorId, $destinationId);
    }

    $_SESSION['addDestinationToTourOperatorResponse'] = $response;
}

if (isset($_POST['passTourOperatorPremium'])) {
    $tourOperatorId = $_POST['tourOperatorId'];

    if ($tourOperatorId === 'null') {
        $response = "Veuillez choisir un tour opérateur";
    }
    else {
        $response = $manager->passTourOperatorPremium($tourOperatorId);
    }
    $_SESSION['passTourOperatorPremiumResponse'] = $response;
}
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

    <div class="px-5">
        <form method="post" class="flex flex-col">
            <input type="hidden" name="addTourOperator">
            <span class="mb-3 markazi text-2xl ml-2">Ajouter un tour opérateur</span>
            <div class="flex flex-row flex-wrap items-center">
                <input type="text" name="name" placeholder="Nom" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                <input type="url" name="link" placeholder="Lien" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                <button type="submit" class="border px-10 rounded-lg bg-black text-white h-min markazi my-3 mx-2">Ajouter</button>
            </div>
        </form>

        <div class="mb-10">
            <?php if (isset($_SESSION['addTourOperatorResponse'])) { ?>
                <p class="mt-3 markazi text-lg ml-2"><?= $_SESSION['addTourOperatorResponse'] ?></p>
                <?php unset($_SESSION['addTourOperatorResponse']); ?>
            <?php } ?> 
        </div>

        <form method="post" class="flex flex-col">
            <input type="hidden" name="addDestinationToTourOperator">
            <span class="mb-3 markazi text-2xl ml-2">Ajouter une destination à un tour opérateur</span>
            <div class="flex flex-row flex-wrap items-center">
                <select name="tourOperatorId" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                    <option value="null">Tour opérateur</option>
                    <?php foreach ($tourOperators as $tourOperator){ ?>
                        <option value="<?= $tourOperator->getId() ?>"><?= $tourOperator->getName() ?></option>
                    <?php } ?>
                </select>
                <select name="destinationId" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                    <option value="null">Destination</option>
                    <?php foreach ($destinations as $destination){ ?>
                        <option value="<?= $destination->getId() ?>"><?= $destination->getLocation() ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="border px-10 rounded-lg bg-black text-white h-min markazi my-3 mx-2">Ajouter</button>
            </div>
        </form>

        <div class="mb-10">
            <?php if (isset($_SESSION['addDestinationToTourOperatorResponse'])) { ?>
                <p class="mt-3 markazi text-lg ml-2"><?= $_SESSION['addDestinationToTourOperatorResponse'] ?></p>
                <?php unset($_SESSION['addDestinationToTourOperatorResponse']); ?>
            <?php } ?>
        </div>

        <form method="post" class="flex flex-col">
            <input type="hidden" name="passTourOperatorPremium">
            <span class="mb-3 markazi text-2xl ml-2">Passer un tour opérateur en premium</span>
            <div class="flex flex-row flex-wrap items-center">
                <select name="tourOperatorId" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                    <option value="null">Tour opérateur</option>
                    <?php foreach ($tourOperators as $tourOperator){ ?>
                        <option value="<?= $tourOperator->getId() ?>"><?= $tourOperator->getName() ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="border px-10 rounded-lg bg-black text-white h-min markazi my-3 mx-2">Ajouter</button>
            </div>
        </form>

        <div>
            <?php if (isset($_SESSION['passTourOperatorPremiumResponse'])) { ?>
                <p class="mt-3 markazi text-lg ml-2"><?= $_SESSION['passTourOperatorPremiumResponse'] ?></p>
                <?php unset($_SESSION['passTourOperatorPremiumResponse']); ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>
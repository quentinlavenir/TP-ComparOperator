<?php
require_once 'config/db.php';
require_once 'classes/manager.php';
require_once 'classes/tour_operateur.php';
require_once 'classes/destination.php';
require_once 'classes/review.php';

$manager = new Manager($db);

$destinationId = $_GET['destination_id'];

$destination = $manager->getDestinationWithId($destinationId);

$tourOperatorsId = $destination->getTourOperatorId();

$tourOperators = [];
foreach ($tourOperatorsId as $i) {
    $tourOperator = $manager->getTourOperatorWithId($i);
    $tourOperators[] = $tourOperator;
}

if (isset($_POST['addReview'])) {
    $tourOperatorId = $_POST['tourOperatorId'];
    $message = $_POST['message'];
    $name = $_POST['name'];

    $response = $manager->addReview($message, $name, $tourOperatorId);
    $_SESSION['addReviewResponse'] = $response;
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
<body class="flex flex-col">
    <header class="bg-green-400 w-full h-12 flex flex-row items-center border-b border-black justify-center mb-10">
        <img class="h-full" src="assets/img/logo.png" alt="logo">
        <h1 class="ml-6 cherry text-white text-xl">Comparoperator</h1>
    </header>
    <a href="index.php" class="flex flex-row items-center px-5 mb-10">
        <img class="size-5 rotate-180 mr-1" src="assets/img/droit.png">
        <span class="markazi text-2xl"><?= $destination->getLocation() ?></span>
    </a>
    <span class="markazi text-5xl bg-black text-yellow-300 py-3 px-10 mb-10"><?= count($tourOperators) ?> tour opérateurs pour <?= $destination->getLocation() ?></span>
    <div class="flex flex-col px-5">
        <ul class="list-disc px-5">
            <?php foreach ($tourOperators as $i) { ?>
                <li><a href="#<?= $i->getId() ?>" class="markazi text-xl"><?= $i->getName() ?></a></li>
            <?php } ?>
        </ul>
        <div class="flex flex-row flex-wrap">
            <?php foreach ($tourOperators as $i) { ?>
                <div class="flex flex-col w-80 mb-10 mx-5">
                    <span id="<?= $i->getId() ?>" class="markazi text-4xl mt-10"><?= $i->getName() ?> - <?= $destination->getPrice() ?>€</span>
                    <p class="mb-3 markazi text-lg"><?= $i->getDescription() ?></p>
                    <?php if ($i->getIsPremium()) { ?>
                        <a href="<?= $i->getLink() ?>" class="markazi text-blue-400 underline text-xl mb-3"><?= $i->getLink() ?></a>
                    <?php } else { ?>
                        <button class="border px-10 rounded-lg bg-black text-yellow-300 h-min w-min markazi mt-3 mb-5 mx-2">Réserver</button>
                    <?php } ?>
                    <span class="markazi text-xl mb-3">Nombres d'avis globals: <?= $i->getScore() ?></span>

                    <form method="post" class="mb-3">
                        <input type="hidden" name="addReview">
                        <input type="hidden" name="tourOperatorId" value="<?= $i->getId() ?>">
                        <div class="flex flex-row flex-wrap items-center">
                            <input type="text" name="name" placeholder="Nom" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                            <input type="text" name="message" placeholder="Avis" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36">
                            <button type="submit" class="border px-10 rounded-lg bg-black text-white h-min markazi my-3 mx-2">Lesser un avis</button>
                        </div>
                    </form>

                    <div class="mb-3">
                        <?php if (isset($_SESSION['addReviewResponse'])) { ?>
                            <p class="mt-3 markazi text-lg ml-2"><?= $_SESSION['addReviewResponse'] ?></p>
                            <?php unset($_SESSION['addReviewResponse']); ?>
                        <?php } ?>
                    </div>

                    <?php $reviews = $manager->getReviewsWithTourOperatorId($i->getId()); ?>
                    <ul class="list-disc px-5">
                    <?php foreach ($reviews as $i) { ?>
                        <li class="markazi text-xl"><?= $i->getMessage() ?></li>
                    <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
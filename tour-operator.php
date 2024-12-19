<?php

session_start();

require_once 'config/db.php';
require_once 'classes/manager.php';
require_once 'classes/tour_operateur.php';
require_once 'classes/destination.php';
require_once 'classes/review.php';

$manager = new Manager($db);

if (isset($_POST['addReview'])) {
    $tourOperatorId = $_POST['tourOperatorId'];
    $message = $_POST['message'];
    $name = $_POST['name'];

    $response = $manager->addReview($message, $name, $tourOperatorId);
    $_SESSION["addReviewResponse{$tourOperatorId}"] = $response;
}

if (isset($_POST['rate'])) {
    $tourOperatorId = $_POST['tourOperatorId'];
    $name = $_POST['name'];
    $score = $_POST['score'];

    $response = $manager->rateTourOperator($tourOperatorId, $score, $name);
    $_SESSION["rateResponse{$tourOperatorId}"] = $response;
}

$destinationId = $_GET['destination_id'];

$destination = $manager->getDestinationWithId($destinationId);

$tourOperatorsId = $destination->getTourOperatorId();

$tourOperators = [];
foreach ($tourOperatorsId as $i) {
    $tourOperator = $manager->getTourOperatorWithId($i);
    $tourOperators[] = $tourOperator;
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
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body class="flex flex-col">
    <header class="w-full h-44 md:h-80 flex flex-row items-center border-b-2 border-black justify-center relative">
        <img src="assets/img/banniere.jpg" alt="banniere" class="w-full h-full absolute z-0">
        <h1 class="cherry text-white text-stroke text-2xl md:text-7xl z-10">Comparoperator</h1>
    </header>

    <div class="w-full h-44 md:h-80 flex flex-col items-center border-b-2 border-black justify-center mb-10 relative">
        <img src="assets/img/banniere-promo.jpg" alt="bannière promotionelle" class="w-full h-full absolute z-0 brightness-50">
        <h1 class="markazi text-white text-2xl md:text-7xl z-10"><?php echo end($tourOperators)->getName() ?></h1>
        <div class="flex flex-row items-center">
            <span class="markazi text-white text-xl md:text-5xl z-10 line-through decoration-red-500"><?php echo $destination->getPrice() ?>€</span>
            <span class="markazi text-white text-2xl md:text-5xl z-10 ml-4"> <?php echo $destination->getPrice() - 200 ?>€</span>
        </div>
        <a href="#<?= end($tourOperators)->getId() ?>" class="z-10"><button class="px-10 text-yellow-300 text-xl rounded-lg bg-black h-min markazi my-3 mx-2 hover:scale-110">En savoir plus</button></a>
    </div>

    <a href="index.php" class="flex flex-row items-center px-10 sm:px-20 mb-10 group">
        <img class="size-5 rotate-180 mr-1 group-hover:scale-110 group-hover:mr-2" src="assets/img/droit.png">
        <span class="markazi text-2xl group-hover:scale-110"><?= $destination->getLocation() ?></span>
    </a>
    <span class="markazi text-5xl bg-black text-yellow-300 py-3 px-20 mb-10"><?= count($tourOperators) ?> tour opérateurs pour <?= $destination->getLocation() ?></span>
    <div class="flex flex-col">
        <ul class="list-disc px-14 sm:px-24">
            <?php foreach ($tourOperators as $i) { ?>
                <li><a href="#<?= $i->getId() ?>" class="markazi text-xl text-blue-400 hover:text-blue-600"><?= $i->getName() ?></a></li>
            <?php } ?>
        </ul>
        <div class="flex flex-row flex-wrap">
            <?php foreach ($tourOperators as $i) { ?>
                <div id="<?= $i->getId() ?>" class="border border-black flex flex-col w-80 mt-5 pt-5 mb-10 pb-10 mx-5 md:mx-10 px-5 md:px-10">
                    <span class="markazi text-4xl"><?= $i->getName() ?> - <?= $destination->getPrice() ?>€</span>
                    <p class="markazi text-lg h-32"><?= $i->getDescription() ?></p>
                    <div class="mb-5">
                        <?php if ($i->getIsPremium()) { ?>
                            <a href="<?= $i->getLink() ?>" class="markazi text-blue-400 hover:text-blue-600 underline text-xl"><?= $i->getLink() ?></a>
                        <?php } else { ?>
                            <button class="border px-10 rounded-lg bg-black text-yellow-300 h-min w-min markazi hover:scale-110">Réserver</button>
                        <?php } ?>
                        <!-- <button class="border px-10 rounded-lg bg-black text-yellow-300 h-min w-min markazi mb-5 ml-2 hover:scale-110">J'aime</button> -->
                    </div>
                    <span class="markazi text-xl mb-3 h-5"><?php for ($stars = 0; $stars < $i->getScore(); $stars++) { ?>⭐<?php } ?></span>

                    <form action="http://tp-comparoperator.test/tour-operator.php?destination_id=1#<?= $i->getId() ?>" method="post" class="mb-3">
                        <span class="mb-3 markazi text-2xl">Noter le tour opérateur</span>
                        <input type="hidden" name="tourOperatorId" value="<?= $i->getId() ?>">
                        <input type="hidden" name="rate">
                        <div class="flex flex-row flex-wrap items-center">
                            <input type="text" name="name" placeholder="Nom" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36 hover:bg-gray-100">
                            <input type="number" min="0" max="5" name="score" placeholder="Note" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36 hover:bg-gray-100">
                            <button type="submit" class="px-10 rounded-lg bg-black text-white h-min markazi my-3 mx-2 hover:scale-110">Noter</button>
                        </div>
                    </form>

                    <div class="mb-5">
                        <?php if (isset($_SESSION["rateResponse{$i->getId()}"])) { ?>
                            <p class="markazi text-2xl text-red-500"><?= $_SESSION["rateResponse{$i->getId()}"] ?></p>
                            <?php unset($_SESSION["rateResponse{$i->getId()}"]); ?>
                        <?php } ?>
                    </div>

                    <form action="http://tp-comparoperator.test/tour-operator.php?destination_id=1#<?= $i->getId() ?>" method="post" class="mb-3">
                        <span class="mb-3 markazi text-2xl">Lesser un avis</span>
                        <input type="hidden" name="addReview">
                        <input type="hidden" name="tourOperatorId" value="<?= $i->getId() ?>">
                        <div class="flex flex-row flex-wrap items-center">
                            <input type="text" name="name" placeholder="Nom" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36 hover:bg-gray-100">
                            <input type="text" name="message" placeholder="Avis" class="border border-black my-3 mx-2 px-3 py-1 markazi w-36 hover:bg-gray-100">
                            <button type="submit" class="border px-10 rounded-lg bg-black text-white h-min markazi my-3 mx-2 hover:scale-110">Lesser</button>
                        </div>
                    </form>

                    
                    <div class="mb-5">
                        <?php if (isset($_SESSION["addReviewResponse{$i->getId()}"])) { ?>
                            <p class="markazi text-2xl text-red-500"><?= $_SESSION["addReviewResponse{$i->getId()}"] ?></p>
                            <?php unset($_SESSION["addReviewResponse{$i->getId()}"]); ?>
                        <?php } ?>
                    </div>

                    <?php $reviews = $manager->getReviewsWithTourOperatorId($i->getId()); ?>
                    <ul class="list-disc px-5">
                    <?php for ($review = 0; $review < 3; $review++) { ?>
                        <?php if (isset($reviews[$review])) { ?>
                        <li class="markazi text-xl"><?= $reviews[$review]->getMessage() ?></li> 
                        <?php } ?>
                    <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
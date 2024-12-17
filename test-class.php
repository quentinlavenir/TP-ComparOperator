<?php
require_once 'classes/manager.php';
require_once 'config/db.php';
require_once 'classes/tour_operateur.php';
require_once 'classes/destination.php';
require_once 'classes/review.php';

$manager = new Manager($db);

$destinations = $manager->getDestinations();
foreach ($destinations as $destination) {
    echo "{$destination}<br><br>";
}

$tourOperators = $manager->getTourOperators();
foreach ($tourOperators as $tourOperator) {
    echo "{$tourOperator}<br><br>";
}

$reviews = $manager->getReviews();
foreach ($reviews as $review) {
    echo "{$review}<br><br>";
}
<?php
require_once 'config/db.php';

$query = $db->query('SELECT * FROM destination');
$destinations = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $db->query('SELECT * FROM tour_operator');
$tourOperators = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['addTourOperator'])) {
    $name = $_POST['name'];
    $link = $_POST['link'];

    $query = $db->prepare('INSERT INTO tour_operator (name, link) VALUES (:name, :link)');
    $query->execute([
        'name' => $name,
        'link' => $link
    ]);

    $response = "Tour opérateur ajouté";
    $_SESSION['addTourOperatorResponse'] = $response;
}

if (isset($_POST['addDestinationToTourOperator'])) {
    if ($_POST['tourOperatorId'] === 'null' || $_POST['destinationId'] === 'null') {
        $response = "Veuillez choisir un tour opérateur et une destination";
    }
    else {
        $tourOperatorId = $_POST['tourOperatorId'];
        $destinationId = $_POST['destinationId'];

        $query = $db->query('SELECT * FROM destination_tour_operator');
        $destinationTO = $query->fetchAll(PDO::FETCH_ASSOC);

        $similaryDestinationTO = false;
        foreach ($destinationTO as $i) {
            if ($i['destination_id'] == $destinationId && $i['tour_operator_id'] == $tourOperatorId) {
                $response = "Cette destination est deja ajoutée";
                $similaryDestinationTO = true;
                break;
            }
        }

        if (!$similaryDestinationTO) {
            $query = $db->prepare('INSERT INTO destination_tour_operator (destination_id, tour_operator_id)
                VALUES (:destination_id, :tour_operator_id)');
            $query->execute([
                'destination_id' => $destinationId,
                'tour_operator_id' => $tourOperatorId
            ]);

            $response = "Destination ajoutée";
        }
    }
    $_SESSION['addDestinationToTourOperatorResponse'] = $response;
}

if (isset($_POST['passTourOperatorPremium'])) {
    $tourOperatorId = $_POST['tourOperatorId'];

    if ($tourOperatorId === 'null') {
        $response = "Veuillez choisir un tour opérateur";
    }
    else {
        $query = $db->query('SELECT * FROM certificate');
        $certificates = $query->fetchAll(PDO::FETCH_ASSOC);

        $similaryCertificate = false;
        foreach ($certificates as $i) {
            if ($i['tour_operator_id'] == $tourOperatorId) {
                $response = "Ce tour opérateur est deja passé en premium";
                $similaryCertificate = true;
                break;
            }
        }

        if (!$similaryCertificate) {
            $date = new DateTime();
            $date->modify('+1 year');

            $query = $db->prepare('INSERT INTO certificate (tour_operator_id, expires_at, signatory)
                VALUES (:tour_operator_id, :expires_at, :signatory)');
            $query->execute([
                'tour_operator_id' => $tourOperatorId,
                'expires_at' => $date->format('Y-m-d H:i:s'),
                'signatory' => 'admin'
            ]);

            $response = "Tour opérateur passé en premium";
        }
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
<body>
    <header class="bg-green-400 w-full h-12 flex flex-row items-center border-b border-black justify-center mb-10">
        <img class="h-full" src="assets/img/logo.png" alt="logo">
        <h1 class="ml-6 cherry text-white text-xl">Comparoperator</h1>
    </header>

    <form method="post" class="flex flex-col mb-10">
        <input type="hidden" name="addTourOperator">
        <span class="mb-5">Ajouter un tour opérateur</span>
        <div class="flex flex-row flex-wrap items-center">
            <input type="text" name="name" placeholder="Nom" class="border border-black m-3 px-5 py-1">
            <input type="url" name="link" placeholder="Lien" class="border border-black m-3 px-5 py-1">
            <button type="submit" class="border px-10 rounded-lg bg-black text-white h-min">Ajouter</button>
        </div>
    </form>

    <div>
        <?php if (isset($_SESSION['addTourOperatorResponse'])) { ?>
            <p><?= $_SESSION['addTourOperatorResponse'] ?></p>
            <?php unset($_SESSION['addTourOperatorResponse']); ?>
        <?php } ?> 
    </div>

    <form method="post" class="flex flex-col mb-10">
        <input type="hidden" name="addDestinationToTourOperator">
        <span class="mb-5">Ajouter une destination à un tour opérateur</span>
        <div class="flex flex-row">
            <select name="tourOperatorId">
                <option value="null">Tour opérateur</option>
                <?php foreach ($tourOperators as $tourOperator){ ?>
                    <option value="<?= $tourOperator['id'] ?>"><?= $tourOperator['name'] ?></option>
                <?php } ?>
            </select>
            <select name="destinationId">
                <option value="null">Destination</option>
                <?php foreach ($destinations as $destination){ ?>
                    <option value="<?= $destination['id'] ?>"><?= $destination['location'] ?></option>
                <?php } ?>
            </select>
            <button type="submit">Ajouter</button>
        </div>
    </form>

    <div>
        <?php if (isset($_SESSION['addDestinationToTourOperatorResponse'])) { ?>
            <p><?= $_SESSION['addDestinationToTourOperatorResponse'] ?></p>
            <?php unset($_SESSION['addDestinationToTourOperatorResponse']); ?>
        <?php } ?>
    </div>

    <form method="post" class="flex flex-col">
        <input type="hidden" name="passTourOperatorPremium">
        <span class="mb-5">Passer un tour opérateur en premium</span>
        <div class="flex flex-row">
            <select name="tourOperatorId">
                <option value="null">Tour opérateur</option>
                <?php foreach ($tourOperators as $tourOperator){ ?>
                    <option value="<?= $tourOperator['id'] ?>"><?= $tourOperator['name'] ?></option>
                <?php } ?>
            </select>
            <button type="submit">Ajouter</button>
        </div>
    </form>

    <div>
        <?php if (isset($_SESSION['passTourOperatorPremiumResponse'])) { ?>
            <p><?= $_SESSION['passTourOperatorPremiumResponse'] ?></p>
            <?php unset($_SESSION['passTourOperatorPremiumResponse']); ?>
        <?php } ?>
    </div>
</body>
</html>
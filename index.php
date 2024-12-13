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
    <title>Document</title>
</head>
<body>
    <?php foreach ($destinations as $destination){} ?>
        
</body>
</html>
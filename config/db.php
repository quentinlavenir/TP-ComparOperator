<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=tp_comparoperator;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur lors de la connection à la base de données : ' . $e->getMessage());
}
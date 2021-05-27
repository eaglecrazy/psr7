<?php

ЗАКОНЧИЛ 2-49

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

$pdo = $container->get(PDO::class);


$id = 2;

$stmt = $pdo->prepare('select * from posts where id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
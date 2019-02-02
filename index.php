<?php
require_once __DIR__ . '/AverageHashInterface.php';
require_once __DIR__ . '/AverageHash.php';

header('Content-Type: image/jpeg');

$hash = new \app\AverageHash('test.png');
$hash->resizeImage();
<?php
require_once __DIR__ . '/AverageHashInterface.php';
require_once __DIR__ . '/HashHelperInterface.php';
require_once __DIR__ . '/AverageHash.php';

$hash = new \app\AverageHash('test.png', 128, 128);
$hash->makeHash();

$hash1 = new \app\AverageHash('test.png', 128, 128);
$hash1->makeHash();

echo \app\AverageHash::getHashesDifference($hash, $hash1);
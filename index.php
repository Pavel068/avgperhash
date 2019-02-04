<?php
require_once __DIR__ . '/AverageHashInterface.php';
require_once __DIR__ . '/HashHelperInterface.php';
require_once __DIR__ . '/AverageHash.php';

$hash = new \app\AverageHash('test.png');
$hash->setConfig(8, 8);
$hash->resizeImage();
$hash->imageToGray();
$hash->getAverageColor();
$hash->getBitChain();
$hash->makeHash();

echo $hash->hash;
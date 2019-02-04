<?php

namespace app;


class AverageHash implements AverageHashInterface, HashHelperInterface
{
    private $config;
    private $inputImage;
    public $inputImageResource;
    public $outputImageResource;
    public $hash;
    private $colorMap = [];
    private $avgColor;
    private $bitChain = [];

    public function __construct($inputImage, $w, $h)
    {
        $this->config = (object)[
            'width' => $w,
            'height' => $h,
        ];
        $this->outputImageResource = imagecreatetruecolor($this->config->width, $this->config->height);
        if (file_exists($inputImage)) {
            $this->inputImage = $inputImage;

            // get extension
            $ext = explode('.', $inputImage);
            $ext = $ext[count($ext) - 1];
            // fix jpeg
            if ($ext == 'jpg')
                $ext = 'jpeg';

            // get function name
            $funcName = 'imagecreatefrom' . $ext;

            if (function_exists($funcName)) {
                $this->inputImageResource = @$funcName($inputImage);
                if (!$this->inputImageResource) {
                    throw new \Error("Cannot create image resource");
                }
            } else {
                throw new \Error("Cannot find function" . $funcName);
            }

        } else {
            throw new \Error("Cannot find image");
        }
    }

    public function resizeImage()
    {
        // get input image size
        list($width, $height) = getimagesize($this->inputImage);

        if (!imagecopyresized($this->outputImageResource, $this->inputImageResource, 0, 0, 0, 0, $this->config->width, $this->config->height, $width, $height)) {
            throw new \Error('Cannot resize image');
        }
    }

    public function imageToGray()
    {
        if (!imagecopymergegray($this->outputImageResource, $this->outputImageResource, 0, 0, 0, 0, $this->config->width, $this->config->height, 0)) {
            throw new \Error('Cannot merge to gray');
        }
    }

    public function getAverageColor()
    {
        for ($i = 0; $i < $this->config->width; $i++) {
            for ($j = 0; $j < $this->config->height; $j++) {
                array_push($this->colorMap, imagecolorat($this->outputImageResource, $i, $j));
            }
        }

        // get average value
        $sum = array_reduce($this->colorMap, function ($currentSum, $currentItem) {
            $currentSum += $currentItem;
            return $currentSum;
        }, 0);
        $avg = $sum / count($this->colorMap);
        $this->avgColor = $avg;
    }

    public function getBitChain()
    {
        $this->bitChain = array_map(function ($item) {
            return $item > $this->avgColor ? 1 : 0;
        }, $this->colorMap);
    }

    public function makeHash()
    {
        // make hash
        $this->resizeImage();
        $this->imageToGray();
        $this->getAverageColor();
        $this->getBitChain();
        //
        $this->hash = implode('', $this->bitChain);
    }

    public static function getHashesDifference(AverageHash $hash1, AverageHash $hash2)
    {
        $hammingDistance = 0;

        if (strlen($hash1->hash) === strlen($hash2->hash)) {
            for ($i = 0; $i < strlen($hash1->hash); $i++) {
                if ($hash1->hash[$i] !== $hash2->hash[$i])
                    $hammingDistance++;
            }
        } else {
            throw new \Error('Hashes has not equal length');
        }

        return $hammingDistance;
    }
}
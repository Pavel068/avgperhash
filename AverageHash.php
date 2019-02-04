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

    public function __construct($inputImage)
    {
        $this->config = (object)[
            'width' => 8,
            'height' => 8,
        ];
        $this->outputImageResource = imagecreatetruecolor($this->config->width, $this->config->height);
        if (file_exists($inputImage)) {
            $this->inputImage = $inputImage;

            // get extension
            $ext = explode('.', $inputImage);
            $ext = $ext[count($ext) - 1];

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

    public function setConfig($w, $h)
    {
        $this->config->width = $w;
        $this->config->height = $h;
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
        $this->hash = implode('', $this->bitChain);
    }

    public function getHashesDifference()
    {
        // TODO: Implement getHashDifference() method.
    }
}
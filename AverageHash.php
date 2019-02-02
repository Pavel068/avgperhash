<?php

namespace app;


class AverageHash implements AverageHashInterface
{
    private $inputImage;
    public $inputImageResource;
    public $outputImageResource;
    public $hash;

    public function __construct($inputImage)
    {
        $this->outputImageResource = imagecreatetruecolor(32, 32);
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

    public function resizeImage()
    {
        // get input image size
        list($width, $height) = getimagesize($this->inputImage);

        if (imagecopyresized($this->outputImageResource, $this->inputImageResource, 0, 0, 0, 0, 32, 32, $width, $height)) {
            imagejpeg($this->outputImageResource);
        } else {
            throw new \Error('Cannot resize image');
        }
    }

    public function imageToGray()
    {
        // TODO: Implement imageToGray() method.
    }

    public function getAverageColor()
    {
        // TODO: Implement getAverageColor() method.
    }

    public function getBitChain()
    {
        // TODO: Implement getBitChain() method.
    }

    public function makeHash()
    {
        // TODO: Implement makeHash() method.
    }
}
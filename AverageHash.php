<?php

namespace app;


class AverageHash implements AverageHashInterface
{
    public $inputImage;
    public $hash;

    public function __construct($inputImage)
    {
        if (file_exists($inputImage)) {
            // get extension
            $ext = explode('.', $inputImage);
            $ext = $ext[count($ext) - 1];
            // get function name
            $funcName = 'imagecreatefrom' . $ext;
            if (function_exists($funcName)) {
                $this->inputImage = $funcName($inputImage);
            } else {
                throw new \Error("Cannot find function" . $funcName);
            }
        } else {
            throw new \Error("Cannot find image");
        }
    }

    public function resizeImage()
    {
        // TODO: Implement resizeImage() method.
//        if (imagecopyresized())
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